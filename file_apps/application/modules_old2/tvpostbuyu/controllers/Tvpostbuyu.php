<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvpostbuyu extends JA_Controller {
  public function __construct()
	{
		parent::__construct();		
				
		$this->load->model('Tvpostbuyu_model');
	}
	
	
	public function filter(){
		
		$filter = $this->input->post('filter_text');
		$filter2 = $this->input->post('filter_text2'); 
		echo $filter."<br>".$filter2;
	}
	
	public function index()
	{
 
		
		if($this->input->post('filter_text')){
				
				$filter = $this->input->post('filter_text');
				$starttime = $this->input->post('starttime');
				$endtime = $this->input->post('endtime');
				$mindur = $this->input->post('mindur');
				$maxdur = $this->input->post('maxdur');
				
				
				
				$f_array = json_decode($filter,true);
				
				$where = " AND";
				foreach($f_array as $farray){
					
					
					if(isset($farray["children"])){
						
						$where = $where." ".$farray['id']." IN (";
						
						foreach($farray["children"] as $child){
							
							$where = $where."'".$child["id"]."',"; 
							
						}
						$where = rtrim($where, ",");
						
						$where = $where.") AND";
					}
					
				} 
				
				$where = rtrim($where, "AND");
				
				if($starttime <> "00:00:00"){
					
					$where = $where." AND DATE_FORMAT(STR_TO_DATE(start_time, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('".$starttime."', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(end_time, '%T'), '%T') < DATE_FORMAT(STR_TO_DATE('".$endtime."', '%T'), '%T') ";
					
				}
				
				if($mindur <> "00:00:00"){
					
					$where = $where." AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('".$mindur."', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') <= DATE_FORMAT(STR_TO_DATE('".$maxdur."', '%T'), '%T') ";
					
				}
			
		}else{
			
			$where = " ";
		}
				
		$data['bln'] = $this->Tvpostbuyu_model->get_bulan();
		$data['thn'] = $this->Tvpostbuyu_model->get_tahun();
 		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
 		if (!isset($tahun)){
			$tahun=$data['thn'][0]['tahun'];
			
			$bln_a = $this->Tvpostbuyu_model->get_bulan();
 			$curr_m = end($bln_a);
	 
			$bulan="December";
		}
		$periode=$tahun;
	 
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		
 		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
			
		if($id == null){
			$id = 0;
 		}else{
			$id = $this->session->userdata('project_id');
		}
		
	
	
 		$data['cond'] = $where;
		$data['profile'] = $this->Tvpostbuyu_model->list_profile();
		$data['channel'] = $this->Tvpostbuyu_model->list_spot_by_chanel_all($where,$periode);
		$data['adstype'] = $this->Tvpostbuyu_model->list_spot_by_program_all($where,$periode);

 		
		$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_daytime_all($where,$periode);

		$data['date'] = $this->Tvpostbuyu_model->list_spot_by_date_all('SPOT',$periode);

	 
		
		foreach($data['channel'] as $datax){
			$data_ch[] = '"'.$datax['CHANNEL'].'"';
			$spot_ch[] = $datax['SPOT'];
			
		}
		
		foreach($data['adstype'] as $datas){
			$data_ads[] = '"'.$datas['ADS_TYPE'].'"';
			$spot_ads[] = $datas['SPOT'];
			
		}
		
		$prime = 0;
		$nprime = 0;
		
		foreach($data['daytime'] as $datass){
			$data_daytime[] = '"'.$datass['htype'].'"';
			$spot_daytime[] = $datass['spot'];
			
			if($datass['htype'] == "18:00 - 22:00"){
				$prime = $prime + $datass['spot'];
			}else{
				$nprime = $nprime + $datass['spot'];
			}
		}
		

		foreach($data['date'] as $datasss){
			$data_date[] = '"'.$datasss['date'].'"';
			$spot_date[] = $datasss['val'];
		}
				
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
 		$data['products'] = json_encode($this->Tvpostbuyu_model->proc_get_segment("PRODUCT","SPOT",$where,$periode),true);
		$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment2_f("PROGRAM","SPOT",$where,$periode),true);
		
		$data['loose'] = $this->Tvpostbuyu_model->list_spot_by_loose_all($where,$periode);
		 
		
		$data['header'] = $this->Tvpostbuyu_model->list_header_dash($periode);
		
 
		$data['json_channel'] = $data_ch;
		$data['json_spot'] = $spot_ch;
 		$data['json_ads'] = $data_ads;
		$data['json_spot_ads'] = $spot_ads;
 		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		
 		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
 		
		$this->template->load('maintemplate', 'tvpostbuyu/views/Tvpostbuyu', $data);
	}
	
	function cost_by_channel(){
		
		$where =  $this->input->post('cond');
		$type =  $this->input->post('type');
		$tahun=$this->input->post('tahun');
 		$periode=$tahun;
		 
		$data_ch = array();
		if($type == "Cost"){
			$data['channel'] = $this->Tvpostbuyu_model->proc_get_cost_by_channel_all("COST",$periode);
			
			foreach($data['channel'] as $datax){
				$data_ch['cat'][] = $datax['CHANNEL'];
				$data_ch['data'][] = $datax['COST'];
			}
			 
			
			
		}elseif($type == "Spot"){
			$data['channel'] = $this->Tvpostbuyu_model->proc_get_cost_by_channel_all("SPOT",$periode);
			
			foreach($data['channel'] as $datax){
				$data_ch['cat'][] = $datax['CHANNEL'];
				$data_ch['data'][] = $datax['SPOT'];
			}
			 
		}elseif($type == "GRP"){
			$data['channel'] = $this->Tvpostbuyu_model->proc_get_cost_by_channel_all("GRP",$periode);
			if ($data['channel'] == null){
				$data_ch['cat'][] = 0;
				$data_ch['data'][] = 0;
			} else {
				foreach($data['channel'] as $datax){
					$data_ch['cat'][] = $datax['CHANNEL'];
					$data_ch['data'][] = $datax['GRP'];
				}
				 
			}
			
		}
		
		
		
		echo json_encode($data_ch,true);
	}
	
	function ads_view(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$periode=$tahun;
	 
			
		if($type == "Cost"){
			$data['programs'] = $this->Tvpostbuyu_model->proc_get_cost_by_program_all("COST",$where,$periode);
			
			foreach($data['programs'] as $datax){
				$data_ch['cat'][] = $datax['ADS_TYPE'];
				$data_ch['data'][] = $datax['COST'];
			}
		
		}elseif($type == "Spot"){
			$data['programs'] = $this->Tvpostbuyu_model->proc_get_cost_by_program_all("SPOT",$where,$periode);
			
			foreach($data['programs'] as $datax){
				$data_ch['cat'][] = $datax['ADS_TYPE'];
				$data_ch['data'][] = $datax['SPOT'];
			}
		}
		elseif($type == "GRP"){
			$data['programs'] = $this->Tvpostbuyu_model->proc_get_cost_by_program_all('GRP',$where,$periode);
			if ($data['programs'] == null){
				$data_ch['cat'][] = 0;
				$data_ch['data'][] = 0;
			} else {
				foreach($data['programs'] as $datax){
				$data_ch['cat'][] = $datax['ADS_TYPE'];
				$data_ch['data'][] = $datax['GRP'];
				}
			}
			
		}
		
		
		
		echo json_encode($data_ch,true);
	}
	
	function day_view(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$periode=$tahun;
		
		if($type == "Cost"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_date_all("COST",$periode);
			
			foreach($data['daytime'] as $datass){
				$data_ch['cat'][] = $datass['date'];
				$data_ch['data'][] = $datass['val'];
			}
		
		}elseif($type == "Spot"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_date_all("SPOT",$periode);
			
				foreach($data['daytime'] as $datasss){
				$data_ch['cat'][] = $datasss['date'];
				$data_ch['data'][] = $datasss['val'];
			}
		}elseif($type == "GRP"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_date_all("GRP",$periode);
				if ($data['daytime'] == null) {
					$data_ch['cat'][] = 0;
					$data_ch['data'][] = 0;
				} else {
					foreach($data['daytime'] as $datasss){
						$data_ch['cat'][] = $datasss['date'];
						$data_ch['data'][] = $datasss['val'];
					}
				}
		}
		
		
		
		echo json_encode($data_ch,true);
		
	}
	
	function daypart_view(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$periode=$tahun;
		
		if($type == "Cost"){
			
			$field = "COST";
		
		}elseif($type == "Spot"){
			
			$field = "SPOT";
			
		}elseif($type == "GRP"){
			$field = "GRP";
		}
		
		
		$data['daytime'] = $this->Tvpostbuyu_model->filtered_daytime_all($field,$periode);
			
			foreach($data['daytime'] as $datass){
				$data_ch['cat'][] = '"'.$datass['htype'].'"';
				$data_ch['data'][] = $datass[$field];
			}
		
		echo json_encode($data_ch,true);
	}
	
	function prime_view(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$periode=$tahun;
		
		$prime = 0;
		$nprime = 0;
		
		if($type == "Cost"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_cost_by_daytime_all($where,$periode);
			
			foreach($data['daytime'] as $datass){
				if($datass['htype'] == "18:00 - 22:00"){
					$prime = $prime + $datass['cost'];
				}else{
					$nprime = $nprime + $datass['cost'];
				}
			}
			
		
		}elseif($type == "Spot"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_daytime_all($where,$periode);
			
			foreach($data['daytime'] as $datass){
				if($datass['htype'] == "18:00 - 22:00"){
					$prime = $prime + $datass['spot'];
				}else{
					$nprime = $nprime + $datass['spot'];
				}
			}
		}elseif($type == "GRP"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_grp_by_daytime_all($where,$periode);
			
			foreach($data['daytime'] as $datass){
				if($datass['htype'] == "18:00 - 22:00"){
					$prime = $prime + $datass['grp'];
				}else{
					$nprime = $nprime + $datass['grp'];
				}
			}
		}
		
		$data_ch['prime'] = $prime;
		$data_ch['nprime'] = $nprime;
		$data_ch['Prime_Time'] = "Prime_Time";
		$data_ch['Non_prime_Time'] = "Non_prime_Time";

		
		
		
		echo json_encode($data_ch,true);
	}
	
	function cost_by_program3(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$periode=$tahun;
 
		
		if(STRTOUPPER($field) == "PROGRAM"){
			if($type == "Cost"){			
				$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment2_f(STRTOUPPER($field),"COST",$where,$periode),true);
				
			}elseif($type == "Spot"){
				$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment2_f(STRTOUPPER($field),"SPOT",$where,$periode),true);

			}elseif($type == "GRP"){
				$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment2_f(STRTOUPPER($field),"GRP",$where,$periode),true);

			}
		}ELSE{
			
			if($type == "Cost"){			
				$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment2_fn(STRTOUPPER($field),"COST",$where,$periode),true);
				
			}elseif($type == "Spot"){
				$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment2_fn(STRTOUPPER($field),"SPOT",$where,$periode),true);

			}elseif($type == "GRP"){
				$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment2_fn(STRTOUPPER($field),"GRP",$where,$periode),true);

			}
			
		}
 
		
		echo json_encode($data['programs'],true);
		
	}
	
	
	function cost_by_program2(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$periode=$tahun;
	 
		
		if($type == "Cost"){			
			$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment_f(STRTOUPPER($field),"COST",$where,$periode),true);
			
		}elseif($type == "Spot"){
			$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment_f(STRTOUPPER($field),"SPOT",$where,$periode),true);

		}elseif($type == "GRP"){
			$data['programs'] = json_encode($this->Tvpostbuyu_model->proc_get_segment_f(STRTOUPPER($field),"GRP",$where,$periode),true);

		}
 
		
		echo json_encode($data['programs'],true);
		
	}
	
	
	function pie1_view(){
		$type =  $this->input->post('type');
		$where =  $this->input->post('cond');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$periode=$tahun;
		
		if($type == "Cost"){			
			$data['programs'] = json_encode($this->Tvpostbuyu_model->list_cost_by_loose_all($where,$periode),true);
		}elseif($type == "Spot"){
			$data['programs'] = json_encode($this->Tvpostbuyu_model->list_spot_by_loose_all($where,$periode),true);
		}elseif($type == "GRP"){
			$data['programs'] = json_encode($this->Tvpostbuyu_model->list_grp_by_loose_all($where,$periode),true);
		}
		
		echo json_encode($data['programs'],true);
	}
	
	
	function ambildata(){
 		$hasil = $this->Tvpostbuyu_model->ambildata();
		if($hasil){
			echo "Sukses";
		}else{
			echo "Gagal";
		}
	}
}
