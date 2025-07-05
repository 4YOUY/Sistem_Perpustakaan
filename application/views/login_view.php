<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Library LP3I</title>
  <link rel="shortcut icon" href="<?= base_url('assets_style/image/favicon.ico'); ?>" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="shortcut icon" href="" />
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/bower_components/font-awesome/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/bower_components/Ionicons/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/dist/css/AdminLTE.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/dist/css/responsivelogin.css');?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
        .navbar-inverse{
        background-color:#333;
         }
         .navbar-color{
        color:#fff;
         }
          blink, .blink {
                animation: blinker 3s linear infinite;
            }

           @keyframes blinker {
                50% { opacity: 0; }
           }
           
           /* Custom Styles */
           .login-box-body {
               border-radius: 8px;
               box-shadow: 0 4px 8px rgba(0,0,0,0.2);
               background: rgba(255,255,255,0.95);
           }
           
           .login-logo a {
               text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
           }
           
           .form-control {
               border-radius: 5px;
           }
           
           .btn-login {
               border-radius: 5px;
               transition: all 0.3s ease;
           }
           
           .btn-login:hover {
               transform: translateY(-2px);
               box-shadow: 0 4px 8px rgba(0,0,0,0.2);
           }
           
           .alert-custom {
               margin-bottom: 15px;
               border-radius: 5px;
               animation: slideDown 0.5s ease;
           }
           
           @keyframes slideDown {
               from { opacity: 0; transform: translateY(-20px); }
               to { opacity: 1; transform: translateY(0); }
           }
           
           /* Password Toggle Styles */
           .password-toggle {
               position: absolute;
               right: 30px;
               top: 50%;
               transform: translateY(-50%);
               cursor: pointer;
               z-index: 5;
               color: #666;
               font-size: 16px;
           }
           
           .password-toggle:hover {
               color: #333;
           }
           
           .form-group.has-feedback {
               position: relative;
           }
    </style>
  </head>
<body class="hold-transition login-page" style="overflow-y: hidden;background:url(
	'<?php echo base_url('assets_style/image/bg-blue2.jpg');?>')no-repeat;background-size:100%;">
<div class="login-box">
	<br/>
  <div class="login-logo">
    <a href="index.php" style="color: White;"><b>Perpustakaan LP3I</b></a>
  </div>
  
  <!-- Alert untuk menampilkan pesan error -->
  <?php if(isset($error_message)): ?>
  <div class="alert alert-danger alert-dismissible alert-custom">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="fa fa-exclamation-triangle"></i> <?= $error_message; ?>
  </div>
  <?php endif; ?>
  
  <!-- /.login-logo -->
  <div class="login-box-body" style="border:2px solid #226bbf;">
    <p class="login-box-msg" style="font-size:16px;">Silakan login untuk melanjutkan</p>
    <form action="<?= base_url('login/auth_improved');?>" method="POST">
      <div class="form-group has-feedback <?= (isset($error_type) && $error_type == 'username') ? 'has-error' : ''; ?>">
        <input type="text" class="form-control" placeholder="Username" id="user" name="user" 
               required="required" autocomplete="off" value="<?= isset($username) ? $username : ''; ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback <?= (isset($error_type) && $error_type == 'password') ? 'has-error' : ''; ?>">
        <input type="password" class="form-control" placeholder="Password" id="pass" name="pass" required="required" autocomplete="off">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="password-toggle" onclick="togglePassword()">
          <i class="fa fa-eye" id="toggleIcon"></i>
        </span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat btn-login">Login</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
  <br/>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets_style/assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets_style/assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets_style/assets/plugins/iCheck/icheck.min.js');?>"></script>

<script>
// Auto hide alert after 5 seconds
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
});

// Toggle password visibility
function togglePassword() {
    var passwordField = document.getElementById('pass');
    var toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.className = 'fa fa-eye-slash';
    } else {
        passwordField.type = 'password';
        toggleIcon.className = 'fa fa-eye';
    }
}
</script>

</body>
</html>