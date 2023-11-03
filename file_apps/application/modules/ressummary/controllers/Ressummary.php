<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ressummary extends CI_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvcc_model');
	}
	
	public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['profile'] = $this->tvcc_model->list_profile($iduser,$idrole,"");
		$data['channel'] = $this->tvcc_model->list_channelas();
    $data['daypart'] = $this->tvcc_model->list_daypart($iduser);
    $data['currdate'] = $this->tvcc_model->current_date();
	
	$data['kota'] = $this->get_data_chart('KOTA');
	$data['demografi']['AGE GROUP'] = $this->get_data_chart('AGE_GROUP');
	$data['demografi']['AGE GROUP RESPONDEN']['label'] = ["'40-55'","'26-39'","'17-25'","'56-60'","'>60'","'0-16'"];
	$data['demografi']['AGE GROUP RESPONDEN']['value'] =  [2193,2022,627,262,31,0] ;
	
	$data['demografi']['RELIGION'] = $this->get_data_chart('RELIGION');
	$data['demografi']['HAVE KID UNDER 5 YEAR'] = $this->get_data_chart('HAVE_U5_KID');
	$data['demografi']['HAVE KID BETWEEN 5 AND 9 YEAR'] = $this->get_data_chart('HAVE_U59_KID');
	$data['demografi']['GENDER'] = $this->get_data_chart_index('GENDER_RESPID');
	$data['demografi']['EDUCATION'] = $this->get_data_chart_index('EDU_LEVEL');
	$data['demografi']['MARITAL STATUS'] = $this->get_data_chart_index('MARITAL_STAT');
	$data['demografi']['HH EXPENDITURE'] = $this->get_data_chart_index('EXPENSE_GROUP');
	$data['demografi']['OCCUPATION'] = $this->get_data_chart_index('JOB');
	$data['demografi']['HOME OWN'] = $this->get_data_chart_index('HOME_OWN');
	
		//$data['demografi']['index'] = ['age_group','gender','MARITAL_STAT'];
	$data['demografi']['index'] = ['MARITAL STATUS','HH EXPENDITURE','EDUCATION','OCCUPATION','RELIGION','HOME OWN','HAVE KID UNDER 5 YEAR','HAVE KID BETWEEN 5 AND 9 YEAR'];
	

	$data['watch_b']['CINEMA']['MENONTON BIOSKOP'] = $this->get_data_chart_index('is_cinema');
	$data['watch_b']['CINEMA']['FREQUENSI MENONTON BIOSKOP'] = $this->get_data_chart('cinema_freq');
	$data['watch_b']['CINEMA']['TEMPAT MENONTON BIOSKOP'] = $this->get_data_chart_split(['cinema_loc_studio21','cinema_loc_xx1','cinema_loc_cgv','cinema_loc_cinemaxx','cinema_loc_platinum','cinema_loc_other']);
	$data['watch_b']['CINEMA']['TERAKHIR MENONTON BIOSKOP'] = $this->get_data_chart('cinema_last');
	
	$data['watch_b']['HANGOUT']['TEMPAT HANGOUT'] = $this->get_data_chart_split(['hangout_loc_park','hangout_loc_cafe','hangout_loc_library','hangout_loc_school','hangout_loc_gym','hangout_loc_other']);
	$data['watch_b']['HANGOUT']['TERAKHIR HANGOUT'] = $this->get_data_chart('hangout_last');
	
	$data['watch_b']['SPORT']['KLUB OLAHRAGA'] = $this->get_data_chart_index('is_sport_club');
	$data['watch_b']['SPORT']['JENIS OLAHRAGA'] = $this->get_data_chart('sport_club_type');
	
	$data['watch_b']['INTERNET PROVIDER']['MONTHLY EXPENDITURE'] = $this->get_data_chart_index('data_expense_group');
	$data['watch_b']['INTERNET PROVIDER']['FREQUENSI INTERNET MOBILE'] = $this->get_data_chart('data_freq');
	$data['watch_b']['INTERNET PROVIDER']['TERAKHIR INTERNET MOBILE'] = $this->get_data_chart('last_user_data');
	$data['watch_b']['INTERNET PROVIDER']['PROVIDER INTERNET'] = $this->get_data_chart_split(['provider_axis','provider_isat','provider_smfr','provider_tsel','provider_three','provider_xl','provider_etc']);
	
	$data['watch_b']['GAMES']['MONTHLY EXPENDITURE'] = $this->get_data_chart('expense_game');
	$data['watch_b']['GAMES']['FREQUENSI GAME'] = $this->get_data_chart('freq_gaming');
	$data['watch_b']['GAMES']['SITUS GAMES'] = $this->get_data_chart_split(['gaming_steam','gaming_garena','gaming_battlenet','gaming_gog','gaming_epic','gaming_ubisoft','gaming_orign','gaming_uplay','gaming_gamersgate','gaming_ocean','gaming_acidplay','gaming_humble','gaming_gametop','gaming_eaplay','gaming_armor','gaming_itchr','gaming_jolt','gaming_etc']);
	$data['watch_b']['GAMES']['JUDUL GAME'] = $this->get_data_chart_multi('gaming_ol',['Free Fire','Roblox','Fortnite','Fall Guys','The Sims 4','Mobile Legends','Starcraft','Minecraft','Rust','Clash of Clans','PUBG Mobile','Clash Royale','Dota II','FIFA 22','Vainglory','Arena of Valor','Space Comander','Ragnarok','Dead by Daylight','Lineage2 Revolution','Rise of Kingdom Lost Crusade','DOTA','Grand Theft Auto V','Counter Strike','Lainnya']);
	$data['watch_b']['GAMES']['PERTIMBANGAN MEMILIH'] = $this->get_data_chart_multi('cons_gaming',['Variasi game yang banyak','Memberikan promo/diskon untuk game yang berbayar','Banyak game gratis tersedia','Proses download game simple/ tidak perlu aplikasi tambahan','Game nya banyak yang “booming/viral”','Lainnya']);
	
	$data['watch_b']['INTERNET ACTIVITY']['AKTIVITAS SAAT INTERNET'] = $this->get_data_chart_split(['website_type_news_info','website_type_learning','website_type_lifestyle','website_type_hobby','website_type_entertainment','website_type_ol_shopping','website_type_gaming','website_type_soc_med','website_type_video_stream','website_type_audio_stream',
'int_activity_video_call','int_activity_messaging','int_activity_ol_meeting','int_activity_download','int_activity_upload','int_activity_email','int_activity_others']);
	$data['watch_b']['INTERNET ACTIVITY']['JENIS INFORMASI'] = $this->get_data_chart_split(['info_type_journal','info_type_breaking_news','info_type_product','info_type_movie_ent','info_type_economy','info_type_politics','info_type_culinary','info_type_otomotif','info_type_property','info_type_health_sport','info_type_technology','info_type_etc']);


	$data['watch_b']['AUDIO']['FREQUENSI AUDIO'] = $this->get_data_chart('freq_audio_stream');
	$data['watch_b']['AUDIO']['MONTHLY EXPENDITURE'] = $this->get_data_chart('expense_audio');
	$data['watch_b']['AUDIO']['GENRE AUDIO'] = $this->get_data_chart_split(['genre_aud_pop','genre_aud_funk','genre_aud_dangdut','genre_aud_jazz','genre_aud_hiphop','genre_aud_rap','genre_aud_kroncong','genre_aud_etc']);
	$data['watch_b']['AUDIO']['APLIKASI AUDIO'] = $this->get_data_chart_split(['app_aud_soundc','app_aud_joox','app_aud_melon','app_aud_spotify','app_aud_musixmatch','app_aud_vortex','app_aud_guvera','app_aud_deezer','app_aud_apple','app_aud_langitm','app_aud_amazon','app_aud_etc']);
	$data['watch_b']['AUDIO']['PERTIMBANGAN MEMILIH'] = $this->get_data_chart_split(['cons_aud_free','cons_aud_interface','cons_aud_catalog','cons_aud_syncron','cons_aud_quality','cons_aud_etc']);
	
	
	$data['watch_b']['VIDEO']['FREQUENSI VIDEO'] = $this->get_data_chart('freq_vid_stream');
	$data['watch_b']['VIDEO']['MONTHLY EXPENDITURE'] = $this->get_data_chart('expense_video');
	$data['watch_b']['VIDEO']['GENRE VIDEO'] = $this->get_data_chart_split(['genre_vid_adv','genre_vid_act','genre_vid_com','genre_vid_drama','genre_vid_mistic','genre_vid_horror','genre_vid_etc']);
	$data['watch_b']['VIDEO']['APLIKASI VIDEO'] = $this->get_data_chart_split(['app_vid_mola','app_vid_viu','app_vid_hbogo','app_vid_maxstream','app_vid_disney','app_vid_video','app_vid_lionsgate','app_vid_useetyvgo','app_vid_catchplay','app_vid_netflix','app_vid_iqiyi','app_vid_googleplay','app_vid_iflix','app_vid_genflix','app_vid_youtube','app_vid_etc']);
	$data['watch_b']['VIDEO']['PERTIMBANGAN MEMILIH'] = $this->get_data_chart_split(['cons_vid_price','cons_vid_device','cons_vid_content','cons_vid_dvcvariety','cons_vid_resolution','cons_vid_offline','cons_vid_etc']);
	
	$data['watch_b']['SHOPPING']['TEMPAT BERBELANJA'] = $this->get_data_chart_split(['is_toko','is_minimarket','is_psr_trdsnal','is_supermrkt','is_hipermrkt']);
	$data['watch_b']['SHOPPING']['MONTHLY EXPENDITURE'] = $this->get_data_chart('exp_shop_month');
	$data['watch_b']['SHOPPING']['MINIMARKET'] = $this->get_data_chart_split(['minimrkt_alfamart','minimrkt_alfamidi','minimrkt_bright','minimrkt_circlek','minimrkt_indomaret','minimrkt_etc']);
	$data['watch_b']['SHOPPING']['SUPERMARKET'] = $this->get_data_chart_split(['minimrkt_alfamart','minimrkt_alfamidi','minimrkt_bright','minimrkt_circlek','minimrkt_indomaret','minimrkt_etc']);
	$data['watch_b']['SHOPPING']['HYPERMARKET'] = $this->get_data_chart_split(['minimrkt_alfamart','minimrkt_alfamidi','minimrkt_bright','minimrkt_circlek','minimrkt_indomaret','minimrkt_etc']);
	$data['watch_b']['SHOPPING']['ONLINE MARKET'] = $this->get_data_chart_split(['minimrkt_alfamart','minimrkt_alfamidi','minimrkt_bright','minimrkt_circlek','minimrkt_indomaret','minimrkt_etc']);

	$data['watch_b']['index'] = ['CINEMA','HANGOUT','SPORT','INTERNET PROVIDER','INTERNET ACTIVITY','GAMES','AUDIO','VIDEO','SHOPPING'];
	$data['watch_b']['CINEMA']['index'] = ['MENONTON BIOSKOP','FREQUENSI MENONTON BIOSKOP','TEMPAT MENONTON BIOSKOP','TERAKHIR MENONTON BIOSKOP'];
	$data['watch_b']['HANGOUT']['index'] = ['TEMPAT HANGOUT','TERAKHIR HANGOUT'];
	$data['watch_b']['SPORT']['index'] = ['KLUB OLAHRAGA','JENIS OLAHRAGA'];
	$data['watch_b']['INTERNET PROVIDER']['index'] = ['PROVIDER INTERNET','MONTHLY EXPENDITURE','FREQUENSI INTERNET MOBILE','TERAKHIR INTERNET MOBILE'];
	$data['watch_b']['INTERNET ACTIVITY']['index'] = ['AKTIVITAS SAAT INTERNET','JENIS INFORMASI'];
	$data['watch_b']['GAMES']['index'] = ['MONTHLY EXPENDITURE','FREQUENSI GAME','SITUS GAMES','JUDUL GAME','PERTIMBANGAN MEMILIH'];
	$data['watch_b']['AUDIO']['index'] = ['FREQUENSI AUDIO','MONTHLY EXPENDITURE','GENRE AUDIO','APLIKASI AUDIO','PERTIMBANGAN MEMILIH'];
	$data['watch_b']['VIDEO']['index'] = ['FREQUENSI VIDEO','MONTHLY EXPENDITURE','GENRE VIDEO','APLIKASI VIDEO','PERTIMBANGAN MEMILIH'];
	$data['watch_b']['SHOPPING']['index'] = ['TEMPAT BERBELANJA','MINIMARKET','SUPERMARKET','HYPERMARKET','ONLINE MARKET','MONTHLY EXPENDITURE'];
	
	$data['media']['index'] = ['ONLINE','OFFLINE'];
	$data['media']['ONLINE']['index'] = ['RAGAM MEDIA ONLINE','FREQUENSI MEDIA ONLINE','SITUS ONLINE','SOCIAL MEDIA','SOCIAL MESSENGER','FREQUENSI YOUTUBE','JENIS TAYANGAN YOUTUBE','KEGIATAN FACEBOOK','KEGIATAN INSTAGRAM','KEGIATAN TIKTOK','FREQUENSI FACEBOOK','FREQUENSI INSTAGRAM','FREQUENSI TIKTOK'];
	$data['media']['ONLINE']['RAGAM MEDIA ONLINE'] = $this->get_data_chart_split(['med_ol_radio','med_ol_tab','med_ol_tv','med_ol_streaming','med_ol_situs','med_ol_nwsppr','med_ol_socmed','med_ol_mjlh','med_ol_etc']);
	$data['media']['ONLINE']['FREQUENSI MEDIA ONLINE'] = $this->get_data_chart('situs_ol_freq');
	$data['media']['ONLINE']['FREQUENSI YOUTUBE'] = $this->get_data_chart('freq_youtube');
	$data['media']['ONLINE']['SITUS ONLINE'] = $this->get_data_chart_split(['situs_ol_detik','situs_ol_tirto','situs_ol_tempo','situs_ol_kumparan','situs_ol_okezone','situs_ol_liputan6','situs_ol_kompas','situs_ol_tribun','situs_ol_kpnlg','situs_ol_etc']);
	$data['media']['ONLINE']['SOCIAL MEDIA'] = $this->get_data_chart_split(['socmed_fb_own','socmed_tw_own','socmed_ig_own','socmed_youtube_own','socmed_tiktok_own','socmed_pntrest_own','socmed_tumblr_own','socmed_lnkdin_own','socmed_snpcht_own','socmed_etc_own']);
	$data['media']['ONLINE']['SOCIAL MESSENGER'] = $this->get_data_chart_split(['socmes_line_own','socmes_imo_own','socmes_wecht_own','socmes_skype_own','socmes_wa_own','socmes_tele_own','socmes_fbm_own','socmes_yho_own','socmes_etc_own']);
	$data['media']['ONLINE']['JENIS TAYANGAN YOUTUBE'] = $this->get_data_chart_multi('youtube_genre',['Music / Dance','Movies','Gaming','Entertainment','Olahraga','Berita & Politik','Kecantikan','Traveling','Mistik','Kuliner / Memasak','Science & Teknologi','Prank / Challenges','DIY / Tips','Daily Vlog','Family / Parenting','Kesehatan']);
	
	$data['media']['ONLINE']['FREQUENSI FACEBOOK'] = $this->get_data_chart('freq_fb');
	$data['media']['ONLINE']['FREQUENSI INSTAGRAM'] = $this->get_data_chart('freq_ig');
	$data['media']['ONLINE']['FREQUENSI TIKTOK'] = $this->get_data_chart('freq_tiktok');
	
	$data['media']['ONLINE']['KEGIATAN FACEBOOK'] = $this->get_data_chart_multi('activity_fb',['Berdagang / Jualan / Berbisnis','Update Status','Memberi Comment / Like','Menyimpan kenangan','Silaturahmi / Bertemu Teman Lama','Diary / Catatan Harian','Update Informasi','Berdiskusi','Lainnya']);
	$data['media']['ONLINE']['KEGIATAN INSTAGRAM'] = $this->get_data_chart_multi('activity_ig',['Berdagang / Jualan / Berbisnis','Update Status','Memberi Comment / Like','Menyimpan kenangan','Silaturahmi / Bertemu Teman Lama','Diary / Catatan Harian','Update Informasi','Berdiskusi','Lainnya']);
	$data['media']['ONLINE']['KEGIATAN TIKTOK'] = $this->get_data_chart_multi('activity_tiktok',['Berdagang / Jualan / Berbisnis','Update Status','Memberi Comment / Like','Menyimpan kenangan','Silaturahmi / Bertemu Teman Lama','Diary / Catatan Harian','Update Informasi','Berdiskusi','Lainnya']);
	
	$data['media']['OFFLINE']['index'] = ['RAGAM MEDIA OFFLINE','FREQUENSI MEDIA OFFLINE','RADIO','TABLOID','RUBRIK TABLOID','KORAN','RUBRIK KORAN','FREQUENSI KORAN'];
	$data['media']['OFFLINE']['RAGAM MEDIA OFFLINE'] = $this->get_data_chart_split(['med_con_radio','med_con_tab','med_con_tv','med_con_bltn','med_con_nwsppr','med_con_inflghmag','med_con_mjlh','med_con_etc']);
	$data['media']['OFFLINE']['FREQUENSI MEDIA OFFLINE'] = $this->get_data_chart('radio_freq');
	$data['media']['OFFLINE']['RADIO']['label'] = ["'Prambors'","'RRI'","'Suara Surabaya'","'Elshinta'","'Gen FM'","'Delta FM'"];
	$data['media']['OFFLINE']['RADIO']['value'] =  [258197,224251,181943,97638,96906,93108] ;
	
	$data['media']['OFFLINE']['TABLOID'] = $this->get_data_chart_split(['read_tbld_trbs','read_tbld_wi','read_tbld_bntg','read_tbld_nova','read_tbld_chip','read_tbld_swa','read_tbld_instr','read_tbld_rmh','read_tbld_gds','read_tbld_etc']);
	$data['media']['OFFLINE']['RUBRIK TABLOID'] = $this->get_data_chart_split(['tbld_pol','tbld_eko','tbld_sos','tbld_tek','tbld_pro','tbld_oto','tbld_olhrg','tbld_sht','tbld_hbrn','tbld_fas','tbld_agro','tbld_etc']);
	$data['media']['OFFLINE']['KORAN'] = $this->get_data_chart_split(['read_koran_jawa','read_koran_kompas','read_koran_bi','read_koran_radar','read_koran_investor','read_koran_jktpost','read_koran_sindo','read_koran_tempo','read_koran_republika','read_koran_etc']);
	$data['media']['OFFLINE']['RUBRIK KORAN'] = $this->get_data_chart_split(['koran_pol','koran_eko','koran_sos','koran_tek','koran_pro','koran_oto','koran_olhrg','koran_sht','koran_hbrn','koran_fas','koran_nas','koran_ln']);
	$data['media']['OFFLINE']['FREQUENSI KORAN'] = $this->get_data_chart('koran_freq');
	
	$data['viewers_b']['index'] = ['WATCHING BEHAVIOUR','SIARAN TV'];
	
	$data['viewers_b']['WATCHING BEHAVIOUR']['index'] = ['DAY PART','TV GENRE','KUALITAS TV','CHANNEL PALING SERING DITONTON'];
	//$data['viewers_b']['WATCHING BEHAVIOUR']['DAY PART'] = $this->get_data_chart_split(['tv_wkday_pagi','tv_wkday_siang','tv_wkday_sore','tv_wkday_mlm','tv_wkday_dini','tv_wkday_etc','tv_wkend_pagi','tv_wkend_siang','tv_wkend_sore','tv_wkend_mlm','tv_wkend_dini','tv_wkend_etc']);
	
	//print_r($data['viewers_b']['WATCHING BEHAVIOUR']['DAY PART']);die; 
	$data['viewers_b']['WATCHING BEHAVIOUR']['TV GENRE'] = $this->get_data_chart_split(['tv_genre_movies','tv_genre_series','tv_genre_news','tv_genre_religi','tv_genre_ent','tv_genre_kids','tv_genre_sport','tv_genre_lifestyle','tv_genre_music','tv_genre_knowledge','tv_genre_documentary','tv_genre_local']);
	$data['viewers_b']['WATCHING BEHAVIOUR']['KUALITAS TV'] = $this->get_data_chart('tv_quality');
	$data['viewers_b']['WATCHING BEHAVIOUR']['CHANNEL PALING SERING DITONTON'] = $this->get_data_chart_split_nu(['tv_mostwatch_genre_antv','tv_mostwatch_genre_gtv','tv_mostwatch_genre_indosiar','tv_mostwatch_genre_kompastv','tv_mostwatch_genre_metrotv','tv_mostwatch_genre_nettv','tv_mostwatch_genre_mnctv','tv_mostwatch_genre_tvone','tv_mostwatch_genre_rcti','tv_mostwatch_genre_sctv','tv_mostwatch_genre_transtv','tv_mostwatch_genre_trans7','tv_mostwatch_genre_hbo','tv_mostwatch_genre_tvn','tv_mostwatch_genre_bioskop','tv_mostwatch_genre_cnn','tv_mostwatch_genre_mtv','tv_mostwatch_genre_sone','tv_mostwatch_genre_bein','tv_mostwatch_genre_natgeowild','tv_mostwatch_genre_natgeo','tv_mostwatch_genre_cartoon','tv_mostwatch_genre_etc']);
	
	
	$data['viewers_b']['SIARAN TV']['index'] = ['SIARAN TV','FREQUENSI MENONTON TV DIGITAL','CHANNEL TV DIGITAL','ALASAN TV DIGITAL','FREQUENSI MENONTON TV ANALOG','CHANNEL TV ANALOG'];
	$data['viewers_b']['SIARAN TV']['SIARAN TV'] = $this->get_data_chart_index('tv_type');
	$data['viewers_b']['SIARAN TV']['FREQUENSI MENONTON TV DIGITAL'] = $this->get_data_chart('tv_digital_int');
	$data['viewers_b']['SIARAN TV']['CHANNEL TV DIGITAL'] = $this->get_data_chart_split(['tv_mostwatch_digital_rcti','tv_mostwatch_digital_mnctv','tv_mostwatch_digital_gtv','tv_mostwatch_digital_inews','tv_mostwatch_digital_metrotv','tv_mostwatch_digital_sctv','tv_mostwatch_digital_antv','tv_mostwatch_digital_indosiar','tv_mostwatch_digital_trans7','tv_mostwatch_digital_transtv','tv_mostwatch_digital_tvone','tv_mostwatch_digital_nettv','tv_mostwatch_digital_cnn_indo','tv_mostwatch_digital_kompastv','tv_mostwatch_digital_etc']);
	$data['viewers_b']['SIARAN TV']['ALASAN TV DIGITAL'] = $this->get_data_chart_multi('reason_tv_digital',['Lebih praktis','Tidak ada alasan khusus','Kualitas suara dan gambar lebih jernih','Lainnya']);
	$data['viewers_b']['SIARAN TV']['FREQUENSI MENONTON TV ANALOG'] = $this->get_data_chart('tv_analog_int');
	$data['viewers_b']['SIARAN TV']['CHANNEL TV ANALOG'] = $this->get_data_chart_split(['tv_mostwatch_analog_rcti','tv_mostwatch_analog_mnctv','tv_mostwatch_analog_gtv','tv_mostwatch_analog_inews','tv_mostwatch_analog_metrotv','tv_mostwatch_analog_sctv','tv_mostwatch_analog_antv','tv_mostwatch_analog_indosiar','tv_mostwatch_analog_trans7','tv_mostwatch_analog_transtv','tv_mostwatch_analog_tvone','tv_mostwatch_analog_nettv','tv_mostwatch_analog_cnn_indo','tv_mostwatch_analog_kompastv','tv_mostwatch_analog_etc']);




	//print_r($data['media']);die;

	$data['merk_data'] = $this->get_data_chart_merk_summ();
	
	$data['FMGC']['index'] =['merk_amdk','merk_softdrink','merk_milk','merk_coffee','merk_tea','merk_biscuit','merk_candy','merk_flavoring','merk_soy_sauce','merk_ketchup','merk_toothpaste','merk_body_wash','merk_cereal',
'merk_bakery','merk_face_wash','merk_hand_wash','merk_shampoo','merk_body_lotion','merk_cloth_deo','merk_detergen','merk_softener','merk_lamp','merk_battery','merk_shaver','merk_insectrepell',
'merk_airfresh','merk_stationary','merk_paper'];


	$data['beauty']['index'] = ['merk_hair_cond','merk_hair_mask','merk_hair_spray','merk_hair_vit','merk_cream_bb','merk_cream_night','merk_cream_white','merk_face_powder','merk_eyebrow','merk_mascara','merk_foundation',
'merk_eyeshadow','merk_sunblock','merk_body_scrub','merk_body_butter','merk_parf_edt','merk_parf_edp','merk_slimming'];

	$data['electronic']['index'] = ['merk_hometht','merk_ledtv','merk_smartv','merk_ac','merk_waterhtr','merk_washmch','merk_gym_tools','merk_mcwave','merk_refri','merk_audio','merk_pc','merk_laptop','merk_tablet','merk_smphone',
'merk_printer','merk_vidgame','merk_riceckr','merk_dvd','merk_fan'];

	$data['transport']['index'] = ['merk_car','merk_mb','merk_bike'];


		$this->template->load('maintemplate_urban', 'ressummary/views/tvcc_view', $data);
	}
	
	
	public function get_data_chart_merk_summ(){
		
		$merk_list = $this->tvcc_model->get_merk_list();
		
		foreach($merk_list as $merk_lists){
			
			$array_data[$merk_lists['MERK']]['title'] = $merk_lists['LABEL'];
			$array_data[$merk_lists['MERK']]['label'][0] = "'".$merk_lists['M1']."'";
			$array_data[$merk_lists['MERK']]['label'][1] = "'".$merk_lists['M2']."'";
			$array_data[$merk_lists['MERK']]['label'][2] = "'".$merk_lists['M3']."'";
			$array_data[$merk_lists['MERK']]['label'][3] = "'".$merk_lists['M4']."'";
			$array_data[$merk_lists['MERK']]['label'][4] = "'".$merk_lists['M5']."'";
			$array_data[$merk_lists['MERK']]['value'][0] = $merk_lists['V1'];
			$array_data[$merk_lists['MERK']]['value'][1] = $merk_lists['V2'];
			$array_data[$merk_lists['MERK']]['value'][2] = $merk_lists['V3'];
			$array_data[$merk_lists['MERK']]['value'][3] = $merk_lists['V4'];
			$array_data[$merk_lists['MERK']]['value'][4] = $merk_lists['V5'];
			
		}
		
		return $array_data;
		
	}
	
	
	public function get_data_chart_merk(){
		
		$merk_list = $this->tvcc_model->get_merk_list();
			
			$qry_all = '';
			
		foreach($merk_list as $merk_lists){
			
			$merk_list_sub = $this->tvcc_model->get_merk_list_sub($merk_lists['DESCRIPTION']);
			
			$scr = ' SELECT ';
			foreach($merk_list_sub as $merk_list_subs){

				$scr .= ' SUM(IF('.$merk_lists['DESCRIPTION'].' LIKE "%'.$merk_list_subs['FIELD'].'%",WEIGHT,0 )) AS `'.strtoupper($merk_list_subs['LABEL']).'`,';

			}
			
			$scr = substr($scr,0,-1);
			
			$scr .= ' FROM URBAN_PROFILE_P22 WHERE WEIGHT IS NOT NULL';

			$datax = $this->tvcc_model->get_value_res_split($scr);
			
			$array_data = [];
			$int_s = 0;
			foreach(array_keys($datax[0]) as $datas){
				
				$array_data[$int_s]['LABEL'] = $datas;
				$array_data[$int_s]['value'] = $datax[0][$datas];
				$int_s++;
			}
			
			usort($array_data, function($a, $b) {
				return $a['value'] - $b['value'];
			});
			
			$narray = array_reverse($array_data);
			
			$data_f = [];
			
			for($i=0;$i<5;$i++){
				
				$data_f['label'][] =  "'".$narray[$i]['LABEL']."'";
				$data_f['value'][] =  $narray[$i]['value'];
				
			}
			
		
			$qry_insert = ' INSERT INTO MERK_SUMMARY_P22 VALUES ( ';
				
			$qry_insert_sub = "'".$merk_lists['DESCRIPTION']."','',".$data_f['label'][0].",".$data_f['label'][1].",".$data_f['label'][2].",".$data_f['label'][3].",".$data_f['label'][4].",'".$data_f['value'][0]."','".$data_f['value'][1]."','".$data_f['value'][2]."','".$data_f['value'][3]."','".$data_f['value'][4]."'";
				
			$qry_insert = $qry_insert.''.$qry_insert_sub.');
			';
			
			$qry_all = $qry_all.''.$qry_insert;
			//echo $qry_insert;die;
			$array_data_merk[$merk_lists['DESCRIPTION']] = $data_f;
			
			
		}
		
		return $array_data_merk;
		
	}
	
	public function get_data_chart_index($param){
		
		$array_index = ['L' => 'Laki Laki','P' => 'PEREMPUAN','married' => 'Married','single' => 'Single','mcm' => 'Menikah – Cerai mati','mch' => 'Menikah – Cerai Hidup',
		'expense_vlow' => 'Dibawah Rp 3.000.000','expense_low' => 'Rp 3.000.000 s/d Rp 4.500.000','expense_middle' => 'Rp 4.500.001 s/d Rp 6.000.000','expense_mhigh' => 'Rp 6.000.001 s/d Rp 9.000.000','expense_high' => 'Rp 9.000.001 s/d Rp 12.000.000','expense_vhigh' => 'Diatas Rp 12.000.000',
		'art' => 'Ibu Rumah Tangga','swasta' => 'Pegawai Swasta','wiraswasta' => 'Wiraswasta','Pelajar' => 'Pelajar/ Mahasiswa','mandiri' => 'Pekerja mandiri','asn' => 'ASN (PNS)/ TNI/ POLRI','bumn' => 'BUMN atau BUMD','pensiunan' => 'Pensiunan',
		'rs' => 'Milik sendiri','rot' => 'Rumah Orang tua','sk' => 'Sewa/ kontrak','rsd' => 'Rumah saudara','rd' => 'Rumah dinas','ho_ll' => 'Lainnya','0' => 'Tidak','1' => 'Ya',
		'data_50' => 'Dibawah Rp 50ribu','data_100' => 'Rp 50ribu – Rp 100ribu','data_150' => 'Rp 100ribu – Rp 150ribu','data_200' => 'Rp 150ribu – Rp 200ribu','data_300' => 'Rp 200ribu – Rp 300ribu','data_300u' => 'Diatas Rp 300ribu'
		,'analog' => 'Analog TV','digital' => 'Digital TV'];
		
		$data = $this->tvcc_model->get_value_res($param);

		foreach($data as $datas){
			
			$data_f['label'][] =  "'".$array_index[$datas['LABEL']]."'";
			$data_f['value'][] =  $datas['PP'];
			
		}
		
		return $data_f;
		
	}
	
	public function get_data_chart_multi($field,$param){
		
		$array_index = [];
		
		$scr = ' SELECT ';
		foreach($param as $params){
			
			$scr .= ' SUM(IF('.$field.' LIKE "%'.$params.'%",WEIGHT,0 )) AS `'.$params.'`,';
			
		}
		
		$scr = substr($scr,0,-1);
		
		$scr .= ' FROM URBAN_PROFILE_P22 WHERE WEIGHT IS NOT NULL';
		
	//	ECHO $scr;die;
		
		$data = $this->tvcc_model->get_value_res_split($scr);
		
		
		$int_s = 0;
		foreach(array_keys($data[0]) as $datas){
			
			$array_data[$int_s]['LABEL'] = $datas;
			$array_data[$int_s]['value'] = $data[0][$datas];
			$int_s++;
		}
		
		//print_r($array_data);die;
		
		usort($array_data, function($a, $b) {
			return $a['value'] - $b['value'];
		});
		
		//print_r(array_reverse($array_data));die;
		
	
		foreach(array_reverse($array_data) as $datas){
			
			$data_f['label'][] =  "'".$datas['LABEL']."'";
			$data_f['value'][] =  $datas['value'];
			
		}
		
		//print_r($data_f);die;
		
		return $data_f;
		
	}
		
	public function get_data_chart_split($param){
		
		$array_index = ['cinema_loc_xx1' => 'Cinema XXI','cinema_loc_studio21' => 'Studio 21','cinema_loc_cgv' => 'CGV*Blitz','cinema_loc_cinemaxx' => 'Cinemaxx','cinema_loc_other' => 'Lainnya','cinema_loc_platinum' => 'Platinum Cineplex',
		'hangout_loc_park' => 'Taman Kota','hangout_loc_cafe' => 'Kafe / Resto','hangout_loc_library' => 'Perpustakaan','hangout_loc_school' => 'Sekolah / Kampus','hangout_loc_gym' => 'Tempat olah raga / Klub kebugaran','hangout_loc_other' => 'Lainnya',
		'provider_axis' => 'Axis','provider_isat' => 'Indosat','provider_smfr' => 'Smartfren','provider_tsel' => 'Telkomsel','provider_three' => 'Three','provider_xl' => 'XL','provider_etc' => 'Lainnya','website_type_news_info' => 'Akses situs berita dan informasi',
'website_type_learning' => 'Akses situs pembelajaran',
'website_type_lifestyle' => 'Akses situs gaya hidup',
'website_type_hobby' => 'Akses situs hobi',
'website_type_entertainment' => 'Akses situs hiburan',
'website_type_ol_shopping' => 'Akses belanja online',
'website_type_gaming' => 'Akses situs games',
'website_type_soc_med' => 'Akses situs media sosial',
'website_type_video_stream' => 'Akses situs video streaming',
'website_type_audio_stream' => 'Akses situs musik/ audio streaming',
'int_activity_video_call' => 'Akses situs video call',
'int_activity_messaging' => 'Melakukan chatting/ instan messaging',
'int_activity_ol_meeting' => 'Meeting online',
'int_activity_download' => 'Download',
'int_activity_upload' => 'Upload',
'int_activity_email' => 'Email',
'int_activity_others' => 'Lainnya',
'info_type_journal' => 'Publikasi hasil penelitian atau jurnal',
'info_type_breaking_news' => 'Berita terbaru/ terkini',
'info_type_product' => 'Informasi produk atau jasa',
'info_type_movie_ent' => 'Informasi film dan hiburan',
'info_type_economy' => 'Informasi Ekonomi',
'info_type_politics' => 'Informasi Politik',
'info_type_culinary' => 'Informasi Kuliner',
'info_type_otomotif' => 'Informasi Otomotif',
'info_type_property' => 'Informasi Properti',
'info_type_health_sport' => 'Informasi Kesehatan & Olahraga',
'info_type_technology' => 'Informasi Teknologi Informasi',
'info_type_etc'  => 'Lainnya','gaming_steam' => 'Steam','gaming_garena' => 'Garena','gaming_battlenet' => 'Battle.net','gaming_gog' => 'GOG','gaming_epic' => 'Epic Game','gaming_ubisoft' => 'Ubisoft Store','gaming_orign' => 'Origin','gaming_uplay' => 'Uplay','gaming_gamersgate' => 'Gamers Gate','gaming_ocean' => 'Ocean of games','gaming_acidplay' => 'Acid Play','gaming_humble' => 'Humble bundle','gaming_gametop' => 'GameTop','gaming_eaplay' => 'EA play','gaming_armor' => 'Armor Games','gaming_itchr' => 'Itch.io','gaming_jolt' => 'Game Jolt','gaming_etc'  => 'Lainnya','genre_aud_pop' => 'Pop','genre_aud_funk' => 'Funk/Rock','genre_aud_dangdut' => 'Dangut','genre_aud_jazz' => 'Jazz','genre_aud_hiphop' => 'Hip hop','genre_aud_rap' => 'Rap','genre_aud_kroncong' => 'Keroncong','genre_aud_etc' => 'Lainnya','app_aud_soundc' => 'Sound Cloud','app_aud_joox' => 'JOOX Music','app_aud_melon' => 'MelOn','app_aud_spotify' => 'Spotify Music','app_aud_musixmatch' => 'MusixMatch','app_aud_vortex' => 'Vortex Music Player','app_aud_guvera' => 'Guvera Music','app_aud_deezer' => 'Deezer Music','app_aud_apple' => 'Apple Music (iTunes)','app_aud_langitm' => 'Langit Musik','app_aud_amazon' => 'Amazon Music with Prime Music','app_aud_etc' => 'Lainnya','genre_vid_adv' => 'Adventure','genre_vid_act' => 'Action','genre_vid_com' => 'Komedi','genre_vid_drama' => 'Drama','genre_vid_mistic' => 'Mistic','genre_vid_horror' => 'Horor & Thriller','genre_vid_etc' => 'Lainnya','app_vid_mola' => 'Mola','app_vid_viu' => 'Viu','app_vid_hbogo' => 'HBO Go','app_vid_maxstream' => 'Maxstream','app_vid_disney' => 'Disney+','app_vid_video' => 'Vidio','app_vid_lionsgate' => 'Lionsgate','app_vid_useetyvgo' => 'UseeTV Go','app_vid_catchplay' => 'Catchplay','app_vid_netflix' => 'Netflix','app_vid_iqiyi' => 'Iqiyi','app_vid_googleplay' => 'Google play movie','app_vid_iflix' => 'Iflix WeTV','app_vid_genflix' => 'Genflix','app_vid_youtube' => 'Youtube','app_vid_etc' => 'Lainnya','cons_aud_free' => 'Tersedia akses gratis', 'cons_aud_interface' => 'Tampilan / interface-nya', 'cons_aud_catalog' => 'Katalog musiknya', 'cons_aud_syncron' => 'Sinkronisasi antar perangkat', 'cons_aud_quality' => 'Kualitas audio', 'cons_aud_etc' => 'Lainnya', 'cons_vid_price' => 'Tarif berlangganan', 'cons_vid_device' => 'Jumlah device untuk menikmati', 'cons_vid_content' => 'Konten film', 'cons_vid_dvcvariety' => 'Bisa bermacam device untuk menikmati', 'cons_vid_resolution' => 'Resolusi video', 'cons_vid_offline' => 'Fitur yang tersedia', 'cons_vid_etc' => 'Lainnya',
'is_toko' => 'Toko/ warung klontong','is_minimarket' => 'Minimarket','is_psr_trdsnal' => 'Pasar Tradisional','is_supermrkt' => 'Supermarket','is_hipermrkt' => 'Hipermarket' ,'is_ol_shop_kebutuhan' => 'Online Shop','minimrkt_alfamart' => 'Alfamart','minimrkt_alfamidi' => 'Alfamidi','minimrkt_bright' => 'Bright','minimrkt_circlek' => 'Circle K','minimrkt_indomaret' => 'Indomaret','minimrkt_etc' => 'Lainnya',
'supermrkt_indogrosir' => 'Indogrosir','supermrkt_lottemart' => 'Lottemart','supermrkt_superindo' => 'Superindo','supermrkt_ranchmrkt' => 'Ranchmarket','supermrkt_hero' => 'Hero','supermrkt_etc' => 'Lainnya',
'hipermrkt_loc_hypermart' => 'Hypermart','hipermrkt_loc_lotte' => 'Lotte','hipermrkt_loc_transmart' => 'Transmart','hipermrkt_loc_others' => 'Lainnya',
'ol_shop_kebutuhan_tani' => 'Tani Hub','ol_shop_kebutuhan_gomart' => 'Gomart','ol_shop_kebutuhan_sayurbox' => 'Sayurbox','ol_shop_kebutuhan_segari' => 'Segari','ol_shop_kebutuhan_orami' => 'Orami ','ol_shop_kebutuhan_etc' => 'Lainnya',
'med_ol_radio' => 'RADIO','med_ol_tab' => 'TABLOID','med_ol_tv' => 'TV','med_ol_streaming' => 'STREAMING','med_ol_situs' => 'SITUS','med_ol_nwsppr' => 'KORAN','med_ol_socmed' => 'SOCIAL MEDIA','med_ol_mjlh' => 'MAJALAAH','med_ol_etc' => 'LAINNYA',
'situs_ol_detik' => 'detik.com','situs_ol_tirto' => 'tirto.id','situs_ol_tempo' => 'tempo.com','situs_ol_kumparan' => 'kumparan.com','situs_ol_okezone' => 'okezone.com','situs_ol_liputan6' => 'liputan6.com','situs_ol_kompas' => 'kompas.com','situs_ol_tribun' => 'tribunnews.com','situs_ol_kpnlg' => 'kapanlagi.com','situs_ol_etc' => 'Lainnya',
'socmed_fb_own' => 'Facebook','socmed_tw_own' => 'Twitter','socmed_ig_own' => 'Instagram','socmed_youtube_own' => 'Youtube','socmed_tiktok_own' => 'Tiktok','socmed_pntrest_own' => 'Pinterest','socmed_tumblr_own' => 'Tumblr','socmed_lnkdin_own' => 'Linkedln','socmed_snpcht_own' => 'Snapchat','socmed_etc_own' => 'Lainnya',
'socmes_line_own' => 'Line','socmes_imo_own' => 'IMO','socmes_wecht_own' => 'WeChat','socmes_skype_own' => 'Skype','socmes_wa_own' => 'Whatsapp','socmes_tele_own' => 'Telegram','socmes_fbm_own' => 'FB Messenger','socmes_yho_own' => 'Yahoo Messenger','socmes_etc_own' => 'Lainnya',
'med_con_radio' => 'Radio','med_con_tab' => 'Tabloid','med_con_tv' => 'Televisi','med_con_bltn' => 'Buletin Komunitas','med_con_nwsppr' => 'Koran','med_con_inflghmag' => 'Infligth Magz','med_con_mjlh' => 'Majalah','med_con_etc' => 'Lainnya',
'read_tbld_trbs' => 'Trubus','read_tbld_wi' => 'Wanita Indonesia','read_tbld_bntg' => 'Bintang','read_tbld_nova' => 'Nova','read_tbld_chip' => 'Chip','read_tbld_swa' => 'SWA','read_tbld_instr' => 'Intisari','read_tbld_rmh' => 'Rumah','read_tbld_gds' => 'Gadis','read_tbld_etc' => 'Lainnya',
'tbld_pol' => 'Politik','tbld_eko' => 'Ekonomi/Bisnis','tbld_sos' => 'Sosial/ Budaya','tbld_tek' => 'Teknologi','tbld_pro' => 'Properti','tbld_oto' => 'Otomotif','tbld_olhrg' => 'Olahraga','tbld_sht' => 'Kesehatan','tbld_hbrn' => 'Hiburan','tbld_fas' => 'Fashion','tbld_agro' => 'Agro','tbld_etc' => 'Lainnya',
'read_koran_jawa' => 'Jawa Pos','read_koran_kompas' => 'Kompas','read_koran_bi' => 'Bisnis Indonesia','read_koran_radar' => 'Radar','read_koran_investor' => 'Investor Daily','read_koran_jktpost' => 'Jakarta Post','read_koran_sindo' => 'Sindo','read_koran_tempo' => 'Tempo','read_koran_republika' => 'Republika','read_koran_etc' => 'Lainnya',
'koran_pol' => 'Politik','koran_eko' => 'Ekonomi/Bisnis','koran_sos' => 'Sosial/ Budaya','koran_tek' => 'Teknologi','koran_pro' => 'Properti','koran_oto' => 'Otomotif','koran_olhrg' => 'Olahraga','koran_sht' => 'Kesehatan','koran_hbrn' => 'Hiburan','koran_fas' => 'Fashion','koran_nas' => 'Berita daerah/ nasional','koran_ln' => 'Berita Luar Negeri',
'tv_genre_movies' => 'Movies','tv_genre_series' => 'TV Series','tv_genre_news' => 'News','tv_genre_religi' => 'Religi','tv_genre_ent' => 'Entertainment','tv_genre_kids' => 'Kids','tv_genre_sport' => 'Sport','tv_genre_lifestyle' => 'Lifestyle','tv_genre_music' => 'Music','tv_genre_knowledge' => 'Knowledge','tv_genre_documentary' => 'Documentary','tv_genre_local' => 'Local',
'tv_wkday_pagi' => 'wd Pagi hari','tv_wkday_siang' => 'wd Siang hari','tv_wkday_sore' => 'wd Sore hari','tv_wkday_mlm' => 'wd Malam hari','tv_wkday_dini' => 'wd Dini hari','tv_wkend_pagi' => 'we Pagi hari','tv_wkend_siang' => 'we Siang hari','tv_wkend_sore' => 'we Sore hari','tv_wkend_mlm' => 'we Malam hari','tv_wkend_dini' => 'we Dini hari',
'tv_mostwatch_digital_rcti' => 'RCTI','tv_mostwatch_digital_mnctv' => 'MNC TV','tv_mostwatch_digital_gtv' => 'GTV','tv_mostwatch_digital_inews' => 'iNews','tv_mostwatch_digital_metrotv' => 'Metro TV','tv_mostwatch_digital_sctv' => 'SCTV','tv_mostwatch_digital_antv' => 'ANTV','tv_mostwatch_digital_indosiar' => 'Indosiar','tv_mostwatch_digital_trans7' => 'Trans 7','tv_mostwatch_digital_transtv' => 'Trans TV','tv_mostwatch_digital_tvone' => 'TV One','tv_mostwatch_digital_nettv' => 'NET TV','tv_mostwatch_digital_cnn_indo' => 'CNN Indonesia','tv_mostwatch_digital_kompastv' => 'Kompas TV','tv_mostwatch_digital_etc' => 'Lainnya',
'tv_mostwatch_analog_rcti' => 'RCTI','tv_mostwatch_analog_mnctv' => 'MNC TV','tv_mostwatch_analog_gtv' => 'GTV','tv_mostwatch_analog_inews' => 'iNews','tv_mostwatch_analog_metrotv' => 'Metro TV','tv_mostwatch_analog_sctv' => 'SCTV','tv_mostwatch_analog_antv' => 'ANTV','tv_mostwatch_analog_indosiar' => 'Indosiar','tv_mostwatch_analog_trans7' => 'Trans 7','tv_mostwatch_analog_transtv' => 'Trans TV','tv_mostwatch_analog_tvone' => 'TV One','tv_mostwatch_analog_nettv' => 'NET TV','tv_mostwatch_analog_cnn_indo' => 'CNN Indonesia','tv_mostwatch_analog_kompastv' => 'Kompas TV','tv_mostwatch_analog_etc' => 'Lainnya'];
		
		$scr = ' SELECT ';
		foreach($param as $params){
			
			$scr .= ' SUM(`'.$params.'`*WEIGHT) '.$params.',';
			
		}
		
		$scr = substr($scr,0,-1);
		
		$scr .= ' FROM URBAN_PROFILE_P22 WHERE WEIGHT IS NOT NULL';
		
		
		$data = $this->tvcc_model->get_value_res_split($scr);
		
		
		$int_s = 0;
		foreach(array_keys($data[0]) as $datas){
			
			$array_data[$int_s]['LABEL'] = $datas;
			$array_data[$int_s]['value'] = $data[0][$datas];
			$int_s++;
		}
		
		//print_r($array_data);die;
		
		usort($array_data, function($a, $b) {
			return $a['value'] - $b['value'];
		});
		
		//print_r(array_reverse($array_data));die;
		
	
		foreach(array_reverse($array_data) as $datas){
			
			$data_f['label'][] =  "'".$array_index[$datas['LABEL']]."'";
			$data_f['value'][] =  $datas['value'];
			
		}
		
		//print_r($data_f);die;
		
		return $data_f;
		
	}
	
	public function get_data_chart_split_nu($param){
		
		$array_index = ['tv_mostwatch_genre_antv' => 'ANTV','tv_mostwatch_genre_gtv' => 'GTV','tv_mostwatch_genre_indosiar' => 'Indosiar','tv_mostwatch_genre_kompastv' => 'Kompas TV','tv_mostwatch_genre_metrotv' => 'MetroTV','tv_mostwatch_genre_nettv' => 'Net TV','tv_mostwatch_genre_mnctv' => 'MNC TV','tv_mostwatch_genre_tvone' => 'TV One','tv_mostwatch_genre_rcti' => 'RCTI','tv_mostwatch_genre_sctv' => 'SCTV ','tv_mostwatch_genre_transtv' => 'Trans TV','tv_mostwatch_genre_trans7' => 'Trans 7','tv_mostwatch_genre_hbo' => 'HBO','tv_mostwatch_genre_tvn' => 'TVN','tv_mostwatch_genre_bioskop' => 'Bioskop Indonesia','tv_mostwatch_genre_cnn' => 'CNN','tv_mostwatch_genre_mtv' => 'MTV','tv_mostwatch_genre_sone' => 'S One','tv_mostwatch_genre_bein' => 'BEIN Sport','tv_mostwatch_genre_natgeowild' => 'Nat Geo Wild','tv_mostwatch_genre_natgeo' => 'National Geographic','tv_mostwatch_genre_cartoon' => 'Cartoon Network','tv_mostwatch_genre_etc' => 'Lainnya'];
		
		$scr = ' SELECT ';
		foreach($param as $params){
			
			$scr .= ' SUM(IF(`'.$params.'` = "",0,WEIGHT)) '.$params.',';
			
		}
		
		$scr = substr($scr,0,-1);
		
		$scr .= ' FROM URBAN_PROFILE_P22 WHERE WEIGHT IS NOT NULL';
		
		
		$data = $this->tvcc_model->get_value_res_split($scr);
		
		
		$int_s = 0;
		foreach(array_keys($data[0]) as $datas){
			
			$array_data[$int_s]['LABEL'] = $datas;
			$array_data[$int_s]['value'] = $data[0][$datas];
			$int_s++;
		}
		
		//print_r($array_data);die;
		
		usort($array_data, function($a, $b) {
			return $a['value'] - $b['value'];
		});
		
		//print_r(array_reverse($array_data));die;
		
	
		foreach(array_reverse($array_data) as $datas){
			
			$data_f['label'][] =  "'".$array_index[$datas['LABEL']]."'";
			$data_f['value'][] =  $datas['value'];
			
		}
		
		//print_r($data_f);die;
		
		return $data_f;
		
	}
	
	public function get_data_chart($param){

		$data = $this->tvcc_model->get_value_res($param);

		foreach($data as $datas){
			
			$data_f['label'][] =  "'".$datas['LABEL']."'";
			$data_f['value'][] =  $datas['PP'];
			
		}
		
		return $data_f;
		
	}	
	


	
	public function get_profile_id($profiles){
		$grouping_json = $this->tvcc_model->content_grouping($profiles);
		$res = json_decode($grouping_json['grouping'],true);		
		$values = [];
		$tag = '';
		$values1 = '';
		
		$strsql='';
		$strsql2='';
		
		$asas = " WHERE 1=1 ";
		
		if($res){		
			foreach($res as $mydata)
			{
				if($mydata['Operation']){
					$key = array_keys($mydata['Operation']);
					$asas = $asas."AND JSON_EXTRACT_STRING(ASTEROID_VALUE,'".$key[0]."') IN (";
					foreach($mydata['Operation'] as $val){
						foreach($val as $value){
							$asas = $asas."'".$value."',";
						}						
					}
					$asas = substr($asas,0,-1).") ";
				}
			}
		}
		
		$where = $asas; 
	
    if($res){		
			foreach($res as $mydata)
			{
				if($mydata['Operation']){
					$values[] = json_encode($mydata['Operation']);
				}
			}
		}
    
		$where = " WHERE 1=1 ";
		
		foreach($values as $vv){
			$str = str_replace("[{","",$vv);
			$str = str_replace("}]","",$str);
			$str_array = explode(",",$str);
			
			foreach($str_array as $str_arrays){
				$vals = explode(":",$str_arrays);
					
				$where = $where.' AND JSON_EXTRACT_STRING(ASTEROID_VALUE,'.$vals[0].') = '.$vals[1];				
			}
			
		} 
		
		$get_userid = $this->tvcc_model->get_userid($where);					
		if($res){		
			$key1 = '';
			foreach($get_userid as $key)
			{
				$key1 .= "'".$key['USERID']."'".",";
			}
			$profile = rtrim($key1,",");
		}else{
			$profile = '';	
		}
		
		return $profile;	
	}
  
  public function list_tvcc(){	                
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['end_date']);
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($_POST['dpart']) ) {
          $listDaypart = explode(",",$_POST['dpart']);
          
          if(count($listDaypart) > 1){
              $arrDaypart1 = explode("-",$listDaypart[0]);
              $start_time = $arrDaypart1[0];
              
              $arrDaypart2 = explode("-",$listDaypart[count($listDaypart) - 1]);
              $end_time = $arrDaypart2[1];
          } else {
              $arrDaypart = explode("-",$_POST['dpart']);
              
              $start_time = $arrDaypart[0]; 
              $end_time = $arrDaypart[1];
          }
      } else {
          $start_time = NULL; 
          $end_time = NULL;
      }
      
      if( ! empty($_POST['profile']) ) {
          $profiles = $_POST['profile'];
      } else {
          $profiles = 0;
      }                                            
      
      $order_fields = ['DATE','M1'];
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          for($i=0;$i < sizeof($channel);$i++){
              $order_fields[$i+2] = str_replace("'","",$channel[$i]);
          }
      } else {
          $channel = "0";
          $channel_array = $this->tvcc_model->channelsearch("","");
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
      if( ! empty($_POST['cgroup']) ) {
          $cgroup = $_POST['cgroup'];
      } else {
          $cgroup = NULL;
      }
      //print_r($order_fields);die();
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      //$order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
      // Build params for calling model 
      $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
      $params['order_column'] = $order_fields[$order_column];
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profiles;
      $params['channel']		= $channel;
      $params['cgroup']		= $cgroup; 
      //print_r($params);

      $arr_tvcc = [];
	  
      //$arraychannel = explode(",",$params['channel']);
      //print_r($params['channel']."kkk");die;
	  
      $list = $this->tvcc_model->list_tvcc($params);
	   
      $n_a = $list['data'];            
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      
      $paging_array = array_slice($n_a,$params['offset'],$params['limit']);
      
      $data = array();		
      for($i=0;$i<count($paging_array);$i++){
          $new_array =  array_values($paging_array[$i]);
          for($j=2; $j < count($new_array); $j++){ 
              if($cgroup == "viewers"){
                  $new_array[$j] = number_format($new_array[$j],0,",",".");
              } else {
                  $new_array[$j] = number_format($new_array[$j],2,",",".");
              }
          } 
          array_push($data,$new_array);
      }                                
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }
  
  public function list_charttvcc()
	{	                
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['end_date']);
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($_POST['dpart']) ) {
          $listDaypart = explode(",",$_POST['dpart']);
          
          if(count($listDaypart) > 1){
              $arrDaypart1 = explode("-",$listDaypart[0]);
              $start_time = $arrDaypart1[0];
              
              $arrDaypart2 = explode("-",$listDaypart[count($listDaypart) - 1]);
              $end_time = $arrDaypart2[1];
          } else {
              $arrDaypart = explode("-",$_POST['dpart']);
              
              $start_time = $arrDaypart[0]; 
              $end_time = $arrDaypart[1];
          }
      } else {
          $start_time = NULL; 
          $end_time = NULL;
      }
      
      if( ! empty($_POST['profile']) ) {
          $profiles = $_POST['profile'];
      } else {
          $profiles = 0;
      }
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
      } else {
          $channel = "0";
      }
      
      if( ! empty($_POST['cgroup']) ) {
          $cgroup = $_POST['cgroup'];
      } else {
          $cgroup = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
      // Build params for calling model 
      $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
      $params['order_column'] = $order_fields[$order_column];
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profiles;
      $params['channel']		= $channel;
      $params['cgroup']		= $cgroup;
      //print_r($params); die(); 

      $arr_tvcc = [];
	  
      //$arraychannel = explode(",",$params['channel']);
      //print_r($params['channel']."kkk");die;
	  
      $list = $this->tvcc_model->list_charttvcc($params);
      //print_r($list);die;
      $n_a = $list['data'];
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      
      $paging_array = array_slice($n_a,$params['offset'],$params['limit']);
      
      $data = array();		
      for($i=0;$i<count($paging_array);$i++){
          $new_array =  array_values($paging_array[$i]); 
          array_push($data,$new_array);
      } 
      
	  $data = $n_a;
      
	  
	  
	  $final_data = [];
	  
	  foreach($data as $datas){
		  $has = 0;
		  foreach($datas as $datass){
			  
			 $final_data[$has][] =  $datass;
			 $has++;
		  }
		 
	  }
    //print_r($final_data);die;
    
    $data['tvcc'] = $final_data;
    $result["data"] = $data;
    //print_r($data);
    
    $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }                                                                            
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvcc_model->profilesearch($_GET['q'],$iduser,$_GET['f']);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }   
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvcc_model->list_profile($iduser,"",$_GET['f']);          
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                             
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->tvcc_model->channelsearch($_GET['q'],$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
  
  public function checkdaypart(){
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($_GET['f']) ) {
          $from = $_GET['f'];
      } else {
          $from = "00:00";
      }
      
      if( ! empty($_GET['t']) ) {
          $to = $_GET['t'];
      } else {
          $to = "00:00";
      }
      
      $daypart = $_GET['f'].":00-".$_GET['t'].":00"; 
      
      $count_daypart = $this->tvcc_model->checkdaypart($userid,$daypart);
    
  		if ( $count_daypart != "1" ) {
        $result = array( 'success' => true, 'message' => 'Vacant', 'data' => array('hasil' => $count_daypart));
  			
  			$this->output->set_content_type('application/json')->set_output(json_encode($result));
  		} else {
  			$result = array( 'success' => false, 'message' => 'Exist', 'data' => array('hasil' => $count_daypart));
  			$this->output->set_content_type('application/json')->set_output(json_encode($result));
  		}
  }
  
  public function setdaypart(){
      $typerole = $this->session->userdata('type_role');
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($_GET['f']) ) {
          $from = $_GET['f'];
      } else {
          $from = "00:00";
      }
      
      if( ! empty($_GET['t']) ) {
          $to = $_GET['t'];
      } else {
          $to = "00:00";
      }
      
      $daypart = $this->tvcc_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}