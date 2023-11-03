<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api User
 * Controller berhubungan dengan data user
 *
 * @author agus.merdeko@gmail.com
 * @copyright (c) 2016 PT. Swamedia Informatika
 */
class Api_user extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_user/api_user_model');
	}

	public function list_datatable()
	{
		
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('id', 'username', 'alamat');
		
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$list = $this->api_user_model->list_user($params);
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = 10;
		
		$data = array();			
		foreach ( $list['data'] as $k => $v ) {
			array_push($data, 
				array(
					$v['id'],
					$v['username'],
					$v['nama'],
					$v['role'],
					$v['alamat'],
					$v['kontak'],
					$v['email'],
					'Action'
					
				)
			);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
	
	public function create() {
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'username', 'required|max_length[30]');
		$this->form_validation->set_rules('password', 'password', 'required|max_length[30]');
		$this->form_validation->set_rules('name', 'name', 'required|max_length[50]');
		$this->form_validation->set_rules('tempatlahir', 'tempatlahir', 'required|max_length[30]');
		if ($this->input->post('tgl_lahir', true) == '00-00-0000'){
		$this->form_validation->set_rules('tgl_lahir', 'tgl_lahir', 'required|max_length[30]');
		}
		$this->form_validation->set_rules('agama', 'agama', 'required|max_length[30]');
		$this->form_validation->set_rules('role', 'role', 'required|max_length[40]');
		$this->form_validation->set_rules('unit', 'unit', 'required|max_length[40]');
		$this->form_validation->set_rules('contact1', 'contact1', 'required|max_length[30]');
		$this->form_validation->set_rules('email', 'email','required|max_length[30]');
		$this->config =  array(
                  'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/img/",
                  'upload_url'      => base_url()."img/",
                  'allowed_types'   => 'gif|jpg|png',
								  'max_width'				=> '1024',
								  'max_height'      => '768',
                  'overwrite'       => TRUE,
				          'max_size'        => "100000 KB",	  
								  'remove_spaces' 	=> "TRUE",
                );
				
		$this->load->library('upload', $this->config);		
		
		if($this->upload->do_upload("logo"))
		{
			$upload_data 	= 	$this->upload->data();
            $pin_nama_file 		= 	$upload_data['file_name'];
		
		if ($this->form_validation->run() == FALSE)  {
			$result = array( 'success' => false, 'message' => validation_errors() );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else if ($this->form_validation->run() == TRUE)  {
			$data = array (
				'username' 			=> $this->input->post('username', true),
				'pwd'				=> $this->input->post('password', true),
				'nama'				=> $this->input->post('name', true),
				'tgl_lahir'			=> $this->input->post('tgl_lahir', true),
				'tempatlahir'		=> $this->input->post('tempatlahir', true),
				'agama'				=> $this->input->post('agama', true),
				'id_role' 			=> $this->input->post('role', true),
				'unit' 				=> $this->input->post('unit', true),
				'nokontak1' 		=> $this->input->post('contact1', true),
				'nokontak2' 		=> $this->input->post('contact2', true),
				'nokontak3' 		=> $this->input->post('contact3', true),
				'alamat' 			=> $this->input->post('alamat', true),
				'email' 			=> $this->input->post('email', true),
				'logo' 				=> $pin_nama_file,
		 );
			$id = $this->api_user_model->create($data);
			if ( $id ) {			
				$result = array( 'success' => true, 'message' => 'Success', 'data' => array('id' => $id));
				
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			} else {
				$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
		}
			echo json_encode(array('msg'=>'Successfully upload your file. ','success'=>true));
		}
		else
		{
		   
		   if ($this->form_validation->run() == FALSE)  {
			$result = array( 'success' => false, 'message' => validation_errors() );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
			} else if ($this->form_validation->run() == TRUE)  {
				$data = array (
					'username' 			=> $this->input->post('username', true),
					'pwd'				=> $this->input->post('password', true),
					'nama'				=> $this->input->post('name', true),
					'tgl_lahir'			=> $this->input->post('tgl_lahir', true),
					'tempatlahir'		=> $this->input->post('tempatlahir', true),
					'agama'				=> $this->input->post('agama', true),
					'id_role' 			=> $this->input->post('role', true),
					'unit' 				=> $this->input->post('unit', true),
					'nokontak1' 		=> $this->input->post('contact1', true),
					'nokontak2' 		=> $this->input->post('contact2', true),
					'nokontak3' 		=> $this->input->post('contact3', true),
					'alamat' 			=> $this->input->post('alamat', true),
					'email' 			=> $this->input->post('email', true),
					'logo' 				=>  $this->input->post('logo', true),
			 );
				$id = $this->api_user_model->create($data);
				if ( $id ) {			
					$result = array( 'success' => true, 'message' => 'Success', 'data' => array('id' => $id));
					
					$this->output->set_content_type('application/json')->set_output(json_encode($result));
				} else {
					$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
					$this->output->set_content_type('application/json')->set_output(json_encode($result));
				}
			}
		   
		   $uploaderor = $this->upload->display_errors();
		 
		   echo json_encode(array('msg'=>$uploaderor,'success'=>false));
		   $this->redirect_halaman();
		}
	}
	
	public function detail($id = FALSE) {
		
		if ( $id == FALSE ) {
			$result = array( 'success' => false, 'message' => 'No ID supplied' );
			header('Content-type: Application/json');
			echo json_encode($result);
			exit();
		}
		$detail = $this->api_user_model->detail($id);
		if ( $detail ) {
			$result = array(
				'success' => true,
				'data' => $detail
			);
		} else {
			$result = array(
				'success' => false,
				'message' => 'Error retrieving data'
			);
		} 
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
	
	public function edit($id = FALSE) {
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'username', 'required|max_length[30]');
		$this->form_validation->set_rules('nama', 'nama', 'required|max_length[50]');
		$this->form_validation->set_rules('roles', 'roles', 'required|max_length[40]');
		$this->form_validation->set_rules('contact1', 'contact1', 'required|max_length[30]');
		$this->form_validation->set_rules('alamat', 'alamat', 'required|max_length[100]');
		$this->form_validation->set_rules('email', 'email','required|max_length[30]');


		if ($this->form_validation->run() == FALSE)  {
			$title = 'Error';
			$tags = strip_tags(validation_errors());
			$message = str_replace("\n", '', $tags);
			$status = 'error';
			$this->session->set_flashdata('msg', '<script>swal("'.$title.'","'.$message.'","'.$status.'");</script>');					
			redirect(base_url('users/edit/'.$id));			
		} else if ($this->form_validation->run() == TRUE)  {

			$config =  array(
					  'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/img/",
					  'upload_url'      => base_url()."img/",
					  'allowed_types'   => 'gif|jpg|png|jpeg',
					  'max_width'		=> '1024',
					  'max_height'      => '768',
					  'overwrite'       => FALSE,
					  'remove_spaces' 	=> TRUE,
					  'max_size'        => "100000 KB",
					);
					
			$this->load->library('upload', $config);	

			$old_logo = $this->input->post('old_logo');

			$image_location = NULL;
			
			if(!empty($old_logo)){
				$image_location = $old_logo;
			}

			{
				$result = $this->upload->data();		
				
					$resizeParams = array
					(
						'source_image'	=> $result['full_path'],
						'new_image'		=> $result['full_path'],
						'width'			=> 500,
						'height'		=> 700
					);
					
					$this->load->library('image_lib', $resizeParams);
					
					$this->image_lib->resize();			
				
				$image_location = $result['file_name'];
				
			}
		
			$data = array (
				'username' 	=> $this->input->post('username', true),
				'nama'		=> $this->input->post('nama', true),
				'id_role' 	=> $this->input->post('roles', true),
				'nokontak1' => $this->input->post('contact1', true),
				'nokontak2' => $this->input->post('contact2', true),
				'nokontak3' => $this->input->post('contact3', true),
				'alamat' 	=> $this->input->post('alamat', true),
				'email' 	=> $this->input->post('email', true),
				'image' 	=> $image_location 
			);
			
			$res = $this->api_user_model->edit($data, $id);
			if ( $res ) {
				$title = 'Success';
				$message = 'Success edit user '.$data['nama'];
				$status = 'success';
				$this->session->set_flashdata('msg', '<script>swal("'.$title.'","'.$message.'","'.$status.'");</script>');					
				redirect(base_url('users/detail/'.$id));
			} else {
				$title = 'Error';
				$message = 'Error when updating data '.$data['nama'];
				$status = 'error';
				$this->session->set_flashdata('msg', '<script>swal("'.$title.'","'.$message.'","'.$status.'");</script>');					
				redirect(base_url('users/edit/'.$id));				
			}
			
		}		 		
		
	}
	
		public function change_pwd($id = FALSE) {
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'password', 'required');


		if ($this->form_validation->run() == FALSE)  {
			$title = 'Error';
			$tags = strip_tags(validation_errors());
			$message = str_replace("\n", '', $tags);
			$status = 'error';
			$this->session->set_flashdata('msg', '<script>swal("'.$title.'","'.$message.'","'.$status.'");</script>');					
			redirect(base_url('users/edit/'.$id));			
		} else if ($this->form_validation->run() == TRUE)  {

			$config =  array(
					  'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/img/",
					  'upload_url'      => base_url()."img/",
					  'allowed_types'   => 'gif|jpg|png|jpeg',
					  'max_width'		=> '1024',
					  'max_height'      => '768',
					  'overwrite'       => FALSE,
					  'remove_spaces' 	=> TRUE,
					  'max_size'        => "100000 KB",
					);
					
			$this->load->library('upload', $config);	

			$old_logo = $this->input->post('old_logo');

			$image_location = NULL;
			
			if(!empty($old_logo)){
				$image_location = $old_logo;
			}

			{
				$result = $this->upload->data();		
				
					$resizeParams = array
					(
						'source_image'	=> $result['full_path'],
						'new_image'		=> $result['full_path'],
						'width'			=> 500,
						'height'		=> 700
					);
					
					$this->load->library('image_lib', $resizeParams);
					
					$this->image_lib->resize();			
				
				$image_location = $result['file_name'];
				
			}
		
			$data = array (
				'password' 	=> $this->input->post('password', true)
			);
			
			$res = $this->api_user_model->change_pwd($data, $id);
			if ( $res ) {
			$this->load->helper('cookie');
			$prefix = $this->config->item('cookie_prefix');
			delete_cookie($prefix.'status_pwd');
			$role		= $_COOKIE["pmis2_role_id"];
			
				$title = 'Success';
				$message = 'Success edit user '.$data['nama'];
				$status = 'success';
				$this->session->set_flashdata('msg', '<script>swal("'.$title.'","'.$message.'","'.$status.'");</script>');
				if ($role == 25 || 26 ||27 ||28 ){
					
					
					redirect(base_url('idashboard'));
					
				}else{
					redirect(base_url('mdashboard'));
				}
				
			} else {
				$title = 'Error';
				$message = 'Error when updating data '.$data['nama'];
				$status = 'error';
				$this->session->set_flashdata('msg', '<script>swal("'.$title.'","'.$message.'","'.$status.'");</script>');					
				redirect(base_url('users/edit/'.$id));				
			}
			
		}		 		
		
	}
	
				public function delete($id = FALSE) {
					
					if ( $id == FALSE ) {
						$result = array( 'success' => false, 'message' => 'No ID supplied' );
						header('Content-type: Application/json');
						echo json_encode($result);
						exit();
					}
					
					$delete = $this->api_user_model->delete($id);
					if ( $delete ) {
						$result = array(
							'success' => true
						);
					} else {
						$result = array(
							'success' => false,
							'message' => 'Error deleting data'
						);
					} 
					$this->output->set_content_type('application/json')->set_output(json_encode($result));
				}
	
				function delete_project()
				{
					$this->api_user_model->delete_project($this->uri->segment(3));
				}
				
				function do_upload()
				{
					$config['upload_path'] = './img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= '1000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
			
					$this->load->library('upload', $config);
			
					if ( ! $this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());
			
						$this->load->view('upload_form', $error);
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
			
						$this->load->view('upload_success', $data);
					}
				}
	
			function list_role()
			{		
				$list = $this->api_user_model->list_all_role();
				$result["data"] = $list;
				$this->output->set_content_type('Application/json')->set_output(json_encode($result));
			}	
	
				function list_unit()
				{		
					$list = $this->api_user_model->list_unit();
					$result["data"] = $list;
					$this->output->set_content_type('Application/json')->set_output(json_encode($result));
				}	
	
				function list_agama()
				{		
					$list = $this->api_user_model->list_agama();
					$result["data"] = $list;
					$this->output->set_content_type('Application/json')->set_output(json_encode($result));
				}	
	
				public function redirect_halaman()
				{
					$this->load->helper('url');
			        redirect(base_url('users'));
				}
	
				public function redirect_profile()
				{
					$this->load->helper('url');
			        redirect(base_url('idashboard'));
				}
}

