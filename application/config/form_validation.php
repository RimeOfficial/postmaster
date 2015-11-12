<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Form Validation Settings
| -------------------------------------------------------------------------
|
*/

$config = array(
  // 'controller/method'            => ['value1', 'value2'],

  'transaction/category/create'   => ['category'],
  'transaction/category/modify'   => ['category'],

  'transaction/home/create'       => ['subject', 'category_id'],
  'transaction/home/modify'       => ['subject', 'reply_to_name', 'reply_to_email', 'message_html', 'category_id'],
);

if ( ! function_exists('fill_element'))
{
  function fill_element($config)
  {
    $CI =& get_instance();
    $CI->config->load('form_element', TRUE);

    foreach ($config as $path => $elem_arr) foreach ($elem_arr as $key => $id)
    {
      $element = $CI->config->item($id, 'form_element');
      $element = array(
        'field' => $id,
        'label' => $element['label'],
        'rules' => $element['rules'],
      );

      $config[ $path ][ $key ] = $element;
    }

    return $config;
  }
}

$config = fill_element($config);
// var_dump($config); // die();