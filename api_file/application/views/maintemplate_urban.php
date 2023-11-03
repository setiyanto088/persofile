<?php
include("/var/www/file/cfg.php");
	
    $path = base_url() . 'assets/urate-frontend-master/';
    $path2 = base_url() . 'assets/font-awesome/';
    $path3 = base_url() . 'assets/ionicons-2.0.1/';
    $path4 = base_url() . 'assets/eModal-master/';
    $path5 = base_url() . 'assets/AdminBSBMaterialDesign-master/';
    $path6 = base_url() . 'assets/bootstrap-select-1.12.4/';
    $path7 = base_url() . 'assets/Bootstrap-3-Typeahead-master/';
    $path8 = base_url() . 'assets/gentelella-master/';
    $path9 = base_url() . 'assets/2022_design/';
	$donwload_base = $donwload_base_v;
?>

  <?php include(APPPATH . 'views/header_urban.php'); ?>
  
  <!-- Content Wrapper. Contains page content -->
  <section class="content">
  <?php include($template_contents.'.php');?>
  </section><!-- /.content-wrapper -->
	
    <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-danger panel-filled">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <p></p>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <?php include(APPPATH . 'views/footer.php');?>
  </body>
</html>