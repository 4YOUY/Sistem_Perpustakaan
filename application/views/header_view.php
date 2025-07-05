<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Library LP3I Bekasi</title>
<link rel="shortcut icon" href="<?= base_url('assets_style/image/favicon.ico'); ?>" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->


  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/bower_components/font-awesome/css/font-awesome.min.css">
	
	
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/bower_components/select2/dist/css/select2.min.css">
	
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->  
	
	<link href="<?php echo base_url();?>assets_style/assets/plugins/summernote/summernote-lite.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/dist/css/AdminLTE.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/dist/css/responsive.css">
	
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets_style/assets/plugins/pace/pace.min.css">
  <!-- jQuery 3 -->
  <script src="<?php echo base_url();?>assets_style/assets/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<!-- offline -->
	<style>
	.order-card {
    color: #fff;
}

  .main-sidebar {
    background-color: #fff !important;
    min-height: 100vh !important;
  }

  .sidebar {
    background-color: #fff !important;
  }

  .content-wrapper {
    background-color: #f4f6f9;
  }

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}


.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-block {
    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}

/* Enhanced Dropdown Styling dengan warna #0D47A1 */
.navbar-nav > .user-menu > .dropdown-toggle {
    color: #fff !important;
    background: linear-gradient(135deg, #0D47A1, #1565C0) !important;
    border-radius: 25px !important;
    padding: 8px 15px !important;
    transition: all 0.3s ease !important;
    border: 2px solid rgba(255,255,255,0.2) !important;
    box-shadow: 0 2px 8px rgba(13, 71, 161, 0.3) !important;
}

.navbar-nav > .user-menu > .dropdown-toggle:hover {
    background: linear-gradient(135deg, #1565C0, #0D47A1) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(13, 71, 161, 0.4) !important;
    border-color: rgba(255,255,255,0.4) !important;
}

.navbar-nav > .user-menu > .dropdown-toggle:focus,
.navbar-nav > .user-menu > .dropdown-toggle:active {
    background: linear-gradient(135deg, #0D47A1, #1565C0) !important;
    box-shadow: 0 2px 8px rgba(13, 71, 161, 0.5) !important;
}

.navbar-nav > .user-menu > .dropdown-toggle .user-image {
    border: 2px solid rgba(255,255,255,0.8) !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important;
    transition: all 0.3s ease !important;
}

.navbar-nav > .user-menu > .dropdown-toggle:hover .user-image {
    border-color: #fff !important;
    transform: scale(1.05) !important;
}

.navbar-nav > .user-menu .dropdown-menu {
    background: linear-gradient(145deg, #ffffff, #f8f9ff) !important;
    border: none !important;
    border-radius: 15px !important;
    box-shadow: 0 8px 25px rgba(13, 71, 161, 0.15) !important;
    margin-top: 5px !important;
    min-width: 280px !important;
    overflow: hidden !important;
}

.navbar-nav > .user-menu .dropdown-menu::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 20px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid #ffffff;
    filter: drop-shadow(0 -2px 4px rgba(13, 71, 161, 0.1));
}

.user-header {
    background: linear-gradient(135deg, #0D47A1, #1565C0) !important;
    color: #fff !important;
    padding: 25px 20px !important;
    position: relative !important;
    overflow: hidden !important;
}

.user-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.user-header .img-circle {
    border: 4px solid rgba(255,255,255,0.9) !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    transition: all 0.3s ease !important;
}

.user-header p {
    margin: 15px 0 5px 0 !important;
    font-weight: 600 !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
}

.user-header small {
    opacity: 0.9 !important;
    background: rgba(255,255,255,0.2) !important;
    padding: 3px 8px !important;
    border-radius: 12px !important;
    font-size: 11px !important;
    font-weight: 500 !important;
}

.user-footer {
    background: #f8f9ff !important;
    padding: 20px !important;
    border-top: 1px solid rgba(13, 71, 161, 0.1) !important;
}

.user-footer .btn {
    border-radius: 25px !important;
    font-weight: 500 !important;
    padding: 10px 20px !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    overflow: hidden !important;
}

.user-footer .btn-primary {
    background: linear-gradient(135deg, #0D47A1, #1565C0) !important;
    border: none !important;
    box-shadow: 0 3px 10px rgba(13, 71, 161, 0.3) !important;
}

.user-footer .btn-primary:hover {
    background: linear-gradient(135deg, #1565C0, #1976D2) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 5px 15px rgba(13, 71, 161, 0.4) !important;
}

.user-footer .btn-danger {
    background: linear-gradient(135deg, #f44336, #e53935) !important;
    border: none !important;
    box-shadow: 0 3px 10px rgba(244, 67, 54, 0.3) !important;
}

.user-footer .btn-danger:hover {
    background: linear-gradient(135deg, #e53935, #d32f2f) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 5px 15px rgba(244, 67, 54, 0.4) !important;
}

.user-footer .btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: all 0.5s ease;
}

.user-footer .btn:hover::before {
    width: 300px;
    height: 300px;
}

.user-footer .btn i {
    margin-right: 8px !important;
    transition: all 0.3s ease !important;
}

.user-footer .btn:hover i {
    transform: scale(1.2) !important;
}

/* Animasi smooth untuk dropdown */
.navbar-nav > .user-menu .dropdown-menu {
    opacity: 0;
    transform: translateY(-10px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.navbar-nav > .user-menu.open .dropdown-menu {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .navbar-nav > .user-menu .dropdown-menu {
        min-width: 250px !important;
        margin-right: 10px !important;
    }
    
    .user-footer .btn-group-justified {
        display: flex !important;
        gap: 10px !important;
    }
    
    .user-footer .btn {
        flex: 1 !important;
        padding: 8px 15px !important;
    }
}
	</style>
  <script type="text/javascript">
      $(document).ajaxStart(function() { Pace.restart(); });
  </script>
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">
  <header class="main-header" style="background-color:#0D47A1">

    <!-- Logo -->
    <a href="<?php echo base_url('index.php/dashboard');?>" class="logo" style="background-color:#0D47A1;">
  <span class="logo-lg" style="display: flex; align-items: center; gap: 10px;">
    <img src="<?= base_url('assets_style/image/logo-lp3i.png'); ?>" alt="Logo LP3I" style="height: 40px;">
    Library LP3I
  </span>
</a>
    <nav class="navbar navbar-static-top" style="background-color:#0D47A1">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <?php
              $d = $this->db->query("SELECT * FROM tbl_login WHERE id_login = '$idbo'")->row();
             ?>
			 <!--
            <a href="<?= base_url('user/edit/'.$idbo);?>">
              Welcome , <i class="fa fa-edit"> </i> <?php echo $d->nama; echo ' | ( '.$d->level.' )'; ?></a>
			-->
		  </li>
      <?php
  $d = $this->db->query("SELECT * FROM tbl_login WHERE id_login = '$idbo'")->row();
?>
<li class="dropdown user user-menu" >
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display: flex; align-items: center;">
    <img src="<?php echo base_url('assets_style/image/'.$d->foto); ?>" class="user-image" alt="User Image" style="border-radius:50%; height:30px; width:30px; margin-right:5px;">
    <span class="hidden-xs"><?php echo $d->nama; ?></span>
  </a>
  <ul class="dropdown-menu">
    <li class="user-header" style="text-align:center;">
      <img src="<?php echo base_url('assets_style/image/'.$d->foto); ?>" class="img-circle" alt="User Image" style="width:65px; height:75px;">
      <p><?php echo $d->nama; ?><br><small><?php echo $d->level; ?></small></p>
    </li>
    <div class="user-footer">
  <?php if ($this->session->userdata('level') != 'Pimpinan') : ?>
    <div class="btn-group btn-group-justified" style="width: 100%;">
      <a href="<?= base_url('user/edit/' . $idbo); ?>" class="btn btn-primary" style="background-color:#3F48CC; border:none;">
        <i class="fa fa-user"></i> Profile
      </a>
      <a href="<?= base_url('login/logout'); ?>" class="btn btn-danger" style="border:none;">
        <i class="fa fa-sign-out"></i> Logout
      </a>
    </div>
  <?php else: ?>
    <div style="text-align: center; width: 100%;">
      <a href="<?= base_url('login/logout'); ?>" class="btn btn-danger" style="border:none; width: 80%;">
        <i class="fa fa-sign-out"></i> Logout
      </a>
    </div>
  <?php endif; ?>
</div>
    </li>
  </ul>
</li>
          <!-- Control Sidebar Toggle Button 
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>
  <!--loading-->
  <!-- Left side column. contains the logo and sidebar -->