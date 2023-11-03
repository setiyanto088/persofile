<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvpostbuyu3resp22 extends JA_Controller {
  public function __construct()
	{
		parent::__construct();		
				
		$this->load->model('Tvpostbuyu_model');
	}
	
	
	public function filter(){
		
		$filter = $this->Anti_si($this->input->post('filter_text',true));
		$filter2 = $this->Anti_si($this->input->post('filter_text2',true));
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
		$array_month = ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
 		$data['thn'] = $this->Tvpostbuyu_model->get_tahun();
		$array_nn = [];
		
		$as = 0;
		foreach($data['thn'] as $sss){
			
 			
			$splitt = explode('-',$sss['tahun']);
			
 			$array_nn[$as]['tahun'] = $splitt[0].'-'.$array_month[$splitt[1]];
			
			$as++;
		}
		$data['thn'] = $array_nn;
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$user=$this->input->post('user');
 		
		$databln = $this->Tvpostbuyu_model->get_curr_bulan();
		if (!isset($tahun)){
			$tahun="2017";
		
			$tahun=$data['thn'][0]['tahun'];
		 
		}
		
		
		if (!isset($user)){
			$user="0";
		 
		}
		$periode=$tahun;
		 
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		$data['userselected'] = $user;
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
 		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		
		
		$data['profiless'] = $this->Tvpostbuyu_model->get_profile($iduser,$idrole,"");
	
 		$data['cond'] = $where;
		$data['profile'] = $this->Tvpostbuyu_model->list_profile();
		$data['channel'] = $this->Tvpostbuyu_model->list_spot_by_chanel_all('SPOT',$where,$periode,$user);
	 
		$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_daytime_all('SPOT',$where,$periode,$user);

		$data['date'] = $this->Tvpostbuyu_model->list_spot_by_date_all('SPOT',$where,$periode,$user);

		foreach($data['channel'] as $datax){
			$data_ch[] = '"'.$datax['CHANNEL'].'"';
			$spot_ch[] = $datax['SPOT'];
			
		}

		$prime = 0;
		$nprime = 0;
		
		foreach($data['daytime'] as $datass){
			$data_daytime[] = '"'.$datass['DAYPART'].'"';
			$spot_daytime[] = $datass['spot'];
			
			if($datass['DAYPART'] == "18:00 - 22:00"){
				$prime = $prime + $datass['spot'];
			}else{
				$nprime = $nprime + $datass['spot'];
			}
		}
		

		foreach($data['date'] as $datasss){
			$data_date[] = '"'.$datasss['DATE'].'"';
			$spot_date[] = $datasss['spot'];
		}
				
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
 		$data['products'] = json_encode($this->Tvpostbuyu_model->list_spot_by_program_all("NAMA_BRAND","SPOT",$where,$periode,$user),true);
		$data['programs'] = json_encode($this->Tvpostbuyu_model->list_spot_by_program_all2n("PROGRAM","SPOT",$where,$periode,$user),true);

		$data['costspot2'] = $this->Tvpostbuyu_model->list_cost_alls_dtv($where,$periode,$user);

		$data['json_channel'] = $data_ch;
		$data['json_spot'] = $spot_ch;
		
		 
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		
 		
		$this->template->load('maintemplate', 'tvpostbuyu3resp22/views/Tvpostbuyu', $data);
	}
	
	function cost_by_channel(){
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$user=$this->Anti_si($this->input->post('user',true));
		$periode=$tahun;
 		
		if($type == "Cost"){
			$data['channel'] = $this->Tvpostbuyu_model->list_spot_by_chanel_all('COST',$where,$periode,$user);
			
			foreach($data['channel'] as $datax){
				$data_ch['cat'][] = $datax['CHANNEL'];
				$data_ch['data'][] = $datax['COST'];
			}
		 
			
			
		}elseif($type == "Spot"){
			$data['channel'] = $this->Tvpostbuyu_model->list_spot_by_chanel_all('SPOT',$where,$periode,$user);
			
			foreach($data['channel'] as $datax){
				$data_ch['cat'][] = $datax['CHANNEL'];
				$data_ch['data'][] = $datax['SPOT'];
			}
		 
		}elseif($type == "GRP"){
			$data['channel'] = $this->Tvpostbuyu_model->list_spot_by_chanel_all('VIEWERS',$where,$periode,$user);
			if ($data['channel'] == null){
				$data_ch['cat'][] = 0;
				$data_ch['data'][] = 0;
			} else {
				foreach($data['channel'] as $datax){
					$data_ch['cat'][] = $datax['CHANNEL'];
					$data_ch['data'][] = $datax['VIEWERS'];
				}
			 
			}
			
		}
		
		
		
		echo json_encode($data_ch,true);
	}
	
	function cost_by_channelASAS(){
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$periode=$tahun;
 		
		if($type == "Cost"){
			$data['channel'] = $this->Tvpostbuyu_model->proc_get_cost_by_channel_all($where,$periode);
			
			foreach($data['channel'] as $datax){
				$data_ch['cat'][] = $datax['CHANNEL'];
				$data_ch['data'][] = $datax['rt'];
			}
		 
			
			
		}elseif($type == "Spot"){
			$data['channel'] = $this->Tvpostbuyu_model->list_spot_by_chanel_all($where,$periode);
			
			foreach($data['channel'] as $datax){
				$data_ch['cat'][] = $datax['CHANNEL'];
				$data_ch['data'][] = $datax['spot'];
			}
		 
		}elseif($type == "GRP"){
			$data['channel'] = $this->Tvpostbuyu_model->list_grp_by_chanel_all($where,$periode);
			if ($data['channel'] == null){
				$data_ch['cat'][] = 0;
				$data_ch['data'][] = 0;
			} else {
				foreach($data['channel'] as $datax){
					$data_ch['cat'][] = $datax['CHANNEL'];
					$data_ch['data'][] = $datax['grp'];
				}
				array_push($data_ch['cat'], "RCTI", "GTV","OCHNL","MNCTV","INEWSTV");
				array_push($data_ch['data'], 0, 0,0,0,0);
			}
			
		}
		
		
		
		echo json_encode($data_ch,true);
	}
	
	function ads_view(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$periode=$tahun;
	 
			
		if($type == "Cost"){
			$data['programs'] = $this->Tvpostbuyu_model->proc_get_cost_by_program_all($field,$where,$periode);
			
			foreach($data['programs'] as $datax){
				$data_ch['cat'][] = $datax['type'];
				$data_ch['data'][] = $datax['Cost'];
			}
		
		}elseif($type == "Spot"){
			$data['programs'] = $this->Tvpostbuyu_model->list_spot_by_program_all($field,$where,$periode);
			
			foreach($data['programs'] as $datax){
				$data_ch['cat'][] = $datax['type'];
				$data_ch['data'][] = $datax['Spot'];
			}
		}
		elseif($type == "GRP"){
			$data['programs'] = $this->Tvpostbuyu_model->list_grp_by_program_all('type',$where,$periode);
			if ($data['programs'] == null){
				$data_ch['cat'][] = 0;
				$data_ch['data'][] = 0;
			} else {
				foreach($data['programs'] as $datax){
				$data_ch['cat'][] = $datax['type'];
				$data_ch['data'][] = $datax['GRP'];
				}
			}
			
		}
		
		
		
		echo json_encode($data_ch,true);
	}
	
	function day_view(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$user=$this->Anti_si($this->input->post('user',true));
		$periode=$tahun;
		
		if($type == "Cost"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_date_all('COST',$where,$periode,$user);
			
			foreach($data['daytime'] as $datass){
				$data_ch['cat'][] = $datass['DATE'];
				$data_ch['data'][] = $datass['spot'];
			}
		
		}elseif($type == "Spot"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_date_all('SPOT',$where,$periode,$user);
			
				foreach($data['daytime'] as $datasss){
				$data_ch['cat'][] = $datasss['DATE'];
				$data_ch['data'][] = $datasss['spot'];
			}
		}elseif($type == "GRP"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_date_all('VIEWERS',$where,$periode,$user);
				if ($data['daytime'] == null) {
					$data_ch['cat'][] = 0;
					$data_ch['data'][] = 0;
				} else {
					foreach($data['daytime'] as $datasss){
						$data_ch['cat'][] = $datasss['DATE'];
						$data_ch['data'][] = $datasss['spot'];
					}
				}
		}
		
		
		
		echo json_encode($data_ch,true);
		
	}
	
	function daypart_view(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$user=$this->Anti_si($this->input->post('user',true));
		$periode=$tahun;
		
		if($type == "Cost"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_daytime_all('COST',$where,$periode,$user);
			
			foreach($data['daytime'] as $datass){
				$data_ch['cat'][] = $datass['DAYPART'];
				$data_ch['data'][] = $datass['spot'];
			}
		
		}elseif($type == "Spot"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_daytime_all('SPOT',$where,$periode,$user);
			
			foreach($data['daytime'] as $datass){
				$data_ch['cat'][] = $datass['DAYPART'];
				$data_ch['data'][] = $datass['spot'];
			}
		}elseif($type == "GRP"){
			$data['daytime'] = $this->Tvpostbuyu_model->list_spot_by_daytime_all('VIEWERS',$where,$periode,$user);
			if ($data['daytime'] == null) {
				$data_ch['cat'][] = 0;
				$data_ch['data'][] = 0;
			} else {
				foreach($data['daytime'] as $datass){
					$data_ch['cat'][] = $datass['DAYPART'];
					$data_ch['data'][] = $datass['spot'];
				}
			}
		}
		echo json_encode($data_ch,true);
	}
	
	function prime_view(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
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
	
	
	function cost_by_program2nn(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$user=$this->Anti_si($this->input->post('user',true));
		$periode=$tahun;
	 
		
		if($type == "Cost"){			
			$data['programs'] = $this->Tvpostbuyu_model->list_spot_by_program_all2n($field,"COST",$where,$periode,$user);
			
		}elseif($type == "Spot"){
			$data['programs'] = $this->Tvpostbuyu_model->list_spot_by_program_all2n($field,"SPOT",$where,$periode,$user);

		}elseif($type == "GRP"){
			$data['programs'] = $this->Tvpostbuyu_model->list_spot_by_program_all2n($field,"VIEWERS",$where,$periode,$user);

		}
		
 		
		$arr_data = [];
		$ii=0;
		foreach($data['programs'] as $ddd){
			
			$arr_data[$ii][] = $ddd['CHANNEL'];
			$arr_data[$ii][] = $ddd['NAME'];
			$arr_data[$ii][] = $ddd['spots'];
			
			$ii++;
		}
 
		echo json_encode(json_encode($arr_data,true),true);
		
	}
	
	function cost_by_program2(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$user=$this->Anti_si($this->input->post('user',true));
		$periode=$tahun;
	 
		if($type == "Cost"){			
			$data['programs'] = $this->Tvpostbuyu_model->list_spot_by_program_all($field,"COST",$where,$periode,$user);
		
		}elseif($type == "Spot"){
			$data['programs'] = $this->Tvpostbuyu_model->list_spot_by_program_all($field,"SPOT",$where,$periode,$user);

		}elseif($type == "GRP"){
			$data['programs'] = $this->Tvpostbuyu_model->list_spot_by_program_all($field,"VIEWERS",$where,$periode,$user);

		}
 		
		$arr_data = [];
		$ii=0;
		foreach($data['programs'] as $ddd){
			
			$arr_data[$ii][] = $ddd['NAME'];
			$arr_data[$ii][] = $ddd['spots'];
			
			$ii++;
		}
		
 		
		echo json_encode(json_encode($arr_data,true),true);
		
	}
	
	
	function pie1_view(){
		$type =  $this->Anti_si($this->input->post('type',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
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
