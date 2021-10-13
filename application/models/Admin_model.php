<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 
  
 	  
	/* roles function starts */    
	
	function trash_role($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('roles_tbl');
		} 
		return true;
	}
	
	function get_all_roles(){
	   $query = $this->db->get('roles_tbl');
	   return $query->result();
	} 
	
	function get_role_by_id($args1){ 
		$query = $this->db->get_where('roles_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	
	 
	function insert_role_data($data){ 
		return $this->db->insert('roles_tbl', $data);
	}  
	
	function update_role_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('roles_tbl', $data);
	}
	/* roles function ends */ 
	 
	
	/* modules function starts */ 
	
	function trash_module($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('modules_tbl');
		} 
		return true;
	}
	
	function get_all_parent_modules($parnt_mod_id){
		if($parnt_mod_id!=''){
			$this->db->order_by("sort_order", "asc");
			$this->db->where('parent_id',$parnt_mod_id); 
		    $query = $this->db->get('modules_tbl');
		    return $query->result();
		}
	} 
	
	function get_all_modules(){
	   $this->db->order_by("sort_order", "asc");
	   $query = $this->db->get('modules_tbl');
	   return $query->result();
	} 
	
	function get_module_by_id($args1){ 
		$query = $this->db->get_where('modules_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function insert_module_data($data){ 
		return $this->db->insert('modules_tbl', $data);
	}  
	
	function update_module_data($args1,$data){ 
		if($args1>0){
			$this->db->where('id',$args1);
			return $this->db->update('modules_tbl', $data);
		}
	}
	
	function get_max_modules_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('modules_tbl')->row();  
		return $rets->sort_order; 
	}
	
	/* modules function ends */ 
	 
	
	/*permission function starts*/ 
	
	function get_all_permission_with_user_modules_roles($params = array()){
		$whrs =''; 
		if(array_key_exists("module_id_val",$params)){
			$sel_module_id = $params['module_id_val']; 
			if($sel_module_id>0){
				$whrs .=" AND p.module_id=$sel_module_id";
			}
		}  
		
		if(array_key_exists("user_type_id_val",$params)){
			$user_type_id_val = $params['user_type_id_val']; 
			if($user_type_id_val>0){
				$whrs .=" AND p.role_id=$user_type_id_val ";
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
		
		$query = $this->db->query("SELECT p.*, m.name AS module_name, r.name AS role_name FROM permissions_tbl p LEFT JOIN modules_tbl m ON p.module_id=m.id LEFT JOIN roles_tbl r ON p.role_id=r.id WHERE p.id >'0' $whrs ORDER BY p.id ASC $limits "); 
		return $query->result(); 
	} 
	 
	
	function get_all_permission_with_user_roles($params = array()){
		$whrs =''; 
		if(array_key_exists("module_id_val",$params)){
			$sel_module_id = $params['module_id_val']; 
			if($sel_module_id>0){
				$whrs .=" AND p.module_id=$sel_module_id";
			}
		}  
		
		if(array_key_exists("user_type_id_val",$params)){
			$user_type_id_val = $params['user_type_id_val']; 
			if($user_type_id_val>0){
				$whrs .=" AND p.role_id=$user_type_id_val ";
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
		
		$query = $this->db->query("SELECT p.*, r.name AS role_name FROM permissions_tbl p LEFT JOIN roles_tbl r ON p.role_id=r.id WHERE p.id >'0' $whrs ORDER BY p.id ASC $limits "); 
		return $query->result(); 
	}  
	
	function trash_permission($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('permissions_tbl');
		} 
		return true;
	}
	
	function get_all_permissions(){
	   $query = $this->db->get('permissions_tbl');
	   return $query->result();
	} 
	
	function get_permission_by_id($args1){ 
		$query = $this->db->get_where('permissions_tbl',array('id'=> $args1));
		return $query->row();
	}
	
	function get_permission_by_id_with_chk($args1){ 
		if($args1 >0){
			$vs_id = $this->session->userdata('us_id'); 
			$query = $this->db->query("SELECT * FROM permissions_tbl WHERE id='$args1' AND added_by='$vs_id' "); 
			return $query->row();  
		} 
	} 
	
	 
	function insert_permission_data($data){ 
		return $this->db->insert('permissions_tbl', $data);
	}  
	
	function update_permission_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('permissions_tbl', $data);
	}
	
	/*permission functions ends*/
	
	
	
	/* categories function starts */
	
	function get_max_categories_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('categories_tbl')->row();  
		return $rets->sort_order; 
	}
	
	function get_all_categories(){
		$this->db->order_by("sort_order", "asc");
	    $query = $this->db->get('categories_tbl');
	    return $query->result();
	} 
	
	function get_category_by_id($args1){ 
		$query = $this->db->get_where('categories_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_category_data($data){ 
		return $this->db->insert('categories_tbl', $data);
	}  
	
	function update_category_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('categories_tbl', $data);
	}

	function trash_category($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('categories_tbl');
		} 
		return true;
	}
	/* categories function ends */
	
	
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
	
	/* portals function ends */
	
	
	/* property source of listings function starts */
	function get_max_source_of_listings_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('source_of_listings_tbl')->row();  
		return $rets->sort_order; 
	} 
	 	
	function get_all_source_of_listings(){
		$this->db->order_by("sort_order", "asc");
	   	$query = $this->db->get('source_of_listings_tbl');
	   	return $query->result();
	} 
	
	function get_all_properties_source_of_listings(){
		$this->db->order_by("sort_order", "asc");
		$this->db->where('show_in_properties', '1');
	   	$query = $this->db->get('source_of_listings_tbl');
	   	return $query->result();
	} 
	
	function get_all_leads_source_of_listings(){
		$this->db->order_by("sort_order", "asc");
		$this->db->where('show_in_leads', '1');
	   	$query = $this->db->get('source_of_listings_tbl');
	   	return $query->result();
	} 
	
	function get_source_of_listing_by_id($args1){ 
		$query = $this->db->get_where('source_of_listings_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_source_of_listing_data($data){ 
		return $this->db->insert('source_of_listings_tbl', $data);
	}  
	
	function update_source_of_listing_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('source_of_listings_tbl', $data);
	}

	function trash_source_of_listing($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('source_of_listings_tbl');
		} 
		return true;
	}
	/* property source of listings function ends */
	 
	
	
	
	/* emirates function starts */
	function get_all_emirates(){
	   $this->db->order_by("name", "asc");
	   $query = $this->db->get('emirates_tbl');
	   return $query->result();
	} 
	
	function get_emirate_by_id($args1){ 
		$query = $this->db->get_where('emirates_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_emirate_data($data){ 
		return $this->db->insert('emirates_tbl', $data);
	}  
	
	function update_emirate_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('emirates_tbl', $data);
	}

	function trash_emirate($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('emirates_tbl');
		} 
		return true;
	}
	/* emirates function ends */ 
	
	/* emirate location function starts */
	function get_all_emirate_with_locations(){
		$this->db->order_by("l.name", "asc"); 
		$this->db->select("l.*, e.name AS emirate_name");
		$this->db->from('emirate_locations_tbl l, emirates_tbl e');
		$this->db->where('l.emirate_id=e.id'); 
		$query = $this->db->get();
	   	return $query->result();
	} 
	
	function get_all_emirate_locations(){
	   $query = $this->db->get('emirate_locations_tbl');
	   return $query->result();
	} 
	
	function get_emirate_location_by_id($args1){ 
		$query = $this->db->get_where('emirate_locations_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_emirate_location_data($data){ 
		return $this->db->insert('emirate_locations_tbl', $data);
	}  
	
	function update_emirate_location_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('emirate_locations_tbl', $data);
	}

	function trash_emirate_location($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('emirate_locations_tbl');
		} 
		return true;
	}
	
	function fetch_emirate_locations($args3){ 
		if(strlen($args3)>0){
			$this->db->order_by("name", "asc");
			$query = $this->db->get_where('emirate_locations_tbl',array('emirate_id'=> $args3));
			return $query->result();
		}else{
			return '';
		}
	}  
	
	function fetch_emirate_sub_locations($args3){ 
		if(strlen($args3)>0){
			$this->db->order_by("name", "asc");
			$query = $this->db->get_where('emirate_sub_locations_tbl',array('emirate_location_id'=> $args3));
			return $query->result();
		}else{
			return '';
		}
	} 
	
	function fetch_property_type_cates($args3){ 
		if(strlen($args3)>0){
			if($args3==1){
				$query = $this->db->get_where('categories_tbl',array('show_in_sale'=> '1'));
			}else if($args3==2){
				$query = $this->db->get_where('categories_tbl',array('show_in_rent'=> '1'));
			}else{
				$query = $this->db->get('categories_tbl');
			}
			
			return $query->result();
		}else{
			return '';
		}
	} 
	/* emirate locations function ends */
	
	/* emirate sub location function starts */ 
	
	function get_all_emirate_with_sub_locations(){
		$this->db->order_by("s.name", "asc"); 
		$this->db->select("s.*, l.name AS location_name, e.name AS emirate_name");
		$this->db->from('emirate_sub_locations_tbl s, emirate_locations_tbl l, emirates_tbl e');
		$this->db->where('s.emirate_location_id=l.id'); 
		$this->db->where('l.emirate_id=e.id'); 
		$query = $this->db->get();
	   	return $query->result();
	} 
	
	function get_all_emirate_sub_locations(){
	   $query = $this->db->get('emirate_sub_locations_tbl');
	   return $query->result();
	} 
	
	function get_emirate_sub_location_by_id($args1){ 
		$query = $this->db->get_where('emirate_sub_locations_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_emirate_sub_location_data($data){ 
		return $this->db->insert('emirate_sub_locations_tbl', $data);
	}
	
	function update_emirate_sub_location_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('emirate_sub_locations_tbl', $data);
	}

	function trash_emirate_sub_location($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('emirate_sub_locations_tbl');
		} 
		return true;
	}
	/* emirate sub locations function ends */
	
	
	
	/* property features function starts */
	function get_max_property_features_sort_val(){
		$this->db->select_max("sort_order");
		$rets = $this->db->get('property_features_tbl')->row();  
		return $rets->sort_order; 
	} 
	 
	function get_all_property_features(){
	   $this->db->order_by("sort_order", "asc");
	   $query = $this->db->get('property_features_tbl');
	   return $query->result();
	} 
	
	function get_portal_property_features($paras1){
		$this->db->order_by("sort_order", "asc");
		$this->db->where(" status='1' ");
		if(strlen($paras1)>0){
			$this->db->where(" FIND_IN_SET($paras1, portal_ids)  ");
		}
		$query = $this->db->get('property_features_tbl');
		return $query->result();
	}
	
	function get_all_property_features_in_id($paras1){
		if(strlen($paras1)>0){
			$this->db->where(" id IN ($paras1) ");
		}
		$query = $this->db->get('property_features_tbl');
		return $query->result();
	} 
	
	function get_property_feature_by_id($args1){ 
		$query = $this->db->get_where('property_features_tbl',array('id'=> $args1));
		return $query->row();
	}
	 
	function insert_property_feature_data($data){ 
		return $this->db->insert('property_features_tbl', $data);
	}  
	
	function update_property_feature_data($args1,$data){ 
		$this->db->where('id',$args1);
		return $this->db->update('property_features_tbl', $data);
	}

	function trash_property_feature($args2){
		if($args2 >0){
			$this->db->where('id', $args2);
			$this->db->delete('property_features_tbl');
		} 
		return true;
	}
	/* property features function ends */
	
}  ?>