<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portals_model extends CI_Model {

	function __construct() {
		parent::__construct();  
	}   
	
	/* portals function starts */
	function get_max_portals_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('portals_tbl')->row();  
		return $rets->sort_order; 
	}

	function get_all_portals(){
	   $this->db->order_by("sort_order", "asc");
	   $query = $this->db->get('portals_tbl');
	   return $query->result();
	} 

	function get_all_portals_in_id($paras1){
		if(strlen($paras1)>0){
			$this->db->where(" id IN ($paras1) ");
		}
		$query = $this->db->get('portals_tbl');
		return $query->result();
	}
	
	function get_portal_by_id($args1){ 
		$query = $this->db->get_where('portals_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_portal_data($data){ 
		return $this->db->insert('portals_tbl', $data);
	}  
	
	function update_portal_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('portals_tbl', $data);
	}

	function trash_portal($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('portals_tbl');
		} 
		return true;
	} 
	
	
	function count_portal_assigned_properties_nums($paras1){ 
		$this->db->where(" FIND_IN_SET($paras1, show_on_portal_ids) "); 
		//$this->db->where(" is_deleted='0' "); 
		//$this->db->where(" is_archived='0' "); 
		$this->db->where(" property_status NOT IN (1,2) ");   
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	}
	
	
	/* portals function ends */ 
	
}  ?>