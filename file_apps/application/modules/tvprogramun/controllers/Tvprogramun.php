<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramun extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
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
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole,$periode);
		
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
 		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['aa'] = $data['active_audience'][0]['VIEWERS'];
	 
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
 		$data['cond'] = $where;
	 
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
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
		
		if ($data['daytime'] <> null){
		
			$prime = $data['daytime'][0]['VIEWERS'];
			$nprime = $data['daytime'][1]['VIEWERS'];
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
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0"); 
		
	 
		$dataM=$data['channels'];
		for ($i=0;$i<count($dataM);$i++){
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
		}
		
		$dataMa=$data['programsu'];
 
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
			$scamu['Rangking'] = $i+1;
			$scamu['Program'] = $dataMa[$i]['Program'];
			$scamu['CHANNEL'] = $dataMa[$i]['CHANNEL'];
			$scamu['Spot'] = $dataMa[$i]['Spot'];
			$data_chas[] = '"'.$dataMa[$i]['CHANNEL'].'"';
			$spot_chas[] = $dataMa[$i]['Spot'];
			array_push($scamas, $scamu);
		}
		$data['programs'] = json_encode($scamas,true); 
		 
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
	 
		$data['json_channel'] = $data_cha;
		$data['json_spot'] = $spot_cha;
		
	 
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
 
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		 
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel();
		 
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
 		
		$this->template->load('maintemplate', 'tvprogramun/views/Tvprogramun', $data);
	}	

	function days_in_month($month, $year) 
	{ 
 		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}


	function audiencebar_by_program_export(){
		
		$type =  $this->input->post('pilihprog');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$profile=$this->input->post('profile');
		$nmonth = date("m", strtotime($tahun));
		$tgl=$this->input->post('tgl');
		
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$datefF = substr($tahun,0,4)."-".$nmonth."-".$tgl;
	 
		 $week=$this->input->post('week');
 		
		$periode=$tahun; 
	 
		if ($week=="0"){
			
			if($tgl=="0"){
 				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$type,$profile);
			}else{
 				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari_date("Program",$where,$periode,$datef,$type,$profile);
			}
		}else {
 			$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari("Program",$where,$periode,$week,$type,$profile);
		}
 		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					$data_ch[$ik]['Rangking'] = $i;
					$data_ch[$ik]['Program'] = $datax['Program'];
					$data_ch[$ik]['CHANNEL'] = $datax['CHANNEL'];
 					$data_ch[$ik]['Spot'] =  $datax['Spot'];
					$i++;
					$ik++;
				}
		} else {
			$data_ch = null;
		}
		
		$this->load->library('excel');
		
		$objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Program')
					->setCellValue('C1', 'Channel')
					->setCellValue('D1', $type);
	   
	   $it1 = 2;
		 foreach($data_ch as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['Rangking'])
					->setCellValue('B'.$it1, $frt['Program'])
					->setCellValue('C'.$it1, $frt['CHANNEL'])
					->setCellValue('D'.$it1, $frt['Spot']);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);

		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_program.xls');	
		
	 
		
	}
	
	function cost_by_program(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$profile=$this->input->post('profile');
		$nmonth = date("m", strtotime($tahun));
		$tgl=$this->input->post('tgl');
		
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$datefF = substr($tahun,0,4)."-".$nmonth."-".$tgl;
 
		 $week=$this->input->post('week');
 		
		$periode=$tahun; 
 
		if ($week=="0"){
			
			if($tgl=="0"){
 				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$type,$profile);
			}else{
 				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari_date("Program",$where,$periode,$datef,$type,$profile);
			}
		}else {
 			$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari("Program",$where,$periode,$week,$type,$profile);
		}
 		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					$data_ch[$ik]['Rangking'] = $i;
					$data_ch[$ik]['Program'] = $datax['Program'];
					$data_ch[$ik]['CHANNEL'] = $datax['CHANNEL'];
 					$data_ch[$ik]['Spot'] =  $datax['Spot'];
					$i++;
					$ik++;
				}
		} else {
			$data_ch = null;
		}
 
		echo json_encode($data_ch,true);
		
	}
	
	function audiencebar_by_channel_export(){
		
		$where =  $this->input->post('cond');
		$type =  $this->input->post('type');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$profile=$this->input->post('profile');
		$nmonth = date("m", strtotime($tahun));
		$week=$this->input->post('week');
		$tgl=$this->input->post('tgl');
		
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$dateftr = substr($tahun,0,4)."-".$nmonth."-".$tgl;
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
			
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2new($dateftr);
			
      if(sizeof($data['channel']) > 0){
		  
		  $i = 1;
		  $ik = 0;
		  
    			if($type == 'Reach'){
    				foreach($data['channel'] as $datax){
						$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
     					$data_ch[$ik]['Spot'] = round(($datax['Spot']/$data['totpopulasi'][0]['tot_pop'])*100,2);
						$ik++;
				$i++;
    				}
    			}else{
    				foreach($data['channel'] as $datax){
						$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					$data_ch[$ik]['Spot'] = $datax['Spot'];
						$ik++;
				$i++;
    				}
    			}
				
      } else {
          $data_ch = null;
      }
 
	  
		   $this->load->library('excel');
	   
	   $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Channel')
					->setCellValue('C1', $type);
					
		   $it1 = 2;
		 foreach($data_ch as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['Rangking'])
					->setCellValue('B'.$it1, $frt['channel'])
					->setCellValue('C'.$it1, $frt['Spot']);

			$it1++;
		}
		
			$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);
 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel.xls');
		
		
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
		$dateftr = substr($tahun,0,4)."-".$nmonth."-".$tgl;
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
			
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2new($dateftr);
			
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

