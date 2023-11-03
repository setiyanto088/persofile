<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daypartresp22 extends JA_Controller {
  public function __construct()
	{
      parent::__construct();			
      $this->load->model('audience_model');
	 
	  
	}
	
	public function channelsearch(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->audience_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
	
	public function index(){
      $id = $this->session->userdata('project_id');
      $iduser = $this->session->userdata('user_id');
      
	 $test_prod = $this->audience_model->test_new();
	   
	  
      if($id == null){
          $id = 0;
      }else{
          $id = $this->session->userdata('project_id');
      }
      if(!$this->session->userdata('user_id')) {
          redirect ('/login');
      }
      
      $data['profile'] = $this->audience_model->list_profile($iduser);
      $data['daypart'] = $this->audience_model->list_daypart($iduser);
	  $data['channels'] = $this->audience_model->get_channel(); 
      
	  
      $typerole = $this->session->userdata('type_role');
      $data['listparent'] = $this->audience_model->listdataprofilenew($typerole);
      $data['currdate'] = $this->audience_model->current_date();
	  
	  $menu = array(
				'items' => array(),
				'parents' => array() 
			);
	  
	  $result = $this->audience_model->tree1();
			
			foreach ($result as $items)
				{
				$menu['items'][$items['ID']] = $items;
				$menu['parents'][$items['PARENTID']][] = $items['ID'];
				}
            
            $result["data"] = $menu;
    
			$data['tree_s'] = $this->_build_menu(0, $result["data"]);
			
      
      $this->template->load('maintemplate_urban', 'daypartresp22/views/audience_view', $data);
	}
	
		function generate_html() {
		return $this->_build_menu(0, $this->menu_data['data']);
	}
	
	function _build_menu($parent, $menu)
	{
	   $html = '';
	   if (isset($menu['parents'][$parent]))
	   {
      $packageSeq = 0;
		   foreach ($menu['parents'][$parent] as $itemId)
		   {                 
			  if( ! isset($menu['parents'][$itemId]))
			  {
				  
				$html .= '{"text" : "'.$menu['items'][$itemId]['LABEL'].'","id" : "'.$menu['items'][$itemId]['VALUE'].'='.$menu['items'][$itemId]['FIELD'].'='.$menu['items'][$itemId]['PARENTFIELD'].'='.$menu['items'][$itemId]['PARENTDEFAULT'].'='.$menu['items'][$itemId]['LABEL'].'", "state" : { "opened" : false } }';
				
			  }
			  if( isset($menu['parents'][$itemId]) )
			  {                        

				$html .= '{"text" : "'.$menu['items'][$itemId]['LABEL'].'","state" : { "opened" : false } ,"children" : [ ';
				
				$html .= $this->_build_menu($itemId, $menu);
				
				$html .= ' ] }'; 
				
			  }   
		   }
	   }
	   
	   $htmls =str_replace("}{","},{",$html); 
	   
	   return $htmls;
	}
	
	
	
	public function list_tree_profile(){
		
		$id_profile = $this->Anti_si($this->input->post('id_profile',true));
		
		$list = $this->audience_model->get_profile_detail($id_profile);
		
		$grouping = json_decode($list[0]['grouping'],true);
		
		$array_data = [];
		foreach($grouping as $groupings){
			$data = $groupings['Data'];
			foreach($groupings['Data'] as $dataq){
				
				$last_param = $this->audience_model->get_last_param($groupings['Tag'],$dataq);
				
				$id_node = $dataq."=".$groupings['Tag']."=".$groupings['Tag']."=0=".$last_param[0]['LABEL'];
				$array_data[] = $id_node;
			}
		}
		
		 $result = array(
                'success' => true,
                'data' => $array_data
          );
		
		
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
	}
	
	
	public function getDatesFromRange($start, $end, $format = 'Ym') {
		$array = array();
		$interval = new DateInterval('P1D');

		$realEnd = new DateTime($end);
		$realEnd->add($interval);

		$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

		$curr = '';
		foreach($period as $date) { 
			if($curr == ''){
				$array[] = $date->format($format); 
			}else{
				if($curr == $date->format($format)){
					
				}else{
					$array[] = $date->format($format); 
				}
			}
			
			$curr = $date->format($format); 
		}

		return $array;
	}
	
	public function cr_pp(){
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$data = $this->Anti_si($_POST['list']);
		$channel = $this->Anti_si($_POST['channel']);
		$start_date = explode('/',$this->Anti_si($_POST['start_date']));
		$end_date = explode('/',$this->Anti_si($_POST['end_date']));
		$program = $this->Anti_si($_POST['program']);
		$daypart = $this->Anti_si($_POST['daypart']);
		$profile = $this->Anti_si($_POST['profile']);
		$dataf = $this->Anti_si($_POST['dataf']);
		$time_segment = explode('-',$daypart);
		
		$params['start_date'] = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
		$params['end_date'] = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];
		$params['daypart'] = $this->Anti_si($_POST['daypart']);
		$params['profile'] = $this->Anti_si($_POST['profile']);
		$params['dataf'] = $this->Anti_si($_POST['dataf']);
		$params['dataf2'] = $this->Anti_si($_POST['dataf2']);
		$params['start_time'] = $time_segment[0];
		$params['end_time'] = $time_segment[1];
		$params['chnl'] = $channel;
		
		$array_date = $this->getDatesFromRange($params['start_date'],$params['end_date']);
		$table_html2 = '';
		$lbl = '';
		
		
		if($dataf == 'hours'){
			$header = 'Hours';
			if($params['dataf2'] == "summary"){
				$list = $this->audience_model->list_tvpc($params);
				$list2 = $this->audience_model->list_tvpc2($params);
				
				
				$t_headers = '
				<thead>
												<tr style="color:red">
													<th>'.$header.'</th>
													<th>All Week</th>
													<th>Week Day</th>
													<th>Week End</th>
												</tr>
											</thead>
				';
				
				$tbd = '';
				$oi = 0;
				$lbl_tbd = '';
				
				foreach($list2 as  $array_tabless){

					 
					$array_tablew['DATA'][$array_tabless['WEEKS']]['TEXT'][] = $array_tabless['TEXT'];
					$array_tablew['DATA'][$array_tabless['WEEKS']]['AUD'][] = $array_tabless['AUD'];
						

				 }
				 
				
				 foreach($list as  $array_tables){
					
					$weekday_aud = 0;
					$weekend_aud = 0;
					
					if($array_tablew['DATA']['WEEKDAY']['AUD'][$oi]){
						$weekday_aud = $array_tablew['DATA']['WEEKDAY']['AUD'][$oi];
					}
					
					if($array_tablew['DATA']['WEEKEND']['AUD'][$oi]){
						$weekend_aud = $array_tablew['DATA']['WEEKEND']['AUD'][$oi];
					}
					
					 $tbd .= '
						<tr>
							<th>'.$array_tables['TEXT'].'</th>
							<th>'.number_format($array_tables['AUD'],0,',','.').'</th>
							<th>'.number_format($weekday_aud,0,',','.').'</th>
							<th>'.number_format($weekend_aud,0,',','.').'</th>
						</tr>
					 ';
					 
					$array_table['DATA'][$oi]['TEXT'] = $array_tables['TEXT'];
					$array_table['DATA'][$oi]['AUD'] = $array_tables['AUD'];
					
					$array_table['DATA_WEEKEND'][$oi]['TEXT'] = $array_tables['TEXT'];
					$array_table['DATA_WEEKEND'][$oi]['AUD'] = $weekend_aud;
					
					$array_table['DATA_WEEKDAY'][$oi]['TEXT'] = $array_tables['TEXT'];
					$array_table['DATA_WEEKDAY'][$oi]['AUD'] = $weekday_aud;
						

					 $oi++;
				 }
				
			}else{
				$list = $this->audience_model->list_tvpc_s($params);
				
				$f = explode(",",$params['chnl']);
				$cin = "";
				$cin2 = "";
				$ic = 0;
				
				$array_color = ['#4565b2','#b197aa','#accea1','#d6aa7f','#d99b9b','#d794aa','#cca4a8','#91a3b0','#738a9b','#cdd2ff'];
		  
				foreach($f as $channel_f){
					$cin = $cin."
					<th style='text-align:center;color:".$array_color[$ic]."'>All Week</th>
					<th style='text-align:center;color:".$array_color[$ic]."'>Week Day</th>
					<th style='text-align:center;color:".$array_color[$ic]."'>Week End</th>
					";
					
					$cin2 = $cin2."
					<th colspan='3' style='text-align:center;color:".$array_color[$ic]."'>".$channel_f."</th>
					";
					$ic++;
				}
				
				$t_headers = '
										<thead>
												<tr>
													<th rowspan="2" style="">'.$header.'</th>
													'.$cin2.'
												</tr>
												<tr>
													'.$cin.'
												</tr>
											</thead>
				';
				
				$tbd = '';
				$oi = 0;
				$lbl_tbd = '';
				
				foreach($list as  $array_tabless){
					
					
					$tbd .= '<tr><th>'.$array_tabless['TEXT_0'].'</th>';
					
					for($ix=1;$ix<=$ic;$ix++){
				
						$tbd .= '
								<th>'.number_format($array_tabless['AUD_'.$ix],0,',','.').'</th>
								<th>'.number_format($array_tabless['AUD_WEEKDAY_'.$ix],0,',','.').'</th>
								<th>'.number_format($array_tabless['AUD_WEEKEND_'.$ix],0,',','.').'</th>
						';
					 
					}
					
					$tbd .= '</tr>';
				
				}
				
			}
			

			
			
		}else if($dataf == 'days'){
			
			$header = 'Date';
			if($params['dataf2'] == "summary"){
				
				$list = $this->audience_model->list_tvpc_day($params);
				
				
				$t_headers = '
				<thead>
												<tr style="color:red">
													<th>'.$header.'</th>
													<th></th>
												</tr>
											</thead>
				';
				
				$tbd = '';
				$oi = 0;
				$lbl_tbd = '';
				
				 foreach($list as  $array_tables){
					 
					  $tbd .= '
						<tr>
							<th>'.$array_tables['TEXT'].'</th>
							<th>'.number_format($array_tables['AUD'],0,',','.').'</th>
						</tr>
					 ';
					 
					 $oi++;
				 }
				 
				 $array_tablew['DATA'] = $list;
				 $array_table['DATA'] = $list;
				 $array_table['DATA_WEEKEND'] = [];
				 $array_table['DATA_WEEKDAY'] = [];
				

				
				
			}else{
				
				$list = $this->audience_model->list_tvpc_split2_day($params,$array_date);
				
				
				$array_data_all = [];
				$f = explode(",",$params['chnl']);
				$cin = "";
				$cin2 = "";
				$ic = 0;
				$tbd = '';
				
				$array_color = ['#4565b2','#b197aa','#accea1','#d6aa7f','#d99b9b','#d794aa','#cca4a8','#91a3b0','#738a9b','#cdd2ff'];
				
				foreach($f as $channel_f){

					
					$cin2 = $cin2."
					<th style='text-align:center;color:".$array_color[$ic]."'>".$channel_f."</th>
					";
					$ic++;
				}
				
				$t_headers = '
										<thead>
												<tr>
													<th style="">'.$header.'</th>
													'.$cin2.'
												</tr>

											</thead>
				';
				
				$idt = 0;
				foreach($list as  $array_tabless){
					
					
					$tbd .= '<tr><th>'.$array_tabless['TEXT_0'].'</th>';
					
					for($ix=1;$ix<=$ic;$ix++){
				
						$tbd .= '
								<th style="text-align:center;">'.number_format($array_tabless['AUD_'.$ix],0,',','.').'</th>
						';
						$array_data_all[$ix-1]['data'][$idt] = intval($array_tabless['AUD_'.$ix]);
						$array_data_all[$ix-1]['name'] = $f[$ix-1];
						$array_data_all[$ix-1]['color'] = $array_color[$ix-1];
						$array_data_all[$ix-1]['label'][$idt] = $array_tabless['TEXT_0'];
					}
					
					$tbd .= '</tr>';
				
				$idt++;
				}
				
				 $array_tablew['DATA'] = $list;
				 $array_table['DATA'] = $list;
				 $array_table['DATA_WEEKEND'] = $array_data_all;
				 $array_table['DATA_WEEKDAY'] = [];
				
			}
		
		}else{
			$header = 'Minutes';
			if($params['dataf2'] == "summary"){
				$list = $this->audience_model->list_tvpc_m($params,$array_date);
				$list2 = $this->audience_model->list_tvpc2_m($params,$array_date);
				
				 
				 $t_headers = '
				<thead>
												<tr style="color:red">
													<th>'.$header.'</th>
													<th>All Week</th>
													<th>Week Day</th>
													<th>Week End</th>
												</tr>
											</thead>
				';
				
				$tbd = '';
				$oi = 0;
				$lbl_tbd = '';
				
				foreach($list2 as  $array_tabless){

					 
					$array_tablew['DATA'][$array_tabless['WEEKS']]['TEXT'][] = $array_tabless['TEXT'];
					$array_tablew['DATA'][$array_tabless['WEEKS']]['AUD'][] = $array_tabless['AUD'];
						

				 }
				 
				
				 foreach($list as  $array_tables){
					
					$weekday_aud = 0;
					$weekend_aud = 0;
					
					if($array_tablew['DATA']['WEEKDAY']['AUD'][$oi]){
						$weekday_aud = $array_tablew['DATA']['WEEKDAY']['AUD'][$oi];
					}
					
					if($array_tablew['DATA']['WEEKEND']['AUD'][$oi]){
						$weekend_aud = $array_tablew['DATA']['WEEKEND']['AUD'][$oi];
					}
					
					 $tbd .= '
						<tr>
							<th>'.$array_tables['TEXT'].'</th>
							<th>'.number_format($array_tables['AUD'],0,',','.').'</th>
							<th>'.number_format($weekday_aud,0,',','.').'</th>
							<th>'.number_format($weekend_aud,0,',','.').'</th>
						</tr>
					 ';
					 
					$array_table['DATA'][$oi]['TEXT'] = $array_tables['TEXT'];
					$array_table['DATA'][$oi]['AUD'] = $array_tables['AUD'];
					
					$array_table['DATA_WEEKEND'][$oi]['TEXT'] = $array_tables['TEXT'];
					$array_table['DATA_WEEKEND'][$oi]['AUD'] = $weekend_aud;
					
					$array_table['DATA_WEEKDAY'][$oi]['TEXT'] = $array_tables['TEXT'];
					$array_table['DATA_WEEKDAY'][$oi]['AUD'] = $weekday_aud;
						

					 $oi++;
				 }
			}else{
				$list = $this->audience_model->list_tvpc_split2($params,$array_date);
				
				$tbd = '';	
				$f = explode(",",$params['chnl']);
				$cin = "";
				$cin2 = "";
				$ic = 0;
				
				$array_color = ['#4565b2','#b197aa','#accea1','#d6aa7f','#d99b9b','#d794aa','#cca4a8','#91a3b0','#738a9b','#cdd2ff'];
		  
				foreach($f as $channel_f){
					$cin = $cin."
					<th style='text-align:center;color:".$array_color[$ic]."'>All Week</th>
					<th style='text-align:center;color:".$array_color[$ic]."'>Week Day</th>
					<th style='text-align:center;color:".$array_color[$ic]."'>Week End</th>
					";
					
					$cin2 = $cin2."
					<th colspan='3' style='text-align:center;color:".$array_color[$ic]."'>".$channel_f."</th>
					";
					$ic++;
				}
				
				$t_headers = '
										<thead>
												<tr>
													<th rowspan="2" style="">'.$header.'</th>
													'.$cin2.'
												</tr>
												<tr>
													'.$cin.'
												</tr>
											</thead>
				';
				
				foreach($list as  $array_tabless){
					
					
					$tbd .= '<tr><th>'.$array_tabless['TEXT_0'].'</th>';
					
					for($ix=1;$ix<=$ic;$ix++){
				
						$tbd .= '
								<th>'.number_format($array_tabless['AUD_'.$ix],0,',','.').'</th>
								<th>'.number_format($array_tabless['AUD_WEEKDAY_'.$ix],0,',','.').'</th>
								<th>'.number_format($array_tabless['AUD_WEEKEND_'.$ix],0,',','.').'</th>
						';
					 
					}
					
					$tbd .= '</tr>';
				
				}
				
			}	 
		}

				 
				

				
				$lbl_tbd = 'No.|'.$lbl.'|Audience|Prosentase#'.$lbl_tbd;
				
				$table_html2 .= ' <div class="col-md-12" style="margin-bottom:10px;">
								  <div class="result-table urate-panel" style="padding:10px">
										<table id="example_data" class="table table-striped" >
											'.$t_headers.'
											<tbody>
											'.$tbd.'
											</tbody>
										</table>
									</div>
							  </div>';


						$table_html_all = '';

		 $result["data"]["table"] = $table_html2;	
		 $result["data"]["data"] = $array_table;	
		 $result["data"]["data_split"] = $list;	
		 $result["data"]["data_weekend"] = $array_table['DATA_WEEKEND'];	
		 $result["data"]["data_weekday"] = $array_table['DATA_WEEKDAY'];	
		 $result["data"]["dataW"] = $array_tablew;	
		$this->output->set_content_type('Application/json')->set_output(json_encode($result)); 
		
	}
  
	function audience_export(){
		
		$data =  $this->Anti_si($this->input->post('data',true));
		$dataf2 =  $this->Anti_si($this->input->post('dataf2',true));
		$dataf =  $this->Anti_si($this->input->post('dataf',true));
		$channel =  $this->Anti_si($this->input->post('channel',true));
		
		$f = explode(",",$channel);
		
		
		$data_array = json_decode($data,true);
		$array_cell = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
		
		$this->load->library('excel');
	    $objPHPExcel = new PHPExcel();
	  
	  if($dataf == 'days'){
		  
		  
		  if($dataf2 == 'summary'){
		   
		   $objPHPExcel->getProperties()->setCreator("Unics")
										 ->setLastModifiedBy("Unics")
										 ->setTitle("Daypart Analytics")
										 ->setSubject("Daypart Analytics")
										 ->setDescription("Report Daypart")
										 ->setKeywords("Daypart Analytics")
										 ->setCategory("Report");

										 $objPHPExcel->setActiveSheetIndex(0)
										 ->setCellValue('A1', $dataf)
										 ->setCellValue('B1', 'All Week');
						    
						     $it1 = 2;
						     $ind = 0;
							 foreach($data_array['DATA'] as $data1s){
								 
								 $objPHPExcel->setActiveSheetIndex(0)
										 ->setCellValue('A'.$it1, $data1s['TEXT'])
										 ->setCellValue('B'.$it1, $data1s['AUD']);
								 
								 $it1++;
								 $ind++;
							 }
							 
						   
						    
					 
							 
							 $objPHPExcel->getActiveSheet()->setTitle('Daypart');
							 $objPHPExcel->setActiveSheetIndex(0);
					 
					 
							 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					 
							 
							 $objWriter->save('/var/www/html/tmp_doc/Daypart_export.xls');
					
										 
			
		   
	   }else{
	   
			$objPHPExcel->getProperties()->setCreator("Unics")
										 ->setLastModifiedBy("Unics")
										 ->setTitle("Daypart Analytics")
										 ->setSubject("Daypart Analytics")
										 ->setDescription("Report Daypart")
										 ->setKeywords("Daypart Analytics")
										 ->setCategory("Report");
										 
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'Date');
						
						
		   
			$it1 = 2;
			$ind = 0;
			
			$ind_c = 1;
			foreach($f as $channel_f){
				
				
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$ind_c].'1', $channel_f);
						
				$ind_c = $ind_c+1;
				
			}
			
			
			foreach($data_array as $data1s){
				
				
				
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$it1, $data1s['TEXT_0']);
				
				$int_ch = 1;
				$indcs = 1;
				foreach($f as $channel_f){
					
					if($data1s['AUD_'.$int_ch] == ''){
						$data1s['AUD_'.$int_ch] = 0;
					}
					

					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($array_cell[$indcs].''.$it1, $data1s['AUD_'.$int_ch]);
					
					$indcs = $indcs+1;
					$int_ch++;
				}
				
				$it1++;
				$ind++;
			}
			
		  
		   

			
			$objPHPExcel->getActiveSheet()->setTitle('Daypart');
			$objPHPExcel->setActiveSheetIndex(0);


			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			
			$objWriter->save('/var/www/html/tmp_doc/Daypart_export.xls');
		
	   }
		  
		  
	  }else{
	  
	   if($dataf2 == 'summary'){
		   
		   $objPHPExcel->getProperties()->setCreator("Unics")
										 ->setLastModifiedBy("Unics")
										 ->setTitle("Daypart Analytics")
										 ->setSubject("Daypart Analytics")
										 ->setDescription("Report Daypart")
										 ->setKeywords("Daypart Analytics")
										 ->setCategory("Report");

										 $objPHPExcel->setActiveSheetIndex(0)
										 ->setCellValue('A1', $dataf)
										 ->setCellValue('B1', 'All Week')
										 ->setCellValue('C1', 'Work Week')
										 ->setCellValue('D1', 'Week End');
						    
						     $it1 = 2;
						     $ind = 0;
							 foreach($data_array['DATA'] as $data1s){
								 
								 $objPHPExcel->setActiveSheetIndex(0)
										 ->setCellValue('A'.$it1, $data1s['TEXT'])
										 ->setCellValue('B'.$it1, $data1s['AUD'])
										 ->setCellValue('C'.$it1, $data_array['DATA_WEEKDAY'][$ind]['AUD'])
										 ->setCellValue('D'.$it1, $data_array['DATA_WEEKEND'][$ind]['AUD']);
								 
								 $it1++;
								 $ind++;
							 }
							 
						   
						    
					 
							 
							 $objPHPExcel->getActiveSheet()->setTitle('Daypart');
							 $objPHPExcel->setActiveSheetIndex(0);
					 
					 
							 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					 
							 
							 $objWriter->save('/var/www/html/tmp_doc/Daypart_export.xls');
					
										 
			
		   
	   }else{
	   
			$objPHPExcel->getProperties()->setCreator("Unics")
										 ->setLastModifiedBy("Unics")
										 ->setTitle("Daypart Analytics")
										 ->setSubject("Daypart Analytics")
										 ->setDescription("Report Daypart")
										 ->setKeywords("Daypart Analytics")
										 ->setCategory("Report");
										 
			$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', $dataf);
						
						
		   
			$it1 = 3;
			$ind = 0;
			
			$ind_c = 1;
			foreach($f as $channel_f){
				
				
				$objPHPExcel->getActiveSheet()->mergeCells($array_cell[$ind_c].'1:'.$array_cell[$ind_c+2].'2');
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$ind_c].'1', $channel_f);
						
				$ind_c = $ind_c+3;
				
			}
			
			
			foreach($data_array as $data1s){
				
				
				
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$it1, $data1s['TEXT_0']);
				
				$int_ch = 1;
				$indcs = 1;
				foreach($f as $channel_f){
					
					if($data1s['AUD_'.$int_ch] == ''){
						$data1s['AUD_'.$int_ch] = 0;
					}
					
					if($data1s['AUD_WEEKDAY_'.$int_ch] == ''){
						$data1s['AUD_WEEKDAY_'.$int_ch] = 0;
					}
					
					if($data1s['AUD_WEEKEND_'.$int_ch] == ''){
						$data1s['AUD_WEEKEND_'.$int_ch] = 0;
					}
					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($array_cell[$indcs].''.$it1, $data1s['AUD_'.$int_ch])
					->setCellValue($array_cell[$indcs+1].''.$it1, $data1s['AUD_WEEKDAY_'.$int_ch])
					->setCellValue($array_cell[$indcs+2].''.$it1, $data1s['AUD_WEEKEND_'.$int_ch]);
					
					$indcs = $indcs+3;
					$int_ch++;
				}
				
				$it1++;
				$ind++;
			}
			
		  
		   

			
			$objPHPExcel->getActiveSheet()->setTitle('Daypart');
			$objPHPExcel->setActiveSheetIndex(0);


			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			
			$objWriter->save('/var/www/html/tmp_doc/Daypart_export.xls');
		
	   }
	   
	  }
		
	}
  
      public function list_program(){
        
        if(empty($_POST)){
            $result = array(
                'success' => false,
                'message' => 'Error retrieving list program'
            );
            
            $this->json_result($result);
        }
        
        $param['channel']	= $this->Anti_si($this->input->post('valselect',true));
        $param['date']	= $this->Anti_si($this->input->post('dateselect',true));
        $param['dateend']	= $this->Anti_si($this->input->post('dateend',true));
      
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['dateend']);
          $param['dateend'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['date']);
          $param['date'] = $date->format('Y-m-d');
	  
        
        $list = $this->audience_model->list_program($param);
		
        
        if ( $list ) {
            $result = array(
                'success' => true,
                'data' => $list
            );
        } else {
            $result = array(
                'success' => false,
                'message' => 'Data not found'
            );
        } 
        
		 $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }
  
   public function listsearchs(){
        $typerole = $this->session->userdata('type_role');
		
		  
		
        $list = $this->audience_model->listsearch($this->Anti_si($_GET['q']), $typerole);
		
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }  
  
   public function listsearch(){
        $typerole = $this->session->userdata('type_role');
		
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['d']));
          $_GET['d'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['dend']));
          $_GET['dend'] = $date->format('Y-m-d');
		
        $list = $this->audience_model->listsearchs($this->Anti_si($_GET['q']), $typerole); 
		
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }                
  
  public function setdaypart(){
      $typerole = $this->session->userdata('type_role');
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($this->Anti_si($_GET['f'])) ) {
          $from = $this->Anti_si($_GET['f']);
      } else {
          $from = "00:00";
      }
      
      if( ! empty($this->Anti_si($_GET['t'])) ) {
          $to = $this->Anti_si($_GET['t']);
      } else {
          $to = "00:00";
      }
      
      $daypart = $this->audience_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}