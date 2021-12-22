<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Locations_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	}  
	
	/* locations function starts */
	function get_all_filter_locations($params = array()){
		$whrs =''; 
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val']; 
			if(strlen($q_val)>0){
				$whrs .=" AND ( name LIKE '%$q_val%' OR description LIKE '%$q_val%' ) ";
			}
		} 
		
		if(array_key_exists("status_val",$params)){
			$status_val = $params['status_val']; 
			if($status_val != ''){
				$whrs .=" AND status='%$status_val%' ";
			}
		} 
		
		if(array_key_exists("parentid_val",$params)){
			$parentid_val = $params['parentid_val']; 
			if($parentid_val != ''){
				$whrs .=" AND parent_id='$parentid_val' ";
			}
		} 
		
		$limits ='';
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
			$tot_limit =   $params['limit'];
			$str_limit =   $params['start']; 			 
			$limits = " LIMIT $str_limit, $tot_limit ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
             $tot_limit =   $params['limit'];
			$limits = " LIMIT $tot_limit ";
		}   
		
		$query = $this->db->query("SELECT * FROM locations_tbl WHERE id >'0' $whrs $limits "); 
		return $query->result(); 
	}
	 
	function count_location_nums($params = array()){ 
		$whrs =''; 
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val']; 
			if(strlen($q_val)>0){
				$whrs .=" AND ( name LIKE '%$q_val%' OR description LIKE '%$q_val%' ) ";
			}
		} 
		
		if(array_key_exists("status_val",$params)){
			$status_val = $params['status_val']; 
			if($status_val != ''){
				$whrs .=" AND status='%$status_val%' ";
			}
		} 
		
		if(array_key_exists("parentid_val",$params)){
			$parentid_val = $params['parentid_val']; 
			if($parentid_val != ''){
				$whrs .=" AND parent_id='$parentid_val' ";
			}
		}    
		
		$query = $this->db->query("SELECT count(id) as NUMS FROM locations_tbl WHERE id >'0' $whrs "); 
		return $query->row()->NUMS; 
	}
	
	function get_all_emirate_with_locations(){
		$this->db->order_by("l.name", "asc"); 
		$this->db->select("l.*, e.name AS emirate_name");
		$this->db->from('locations_tbl l, emirates_tbl e');
		$this->db->where('l.emirate_id=e.id'); 
		$query = $this->db->get();
	   	return $query->result();
	} 
	
	function get_parent_child_locations($parent_loc_id = '0'){
		$query = $this->db->get_where('locations_tbl', array('parent_id' => $parent_loc_id)); 
	   	return $query->result();
	} 
	
	function get_locations_by_id($args1){ 
		$query = $this->db->get_where('locations_tbl',array('id'=> $args1));
		return $query->result();
	}
	
	function get_location_by_id($args1){ 
		$query = $this->db->get_where('locations_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_location_data($data){ 
		return $this->db->insert('locations_tbl', $data);
	}  
	
	function update_location_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('locations_tbl', $data);
	}

	function trash_location($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('locations_tbl');
		} 
		return true;
	}
	
	function fetch_locations($loc_id='0'){ 
		if($loc_id>0){
			//$this->db->order_by("name", "asc");
			$query = $this->db->get_where('locations_tbl',array('id'=> $loc_id));
			return $query->result();
		}else{
			return false;
		}
	}
	
	
	function get_parent_location_name($par_id){ 
		$query = $this->db->get_where('locations_tbl',array('id'=> $par_id));
		return $query->row()->name;
	}
	
	  
	/* locations function ends */ 
	
}  ?>