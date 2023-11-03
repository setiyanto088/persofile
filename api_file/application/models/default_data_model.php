<?php

class default_data_model extends CI_Model
{

	public function list_role($id_user) {

		$this->db->select('"USER_ROLE"."ROLE_ID","ROLE"."NAME"');
		$this->db->from('"USER_ROLE"');
		$this->db->join('"ROLE"', 'USER_ROLE.ROLE_ID=ROLE.ID', 'inner');
		$this->db->where('"USER_ID"', $id_user);
		$this->db->order_by('"USER_ROLE"', 'asc');

		return $list_role = $this->db->get()->result_array();

	}

	public function task() {
		$user_id = $_COOKIE["pmis2_user_id"];
		$query = "SELECT a.nama AS task, d.nama AS project, b.nama AS nama, e.txt1 AS status_task, f.txt1 AS priority,proi.username AS Project_Leader
				FROM pmt_task a
				LEFT JOIN hrd_profile b ON a.task_owner = b.id
				LEFT JOIN pmt_modul c ON a.id=c.id 
				LEFT JOIN pmt_project d ON c.project_id = d.id
				LEFT JOIN pmt_team AS tea ON d.id = tea.project_id AND tea.role_id = '23'
				LEFT JOIN hrd_profile AS proi ON tea.profile_id = proi.id
				INNER JOIN pmt_parameter e ON a.status_task = e.rfid
				INNER JOIN pmt_parameter f ON a.priority = f.rfid
				
			WHERE
				a.task_owner	= ".$user_id."
			AND	f.rfen	= 'TSKPRIO'
			AND	e.rfen = 'STATTSK' ";  			
		$sql	= $this->db->query($query);
		$this->db->close();	   
	
		return $sql->num_rows();
		
	}
	public function list_task() {
		$user_id = $_COOKIE["pmis2_user_id"];
		$query = "SELECT a.nama AS task,e.txt1 AS status_task
				FROM pmt_task a
				LEFT JOIN hrd_profile b ON a.task_owner = b.id
				LEFT JOIN pmt_modul c ON a.id=c.id 
				LEFT JOIN pmt_project d ON c.project_id = d.id
				LEFT JOIN pmt_team AS tea ON d.id = tea.project_id AND tea.role_id = '23'
				LEFT JOIN hrd_profile AS proi ON tea.profile_id = proi.id
				INNER JOIN pmt_parameter e ON a.status_task = e.rfid
				INNER JOIN pmt_parameter f ON a.priority = f.rfid
				
			WHERE
				a.task_owner	= ".$user_id."
			AND	f.rfen	= 'TSKPRIO'
			AND	e.rfen = 'STATTSK' ";  			
		$sql	= $this->db->query($query);
		$this->db->close();	   
	
		return $sql->result_array();
		
	}

