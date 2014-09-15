<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>HomeWork <?php clean_output($title) ?></title>
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
            $( "#tab" ).tabs();
            });
    </script>
  </head>

  <body>
      <div class="navbar navbar-fixed-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container" >
                <?php if(!isset($_SESSION['user_session'])): ?>
                        <div class="pull-left">
                            <a  href="<?php clean_output(url('/')); ?>"><img src="/img/logo.png"/></a>
                        </div>
                        <div class="pull-right">
                            <a class="brand" href="<?php clean_output(url('/')); ?>"><i class="icon icon-home icon-white"></i> Home</a>
                            <a class="brand" href="<?php clean_output(url('user/register')); ?>"><i class="icon icon-icon-list icon-white"></i> Register</a>
                        </div>
                <?php else: ?>
                    <form method="get" action="/topic/search" class="navbar-form">
                        <div class="pull-left">
                            <td class="span3"><a href="<?php clean_output(url('topic/topics')); ?>"><img src="/img/logo.png"/></a>
                        </div>
                        <div class="pull-right">
                            <div class="pull-left" style="margin-top:5px; margin-right:8px;">
                                <input type="text" name="searchbar" placeholder="Search Thread" style="height:12px;">
                                <input type="submit" class="btn btn-mini" value="Search">
                            </div>
                            <div class="pull-right">
                                <?php if($_SESSION['user_session']['role'] == 1):?>
                                    <a class="brand" href="<?php clean_output(url('user/users')); ?>">
                                        <i class="icon icon-user icon-white"></i>Users</a>  
                                <?php endif ?>
                                <a class="brand" href="<?php clean_output(url('user/updateprofile')); ?>">
                                    <i class="icon icon-list icon-white"></i>Profile</a>
                                <a class="brand" href="<?php clean_output(url('topic/topics')); ?>">
                                    <i class="icon icon-list-alt icon-white"></i>Topics</a>
                                <a class="brand" href="<?php clean_output(url('user/logout')); ?>">
                                    <i class="icon icon-off icon-white"></i>Logout</a>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="container">

      <?php echo $_content_;  ?>

    </div>

    <script>
    console.log(<?php clean_output(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>
    <br /><br /><br /><br />
    <div class="navbar navbar-fixed-bottom footer">Geno Kim Romualdo TC June 2014 &#0169;
    </div>
    
    </div>


  </body>
</html>
