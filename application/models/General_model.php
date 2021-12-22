<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class General_model extends CI_Model {

	 function __construct() {
		parent::__construct();  
	} 

	public function _create_thumbnail($fileName,$source_paths,$target_paths,$width,$height){
	
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_paths.$fileName;       
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $target_paths.$fileName;               
        $this->image_lib->initialize($config);
        if(!$this->image_lib->resize()){ 
            
			return $this->image_lib->display_errors();
        
		}else{
			return '1';
		}
    }   
	
	function get_permission_by_module_role($per_id,$mod_id,$rol_id){ 
		if($mod_id >0 && $rol_id >0){
			$whrs = " WHERE id >'0' ";
			if($per_id>0){
				$whrs = " WHERE id!='$per_id' ";
			}
			$whrs .= " AND module_id='$mod_id' AND role_id='$rol_id' "; 
			$query = $this->db->query(" SELECT count(*) AS NUMS FROM permissions_tbl $whrs "); 
			$row_nums = $query->row()->NUMS;
		 	return $row_nums;
		}else{
			return '0';	
		}
	} 
	
	public function check_controller_permission_access_old($contrlrs_name,$rol_id,$is_restrick){ 
		$whrs = '';
		if(strlen($contrlrs_name)>0 && $rol_id >0 && $is_restrick==1){ 
			$whrs = " WHERE controller_name='$contrlrs_name' AND role_id='$rol_id' "; 
		}
			
		$query = $this->db->query(" SELECT count(*) AS NUMS FROM permissions_tbl $whrs "); 
		$row_nums = $query->row()->NUMS;
		return $row_nums; 
	} 
	
	
	
	public function check_controller_permission_access($contrlrs_name,$rol_id,$is_restrick){ 
		$whrs = '';
		if(strlen($contrlrs_name)>0 && $rol_id >0 && $is_restrick==1){ 
			$whrs = " AND m.controller_name='$contrlrs_name' AND p.role_id='$rol_id' ";
		}
			 
		$query = $this->db->query("SELECT count(p.id) AS NUMS FROM permissions_tbl p, modules_tbl m WHERE p.module_id=m.id $whrs "); 
		$row_nums = $query->row()->NUMS;
		return $row_nums; 
	}  
	 
	public function check_controller_method_permission_access($contrlrs_name,$mthd_name,$rol_id,$is_restrick){ 
		$whrs = '';
		if(strlen($contrlrs_name)>0 && strlen($mthd_name)>0 && $rol_id >0 && $is_restrick==1){  
			$whrs = " AND m.controller_name='$contrlrs_name' AND p.role_id='$rol_id' ";
		
			if($mthd_name=='add'){
				$whrs .= " AND p.is_add_permission='1' ";	
			} 
			if($mthd_name=='update'){
				$whrs .= " AND p.is_update_permission='1' ";		
			}
			if($mthd_name=='view' || $mthd_name=='index'){
				$whrs .= " AND p.is_view_permission='1' ";		
			}
			if($mthd_name=='delete' || $mthd_name=='trash'){
				$whrs .= " AND p.is_delete_permission='1' ";		
			}  
		}
			 
		$query = $this->db->query("SELECT count(p.id) AS NUMS FROM permissions_tbl p, modules_tbl m WHERE p.module_id=m.id $whrs "); 
		$row_nums = $query->row()->NUMS;
		return $row_nums; 
	} 
	 
	public function check_controller_method_permission_access111($contrlrs_name,$mthd_field,$mthd_name,$rol_id,$is_restrick){ 
		$whrs = '';
		if(strlen($contrlrs_name)>0 && strlen($mthd_field)>0 && strlen($mthd_name)>0 && $rol_id >0 && $is_restrick==1){  
			$whrs = " AND m.controller_name='$contrlrs_name' AND p.role_id='$rol_id' ";
		
			if($mthd_field=='add_method_name'){
				$whrs .= " AND m.add_method_name='$mthd_name' AND p.is_add_permission='1' ";	
			} 
			if($mthd_field=='update_method_name'){
				$whrs .= " AND m.update_method_name='$mthd_name' AND p.is_update_permission='1' ";		
			}
			if($mthd_field=='view_method_name'){
				$whrs .= " AND m.view_method_name='$mthd_name' AND p.is_view_permission='1' ";		
			}
			if($mthd_field=='delete_method_name'){
				$whrs .= " AND m.delete_method_name='$mthd_name' AND p.is_delete_permission='1' ";		
			}  
		}
			 
		$query = $this->db->query("SELECT count(p.id) AS NUMS FROM permissions_tbl p, modules_tbl m WHERE p.module_id=m.id $whrs "); 
		$row_nums = $query->row()->NUMS;
		return $row_nums; 
	} 
	
	//file upoading function                 
	public function fileExists($file,$dir) {
			
			$i=1; 
			$probeer=$file;
			while(file_exists($dir.$probeer)) {
				$punt=strrpos($file,".");
				if(substr($file,($punt-3),1)!==("[") && substr($file,($punt-1),1)!==("]")) {
					$probeer=substr($file,0,$punt)."[".$i."]".
					substr($file,($punt),strlen($file)-$punt);
				   } else {
					   $probeer=substr($file,0,($punt-3))."[".$i."]".
					   substr($file,($punt),strlen($file)-$punt);
					  }
					$i++;
			  }
			  return $probeer;
		}// end of the file uploading function
		
		public function get_custom_file_extension($str){
			 $i = strrpos($str,".");
			 if (!$i) { return ""; } 
		
			 $l = strlen($str) - $i;
			 $ext = substr($str,$i+1,$l);
			 return $ext;
		 }
		 
		 public function genernate_thumbnails($filename,$extension,$uploadedfile,$file_to_upload,$newwidth,$newheightsss){

			if($extension=="jpg" || $extension=="jpeg" ){ 
				$src = imagecreatefromjpeg($uploadedfile);
			}else if($extension=="png"){ 
				$src = imagecreatefrompng($uploadedfile);
			}else{
				$src = imagecreatefromgif($uploadedfile);
			}
		
			list($width,$height) = getimagesize($uploadedfile);
			
			if($newwidth>$width){
				$newwidth = $width;
			}
			
			if($newwidth>$width){
				$newwidth = $width;
				$newheight = $height;
			}else{
				$newheight=($height/$width)*$newwidth;
			} 
			
			$tmp = imagecreatetruecolor($newwidth,$newheight);
		
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
			$filename = $file_to_upload.$filename;
		
			imagejpeg($tmp,$filename,100); 
		
			imagedestroy($src);
			imagedestroy($tmp);
		}
		
		public function get_user_info_by_id($args1){ 
			$query = $this->db->get_where('users_tbl',array('id'=> $args1));
			return $query->row();
		}
		
		  
		public function get_gen_all_users_list(){  
			$query = $this->db->get('users_tbl');
			return $query->result();
		}
		
		public function get_gen_all_owners_list(){  
			$query = $this->db->get('owners_tbl');
			return $query->result();
		} 
		
		public function get_user_role_info_by_id($args1){
			$this->db->select("u.*, r.name AS user_role_name");
			$this->db->from('users_tbl u, roles_tbl r');
			$this->db->where('u.role_id=r.id');
			$this->db->where("u.id=$args1"); 
			$query = $this->db->get();
			return $query->row();
		} 
		
		public function get_emirate_locations_info_by_id($args1){ 
			$query = $this->db->get_where('emirate_locations_tbl',array('emirate_id'=> $args1));
			return $query->result();
		} 
		
		
		public function get_emirate_sub_locations_info_by_id($args1){ 
			$query = $this->db->get_where('emirate_sub_locations_tbl',array('emirate_location_id'=> $args1));
			return $query->result();
		}
		
		public function get_emirate_sub_location_areas_info_by_id($args1){ 
			$query = $this->db->get_where('emirate_sub_location_areas_tbl',array('emirate_sub_location_id'=> $args1));
			return $query->result();
		} 
		
		/* encryption and decryption functions starts */
		public function encrypt_data_old($cstm_string){
			$output = false; 
			$key = 'E0B554B341FF5632DE241FBF4B1DBB37'; // initialization vector 
			$iv = md5(md5($key)); 
			
			$output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cstm_string, MCRYPT_MODE_CBC, $iv); 
			$output = base64_encode($output); 
			$output = rtrim($output, "");
			$output = trim($output, "");  
			return $output;
		}
		
		public function decrypt_data_old($cstm_string){
			$output = false; 
			$key = 'E0B554B341FF5632DE241FBF4B1DBB37'; // initialization vector
			$iv = md5(md5($key)); 
			
			$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cstm_string), MCRYPT_MODE_CBC, $iv); 
			$output = rtrim($output, "");
			$output = trim($output, "");  
			return $output;
		}
		/* encryption and decryption functions ends */
		
		
		/* encryption and decryption 2 functions starts */
		public function encrypt_data($str_txts) {
			$ret_data = base64_encode($str_txts);
			$ret_data = str_replace(array('+','/','='),array('-','_',''),$ret_data);
			return $ret_data;
		}
	
		public function decrypt_data($str_txts) {
			$ret_data = str_replace(array('-','_'),array('+','/'),$str_txts);
			$mod4 = strlen($ret_data) % 4;
			if ($mod4) {
				$ret_data .= substr('====', $mod4);
			}
			return base64_decode($ret_data);
		}
		/* encryption and decryption 2 functions ends */
		
		function get_gen_all_users_by_field($arrs_field){  
			$query = $this->db->get_where('users_tbl',$arrs_field);
			return $query->result();
		}
		 
		public function get_gen_module_name($args0){
			$ret_txt=''; 
			switch($args0){
				case 1:
					$ret_txt ="Properties List";
					break;
				case 2:
					$ret_txt ="Archived Properties";
					break;
				case 3:
					$ret_txt ="Contacts";
					break;
				case 4:
					$ret_txt ="Portals";
					break;
				case 5:
					$ret_txt ="Categories";
					break;
				case 6:
					$ret_txt ="Property Features";
					break;
				case 7:
					$ret_txt ="Source of Listings";
					break;  
				case 8:
					$ret_txt ="Neighbourhoods";
					break;
				case 9:
					$ret_txt ="Emirate";
					break;
				case 10:
					$ret_txt ="Emirate Locations";
					break;
				case 11:
					$ret_txt ="Emirate Sub Locations";
					break;
				case 12:
					$ret_txt ="Users";
					break;
				case 13:
					$ret_txt ="User Types";
					break;
				case 14:
					$ret_txt ="No. of Beds";
					break;
				case 15:
					$ret_txt ="Reports";
					break;	 
				case 16:
					$ret_txt ="Owners";
					break;
				case 17:
					$ret_txt ="Sales Listings";
					break;
				case 18:
					$ret_txt ="Rentals Listings";
					break;
				case 19:
					$ret_txt ="Deals Listings";
					break;
				case 20:
					$ret_txt ="Deleted Listings";
					break;
				case 21:
					$ret_txt ="Leads Listing";
					break;
						
				default:
				   $ret_txt ='---';
			} 
			
			return $ret_txt;
		}
		 
		public function get_gen_permission_check($perms_arrs){ 
			$query = $this->db->get_where('permissions_tbl',$perms_arrs);
			return $query->result();
		}  
		
		/* module permissions check starts */		
		public function check_gen_module_permission($needle, $needle_field, $haystack) {
			if($haystack){ 
				foreach($haystack as $item){
					if(isset($item->$needle_field) && $item->$needle_field==$needle && ( $item->is_add_permission==1 || $item->is_update_permission==1 || $item->is_view_permission==1 || $item->is_delete_permission==1)){
						return true;
					}
				}
			}
			return false;
		}
		
		public function in_array_field($needle, $needle_field,$needle2, $needle_field2, $haystack) {
			if($haystack){ 
				foreach($haystack as $item){
					if(isset($item->$needle_field) && $item->$needle_field == $needle && $item->$needle_field2 == $needle2){
						return true;
					}
				}
			}
			return false;
		}
		
		public function in_array_section_field($needle, $needle_field, $needle_field2, $haystack) {
			if($haystack){ 
				foreach($haystack as $item){
					if(isset($item->$needle_field) && $item->$needle_field == $needle){
						return $item->$needle_field2;
					}
				}
			}
			return false;
		}
		
		/* module permissions check ends */ 
		
		
		public function get_configuration(){ 
			$query = $this->db->get_where('config_tbl',array('id'=> '1'));
			return $query->row();
		} 
		
		 
		public function get_gen_currency_symbol(){ 
			$query = $this->db->get_where('config_tbl',array('id'=> '1'));
			$sl_currency_id = $query->row()->currency_id;
			
			$query2 = $this->db->get_where('currencies_tbl', array('id' => $sl_currency_id));
			$row2 = $query2->row();		
			if($row2){
				return $row2->symbol;
			}else{
				return '';
			}
		}  
		
		public function get_gen_colors($paras1){
			$retrn_vals ='';
			switch($paras1){   
				case 1:
					$retrn_vals ='#003366';
					break;  
				case 2:
					$retrn_vals ='#ff7373';
					break; 
				case 3:
					$retrn_vals ='#008080';
					break; 
				case 4:
					$retrn_vals ='#40e0d0';
					break; 
				case 5:
					$retrn_vals ='#fa8072';
					break; 
				case 6:
					$retrn_vals ='#008000';
					break; 
				case 7:
					$retrn_vals ='#0099cc';
					break;  
				case 8:
					$retrn_vals ='#cc0000';
					break;  
				case 9:
					$retrn_vals ='#999999';
					break;  
				case 10:
					$retrn_vals ='#c39797';
					break; 
					  
				default:
					$retrn_vals ='#660066';
			} 
			return $retrn_vals;
	  
	  	}
		
		public function get_gen_property_status($args0){
			$ret_txt=''; 
			switch($args0){
				case 1:
					$ret_txt ="Sold";
					break;
				case 2:
					$ret_txt ="Rented";
					break;
				case 3:
					$ret_txt ="Available";
					break;
				case 4:
					$ret_txt ="Upcoming";
					break;
				case 5:
					$ret_txt ="Renewed";
					break;
				case 6:
					$ret_txt ="Pending";
					break; 
				default:
				   $ret_txt ='---';
			} 
			
			return $ret_txt;
		}
		
		
		function get_property_ms_unit($ms_unt_val){
			$retrn_vals ='';
			switch($ms_unt_val){   
				case 1:
					$retrn_vals ='SqFt';
					break;  
				case 2:
					$retrn_vals ='SqCm';
					break; 
				case 3:
					$retrn_vals ='SqM';
					break; 
				case 4:
					$retrn_vals ='SqMm';
					break; 
				case 5:
					$retrn_vals ='SqKm';
					break; 
				case 6:
					$retrn_vals ='SqYd';
					break; 
				case 7:
					$retrn_vals ='SqMi';
					break;   
				default:
					$retrn_vals ='';
			} 
			return $retrn_vals;
		}
		
		
		public function exportExcelData($exp_records){
			$headings = false;
			if(!empty($exp_records))
				foreach ($exp_records as $exp_row) {
					if (!$headings) {
						// display field/column names as a first row
						echo implode("\t", array_keys($exp_row)) . "\n";
						$headings = true;
					}
					echo implode("\t", ($exp_row)) . "\n";
				}
		} 
	
		function random_string($length){
			$str ='';
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";	
			$size = strlen( $chars );
			for( $i = 0; $i < $length; $i++ ) {
				$str .= $chars[ rand( 0, $size - 1 ) ];
			}
			return $str;
		}
		
		
		function get_gen_all_users_assigned(){  
			
			$vs_id = $this->session->userdata('us_id');
			$vs_user_role_id = $this->session->userdata('us_role_id');
			 
			$this->db->select("u.* ");
			$this->db->from('users_tbl u');
			if($vs_user_role_id==3){
				$wheress = " id=$vs_id ";
			}else if($vs_user_role_id==2){
				$wheress = " id=$vs_id OR ( role_id='3' AND parent_id=$vs_id ) "; 
			}else{
				$wheress = "id >0";
			}
			
			$this->db->where($wheress);  
			$query = $this->db->get();
			return $query->result(); 
		}
		
		
		function insert_categories_portal_abbrevations_data($data){ 
			return $this->db->insert('categories_portal_abbrevation_tbl', $data);
		}
		
		function get_category_portal_abbrevations_data($paras1,$paras2){
			if($paras1>'0' && $paras2>'0'){
				$this->db->where('category_id', $paras1);
				$this->db->where('portal_id', $paras2);
				$query = $this->db->get('categories_portal_abbrevation_tbl');
				return $query->row();
			} 
		} 
		
		function trash_categories_portal_abbrevations_data($paras1,$paras2){
			if($paras1>'0' && $paras2>'0'){
				$this->db->where('category_id', $paras1);
				$this->db->where('portal_id', $paras2);
				$this->db->delete('categories_portal_abbrevation_tbl');
			} 
			return true;
		} 
		
		function trash_category_portal_abbrevations_data($paras1){
			if($paras1>'0'){
				$this->db->where('category_id', $paras1);
				$this->db->delete('categories_portal_abbrevation_tbl');
			} 
			return true;
		}
		
		
		
		
		
		
		
		
		/* property source of listings function starts */
		function get_property_portal_feature_data($paras1,$paras2){
			
			if($paras1>'0' && $paras2>'0'){
				$this->db->where('property_id', $paras1);
				$this->db->where('portal_id', $paras2);
				$query = $this->db->get('properties_portal_features_tbl');
				return $query->row();
			} 
		}
		
		function get_all_property_portal_feature_data($paras1,$paras2){
			
			if($paras1>'0' && $paras2>'0'){
				$this->db->where('property_id', $paras1);
				$this->db->where('portal_id', $paras2);
				$query = $this->db->get('properties_portal_features_tbl');
				return $query->result();
			} 
		} 
			
		function insert_property_portal_feature_data($data){ 
			return $this->db->insert('properties_portal_features_tbl', $data);
		}
		
		function trash_property_portal_feature_data($paras1,$paras2){
			if($paras1>'0' && $paras2>'0'){
				$this->db->where('property_id', $paras1);
				$this->db->where('portal_id', $paras2);
				$this->db->delete('properties_portal_features_tbl');
			} 
			return true;
		}
		
		function trash_property_assigned_portal_feature_data($paras1){
			if($paras1 >0){
				$this->db->where('property_id', $paras1); 
				$this->db->delete('properties_portal_features_tbl');
			} 
			return true;
		} 
		 
		function insert_featured_portal_abbrevations_data($data){ 
			return $this->db->insert('featured_portal_abbrevation_tbl', $data);
		}
		
		function get_featured_portal_abbrevations_data($paras1,$paras2){
			if($paras1>'0' && $paras2>'0'){
				$this->db->where('featured_id', $paras1);
				$this->db->where('portal_id', $paras2);
				$query = $this->db->get('featured_portal_abbrevation_tbl');
				return $query->row();
			} 
		} 
		
		function trash_featured_portal_abbrevations_data($paras1,$paras2){
			if($paras1>'0' && $paras2>'0'){
				$this->db->where('featured_id', $paras1);
				$this->db->where('portal_id', $paras2);
				$this->db->delete('featured_portal_abbrevation_tbl');
			} 
			return true;
		} 
		
		function trash_feature_portal_abbrevation_data($paras1){
			if($paras1>'0'){
				$this->db->where('featured_id', $paras1);
				$this->db->delete('featured_portal_abbrevation_tbl');
			} 
			return true;
		} 
		
		/* property features function ends */ 
		 
		 function get_all_users_with_roles(){ 
			$this->db->select("u.*, r.name AS role_name");
			$this->db->from('users_tbl u, roles_tbl r');
			$this->db->where('u.role_id=r.id'); 
			$query = $this->db->get();
			return $query->result();
		}  
		
		function chk_entry_of_yesterday_meetings_and_views(){ 
			$vs_id = $this->session->userdata('us_id');  
			$curr_date = date("Y-m-d");
			$prev_date = strtotime(date("Y-m-d", strtotime($curr_date))." -1 day");
			$prev_date = date("Y-m-d",$prev_date);   
			
			$this->db->where(" user_id=$vs_id AND dated='$prev_date' "); 
			$num_rows = $this->db->count_all_results('meetings_views_tbl');
			return $num_rows;
		} 
		
		
		public function get_gen_all_contacts_list(){  
			$query = $this->db->get('contacts_tbl'); //siteusers_tbl
			return $query->result();
		}
		
		public function get_gen_all_cstm_contacts_list($params = array()){			
			$whrs ='';   
			if(array_key_exists("q_val",$params)){
				$q_val = $params['q_val'];  
				if(strlen($q_val)>0){
					$whrs .= " AND ( name LIKE '%$q_val%' OR email LIKE '%$q_val%' OR phone_no LIKE '%$q_val%' ) "; 
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
			//siteusers_tbl
			$query = $this->db->query("SELECT * FROM contacts_tbl WHERE id >'0' $whrs ORDER BY id DESC "); 
			return $query->result(); 
		} 	  
		
		public function get_gen_contact_info_by_id($args1){ 
			$query = $this->db->get_where('contacts_tbl',array('id'=> $args1)); //siteusers_tbl
			return $query->row();
		}
		
		public function get_gen_owner_info_by_id($args1){ 
			$query = $this->db->get_where('owners_tbl',array('id'=> $args1));
			return $query->row();
		}	
		
		public function get_gen_property_info_by_references($paras0){
			$this->db->select("ref_no");
			$this->db->from('properties_tbl'); 
			$this->db->where("ref_no LIKE '%$paras0%' "); 
			$query = $this->db->get();
			return $query->result();
		}
		 
		public function get_gen_property_info_by_ref($paras0){
			$this->db->select("*");
			$this->db->from('properties_tbl'); 
			$this->db->where("ref_no LIKE '%$paras0%' "); 
			$query = $this->db->get();
			return $query->row();
		}
		
		
		
		public function get_gen_property_locations_list($prop_id){  
			$ret_txt = '';
			$query = $this->db->query("SELECT lc.name FROM properties_locations_tbl pl, locations_tbl lc WHERE pl.property_id='".$prop_id."' AND pl.location_id=lc.id ORDER BY pl.id ASC"); 
			$recs = $query->result(); 
			if($recs){
				foreach($recs as $rec){
					$ret_txt .= $rec->name.', '; 
				}
				
				$ret_txt = rtrim($ret_txt, ', ');
			}
			
			return $ret_txt ;
		} 	 
						
	}  ?>