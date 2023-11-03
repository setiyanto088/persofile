<?php

// $path = base_url() . 'assets/AdminLTE-2.1.1/';
$path = base_url() . 'assets/gentelella-master/';
$path2 = base_url() . 'assets/font-awesome/';
$path3 = base_url() . 'assets/ionicons-2.0.1/';
$path4 = base_url() . 'assets/eModal-master/';


?>


		<?php include(APPPATH . 'views/header2.php');
		
		?>
		

		

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
			<div class="right_col" role="main">
           
			<?php include($template_contents.'.php');?>
		</div>
      </div><!-- /.content-wrapper -->

      
	<?php include(APPPATH . 'views/footer2.php');?>
  </body>
</html>
