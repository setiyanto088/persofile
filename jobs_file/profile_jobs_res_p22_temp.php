<?php 

	include '/var/www/file/cfg.php';  
	 	
	$s = $_SERVER['argv'];
	$id = $s[1];
	
	
	
	$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$id; 
	
	
	$script_check = "SELECT * FROM `t_profiling_ub_res` WHERE id = ".$id;   
						
	$query_check =  mysqli_query($con,$script_check);  
	$check_progress = mysqli_fetch_array($query_check);

	$universe = $check_progress['respondents_all'];
	$user_id_profil = $check_progress['user_id_profil'];
	
	//ECHO $universe;DIE;
	
	$arr_periode = array();
	$int_prog = 0;
	$percentage = 0;
		
	$periode_list_script = "SELECT PERIODE FROM M_MONTH_PROFILE_RES_P22 WHERE PROFILE_ID = ".$id." AND STATUS_PROCESS = 2 ORDER BY PERIODE DESC ";   
						
	$query_periode_list =  mysqli_query($con,$periode_list_script);  
	while($row_PER = mysqli_fetch_array($query_periode_list)){
			
		$arr_periode[] = $row_PER['PERIODE'];
		$int_prog = $int_prog+1;
			
	}
	
	$sql_edit = " update t_profiling_ub_res set status_job = 2, date_process = '".date('Y-m-d H:i:s')."', global_progress = '".$percentage." %' WHERE id = ".$id;
	$query_edt =  mysqli_query($con,$sql_edit); 
	
	$row_users['PROFILE_ID'] = $id;
	
	//-------------------------------------------------------------------------------------------------
		
	foreach($arr_periode as $arp){
		
		$sql_edit = " update M_MONTH_PROFILE_RES_P22 set DATE_PROCESS = '".date('Y-m-d H:i:s')."', STATUS_PROCESS = '3' WHERE PERIODE = '".$arp."' AND PROFILE_ID = ".$id;
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
		
		
		$end_date_m = cal_days_in_month(CAL_GREGORIAN,strtoupper(date_format(date_create($data_file),"m")),strtoupper(date_format(date_create($data_file),"Y")));
		
		$start_date_periode = strtoupper(date_format(date_create($data_file),"Y-m")).'-01';
		$end_date_periode = strtoupper(date_format(date_create($data_file),"Y-m")).'-'.$end_date_m;
		//print_r($start_date_periode.'-'.$end_date_periode);die;
		
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s);  
		//echo $periode;die;
		
		$sql_edit = " DELETE FROM SUMMARY_PER_MINUTES_RES_V2 WHERE PROFILE_ID = ".$id." AND PERIODE = '".$periode."' ";
		$query_edt =  mysqli_query($con,$sql_edit); 
		// rating per minute
		
		// $sql_edit = " 		
			// INSERT INTO `SUMMARY_PER_MINUTES_RES_V2`
			// SELECT CHANNEL,`KATEGORI_CHANNEL`,`PROGRAM`,`BEGIN_PROGRAM`,`END_PROGRAM`,
			// `GENRE_PROGRAM`,`SPLIT_MINUTES`,SUM(WEIGHT) `VIEWERS`,SUM(WEIGHT_ALL) `VIEWERS_A`,
			// '".$periode."' PERIODE, ".$id." PID, 0 SD, 0 `ALL_VIEWS`, 0 `ALL_VIEWS_A`, 0 `TVS`, 0 `TVS_A`,
			// 0 `TVR`, 0 `TVR_A`, 0 `UNIVERSE`, 0 `UNIVERSE_A` FROM (
									
			// SELECT A.* FROM CDR_EPG_RES_".$name_tbs_new."_SPLIT_STEP4_V2_2021 A
			// WHERE A.RESPID IN (".$sql_c.")

			// ) O GROUP BY SPLIT_MINUTES, CHANNEL, PROGRAM

		// ";
		$sql_edit = "
			INSERT INTO `SUMMARY_PER_MINUTES_RES_V2`
			SELECT CHANNEL,`KATEGORI_CHANNEL`,`PROGRAM`,`BEGIN_PROGRAM`,`END_PROGRAM`,
						`GENRE_PROGRAM`,O.`SPLIT_MINUTES`,SUM(WEIGHT) `VIEWERS`,SUM(WEIGHT_ALL) `VIEWERS_A`,
						'".$periode."' PERIODE, ".$id." PID, 0 SD, ALL_VIEWSS `ALL_VIEWS`, ALL_VIEWSS `ALL_VIEWS_A`, 
						(SUM(WEIGHT)/ALL_VIEWSS) `TVS`, (SUM(WEIGHT_ALL)/ALL_VIEWSS) `TVS_A`,
						(SUM(WEIGHT)/".$universe.") `TVR`, (SUM(WEIGHT)/".$universe.") `TVR_A`, ".$universe." `UNIVERSE`, ".$universe." `UNIVERSE_A` FROM (
							SELECT A.* FROM CDR_EPG_RES_".$name_tbs_new."_SPLIT_STEP4_V2_2022 A
							WHERE A.RESPID IN (SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$id." )
							GROUP BY RESPID,SPLIT_MINUTES, CHANNEL, PROGRAM 
						) O JOIN (
							SELECT SUM(WEIGHT) AS ALL_VIEWSS, SPLIT_MINUTES FROM (
								SELECT RESPID,SPLIT_MINUTES,WEIGHT FROM CDR_EPG_RES_".$name_tbs_new."_SPLIT_STEP4_V2_2022 A
								WHERE A.RESPID IN (SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$id." )
								GROUP BY RESPID,SPLIT_MINUTES
							) A GROUP BY SPLIT_MINUTES
						) B ON O.SPLIT_MINUTES = B.SPLIT_MINUTES
						GROUP BY O.SPLIT_MINUTES, CHANNEL, PROGRAM 
		";
		
		//echo $sql_edit;die;
		$query_edt =  mysqli_query($con,$sql_edit); 
	
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s); 
	
		// $sql_edit = "	
		// UPDATE `SUMMARY_PER_MINUTES_RES_V2` A JOIN (
		// SELECT SPLIT_MINUTES, SUM(VIEWERS) AS ALL_VIEWS, 
		// SUM(VIEWERS_A) AS ALL_VIEWS_A 
		// FROM SUMMARY_PER_MINUTES_RES_V2
		// WHERE PROFILE_ID = ".$id."
		// AND PERIODE = '".$periode."'
		// GROUP BY SPLIT_MINUTES
		// ) B ON A.SPLIT_MINUTES = B.SPLIT_MINUTES
		// SET A.`ALL_VIEWS` = B.ALL_VIEWS, A.`ALL_VIEWS_A` = B.ALL_VIEWS_A;
		// ";
		// $query_edt =  mysqli_query($con,$sql_edit); 
		
		// $sql_edit = "	
		// UPDATE `SUMMARY_PER_MINUTES_RES_V2` A ,(
		// SELECT `ID_PROFILE`,SUM(B.WEIGHT) VIEWERS,SUM(B.WEIGHT) VIEWERS_A FROM `PROFILE_CARDNO_RES` A 
		// JOIN URBAN_PROFILE_2021 B 
		// ON A.`CARDNO` = B.RESPID
		// WHERE A.ID_PROFILE = ".$id." ) B
		// SET A.UNIVERSE = B.VIEWERS,
		// A.UNIVERSE_A = B.VIEWERS_A
		// WHERE PROFILE_ID = ".$id."
		// AND PERIODE = '".$periode."';
		// ";
		// $query_edt =  mysqli_query($con,$sql_edit); 

		// // $sql_edit = "
		// // UPDATE `SUMMARY_PER_MINUTES_RES_V2` A ,(
		// // SELECT `VIEWERS` FROM `M_SUM_TV_DASH_OTHER_RES` 
		// // WHERE FIELDS = 'UNIVERSE ALL' ) B
		// // SET A.UNIVERSE_A = B.VIEWERS
		// // WHERE PROFILE_ID = ".$id."
		// // AND PERIODE = '".$periode."';
		// // ";
		// // $query_edt =  mysqli_query($con,$sql_edit); 

		// $sql_edit = "
		// UPDATE SUMMARY_PER_MINUTES_RES_V2
		// SET `TVS` = `VIEWERS` / `ALL_VIEWS`,
		// `TVS_A` = `VIEWERS_A` / `ALL_VIEWS_A`,
		// `TVR` = `VIEWERS` / `UNIVERSE`,
		// `TVR_A` = `VIEWERS_A` / `UNIVERSE_A`
		// WHERE PROFILE_ID = ".$id."
		// AND PERIODE = '".$periode."';
		// ";
		// $query_edt =  mysqli_query($con,$sql_edit); 
	
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s);  
	
	
		// Mediaplan
		$script_doneb_s = "
		DELETE FROM M_SUMMARY_MEDIA_PLAN_D_RES
		WHERE `PROFILE_ID` = ".$id."
		AND PERIODE = '".$periode."'
		";
		mysqli_query($con,$script_doneb_s);  
		
		$script_doneb_s = "
				INSERT INTO M_SUMMARY_MEDIA_PLAN_D_RES
