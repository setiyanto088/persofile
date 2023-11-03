<!DOCTYPE html>
<meta charset="utf-8" />
<html lang="en">
<head>
  <title>INRATE</title>
 <link rel="icon" href="https://inrate.id/wp-content/themes/jupiter/assets/images/favicon.png?ver=2.1.0" type="image/x-icon">
	<!-- Meta Data -->
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato"> 
  
  <!-- Material Icons -->
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/bootstrap.css">                                               
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   
  <!-- Bootstrap Material Datetime Picker Css -->
  <link rel="stylesheet" href="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css"> 
  <link href="<?php echo $path5;?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

  <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/widget.css?v=1.0.1"> 
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/video-thumbnail.css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/panel.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/data-set.css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/table.css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack-extra.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/grid.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path6;?>dist/css/bootstrap-select.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tag.css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tree-list.css">      

  <!-- JQuery DataTable Css -->
  <link href="<?php echo $path5;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

  <!-- Sweet Alert -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/sweetalert/sweetalert2.css">
  
  <!-- JsTree -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/vendors/jstree/themes/default/style.min.css">    
  
  <style>
    body {
         font-family: Lato, sans-serif;
    }
	
	.dropdown-menu {
		color: red;
		-webkit-border-radius: 0;
		-moz-border-radius: 0;
		-ms-border-radius: 0;
		border-radius: 0;
		margin-top: 0px !important;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
		border: none; 
  
	}
  .dropdown-menu .divider {
    margin: 5px 0; }
  .dropdown-menu .header {
    font-size: 13px;
    font-weight: bold;
    min-width: 270px;
    border-bottom: 1px solid #eee;
    text-align: center;
    padding: 4px 0 6px 0; }
  .dropdown-menu ul.menu {
    padding-left: 0; }
    .dropdown-menu ul.menu.tasks h4 {
      color: #333;
      font-size: 13px;
      margin: 0 0 8px 0; }
      .dropdown-menu ul.menu.tasks h4 small {
        float: right;
        margin-top: 6px; }
    .dropdown-menu ul.menu.tasks .progress {
      height: 7px;
      margin-bottom: 7px; }
    .dropdown-menu ul.menu .icon-circle {
      width: 36px;
      height: 36px;
      -webkit-border-radius: 50%;
      -moz-border-radius: 50%;
      -ms-border-radius: 50%;
      border-radius: 50%;
      color: #fff;
      text-align: center;
      display: inline-block; }
      .dropdown-menu ul.menu .icon-circle i {
        font-size: 18px;
        line-height: 36px; }
    .dropdown-menu ul.menu li {
      border-bottom: 1px solid #eee; }
      .dropdown-menu ul.menu li:last-child {
        border-bottom: none; }
		
		
      .dropdown-menu ul.menu li a {
		  
        padding: 7px 11px;
        text-decoration: none;
        -moz-transition: 0.5s;
        -o-transition: 0.5s;
        -webkit-transition: 0.5s;
        transition: 0.5s; 
	 }
     .dropdown-menu ul.menu li a:hover {
			
          background-color: #e9e9e9; 
	}
    .dropdown-menu ul.menu .menu-info {
      display: inline-block;
      position: relative;
      top: 3px;
      left: 5px; }
      .dropdown-menu ul.menu .menu-info h4 {
        margin: 0;
        font-size: 13px;
        color: #333; }
      .dropdown-menu ul.menu .menu-info p {
        margin: 0;
        font-size: 11px;
        color: #aaa; }
        .dropdown-menu ul.menu .menu-info p .material-icons {
          font-size: 13px;
          color: #aaa;
          position: relative;
          top: 2px; }
  .dropdown-menu .footer a {
    text-align: center;
    border-top: 1px solid #eee;
    padding: 5px 0 5px 0;
    font-size: 12px;
    margin-bottom: -5px; }
    .dropdown-menu .footer a:hover {
      background-color: transparent; }
  .dropdown-menu > li > a {
    padding: 7px 18px;
    color: #666;
    -moz-transition: all 0.5s;
    -o-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    font-size: 14px;
    line-height: 25px; }
    .dropdown-menu > li > a:hover {
      background-color: rgba(0, 0, 0, 0.075); }
    .dropdown-menu > li > a i.material-icons {
      float: left;
      margin-right: 7px;
      margin-top: 2px;
      font-size: 20px; }

.dropdown-animated {
  -webkit-animation-duration: .3s !important;
  -moz-animation-duration: .3s !important;
  -o-animation-duration: .3s !important;
  animation-duration: .3s !important; }
  


  </style>
  <!-- /.LINK -->
  
  <style>
      .urate{
          border: 2px solid #9b9b9b;
          border-radius: 18px;
      }
	  
	  .widget{
		  min-height: 80px !important;
	  }
	  
	    .content-wrapper{
	  
	  margin-left: 30px !important;
	  
  }
	  
  </style>
  
  <!-- Javascript -->
  <script type="text/javascript" src="<?php echo $path;?>assets/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo $path;?>assets/ext/jquery-ui.js"></script>
  <script type="text/javascript" src="<?php echo $path;?>assets/js/bootstrap.js"></script>    
  <script type="text/javascript" src="<?php echo $path;?>assets/ext/lodash.min.js"></script>
  <script type="text/javascript" src="<?php echo $path;?>assets/js/sidebar.js"></script>
  <script src="<?php echo $path;?>assets/js/gridstack.js"></script>
  <script src="<?php echo $path6;?>dist/js/bootstrap-select.js"></script>           
  
  <!-- Jquery DataTable Plugin Js -->
  <script src="<?php echo $path5;?>plugins/jquery-datatable/jquery.dataTables.js"></script>     
  <script src="<?php echo $path5;?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
  <script src="<?php echo $path5;?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
  <script src="<?php echo $path5;?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
  <script src="<?php echo $path5;?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
  <script src="<?php echo $path5;?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
  <script src="<?php echo $path5;?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
  <script src="<?php echo $path5;?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>	
  <!-- <script src="<?php echo $path5;?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script> -->
  
  <!--typehead-->
  <script src="<?php echo $path7;?>bootstrap3-typeahead.js" type="text/javascript"></script>     
  
  <!-- Bootstrap Material Datetime Picker Plugin Js -->
  <script src="<?php echo $path;?>assets/ext/moment.min.js" type="text/javascript"></script>
  <script src="<?php echo $path5;?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
  
  <!-- Price Format -->
  <script src="<?php echo $path5;?>plugins/Jquery-Price-Format/jquery.priceformat.min.js" type="text/javascript"></script>
  
  <!-- Jquery Cookie -->
  <script src="<?php echo base_url();?>assets/cookie/jquery.cookie.js" type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/sweetalert/sweetalert2.min.js" type="text/javascript"></script>
  
  <!-- Chart.js -->
  <script type="text/javascript" src="<?php echo $path;?>assets/ext/Chart.bundle.min.js"></script>
  
  <!-- JsTree -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/vendors/jstree/jstree.min.js"></script>
  
  <!-- Parameter Box -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/parameter-box.js"></script>
  
  
 
  <?php 
      // $user_id = $this->session->userdata('user_id');
      // $id_role = $this->session->userdata('id_role');
      // $image = $this->session->userdata('image');
	  
	  // print_r($this->session->userdata);
  ?>
  
 

</head>
<body>
  <!-- Header -->
	<header>
       	<nav class="navbar navbar-fixed-top navbar-urate">
          	<div class="container-fluid">
              	<a class="navbar-brand" href="#">
                   <!-- <img src="<?php echo base_url();?>img/logo_putih_png2.png" alt="logo RMRate" width="1200px" height="160px"> -->
              	</a>
              	
          	</div>
        </nav>
   	</header>
	<!-- / Header -->
	<!-- Main Container -->
	<div class="main-container">
		<!-- Sidebar -->
    <?php //include(APPPATH . 'views/menu.php');?>