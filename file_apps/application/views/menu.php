<?php
class Menu_tree {
	
	private $menu_data;
	
	function __construct() {

		// $ci =& get_instance();
		// $ci->load->helper('cookie');
		// $prefix = $ci->config->item('cookie_prefix');
		// $user_id  = get_cookie($prefix.'user_id');
		// $token  = get_cookie($prefix.'token');
		// $role_id = get_cookie($prefix.'role_id');
		// $status_pwd = get_cookie($prefix.'status_pwd');
		
		$this->ci =& get_instance();
		$user_id = $this->ci->session->userdata['user_id'];
		$role_id = $this->ci->session->userdata['id_role'];
		$token = $this->ci->session->userdata['token'];
		
		//$CI =& get_instance();
		//$this->ci->load->database();
		//$url = base_url(). 'api_menu/get_menu/' .  $role_id	 . '?sess_user_id='.$user_id.'&sess_token='.$token;
		
		
		 //print_r($url);die;
		 //die;
		 
		 
		// $ch = curl_init(); 
		// curl_setopt($ch, CURLOPT_URL, $url); 
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		// $output = curl_exec($ch); 
		
		
		//curl_error($ch);die;
		// curl_close($ch); 
		// echo 123;
		// print_r($output);
		// die;
		
		$url = $this->getMenu($role_id);
		
		//print_r(json_decode($url, TRUE));
		
		$this->menu_data = json_decode($url, TRUE);
		
	}
	
		function getMenu($role_id) {
		$uid = '86 	'; $rid = '25';

			$sql 	=	'SELECT
                            b.id,
                            b.menu,
                            b.namamenu,
                            b.parentid,
                            b.icon,
                            b.sequence
                        FROM
                            pmt_menu_profile a, 
                            pmt_menu_ev b 
                        WHERE
                            a.statusmenu	= 1 
                            AND b.status_menu	= 1 	
                            AND	a.id_menu	= b.id 
                            AND a.id_profile = \''.$role_id.'\'
                        ORDER BY 
                            b.parentid, 
                            b.sequence,
                            b.namamenu;';
							
			// echo $role_id;
							
			$query 	=	$this->ci->db->query($sql);
			$result =	$query->result_array();
			// echo "<script>alert(rian);</script>";
			
			 
			
		 
		// $result =	$query->result_array();
		
		// if ( ! empty($result) ) {
			$menu = array(
				'items' => array(),
				'parents' => array()
			);
			
			// Builds the array lists with data from the menu table
			
			foreach ($result as $items)
				{
				// Creates entry into items array with current menu item id ie. $menu['items'][1]
				$menu['items'][$items['id']] = $items;
				// Creates entry into parents array. Parents array contains a list of all items with children
				$menu['parents'][$items['parentid']][] = $items['id'];
				}
			//echo 'menu: ';		var_dump($menu);
            
            $result["data"] = $menu;
			return json_encode($result,JSON_FORCE_OBJECT);
			//return $menu;
			
			
		// } else  {
		// return null;
		// }	
			
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
      $packageSeq = 0;
		   foreach ($menu['parents'][$parent] as $itemId)
		   {                 
			  if( ! isset($menu['parents'][$itemId]))
			  {
				 $html .=  
				 '<li class="menu-item">
                    <a href="'. base_url().$menu['items'][$itemId]['menu']. '" data-menu-name="'.$menu['items'][$itemId]['menu'].'">
                    
                    <span class="menu-icon"><image src="'.base_url().'assets/urate-frontend-master/assets/images/'.$menu['items'][$itemId]['icon'].'.png"/></span>
	                <span>'.$menu['items'][$itemId]['namamenu'].'</span>
                    
                
                    
					</a>
                 
				  </li>';
			  }
			  if( isset($menu['parents'][$itemId]) )
			  {                        
//				$menu['items'][$itemId]['icon']  
				 $html .= 
				 '<li   class="menu-item has-child">
					<a href="javascript:void(0);" data-menu-name="'.$menu['items'][$itemId]['menu'].'" >
                    
                    <span class="menu-icon"><image src="'.base_url().'assets/urate-frontend-master/assets/images/'.$menu['items'][$itemId]['icon'].'.png"/></span>
	                <span>'.$menu['items'][$itemId]['namamenu'].'</span>
                    
                
                    
					</a>
					<ul id="kkkkkkk" >';        
				 
				 $html .= $this->_build_menu($itemId, $menu);
					
				 $html .= '</ul></li>';  
			  }   
		   }
	   }
	   return $html;
	}
}
?>



 	<div class="side-menu-wrapper">
           	<ul>
                <li class="menu-item">
					<input type='text' class="menu-item" id="search-menu" placeholder="Search" style="background-color:#2F2F2F;border: 1px solid rgba(255, 255, 255, 0.1);box-sizing: border-box;border-radius: 6px;display: flex;flex-direction: row;align-items: center;padding: 10px 20px 10px 10px;flex: none;order: 1;align-self: stretch;flex-grow: 0;margin: 0px 0px 20px 10px;width: 220px;" />
				</li>
                <?php 
                    
                    // $ci =& get_instance();
                    // $ci->load->helper('cookie');
                    // $prefix = $ci->config->item('cookie_prefix');
                    // $user_id  = get_cookie($prefix.'user_id');
                    // $token  = get_cookie($prefix.'token');
                    // $role_id = get_cookie($prefix.'role_id');
                    // $status_pwd = get_cookie($prefix.'status_pwd');
                    // $this->ci =& get_instance();
					// $user_id = $this->session->userdata('user_id');
					// $role_id = $this->session->userdata('id_role');
					// $token = $this->session->userdata('token');
							//echo $token; 
							$menu_tree = new Menu_tree();
							// $this->load->helper('cookie');
							// $prefix = $this->config->item('cookie_prefix');
							// $user_id = get_cookie($prefix.'user_id');

							// $status_pwd = get_cookie($this->config->item('cookie_prefix').'status_pwd');
							
							echo $menu_tree->generate_html();
							
							?>
                
             	
           	</ul>
       	</div>










			
			 