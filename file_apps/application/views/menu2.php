<?php
class Menu_tree {
	
	private $menu_data;
	
	function __construct() {

		$ci =& get_instance();
		$ci->load->helper('cookie');
		$prefix = $ci->config->item('cookie_prefix');
		$user_id  = get_cookie($prefix.'user_id');
		$token  = get_cookie($prefix.'token');
		$role_id = get_cookie($prefix.'role_id');
		$status_pwd = get_cookie($prefix.'status_pwd');
		$url = base_url(). 'api_menu/get_menu/' .  $role_id	 . '?sess_user_id='.$user_id.'&sess_token='.$token;
		// print_r($url);
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch); 
		curl_close($ch); 
		
		
		$this->menu_data = json_decode($output, TRUE);
		
	}
	
	function generate_html() {
		return $this->_build_menu(0, $this->menu_data['data']);
	}
	
	// function generate_html2() {

		// return $this->_build_menu(0, $this->menu_data[]);
	// }
			
	private function _build_menu($parent, $menu)
	{
	   $html = '';
	   if (isset($menu['parents'][$parent]))
	   {
		  //$html .= '<li class="treeview">';
		   foreach ($menu['parents'][$parent] as $itemId)
		   {
			  if( ! isset($menu['parents'][$itemId]))
			  {
				 $html .=  
				 '<li id="menu">
					<a href="'. base_url().$menu['items'][$itemId]['menu']. '"  >
						<i class="'.$menu['items'][$itemId]['icon'].'"></i>'.
						'<span>'.$menu['items'][$itemId]['namamenu'].'</span>'.
					'</a>
				  </li>';
			  }
			  if( isset($menu['parents'][$itemId]) )
			  {
				
				 $html .= 
				 '<li class="treeview" id="menu">
					<a href="#">
						<i class="'.$menu['items'][$itemId]['icon'].'"></i>'.
						'<span>'.$menu['items'][$itemId]['namamenu'].'</span>'.
						'<i class="fa fa-chevron-down pull-right"></i>
					</a>
					<ul class="nav child_menu">';
				 
				 $html .= $this->_build_menu($itemId, $menu);
					
				 $html .= '</ul></li>';
			  }
		   }
	   }
	   return $html;
	}
}
?>


 <div class="left_col scroll-view">
	<div class="navbar nav_title" style="border: 0;">
	  <a href="#" class="site_title"><span>URATE</span></a>
	</div>

	<div class="clearfix"></div>

	<!-- menu profile quick info -->
	<div class="profile">
	  <div class="profile_pic">
		<img src=" <?php  
								if(isset($image)){
									$gambar = base_url().'img/'.$image;
								}else{
									$gambar = base_url().'img/person.jpg';
								}
								echo $gambar;
							?>" alt="..." class="img-circle profile_img" style="width: 50px !important; height: 50px !important;">
	  </div>
	  <div class="profile_info">
		<span><?php echo get_cookie($this->config->item('cookie_prefix').'role_name');?></span>
		<h2><?php echo get_cookie($this->config->item('cookie_prefix').'user_full_name');?></h2>
	  </div>
	</div>
	<!-- /menu profile quick info -->

	<br />

	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	  <div class="menu_section">
		<h3>General</h3>
		<ul class="nav side-menu">
		
		<?php 
			
			$menu_tree = new Menu_tree();
			$this->load->helper('cookie');
			$prefix = $this->config->item('cookie_prefix');
			$user_id = get_cookie($prefix.'user_id');

			$status_pwd = get_cookie($this->config->item('cookie_prefix').'status_pwd');
			
			echo $menu_tree->generate_html();
			
			?>
		
		
		
	  </div>

	</div>
	<!-- /sidebar menu -->

  </div>




			
			 