<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Promise;
use Aws\Exception\AwsException;

class Lib_archive
{
    private $error = array();
    
    function __construct($options = array())
    {
        $this->CI =& get_instance();
        $this->CI->load->model('model_archive');
    }
    
    /**
     * Get error message.
     * Can be invoked after any failed operation.
     *
     * @return  string
     */
    function get_error_message()
    {
        return $this->error;
    }

    function get($request_id, $web_version_key)
    {
        return $this->CI->model_archive->get($request_id, $web_version_key);
    }

    function get_list($type = NULL, $count = 99)
    {
        return $this->CI->model_archive->get_list($type, $count);
    }

    function get_unsent($count)
    {
        return $this->CI->model_archive->get_unsent($count);
    }

    function send($requests)
    {
        // 1. send emails async
        $this->CI->load->library('composer/lib_aws');
        $ses_client = $this->CI->lib_aws->get_ses();
        $promises = [];

        foreach ($requests as $request)
        {
            echo '('.$request['request_id'].') Sending message: '.$request['subject'].', to: '.$request['to_email'].PHP_EOL;

            // @debug: send to *@users.noreply.rime.co
            // $request['to_email'] = 'user-'.md5($request['to_email']).'@users.noreply.rime.co';
            
            $raw_message = ses_raw_email($request);
            // var_dump($raw_message); die();

            $email = ['RawMessage' => array('Data' => $raw_message)];

            $promises[ $request['request_id'] ] = $ses_client->sendRawEmailAsync($email);
        }

        // Wait on promises to complete and return the results.
        try {
            $results = Promise\unwrap($promises);
        } catch (AwsException $e) {
            // handle the error.
            $error_msg = 'getAwsRequestId: '.$e->getAwsRequestId().', getAwsErrorType:'.$e->getAwsErrorType().', getAwsErrorCode:'.$e->getAwsErrorCode()."\n\n";
            $error_msg .= $e->getMessage()."\n";
            $error_msg .= $e->getTraceAsString();
        }

        if (!empty($results))
        {
            // 2. save messege_id
            $message_sent_list = [];
            foreach ($results as $request_id => $result)
            {
                echo '('.$request_id.') statusCode: '.$result['@metadata']['statusCode'].', MessageId: '.$result['MessageId'].PHP_EOL;
                
                if (!empty($result['@metadata']['statusCode']) AND $result['@metadata']['statusCode'] == 200
                    AND !empty($result['MessageId'])
                )
                {
                    $ses_message_id = $result['MessageId'];
                    $message_sent_list[] = [
                        'request_id' => $request_id,
                        'sent' => date('Y-m-d H:i:s'),
                        'ses_message_id' => $ses_message_id,

                        'archived' => date('Y-m-d H:i:s'),
                        'body_html' => NULL,
                        'body_text' => NULL,
                    ];
                }
            }

            // mark sent
            if(!empty($message_sent_list)) $this->CI->model_archive->update_batch($message_sent_list);
        }

        if (!empty($error_msg))
        {
            $this->error = ['message' => $error_msg];
            return NULL;
        }
        else return TRUE;
    }

    function get_info($request_id, $unsubscribe_key)
    {
        $recipient_info = $this->CI->model_archive->get_info($request_id, $unsubscribe_key);

        if (!empty($recipient_info)) return $recipient_info;
        else
        {
            $this->error = ['status' => 401, 'message' => 'invalid details ;('];
            return NULL;
        }
    }

    function get_unarchive($count)
    {
        return $this->CI->model_archive->get_unarchive($count);
    }
}