SELECT RC.`DATE`,RC.CHANNEL,RC.`PROGRAM`,RC.`TITTLE`,RC.`TYPE`,RC.`STATUS`,RC.`START_TIME`,RC.`END_TIME`,RC.`DURATION`,
RC.RATE,RC.`LEVEL1`,RC.`LEVEL2`,RC.`SPLIT_MINUTES`, 0 AS `FLAG_TV`, '".$periode."' AS PERIODE,
IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('00:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('06:00:00' AS TIME) ,'00:00 - 06:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('06:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('08:00:00' AS TIME) ,'06:00 - 08:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('08:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('12:00:00' AS TIME) ,'08:00 - 12:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('12:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('18:00:00' AS TIME) ,'12:00 - 18:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('18:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('22:00:00' AS TIME) ,'18:00 - 22:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('22:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('23:59:59' AS TIME) ,'22:00 - 00:00','00:00 - 06:00')
							  )
							  )
							  )
							  )
							  ) AS DPART,AVG(`VIEWERS`),AVG(`ALL_VIEWS`),`UNIVERSE`,AVG(`TVR`),AVG(`TVS`),0 IDX,AVG(`VIEWERS_A`),AVG(`ALL_VIEWS_A`)
							  ,`UNIVERSE_A`,AVG(`TVR_A`),AVG(`TVS_A`),0 `IDX_A`,`PROFILE_ID`  FROM DM_RATECARD_".$name_tbs2."_SPLIT_PTV RC JOIN 
							  (
								  SELECT * FROM `SUMMARY_PER_MINUTES_RES_V2` 
								  WHERE PERIODE = '".$periode."' AND `PROFILE_ID` = ".$id."
							  ) B 
							  ON RC.CHANNEL = B.CHANNEL AND RC.SPLIT_MINUTES = B.SPLIT_MINUTES
							 GROUP BY RC.`DATE`,RC.CHANNEL, RC.PROGRAM, RC.START_TIME
		";
		//mysqli_query($con,$script_doneb_s);  
		
		
		$script_doneb_s = "
						
						UPDATE M_SUMMARY_MEDIA_PLAN_D_RES A
						JOIN  (
						SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_RES
						WHERE `PROFILE_ID` = 0
						) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME AND B.START_TIME
						SET `IDX` = (A.TVR/B.TVR)*100, IDX_A = (A.TVR_A/B.TVR_A)*100 
						WHERE A.`PROFILE_ID` = ".$id."
						AND A.PERIODE = '".$periode."' 
						";
						//mysqli_query($con,$script_doneb_s); 
		

		// mediaplan PTV
		
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
		
						$percentage = $percentage + (8/$int_prog);
						$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
						mysqli_query($con,$script_doneb_s);  
		// TVPC
		
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
		
		$percentage = $percentage + (8/$int_prog);
						$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
						mysqli_query($con,$script_doneb_s);  
		
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
		
		$percentage = $percentage + (8/$int_prog);
						$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
						mysqli_query($con,$script_doneb_s);  
		
		// POSTBUY AND MAEDIAPLAN FTA
		
		$script_check = "	DELETE FROM M_CIM_F2A_SUMMARY_CB_RES WHERE DATE_FORMAT(`DATE_UNICS`,'%Y-%M') = '".$periode."' AND `ID_PROFILE` =  ".$id;	
				$query_check =  mysqli_query($con,$script_check);
				
				// $script_check = "	 
				// INSERT INTO M_CIM_F2A_SUMMARY_CB_RES
				// SELECT  VW.CHANNEL, '' AS L, VW.CHANNEL AS CHN,VW.PROGRAM, '' AS A,'' AS AA,
				// VW.SECTOR, VW.CATEGORY,VW.ADVERTISER, VW.PRODUCT, VW.COPY, VW.ADS_TYPE,
				// VW.START_TIME, VW.END_TIME, VW.SPLIT_MINUTES, 
				// TIMEDIFF(VW.END_TIME,VW.START_TIME), VW.COST,VW.DATE_UNICS, 0 AS CCC, 
				// VIEWERS, 
				// ALL_VIEWERS, 
				// RESP.`respondents` UNIVERSE,
				// VIEWERS_ALL, 
				// ALL_VIEWERS_ALL, 
				// RESP.`respondents_all` UNIVERSE_ALL,
				// ROUND((VIEWERS/ALL_VIEWERS)*100,3) TVS ,
				// ROUND((VIEWERS/RESP.`respondents`)*100,3) TVR,
				// ROUND((ALL_VIEWERS/ALL_VIEWERS_ALL)*100,3) TVS_ALL ,
				// ROUND((ALL_VIEWERS/RESP.`respondents_all`)*100,3) TVR_ALL,
				// ".$row_users['PROFILE_ID']." idm 
										  
				// FROM
				// (
				// SELECT A.*,SUM(WEIGHT) VIEWERS, SUM(WEIGHT_ALL) VIEWERS_ALL FROM (
				// SELECT A.*,B.JENIS_HARI,B.DAYPART,B.AGE,B.GENDER,C.WEIGHT,C.WEIGHT AS WEIGHT_ALL FROM (
				// SELECT A.*,REPLACE(REPLACE(KATEGORI_CHANEL, '\r', ''), '\n', '') KATEGORI_CHANEL,REPLACE(REPLACE(GENRE_PROGRAM, '\r', ''), '\n', '') GENRE_PROGRAM 
				// FROM M_SUMM_POSTBUY_NEW_".$name_tbs."_RES A
				// LEFT JOIN EPG_SPLIT B ON A.CHANNEL = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTE
				// ) A JOIN DATASET_VIEW_ASSIGNMENT_V4_2021 B ON A.CARDNO = B.CARDNO
				 // AND A.GENRE_PROGRAM = B.GENRE_PROGRAM
				 // JOIN URBAN_PROFILE_2021 C ON B.RESPID = C.RESPID
				 // JOIN `PROFILE_CARDNO_RES` D ON B.RESPID = D.CARDNO
				 // WHERE D.`ID_PROFILE` = ".$row_users['PROFILE_ID']."
				 // GROUP BY SPLIT_MINUTES,A.CHANNEL,PROGRAM,PRODUCT,START_TIME,END_TIME,B.RESPID
				 // ) A
				 // GROUP BY SPLIT_MINUTES,CHANNEL,PROGRAM,PRODUCT,START_TIME,END_TIME
				 // ) VW,(
				 // SELECT A.*,SUM(WEIGHT) ALL_VIEWERS, SUM(WEIGHT_ALL) ALL_VIEWERS_ALL FROM (
				// SELECT A.*,B.JENIS_HARI,B.DAYPART,B.AGE,B.GENDER,C.WEIGHT,C.WEIGHT AS WEIGHT_ALL FROM (
				// SELECT A.*,REPLACE(REPLACE(KATEGORI_CHANEL, '\r', ''), '\n', '') KATEGORI_CHANEL,REPLACE(REPLACE(GENRE_PROGRAM, '\r', ''), '\n', '') GENRE_PROGRAM 
				// FROM M_SUMM_POSTBUY_NEW_".$name_tbs."_RES A
				// LEFT JOIN EPG_SPLIT B ON A.CHANNEL = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTE
				// ) A JOIN DATASET_VIEW_ASSIGNMENT_V4_2021 B ON A.CARDNO = B.CARDNO
				 // AND A.GENRE_PROGRAM = B.GENRE_PROGRAM
				 // JOIN URBAN_PROFILE_2021 C ON B.RESPID = C.RESPID
				 // JOIN `PROFILE_CARDNO_RES` D ON B.RESPID = D.CARDNO
				 // WHERE D.`ID_PROFILE` = ".$row_users['PROFILE_ID']."
				 // GROUP BY SPLIT_MINUTES,B.RESPID
				 // ) A
				 // GROUP BY SPLIT_MINUTES
				 // ) ALLVW,(
					
					// SELECT * FROM t_profiling_ub_res
					// WHERE id = ".$row_users['PROFILE_ID']."
				 
				 // ) RESP
				 // WHERE VW.SPLIT_MINUTES = ALLVW.SPLIT_MINUTES
				// ";	
				// $query_check =  mysqli_query($con,$script_check);
				
				$script_check = "
				INSERT INTO `M_CIM_F2A_SUMMARY_CB_RES`
				 SELECT A.CHANNEL AS CHN,B.DATE,A.CHANNEL AS CHNS,B.PROGRAM,B.LEVEL1,B.`LEVEL2`,`SECTOR`,'' `CATEGORY`,`ADVERTISER`,`PRODUCT`,`COPY`,'' `TYPE`,`START_TIME`,`END_TIME`,
				 B.`SPLIT_MINUTES`,`DURATION`,`COST`,B.DATE `DATE_UNICS`,TIME_TO_SEC(DURATION) `DURATION_INT`,
				AVG(`VIEWERS`),`ALL_VIEWS`,`UNIVERSE`,AVG(`VIEWERS_A`),`ALL_VIEWS_A`,`UNIVERSE_A`,AVG(A.`TVS`)*100,AVG(A.`TVR`)*100,AVG(A.`TVS_A`)*100,AVG(A.`TVR_A`)*100,".$id." `ID_PROFILE`
				  FROM SUMMARY_PER_MINUTES_RES_V2 A
				 JOIN MDM_RAW_CIM_SPLIT_PART3 B ON A.CHANNEL = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTES 
				 WHERE `PERIODE` = '".$periode."'
				 AND `PROFILE_ID` = ".$id."
				 GROUP BY A.CHANNEL,B.DATE,B.PROGRAM,`PRODUCT`,`START_TIME`
				 ";
				 //$query_check =  mysqli_query($con,$script_check);
				 
				 // $script_check = "
				 // INSERT INTO PTV_CIM_RATING_RES
												// SELECT  STR_TO_DATE(`DATE`,'%d/%m/%Y') DATES,A.CHANNEL,PROGRAM,B.SPLIT_MINUTES,TIME,TIME AS SS,DURATION,`BRAND`,
												// RATE,RATECARD, RATECARD AS NETPRICE,ADVERTISER,AGENCY,HOUSE_NUMBER,STATUS,'UseeTV' AS PROVIDER,
												// B.`VIEWERS`, ALL_VIEWS,UNIVERSE, (B.`VIEWERS`/ALL_VIEWS)*100 AS TVS,(B.`VIEWERS`/UNIVERSE)*100 AS TVR, ".$id." II, 0 re  FROM
												// (

													// SELECT *,
													// CONCAT(STR_TO_DATE(`DATE`,'%d/%m/%Y'),' ',SUBSTRING(B.`TIME` ,1, 2),':',SUBSTRING(B.`TIME`, 4, 2),':00' ) AS MINUTES 
													// FROM `LOGPROOF_".$name_tbs3 ."_FULL_STEP2` B
													// WHERE `RATECARD` > 0
													
												// ) A,
												// (
													// SELECT ALL_VIEWS,VIEWERS,SPLIT_MINUTES,UNIVERSE,CHANNEL,PROGRAM FROM `SUMMARY_PER_MINUTES_RES_V2`
													// WHERE `PERIODE` = '".$periode."'
													// AND PROFILE_ID = ".$id."
												// ) B
												// WHERE A.CHANNEL = B.CHANNEL AND A.MINUTES = B.SPLIT_MINUTES 
												// ORDER BY SPLIT_MINUTES,CHANNEL,PROGRAM";
				 // $query_check =  mysqli_query($con,$script_check);
				 
				 $script_check = "
				
				INSERT INTO PTV_CIM_RATING_RES
												
											SELECT * FROM (												
												SELECT  STR_TO_DATE(`DATE`,'%d/%m/%Y') DATES,A.CHANNEL,A.PROGRAM,B.SPLIT_MINUTES,TIME,TIME AS SS,DURATION,`BRAND`,
												RATE,RATECARD, RATECARD AS NETPRICE,ADVERTISER,AGENCY,HOUSE_NUMBER,STATUS,'UseeTV' AS PROVIDER,
												B.`VIEWERS`, ALL_VIEWS,UNIVERSE, (B.`VIEWERS`/ALL_VIEWS)*100 AS TVS,(B.`VIEWERS`/UNIVERSE)*100 AS TVR, ".$id.", (CNTS/UNIVERSE)*100 re  FROM
												(

													SELECT B.*,C.PROGRAM ,
													CONCAT(STR_TO_DATE(`DATE`,'%d/%m/%Y'),' ',SUBSTRING(B.`TIME` ,1, 2),':',SUBSTRING(B.`TIME`, 4, 2),':00' ) AS MINUTES 
													FROM `LOGPROOF_".$name_tbs3 ."_FULL_STEP2` B 
													LEFT JOIN (SELECT IF(CHANNEL = 'ONE','S-ONE',IF(CHANNEL = 'SPOTV','SPO TV',CHANNEL)) AS CHANNEL_NAME,
													* FROM `EPG_SPLIT` WHERE SPLIT_MINUTE BETWEEN '".$start_date_periode." 00:00:00' AND '".$end_date_periode." 23:59:59'
													GROUP BY CHANNEL,PROGRAM,SPLIT_MINUTE) C ON B.CHANNEL = C.CHANNEL_NAME 
													AND CONCAT(STR_TO_DATE(`DATE`,'%d/%m/%Y'),' ',SUBSTRING(B.`TIME` ,1, 2),':',SUBSTRING(B.`TIME`, 4, 2),':00' ) = C.`SPLIT_MINUTE`
													WHERE `RATECARD` > 0
													
												) A LEFT JOIN 
												(
													SELECT ALL_VIEWS,VIEWERS,SPLIT_MINUTES,UNIVERSE,CHANNEL,PROGRAM FROM `SUMMARY_PER_MINUTES_RES_V2`
													WHERE PERIODE = '".$periode."'
													AND PROFILE_ID = ".$id."
												) B ON A.CHANNEL = B.CHANNEL AND A.MINUTES = B.SPLIT_MINUTES
												LEFT JOIN
												(
													 SELECT SUM(WEIGHT) CNTS,A.CHANNEL,MINUTES FROM (
														SELECT COUNT(RESPID) CNT,RESPID,A.CHANNEL_NAME AS CHANNEL,WEIGHT,BRAND,ADVERTISER,AGENCY,HOUSE_NUMBER,B.MINUTES FROM (
															 SELECT A.CHANNEL AS CHANNEL_NAME,A.* FROM `CDR_EPG_RES_ALL_STEP2_2022` A
															 JOIN `PROFILE_CARDNO_RES` F ON A.`RESPID` = F.CARDNO
															 WHERE (`BEGIN_PROGRAM` BETWEEN '".$start_date_periode." 00:00:00' AND '".$end_date_periode." 23:59:59' OR
															 `END_PROGRAM` BETWEEN '".$start_date_periode." 00:00:00' AND '".$end_date_periode." 23:59:59' )
															 AND `ID_PROFILE` = ".$id."
														 ) A JOIN (
															SELECT *,
															CONCAT(STR_TO_DATE(`DATE`,'%d/%m/%Y'),' ',SUBSTRING(B.`TIME` ,1, 2),':',SUBSTRING(B.`TIME`, 4, 2),':00' ) AS MINUTES 
															FROM `LOGPROOF_".$name_tbs3 ."_FULL_STEP2` B
														 ) B ON B.MINUTES BETWEEN BEGIN_PROGRAM AND END_PROGRAM AND A.CHANNEL_NAME = B.CHANNEL
														 GROUP BY RESPID,A.CHANNEL,BRAND,ADVERTISER,AGENCY,HOUSE_NUMBER,B.MINUTES  	
													 ) A WHERE CNT >= 1 GROUP BY CHANNEL,BRAND,ADVERTISER,AGENCY,HOUSE_NUMBER,MINUTES  
												) C  
												ON A.CHANNEL = C.CHANNEL AND A.MINUTES = C.MINUTES
												ORDER BY SPLIT_MINUTES,CHANNEL,PROGRAM
											) GROUP BY `DATES`,`CHANNEL`,`PROGRAM`,`SPLIT_MINUTES`,`TIME`,`BRAND`;
				
				";
				 $query_check =  mysqli_query($con,$script_check);
				 
				
				//PRINT_R($check_progress);DIE;
				
				$script_check = "	DELETE FROM M_SUMMARY_MEDIA_PLAN_D_RES WHERE `ID_PROFILE` =  ".$id;	
				$query_check =  mysqli_query($con,$script_check);
				
				// $script_check = "
				// INSERT INTO M_SUMMARY_MEDIA_PLAN_D_RES
					// SELECT VW.DATE,VW.CHANNEL_STD,VW.PROGRAM,'UNKNOWN' AS TITTLE,ADS_TYPE AS TYPE, 'UNKNOWN' AS STATUS,
					// START_TIME,END_TIME,TIMEDIFF(END_TIME,START_TIME) DURATION,RATE,LEVEL1,LEVEL2,VW.SPLIT_MINUTES,0 FLAG_TV,
					// PERIODE,TIME_PERIODE,AVG(VIEWERS),AVG(ALL_VIEWERS),RESP.`respondents` UNIVERSE, AVG(VIEWERS/RESP.`respondents`)*100 AS TVR, 
					// AVG(VIEWERS/ALL_VIEWERS)*100 AS TVS, 100 AS IDX, AVG(VIEWERS_ALL) AS VIEWER_A,AVG(ALL_VIEWERS_ALL) AS VIEWER_ALL_A,
					// RESP.`respondents_all` UNIVERSE_A, AVG(VIEWERS_ALL/RESP.`respondents_all`)*100 AS TVR_A, 
					// AVG(VIEWERS_ALL/ALL_VIEWERS_ALL)*100 AS TVS_A, 100 AS IDX_A, ".$row_users['PROFILE_ID']." PID FROM (

					// SELECT A.*,SUM(WEIGHT) VIEWERS, SUM(WEIGHT_ALL) VIEWERS_ALL FROM (
					// SELECT A.*,B.JENIS_HARI,B.DAYPART,B.AGE,B.GENDER,C.WEIGHT,C.WEIGHT AS WEIGHT_ALL FROM (
					// SELECT A.*,CM.ADS_TYPE,O.CHANNEL_STD,REPLACE(REPLACE(KATEGORI_CHANEL, '\r', ''), '\n', '') KATEGORI_CHANEL,REPLACE(REPLACE(GENRE_PROGRAM, '\r', ''), '\n', '') GENRE_PROGRAM 
					// FROM M_SUMMARY_MEDIAPLAN_".$name_tbs."N_RES A
					// JOIN CHANNEL_PARAM O ON A.CHANNEL = O.CHANNEL_RC
					// LEFT JOIN EPG_SPLIT B ON O.CHANNEL_STD = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTE
					// LEFT JOIN M_CIM_F2A_N_SPLIT_TEST CM ON A.CHANNEL = CM.CHANNEL AND A.SPLIT_MINUTES = CM.SPLIT_MINUTES
					// ) A JOIN DATASET_VIEW_ASSIGNMENT_V4_2021 B ON A.CARDNO = B.CARDNO
					 // AND A.GENRE_PROGRAM = B.GENRE_PROGRAM
					 // JOIN URBAN_PROFILE_2021 C ON B.RESPID = C.RESPID
					 // JOIN `PROFILE_CARDNO_RES` D ON B.RESPID = D.CARDNO
					 // WHERE D.`ID_PROFILE` = ".$row_users['PROFILE_ID']."
					 // GROUP BY SPLIT_MINUTES,A.CHANNEL,PROGRAM,START_TIME,END_TIME,B.RESPID,ADS_TYPE
					 // ) A GROUP BY SPLIT_MINUTES,CHANNEL,PROGRAM,START_TIME,END_TIME,ADS_TYPE
					 // ) VW,(
					 // SELECT A.SPLIT_MINUTES,SUM(WEIGHT) ALL_VIEWERS, SUM(WEIGHT_ALL) ALL_VIEWERS_ALL FROM (
					// SELECT A.*,B.JENIS_HARI,B.DAYPART,B.AGE,B.GENDER,C.WEIGHT,C.WEIGHT AS WEIGHT_ALL FROM (
					// SELECT A.*,REPLACE(REPLACE(KATEGORI_CHANEL, '\r', ''), '\n', '') KATEGORI_CHANEL,REPLACE(REPLACE(GENRE_PROGRAM, '\r', ''), '\n', '') GENRE_PROGRAM 
					// FROM M_SUMMARY_MEDIAPLAN_".$name_tbs."N_RES A
					// JOIN CHANNEL_PARAM O ON A.CHANNEL = O.CHANNEL_RC
					// LEFT JOIN EPG_SPLIT B ON O.CHANNEL_STD = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTE
					// ) A JOIN DATASET_VIEW_ASSIGNMENT_V4_2021 B ON A.CARDNO = B.CARDNO
					 // AND A.GENRE_PROGRAM = B.GENRE_PROGRAM
					 // JOIN URBAN_PROFILE_2021 C ON B.RESPID = C.RESPID
					 // JOIN `PROFILE_CARDNO_RES` D ON B.RESPID = D.CARDNO
					 // WHERE D.`ID_PROFILE` = ".$row_users['PROFILE_ID']."
					 // GROUP BY SPLIT_MINUTES,B.RESPID
					 // ) A GROUP BY SPLIT_MINUTES
					 
					 // ) ALLVW,(
						
						// SELECT * FROM t_profiling_ub_res
						// WHERE id = ".$row_users['PROFILE_ID']."
					 
					 // ) RESP
					  // WHERE VW.SPLIT_MINUTES = ALLVW.SPLIT_MINUTES
					  // GROUP BY DATE,CHANNEL,PROGRAM,START_TIME
				// ";	
				// $query_check =  mysqli_query($con,$script_check);
				
				// $script_check = "
				// INSERT INTO M_SUMMARY_MEDIA_PLAN_D_RES
					// SELECT VW.DATE,VW.CHANNEL_STD,VW.PROGRAM,'UNKNOWN' AS TITTLE,ADS_TYPE AS TYPE, 'UNKNOWN' AS STATUS,
					// START_TIME,END_TIME,TIMEDIFF(END_TIME,START_TIME) DURATION,RATE,LEVEL1,LEVEL2,VW.SPLIT_MINUTES,0 FLAG_TV,
					// PERIODE,TIME_PERIODE,AVG(VIEWERS),AVG(ALL_VIEWERS),RESP.`respondents` UNIVERSE, AVG(VIEWERS/RESP.`respondents`)*100 AS TVR, 
					// AVG(VIEWERS/ALL_VIEWERS)*100 AS TVS, 100 AS IDX, AVG(VIEWERS_ALL) AS VIEWER_A,AVG(ALL_VIEWERS_ALL) AS VIEWER_ALL_A,
					// RESP.`respondents_all` UNIVERSE_A, AVG(VIEWERS_ALL/RESP.`respondents_all`)*100 AS TVR_A, 
					// AVG(VIEWERS_ALL/ALL_VIEWERS_ALL)*100 AS TVS_A, 100 AS IDX_A, ".$row_users['PROFILE_ID']." PID FROM (

					// SELECT A.*,SUM(WEIGHT) VIEWERS, SUM(WEIGHT_ALL) VIEWERS_ALL FROM (
					// SELECT A.*,B.JENIS_HARI,B.DAYPART,B.AGE,B.GENDER,C.WEIGHT,C.WEIGHT AS WEIGHT_ALL FROM (
					// SELECT A.*,CM.ADS_TYPE,O.CHANNEL_STD,REPLACE(REPLACE(KATEGORI_CHANEL, '\r', ''), '\n', '') KATEGORI_CHANEL,REPLACE(REPLACE(GENRE_PROGRAM, '\r', ''), '\n', '') GENRE_PROGRAM 
					// FROM M_SUMMARY_MEDIAPLAN_".$name_tbs."N_RES A
					// JOIN CHANNEL_PARAM O ON A.CHANNEL = O.CHANNEL_RC
					// LEFT JOIN EPG_SPLIT B ON O.CHANNEL_STD = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTE
					// LEFT JOIN M_CIM_F2A_N_SPLIT_TEST CM ON A.CHANNEL = CM.CHANNEL AND A.SPLIT_MINUTES = CM.SPLIT_MINUTES
					// ) A JOIN DATASET_VIEW_ASSIGNMENT_V4_2021 B ON A.CARDNO = B.CARDNO
					 // AND A.GENRE_PROGRAM = B.GENRE_PROGRAM
					 // JOIN URBAN_PROFILE_2021 C ON B.RESPID = C.RESPID
					 // JOIN `PROFILE_CARDNO_RES` D ON B.RESPID = D.CARDNO
					 // WHERE D.`ID_PROFILE` = ".$row_users['PROFILE_ID']."
					 // GROUP BY SPLIT_MINUTES,A.CHANNEL,PROGRAM,START_TIME,END_TIME,B.RESPID,ADS_TYPE
					 // ) A GROUP BY SPLIT_MINUTES,CHANNEL,PROGRAM,START_TIME,END_TIME,ADS_TYPE
					 // ) VW,(
					 // SELECT A.SPLIT_MINUTES,SUM(WEIGHT) ALL_VIEWERS, SUM(WEIGHT_ALL) ALL_VIEWERS_ALL FROM (
					// SELECT A.*,B.JENIS_HARI,B.DAYPART,B.AGE,B.GENDER,C.WEIGHT,C.WEIGHT AS WEIGHT_ALL FROM (
					// SELECT A.*,REPLACE(REPLACE(KATEGORI_CHANEL, '\r', ''), '\n', '') KATEGORI_CHANEL,REPLACE(REPLACE(GENRE_PROGRAM, '\r', ''), '\n', '') GENRE_PROGRAM 
					// FROM M_SUMMARY_MEDIAPLAN_".$name_tbs."N_RES A
					// JOIN CHANNEL_PARAM O ON A.CHANNEL = O.CHANNEL_RC
					// LEFT JOIN EPG_SPLIT B ON O.CHANNEL_STD = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTE
					// ) A JOIN DATASET_VIEW_ASSIGNMENT_V4_2021 B ON A.CARDNO = B.CARDNO
					 // AND A.GENRE_PROGRAM = B.GENRE_PROGRAM
					 // JOIN URBAN_PROFILE_2021 C ON B.RESPID = C.RESPID
					 // JOIN `PROFILE_CARDNO_RES` D ON B.RESPID = D.CARDNO
					 // WHERE D.`ID_PROFILE` = ".$row_users['PROFILE_ID']."
					 // GROUP BY SPLIT_MINUTES,B.RESPID
					 // ) A GROUP BY SPLIT_MINUTES
					 
					 // ) ALLVW,(
						
						// SELECT * FROM t_profiling_ub_res
						// WHERE id = ".$row_users['PROFILE_ID']."
					 
					 // ) RESP
					  // WHERE VW.SPLIT_MINUTES = ALLVW.SPLIT_MINUTES
					  // GROUP BY DATE,CHANNEL,PROGRAM,START_TIME
				// ";	
				// $query_check =  mysqli_query($con,$script_check);
				
				$script_check = "
				
				INSERT INTO M_SUMMARY_MEDIA_PLAN_D_RES
				SELECT RC.`DATE`,RC.CHANNEL,RC.`PROGRAM`,RC.`TITLE`,RC.`TYPE`,RC.`STATUS`,RC.`START_TIME`,RC.`END_TIME`,RC.`DURATION`,
RC.RATE,RC.`LEVEL1`,RC.`LEVEL2`,RC.`SPLIT_MINUTES`, 0 AS `FLAG_TV`, '".$periode."' AS PERIODE,
IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('00:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('06:00:00' AS TIME) ,'00:00 - 06:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('06:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('08:00:00' AS TIME) ,'06:00 - 08:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('08:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('12:00:00' AS TIME) ,'08:00 - 12:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('12:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('18:00:00' AS TIME) ,'12:00 - 18:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('18:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('22:00:00' AS TIME) ,'18:00 - 22:00',
							  IF(CAST(RC.SPLIT_MINUTES AS TIME) > CAST('22:00:00' AS TIME) AND CAST(RC.SPLIT_MINUTES AS TIME) < CAST('23:59:59' AS TIME) ,'22:00 - 00:00','00:00 - 06:00')
							  )
							  )
							  )
							  )
							  ) AS DPART,AVG(`VIEWERS`),AVG(`ALL_VIEWS`),`UNIVERSE`,AVG(`TVR`),AVG(`TVS`),0 IDX,AVG(`VIEWERS_A`),AVG(`ALL_VIEWS_A`)
							  ,`UNIVERSE_A`,AVG(`TVR_A`),AVG(`TVS_A`),0 `IDX_A`,".$row_users['PROFILE_ID']." `PROFILE_ID`  FROM RATE_CARD_SPLIT_MDM RC JOIN 
							  (
								  SELECT * FROM `SUMMARY_PER_MINUTES_RES_V2` 
								  WHERE PERIODE = '".$periode."' AND `PROFILE_ID` = ".$row_users['PROFILE_ID']."
							  ) B 
							  ON RC.CHANNEL = B.CHANNEL AND RC.SPLIT_MINUTES = B.SPLIT_MINUTES
							 GROUP BY RC.`DATE`,RC.CHANNEL, RC.PROGRAM, RC.START_TIME
							 ";	
				//$query_check =  mysqli_query($con,$script_check);
				
				$script_check = "
				
				  INSERT INTO M_SUMMARY_MEDIA_PLAN_D_RES
				  SELECT DATE,CHANNEL,REPLACE(PROGRAM, \"'\", \"&#39;\"),TITTLE,TYPE,STATUS,START_TIME,END_TIME,
				  DURATION,RATE,LEVEL1,LEVEL2,SPLIT_MINUTES,FLAG_TV,PERIODE,TIME_PERIODE,VIEWER,VIEWER_ALL,
				  UNIVERSE,TVR,TVS,IDX,VIEWER_A,VIEWER_ALL_A,UNIVERSE_A,TVR_A,TVS_A,IDX_A,PROFILE_ID FROM M_SUMMARY_MEDIA_PLAN_D_RES
				  WHERE PROFILE_ID = ".$row_users['PROFILE_ID']."
				  AND PROGRAM LIKE \"%'%\"
				
				";	
				//$query_check =  mysqli_query($con,$script_check);
				
				$script_check = "
				 DELETE FROM M_SUMMARY_MEDIA_PLAN_D_RES
				  WHERE PROGRAM LIKE \"%'%\"
					AND PROFILE_ID = ".$row_users['PROFILE_ID']."
					";	
				//$query_check =  mysqli_query($con,$script_check);
	
				$script_check = "
				
				UPDATE M_SUMMARY_MEDIA_PLAN_D_RES A JOIN (
					SELECT A.DATE,A.CHANNEL,A.PROGRAM,A.START_TIME,A.TYPE,(A.TVR / B.TVR)*100 AS INDEXS,(A.TVR_A / B.TVR_A)*100 AS INDEXS_A FROM (
						SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_RES
						WHERE PROFILE_ID = ".$row_users['PROFILE_ID']."
					) A JOIN (
						SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_RES
						WHERE PROFILE_ID = 0
					) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME = B.START_TIME 
				) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME = B.START_TIME 
				SET A.`IDX` = INDEXS, A.`IDX_A` = INDEXS_A
				WHERE A.`PROFILE_ID` = ".$row_users['PROFILE_ID']."
	";	
				//$query_check =  mysqli_query($con,$script_check);
				
				
	
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s);  
		
		
		$clean_epg_Query = "
		DELETE FROM `M_SUM_TV_DASH_CHAN_RES_FULL`
		WHERE TANGGAL = '".$periode."' 
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
		
		$clean_epg_Query = "
		DELETE FROM `M_SUM_TV_DASH_CHAN_DAY_RES`
		WHERE TANGGAL = '".$periode."' 
		AND ID_PROFILE = ".$id.";
		";
		mysqli_query($con,$clean_epg_Query);
		
		
		//MONTHLY CHANNEL 
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_RES_FULL`
						SELECT A.CHANNEL,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,1 AS STS FROM (
							SELECT CHANNEL,SUM(WEIGHT) AS AUDIENCE,SUM(WEIGHT_ALL) AS AUDIENCE_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS,".$id." ID_PROFILE  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`
								WHERE RESPID IN (SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$id.")
								GROUP BY RESPID,CHANNEL
							) P GROUP BY CHANNEL
						) A JOIN (
							SELECT `CHANNEL`,
							AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
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
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '1'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 1 
						) D ON A.CHANNEL = D.CHANNEL ";
		mysqli_query($con,$clean_epg_Query);
	

		//DAILY CHANNEL
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_DAY_RES_FULL`
						SELECT A.CHANNEL,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,A.HARIS,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,1 AS STS FROM (
							SELECT CHANNEL,VIEWERS AS AUDIENCE,VIEWERS_ALL AS AUDIENCE_ALL,HARIS,".$id." ID_PROFILE  FROM (
								SELECT CHANNEL,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`
								WHERE RESPID IN (".$sql_c.")
								GROUP BY RESPID,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,HARIS
							) P GROUP BY CHANNEL,HARIS
						) A JOIN (
							SELECT `CHANNEL`,
							AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
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
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '1'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 1 
						) D ON A.CHANNEL = D.CHANNEL AND A.HARIS = D.DATE;  ";
		mysqli_query($con,$clean_epg_Query);
		
		//------- END CHANNEL

		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_RES_FULL`
		SELECT `CHANNEL`,`VIEWERS`,`VIEWERS2`,`TANGGAL`,`AUDIENCE`,`TVR`,`TVS`,`REACH`,`INDEX`,`ID_PROFILE`,1 `STATUS` FROM `M_SUM_TV_DASH_CHAN_RES_FULL`
		WHERE TANGGAL = '".$periode."' AND `STATUS`=0
		AND ID_PROFILE = ".$id.";
		";
		//mysqli_query($con,$clean_epg_Query);
		
		
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_CHAN_DAY_RES_FULL`
		SELECT `CHANNEL`,`VIEWERS`,`VIEWERS2`,`TANGGAL`,`DATE`,`AUDIENCE`,`TVR`,`TVS`,`REACH`,`INDEX`,`ID_PROFILE`, 1 `STATUS`  FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL`
		WHERE TANGGAL = '".$periode."' AND `STATUS`=0 
		AND ID_PROFILE = ".$id.";
		";
		//mysqli_query($con,$clean_epg_Query);

		
		
		//-------------------------------------------------------------------------------------------------------------------------------------------------------
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s);  
		
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
							SELECT CHANNEL,PROGRAM,VIEWERS AS AUDIENCE,VIEWERS_ALL AS AUDIENCE_ALL,".$id." ID_PROFILE  FROM (
								SELECT CHANNEL,PROGRAM,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`
								WHERE RESPID IN (".$sql_c.") 
								GROUP BY RESPID,PROGRAM,CHANNEL
								) P GROUP BY CHANNEL,PROGRAM
							) P GROUP BY CHANNEL,PROGRAM
						) A JOIN (
							SELECT `CHANNEL`,PROGRAM,
							AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
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
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '1'  AND A.DATA_TYPE = 'TVR_S' AND A.`STATUS` = 1 
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
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`
								WHERE RESPID IN (".$sql_c.") 
								GROUP BY RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,PROGRAM,HARIS
							) P GROUP BY CHANNEL,PROGRAM,HARIS
						) A JOIN (
							SELECT `CHANNEL`,PROGRAM,
							AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
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
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '1'  AND A.DATA_TYPE = 'TVR_S' AND A.`STATUS` = 1
						) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM AND A.HARIS = D.DATE;  
		";
		mysqli_query($con,$clean_epg_Query);

		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s);  


		
		//-------------------------------------------------------------------------------------------------------------------------------------------------------
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		//mysqli_query($con,$script_doneb_s);  
		
		//MONTHLY PROGRAM TIME
		$clean_epg_Query = "
		INSERT INTO `M_SUM_TV_DASH_PROG_RES_FULL`
						SELECT A.CHANNEL,A.PROGRAM,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/UNIVERSE)*100 REACH, (TVR2/UNIVERSE_IDX_ALL)*100 AS IDX,
						A.ID_PROFILE,0 AS STS, 1 AS TPE FROM (
							SELECT CHANNEL,CONCAT(PROGRAM,' ',BEGIN_PROGRAM) AS PROGRAM,AVG(VIEWERS) AS AUDIENCE,AVG(VIEWERS_ALL) AS AUDIENCE_ALL,".$id." ID_PROFILE  FROM (
								SELECT CHANNEL,PROGRAM,BEGIN_PROGRAM,SUM(WEIGHT) AS VIEWERS,SUM(WEIGHT_ALL) AS VIEWERS_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS  FROM (
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`
								WHERE RESPID IN (".$sql_c.")
								GROUP BY RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM,HARIS
							) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM
						) A JOIN (
							SELECT `CHANNEL`,CONCAT(PROGRAM,' ',BEGIN_PROGRAM) AS PROGRAM,
							AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
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
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '1'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 1
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
								SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`
								WHERE RESPID IN (".$sql_c.")
								GROUP BY RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
								) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM,HARIS
							) P GROUP BY CHANNEL,PROGRAM,BEGIN_PROGRAM,HARIS
						) A JOIN (
							SELECT `CHANNEL`,CONCAT(PROGRAM,' ',BEGIN_PROGRAM) AS PROGRAM,
							AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
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
								WHERE A.TANGGAL = '".$periode."' AND A.ID_PROFILE = '1'  AND A.DATA_TYPE = 'TVR' AND A.`STATUS` = 1
						) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM AND A.HARIS = D.DATE;  
		";
		mysqli_query($con,$clean_epg_Query);
		
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s);  

		
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
		
		
		$script_doneb_s = "
			SELECT * FROM `DAYPART`
			WHERE USERID IN (".$user_id_profil.")
			GROUP BY `DAYPART1`
		";
		$querys = mysqli_query($con_maria,$script_doneb_s);  
		
		while($row_users = mysqli_fetch_array($querys)){
			
			$array_dayparts = $row_users['DAYPART1'];
			$time_segment = explode('-',$array_dayparts);
		
			$start_time = $time_segment[0];
					
			if($time_segment[1] == '00:00:00'){
				$end_time = '23:59:59';
			}else{
				$end_time = $time_segment[1];
			}
			
			$script_date08 = " 
									
					INSERT INTO `M_SUM_TV_DASH_CHAN_RES_DAYPART_FULL`
						SELECT A.CHANNEL,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,'".$array_dayparts."' DAYPART,AUDIENCE,TVR2,TVS2,
						(AUDIENCE/19479194)*100 REACH, (TVR2/TVR2A)*100 AS IDX,
						A.ID_PROFILE,1 AS STS FROM (
							SELECT CHANNEL,SUM(WEIGHT) AS AUDIENCE,SUM(WEIGHT_ALL) AS AUDIENCE_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS,".$id." ID_PROFILE  FROM (
								SELECT A.*,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`  A
								JOIN (SELECT * FROM `PROFILE_CARDNO_RES` WHERE ID_PROFILE = '".$id."') B ON A.RESPID = B.`CARDNO`
								WHERE DATE_FORMAT(`BEGIN_PROGRAM`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
								GROUP BY RESPID,CHANNEL
							) P GROUP BY CHANNEL
						) A JOIN (
							SELECT `CHANNEL`,
							AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
							AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
							AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = ".$id."
							AND DATE_FORMAT(`SPLIT_MINUTES`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
							GROUP BY CHANNEL
						) B ON A.CHANNEL = B.CHANNEL 
						 JOIN (
							SELECT `CHANNEL`,
							AVG(TVR)*100 AS TVRA,AVG(TVR_A)*100 AS TVR2A
							FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE PERIODE = '".$periode."'
							AND PROFILE_ID = 1
							AND DATE_FORMAT(`SPLIT_MINUTES`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
							GROUP BY CHANNEL
						) C ON B.CHANNEL = C.CHANNEL;

					";   
					
					//echo $script_date08;die;
					
					mysqli_query($con,$script_date08);
			
		}
		
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
					 SELECT B.CHANNEL_NAME,A.* FROM `CDR_EPG_RES_ALL_STEP2_2022` A
					JOIN `CHANNEL_PARAM_FINAL` B ON A.CHANNEL = B.`CHANNEL_NAME_PROG`
					 WHERE (DATE_FORMAT(`BEGIN_PROGRAM`, '%Y-%M')  = '".$periode."'  OR
					 DATE_FORMAT(`END_PROGRAM`, '%Y-%M')  = '".$periode."'  )
				 ) A JOIN (
					SELECT *,
					CONCAT(`DATE`,' ',SPLIT_MINUTES) AS MINUTES 
					FROM `PTV_CIM_RATING_RES` B
					WHERE DATE_FORMAT(`DATE`, '%Y-%M') = '".$periode."' 
					AND ID_PROFILE = ".$id."
				 ) B ON B.MINUTES BETWEEN BEGIN_PROGRAM AND END_PROGRAM AND A.CHANNEL_NAME = B.CHANNEL
				 GROUP BY RESPID,ID_PROFILE
			) A
		) L WHERE K.ID_PROFILE = L.ID_PROFILE;
													";
		mysqli_query($con,$clean_epg_Query);	
		
		
		
		$sql_edit = " update M_MONTH_PROFILE_RES_P22 set DATE_FINISH = '".date('Y-m-d H:i:s')."', STATUS_PROCESS = '1' WHERE PERIODE = '".$arp."' AND PROFILE_ID = ".$id;
		$query_edt =  mysqli_query($con,$sql_edit);  
	
		$percentage = $percentage + (8/$int_prog);
		$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '".$percentage." %' where id ='".$id."' ";
		mysqli_query($con,$script_doneb_s);  
		
		
		// $response = file_get_contents('http://dev-db.u.1elf.net/ff/sync_data_res_periode.php?p='.$arp.'&id='.$id);
		// $response = file_get_contents('http://dev-db.u.1elf.net/ff/sync_param_res.php');
		$response = file_get_contents('http://dev-db.u.1elf.net/ff/sync_data.php?p='.$arp.'&id='.$id);
		
	} 
	// echo "\n End time ".date("Y-m-d h:i:s")." \n\n ";
	
	$percentage = 100;
	$script_doneb_s = "UPDATE t_profiling_ub_res SET global_progress = '100 %' where id ='".$id."' ";
	mysqli_query($con,$script_doneb_s);  
	
	$sql_edit = " update t_profiling_ub_res set status_job = 0, date_finish = '".date('Y-m-d H:i:s')."' WHERE id = ".$id;
	$query_edt =  mysqli_query($con,$sql_edit);   
	
 
	$user_id = "SELECT *, TIMEDIFF(date_finish,date_process) as dif_time  FROM `t_profiling_ub_res` WHERE id = ".$id;
	$query =  mysqli_query($con,$user_id);    
	$row_users = mysqli_fetch_array($query);	
	
	$sql_edit = " INSERT INTO NOTIF_PROFILE VALUES (NULL,'".$row_users['name']."','1','".$row_users['user_id_profil']."','".$row_users['date_finish']."','1','0','".$row_users['dif_time']."') ";
	$query_edt =  mysqli_query($con,$sql_edit); 
	
	$sql_edit = " update t_profiling_ub_res set postbuy_status = 'Done',mediaplan_status = 'Done',status_dash_str = 'Done',status_tvcc_str = 'Done',status_tvpc_str = 'Done',cm_status_str = 'Done',status_reach_str = 'Done' WHERE id = ".$id;
	$query_edt =  mysqli_query($con,$sql_edit);   
	
	
	foreach($arr_periode as $arps){
	
		//$response = file_get_contents('http://dev-db.u.1elf.net/ff/sync_data.php?p='.$arps.'&id='.$id);
		//$response = file_get_contents('http://dev-db.u.1elf.net/ff/sync_param_res.php');
	
	}
	
	$commands = 'php /var/www/jobs/profiling/ultimate/profile_jobs_res_p22_temp_ext.php '.$id.' > /var/www/jobs/profiling/ultimate/log_profile_n_'.$id.'res_2021.log 2>&1 & ';  
	$pids = shell_exec($commands);
	
// //	print_r($row_user[0]);die;

	// $job_id = "SELECT * FROM `t_profiling_ub_res` WHERE user_id_profil = ".$row_users['user_id_profil']." AND status_job = 1 order by `date_process` DESC LIMIT 1 ";
	
	// // //echo $job_id;die;
	
	// $querys =  mysqli_query($con,$job_id);    
	// $row_que = mysqli_fetch_array($querys);
	
	// IF ($row_que == ""){
		
	// }ELSE{
		
		// $sql_edit = " update t_profiling_ub_res set status_job = 2 WHERE id = ".$row_que['id'];
		// $query_edt =  mysqli_query($con,$sql_edit);  

		// $command = 'php /var/www/jobs/profiling/ultimate/profile_jobs_res.php '.$row_que['id'].' > /var/www/jobs/profiling/ultimate/log_profile_n_'.$row_que['id'].'res.log 2>&1 & ';  
			
		// //echo $command;die;
	// //	$pid = shell_exec($command);
	// }
	
	
	
		
?>
