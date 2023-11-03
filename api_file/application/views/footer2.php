
  <!-- footer content -->
        <footer>
          <div class="pull-right hidden-xs">
          <strong>Version</strong> 2.0
        </div>
        <strong>Copyright &copy; 2015 <a href="http://swamedia.co.id">swamedia</a>.</strong> All rights reserved.
		  <?php 
				$result = $this->session->all_userdata();
				print_r($this->session->userdata('id_unit'));
		  
		  ?>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

	
	<!-- JS -->
	<!-- jQuery -->
    <script src="<?php echo $path;?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $path;?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $path;?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo $path;?>vendors/nprogress/nprogress.js"></script>
    
    <!-- bootstrap-progressbar -->
    <script src="<?php echo $path;?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $path;?>vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo $path;?>vendors/skycons/skycons.js"></script>
     <!-- DateJS -->
    <script src="<?php echo $path;?>vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo $path;?>js/moment/moment.min.js"></script>
    <script src="<?php echo $path;?>js/datepicker/daterangepicker.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo $path;?>build/js/custom.min.js"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo $path;?>datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo $path;?>datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $path;?>datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="<?php echo $path;?>datatables/fnReloadAjax.js" type="text/javascript"></script>
	<!-- Jquery Cookie -->
    <script src="<?php echo base_url();?>assets/cookie/jquery.cookie.js" type="text/javascript"></script>
	
  </body>
</html>
