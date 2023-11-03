 
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Menu
	<small>Edit Menu</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo base_url();?>"><em class="fa fa-dashboard"></em> Home</a></li>
	<li><a href="<?php echo base_url();?>menu">Menu</a></li>
	<li class="active">Edit Menu</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-xs-12">
		
	  <div class="box box-primary">
		  
		<div class="box-header">
		  <h3 class="box-title">Edit Menu</h3>
		</div><!-- /.box-header -->
		
		<div class="box-body">
		  <?php if ( isset($success) && $success == FALSE) :?>
		  <div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><em class="icon fa fa-ban"></em> Error!</h4>
			<span class="content"><?php echo $message;?></span>
		  </div>
		  <?php endif;?>
		  <div class="alert alert-info alert-dismissable" style="display:none">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><em class="icon fa fa-info"></em> Info!</h4>
			<span class="content">Info alert preview. This alert is dismissable.</span>
		  </div>
		  <div class="alert alert-warning alert-dismissable" style="display:none">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><em class="icon fa fa-warning"></em> Warning!</h4>
			<span class="content">Warning alert preview. This alert is dismissable.</span>
		  </div>
		  <?php if ( isset($success) && $success == TRUE) :?>
		  <div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4>	<em class="icon fa fa-check"></em> Success!</h4>
			<span class="content"><?php echo $message;?></span>
		  </div>
		  <?php endif;?>
		</div>
		
		<div class="box-body">
			
			<form action="<?php echo base_url();?>menu/edit/" method="post" id="form_edit">
				<div class="form-group">
					<label>Role</label> 
					<div class="input-group">
						<select id="role_id" name="role_id" class="form-control">
							<?php foreach ($roles as $k => $v) :?>
							<option value="<?php echo $v['id'];?>" <?php if ( isset($role_id) && $role_id == $v['id']) echo 'selected="selected"';?>>
								<?php echo $v['role'];?>
							</option>
							<?php endforeach;?>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit" id="btn_select_role" name="btn_select_role" value="OK"><em class="fa fa-refresh"></em></button>
						</span>
					</div>
				</div>
				
				<?php echo $menu_html;?>
				
				<div class="form-group">
					<button class="btn btn-lg btn-block btn-success" type="submit" id="btn_submit" name="btn_submit" value="Save">Save</button>
				</div>
			</form>
		</div><!-- /.box-body -->
			
	  </div><!-- /.box-primary -->
	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
