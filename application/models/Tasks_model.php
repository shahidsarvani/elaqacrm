<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Tasks_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}  
	
	function trash_tasks_to_do($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('tasks_to_do_tbl');
		} 
		return true;
	}
	
	function get_all_tasks_to_do_old($assigned_to_id_val,$status_val,$from_date_val,$to_date_val){
		$vs_user_type_id= $this->session->userdata('us_role_id'); 
		$temp_agents_ids = '';
		if($vs_user_type_id==2){  
			$vs_id = $this->session->userdata('us_id');
			$agnt_arrs = $this->get_all_managers_agents_list($vs_id); 
			
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		 
		$this->db->select("*");
		$this->db->from('tasks_to_do_tbl');
		  
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id');
			$this->db->where("assigned_to=$vs_id"); 
		}else if($vs_user_type_id==2){
		 	if($assigned_to_id_val>0){ 
				$this->db->where("assigned_to=$assigned_to_id_val ");
			}else if($temp_agents_ids!=''){
				$vs_id = $this->session->userdata('us_id');
				$this->db->where("assigned_to=$vs_id OR assigned_to IN ($temp_agents_ids) ");
			}
		}else if($vs_user_type_id==1){
		 	if($assigned_to_id_val>0){
				$this->db->where("assigned_to=$assigned_to_id_val ");
			} 
		}
		
		if(strlen($from_date_val)>0 && strlen($to_date_val)>0 ){
			$this->db->where("due_date>='$from_date_val' AND due_date<='$to_date_val'"); 
		}
		
		if($status_val >='0'){ 
			$this->db->where("status='$status_val'"); 
		} 
 
		$this->db->order_by("created_on", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	function get_all_tasks_to_do($params = array()){
		
		$vs_user_type_id = $this->login_vs_role_id = $vs_user_type_id= $this->session->userdata('us_role_id'); 
		$temp_agents_ids = '';
		if($vs_user_type_id==2){  
			$vs_id = $this->session->userdata('us_id');
			$agnt_arrs = $this->get_all_managers_agents_list($vs_id); 
			
			if(isset($agnt_arrs) && count($agnt_arrs)>0){   
				foreach($agnt_arrs as $agnt_arr){
					$temp_agents_ids .= $agnt_arr->id.",";
				}
				$temp_agents_ids = trim($temp_agents_ids,","); 
			}	 
		} 
		
		$whrs =''; 
		$assigned_to_id_val='';
		if(array_key_exists("assigned_to_val",$params)){
			$assigned_to_id_val = $params['assigned_to_val']; 
			/*if($assigned_to_val>0){
				$whrs .=" AND assigned_to=$assigned_to_val";
			}*/
		} 
		
		if($vs_user_type_id==3){
			$vs_id = $this->session->userdata('us_id'); 
			$whrs .=" AND assigned_to=$vs_id "; 
		}else if($vs_user_type_id==2){
		 	if($assigned_to_id_val>0){  
				$whrs .=" AND assigned_to=$assigned_to_id_val ";
			}else if($temp_agents_ids!=''){
				$vs_id = $this->session->userdata('us_id');
				$whrs .=" AND ( assigned_to=$vs_id OR assigned_to IN ($temp_agents_ids) )";
			}
		}else if($vs_user_type_id==1){
		 	if($assigned_to_id_val>0){ 
				$whrs .=" AND assigned_to=$assigned_to_id_val";
			} 
		} 
		
		
		if(array_key_exists("q_val",$params)){
			$q_val = $params['q_val']; 
			if(strlen($q_val) >0){
				$whrs .=" AND ( title LIKE '%$q_val%' OR property_ref LIKE '%$q_val%' OR lead_ref LIKE '%$q_val%' OR instructions LIKE '%$q_val%' ) ";
			}
		} 
		
		
		if(array_key_exists("status_val",$params)){
			$status_val = $params['status_val']; 
			if($status_val>0){
				$whrs .=" AND status='$status_val' ";
			}
		}  
		
		$sel_from_date_val = $sel_to_date_val = '';
		
		if(array_key_exists("from_date_val",$params)){
			$from_date_val = $params['from_date_val']; 
			if(strlen($from_date_val)>0){
				$sel_from_date_val = $from_date_val;
			}
		}
		
		if(array_key_exists("to_date_val",$params)){
			$to_date_val = $params['to_date_val'];  
			if(strlen($to_date_val)>0){
				$sel_to_date_val = $to_date_val;
			}
		}
		
		if((isset($sel_from_date_val) && strlen($sel_from_date_val)>0) && (isset($sel_to_date_val) && strlen($sel_to_date_val)>0)){   
			$whrs .=" AND ( DATE_FORMAT(due_date,'%Y-%m-%d')>='$sel_from_date_val' AND DATE_FORMAT(due_date,'%Y-%m-%d')<='$sel_to_date_val' ) ";
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
		
		$query = $this->db->query("SELECT * FROM tasks_to_do_tbl WHERE id >'0' $whrs ORDER BY created_on DESC $limits "); 
		return $query->result(); 
	}  
	
	function get_tasks_to_do_by_id($args1){
		$this->dbs_role_id = $this->session->userdata('us_role_id'); 
		if($this->dbs_role_id==3){
			$vs_id = $this->session->userdata('us_id');
			$query = $this->db->get_where('tasks_to_do_tbl',array('id'=> $args1,'assigned_to'=> $vs_id));
		}else{
			$query = $this->db->get_where('tasks_to_do_tbl',array('id'=> $args1));
		}
			
		return $query->row();
	} 
	 
	function insert_tasks_to_do_data($data){ 
		return $this->db->insert('tasks_to_do_tbl', $data);
	}  
	
	function update_tasks_to_do_data($args1,$data){
		if($args1 >0){
			$this->db->where('id',$args1);
			
			if($this->login_vs_role_id==3){
				$vs_id = $this->session->userdata('us_id');
				$this->db->where('assigned_to',$vs_id); 
			} 
			
			return $this->db->update('tasks_to_do_tbl', $data);
		}  
	}
	
	function get_all_managers_agents_list($mngrs_ids){ 
	   $query = $this->db->get_where('users_tbl',array('parent_id'=> $mngrs_ids));
	   return $query->result();
	} 
	
	
	function operate_over_due_tasks(){ 
		 $curr_date = date('Y-m-d');
		 $updated_on = date('Y-m-d H:i:s');
		 
		 $this->db->query("update tasks_to_do_tbl set status='4',updated_on='$updated_on' where due_date < '$curr_date' AND ( status='0' OR status='2' ) AND percentage_of_completion < '80' ",false);
	}
	
	function trash_task($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('tasks_to_do_tbl');
		} 
		return true;
	}
	
}  ?>