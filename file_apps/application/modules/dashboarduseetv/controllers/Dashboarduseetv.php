<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboarduseetv extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}

	
	public function filter_program(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR','O CHANNEL')";
				
			}else{
				
				$where = "";
				
				
			}
			
			$arr_regional = ['01','02','03','04','05','06','07'];
		
			$array_view = array();
			$array_view[0]["RANK"] = 1;
			$array_view[1]["RANK"] = 2;
			$array_view[2]["RANK"] = 3;
			$array_view[3]["RANK"] = 4;
			$array_view[4]["RANK"] = 5;
			$array_view[5]["RANK"] = 6;
			$array_view[6]["RANK"] = 7;
			$array_view[7]["RANK"] = 8;
			$array_view[8]["RANK"] = 9;
			$array_view[9]["RANK"] = 10;

			$ta = 0;
			foreach($arr_regional as $arr_reg){
				
				$rank_reg = $this->tvprogramun_model->list_rank_prog($periode,$arr_reg,$where);
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr][$arr_reg.'_PROGRAM'] = $rank_regs['PROGRAM'];
					$array_view[$tr][$arr_reg.'_CHANNEL'] = $rank_regs['CHANNEL'];
					$tr++;
				}
				$ta++;
				
			}
			
			$data['table'] = $array_view;
			
			$regionalss = 'NASIONAL';
			
			$rank_prog_chart = $this->tvprogramun_model->list_rank_prog_nas($periode,$regionalss,$where);
		
			$field_prog = array();
			$value_prog = array();
			
			foreach($rank_prog_chart as $rank_prog_chartss){
				
				$field_prog[] = $rank_prog_chartss['PROGRAM'];
				$value_prog[] = intval($rank_prog_chartss['VIEWERS']);
				
			}
			
			$data['field_prog'] = $field_prog;
			$data['value_prog'] = $value_prog;
			
			
			echo json_encode($data,true);
			
		
	}
	
	public function filter_program_nas(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR','O CHANNEL')";
				
			}else{
				
				$where = "";
				
				
			}
			
			$arr_regional = ['01','02','03','04','05','06','07'];
		
			$array_view = array();
			$array_view[0]["RANK"] = 1;
			$array_view[1]["RANK"] = 2;
			$array_view[2]["RANK"] = 3;
			$array_view[3]["RANK"] = 4;
			$array_view[4]["RANK"] = 5;
			$array_view[5]["RANK"] = 6;
			$array_view[6]["RANK"] = 7;
			$array_view[7]["RANK"] = 8;
			$array_view[8]["RANK"] = 9;
			$array_view[9]["RANK"] = 10;

			$ta = 0;
				
				$rank_reg = $this->tvprogramun_model->list_rank_prog_nas($periode,'',$where);
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr]['01_PROGRAM'] = $rank_regs['PROGRAM'];
					$array_view[$tr]['01_CHANNEL'] = $rank_regs['CHANNEL'];
					$tr++;
				}
				$ta++;
				
			
			
			$data['table'] = $array_view;
			
			$regionalss = 'NASIONAL';
			
			$rank_prog_chart = $this->tvprogramun_model->list_rank_prog_nas($periode,'',$where);
		
			$field_prog = array();
			$value_prog = array();
			
			foreach($rank_prog_chart as $rank_prog_chartss){
				
				$field_prog[] = $rank_prog_chartss['PROGRAM'];
				$value_prog[] = intval($rank_prog_chartss['VIEWERS']);
				
			}
			
			$data['field_prog'] = $field_prog;
			$data['value_prog'] = $value_prog;
			
			
			echo json_encode($data,true);
			
		
	}
	
	
	public function filter_program_detail(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			$tipe_table = $this->input->post('tipe_table');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR','O CHANNEL')";
				
			}else{
				
				$where = "";
				
				
			}
			
				
			$array_view = array();
				
				$rank_reg = $this->tvprogramun_model->list_rank_prog_nas_d($periode,'',$where);
		
				$tr = 0;
				foreach($rank_reg as $rank_regs){
				
					$array_view[$tr]['RANK'] = $tr+1;
					$array_view[$tr]['CHANNEL'] = $rank_regs['CHANNEL'];
					$array_view[$tr]['PROGRAM'] = $rank_regs['PROGRAM'];
					$tr++;
				}

		
							
				echo json_encode($array_view,true);
				

		
	}	
	
	public function filter_program_detail_a(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			$tipe_table = $this->input->post('tipe_table');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR','ANTARA TV','BERITA SATU')";
				
			}else{
				
				$where = "";
				
				
			}
			
			if($regional == "0"){
				
				$arr_regional = ['01','02','03','04','05','06','07'];
				
				$data['list_witel_h'] = $arr_regional;
				
				$max_rank = $this->tvprogramun_model->list_rank_prog_reg_all_rank_detail($periode,$where);
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_prog_reg_all_detail2($periode,$arr_reg,$where);
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['PROGRAM'])) {
							$array_view[$rt][$arr_reg.'_PROGRAM'] = $rank_reg[$rt]['PROGRAM'];
							$array_view[$rt][$arr_reg.'_CHANNEL'] = $rank_reg[$rt]['CHANNEL'];
						}else{
							$array_view[$rt][$arr_reg.'_PROGRAM'] = "";
							$array_view[$rt][$arr_reg.'_CHANNEL'] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				echo json_encode($array_view,true);
				
			}else{
			
				$list_witel = $this->tvprogramun_model->list_witel($periode,$regional);
			
				foreach($list_witel as $list_witels){
					
					$arr_regional[] = $list_witels['WITEL'];
					
				}
				
			
					$max_rank = $this->tvprogramun_model->list_rank_prog_witel_all_rank_detail($periode,$regional,$where);
					
					$array_view = array();
					
					for($ro = 0; $ro < $max_rank; $ro++){
						$array_view[$ro]["RANK"] = $ro+1;
					}

					$ta = 0;
					foreach($arr_regional as $arr_reg){
						
						$rank_reg = $this->tvprogramun_model->list_rank_prog_witel_all_detail($periode,$regional,$arr_reg,$where);
						$tr = 0;
							
						for($rt = 0; $rt < $max_rank; $rt++){
							
							if (isset($rank_reg[$rt]['PROGRAM'])) {
								$array_view[$rt][$arr_reg.'_PROGRAM'] = $rank_reg[$rt]['PROGRAM'];
								$array_view[$rt][$arr_reg.'_CHANNEL'] = $rank_reg[$rt]['CHANNEL'];
							}else{
								$array_view[$rt][$arr_reg.'_PROGRAM'] = "";
								$array_view[$rt][$arr_reg.'_CHANNEL'] = "";
							}
							
							$tr++;
						}
						$ta++;
						
					}
								
				
				echo json_encode($array_view,true);
			
			}

		
	}
	
	public function filter_program_reg(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR','O CHANNEL')";
				
			}else{
				
				$where = "";
				
				
			}
			
			$list_witel = $this->tvprogramun_model->list_witel($periode,$regional);
		
			foreach($list_witel as $list_witels){
				
				$arr_regional[] = $list_witels['WITEL'];
				
			}
			
		
			$array_view = array();
			$array_view[0]["RANK"] = 1;
			$array_view[1]["RANK"] = 2;
			$array_view[2]["RANK"] = 3;
			$array_view[3]["RANK"] = 4;
			$array_view[4]["RANK"] = 5;
			$array_view[5]["RANK"] = 6;
			$array_view[6]["RANK"] = 7;
			$array_view[7]["RANK"] = 8;
			$array_view[8]["RANK"] = 9;
			$array_view[9]["RANK"] = 10;

			$ta = 0;
			foreach($arr_regional as $arr_reg){
				
				$rank_reg = $this->tvprogramun_model->list_rank_prog_witel($periode,$regional,$arr_reg,$where);
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr][$arr_reg.'_PROGRAM'] = $rank_regs['PROGRAM'];
					$array_view[$tr][$arr_reg.'_CHANNEL'] = $rank_regs['CHANNEL'];
					$tr++;
				}
				$ta++;
				
			}
			
			$data['table'] = $array_view;
			
			$regionalss = $regional;
			
			$rank_prog_chart = $this->tvprogramun_model->list_rank_prog_chart($periode,$regionalss,$where);
		
			$field_prog = array();
			$value_prog = array();
			
			foreach($rank_prog_chart as $rank_prog_chartss){
				
				$field_prog[] = $rank_prog_chartss['PROGRAM'];
				$value_prog[] = intval($rank_prog_chartss['VIEWERS']);
				
			}
			
			$data['field_prog'] = $field_prog;
			$data['value_prog'] = $value_prog;
			
			
			echo json_encode($data,true);
			
		
	}
	
	public function filter_channel_detail(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			$tipe_table = $this->input->post('tipe_table');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR')";
				
			}else{
				
				$where = "";
				
				
			}
			
			
				$arr_regional = ['01','02','03','04','05','06','07'];
				
				$data['list_witel_h'] = $arr_regional;
				
				$max_rank = $this->tvprogramun_model->list_rank_channel_reg_all_rank_detail($periode,$where);
				
				$array_view = array();
				
				$rank_reg = $this->tvprogramun_model->list_rank_channel_nas_d($periode,'',$where);
		
				$tr = 0;
				foreach($rank_reg as $rank_regs){
				
					$array_view[$tr]['RANK'] = $tr+1;
					$array_view[$tr]['CHANNEL'] = $rank_regs['CHANNEL'];
					$tr++;
				}

		
							
				echo json_encode($array_view,true);
					
		
			
		
			
		
	}	
	
	public function filter_channel_detail_a(){
		
		
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			$tipe_table = $this->input->post('tipe_table');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR')";
				
			}else{
				
				$where = "";
				
				
			}
			
			if($regional == "0"){ 
			
				$arr_regional = ['01','02','03','04','05','06','07'];
				
				$data['list_witel_h'] = $arr_regional;
				
				$max_rank = $this->tvprogramun_model->list_rank_channel_reg_all_rank_detail($periode,$where);
				
				
				$maxx = (int)$max_rank[0]['MAX_RANK'];
				$array_view = array();
				
				$rrt = 1;
				for($ro = 0; $ro < $max_rank[0]['MAX_RANK']; $ro++){
					
					
					$array_view[$ro]["RANK"] = $rrt;
					
					$rrt++;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_channel_reg_all($periode,$arr_reg,$where);
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank[0]['MAX_RANK']; $rt++){
						
						if (isset($rank_reg[$rt]['CHANNEL'])) {
							$array_view[$rt][$arr_reg] = $rank_reg[$rt]['CHANNEL'];
						}else{
							$array_view[$rt][$arr_reg] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				echo json_encode($array_view,true);
					
			}else{
				
				$list_witel = $this->tvprogramun_model->list_witel($periode,$regional);
		
				foreach($list_witel as $list_witels){
					
					$arr_regional[] = $list_witels['WITEL'];
					
				}
				
				$data['list_witel_h'] = $arr_regional;
				
				$max_rank = $this->tvprogramun_model->list_rank_channel_witel_all_rank_detail($periode,$regional,$where);
				
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_channel_witel_all($periode,$regional,$arr_reg,$where);
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['CHANNEL'])) {
							$array_view[$rt][$arr_reg] = $rank_reg[$rt]['CHANNEL'];
						}else{
							$array_view[$rt][$arr_reg] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				echo json_encode($array_view,true);
				
			}
			
		
			
		
	
		
	}
	
	public function filter_channel_reg(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			
			
			if($check == "False"){
				
				$where = " AND CHANNEL NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR')";
				
			}else{
				
				$where = "";
				
				
			}
			
			
			$regionalss = $regional;
		
			$rank_reg_chart = $this->tvprogramun_model->list_rank_channel_chart($periode,$regionalss,$where);
			
			$field_channel = array();
			$value_channel = array();
			
			
			foreach($rank_reg_chart as $rank_reg_chartss){
				
				$field_channel[] = $rank_reg_chartss['CHANNEL'];
				$value_channel[] = intval($rank_reg_chartss['VIEWERS']);
				
			}
			
			$data['field_channel'] = json_encode($field_channel,true);
			$data['value_channel'] = json_encode($value_channel,true);
			
			$list_witel = $this->tvprogramun_model->list_witel($periode,$regional);
		
			foreach($list_witel as $list_witels){
				
				$arr_regional[] = $list_witels['WITEL'];
				
			}
			
		
			$array_view = array();
			$array_view[0]["RANK"] = 1;
			$array_view[1]["RANK"] = 2;
			$array_view[2]["RANK"] = 3;
			$array_view[3]["RANK"] = 4;
			$array_view[4]["RANK"] = 5;
			$array_view[5]["RANK"] = 6;
			$array_view[6]["RANK"] = 7;
			$array_view[7]["RANK"] = 8;
			$array_view[8]["RANK"] = 9;
			$array_view[9]["RANK"] = 10;

			$ta = 0;
			foreach($arr_regional as $arr_reg){
				
				$rank_reg = $this->tvprogramun_model->list_rank_channel_witel($periode,$regional,$arr_reg,$where);
				$tr = 0;
				
				for($tt = 0;$tt<10;$tt++){
					
					if(isset($rank_reg[$tt]['CHANNEL'])){
					
						$array_view[$tr][$arr_reg] = $rank_reg[$tt]['CHANNEL'];
					
					}else{
						$array_view[$tr][$arr_reg] = "-";
						
					}
					$tr++;
					
				}
				
					
				$ta++;
				
			}
			
			$data['table'] = $array_view;
			
			$data['field_channel'][0] = $field_channel;
			$data['value_channel'][0] = $value_channel;
				
			
			echo json_encode($data,true);
			
			
		
	}
	
	public function filter_channel(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR')";
				
			}else{
				
				$where = "";
				
				
			}
			
			$arr_regional = ['01','02','03','04','05','06','07'];
		
			$array_view = array();
			$array_view[0]["RANK"] = 1;
			$array_view[1]["RANK"] = 2;
			$array_view[2]["RANK"] = 3;
			$array_view[3]["RANK"] = 4;
			$array_view[4]["RANK"] = 5;
			$array_view[5]["RANK"] = 6;
			$array_view[6]["RANK"] = 7;
			$array_view[7]["RANK"] = 8;
			$array_view[8]["RANK"] = 9;
			$array_view[9]["RANK"] = 10;

			$ta = 0;
			foreach($arr_regional as $arr_reg){
				
				$rank_reg = $this->tvprogramun_model->list_rank_channel($periode,$arr_reg,$where);
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr][$arr_reg] = $rank_regs['CHANNEL'];
					$tr++;
				}
				$ta++;
				
			}
			
			$data['table'] = $array_view;
			
			$regionalss = 'NASIONAL';
		
			$rank_reg_chart = $this->tvprogramun_model->list_rank_channel_nas($periode,$regionalss,$where);
			
			$field_channel = array();
			$value_channel = array();
			
			foreach($rank_reg_chart as $rank_reg_chartss){
				
				$field_channel[] = $rank_reg_chartss['CHANNEL'];
				$value_channel[] = intval($rank_reg_chartss['VIEWERS']);
				
			}
			
			$data['field_channel'] = $field_channel;
			$data['value_channel'] = $value_channel;
				
			
			echo json_encode($data,true);
			
		
	}	
	
	public function filter_channel_nas(){
		
			$periode = $this->input->post('tahun');
			$check = $this->input->post('check');
			$regional = $this->input->post('reg');
			
			
			if($check == "False"){
				
				$where = " AND UPPER(CHANNEL) NOT IN('METRO TV','RTV','KOMPAS TV','TRANS 7','TV ONE','TRANS TV','TVRI','SCTV','ANTV','NET TV','INDOSIAR')";
				
			}else{
				
				$where = "";
				
				
			}
			
			$arr_regional = ['01','02','03','04','05','06','07'];
		
			$array_view = array();
			$array_view[0]["RANK"] = 1;
			$array_view[1]["RANK"] = 2;
			$array_view[2]["RANK"] = 3;
			$array_view[3]["RANK"] = 4;
			$array_view[4]["RANK"] = 5;
			$array_view[5]["RANK"] = 6;
			$array_view[6]["RANK"] = 7;
			$array_view[7]["RANK"] = 8;
			$array_view[8]["RANK"] = 9;
			$array_view[9]["RANK"] = 10;

			$ta = 0;
			
				
				$rank_reg = $this->tvprogramun_model->list_rank_channel_nas($periode,'',$where);
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr]['CHANNEL'] = $rank_regs['CHANNEL'];
					$tr++;
				}
				$ta++;
				
			
			
			$data['table'] = $array_view;
			
			$regionalss = 'NASIONAL';
		
			$rank_reg_chart = $this->tvprogramun_model->list_rank_channel_nas($periode,'',$where);
			
			$field_channel = array();
			$value_channel = array();
			
			foreach($rank_reg_chart as $rank_reg_chartss){
				
				$field_channel[] = $rank_reg_chartss['CHANNEL'];
				$value_channel[] = intval($rank_reg_chartss['VIEWERS']);
				
			}
			
			$data['field_channel'] = $field_channel;
			$data['value_channel'] = $value_channel;
				
			
			echo json_encode($data,true);
			
		
	}
	
	
	public function detail(){
		
	
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['channel'] = $this->tvprogramun_model->get_channel();
		
		$data['bln'] = $this->tvprogramun_model->get_bulan();
		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole);
		
		$data['file_date'] = $this->tvprogramun_model->get_file_date();
		
		
		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		
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
		
		
		
		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
		$pilihaudiencebar=$this->input->post('audiencebar');
		$pilihprog=$this->input->post('product_program');
		
		
		if (!isset($tahun)){ 
		
			
			$tahun= $data['thn'][0]['TANGGAL'];
		}
		$periode=$tahun;
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
		$data['cond'] = $where;
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['prime'] = $this->tvprogramun_model->list_spot_by_prime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		
		
		
		
		
		
		
			
		
			
		
		$prime = 0;
		$nprime = 0;
		
			
		
		if ($data['daypart'] <> null){
			foreach($data['daypart'] as $datass){
				$data_daytime[] = '"'.$datass['TIME'].'"';
				$spot_daytime[] = $datass['VIEWERS'];
			}	
		}
		else{
			$data_daytime[] = '';
			$spot_daytime[] = 0;
		}
		
		
		
		
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = '"'.$datasss['date'].'"';
				$spot_date[] = $datasss['spot'];
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
		$regional = $this->input->post('regional');
		
		
		$data['regional_text'] = $regional;
		
		
		
		$tipe_table = $this->input->post('filter');
			
		$data['tipe_table'] = $tipe_table;
		
		$arr_regional = array();
		
		if($regional == "0"){
			
			$arr_regional = ['01','02','03','04','05','06','07'];
				
			$data['list_witel_h'] = $arr_regional;
			
			if($tipe_table == 'channel'){
				
				$max_rank = $this->tvprogramun_model->list_rank_channel_reg_all_rank($periode,'');
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_channel_reg_all($periode,$arr_reg,'');
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['CHANNEL'])) {
							$array_view[$rt][$arr_reg] = $rank_reg[$rt]['CHANNEL'];
						}else{
							$array_view[$rt][$arr_reg] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				$data['channels_rank'] = json_encode($array_view,true);
				
			
			}elseif($tipe_table == 'minipack'){
				
				$max_rank = $this->tvprogramun_model->list_rank_reg_witel_all_rank($periode);
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_pack_reg_all($periode,$arr_reg);
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['MINIPACK'])) {
							$array_view[$rt][$arr_reg] = $rank_reg[$rt]['MINIPACK'];
						}else{
							$array_view[$rt][$arr_reg] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				$data['channels_rank'] = json_encode($array_view,true);
				
			
			}else{
				
				$channle_list = $this->input->post('channle_list');
				
				
					if (!isset($channle_list)){ 
		

						$list_channel= "";
						$wheres = "";
						$trakos = "";
					}else{
						
						if($channle_list == "all,"){
							
							$list_channel= "";
							$wheres = "";
							$trakos = "";
						
						
						}else{
							$trakos = "ooo";
							$arr_channel = explode(",",substr($channle_list, 0, -1));
							$wheres = " AND CHANNEL IN( ";
							
							foreach($arr_channel as $arr_channels){
								
								$wheres = $wheres."'".$arr_channels."',";
								
							}
							
							$lstr = substr($wheres, 0, -1);
							
							$wheres = $lstr." ) ";
						}
						
					}
					
					$data['trakos'] = $trakos;
				
				
				$max_rank = $this->tvprogramun_model->list_rank_prog_reg_all_rank2($periode,$wheres);
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_prog_reg_all3($periode,$arr_reg,$wheres);
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['PROGRAM'])) {
							$array_view[$rt][$arr_reg.'_RANK'] = $rank_reg[$rt]['RANK'];
							$array_view[$rt][$arr_reg.'_PROGRAM'] = $rank_reg[$rt]['PROGRAM'];
							$array_view[$rt][$arr_reg.'_CHANNEL'] = $rank_reg[$rt]['CHANNEL'];
						}else{
							$array_view[$rt][$arr_reg.'_RANK'] = "";
							$array_view[$rt][$arr_reg.'_PROGRAM'] = "";
							$array_view[$rt][$arr_reg.'_CHANNEL'] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				$data['channels_rank'] = json_encode($array_view,true);
				
			}
			
		}else{
				
			
			$list_witel = $this->tvprogramun_model->list_witel($periode,$regional);
		
		
			foreach($list_witel as $list_witels){
				
				$arr_regional[] = $list_witels['WITEL'];
				
			}
			
			$data['list_witel_h'] = $arr_regional;
			
			
			
			
			
			
			
			
			
			
			if($tipe_table == 'channel'){
				
				$max_rank = $this->tvprogramun_model->list_rank_channel_witel_all_rank($periode,$regional,'');
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_channel_witel_all($periode,$regional,$arr_reg,'');
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['CHANNEL'])) {
							$array_view[$rt][$arr_reg] = $rank_reg[$rt]['CHANNEL'];
						}else{
							$array_view[$rt][$arr_reg] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				$data['channels_rank'] = json_encode($array_view,true);
				
			
			}elseif($tipe_table == 'minipack'){
				
				$max_rank = $this->tvprogramun_model->list_rank_pack_witel_all_rank($periode,$regional);
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_pack_witel_all($periode,$regional,$arr_reg);
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['MINIPACK'])) {
							$array_view[$rt][$arr_reg] = $rank_reg[$rt]['MINIPACK'];
						}else{
							$array_view[$rt][$arr_reg] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
							
				$data['channels_rank'] = json_encode($array_view,true);
				
				
			}else{
				
				
					$channle_list = $this->input->post('channle_list');
				
				
					if (!isset($channle_list)){ 
		

						$list_channel= "";
						$wheres = "";
						$trakos = "";
					}else{
						
						if($channle_list == "all,"){
							
							$list_channel= "";
							$wheres = "";
							$trakos = "";
						
						}else{
							
							$trakos = "ooo";
						
							$arr_channel = explode(",",substr($channle_list, 0, -1));
							$wheres = " AND CHANNEL IN( ";
							
							foreach($arr_channel as $arr_channels){
								
								$wheres = $wheres."'".$arr_channels."',";
								
							}
							
							$lstr = substr($wheres, 0, -1);
							
							$wheres = $lstr." ) ";
						}
						
					}
					
					$data['trakos'] = $trakos;
				
				$max_rank = $this->tvprogramun_model->list_rank_prog_witel_all_rank_detail($periode,$regional,$wheres);
				
				$array_view = array();
				
				for($ro = 0; $ro < $max_rank; $ro++){
					$array_view[$ro]["RANK"] = $ro+1;
				}

				$ta = 0;
				foreach($arr_regional as $arr_reg){
					
					$rank_reg = $this->tvprogramun_model->list_rank_prog_witel_all_detail($periode,$regional,$arr_reg,$wheres);
					$tr = 0;
						
					for($rt = 0; $rt < $max_rank; $rt++){
						
						if (isset($rank_reg[$rt]['PROGRAM'])) {
							$array_view[$rt][$arr_reg.'_RANK'] = $rank_reg[$rt]['RANK'];
							$array_view[$rt][$arr_reg.'_PROGRAM'] = $rank_reg[$rt]['PROGRAM'];
							$array_view[$rt][$arr_reg.'_CHANNEL'] = $rank_reg[$rt]['CHANNEL'];
						}else{
							$array_view[$rt][$arr_reg.'_RANK'] = "";
							$array_view[$rt][$arr_reg.'_PROGRAM'] = "";
							$array_view[$rt][$arr_reg.'_CHANNEL'] = "";
						}
						
						$tr++;
					}
					$ta++;
					
				}
						
						
				$data['channels_rank'] = json_encode($array_view,true);
				
			}
			
		}
		
		
		
		
		
	
		
		

		
		
		
		$daily = $this->tvprogramun_model->daily($where,$periode,$pilihprog,'0');
		
		
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0"); 
		
		$dataM=$data['channels'];
		for ($i=0;$i<count($dataM);$i++){
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
		}
		
		$dataMa=$data['programsu'];
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
		
			$scamu['Date'] = $dataMa[$i]['LOG_DATE'];
			$scamu['file_name'] = "";
			$scamu['file_size'] = $dataMa[$i]['FILESIZE'];
			$scamu['row_file'] = $dataMa[$i]['ROW_COUNT_FILE'];
			$scamu['row_load'] = $dataMa[$i]['ROW_COUNT_LOAD'];
			$scamu['row_cleansing'] = $dataMa[$i]['ROW_COUNT_CLEANSING'];
			$scamu['date_load'] = $dataMa[$i]['DATE_LOAD'];
			$scamu['file_type'] = "";
			
					
			
			array_push($scamas, $scamu);
		}

		$status_array = ['Not Process','Success','Failed','On Process'];
		$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
		
		$data['programs'] = json_encode($scamas,true); 
		
		$data['detail_daily_name'] = $array_jobs_detail;
		foreach($data['channels'] as $datac){
			$data_cha[] = '"'.$datac['channel'].'"';
			$spot_cha[] = $datac['Spot'];
			
		}
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel();
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['check_stat'] = $this->tvprogramun_model->check_stat();
		
		
		$this->template->load('maintemplate_useetv', 'dashboarduseetv/views/Tvprogramun_detail', $data);
	}
	
	
	public function detail_nas(){
		
	
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['channel'] = $this->tvprogramun_model->get_channel();
		
		$data['bln'] = $this->tvprogramun_model->get_bulan();
		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole);
		
		$data['file_date'] = $this->tvprogramun_model->get_file_date();
		
		
		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		
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
		
		
		
		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
		$pilihaudiencebar=$this->input->post('audiencebar');
		$pilihprog=$this->input->post('product_program');
		
		
		if (!isset($tahun)){ 
		
			
			$tahun= $data['thn'][0]['TANGGAL'];
		}
		$periode=$tahun;
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
		$data['cond'] = $where;
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['prime'] = $this->tvprogramun_model->list_spot_by_prime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		
		
		
		
		
		
		
			
		
			
		
		$prime = 0;
		$nprime = 0;
		
			
		
		if ($data['daypart'] <> null){
			foreach($data['daypart'] as $datass){
				$data_daytime[] = '"'.$datass['TIME'].'"';
				$spot_daytime[] = $datass['VIEWERS'];
			}	
		}
		else{
			$data_daytime[] = '';
			$spot_daytime[] = 0;
		}
		
		
		
		
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = '"'.$datasss['date'].'"';
				$spot_date[] = $datasss['spot'];
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
		$regional = $this->input->post('regional');
		
		
		$data['regional_text'] = $regional;
		
		
		
		$tipe_table = $this->input->post('filter');
			
		$data['tipe_table'] = $tipe_table;
		$data['list_witel_h'] = ['01']; 
		
		$arr_regional = array();
		
		
		if($tipe_table == 'channel'){
				
				$rank_reg = $this->tvprogramun_model->list_rank_channel_nas_d($periode,'','');
		
		
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr]['RANK'] = $tr+1;
					$array_view[$tr]['CHANNEL'] = $rank_regs['CHANNEL'];
					$tr++;
				}
							
				$data['channels_rank'] = json_encode($array_view,true);
				
			
		}else if($tipe_table == 'minipack'){
				
				$rank_reg = $this->tvprogramun_model->list_rank_pack_d($periode,'NASIONAL');
		
		
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr]['RANK'] = $tr+1;
					$array_view[$tr]['CHANNEL'] = $rank_regs['MINIPACK'];
					$tr++;
				}
							
				$data['channels_rank'] = json_encode($array_view,true);
				
			
		}else{
			
				
				$rank_reg = $this->tvprogramun_model->list_rank_prog_nas_d($periode,'','');
				$tr = 0;
				foreach($rank_reg as $rank_regs){
					
					$array_view[$tr]['RANK'] = $tr+1; 
					$array_view[$tr]['PROGRAM'] = $rank_regs['PROGRAM'];
					$array_view[$tr]['CHANNEL'] = $rank_regs['CHANNEL'];
					$tr++;
				}

				
				$data['channels_rank'] = json_encode($array_view,true);
		}
		

		
		
		$daily = $this->tvprogramun_model->daily($where,$periode,$pilihprog,'0');
		
		
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0"); 
		
		$dataM=$data['channels'];
		for ($i=0;$i<count($dataM);$i++){
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
		}
		
		$dataMa=$data['programsu'];
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
		
			$scamu['Date'] = $dataMa[$i]['LOG_DATE'];
			$scamu['file_name'] = "";
			$scamu['file_size'] = $dataMa[$i]['FILESIZE'];
			$scamu['row_file'] = $dataMa[$i]['ROW_COUNT_FILE'];
			$scamu['row_load'] = $dataMa[$i]['ROW_COUNT_LOAD'];
			$scamu['row_cleansing'] = $dataMa[$i]['ROW_COUNT_CLEANSING'];
			$scamu['date_load'] = $dataMa[$i]['DATE_LOAD'];
			$scamu['file_type'] = "";
			
					
			
			array_push($scamas, $scamu);
		}

		$status_array = ['Not Process','Success','Failed','On Process'];
		$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
		
		$data['programs'] = json_encode($scamas,true); 
		
		$data['detail_daily_name'] = $array_jobs_detail;
		foreach($data['channels'] as $datac){
			$data_cha[] = '"'.$datac['channel'].'"';
			$spot_cha[] = $datac['Spot'];
			
		}
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel();
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['check_stat'] = $this->tvprogramun_model->check_stat();
		
		
		$this->template->load('maintemplate_useetv', 'dashboarduseetv/views/Tvprogramun_detail_nas', $data);
	}
	
	public function regional(){
		
	
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['bln'] = $this->tvprogramun_model->get_bulan();
		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole);
		
		$data['file_date'] = $this->tvprogramun_model->get_file_date();
		
		
		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		
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
		
		
		
		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
		$pilihaudiencebar=$this->input->post('audiencebar');
		$pilihprog=$this->input->post('product_program');
		
		
		if (!isset($tahun)){ 
		
			
			$tahun= $data['thn'][0]['TANGGAL'];
		}
		$periode=$tahun;
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
		$data['cond'] = $where;
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['prime'] = $this->tvprogramun_model->list_spot_by_prime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		
		
		
		
		
		
		
			
		
			
		
		$prime = 0;
		$nprime = 0;
		
			
		
		if ($data['daypart'] <> null){
			foreach($data['daypart'] as $datass){
				$data_daytime[] = '"'.$datass['TIME'].'"';
				$spot_daytime[] = $datass['VIEWERS'];
			}	
		}
		else{
			$data_daytime[] = '';
			$spot_daytime[] = 0;
		}
		
		
		
		
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = '"'.$datasss['date'].'"';
				$spot_date[] = $datasss['spot'];
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
		if($this->session->userdata('id_unit') == '0'){
		
			$regional = $this->input->post('regional');
		
		}else{
			$regional = '0'.$this->session->userdata('id_unit');
			
		}
		
		$data['regional_text'] = $regional;
		
		
		
		$regionalss = $regional;
		
		$rank_reg_chart = $this->tvprogramun_model->list_rank_channel_chart($periode,$regionalss,'');
		
		$field_channel = array();
		$value_channel = array();
		
		foreach($rank_reg_chart as $rank_reg_chartss){
			
			$field_channel[] = $rank_reg_chartss['CHANNEL'];
			$value_channel[] = intval($rank_reg_chartss['VIEWERS']);
			
		}
		
		$data['field_channel'] = json_encode($field_channel,true);
		$data['value_channel'] = json_encode($value_channel,true);
		
		
		
		
		$rank_pact_chart = $this->tvprogramun_model->list_rank_pack_chart($periode,$regionalss,'');
		
		$field_pact = array();
		$value_pact = array();
		
		foreach($rank_pact_chart as $rank_pact_chartss){
			
			$field_pact[] = $rank_pact_chartss['MINIPACK'];
			$value_pact[] = intval($rank_pact_chartss['VIEWERS']);
			
		}
		
		$data['field_pact'] = json_encode($field_pact,true);
		$data['value_pact'] = json_encode($value_pact,true);
		
		
		
		$rank_prog_chart = $this->tvprogramun_model->list_rank_prog_chart($periode,$regionalss,'');
		
		$field_prog = array();
		$value_prog = array();
		
		foreach($rank_prog_chart as $rank_prog_chartss){
			
			$field_prog[] = $rank_prog_chartss['PROGRAM'];
			$value_prog[] = intval($rank_prog_chartss['VIEWERS']);
			
		}
		
		$data['field_prog'] = json_encode($field_prog,true);
		$data['value_prog'] = json_encode($value_prog,true);
		
		
		
		$list_witel = $this->tvprogramun_model->list_witel($periode,$regional);
		
		
		foreach($list_witel as $list_witels){
			
			$arr_regional[] = $list_witels['WITEL'];
			
		}
		
		$data['list_witel_h'] = $arr_regional;
		
		$max_rank = 10;
		
		
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_channel_witel($periode,$regional,$arr_reg,'');
			$tr = 0;
			for($rt = 0; $rt < $max_rank; $rt++){
				
				if (isset($rank_reg[$rt]['CHANNEL'])) {
					$array_view[$rt][$arr_reg] = $rank_reg[$rt]['CHANNEL'];
				}else{
					$array_view[$rt][$arr_reg] = "";
				}
				 
				$tr++;
			}
			$ta++;
			
		}
		
		
		$data['channels_rank'] = json_encode($array_view,true);
		
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_pack_witel($periode,$regional,$arr_reg);
			$tr = 0;
				
				for($rt = 0; $rt < $max_rank; $rt++){
					
					if (isset($rank_reg[$rt]['MINIPACK'])) {
							$array_view[$rt][$arr_reg] = $rank_reg[$rt]['MINIPACK'];
					}else{
							$array_view[$rt][$arr_reg] = "";
					}
					
					$tr++;
				}
				
				
				
				
			
			
			$ta++;
			
		}
		
		$data['minipack_rank'] = json_encode($array_view,true);
		
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_prog_witel($periode,$regional,$arr_reg,'');
			$tr = 0;
				
			for($rt = 0; $rt < $max_rank; $rt++){
				
				if (isset($rank_reg[$rt]['PROGRAM'])) {
					$array_view[$tr][$arr_reg.'_PROGRAM'] = $rank_reg[$rt]['PROGRAM'];
					$array_view[$tr][$arr_reg.'_CHANNEL'] = $rank_reg[$rt]['CHANNEL'];
				}else{
					$array_view[$tr][$arr_reg.'_PROGRAM'] = '';
					$array_view[$tr][$arr_reg.'_CHANNEL'] = '';
				}
				
				$tr++;
			}
			$ta++;
			
		}
		
		
		$data['program_rank'] = json_encode($array_view,true);
		
		
		
		$daily = $this->tvprogramun_model->daily($where,$periode,$pilihprog,'0');
		
		
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0"); 
		
		$dataM=$data['channels'];
		for ($i=0;$i<count($dataM);$i++){
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
		}
		
		$dataMa=$data['programsu'];
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
		
			$scamu['Date'] = $dataMa[$i]['LOG_DATE'];
			$scamu['file_name'] = "";
			$scamu['file_size'] = $dataMa[$i]['FILESIZE'];
			$scamu['row_file'] = $dataMa[$i]['ROW_COUNT_FILE'];
			$scamu['row_load'] = $dataMa[$i]['ROW_COUNT_LOAD'];
			$scamu['row_cleansing'] = $dataMa[$i]['ROW_COUNT_CLEANSING'];
			$scamu['date_load'] = $dataMa[$i]['DATE_LOAD'];
			$scamu['file_type'] = "";
			
					
			
			array_push($scamas, $scamu);
		}

		$status_array = ['Not Process','Success','Failed','On Process'];
		$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
		
		$data['programs'] = json_encode($scamas,true); 
		
		$data['detail_daily_name'] = $array_jobs_detail;
		foreach($data['channels'] as $datac){
			$data_cha[] = '"'.$datac['channel'].'"';
			$spot_cha[] = $datac['Spot'];
			
		}
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel();
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['check_stat'] = $this->tvprogramun_model->check_stat();
		
		
		$this->template->load('maintemplate_useetv', 'dashboarduseetv/views/Tvprogramun_reg', $data);
	}		
	
	
	  public function regional_full()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['bln'] = $this->tvprogramun_model->get_bulan();
		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole);
		
		$data['file_date'] = $this->tvprogramun_model->get_file_date();
		
		
		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		
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
		
		
		
		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
		$pilihaudiencebar=$this->input->post('audiencebar');
		$pilihprog=$this->input->post('product_program');
		
		
		if (!isset($tahun)){ 
		
			
			$tahun= $data['thn'][0]['TANGGAL'];
		}
		$periode=$tahun;
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
		$data['cond'] = $where;
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['prime'] = $this->tvprogramun_model->list_spot_by_prime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		
		
		
		
		
		
		
		
		
			
		
			
		
		$prime = 0;
		$nprime = 0;
		
			
		
		if ($data['daypart'] <> null){
			foreach($data['daypart'] as $datass){
				$data_daytime[] = '"'.$datass['TIME'].'"';
				$spot_daytime[] = $datass['VIEWERS'];
			}	
		}
		else{
			$data_daytime[] = '';
			$spot_daytime[] = 0;
		}
		
		
		
		
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = '"'.$datasss['date'].'"';
				$spot_date[] = $datasss['spot'];
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
		$regionalss = 'NASIONAL';
		
		$rank_reg_chart = $this->tvprogramun_model->list_rank_channel_chart($periode,$regionalss,'');
		
		$field_channel = array();
		$value_channel = array();
		
		foreach($rank_reg_chart as $rank_reg_chartss){
			
			$field_channel[] = $rank_reg_chartss['CHANNEL'];
			$value_channel[] = intval($rank_reg_chartss['VIEWERS']);
			
		}
		
		$data['field_channel'] = json_encode($field_channel,true);
		$data['value_channel'] = json_encode($value_channel,true);
		
		
		
		$rank_pact_chart = $this->tvprogramun_model->list_rank_pack_chart($periode,$regionalss,'');
		
		$field_pact = array();
		$value_pact = array();
		
		foreach($rank_pact_chart as $rank_pact_chartss){
			
			$field_pact[] = $rank_pact_chartss['MINIPACK'];
			$value_pact[] = intval($rank_pact_chartss['VIEWERS']);
			
		}
		
		$data['field_pact'] = json_encode($field_pact,true);
		$data['value_pact'] = json_encode($value_pact,true);
		
		
		
		$rank_prog_chart = $this->tvprogramun_model->list_rank_prog_chart($periode,$regionalss,'');
		
		$field_prog = array();
		$value_prog = array();
		
		foreach($rank_prog_chart as $rank_prog_chartss){
			
			$field_prog[] = $rank_prog_chartss['PROGRAM'];
			$value_prog[] = intval($rank_prog_chartss['VIEWERS']);
			
		}
		
		$data['field_prog'] = json_encode($field_prog,true);
		$data['value_prog'] = json_encode($value_prog,true);
		
		
		
		
		$arr_regional = ['01','02','03','04','05','06','07'];
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_channel($periode,$arr_reg,'');
			$tr = 0;
			foreach($rank_reg as $rank_regs){
				
				$array_view[$tr][$arr_reg] = $rank_regs['CHANNEL'];
				$tr++;
			}
			$ta++;
			
		}
		
		
		$data['channels_rank'] = json_encode($array_view,true);
		
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_pack($periode,$arr_reg);
			$tr = 0;
			
			for($tt = 0;$tt<10;$tt++){
				
				if(isset($rank_reg[$tt]['MINIPACK'])){
				
					$array_view[$tr][$arr_reg] = $rank_reg[$tt]['MINIPACK'];
				
				}else{
					$array_view[$tr][$arr_reg] = "-";
					
				}
				$tr++;
				
			}
			
				
			$ta++;
			
		}
		
		
		$data['minipack_rank'] = json_encode($array_view,true);
		
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_prog($periode,$arr_reg,'');
			$tr = 0;
			foreach($rank_reg as $rank_regs){
				
				$array_view[$tr][$arr_reg.'_PROGRAM'] = $rank_regs['PROGRAM'];
				$array_view[$tr][$arr_reg.'_CHANNEL'] = $rank_regs['CHANNEL'];
				$tr++;
			}
			$ta++;
			
		}
		
		
		$data['program_rank'] = json_encode($array_view,true);
		
		
		
		$daily = $this->tvprogramun_model->daily($where,$periode,$pilihprog,'0');
		
		
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0"); 
		
		$dataM=$data['channels'];
		for ($i=0;$i<count($dataM);$i++){
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
		}
		
		$dataMa=$data['programsu'];
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
		
			$scamu['Date'] = $dataMa[$i]['LOG_DATE'];
			$scamu['file_name'] = "";
			$scamu['file_size'] = $dataMa[$i]['FILESIZE'];
			$scamu['row_file'] = $dataMa[$i]['ROW_COUNT_FILE'];
			$scamu['row_load'] = $dataMa[$i]['ROW_COUNT_LOAD'];
			$scamu['row_cleansing'] = $dataMa[$i]['ROW_COUNT_CLEANSING'];
			$scamu['date_load'] = $dataMa[$i]['DATE_LOAD'];
			$scamu['file_type'] = "";
			
					
			
			array_push($scamas, $scamu);
		}

		$status_array = ['Not Process','Success','Failed','On Process'];
		$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
		
		$data['programs'] = json_encode($scamas,true); 
		
		$data['detail_daily_name'] = $array_jobs_detail;
		foreach($data['channels'] as $datac){
			$data_cha[] = '"'.$datac['channel'].'"';
			$spot_cha[] = $datac['Spot'];
			
		}
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel();
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['check_stat'] = $this->tvprogramun_model->check_stat();
		
		if($this->session->userdata('id_unit') == '0'){
			$this->template->load('maintemplate_useetv', 'dashboarduseetv/views/Tvprogramun', $data);
		}else{
			$this->regional();
		}
		
		
	}
	
	
  public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['bln'] = $this->tvprogramun_model->get_bulan();
		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole);
		
		$data['file_date'] = $this->tvprogramun_model->get_file_date();
		
		
		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		
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
		
		
		
		
		
		$tahun=$this->input->post('tahun');
		
		
		$bulan=$this->input->post('bulan');
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
		$pilihaudiencebar=$this->input->post('audiencebar');
		$pilihprog=$this->input->post('product_program');
		
		
		if (!isset($tahun)){ 
		
			
			$tahun= $data['thn'][0]['TANGGAL'];
		}
		$periode=$tahun;
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
		$data['cond'] = $where;
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['prime'] = $this->tvprogramun_model->list_spot_by_prime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] =[];
		
		
		
		
		
		
		
		
		
			
		
			
		
		$prime = 0;
		$nprime = 0;
		
			
		
		if ($data['daypart'] <> null){
			foreach($data['daypart'] as $datass){
				$data_daytime[] = '"'.$datass['TIME'].'"';
				$spot_daytime[] = $datass['VIEWERS'];
			}	
		}
		else{
			$data_daytime[] = '';
			$spot_daytime[] = 0;
		}
		
		
		
		
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = '"'.$datasss['date'].'"';
				$spot_date[] = $datasss['spot'];
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
		$data['programsu'] =[];
		
		$regionalss = 'NASIONAL';
		
		$rank_reg_chart = $this->tvprogramun_model->list_rank_channel_chart($periode,$regionalss,'');
		
		$field_channel = array();
		$value_channel = array();
		
		foreach($rank_reg_chart as $rank_reg_chartss){
			
			$field_channel[] = $rank_reg_chartss['CHANNEL'];
			$value_channel[] = intval($rank_reg_chartss['VIEWERS']);
			
		}
		
		$data['field_channel'] = json_encode($field_channel,true);
		$data['value_channel'] = json_encode($value_channel,true);
		
		
		
		$rank_pact_chart = $this->tvprogramun_model->list_rank_pack_chart($periode,$regionalss,'');
		
		$field_pact = array();
		$value_pact = array();
		
		foreach($rank_pact_chart as $rank_pact_chartss){
			
			$field_pact[] = $rank_pact_chartss['MINIPACK'];
			$value_pact[] = intval($rank_pact_chartss['VIEWERS']);
			
		}
		
		$data['field_pact'] = json_encode($field_pact,true);
		$data['value_pact'] = json_encode($value_pact,true);
		
		
		
		$rank_prog_chart = $this->tvprogramun_model->list_rank_prog_chart($periode,$regionalss,'');
		
		$field_prog = array();
		$value_prog = array();
		
		foreach($rank_prog_chart as $rank_prog_chartss){
			
			$field_prog[] = $rank_prog_chartss['PROGRAM'];
			$value_prog[] = intval($rank_prog_chartss['VIEWERS']);
			
		}
		
		$data['field_prog'] = json_encode($field_prog,true);
		$data['value_prog'] = json_encode($value_prog,true);
		
		
		
		
		$arr_regional = ['CHANNEL'];
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
	
		$rank_reg = $this->tvprogramun_model->list_rank_channel_nas($periode,'','');
		
		$tr = 0;
			foreach($rank_reg as $rank_regs){
				
				$array_view[$tr]['CHANNEL'] = $rank_regs['CHANNEL'];
				$tr++;
			}

		
		
		$data['channels_rank'] = json_encode($array_view,true);
		
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_pack($periode,'NASIONAL');
			$tr = 0;
			
			for($tt = 0;$tt<10;$tt++){
				
				if(isset($rank_reg[$tt]['MINIPACK'])){
				
					$array_view[$tr]['NASIONAL'] = $rank_reg[$tt]['MINIPACK'];
				
				}else{
					$array_view[$tr]['NASIONAL'] = "-";
					
				}
				$tr++;
				
			}
			
				
			$ta++;
			
		}
		
		
		$data['minipack_rank'] = json_encode($array_view,true);
		
		
		$array_view = array();
		$array_view[0]["RANK"] = 1;
		$array_view[1]["RANK"] = 2;
		$array_view[2]["RANK"] = 3;
		$array_view[3]["RANK"] = 4;
		$array_view[4]["RANK"] = 5;
		$array_view[5]["RANK"] = 6;
		$array_view[6]["RANK"] = 7;
		$array_view[7]["RANK"] = 8;
		$array_view[8]["RANK"] = 9;
		$array_view[9]["RANK"] = 10;

		$ta = 0;
		foreach($arr_regional as $arr_reg){
			
			$rank_reg = $this->tvprogramun_model->list_rank_prog_nas($periode,$arr_reg,'');
			$tr = 0;
			foreach($rank_reg as $rank_regs){
				
				$array_view[$tr]['01_PROGRAM'] = $rank_regs['PROGRAM'];
				$array_view[$tr]['01_CHANNEL'] = $rank_regs['CHANNEL'];
				$tr++;
			}
			$ta++;
			
		}
		
		
		$data['program_rank'] = json_encode($array_view,true);
		
		
		
		
		
		
		$data['channels'] = [];
		
		$dataM=$data['channels'];
		for ($i=0;$i<count($dataM);$i++){
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
		}
		
		$dataMa=$data['programsu'];
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
		
			$scamu['Date'] = $dataMa[$i]['LOG_DATE'];
			$scamu['file_name'] = "";
			$scamu['file_size'] = $dataMa[$i]['FILESIZE'];
			$scamu['row_file'] = $dataMa[$i]['ROW_COUNT_FILE'];
			$scamu['row_load'] = $dataMa[$i]['ROW_COUNT_LOAD'];
			$scamu['row_cleansing'] = $dataMa[$i]['ROW_COUNT_CLEANSING'];
			$scamu['date_load'] = $dataMa[$i]['DATE_LOAD'];
			$scamu['file_type'] = "";
			
					
			
			array_push($scamas, $scamu);
		}

		$status_array = ['Not Process','Success','Failed','On Process'];
		$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
		
		$data['programs'] = json_encode($scamas,true); 
		
		$data['detail_daily_name'] = $array_jobs_detail;
		foreach($data['channels'] as $datac){
			$data_cha[] = '"'.$datac['channel'].'"';
			$spot_cha[] = $datac['Spot'];
			
		}
		
		
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel();
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['check_stat'] = $this->tvprogramun_model->check_stat();
		
		if($this->session->userdata('id_unit') == '0'){
			$this->template->load('maintemplate_useetv', 'dashboarduseetv/views/Tvprogramun_nas', $data);
		}else{
			$this->regional();
		}
		
		
	}	
	
	function insert_queue_rep_f(){
		
		$date_data =  $this->input->post('date_data');
		$type_jobs =  $this->input->post('type_jobs');
		
		
		$this->tvprogramun_model->insert_queue_f($date_data,$type_jobs);
		
		
		
		$periode =  date_format(date_create($date_data),"Y-F");
		
		$data['programs'] = $this->tvprogramun_model->filter_table("Program",$periode,$type_jobs);
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];

		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					
					if($datax['FILE_TYPE'] == 0){
						$ft = 'Original';
					}else if($datax['FILE_TYPE'] == 99){
						$ft = 'File Not Found';
					}else{
						$ft = 'Rev '.$datax['FILE_TYPE'];
					}
					
					$fn = explode("/",$datax['FILE_NAME']);
					
					$data_ch[$ik]['Date'] = $datax['LOG_DATE'];
					$data_ch[$ik]['file_name'] = end($fn);
					$data_ch[$ik]['file_size'] = $datax['FILESIZE'];
					$data_ch[$ik]['row_file'] = $datax['ROW_COUNT_FILE'];
					$data_ch[$ik]['row_load'] = $datax['ROW_COUNT_LOAD'];
					$data_ch[$ik]['row_cleansing'] = $datax['ROW_COUNT_CLEANSING'];
					$data_ch[$ik]['date_load'] = $datax['DATE_LOAD'];
					$data_ch[$ik]['file_type'] = $ft;
					
					if($datax['STATUS_FILE'] == 3){
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onqueue(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Process</button>";
					}else{
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br>".$datax['NOTE'];
					}
					
					
					
					if($datax['STATUS_FILE'] == 1){
						
						if($datax['STATUS_J'] == 1 ){
							$data_ch[$ik]['check_data'] = "<span style='color:blue'><strong>Checked</strong></span>";
						}elseif($datax['STATUS_J'] == 2 ){
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onreproc_f(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Reprocess</button>";
						}elseif($datax['STATUS_J'] == 3 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Checking</strong></span>";
							
						}elseif($datax['STATUS_J'] == 4 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Queue</strong></span>";
							
						}else{
						
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='checkdata_day(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Check Data</button>";
						}
						
					}else{
						$data_ch[$ik]['check_data']  = "";
					}
					
					$i++;
					$ik++;
				}
		} else {
			$data_ch = null;
		}
		
		echo json_encode($data_ch,true);
		
		
		
	}

	function insert_queue_rep(){
		
		$date_data =  $this->input->post('date_data');
		$type_jobs =  $this->input->post('type_jobs');
		
		
		$this->tvprogramun_model->insert_queue_rep($date_data,$type_jobs);
		
		
		
		$periode =  date_format(date_create($date_data),"Y-F");
		
		
		
		$type = $type_jobs;
		$tahun= $periode;
		$detail_file = 9;
		
		if($type == "1"){
		
			$daily = $this->tvprogramun_model->daily_filter($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
			$iii = 13;

		}elseif($type == "2"){
			
			$daily = $this->tvprogramun_model->daily_filter_2($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}elseif($type == "3"){
			
			$daily = $this->tvprogramun_model->daily_filter_3($tahun);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}elseif($type == "4"){
			
			$daily = $this->tvprogramun_model->daily_filter_4($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_CIM','SPLIT_CIM','DETAIL_CIM','DETAIL_LOGPROOF','CIM_RATING','REACH_PRODUCT','REACH_SECTOR','REACH_ADVERTISER','REACH_PRODUCT_MONTHLY','REACH_SECTOR_MONTHLY','REACH_ADVERTISER_MONTHLY','SUB_CAT','DASHBOARD_POSTBUY'];
			$iii = 13;

			
		}elseif($type == "5"){
			
			$daily = $this->tvprogramun_model->daily_filter_5($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_RATECARD','CLEANSING_RATECARD','SPLIT_RATECARD','DETAIL_RATECARD','RATING_PERMINUTES','MEDIAPLAN_RATING','TVCC','AFTER_BEFORE','MIGRATION','AUDIENCE','DASHBOARD_MEDIAPLAN'];
			$iii = 11;

			
		}
		
		
			$status_array = ['Not Process','Success','Failed','On Process','On Queue'];

			$detail_daily = array();
			for ($i=0;$i<count($daily);$i++){
				$scamud['LOG_DATE'] = $daily[$i]['LOG_DATE'];
				$ssucc = 0;
				$prog = 0;
				
				foreach($array_jobs_detail AS $detail_name){
					if($daily[$i][$detail_name] == null){
						$scamud[$detail_name] = $status_array[0];
					}else{
						$scamud[$detail_name] = $status_array[$daily[$i][$detail_name]];
					}
					
					$note[$detail_name] = explode("||",$daily[$i][$detail_name.'_NOTE']);
					$scamud[$detail_name.'_NOTE'] = $note[$detail_name][0];
					$scamud[$detail_name.'_NOTE_FL'] = $scamud[$detail_name]."||".$note[$detail_name][0];
					
					if($daily[$i][$detail_name] == 1){
						$ssucc++ ;
					}
					
					if($daily[$i][$detail_name] == 3){
						
						$prog++;
					}
				}

				if($daily[$i]['STATUS_J'] == 3){
					
					$scamud['SUCC'] = "On Progress";
				}else{
				
					if($ssucc < $iii){
						if($ssucc == 0){
							$scamud['SUCC'] = "Process Not Running";
						}else{
							if($prog == 0){
								$scamud['SUCC'] = "Process Not Complete<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",".$type.")' >Reprocess</button>";
							}else{
								$scamud['SUCC'] = "Process Not Complete";
							}
						}
					}else{
						$scamud['SUCC'] = "Process Complete";
					}
				
				}
				
				array_push($detail_daily, $scamud);
			}
			
			$data['daily'] = json_encode($detail_daily,true); 
			
			echo $data['daily'];
		
	}
	
	function insert_queue(){
		
		$date_data =  $this->input->post('date_data');
		$type_jobs =  $this->input->post('type_jobs');
		
		
		$this->tvprogramun_model->insert_queue($date_data,$type_jobs);
		
		$get_file = $this->tvprogramun_model->get_file_prop($date_data,$type_jobs);
		
		$arr_file = explode("/",$get_file[0]['FILE_NAME']);
		
		

		
		
		
		$tahun=$this->input->post('tahun');

		$periode=$tahun; 

			
		if($type_jobs == 7 || $type_jobs == 8 ){
			$data['programs'] = $this->tvprogramun_model->filter_table2("Program",$periode,$type_jobs);
		}else{
			$data['programs'] = $this->tvprogramun_model->filter_table("Program",$periode,$type_jobs);
		}
		
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];

		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					
					if($datax['FILE_TYPE'] == 0){
						$ft = 'Original';
					}else if($datax['FILE_TYPE'] == 99){
						$ft = 'File Not Found';
					}else{
						$ft = 'Rev '.$datax['FILE_TYPE'];
					}
					
					$fn = explode("/",$datax['FILE_NAME']);
					
					$data_ch[$ik]['Date'] = $datax['LOG_DATE'];
					$data_ch[$ik]['file_name'] = end($fn);
					$data_ch[$ik]['file_size'] = $datax['FILESIZE'];
					$data_ch[$ik]['row_file'] = $datax['ROW_COUNT_FILE'];
					$data_ch[$ik]['row_load'] = $datax['ROW_COUNT_LOAD'];
					$data_ch[$ik]['row_cleansing'] = $datax['ROW_COUNT_CLEANSING'];
					$data_ch[$ik]['date_load'] = $datax['DATE_LOAD'];
					$data_ch[$ik]['file_type'] = $ft;
					
					if($datax['STATUS_FILE'] == 3){
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onqueue(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Process</button>";
					}else{
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br>".$datax['NOTE'];
					}
					
					
					
					if($datax['STATUS_FILE'] == 1){
						
						if($datax['STATUS_J'] == 1 ){
							$data_ch[$ik]['check_data'] = "<span style='color:blue'><strong>Checked</strong></span>";
						}elseif($datax['STATUS_J'] == 2 ){
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onreproc_f(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Reprocess</button>";
						}elseif($datax['STATUS_J'] == 3 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Checking</strong></span>";
							
						}elseif($datax['STATUS_J'] == 4 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Queue</strong></span>";
							
						}else{
						
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='checkdata_day(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Check Data</button>";
						}
						
					}else{
						$data_ch[$ik]['check_data']  = "";
					}
					
					$i++;
					$ik++;
				}
		} else {
			$data_ch = null;
		}
		
		echo json_encode($data_ch,true);
		
	}
	
	function days_in_month($month, $year) 
	{ 
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	function checkdata_day(){
		
			
		$type =  $this->input->post('type');
		$date_file = $this->input->post('date_file');
		
		$tahun = $date_file;
		
		if($type == "4"){
		
			$queue_id = 7;
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_u_".$tahun." & ";
			$tbs = 'DAILY_LOGPROOF_U_CHECK';

		}elseif($type == "2"){
		
			$queue_id = 10;
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_cim_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_cim_u_".$tahun." & ";
			$tbs = 'DAILY_CIM_CHECK';

		}elseif($type == "3"){
		
			$queue_id = 9;
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_rc_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_rc_u_".$tahun." & ";
			$tbs = 'DAILY_RATECARD_CHECK';

		}elseif($type == "6"){
		
			$queue_id = 8;
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_m.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_m_".$tahun." & ";
			$tbs = 'DAILY_LOGPROOF_M_CHECK';

		}elseif($type == "1"){
		
			$queue_id = 6;
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_daily_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_daily_u_".$tahun." & ";
			$tbs = 'DAILY_CHECK_REPORT';

		}elseif($type == "5"){
		
			$queue_id = 6;
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_daily_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_daily_u_".$tahun." & ";
			$tbs = 'DAILY_CHECK_REPORT';

		}
		
		
		$this->tvprogramun_model->insert_queue_check($tahun,$queue_id,$sc_duplicate,$tbs);
		
		echo true;
		
		
	}
	
	function checkdata(){
		
		$type =  $this->input->post('type');
		$tahun = $this->input->post('tahun');
		$detail_file = $this->input->post('detail_file');
		
		
		if($type == "2"){
		
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_u_".$tahun." & ";
			shell_exec($sc_duplicate);

		}elseif($type == "4"){
		
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_cim_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_cim_u_".$tahun." & ";
			shell_exec($sc_duplicate); 

		}elseif($type == "5"){
		
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_rc_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_rc_u_".$tahun." & ";
			shell_exec($sc_duplicate);

		}elseif($type == "3"){
		
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_m.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_loogproof_m_".$tahun." & ";
			shell_exec($sc_duplicate);

		}elseif($type == "1"){
		
			$sc_duplicate = "php /var/www/jobs/steve/JOBS/fix_jobs/check_daily_u.php ".$tahun." > /var/www/jobs/steve/JOBS/fix_jobs/check_daily_u_".$tahun." & ";
			shell_exec($sc_duplicate);

		}
		
		echo true;
		
	}
	
	function datadash(){
		
		$type =  $this->input->post('type');
		$tahun= $this->input->post('tahun');
		$detail_file = $this->input->post('detail_file');
		
		if($type == "1"){
		
			$daily = $this->tvprogramun_model->daily_filter($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
			$iii = 13;

		}elseif($type == "2"){
			
			$daily = $this->tvprogramun_model->daily_filter_2($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}elseif($type == "3"){
			
			$daily = $this->tvprogramun_model->daily_filter_3($tahun);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}elseif($type == "4"){
			
			$daily = $this->tvprogramun_model->daily_filter_4($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_CIM','SPLIT_CIM','DETAIL_CIM','DETAIL_LOGPROOF','CIM_RATING','REACH_PRODUCT','REACH_SECTOR','REACH_ADVERTISER','REACH_PRODUCT_MONTHLY','REACH_SECTOR_MONTHLY','REACH_ADVERTISER_MONTHLY','SUB_CAT','DASHBOARD_POSTBUY'];
			$iii = 13;

			
		}elseif($type == "5"){
			
			$daily = $this->tvprogramun_model->daily_filter_5($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_RATECARD','CLEANSING_RATECARD','SPLIT_RATECARD','DETAIL_RATECARD','RATING_PERMINUTES','MEDIAPLAN_RATING','TVCC','AFTER_BEFORE','MIGRATION','AUDIENCE','DASHBOARD_MEDIAPLAN'];
			$iii = 11;

			
		}elseif($type == "7"){
			
			$daily = $this->tvprogramun_model->daily_filter_7($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}elseif($type == "8"){
			
			$daily = $this->tvprogramun_model->daily_filter_8($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}
		
		
			$status_array = ['Not Process','Success','Failed','On Process','On Queue'];

			$detail_daily = array();
			for ($i=0;$i<count($daily);$i++){
				$scamud['LOG_DATE'] = $daily[$i]['LOG_DATE'];
				$ssucc = 0;
				$prog = 0;
				
				foreach($array_jobs_detail AS $detail_name){
					if($daily[$i][$detail_name] == null){
						$scamud[$detail_name] = $status_array[0];
					}else{
						$scamud[$detail_name] = $status_array[$daily[$i][$detail_name]];
					}
					
					$note[$detail_name] = explode("||",$daily[$i][$detail_name.'_NOTE']);
					$scamud[$detail_name.'_NOTE'] = $note[$detail_name][0];
					$scamud[$detail_name.'_NOTE_FL'] = $scamud[$detail_name]."||".$note[$detail_name][0];
					
					if($daily[$i][$detail_name] == 1){
						$ssucc++ ;
					}
					
					if($daily[$i][$detail_name] == 3){
						
						$prog++;
					}
				}

				if($daily[$i]['STATUS_J'] == 3){
					
					$scamud['SUCC'] = "On Progress";
				}else{
					
					if($ssucc < $iii){
						if($ssucc == 0){
							$scamud['SUCC'] = "Process Not Running";
						}else{
							if($prog == 0){
								$scamud['SUCC'] = "Process Not Complete<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",".$type.")' >Reprocess</button>";
							}else{
								$scamud['SUCC'] = "Process Not Complete";
							}
						}
					}else{
						$scamud['SUCC'] = "Process Complete";
					}
					
				}
				

				
				
				
				array_push($detail_daily, $scamud);
			}
			
			$data['daily'] = json_encode($detail_daily,true); 
			
			echo $data['daily'];
		
		
	}
	
	function cost_by_program(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$tahun= $this->input->post('tahun');

		$periode=$tahun; 

		if($type == 7 || $type == 8 ){
			$data['programs'] = $this->tvprogramun_model->filter_table2("Program",$periode,$type);
		}else{
			$data['programs'] = $this->tvprogramun_model->filter_table("Program",$periode,$type);
		}
		
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];

		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					
					if($datax['FILE_TYPE'] == 0){
						$ft = 'Original';
					}else if($datax['FILE_TYPE'] == 99){
						$ft = 'File Not Found';
					}else{
						$ft = 'Rev '.$datax['FILE_TYPE'];
					}
					
					$fn = explode("/",$datax['FILE_NAME']);
					
					$data_ch[$ik]['Date'] = $datax['LOG_DATE'];
					$data_ch[$ik]['file_name'] = end($fn);
					$data_ch[$ik]['file_size'] = $datax['FILESIZE'];
					$data_ch[$ik]['row_file'] = $datax['ROW_COUNT_FILE'];
					$data_ch[$ik]['row_load'] = $datax['ROW_COUNT_LOAD'];
					$data_ch[$ik]['row_cleansing'] = $datax['ROW_COUNT_CLEANSING'];
					$data_ch[$ik]['date_load'] = $datax['DATE_LOAD'];
					$data_ch[$ik]['file_type'] = $ft;
					
					if($datax['STATUS_FILE'] == 3){
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onqueue(\"".$datax['LOG_DATE']."\",".$type.")' >Process</button>";
					}else{
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br>".$datax['NOTE'];
					}
					
					if($datax['STATUS_FILE'] == 1){
						
						if($datax['STATUS_J'] == 1 ){
							$data_ch[$ik]['check_data'] = "<span style='color:blue'><strong>Checked</strong></span>";
						}elseif($datax['STATUS_J'] == 2 ){
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onreproc_f(\"".$datax['LOG_DATE']."\",".$type.")' >Reprocess</button>";
						}elseif($datax['STATUS_J'] == 3 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Checking</strong></span>";
							
						}elseif($datax['STATUS_J'] == 4 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Queue</strong></span>";
							
						}else{
						
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='checkdata_day(\"".$datax['LOG_DATE']."\",".$type.")' >Check Data</button>";
						}
						
					}else{
						
						$data_ch[$ik]['check_data'] = "";
	
					}
					
					$i++;
					$ik++;
				}
		} else {
			$data_ch = null;
		}
		
		
			


		
		
		echo json_encode($data_ch,true);
		
	}
	
	function audiencebar_by_channel(){
		
		$where =  $this->input->post('cond');
		$type =  $this->input->post('type');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$profile=$this->input->post('profile');
		$nmonth = date("m", strtotime($tahun));
		$week=$this->input->post('week');
		$tgl=$this->input->post('tgl');
		
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$periode=$tahun;
		
			if ($week=="0"){
				
				if($tgl=="0"){
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type,$profile); 
				}else{
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date("channel_name",$where,$periode,$datef,$type,$profile); 
				}
				
			}else{
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile); 
			}
			
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2new();
			
      if(sizeof($data['channel']) > 0){
    			if($type == 'Reach'){
    				foreach($data['channel'] as $datax){
    					$data_ch['cat'][] = $datax['channel'];
    					$data_ch['data'][] = round(($datax['Spot']/$data['totpopulasi'][0]['tot_pop'])*100,2);
    				}
    			}else{
    				foreach($data['channel'] as $datax){
    					$data_ch['cat'][] = $datax['channel'];
    					$data_ch['data'][] = $datax['Spot'];
    				}
    			}
      } else {
          $data_ch['cat'][] = "";
          $data_ch['data'][] = "";
      }
      
		echo json_encode($data_ch,true);
	}

}