	public function jml_not_accomplished($id_user) {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		
		if ($xgroup == 'FLM')
		{
		$this->db->from('"MORDER"');
		$this->db->join('VENDOR', 'MORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','MORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		//$this->db->where('"ORDER"."STATUS" not in (3,4)',null,false);
		$this->db->where('"MORDER"."STATUS" <= 2',null,false);
		$this->db->where('"MORDER"."ASSIGN_DATE" < \''.date("Y-m-d").'\'',null,false);
		switch ($hak_akses) {
			case 58:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"MORDER"."USER_ID"',$id_user);
				break;
			case 56: // admin vendor
				$this->db->where('"MORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 57: // admin infra
			case 55: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$data_4_close=$this->db->get();

		return $jml_not_accomplished=$data_4_close->num_rows();
		}else{
			
			
		$this->db->from('"ORDER"');
		$this->db->join('VENDOR', 'ORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','ORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		//$this->db->where('"ORDER"."STATUS" not in (3,4)',null,false);
		$this->db->where('"ORDER"."STATUS" <= 2',null,false);
		$this->db->where('"ORDER"."ASSIGN_DATE" < \''.date("Y-m-d").'\'',null,false);
		switch ($hak_akses) {
			case 2:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"ORDER"."USER_ID"',$id_user);
				break;
			case 41: // admin vendor
				$this->db->where('"ORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 3: // admin infra
			case 1: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$data_4_close=$this->db->get();

		return $jml_not_accomplished=$data_4_close->num_rows();
		}
	}

	public function reschedule_preventif($id_user) {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		
		if ($xgroup == 'FLM')
		{
		$this->db->from('"MORDER"');
		$this->db->join('VENDOR', 'MORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','MORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"MORDER"."ORDER_TYPE_ID"','1');
		$this->db->where('"MORDER"."STATUS"','1');
		$this->db->where('"MORDER"."ASSIGN_DATE"',date("Y-m-d"));
		switch ($hak_akses) {
			case 58:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"MORDER"."USER_ID"',$id_user);
				break;
			case 56: // admin vendor
				$this->db->where('"MORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 57: // admin infra
			case 55: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"MORDER"."ID" in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$reschedule_preventif=$this->db->get();
		return $reschedule_preventif=$reschedule_preventif->num_rows();	
		}else{	
		$this->db->from('"ORDER"');
		$this->db->join('VENDOR', 'ORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','ORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"ORDER"."ORDER_TYPE_ID"','1');
		$this->db->where('"ORDER"."STATUS"','1');
		$this->db->where('"ORDER"."ASSIGN_DATE"',date("Y-m-d"));
		switch ($hak_akses) {
			case 2:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"ORDER"."USER_ID"',$id_user);
				break;
			case 41: // admin vendor
				$this->db->where('"ORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 3: // admin infra
			case 1: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"ORDER"."ID" in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$reschedule_preventif=$this->db->get();
		return $reschedule_preventif=$reschedule_preventif->num_rows();
		}
	}


	public function reschedule_corrective($id_user) {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		
		if ($xgroup == 'FLM')
		{
		$this->db->from('"MORDER"');
		$this->db->join('VENDOR', 'MORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','MORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"MORDER"."ORDER_TYPE_ID"','2');
		$this->db->where('"MORDER"."STATUS"','1');
		$this->db->where('"MORDER"."ASSIGN_DATE"',date("Y-m-d"));
		
		
		switch ($hak_akses) {
			case 58:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"MORDER"."USER_ID"',$id_user);
				break;
			case 56: // admin vendor
				$this->db->where('"MORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 57: // admin infra
			case 55: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"MORDER"."ID" in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$reschedule_corrective=$this->db->get();
		return $reschedule_corrective=$reschedule_corrective->num_rows();
		}else{
		$this->db->from('"ORDER"');
		$this->db->join('VENDOR', 'ORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','ORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"ORDER"."ORDER_TYPE_ID"','2');
		$this->db->where('"ORDER"."STATUS"','1');
		$this->db->where('"ORDER"."ASSIGN_DATE"',date("Y-m-d"));
		
		
		switch ($hak_akses) {
			case 2:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"ORDER"."USER_ID"',$id_user);
				break;
			case 41: // admin vendor
				$this->db->where('"ORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 3: // admin infra
			case 1: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"ORDER"."ID" in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$reschedule_corrective=$this->db->get();
		return $reschedule_corrective=$reschedule_corrective->num_rows();
		}
	}

	public function order_preventif($id_user) {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		
		if ($xgroup == 'FLM')
		{
		$this->db->from('"MORDER"');
		$this->db->join('VENDOR', 'MORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','MORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"MORDER"."ORDER_TYPE_ID"','1');
		$this->db->where('"MORDER"."STATUS"','1');
		$this->db->where('"MORDER"."ASSIGN_DATE"',date("Y-m-d"));
		switch ($hak_akses) {
			case 58:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"MORDER"."USER_ID"',$id_user);
				break;
			case 56: // admin vendor
				$this->db->where('"MORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 57: // admin infra
			case 55: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"MORDER"."ID" not in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$order_preventif=$this->db->get();
		return $order_preventif=$order_preventif->num_rows();
		}else{
		$this->db->from('"ORDER"');
		$this->db->join('VENDOR', 'ORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','ORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"ORDER"."ORDER_TYPE_ID"','1');
		$this->db->where('"ORDER"."STATUS"','1');
		$this->db->where('"ORDER"."ASSIGN_DATE"',date("Y-m-d"));
		switch ($hak_akses) {
			case 2:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"ORDER"."USER_ID"',$id_user);
				break;
			case 41: // admin vendor
				$this->db->where('"ORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 3: // admin infra
			case 1: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"ORDER"."ID" not in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$order_preventif=$this->db->get();
		return $order_preventif=$order_preventif->num_rows();
		}
	}


	public function order_corrective($id_user) {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		if ($xgroup == 'FLM')
		{			
		$this->db->from('"MORDER"');
		$this->db->join('VENDOR', 'MORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','MORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"MORDER"."ORDER_TYPE_ID"','2');
		$this->db->where('"MORDER"."STATUS"','1');
		$this->db->where('"MORDER"."ASSIGN_DATE"',date("Y-m-d"));
		switch ($hak_akses) {
			case 58:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"MORDER"."USER_ID"',$id_user);
				break;
			case 56: // admin vendor
				$this->db->where('"MORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 57: // admin infra
			case 55: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"MORDER"."ID" not in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$order_corrective=$this->db->get();
		return $order_corrective=$order_corrective->num_rows();
		
		}else{
		$this->db->from('"ORDER"');
		$this->db->join('VENDOR', 'ORDER.VENDOR_ID = VENDOR.ID', 'inner');
		$this->db->join('"SITE"','ORDER.SITE_ID=SITE.ID','inner');
		//$this->db->join('"USER"','USER.CLUSTER=SITE.CLUSTER','inner');
		//$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.VENDOR_ID=VENDOR.ID','inner');
		$this->db->where('"ORDER"."ORDER_TYPE_ID"','2');
		$this->db->where('"ORDER"."STATUS"','1');
		$this->db->where('"ORDER"."ASSIGN_DATE"',date("Y-m-d"));
		switch ($hak_akses) {
			case 2:// engineer
				//$this->db->where('"USER"."USER_ID"',$id_user);
				$this->db->where('"ORDER"."USER_ID"',$id_user);
				break;
			case 41: // admin vendor
				$this->db->where('"ORDER"."VENDOR_ID"',$vendor_id);
				break;
			case 3: // admin infra
			case 1: // sa
				$this->db->where('0=0', null, false); // all
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		//$this->db->where('"SITE"."CLUSTER"="CLUSTER_MASTER"."ID"',null,false);
		$this->db->where('"ORDER"."ID" not in (select distinct "ORDER_ID" from "RESCHEDULE")',null,false);
		$order_corrective=$this->db->get();
		return $order_corrective=$order_corrective->num_rows();
		}
		
		
		
	}
	
	
	public function order_mbp() {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		$regional_id = $this->session->userdata('regional_id');
		$this->db->from('"MBP"');	
			switch ($hak_akses) {
			case 41: // admin vendor
				$this->db->where('"MBP"."VENDOR_ID"',$vendor_id);
				break;
			case 56:
				$this->db->where('"MBP"."VENDOR_ID"',$vendor_id);
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				//var_dump($xgroup);
				break;
			case 1: // admin infra			
			case 3: // admin infra
			$this->db->where('0=0', null, false); // all
			break;
			case 57:
			$this->db->where('"MBP"."REGIONAL"',$regional_id);
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				//var_dump($regional_id);
				break;
			case 55:
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 
		$this->db->join('"USER"','MBP.REQ_BY = USER.USER_ID', 'inner'); 		
		$this->db->where('"MBP"."MBP_STATUS"','0');			
		$order_mbp=$this->db->get();
		
		return $order_mbp=$order_mbp->num_rows();
	}
	
	public function order_bbm() {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		$regional_id = $this->session->userdata('regional_id');
		
		
		$this->db->from('"bbm"');		
			switch ($hak_akses) {
				case 41: // admin vendor
				$this->db->where('"bbm"."VENDOR_ID"',$vendor_id);
				break;
				case 56:
				$this->db->where('"bbm"."VENDOR_ID"',$vendor_id);
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				break;
			case 1: // admin infra
			case 3: // admin infra
				$this->db->where('0=0', null, false); // all
				break;
			case 57:
				$this->db->where('"bbm"."REGIONAL_REFUEL"',$regional_id);
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				//var_dump($regional_id);
				break;
			case 55:
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		}
		$this->db->join('"USER"','bbm.REQ_BY = USER.USER_ID', 'inner'); 		
		$this->db->where('"bbm"."REFUEL_STATUS"','0');
		$order_bbm=$this->db->get();
		//echo $this->db->last_query();
		return $order_bbm=$order_bbm->num_rows();
	}
	
	public function ticket($id_user) {
		$hak_akses = $this->session->userdata('role_id');
		$vendor_id = $this->session->userdata('vendor_id');
		$xgroup = $this->session->userdata('x_group');
		$regional_id = $this->session->userdata('regional_id');
		$cluster = $this->session->userdata('cluster_id');
		
		$this->db->from('"TICKET_MASTER"');		
		$this->db->join('SITE', 'TICKET_MASTER.SITE_ID = SITE.ID', 'inner');
			switch ($hak_akses) {
				case 41: // admin vendor
				$this->db->where('"TICKET_MASTER"."USER_ID" IN (SELECT "USER_ID" FROM "USER" WHERE "VENDOR_ID" = ' . $vendor_id .') ', null, false );
				break;
				case 56:
				$this->db->where('"USER"."VENDOR_ID"',$vendor_id);
				$this->db->where('"USER"."CLUSTER"',$cluster);
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				break;
			case 1: // admin infra
			case 3: // admin infra
				$this->db->where('0=0', null, false); // all
				break;
			case 57:
			$this->db->where('"CLUSTER_MASTER"."REGIONAL"',$regional_id);
			$this->db->where('"USER"."X_GROUP"',$xgroup);
			break;
			case 55:
				$this->db->where('"USER"."X_GROUP"',$xgroup);
				//$this->db->where('"USER"."CLUSTER"',$cluster);
				break;
			default: // others
				$this->db->where('0=1', null, false); // no data
				break;
		} 		
		
		$this->db->join('"USER"','TICKET_MASTER.USER_ID = USER.USER_ID', 'left');
		$this->db->join('"CLUSTER_MASTER"','CLUSTER_MASTER.ID = SITE.CLUSTER', 'left');
		$this->db->join('"REGIONAL"','CLUSTER_MASTER.REGIONAL = REGIONAL.ID_REGIONAL', 'left');
		$this->db->join('"VENDOR"','USER.VENDOR_ID = VENDOR.ID', 'left');
		$this->db->join('"MORDER"','TICKET_MASTER.ID = MORDER.CONTRACT_ID', 'left');
		$this->db->where('"TICKET_MASTER"."STATUS"', '0');
		$ticket = $this->db->get();
		//echo $this->db->last_query();
		return $ticket->num_rows();
	}

}	



?>
