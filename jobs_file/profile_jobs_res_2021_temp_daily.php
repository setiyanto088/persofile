<?php 

	include '/var/www/file/cfg.php';   
	 	
	// $s = $_SERVER['argv'];
	// $id = $s[1];
	
	// $script_check = "SELECT * FROM `t_profiling_ub_res` WHERE pid = 21 ";   
	// $query_check =  mysqli_query($con,$script_check);  
	// //$check_progress = mysqli_fetch_array($query_check);
	
	// $row_users = mysqli_fetch_array($query_check);
	
	// print_r($row_users);die;
	// while($row_users = mysqli_fetch_array($query_check)){
		
		
	$script = 'SELECT * FROM `t_profiling_ub_res` WHERE pid = 1 AND flag = 1';
	$querys =  mysqli_query($con,$script); 
	while($row_users = mysqli_fetch_array($querys)){
		
		$id = $row_users['id'];
		echo $id."\n";
		
		//$periode_a = strtoupper(date_format(date_create(date('Y-m-d')),"Y-m")); //2018-11
		//$periode_a = "2022-November"; //2018-11
		$periode_a = "2023-03"; //2018-11
		
		$script_checkS = "DELETE FROM M_MONTH_PROFILE_RES WHERE PERIODE = '".$periode_a."' AND PROFILE_ID = ".$id;   
		$query_checkS =  mysqli_query($con,$script_checkS);  
		
		
		$sql5 = "INSERT INTO M_MONTH_PROFILE_RES VALUES('".$periode_a."','','',".$id.",'0') ";
		$query_checkSS =  mysqli_query($con,$sql5);  
		
		
		$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$id; 
	
	
		$script_check = "SELECT * FROM `t_profiling_ub_res` WHERE id = ".$id;   
							
		$query_check =  mysqli_query($con,$script_check);  
		$check_progress = mysqli_fetch_array($query_check);

		$universe = $check_progress['respondents_all'];
		
		//ECHO $universe;DIE;
		
		$arr_periode = array();
		$int_prog = 0;
		$percentage = 0;
			
			
			
		$periode_list_script = "SELECT PERIODE FROM M_MONTH_PROFILE_RES WHERE PROFILE_ID = ".$id." AND STATUS_PROCESS = 0 AND PERIODE = '".$periode_a."' ORDER BY PERIODE DESC ";   
							
		$query_periode_list =  mysqli_query($con,$periode_list_script);  
		while($row_PER = mysqli_fetch_array($query_periode_list)){
				
			$arr_periode[] = $row_PER['PERIODE'];
			$int_prog = $int_prog+1;
				
		}
		
		$row_users['PROFILE_ID'] = $id;
		
		//print_r($arr_periode);
		
		foreach($arr_periode as $arp){
		
			$sql_edit = " update M_MONTH_PROFILE_RES set DATE_PROCESS = '".date('Y-m-d H:i:s')."', STATUS_PROCESS = '3' WHERE PERIODE = '".$arp."' AND PROFILE_ID = ".$id;
			$query_edt =  mysqli_query($con,$sql_edit);  
			
			$data_file = $arp;
			$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
			$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
			$name_tbs2 = strtoupper(date_format(date_create($data_file),"MY")); //MAR2020
			$name_tbs3 = strtoupper(date_format(date_create($data_file),"Fy")); //MARCH20
			$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
			$name_arps = strtoupper(date_format(date_create($data_file),"Y-m")); //2018-11
			$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
			$periode =date_format(date_create($data_file),"Y-F"); //2018-March
			
			$percentage = $percentage + (3/$int_prog);
			$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
			//mysqli_query($con,$script_doneb_s);  
			//echo $periode;die;
			
			$sql_edit = " DELETE FROM SUMMARY_PER_MINUTES_RES_V2 WHERE PROFILE_ID = ".$id." AND PERIODE = '".$periode."' ";
			$query_edt =  mysqli_query($con,$sql_edit); 
			
			$sql_edit = "
			INSERT INTO `SUMMARY_PER_MINUTES_RES_V2`
			SELECT CHANNEL,`KATEGORI_CHANNEL`,`PROGRAM`,`BEGIN_PROGRAM`,`END_PROGRAM`,
						`GENRE_PROGRAM`,O.`SPLIT_MINUTES`,SUM(WEIGHT) `VIEWERS`,SUM(WEIGHT_ALL) `VIEWERS_A`,
						'".$periode."' PERIODE, ".$id." PID, 0 SD, ALL_VIEWSS `ALL_VIEWS`, ALL_VIEWSS `ALL_VIEWS_A`, 
						(SUM(WEIGHT)/ALL_VIEWSS) `TVS`, (SUM(WEIGHT_ALL)/ALL_VIEWSS) `TVS_A`,
						(SUM(WEIGHT)/".$universe.") `TVR`, (SUM(WEIGHT)/".$universe.") `TVR_A`, ".$universe." `UNIVERSE`, ".$universe." `UNIVERSE_A` FROM (
							SELECT A.* FROM CDR_EPG_RES_".$name_tbs_new."_SPLIT_STEP4_V2_2021 A
							WHERE A.RESPID IN (SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$id." )
							GROUP BY RESPID,SPLIT_MINUTES, CHANNEL, PROGRAM 
						) O JOIN (
							SELECT SUM(WEIGHT) AS ALL_VIEWSS, SPLIT_MINUTES FROM (
								SELECT RESPID,SPLIT_MINUTES,WEIGHT FROM CDR_EPG_RES_".$name_tbs_new."_SPLIT_STEP4_V2_2021 A
								WHERE A.RESPID IN (SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$id." )
								GROUP BY RESPID,SPLIT_MINUTES
							) A GROUP BY SPLIT_MINUTES
						) B ON O.SPLIT_MINUTES = B.SPLIT_MINUTES
						GROUP BY O.SPLIT_MINUTES, CHANNEL, PROGRAM 
			";
			$query_edt =  mysqli_query($con,$sql_edit); 
			
			$script_doneb_s = "
			DELETE FROM M_SUMMARY_MEDIA_PLAN_D_RES
			WHERE `PROFILE_ID` = ".$id."
			AND PERIODE = '".$periode."'
			";
			mysqli_query($con,$script_doneb_s);  
			
			$script_doneb_s = "						
						DELETE FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
						WHERE PERIODE = '".$periode."'
						AND PROFILE_ID = ".$id.";
						";
						mysqli_query($con,$script_doneb_s);  
						
						$script_doneb_s = "
						INSERT INTO M_SUMMARY_MEDIA_PLAN_D_RES_P
						SELECT DATE_FORMAT(`SPLIT_MINUTES`,'%d/%m/%Y'), CHANNEL, PROGRAM, '' AS TITTLE, 'LOOSE SPOT' AS TITTLE,'PLAY' AS `TYPE`,`BEGIN_PROGRAM`,`END_PROGRAM`,TIMEDIFF(`END_PROGRAM`, `BEGIN_PROGRAM`) DURASI,RATE/1000 COST,'' L1,'' L2, A.SPLIT_MINUTES,
						0 AS FLAG_TV, PERIODE,'' TIME_PERIODE,AVG(VIEWERS) `VV`,`ALL_VIEWS`,`UNIVERSE`,AVG(`TVR`)*100,AVG(`TVS`)*100,100 `IDX`,AVG(`VIEWERS_A`),AVG(`ALL_VIEWS_A`),`UNIVERSE_A`,AVG(`TVR_A`),AVG(`TVS_A`),100 `IDX_A`, ".$id." `PROFILE_ID` FROM (
						SELECT * FROM SUMMARY_PER_MINUTES_RES_V2 A 
						,(SELECT CHANNEL_NAME,JAM_MULAI AS START_TIME,JAM_AKHIR AS END_TIME,HARGA AS RATE FROM `M_RATE_CARD_PTV` WHERE TANGGAL_AKHIR = '31/12/2022' AND SLOT_NAME IN ('PRIME','REGULAR') ) B WHERE A.CHANNEL = B.`CHANNEL_NAME` AND DATE_FORMAT(SPLIT_MINUTES,'%H:%i:%s') BETWEEN B.`START_TIME` AND B.`END_TIME`
						AND `PROFILE_ID` = ".$id." AND VIEWERS IS NOT NULL
						AND DATE_FORMAT(SPLIT_MINUTES,'%Y-%M') = '".$periode."'

						) A GROUP BY DATE_FORMAT(`SPLIT_MINUTES`,'%d/%m/%Y'),CHANNEL,PROGRAM,BEGIN_PROGRAM,COST
						";
						mysqli_query($con,$script_doneb_s); 
						
						
						$script_doneb_s = "
						
						UPDATE M_SUMMARY_MEDIA_PLAN_D_RES_P A
						JOIN  (
						SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
						WHERE `PROFILE_ID` = 0
						) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME AND B.START_TIME
						SET `IDX` = (A.TVR/B.TVR)*100, IDX_A = (A.TVR_A/B.TVR_A)*100 
						WHERE A.`PROFILE_ID` = ".$id."
						AND A.PERIODE = '".$periode."' 
						";
						mysqli_query($con,$script_doneb_s); 
						
						$script_doneb_s = "
		DELETE FROM TVPC_RES
		WHERE `PROFILE_ID` = ".$id."
		AND `PERIODE` = '".$periode."'
		";
		mysqli_query($con,$script_doneb_s);  
		
		$script_doneb_s = "
		INSERT INTO `TVPC_RES`
		SELECT DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') AS DT ,CHANNEL,PROGRAM,BEGIN_PROGRAM,END_PROGRAM,GENRE_PROGRAM,PERIODE,
		AVG(`VIEWERS`),AVG(`ALL_VIEWS`), UNIVERSE, AVG(TVR)*100, AVG(TVS)*100, 0,
		AVG(`VIEWERS_A`),AVG(`ALL_VIEWS_A`), UNIVERSE_A, AVG(TVR_A)*100, AVG(TVS_A)*100, 0,`PROFILE_ID` FROM `SUMMARY_PER_MINUTES_RES_V2`
		WHERE `PROFILE_ID` = ".$id."
		AND PERIODE = '".$periode."'
		GROUP BY DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d'),CHANNEL,PROGRAM,BEGIN_PROGRAM

		";
		mysqli_query($con,$script_doneb_s);  
		
		$percentage = $percentage + (3/$int_prog);
						$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
						//mysqli_query($con,$script_doneb_s);  
		
		// TVCC
		$script_doneb_s = "
		DELETE FROM M_SUMMARY_TVCC_30_RES
		WHERE `PROFILE_ID` = ".$id."
		AND DATE_FORMAT(`DATE`,'%Y-%M') = '".$periode."'
		";
		mysqli_query($con,$script_doneb_s); 
		
		$script_doneb_s = '
		INSERT INTO M_SUMMARY_TVCC_30_RES 
						SELECT CHANNEL,PROGRAM,DATES,M1_START,M1_END,AVG(VIEWERS) AS AVG, AVG(UNIVERSE) AS UNIVERSE, AVG(ALL_VIEWS) AS ALL_VIEWERS,
						AVG(TVS)*100 AS TVS, AVG(TVR)*100 AS TVR,AVG(VIEWERS_A) AS VIEWERS_A, AVG(UNIVERSE_A) AS UNIVERSE_A, AVG(ALL_VIEWS_A) AS ALL_VIEWS_A,
						AVG(TVS_A)*100 AS TVS_A, AVG(TVR_A)*100 AS TVR_A,PROFILE_ID FROM (
									
							SELECT *,DATE_FORMAT(SPLIT_MINUTES,"%Y-%m-%d") DATES,

							CONCAT(SUBSTR(SPLIT_MINUTES,12,2),
							IF(SUBSTR(SPLIT_MINUTES,15,2) < 30,":00:00",":30:00")) M1_START,
						 
											
							IF(SUBSTR(SPLIT_MINUTES,15,2) < 30,CONCAT(SUBSTR(SPLIT_MINUTES,12,2),":30:00"),
							IF(SUBSTR(SPLIT_MINUTES,12,2)+1 < 10,CONCAT("0",SUBSTR(SPLIT_MINUTES,12,2)+1,":00:00"),CONCAT(SUBSTR(SPLIT_MINUTES,12,2)+1,":00:00"))
							)  M1_END FROM `SUMMARY_PER_MINUTES_RES_V2` 
								WHERE `PROFILE_ID` = '.$id.' AND PERIODE = "'.$periode.'"
						) L
						GROUP BY CHANNEL,PROGRAM,DATES,M1_START,M1_END
		';
		mysqli_query($con,$script_doneb_s);  
		
		$script_check = "	DELETE FROM M_CIM_F2A_SUMMARY_CB_RES WHERE DATE_FORMAT(`DATE_UNICS`,'%Y-%M') = '".$periode."' AND `ID_PROFILE` =  ".$id;	
				$query_check =  mysqli_query($con,$script_check);
		
		 $script_check = "
				 INSERT INTO PTV_CIM_RATING_RES
												SELECT  STR_TO_DATE(`DATE`,'%d/%m/%Y') DATES,A.CHANNEL,PROGRAM,B.SPLIT_MINUTES,TIME,TIME AS SS,DURATION,`BRAND`,
												RATE,RATECARD, RATECARD AS NETPRICE,ADVERTISER,AGENCY,HOUSE_NUMBER,STATUS,'UseeTV' AS PROVIDER,
												B.`VIEWERS`, ALL_VIEWS,UNIVERSE, (B.`VIEWERS`/ALL_VIEWS)*100 AS TVS,(B.`VIEWERS`/UNIVERSE)*100 AS TVR, ".$id." II, 0 re  FROM
												(

													SELECT *,
													CONCAT(STR_TO_DATE(`DATE`,'%d/%m/%Y'),' ',SUBSTRING(B.`TIME` ,1, 2),':',SUBSTRING(B.`TIME`, 4, 2),':00' ) AS MINUTES 
													FROM `LOGPROOF_".$name_tbs3 ."_FULL_STEP2` B
													WHERE `RATECARD` > 0
													
												) A,
												(
													SELECT ALL_VIEWS,VIEWERS,SPLIT_MINUTES,UNIVERSE,CHANNEL,PROGRAM FROM `SUMMARY_PER_MINUTES_RES_V2`
													WHERE `PERIODE` = '".$periode."'
													AND PROFILE_ID = ".$id."
												) B
												WHERE A.CHANNEL = B.CHANNEL AND A.MINUTES = B.SPLIT_MINUTES 
												ORDER BY SPLIT_MINUTES,CHANNEL,PROGRAM";
				 $query_check =  mysqli_query($con,$script_check);
				 
			$script_check = "	DELETE FROM M_SUMMARY_MEDIA_PLAN_D_RES `ID_PROFILE` =  ".$id;	
			//	$query_check =  mysqli_query($con,$script_check);
				
				
				//MONTHLY CHANNEL 
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_RES_FULL`
						SELECT A.CHANNEL,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,0 AS STS FROM (
							SELECT CHANNEL,AVG(VIEWERS) AS AUDIENCE,AVG(VIEWERS_ALL) AS AUDIENCE_ALL,".$id." ID_PROFILE  FROM (
								SELECT CHANNEL,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2021`
								WHERE RESPID IN (".$sql_c.")
								GROUP BY RESPID,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,HARIS
							) P GROUP BY CHANNEL
						) A JOIN (
							SELECT `CHANNEL`,
							AVG(VIEWERS)/1000 AS VIEWERS, AVG(VIEWERS_A)/1000 AS VIEWERS2,
							AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
							AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = ".$id."
							GROUP BY CHANNEL
						) B ON A.CHANNEL = B.CHANNEL
						JOIN (
							SELECT `respondents` AS UNIVERSE, `respondents_all` AS UNIVERSE_ALL, `id` AS ID_PROFILE 
							FROM  `t_profiling_ub_res` WHERE `id` = ".$id."
						) C ON A.ID_PROFILE = C.ID_PROFILE
						JOIN (
							SELECT CHANNEL, `VIEWERS` AS UNIVERSE_IDX, `VIEWERS2` AS UNIVERSE_IDX_ALL FROM  `M_SUM_TV_DASH_CHAN_RES` A
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '0'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 0 
						) D ON A.CHANNEL = D.CHANNEL ";
		mysqli_query($con,$clean_epg_Query);
	

		//DAILY CHANNEL
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_DAY_RES_FULL`
						SELECT A.CHANNEL,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,A.HARIS,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,0 AS STS FROM (
							SELECT CHANNEL,AVG(VIEWERS) AS AUDIENCE,AVG(VIEWERS_ALL) AS AUDIENCE_ALL,HARIS,".$id." ID_PROFILE  FROM (
								SELECT CHANNEL,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2021`
								WHERE RESPID IN (".$sql_c.")
								GROUP BY RESPID,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,HARIS
							) P GROUP BY CHANNEL,HARIS
						) A JOIN (
							SELECT `CHANNEL`,
							AVG(VIEWERS)/1000 AS VIEWERS, AVG(VIEWERS_A)/1000 AS VIEWERS2,
							AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
							AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2,
							DATE_FORMAT(SPLIT_MINUTES,'%Y-%m-%d') AS HARIS
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = ".$id."
							GROUP BY CHANNEL,DATE_FORMAT(SPLIT_MINUTES,'%Y-%m-%d')
						) B ON A.CHANNEL = B.CHANNEL AND A.HARIS = B.HARIS
						JOIN (
							SELECT `respondents` AS UNIVERSE, `respondents_all` AS UNIVERSE_ALL, `id` AS ID_PROFILE 
							FROM  `t_profiling_ub_res` WHERE `id` = ".$id."
						) C ON A.ID_PROFILE = C.ID_PROFILE
						JOIN (
							SELECT CHANNEL, `VIEWERS` AS UNIVERSE_IDX, `VIEWERS2` AS UNIVERSE_IDX_ALL, `DATE` FROM  `M_SUM_TV_DASH_CHAN_DAY_RES` A
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '0'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 0 
						) D ON A.CHANNEL = D.CHANNEL AND A.HARIS = D.DATE;  ";
		mysqli_query($con,$clean_epg_Query);
		
		//------- END CHANNEL

		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_RES_FULL`
		SELECT `CHANNEL`,`VIEWERS`,`VIEWERS2`,`TANGGAL`,`AUDIENCE`,`TVR`,`TVS`,`REACH`,`INDEX`,`ID_PROFILE`,1 `STATUS` FROM `M_SUM_TV_DASH_CHAN_RES_FULL`
		WHERE TANGGAL = '".$periode."' AND `STATUS`=0
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
		
		
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_DAY_RES_FULL`
		SELECT `CHANNEL`,`VIEWERS`,`VIEWERS2`,`TANGGAL`,`DATE`,`AUDIENCE`,`TVR`,`TVS`,`REACH`,`INDEX`,`ID_PROFILE`, 1 `STATUS`  FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL`
		WHERE TANGGAL = '".$periode."' AND `STATUS`=0 
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
				
		
$clean_epg_Query = "
		DELETE FROM `M_SUM_TV_DASH_PROG_RES_FULL`
		WHERE TANGGAL = '".$periode."' 
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
		
		
		$clean_epg_Query = "
		DELETE FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`
		WHERE TANGGAL = '".$periode."' 
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
		
		
		//MONTHLY PROGRAM
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_PROG_RES_FULL`
						SELECT A.CHANNEL,A.PROGRAM,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,0 AS STS, 0 AS TYPES FROM (
							SELECT CHANNEL,PROGRAM,AVG(VIEWERS) AS AUDIENCE,AVG(VIEWERS_ALL) AS AUDIENCE_ALL,".$id." ID_PROFILE  FROM (
								SELECT CHANNEL,PROGRAM,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2021`
								WHERE RESPID IN (".$sql_c.") 
								GROUP BY RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,PROGRAM,HARIS
							) P GROUP BY CHANNEL,PROGRAM
						) A JOIN (
							SELECT `CHANNEL`,PROGRAM,
							AVG(VIEWERS)/1000 AS VIEWERS, AVG(VIEWERS_A)/1000 AS VIEWERS2,
							AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
							AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = ".$id."
							GROUP BY CHANNEL,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
						JOIN (
							SELECT `respondents` AS UNIVERSE, `respondents_all` AS UNIVERSE_ALL, `id` AS ID_PROFILE 
							FROM  `t_profiling_ub_res` WHERE `id` = ".$id."
						) C ON A.ID_PROFILE = C.ID_PROFILE
						JOIN (
							SELECT CHANNEL,PROGRAM, `VIEWERS` AS UNIVERSE_IDX, `VIEWERS2` AS UNIVERSE_IDX_ALL FROM  `M_SUM_TV_DASH_PROG_RES` A
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '0'  AND A.DATA_TYPE = 'TVR_S' AND A.`STATUS` = 0 
						) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM;";
		mysqli_query($con,$clean_epg_Query);

		
		//DAILY PROGRAM
		$clean_epg_Query = "
			INSERT INTO `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`
						SELECT A.CHANNEL,A.PROGRAM,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,A.HARIS,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,0 AS STS, 0 AS TYPES FROM (
							SELECT CHANNEL,PROGRAM,AVG(VIEWERS) AS AUDIENCE,AVG(VIEWERS_ALL) AS AUDIENCE_ALL,".$id." ID_PROFILE,HARIS  FROM (
								SELECT CHANNEL,PROGRAM,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2021`
								WHERE RESPID IN (".$sql_c.") 
								GROUP BY RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,PROGRAM,HARIS
							) P GROUP BY CHANNEL,PROGRAM,HARIS
						) A JOIN (
							SELECT `CHANNEL`,PROGRAM,
							AVG(VIEWERS)/1000 AS VIEWERS, AVG(VIEWERS_A)/1000 AS VIEWERS2,
							AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
							AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2,
							DATE_FORMAT(SPLIT_MINUTES,'%Y-%m-%d') AS HARIS
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = ".$id."
							GROUP BY CHANNEL,PROGRAM,DATE_FORMAT(SPLIT_MINUTES,'%Y-%m-%d')
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.HARIS = B.HARIS
						JOIN (
							SELECT `respondents` AS UNIVERSE, `respondents_all` AS UNIVERSE_ALL, `id` AS ID_PROFILE 
							FROM  `t_profiling_ub_res` WHERE `id` = ".$id."
						) C ON A.ID_PROFILE = C.ID_PROFILE
						JOIN (
							SELECT CHANNEL,PROGRAM, `VIEWERS` AS UNIVERSE_IDX, `VIEWERS2` AS UNIVERSE_IDX_ALL, `DATE` FROM  M_SUM_TV_DASH_PROG_DAY_RES A
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '0'  AND A.DATA_TYPE = 'TVR_S' AND A.`STATUS` = 0 
						) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM AND A.HARIS = D.DATE;  
		";
		mysqli_query($con,$clean_epg_Query);

$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_PROG_RES_FULL`
						SELECT A.CHANNEL,A.PROGRAM,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,0 AS STS, 1 AS TPE FROM (
							SELECT CHANNEL,CONCAT(PROGRAM,' ',BEGIN_PROGRAM) AS PROGRAM,AVG(VIEWERS) AS AUDIENCE,AVG(VIEWERS_ALL) AS AUDIENCE_ALL,".$id." ID_PROFILE  FROM (
								SELECT CHANNEL,PROGRAM,BEGIN_PROGRAM,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2021`
								WHERE RESPID IN (".$sql_c.")
								GROUP BY RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM,HARIS
							) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM
						) A JOIN (
							SELECT `CHANNEL`,CONCAT(PROGRAM,' ',BEGIN_PROGRAM) AS PROGRAM,
							AVG(VIEWERS)/1000 AS VIEWERS, AVG(VIEWERS_A)/1000 AS VIEWERS2,
							AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
							AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = ".$id."
							GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
						JOIN (
							SELECT `respondents` AS UNIVERSE, `respondents_all` AS UNIVERSE_ALL, `id` AS ID_PROFILE 
							FROM  `t_profiling_ub_res` WHERE `id` = ".$id."
						) C ON A.ID_PROFILE = C.ID_PROFILE
						JOIN (
							SELECT CHANNEL,PROGRAM, `VIEWERS` AS UNIVERSE_IDX, `VIEWERS2` AS UNIVERSE_IDX_ALL FROM  `M_SUM_TV_DASH_PROG_RES` A
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '0'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 0 
						) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM
						ORDER BY AUDIENCE DESC;

		";
		mysqli_query($con,$clean_epg_Query);
		
		
		//DAILY AUDIENCE PROGRAM
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`
						SELECT A.CHANNEL,A.PROGRAM,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,A.HARIS,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,0 AS STS, 1 AS TPE FROM (
							SELECT CHANNEL,CONCAT(PROGRAM,' ',BEGIN_PROGRAM) AS PROGRAM, AVG(VIEWERS) AS AUDIENCE,AVG(VIEWERS_ALL) AS AUDIENCE_ALL,".$id." ID_PROFILE,HARIS  FROM (
								SELECT CHANNEL,PROGRAM,BEGIN_PROGRAM,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2021`
								WHERE RESPID IN (".$sql_c.")
								GROUP BY RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM,HARIS
							) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM,HARIS
						) A JOIN (
							SELECT `CHANNEL`,CONCAT(PROGRAM,' ',BEGIN_PROGRAM) AS PROGRAM,
							AVG(VIEWERS)/1000 AS VIEWERS, AVG(VIEWERS_A)/1000 AS VIEWERS2,
							AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
							AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2,
							DATE_FORMAT(SPLIT_MINUTES,'%Y-%m-%d') AS HARIS
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = ".$id."
							GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM,DATE_FORMAT(SPLIT_MINUTES,'%Y-%m-%d')
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.HARIS = B.HARIS
						JOIN (
							SELECT `respondents` AS UNIVERSE, `respondents_all` AS UNIVERSE_ALL, `id` AS ID_PROFILE 
							FROM  `t_profiling_ub_res` WHERE `id` = ".$id."
						) C ON A.ID_PROFILE = C.ID_PROFILE
						JOIN (
							SELECT CHANNEL,PROGRAM, `VIEWERS` AS UNIVERSE_IDX, `VIEWERS2` AS UNIVERSE_IDX_ALL, `DATE` FROM  M_SUM_TV_DASH_PROG_DAY_RES A
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '0'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 0 
						) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM AND A.HARIS = D.DATE;  
		";
		mysqli_query($con,$clean_epg_Query);
		
		$percentage = $percentage + (6.2/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		//mysqli_query($con,$script_doneb_s);  

		
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_PROG_RES_FULL`
		SELECT `CHANNEL`,`PROGRAM`,`VIEWERS`,`VIEWERS2`,`TANGGAL`,`AUDIENCE`,`TVR`,`TVS`,`REACH`,`INDEX`,`ID_PROFILE`,1 `STATUS`,`TYPE` FROM `M_SUM_TV_DASH_PROG_RES_FULL`
		WHERE TANGGAL = '".$periode."' AND `STATUS`=0 
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
		
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`
		SELECT `CHANNEL`,`PROGRAM`,`VIEWERS`,`VIEWERS2`,`TANGGAL`,`DATE`,`AUDIENCE`,`TVR`,`TVS`,`REACH`,`INDEX`,`ID_PROFILE`,1 `STATUS`,`TYPE` FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`
		WHERE TANGGAL = '".$periode."' AND `STATUS`=0 
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
		
		
		#PB
		
		$clean_epg_Query = "
		INSERT INTO PB_DASH_DAYPART_RES 
		SELECT DATE_FORMAT(`DATE`, '%Y-%M'),
		tb_cgi.htype, COUNT(tb_cgi.htype) AS spot, SUM(NET_PRICE) AS COST, MAX(VIEWERS) AS VIEWERS, 0 FTV, ID_PROFILE FROM
              (SELECT *, 
			( CASE WHEN a.`SPLIT_MINUTES` BETWEEN '00:00:00' AND '05:59:59'  THEN '000 - 06:00'
			 WHEN a.SPLIT_MINUTES BETWEEN '06:00:00' AND '07:59:59'  THEN '06:00 - 08:00'
			 WHEN a.SPLIT_MINUTES BETWEEN '08:00:00' AND '11:59:59'  THEN '06:00 - 12:00'
			 WHEN a.SPLIT_MINUTES BETWEEN '12:00:00' AND '17:59:59'  THEN '12:00 - 18:00'
			 WHEN a.SPLIT_MINUTES BETWEEN '18:00:00' AND '21:59:59'  THEN '18:00 - 22:00'
			ELSE '22:00 - 00:00' END
			) AS htype 
              	 FROM `PTV_CIM_RATING_RES` a 
              	 WHERE 1=1 AND 
              	 DATE_FORMAT(`DATE`, '%Y-%M')='".$periode."' 
              	 AND `ID_PROFILE` = ".$id."
              	 ) AS tb_cgi 
						 GROUP BY tb_cgi.htype;
		";
		mysqli_query($con,$clean_epg_Query);
		
		
		$clean_epg_Query = "
		INSERT INTO PB_DASH_DAYS_RES
		SELECT DATE_FORMAT(`DATE`, '%Y-%M'),DATE AS DDD, COUNT(CHANNEL),SUM(NET_PRICE),  MAX(VIEWERS) AS VIEWERS, 0 FTV, ID_PROFILE FROM (

		SELECT * FROM `PTV_CIM_RATING_RES`
		WHERE DATE_FORMAT(`DATE`, '%Y-%M') = '".$periode."' 
		AND `ID_PROFILE` = ".$id."
				GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
				
				) K GROUP BY DATE,ID_PROFILE;
		";
		mysqli_query($con,$clean_epg_Query);
		
		
		$clean_epg_Query = '
		INSERT INTO `PB_DASH_SEGMENT_RES`

SELECT DATE_FORMAT(`DATE`, "%Y-%M"),"NAMA_BRAND" SEGMENT,NAMA_BRAND, COUNT(CHANNEL) DD ,SUM(NET_PRICE), MAX(VIEWERS), 0 S,ID_PROFILE FROM (

SELECT * FROM `PTV_CIM_RATING_RES`
WHERE DATE_FORMAT(`DATE`, "%Y-%M") = "'.$periode.'" 
AND `ID_PROFILE` = '.$id.'
		GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
		
		) K GROUP BY NAMA_BRAND,ID_PROFILE;
		';
		mysqli_query($con,$clean_epg_Query);
		
		
				$clean_epg_Query = '
						INSERT INTO `PB_DASH_SEGMENT_RES`

SELECT DATE_FORMAT(`DATE`, "%Y-%M"),"ADVERTISER" SEGMENT,`ADVERTISER`, COUNT(CHANNEL) DD ,SUM(NET_PRICE), MAX(VIEWERS), 0 S,ID_PROFILE FROM (

SELECT * FROM `PTV_CIM_RATING_RES`
WHERE DATE_FORMAT(`DATE`, "%Y-%M") =  "'.$periode.'" 
AND `ID_PROFILE` = '.$id.'
		GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
		
		) K GROUP BY ADVERTISER,ID_PROFILE;
		';
		mysqli_query($con,$clean_epg_Query);
		
		
					$clean_epg_Query = '
						INSERT INTO `PB_DASH_SEGMENT_RES`

SELECT DATE_FORMAT(`DATE`, "%Y-%M"),"AGENCY" SEGMENT,`AGENCY`, COUNT(CHANNEL) DD ,SUM(NET_PRICE), MAX(VIEWERS), 0 S,ID_PROFILE FROM (

SELECT * FROM `PTV_CIM_RATING_RES`
WHERE DATE_FORMAT(`DATE`, "%Y-%M") = "'.$periode.'" 
AND `ID_PROFILE` = '.$id.'
		GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
		
		) K GROUP BY AGENCY,ID_PROFILE;
		';
		mysqli_query($con,$clean_epg_Query);	
		
		
							$clean_epg_Query = '
														INSERT INTO `PB_DASH_SEGMENT_RES`

SELECT DATE_FORMAT(`DATE`, "%Y-%M"),"PO_NUMBER" SEGMENT,`PO_NUMBER`, COUNT(CHANNEL) DD ,SUM(NET_PRICE), MAX(VIEWERS), 0 S,ID_PROFILE FROM (

SELECT * FROM `PTV_CIM_RATING_RES`
WHERE DATE_FORMAT(`DATE`, "%Y-%M") = "'.$periode.'" 
AND `ID_PROFILE` = '.$id.'
		GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
		
		) K GROUP BY PO_NUMBER,ID_PROFILE;
		';
		mysqli_query($con,$clean_epg_Query);	
		
		
									$clean_epg_Query = '
INSERT INTO `PB_DASH_SEGMENT2_RES`

SELECT DATE_FORMAT(`DATE`, "%Y-%M"),"PROGRAM" SEGMENT,CHANNEL,`PROGRAM`, COUNT(CHANNEL) DD ,SUM(NET_PRICE), MAX(VIEWERS), 0 S,ID_PROFILE FROM (

SELECT * FROM `PTV_CIM_RATING_RES`
WHERE DATE_FORMAT(`DATE`, "%Y-%M") = "'.$periode.'" 
AND `ID_PROFILE` = '.$id.'
		GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
		
		) K GROUP BY CHANNEL,PROGRAM,ID_PROFILE;
		';
		mysqli_query($con,$clean_epg_Query);	
		
		
		
											$clean_epg_Query = '
												INSERT INTO `PB_DASH_CHANNEL_RES`

SELECT DATE_FORMAT(`DATE`, "%Y-%M"),CHANNEL,COUNT(CHANNEL) DD ,SUM(NET_PRICE), MAX(VIEWERS), 0 S,ID_PROFILE FROM (

SELECT * FROM `PTV_CIM_RATING_RES`
WHERE DATE_FORMAT(`DATE`, "%Y-%M") = "'.$periode.'" 
AND `ID_PROFILE` = '.$id.'
		GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
		
		) K GROUP BY CHANNEL,ID_PROFILE;
		';
		mysqli_query($con,$clean_epg_Query);	
		
		
													$clean_epg_Query = "
													INSERT INTO `PB_DASH_SPOTCOST_RES`
SELECT DATE_FORMAT(`DATE`, '%Y-%M'),COUNT(CHANNEL) DD ,SUM(NET_PRICE), VVV, 0 S,K.ID_PROFILE FROM (

SELECT * FROM `PTV_CIM_RATING_RES`
WHERE DATE_FORMAT(`DATE`, '%Y-%M') = '".$periode."' 
AND ID_PROFILE = ".$id."
		GROUP BY CHANNEL, DATE, START_TIME, NAMA_BRAND,ID_PROFILE
		
		) K,(
			SELECT SUM(WEIGHT) AS VVV,ID_PROFILE FROM (
				SELECT RESPID,WEIGHT,ID_PROFILE FROM (
					 SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2021`
					 WHERE (DATE_FORMAT(`BEGIN_PROGRAM`, '%Y-%M')  = '".$periode."'  OR
					 DATE_FORMAT(`END_PROGRAM`, '%Y-%M')  = '".$periode."'  )
				 ) A JOIN (
					SELECT *,
					CONCAT(`DATE`,' ',SPLIT_MINUTES) AS MINUTES 
					FROM `PTV_CIM_RATING_RES` B
					WHERE DATE_FORMAT(`DATE`, '%Y-%M') = '".$periode."' 
					AND ID_PROFILE = ".$id."
				 ) B ON B.MINUTES BETWEEN BEGIN_PROGRAM AND END_PROGRAM AND A.CHANNEL = B.CHANNEL
				 GROUP BY RESPID,ID_PROFILE
			) A
		) L WHERE K.ID_PROFILE = L.ID_PROFILE;
													";
		mysqli_query($con,$clean_epg_Query);	
		
		$sql_edit = " update M_MONTH_PROFILE_RES set DATE_FINISH = '".date('Y-m-d H:i:s')."', STATUS_PROCESS = '1' WHERE PERIODE = '".$arp."' AND PROFILE_ID = ".$id;
		$query_edt =  mysqli_query($con,$sql_edit);  
		
		$response = file_get_contents('http://dev-db.u.1elf.net/ff/sync_data.php?p='.$arp.'&id='.$id);
		
		}
		
	}
		
?>
