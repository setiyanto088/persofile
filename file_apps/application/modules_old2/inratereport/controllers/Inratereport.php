<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inratereport extends JA_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inratereport_model');
	}

	public function filter_days()
	{
		$type =  $this->input->post('audiencebarday');
		$periode =  $this->input->post('periode');
		$where = '';

		if ($type == 'Viewers') {
			$data['date'] = $this->inratereport_model->list_spot_by_date_all2_viewer($where, $periode);
		} elseif ($type == 'Duration') {
			$data['date'] = $this->inratereport_model->list_spot_by_date_all2_duration($where, $periode);
		} else {
			$data['date'] = $this->inratereport_model->list_spot_by_date_all2($where, $periode);
		}

		if ($data['date'] <> null) {
			foreach ($data['date'] as $datasss) {
				$data_date[] = $datasss['date'];
				$spot_date[] = floatval($datasss['spot']);
			}
		} else {
			$data_date[] = '';
			$spot_date[] = 0;
		}

		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;

		echo json_encode($data, true);

	}

	public function get_report()
	{
		$where = '';

		$sess_user_id =  $this->input->post('sess_user_id');
		$sess_token =  $this->input->post('sess_token');
		$periode = $this->input->post('periode');
		$pilihprog = $this->input->post('pilihprog');
		$tgl1mr = $this->input->post('tgl1mr');
		$tgl2mr = $this->input->post('tgl2mr');
		$check = $this->input->post('check');
		$channel = $this->input->post('channel');
		$profile = 0;
		$genre = $this->input->post('genre');
		$tipe_filter = $this->input->post('tipe_filter_prog');


		$params['periode'] 	= $periode;
		$params['genre'] 	= $genre;
		$params['profile'] 	= 0;
		$params['tgl2mr'] 	= $tgl2mr;
		$params['tgl1mr'] 	= $tgl1mr;
		$params['check'] 	= $check;
		$array_mnth = array();

		$start    = new DateTime($tgl1mr);
		$start->modify('first day of this month');
		$end      = new DateTime($tgl2mr);
		$end->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		$array_period = array();

		$condition1 = '';
		$condition2 = '';
		$dataindex = 0;
		foreach ($period as $dt) {
			$array_period[] = $dt->format("Y-F");
			$condition1 .= " AA".$dataindex.".AUDIENCE AS AUDIENCE, AA".$dataindex.".`TVR` AS TVR, AA".$dataindex.".`TVS` AS TV, AA".$dataindex.".`TOTAL_VIEW` AS VIEWS, AA".$dataindex.".`REACH` AS REACH, ";
			$condition2 .= " LEFT JOIN ( SELECT * FROM `AUDIENCE_DAYS_ALL` WHERE TYPE = 'MONTHLY' AND PERIODE = '".$dt->format("Y-F")."' ) AA".$dataindex." ON A.CHANNEL = AA".$dataindex.".CHANNEL";
			$dataindex++;
		}

		if ($params['check'] == "True") {
			$wh_chn = '';
		} else {
			$wh_chn = " AND A.CHANNEL NOT IN (SELECT CHANNEL_NAME_PROG FROM CHANNEL_PARAM_FINAL C
							LEFT JOIN CHANNEL_PARAM D ON C.CHANNEL_NAME = D.`CHANNEL_NAME`
							WHERE C.`FLAG_TV` = 0) ";
		}

		if($params['genre'] !== 'ALL'){
			$condition2 .= " WHERE B.GENRE = '".$params['genre']."' ";
		}

		$query = "SELECT A.CHANNEL, B.GENRE, ".$condition1." 'aaa' as hoo FROM 
				( SELECT CHANNEL, TOTAL_VIEW FROM AUDIENCE_DAYS_ALL WHERE TYPE = 'MONTHLY' AND PERIODE BETWEEN '".$tgl1mr."' 
				AND '".$tgl2mr."' " .$wh_chn." GROUP BY CHANNEL, TOTAL_VIEW ) A
				JOIN INRATE_CHANNEL_GENRE B ON A.CHANNEL = B.CHANNEL ".$condition2. "  GROUP BY A.CHANNEL, B.GENRE, AA0.AUDIENCE , AA0.TVR, AA0.TVS, AA0.TOTAL_VIEW, AA0.REACH ORDER BY AA0.TOTAL_VIEW DESC ";




		$list = $this->inratereport_model->get_reports($query);
		
		

		$data = array();
		$idx = 0;

		$i = 1;
		$ik = 0;
		foreach ($list as $datax) {
			$data[$ik]['Rangking'] = $i;
			$data[$ik]['CHANNEL'] = $datax['CHANNEL'];
			$data[$ik]['GENRE'] = $datax['GENRE'];
			$frt = 0;
			foreach ($array_period as $dts) {
				$data[$ik]['AUDIENCE'. $frt] =  $datax['AUDIENCE'];
				$data[$ik]['TVR' . $frt] =  $datax['TVR'];
				$data[$ik]['TVS' . $frt] =  $datax['TVS'];
				$data[$ik]['VIEWS' . $frt] =  $datax['VIEWS'];
				$data[$ik]['REACH' . $frt] =  $datax['REACH'] * 100;
				$frt++;
			}
			$i++;
			$ik++;
		}
		
		echo json_encode($data, true);
	}

	public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');

		$datefg = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];

		$data['tanggal'] = $datefg;

		if ($id == null) {
			$id = 0;
		} else {
			$id = $this->session->userdata('project_id');
		}

		$data['thn'] = $this->inratereport_model->get_tahun();

		if (!$this->session->userdata('user_id')) {
		}

		if ($this->input->post('filter_text')) {
			$filter = $this->input->post('filter_text');
			$starttime = $this->input->post('starttime');
			$endtime = $this->input->post('endtime');
			$mindur = $this->input->post('mindur');
			$maxdur = $this->input->post('maxdur');

			$f_array = json_decode($filter, true);
			$where = " AND";
			foreach ($f_array as $farray) {
				if (isset($farray["children"])) {
					$where = $where . " " . $farray['id'] . " IN (";
					foreach ($farray["children"] as $child) {
						$where = $where . "'" . $child["id"] . "',";
					}
					$where = rtrim($where, ",");
					$where = $where . ") AND";
				}
			}

			$where = rtrim($where, "AND");

			if ($starttime <> "00:00:00") {
				$where = $where . " AND DATE_FORMAT(STR_TO_DATE(start_time, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('" . $starttime . "', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(end_time, '%T'), '%T') < DATE_FORMAT(STR_TO_DATE('" . $endtime . "', '%T'), '%T') ";
			}
			if ($mindur <> "00:00:00") {
				$where = $where . " AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('" . $mindur . "', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') <= DATE_FORMAT(STR_TO_DATE('" . $maxdur . "', '%T'), '%T') ";
			}
		} else {
			$where = " ";
		}

		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');

		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun);
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun);

		if (!isset($tahun)) {
			$tahun = $data['thn'][0]['TANGGAL'];
		}
		$periode = $tahun;

		$data['genre'] = $this->inratereport_model->get_genre();

		$data['mingguan1'] = $this->inratereport_model->get_week_channel($periode);
		$data['mingguan2'] = $this->inratereport_model->get_week_program($periode);
		$data['channel_list'] = $this->inratereport_model->channel_list($periode);
		$data['active_audience'] = $this->inratereport_model->get_active_audience($periode);
		$data['aa'] = $data['active_audience'][0]['VIEWERS'];
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;

		$data['cond'] = $where;

		$html = "";

		$prime = 0;
		$nprime = 0;

		$data['drag'] = $html;






		$this->template->load('maintemplate', 'inratereport/views/inratereport', $data);
	}

	function days_in_month($month, $year)
	{
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	}
}
