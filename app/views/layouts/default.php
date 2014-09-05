<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DayetKEK <?php clean_output($title) ?></title>
    <link href="/bootstrap/css/own.css" rel="stylesheet">   
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="/bootstrap/css/jquery-ui.css">
    <script src="/bootstrap/js/jquery-1.10.2.js"></script>
    <script src="/bootstrap/js/jquery-ui.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <style>
      body {
        padding-top: 60px;
      }
    </style>
    <script>
        $(function() {
            $( "#accordion" ).accordion({
                collapsible: true,
                heightStyle: "content"
                });
            });
    </script>
  </head>

  <body>
      <div class="navbar navbar-fixed-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container" >
            <span class="pull-right">
                <?php if(!isset($_SESSION['user_session'])): ?>
                    <a class="brand" href="<?php clean_output(url('/')); ?>"><i class="icon icon-home icon-white"></i> Home</a>
                    <a class="brand" href="<?php clean_output(url('user/register')); ?>"><i class="icon icon-user icon-white"></i> Register</a>
                <?php else: ?>
                    <a class="brand" href="<?php clean_output(url('thread/threads')); ?>"><i class="icon icon-list-alt icon-white"></i> Threads</a>
                    <a class="brand" href="<?php clean_output(url('user/logout')); ?>"><i class="icon icon-off icon-white"></i> Logout</a>
                <?php endif; ?>
            </span>
        </div>
      </div>
    </div>

    <div class="container">

      <?php echo $_content_;  ?>

    </div>

    <script>
    console.log(<?php clean_output(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>
    <br /><br />
    <div class="navbar navbar-fixed-bottom footer">Geno Kim Romualdo TC June 2014 &#0169;
    </div>
    
    </div>


  </body>
</html>
