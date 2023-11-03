<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramun3treg extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}

	public function stosearch(){
      $typerole = $this->session->userdata('type_role');
      $genre = str_replace("AND","&",$_GET['g']);
      $witel = $_GET['w'];
      $datel = $_GET['d'];
	  
	  
      $list = $this->tvprogramun_model->stosearch($_GET['q'],$genre,$witel,$typerole, $datel);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	} 

	public function datelsearch(){
      $typerole = $this->session->userdata('type_role');
      $genre = str_replace("AND","&",$_GET['g']);
      $witel = $_GET['w'];
	  
	  
      $list = $this->tvprogramun_model->datelsearch($_GET['q'],$genre,$witel,$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	} 
	
	public function witelsearch(){
      $typerole = $this->session->userdata('type_role');
      $genre = str_replace("AND","&",$_GET['g']);
      $list = $this->tvprogramun_model->witelsearch($_GET['q'],$genre,$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	}    
	
	
	public function audiencebar_by_program_export(){
		
		
		$genre =  $this->Anti_si($this->input->post('genre',true));
		$regional =  $this->Anti_si($this->input->post('regional',true));
		$witel =  $this->Anti_si($this->input->post('witel',true));
		$datel =  $this->Anti_si($this->input->post('datel',true));
		$sto =  $this->Anti_si($this->input->post('sto',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('pilihprog',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$periode=$this->Anti_si($this->input->post('periode',true));
	
	
		if($genre == "" || $genre == "0" ){
				$where_g = "";
			}else{
				$where_g = " AND GENRE = '".str_replace("AND","&",$genre)."' ";
			}
		  
 		  
		  $where = '';
		  $pilihprog = $type;
		 
		   $params['limit'] 		= 10;
			$params['offset'] 		= 0;
			$params['periode'] 	= $periode;
			$params['week'] 	= $week;
			$params['searchtxt'] 	= "";
		 
			
			$nmonth = date("m", strtotime($periode));
			$datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			$datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			$params['tgl'] 	= $datefF;
		
		
		
				if ($week=="ALL"){
			if ($tgl=="0"){
				
				if($regional == "0" || $regional == ""){
					
 					
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly","NASIONAL","",$profile,$where_g,$params);
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$regional,"NASIONAL",$profile,$where_g,$params); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$witel,$regional,$profile,$where_g,$params); 
							
							
						}else{
						
							if($sto == "0" || $sto == ""){
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$datel,$witel,$profile,$where_g,$params); 
							}else{
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$sto,$datel,$profile,$where_g,$params); 
							}
						}

					
					}

				}
				
				
			}else {
				
				if($regional == "0" || $regional == ""){
					
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly","NASIONAL","",$profile,$where_g,$params,$datefF);
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$regional,"NASIONAL",$profile,$where_g,$params,$datefF); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$witel,$regional,$profile,$where_g,$params,$datefF); 
							
							
						}else{
							
							if($sto == "0" || $sto == ""){
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$datel,$witel,$profile,$where_g,$params,$datefF); 
							}else{
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$sto,$datel,$profile,$where_g,$params,$datefF); 
							}
						
						}

					
					}

				}
				
			}
		}else {
				if($regional == "0" || $regional == ""){
					
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly","NASIONAL","",$profile,$where_g,$params,$week);
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$regional,"NASIONAL",$profile,$where_g,$params,$week); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$witel,$regional,$profile,$where_g,$params,$week); 
							
							
						}else{
							if($sto == "0" || $sto == ""){
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$datel,$witel,$profile,$where_g,$params,$week); 
							}else{
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$sto,$datel,$profile,$where_g,$params,$week); 
							}
						
						}

					
					}

				}
		}
			
				
		    $data = array();	
			
 		
		   foreach ( $list['data_full'] as $k => $v ) {
			  
				
			    array_push($data, 
				  array(
					 $v['Rangking'],
					  $v['PROGRAM'],
					  $v['CHANNEL'],
					  $v['AUDIENCE'],
					  $v['SHARE'],
					 $v['REACH'],
					  $v['TOTAL_VIEW'],
					$v['DURATION'],
					 $v['AVGTOTDUR']
					 
				  )
			  );
 			   
		   }
			 $result["data_full"] = $data;
			  
		 
			
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
					->setCellValue('A1', 'Regional '.$regional)
					->setCellValue('B1', 'Witel '.$witel)
					->setCellValue('C1', 'Datel '.$datel)
					->setCellValue('C1', 'STO '.$sto);
	   
	   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'Rangking')
					->setCellValue('B3', 'Channel')
					->setCellValue('C3', 'Program')
					->setCellValue('D3', 'Audience')
 					->setCellValue('E3', 'Reach')
					->setCellValue('F3', 'Total Viewers')
					->setCellValue('G3', 'Duration')
					->setCellValue('H3', 'Avg Duration/View');
	   
	   $it1 = 4;
		 foreach($data as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt[0])
					->setCellValue('B'.$it1, $frt[1])
					->setCellValue('C'.$it1, $frt[2])
					->setCellValue('D'.$it1, $frt[3])
 					->setCellValue('E'.$it1, $frt[5])
					->setCellValue('F'.$it1, $frt[6])
					->setCellValue('G'.$it1, $frt[7])
					->setCellValue('H'.$it1, $frt[8]);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);
 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_program.xls');	
		
			
	}
	
	public function get_filter_programaud(){
		
		 if( !empty($this->Anti_si($_GET['periode'])) ) {
			  $periode = $this->Anti_si($_GET['periode']);
		  } else {
			  $periode = NULL;
		  }
		  
		   if( !empty($this->Anti_si($_GET['pilihprog'])) ) {
			  $pilihprog = $this->Anti_si($_GET['pilihprog']);
		  } else {
			  $pilihprog = 'Viewers';
		  }
		  
		   if( !empty($this->Anti_si($_GET['tgl2'])) ) {
			  $tgl = $this->Anti_si($_GET['tgl2']);
		  } else {
			  $tgl = '0';
		  }
		  
		   if( !empty($this->Anti_si($_GET['week2'])) ) {
			  $week = $this->Anti_si($_GET['week2']);
		  } else {
			  $week = '0';
		  }
		  
		   if( !empty($this->Anti_si($_GET['genre2'])) ) {
			  $genre = $this->Anti_si($_GET['genre2']);
		  } else {
			  $genre = "";
		  }
		  
		   if( !empty($this->Anti_si($_GET['regional2'])) ) {
			  $regional = $this->Anti_si($_GET['regional2']);
		  } else {
			  $regional = "0";
		  }
		  
		   if( !empty($this->Anti_si($_GET['witel2'])) ) {
			  $witel = $this->Anti_si($_GET['witel2']);
		  } else {
			  $witel = "";
		  }
		  
		   if( !empty($this->Anti_si($_GET['datel2'])) ) {
			  $datel = $this->Anti_si($_GET['datel2']);
		  } else {
			  $datel = "";
		  }
		  
		    if( !empty($this->Anti_si($_GET['sto2'])) ) {
			  $sto = $this->Anti_si($_GET['sto2']);
		  } else {
			  $sto = "";
		  }
		  
		   if( !empty($this->Anti_si($_GET['profile_prog'])) ) {
			  $profile = $this->Anti_si($_GET['profile_prog']);
		  } else {
			  $profile = "0";
		  }
		  
		   if( !empty($this->Anti_si($_GET['searchtxt'])) ) {
			  $searchtxt = $this->Anti_si($_GET['searchtxt']);
		  } else {
			  $searchtxt = "";
		  }
		  
		  $where = '';
 
		  	
			if($genre == ""){
				$where_g = "";
			}else{
				$where_g = " AND GENRE = '".str_replace("AND","&",$genre)."' ";
			}
		
		   
		  if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		  if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		  if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		  $order_fields = array('TANGGAL','TANGGAL', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR');  
		  $order = $this->input->get_post('order');
		  if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		  if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		  
		    $params['limit'] 		= (int) $length;
			$params['offset'] 		= (int) $start;
			$params['order_column'] = $order_fields[$order_column];
			$params['order_dir'] 	= $order_dir;
			$params['periode'] 	= $periode;
			$params['week'] 	= $week;
			$params['regional'] 	= $regional;
			$params['witel'] 	= $witel;
			$params['datel'] 	= $datel;
			$params['where_g'] 	= $where_g;
			$params['searchtxt'] 	= $_GET['search']['value'];
 
			
			$nmonth = date("m", strtotime($periode));
			$datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			$datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			$params['tgl'] 	= $datefF;
		
		 
			if ($week=="ALL"){
			if ($tgl=="0"){
				
				if($regional == "0" || $regional == ""){
					
 					
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly","NASIONAL","",$profile,$where_g,$params);
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$regional,"NASIONAL",$profile,$where_g,$params); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$witel,$regional,$profile,$where_g,$params); 
							
							
						}else{
						
							if($sto == "0" || $sto == ""){ 
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$datel,$witel,$profile,$where_g,$params); 
							}else{
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2($periode,"Monthly",$sto,$datel,$profile,$where_g,$params); 
								
							}
							
							
						
						}

					
					}

				}
				
				
			}else {
				
				if($regional == "0" || $regional == ""){
					
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly","NASIONAL","",$profile,$where_g,$params,$datefF);
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$regional,"NASIONAL",$profile,$where_g,$params,$datefF); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$witel,$regional,$profile,$where_g,$params,$datefF); 
							
							
						}else{
							
							if($sto == "0" || $sto == ""){ 
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$datel,$witel,$profile,$where_g,$params,$datefF);
							}else{
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_day($periode,"Monthly",$sto,$datel,$profile,$where_g,$params,$datefF);
							}
							
							 
						
						}

					
					}

				}
				
			}
		}else {
				if($regional == "0" || $regional == ""){
					
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly","NASIONAL","",$profile,$where_g,$params,$week);
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$regional,"NASIONAL",$profile,$where_g,$params,$week); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$witel,$regional,$profile,$where_g,$params,$week); 
							
							
						}else{
							
							if($sto == "0" || $sto == ""){
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$datel,$witel,$profile,$where_g,$params,$week); 
							}else{
								$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new2_week($periode,"Monthly",$sto,$datel,$profile,$where_g,$params,$week); 
							}
							
						
						}

					
					}

				}
		}
			
				
		    $data = array();	
		
		   foreach ( $list['data'] as $k => $v ) {
			   
				
			    array_push($data, 
				  array(
					  number_format($v['Rangking'],0,',','.'),
					  $v['PROGRAM'],
					  $v['CHANNEL'],
					  "<p align='right' >".number_format($v['AUDIENCE'],0,",",".")."</p>",
 					  "<p align='right' >".number_format($v['REACH'],2,",",".")."</p>",
					  "<p align='right' >".number_format($v['TOTAL_VIEW'],0,",",".")."</p>",
					  "<p align='right' >".number_format($v['DURATION'],0,",",".")."</p>",
					  "<p align='right' >".number_format($v['AVGTOTDUR'],2,",",".")."</p>"
					 
				  )
			  );
 			   
		   }
			 $result["data"] = $data;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
 	  
			$this->json_result($result);
			
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
		
		$data_t['January'] = '01';
		$data_t['February'] = '02';
		$data_t['March'] = '03';
		$data_t['April'] = '04';
		$data_t['May'] = '05';
		$data_t['June'] = '06';
		$data_t['July'] = '07';
		$data_t['August'] = '08';
		$data_t['September'] = '09';
		$data_t['October'] = '10';
		$data_t['November'] = '11';
		$data_t['December'] = '12';
		
 		
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
			
		
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode,$data_t);
		
		 
		
		$html = "";
		 
		
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
 		
		$data['drag'] = $html;
 		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
		
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly","NASIONAL","","0",""); 
	 
		$dataM=$data['channels'];
		$scama = array();
		for ($i=0;$i<count($dataM);$i++){
			$scam['Rangking'] = $i+1;
			$scam['AUDIENCE'] = $dataM[$i]['AUDIENCE'];
			$scam['TOTAL_VIEW'] = $dataM[$i]['TOTAL_VIEW'];
			$scam['DURATION'] = $dataM[$i]['DURATION'];
			$scam['SHARE'] = $dataM[$i]['SHARE'];
			$scam['AVGTOTDUR'] = $dataM[$i]['AVGTOTDUR'];
			$scam['REACH'] = $dataM[$i]['REACH'];
			$scam['channel'] = $dataM[$i]['CHANNEL'];
			$data_cha[] = '"'.$dataM[$i]['CHANNEL'].'"';
			$spot_cha[] = $dataM[$i]['AUDIENCE'];
			array_push($scama, $scam);
		}

		
		
		$dataMa=$data['programsu'];
		
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
			$scamu['Rangking'] = $i+1;
			$scamu['Program'] = $dataMa[$i]['PROGRAM'];
			$scamu['CHANNEL'] = $dataMa[$i]['CHANNEL'];
			$scamu['Spot'] = $dataMa[$i]['Spot'];
			$data_chas[] = '"'.$dataMa[$i]['CHANNEL'].'"';
			$spot_chas[] = $dataMa[$i]['Spot'];
			array_push($scamas, $scamu);
		}
	 
		
		$data['audiencebychannel'] = json_encode($scama,true); 
		$data['programs'] = json_encode($scamas,true); 
		 
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		
		 
		$data['json_channel'] = $data_cha;
		$data['json_spot'] = $spot_cha;
		 
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
	 
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		 
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel($periode);
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['genre'] = $this->tvprogramun_model->list_channel_genre();
		
		$this->template->load('maintemplate', 'tvprogramun3treg/views/Tvprogramun', $data);
	}	

	function days_in_month($month, $year) 
	{ 
 		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	function cost_by_program(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
			$tgl=$this->Anti_si($this->input->post('tgl',true));
		$nmonth = date("m", strtotime($tahun)); 
		 $week=$this->Anti_si($this->input->post('week',true));
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$datefF = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		
		$periode=$tahun; 
		 
		
		if ($week=="ALL"){
			if ($tgl=="0"){
				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$type,$profile);
 			}else {
				
 				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari_date("Program",$where,$periode, $datef,$datefF,$type,$profile); 
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
	
	function audiencebar_by_channel_export_m(){
		
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		
		$scama = $this->tvprogramun_model->list_spot_by_program_all_bar_month($tahun); 
		
		 $this->load->library('excel');
		
 	   
	   $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Treg Analytics")
									 ->setSubject("Treg Analytics")
									 ->setDescription("Report Treg")
									 ->setKeywords("Treg Analytics")
									 ->setCategory("Report");
									 
 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Regional ')
					->setCellValue('B1', 'Witel ')
					->setCellValue('C1', 'Datel ')
					->setCellValue('D1', 'Channel ')
					->setCellValue('E1', 'Audience ')
					->setCellValue('F1', 'Reach ')
					->setCellValue('G1', 'Total Viewers ')
					->setCellValue('H1', 'Duration ')
					->setCellValue('I1', 'Avg Duration/View ')
					->setCellValue('J1', 'Audience Share ');
	   
	   
	   $it1 = 2;
		 foreach($scama as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['REG'])
					->setCellValue('B'.$it1, $frt['WITEL'])
					->setCellValue('C'.$it1, $frt['DATEL'])
					->setCellValue('D'.$it1, $frt['CHANNEL'])
					->setCellValue('E'.$it1, $frt['AUDIENCE'])
					->setCellValue('F'.$it1, $frt['REACH'])
					->setCellValue('G'.$it1, $frt['TOTAL_VIEW'])
					->setCellValue('H'.$it1, $frt['DURATION'])
					->setCellValue('I'.$it1, $frt['AVGTOTDUR'])
					->setCellValue('J'.$it1, $frt['SHARE']);

			$it1++;
		}
		
		
		$objPHPExcel->getActiveSheet()->setTitle('Treg by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel_treg.xls');
		
	}
	
	function audiencebar_by_channel_export(){
		
 		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		
		$genre =  $this->Anti_si($this->input->post('genre',true));
		$regional =  $this->Anti_si($this->input->post('regional',true));
		$witel =  $this->Anti_si($this->input->post('witel',true));
		$datel =  $this->Anti_si($this->input->post('datel',true));
		$sto =  $this->Anti_si($this->input->post('sto',true));
			 
		$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		
		if($genre == "" || $genre == "0" ){
			$where = "";
		}else{
			$where = " AND GENRE = '".str_replace("AND","&",$genre)."' ";
		}
		 
		if ($week=="ALL"){
			if ($tgl=="0"){
				
				if($regional == "0" || $regional == ""){
					
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly","NASIONAL","","0",$where); 
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$regional,"NASIONAL","0",$where); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$witel,$regional,"0",$where); 
							
							
						}else{
							
							if($sto == "0" || $sto == ""){
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$datel,$witel,"0",$where); 
							}else{
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$sto,$datel,"0",$where); 
							}
						
							
						
						}

					
					}

				}
				
				
			}else {
				
				if($regional == "0" || $regional == ""){
					
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly","NASIONAL","","0",$where,$datef); 
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$regional,"NASIONAL","0",$where,$datef); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$witel,$regional,"0",$where,$datef); 
							
							
						}else{
						
							if($sto == "0" || $sto == ""){
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$datel,$witel,"0",$where,$datef); 
							}else{
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$sto,$datel,"0",$where,$datef); 
							}
						
						}

					
					}

				}
				
			}
		}else {
				if($regional == "0" || $regional == ""){
					
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly","NASIONAL","","0",$where,$week); 
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$regional,"NASIONAL","0",$where,$week); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$witel,$regional,"0",$where,$week); 
							
							
						}else{
							
							if($sto == "0" || $sto == ""){
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$datel,$witel,"0",$where,$week); 
							}else{
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$sto,$datel,"0",$where,$week); 
							}
						
						}

					
					}

				}
		}
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
			
       if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
		$dataM=$data['channel'];
		$scama = array();
		for ($i=0;$i<count($dataM);$i++){
			$scam['Rangking'] = $i+1;
			$scam['AUDIENCE'] = $dataM[$i]['AUDIENCE'];
			$scam['TOTAL_VIEW'] = $dataM[$i]['TOTAL_VIEW'];
			$scam['DURATION'] = $dataM[$i]['DURATION'];
			$scam['SHARE'] = $dataM[$i]['SHARE'];
			$scam['AVGTOTDUR'] = $dataM[$i]['AVGTOTDUR'];
			$scam['REACH'] = $dataM[$i]['REACH'];
			$scam['channel'] = $dataM[$i]['CHANNEL'];
			$data_cha[] = '"'.$dataM[$i]['CHANNEL'].'"';
			$spot_cha[] = $dataM[$i]['AUDIENCE'];
			array_push($scama, $scam);
		}	
		
		 
      } else {
          $scama = null;
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
					->setCellValue('A1', 'Regional '.$regional)
					->setCellValue('B1', 'Witel '.$witel)
					->setCellValue('C1', 'Datel '.$datel)
					->setCellValue('D1', 'STO '.$sto);
	   
	   
	   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A3', 'Rangking')
					->setCellValue('B3', 'Channel')
					->setCellValue('C3', 'Audience')
					->setCellValue('D3', 'Reach')
					->setCellValue('E3', 'Total Viewers')
					->setCellValue('F3', 'Duration')
					->setCellValue('G3', 'Avg Duration/Views')
					->setCellValue('H3', 'Audience Share');
	   
	   $it1 = 4;
		 foreach($scama as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['Rangking'])
					->setCellValue('B'.$it1, $frt['channel'])
					->setCellValue('C'.$it1, $frt['AUDIENCE'])
					->setCellValue('D'.$it1, $frt['REACH'])
					->setCellValue('E'.$it1, $frt['TOTAL_VIEW'])
					->setCellValue('F'.$it1, $frt['DURATION'])
					->setCellValue('G'.$it1, $frt['AVGTOTDUR'])
					->setCellValue('H'.$it1, $frt['SHARE']);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);
 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel.xls');
 
	}
	
	function channel_filter(){
		
		
		
	}
	
	function audiencebar_by_channel(){
		
		$genre =  $this->Anti_si($this->input->post('genre',true));
		
 		
		$regional =  $this->Anti_si($this->input->post('regional',true));
		$witel =  $this->Anti_si($this->input->post('witel',true));
		$datel =  $this->Anti_si($this->input->post('datel',true));
		$sto =  $this->Anti_si($this->input->post('sto',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		 
		$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		
		if($genre == "" || $genre == "0" || $genre == NULL){
			$where = "";
		}else{
			$where = " AND GENRE = '".str_replace("AND","&",$genre)."' ";
		}
		 
		if ($week=="ALL"){
			if ($tgl=="0"){
				
				if($regional == "0" || $regional == ""){
					
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly","NASIONAL","","0",$where); 
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$regional,"NASIONAL","0",$where); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$witel,$regional,"0",$where); 
							
							
						}else{
						
							if($sto == "0" || $sto == ""){
								
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$datel,$witel,"0",$where); 
								
							}else{
								
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar($periode,"Monthly",$sto,$datel,"0",$where); 
								
							}
							
						
						}

					
					}

				}
				
				
			}else {
				
				if($regional == "0" || $regional == ""){
					
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly","NASIONAL","","0",$where,$datef); 
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$regional,"NASIONAL","0",$where,$datef); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$witel,$regional,"0",$where,$datef); 
							
							
						}else{
						
							if($sto == "0" || $sto == ""){
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$datel,$witel,"0",$where,$datef); 
							}else{
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_day($periode,"Monthly",$sto,$datel,"0",$where,$datef); 
							}							
							
						
						}

					
					}

				}
				
			}
		}else {
				if($regional == "0" || $regional == ""){
					
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly","NASIONAL","","0",$where,$week); 
					
				}else{
					
					if($witel == "0" || $witel == ""){
						
						$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$regional,"NASIONAL","0",$where,$week); 
						
						
					}else{
					
						if($datel == "0" || $datel == ""){
							
							$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$witel,$regional,"0",$where,$week); 
							
							
						}else{
						
							if($sto == "0" || $sto == ""){
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$datel,$witel,"0",$where,$week); 
							}else{
								$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_week($periode,"Monthly",$sto,$datel,"0",$where,$week); 
							}	
							
						
						}

					
					}

				}
		}
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
			
       if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
		$dataM=$data['channel'];
		$scama = array();
		for ($i=0;$i<count($dataM);$i++){
			$scam['Rangking'] = $i+1;
			$scam['AUDIENCE'] = $dataM[$i]['AUDIENCE'];
			$scam['TOTAL_VIEW'] = $dataM[$i]['TOTAL_VIEW'];
			$scam['DURATION'] = $dataM[$i]['DURATION'];
			$scam['SHARE'] = $dataM[$i]['SHARE'];
			$scam['AVGTOTDUR'] = $dataM[$i]['AVGTOTDUR'];
			$scam['REACH'] = $dataM[$i]['REACH'];
			$scam['channel'] = $dataM[$i]['CHANNEL'];
			$data_cha[] = '"'.$dataM[$i]['CHANNEL'].'"';
			$spot_cha[] = $dataM[$i]['AUDIENCE'];
			array_push($scama, $scam);
		}	
 
      } else {
          $scama = null;
      }
      
		  echo json_encode($scama,true);
	}

}

