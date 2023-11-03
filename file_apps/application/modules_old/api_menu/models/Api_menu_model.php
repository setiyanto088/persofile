<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Api Auth Model
 * Model yang berhubungan dengan data-data autentikasi user
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
class Api_menu_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
        }
        
		function getMenu($role_id) {
		$uid = '86 	'; $rid = '25';

			$sql 	=	'SELECT
                            b.id,
                            b.menu,
                            b.namamenu,
                            b.parentid,
                            b.icon,
                            b.sequence
                        FROM
                            pmt_menu_profile a, 
                            pmt_menu_ev b 
                        WHERE
                            a.statusmenu	= 1 
                            AND b.status_menu	= 1 	
                            AND	a.id_menu	= b.id 
                            AND a.id_profile = ?
                        ORDER BY 
                            b.parentid, 
                            b.sequence,
                            b.namamenu;';
			$query 	=	$this->db->query($sql, array($role_id));
			$result =	$query->result_array();

			$menu = array(
				'items' => array(),
				'parents' => array()
			);
			
			// Builds the array lists with data from the menu table
			
			foreach ($result as $items)
				{
				// Creates entry into items array with current menu item id ie. $menu['items'][1]
				$menu['items'][$items['id']] = $items;
				// Creates entry into parents array. Parents array contains a list of all items with children
				$menu['parents'][$items['parentid']][] = $items['id'];
				}
            
            
			return $menu;

			
		}
		
		function getMenu2($role_id) {
		$uid = '4'; $rid = '22';
		
			$sql 	=	'CALL menu_list_user(?)';
			$query 	=	$this->db->query($sql, array($uid));
			$result =	$query->result_array();

			$menu = array(
				'items' => array(),
				'parents' => array()
			);
			
			// Builds the array lists with data from the menu table
			
			foreach ($result as $items)
				{
				// Creates entry into items array with current menu item id ie. $menu['items'][1]
				$menu['items'][$items['id']] = $items;
				// Creates entry into parents array. Parents array contains a list of all items with children
				$menu['parents'][$items['parentid']][] = $items['id'];
				}
			return $menu;
		}
		
		function get_all_menu() {
			$sql 	=	'CALL menu_list_all()';
			$query 	=	$this->db->query($sql);
			$result =	$query->result_array();
			
			$menu = array(
				'items' => array(),
				'parents' => array()
			);
			
			// Builds the array lists with data from the menu table
			foreach ($result as $items)
			{
				// Creates entry into items array with current menu item id ie. $menu['items'][1]
				$menu['items'][$items['id']] = $items;
				// Creates entry into parents array. Parents array contains a list of all items with children
				$menu['parents'][$items['parentid']][] = $items['id'];
			}
			return $menu;
			
		}
		
		function get_roles() {
			$sql 	=	'select id as id, role from pmt_role_new WHERE project_role <> 0 and id not in (23) order by role;';
			$query 	=	$this->db->query($sql);
			return	$query->result_array();
		}
		
	
		function save_menu($data, $role_id) {
			$this->db->trans_begin();
			
			$sql 	=	'CALL menu_delete(?)';
			$query 	=	$this->db->query($sql, array($role_id));
			
			$sql 	=	'CALL menu_create(?, ?)';
			foreach ($data as $id) {
				$query 	=	$this->db->query($sql, array($role_id, $id));
			}
			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE) {
				log_message('error', 'Save menu transaction failed : ' . $this->db->_error_message());
				return false;
			} 
			else {
				return true;
			}

		}
		
}
