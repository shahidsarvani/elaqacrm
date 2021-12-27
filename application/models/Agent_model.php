<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Agent_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}  
	
	function get_agent_active_properties(){ 
		//$this->db->where("is_lead='0'"); 
		$this->db->where("is_deleted='0'");  
		$this->db->where("is_archived='0'"); 
		$vs_id = $this->session->userdata('us_id');
		$this->db->where("assigned_to_id=$vs_id"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	} 
	
	function get_agent_archived_properties(){ 
		//$this->db->where("is_lead='0'"); 
		$this->db->where("is_deleted='0'");  
		$this->db->where("is_archived='1'"); 
		$vs_id = $this->session->userdata('us_id');
		$this->db->where("assigned_to_id=$vs_id"); 
		$num_rows = $this->db->count_all_results('properties_tbl');
		return $num_rows;
	}  
	
	function insert_nos_of_meetings_views_data($data){ 
		return $this->db->insert('meetings_views_tbl', $data);
	} 
	 
	function get_agent_meetings_views_list($agnt_id){ 
		$this->db->select("m.*, u.name AS agent_name");
		$this->db->from('meetings_views_tbl m, users_tbl u');
		$this->db->where('m.user_id=u.id');   
		$this->db->where("u.id=$agnt_id ");  
		$query = $this->db->get();
	   	return $query->result();
	} 
	
}  ?>