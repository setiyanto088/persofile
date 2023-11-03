<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	private $profile_menu = array();
	
	public function __construct() {
		parent::__construct();	
		$this->load->helper('cookie');
		$this->load->model('menu/menu_model');
	}
	
	function _build_menu($parent, $menu, $role_id)
	{
	   $html = "";
	   if (isset($menu['parents'][$parent]))
	   {
		  $html .= '<ul style="list-style:none">';
		   foreach ($menu['parents'][$parent] as $itemId)
		   {
			  if( ! isset($menu['parents'][$itemId]))
			  {
				 if ( $this->is_menu_in_profile($menu['items'][$itemId]['id'], $this->profile_menu) ) 
					$checked = 'checked';
				 else 
					$checked = '';
 				 $html .= 
				 '<li>       
					<div class="checkbox icheck">
						<label> 
							<input name="menu_id[]" type="checkbox" value="'.$menu['items'][$itemId]['id'].'" '.$checked.'> ' .$menu['items'][$itemId]['namamenu']
						.'</label>
					</div>
                  </li>';
			  }
			  if( isset($menu['parents'][$itemId]) )
			  {
				 if ( $this->is_menu_in_profile($menu['items'][$itemId]['id'], $this->profile_menu) ) 
					$checked = 'checked';
				 else 
					$checked = '';
					
 				 $html .= 
				 '<li>
					<div class="checkbox icheck">
						<label>
							<input name="menu_id[]" type="checkbox" value="'.$menu['items'][$itemId]['id'].'" '.$checked.'> ' .$menu['items'][$itemId]['namamenu'].
						'</label>
					</div>';
                 
				 $html .= $this->_build_menu($itemId, $menu, $role_id);
					
				 $html .= '</li>';
			  }
		   }
		   $html .= '</ul>';
	   }
	   return $html;
	}
		
	function edit() {
	
		$message = '';
		$menu_html = '';
		
		$prefix = $this->config->item('cookie_prefix');
		$role_id = get_cookie($prefix.'role_id'); // init role
		$roles = $this->menu_model->get_roles();
		$data['roles'] = $roles['data'];
		
		if ( $this->input->post('btn_select_role') != FALSE ) {
			$role_id = $this->input->post('role_id'); // role from select box
		}
		
		if ( $this->input->post('btn_submit') != FALSE) {
			$api_data['role_id'] = $this->input->post('role_id');
			$api_data['menu_id'] = $this->input->post('menu_id');
			//var_dump($api_data);exit();
			$save_res = $this->menu_model->save_menu($api_data);
			$data['success'] = $save_res['success'];
			$data['message'] = $save_res['message'];
			$role_id = $this->input->post('role_id'); // role from select box
		}
		
		
		$all_menu = $this->menu_model->get_all_menu();
		$profile_menu = $this->menu_model->get_profile_menu($role_id);
 		$this->profile_menu = $profile_menu['data'];
		
		$menu_html = $this->_build_menu(0, $all_menu['data'], $role_id);
		
		$data['role_id'] = $role_id;
		$data['menu_html'] = $menu_html;

		
		$this->template->load('maintemplate', 'menu/views/edit', $data);	
	}
	
	function is_menu_in_profile($menu_id, $profile_menu) {
 		foreach ($profile_menu['items'] as $item) {
			if ($menu_id == $item['id']) {
				return true;
			}
		}
		return false;
	}
}
