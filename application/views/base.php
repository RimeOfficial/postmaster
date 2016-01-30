<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!-- 
Fork: https://github.com/RimeOfficial/postmaster
Wiki: https://github.com/RimeOfficial/postmaster/wiki

Page rendered in {elapsed_time} seconds
CodeIgniter Version <?php echo CI_VERSION; ?> 
 -->
<html lang="en">
  <head>
    <title><?php echo app_name(); ?> - AWS email server</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="<?php echo app_name(); ?> - AWS email server">
    <meta name="description" content="🍳 Fork: https://github.com/RimeOfficial/postmaster 🍺 Wiki: https://github.com/RimeOfficial/postmaster/wiki">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
    <style type="text/css">
      body { padding-top: 20px; padding-bottom: 20px; }
      .container { max-width: 680px; }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
   
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <header>
            <?php
            $this->load->config('nav', TRUE);
            $navbar = $this->config->item('navbar', 'nav');
            ?>
            <nav class="navbar navbar-default">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand">Postmaster</a>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                  
                  <?php
                  if ($is_logged_in)
                  {
                    $nav_selected = explode('/', uri_string());
                    $nav_selected = $nav_selected[0];
                    
                    foreach ($navbar as $uri => $name): ?>
                      <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
                        <a href="<?php echo base_url($uri); ?>"><?php echo $name; ?></a>
                      </li>
                    <?php endforeach;
                  }
                  ?>
                  <!-- <li>
                    <a href="https://github.com/Rimeofficial/postmaster" title="Fork me on GitHub" target="_blank">
                      <span class="glyphicon glyphicon-cutlery"></span>
                    </a>
                  </li> -->
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                  <?php
                  if ($is_logged_in)
                  {
                    ?>
                    <li><a href="<?php echo base_url('auth/sign-out') ?>">Sign out</a></li>
                    <?php
                  }
                  else
                  {
                    ?>
                    <li><a href="<?php echo base_url('auth/sign-in') ?>">Sign in</a></li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
            </nav>
          </header>

          <?php $this->view('nav_tab'); ?>
          <?php $this->view('alert'); ?>

          <?php echo $main_content; ?>

          <hr>
          <footer>

            <p class="small">
              <a class="text-muted" href="http://wiki.rime.co/postmaster">
                <span class="glyphicon glyphicon-info-sign"></span>
              </a>
              <a class="text-muted" href="https://github.com/RimeOfficial/postmaster">
                <strong class="pull-right"><?php echo app_name(); ?> v1.0</strong>
              </a>
            </p>

          </footer>
        </div>
      </div>
    </div>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>
