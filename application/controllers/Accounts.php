<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accounts extends CI_Controller{

    public function __construct(){
        parent::__construct();
		
		
		$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
		$this->login_vs_role_id = $this->dbs_role_id = $vs_role_id = $this->session->userdata('us_role_id');
		$this->load->model('general_model');
		if(isset($vs_id) && (isset($vs_role_id) && $vs_role_id>=1)){
			/* ok */ 
			$res_nums = $this->general_model->check_controller_permission_access('Accounts',$vs_role_id,'1');
			if($res_nums>0){
				/* ok */
			}else{
				redirect('/');
			} 
		}else{
			redirect('/');
		}
		
		$this->load->helper(array('form','url','security','utility','html'));
        $this->load->library(array('form_validation','user_agent'));
		$this->load->model('users_model'); 
		$this->load->model('admin_model'); 
		$perms_arrs = array('role_id'=> $vs_role_id);
		
		$this->load->library('Ajax_pagination');
		$this->perPage = 25;
    }  
	
	function index(){
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','view_method_name','users_list',$this->login_vs_role_id,'1');  
		if($res_nums>0){ 
		
			$data['records'] = $this->admin_model->get_all_users_with_roles();
			$data['page_headings']="Users List";
			$this->load->view('accounts/index',$data); 
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	}
	
	function users_list(){
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','view_method_name','users_list',$this->login_vs_role_id,'1'); 
		
		if($res_nums>0){ 
			$data['page_headings']="Users List";
			$data['records'] = $this->admin_model->get_all_users_with_roles(); 
			$this->load->view('accounts/users_list',$data);   
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	} 
	
	function trash_user($args2=''){    
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_user',$this->login_vs_role_id,'1');  
		if($res_nums>0){ 
		
			$data['page_headings']="Users List";
			$this->admin_model->trash_user($args2);
			redirect('accounts/users_list');    
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	} 
	
	
	 function trash_user_aj(){   
		 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_user',$this->login_vs_role_id,'1'); 
		if($res_nums>0){  
		
			if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1"); 
				$this->admin_model->trash_user($args1); 
			 }  
			 
			 $data['records'] = $this->admin_model->get_all_users_with_roles();
			 $this->load->view('accounts/users_list_aj',$data);   
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	 }  
	 
	 function trash_multiple_users(){  
	    
		 $res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_user',$this->login_vs_role_id,'1'); 
		
		if($res_nums>0){  
		
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){    
					$this->admin_model->trash_user($args2);   
				}  
			}  
			 
			 $data['records'] = $this->admin_model->get_all_users_with_roles();
			 $this->load->view('accounts/users_list_aj',$data);  
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		}   
	 } 

	 
	function operate_user($args1=''){ 
		 $res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','add_method_name','operate_user',$this->login_vs_role_id,'1'); 
		
		if($res_nums>0){ 
		
	
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_headings'] = 'Update User';
			$update_record_arr = $data['record'] = $this->users_model->get_user_by_id($args1);
		}else{
			$data['page_headings'] = 'Add User';
		}  
		$arrs_field = array('role_id' => '2');
		$data['manager_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
		$data['role_arrs'] = $this->admin_model->get_all_roles();
		
		if(isset($_POST) && !empty($_POST)){ 
			// get form input
			$name = $this->input->post("name");
			$role_id = $this->input->post("role_id"); 
			$email = $this->input->post("email");
			$password = $this->input->post("password"); 
			$phone_no = $this->input->post("phone_no");  
			$mobile_no = $this->input->post("mobile_no");  
			$company_name = $this->input->post("company_name"); 
			$rera_no = $this->input->post("rera_no"); 
			$address = $this->input->post("address"); 
			$status = $this->input->post("status");  
			 
			$parent_id = (isset($_POST['parent_id'])) ? $this->input->post("parent_id") : '';
			 
			$prf_img_error = ''; 		
			$alw_typs = array('image/jpg','image/jpeg','image/png','image/gif');
			$imagename = (isset($_POST['old_image']) && $_POST['old_image']!='') ? $_POST['old_image']:''; 
			if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!=''){ 
				if(!(in_array($_FILES['image']['type'],$alw_typs))) {
					$tmp_img_type = "'".($_FILES['image']['type'])."'";
					$prf_img_error .= "Profile image type: $tmp_img_type not allowed!<br>";
				}
				
				if($prf_img_error==''){
					
					@unlink("downloads/profile_pictures/thumbs/$imagename");
					$imagename = $this->general_model->fileExists($_FILES['image']['name'],"downloads/profile_pictures/thumbs/");
					
					$extension = $this->general_model->get_custom_file_extension($imagename);
					$extension = strtolower($extension);
					$uploadedfile = $_FILES['image']['tmp_name']; 
					$file_to_upload = "downloads/profile_pictures/thumbs/";   
					$this->general_model->genernate_thumbnails($imagename,$extension,$uploadedfile,$file_to_upload,200,200);
				}
			} 
			
			$is_unique_name = '|is_unique[users_tbl.name]';
			if(isset($update_record_arr)){ 
				if($update_record_arr->name == $name) {
					$is_unique_name = '';
				} 
			}  
			
			$is_unique_email = '|is_unique[users_tbl.email]';
			if(isset($update_record_arr)){ 
				if($update_record_arr->email == $email) {
					$is_unique_email = '';
				} 
			} 
			
			$is_unique_mobile_no = '|is_unique[users_tbl.mobile_no]';
			if(isset($update_record_arr)){ 
				if($update_record_arr->mobile_no == $mobile_no) {
					$is_unique_mobile_no = '';
				} 
			} 
			
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean{$is_unique_name}");
			$this->form_validation->set_rules("role_id", "Role Name", "trim|required|xss_clean");
			$this->form_validation->set_rules("email", "Email-ID", "trim|required|xss_clean|valid_email{$is_unique_email}");
			$this->form_validation->set_rules("password", "Password", "trim|required|xss_clean");
			$this->form_validation->set_rules("phone_no", "Phone No","trim|required|xss_clean");
			$this->form_validation->set_rules("mobile_no", "Mobile No","trim|required|xss_clean{$is_unique_mobile_no}"); 
			$this->form_validation->set_rules("address", "Address", "trim|required|xss_clean"); 
			$this->form_validation->set_rules("status", "Account Status", "trim|required|xss_clean");
			 
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('accounts/operate_user',$data);
			}else if(strlen($prf_img_error)>0){ 
			 
				$this->session->set_flashdata('prof_img_error',$prf_img_error);
				$this->load->view('accounts/operate_user',$data);
				
			}else if(isset($args1) && $args1!=''){
				/*$password = md5($password);*/
				$password = $this->general_model->encrypt_data($password);
				$datas = array('name' => $name,'role_id' => $role_id,'email' => $email,'password' => $password,'mobile_no' => $mobile_no,'phone_no' => $phone_no,'company_name' => $company_name,'address' => $address,'status' => $status,'image' => $imagename,'parent_id' => $parent_id,'rera_no' => $rera_no); 
				$res = $this->users_model->update_user_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("accounts/users_list");
			}else{
				$created_on = date('Y-m-d H:i:s');
				/*$password = md5($password);*/
				$password = $this->general_model->encrypt_data($password);
				$datas = array('name' => $name,'role_id' => $role_id,'email' => $email,'password' => $password,'mobile_no' => $mobile_no,'phone_no' => $phone_no,'company_name' => $company_name,'address' => $address,'created_on' => $created_on,'status' => $status,'image' => $imagename,'parent_id' => $parent_id,'rera_no' => $rera_no); 
				$res = $this->users_model->insert_user_data($datas); 
				 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				}  
				
				if(isset($_POST['saves_and_new'])){
					redirect("accounts/operate_user");
				}else{
					redirect("accounts/users_list");	
				} 
			} 	 
			
		}else{
			$this->load->view('accounts/operate_user',$data);
		}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}   
	}   
	
	
	 
	function roles_list(){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','view_method_name','roles_list',$this->login_vs_role_id,'1'); 
		if($res_nums>0){ 
		
			$data['page_headings']= "Roles List";
			$data['records'] = $this->admin_model->get_all_roles();
			$this->load->view('accounts/roles_list',$data);  
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}
	
	
	function trash_role($args2=''){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_role',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
				
			$data['page_headings']="Roles List";
			if($args2 >1){
				$this->admin_model->trash_role($args2);
			}
			redirect('accounts/roles_list'); 
			
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }
	 
	 
	 function trash_role_aj(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_role',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
			
			 if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1"); 
				$this->admin_model->trash_role($args1); 
			 }  
			 
			 $data['records'] = $this->admin_model->get_all_roles();
			 $this->load->view('accounts/roles_list_aj',$data); 
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }  
	 
	 function trash_multiple_roles(){  
	  	$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_role',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
			
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){    
					$this->admin_model->trash_role($args2);  
				}  
			}  
			 
			$data['records'] = $this->admin_model->get_all_roles();
			$this->load->view('accounts/roles_list_aj',$data);
		 
		 }else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }   
	 
	 
	 function operate_role($args1=''){  
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','add_method_name','operate_role',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
			
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_headings'] = 'Update Role';
			$data['record'] = $this->admin_model->get_role_by_id($args1);
		}else{
			$data['page_headings'] = 'Add Role';
		}  
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$name = $this->input->post("name"); 
			// form validation
			$this->form_validation->set_rules("name", "Role Name", "trim|required|xss_clean");  
			
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('accounts/operate_role',$data);
			}else if(isset($args1) && $args1!=''){ 
				$datas = array('name' => $name); 
				$res = $this->admin_model->update_role_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("accounts/roles_list");
			}else{ 
				$datas = array('name' => $name); 
				$res = $this->admin_model->insert_role_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				 
				if(isset($_POST['saves_and_new'])){
					redirect("accounts/operate_role");
				}else{
					redirect("accounts/roles_list");	
				}
			} 	 
			
		}else{
			$this->load->view('accounts/operate_role',$data);
		} 
	 }else{ 
		$this->load->view('no_permission_access'); 
	} 
}
	
	
	/* modules module starts */
	function modules_list(){ 
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','view_method_name','modules_list',$this->login_vs_role_id,'1'); 
		if($res_nums>0){  
		
			$data['page_headings']= "Modules List";
			$data['records'] = $this->admin_model->get_all_modules();
			$this->load->view('accounts/modules_list',$data);
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}    
	}
	
	function trash_module($args2=''){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_module',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
			 
			$data['page_headings']="Modules List";
			if($args2 >1){
				$this->admin_model->trash_module($args2);
			}
			redirect('accounts/modules_list'); 
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}
	 }
	 
	 
	 function trash_module_aj(){ 
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_module',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
			 
			if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1"); 
				$this->admin_model->trash_module($args1); 
			}  
			 
			$data['records'] = $this->admin_model->get_all_modules();
			$this->load->view('accounts/modules_list_aj',$data);
		 
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
		
	 }  
	 
	 function trash_multiple_modules(){  
	 
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_module',$this->login_vs_role_id,'1'); 
		if($res_nums>0){  
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){    
					$this->admin_model->trash_module($args2);  
				}  
			}  
			 
			 $data['records'] = $this->admin_model->get_all_modules();
			 $this->load->view('accounts/modules_list_aj',$data);
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
		
	 }   
	 
	 
	 function operate_module($args1=''){  
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','add_method_name','operate_module',$this->login_vs_role_id,'1'); 
		if($res_nums>0){ 
	 	
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_headings'] = 'Update Module';
			$data['record'] = $this->admin_model->get_module_by_id($args1);
		}else{
			$data['page_headings'] = 'Add Module';
		}  
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$name = $this->input->post("name"); 
			$parent_id = $this->input->post("parent_id"); 
			$sort_order = $this->input->post("sort_order"); 
			$url_address = $this->input->post("url_address"); 
			$icon_name = $this->input->post("icon_name");
			
			$controller_name = $this->input->post("controller_name"); 
			$add_method_name = $this->input->post("add_method_name"); 
			$update_method_name = $this->input->post("update_method_name"); 
			$delete_method_name = $this->input->post("delete_method_name");
			$view_method_name = $this->input->post("view_method_name");
			 
			// form validation
			$this->form_validation->set_rules("name","Module Name","trim|required|xss_clean");  
			$this->form_validation->set_rules("parent_id","Parent Module","trim|required|xss_clean");
			$this->form_validation->set_rules("sort_order","Sort Order","trim|required|xss_clean"); 
			$this->form_validation->set_rules("controller_name","Controller Name","trim|required|xss_clean");
			
			if($this->form_validation->run() == FALSE){
				// validation fail
				$this->load->view('accounts/operate_module',$data);
			}else if(isset($args1) && $args1!=''){
				$datas = array('parent_id' => $parent_id,'name' => $name,'sort_order' => $sort_order,'url_address' => $url_address,'icon_name' => $icon_name,'controller_name' => $controller_name,'add_method_name' => $add_method_name,'update_method_name' => $update_method_name,'delete_method_name' => $delete_method_name,'view_method_name' => $view_method_name); 
				$res = $this->admin_model->update_module_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				} 
				
				redirect("accounts/modules_list");
			}else{ 
				 
				$vs_id = $this->session->userdata('us_id');
				$created_on = date('Y-m-d H:i:s'); 
			
				$datas = array('parent_id' => $parent_id,'name' => $name,'sort_order' => $sort_order,'url_address' => $url_address,'icon_name' => $icon_name,'controller_name' => $controller_name,'add_method_name' => $add_method_name,'update_method_name' => $update_method_name,'delete_method_name' => $delete_method_name,'view_method_name' => $view_method_name,'added_by' => $vs_id,'created_on' => $created_on); 
				$res = $this->admin_model->insert_module_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				 
				if(isset($_POST['saves_and_new'])){
					redirect("accounts/operate_module");
				}else{
					redirect("accounts/modules_list");	
				}
			} 	 
			
		}else{
			$this->load->view('accounts/operate_module',$data);
		}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	}
	
	/* modules module end */
	
	
	
	/* Permission module starts */
	function permissions_list(){
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','view_method_name','permissions_list',$this->login_vs_role_id,'1'); 
		if($res_nums>0){ 
	 
		$sel_module_id = $sel_user_type_id =''; 
		$paras_arrs = array();	
		
		
		if($this->input->post('sel_per_page_val')){
			$per_page_val = $this->input->post('sel_per_page_val'); 
			$_SESSION['tmp_per_page_val'] = $per_page_val;  
			
		}else if(isset($_SESSION['tmp_per_page_val'])){
				unset($_SESSION['tmp_per_page_val']);
			} 
		
		if($this->input->post('module_id')){
			$sel_module_id = $this->input->post('module_id'); 
			$_SESSION['tmp_module_id_val'] = $sel_module_id;
			$paras_arrs = array_merge($paras_arrs, array("module_id_val" => $sel_module_id));
			
		}else if(isset($_SESSION['tmp_module_id_val'])){
				unset($_SESSION['tmp_module_id_val']);
			} 
			
		if($this->input->post('user_type_id')){
			$sel_user_type_id = $this->input->post('user_type_id'); 
			$_SESSION['tmp_user_type_val'] = $sel_user_type_id;  
			
			$paras_arrs = array_merge($paras_arrs, array("user_type_id_val" => $sel_user_type_id));
			
		}else if(isset($_SESSION['tmp_user_type_val'])){
				unset($_SESSION['tmp_user_type_val']);
			}  
		
		
		if(isset($_SESSION['tmp_per_page_val'])){
			$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
		}else{
			$show_pers_pg = $this->perPage;
		}
		 
		//total rows count
		$totalRec = count($this->admin_model->get_all_permission_with_user_modules_roles($paras_arrs));
		
		//pagination configuration
		$config['target']      = '#fetch_dya_list';
		$config['base_url']    = site_url('/accounts/permissions_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
		
	    $records = $data['records'] = $this->admin_model->get_all_permission_with_user_modules_roles($paras_arrs);
		 
		$data['page_headings']="Permissions List";
		$this->load->view('accounts/permissions_list',$data); 
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}


	function permissions_list2(){
	 
		$data['role_arrs'] = $this->admin_model->get_all_roles();
		$sel_module_id = $sel_user_type_id ='';

		$paras_arrs = array();	
		$page = $this->input->post('page');
		if(!$page){
			$offset = 0;
		}else{
			$offset = $page;
		} 
		
		$data['page'] = $page; 
		
			
		if($this->input->post('sel_per_page_val')){
			$per_page_val = $this->input->post('sel_per_page_val'); 
			$_SESSION['tmp_per_page_val'] = $per_page_val;  
			
		}else if(isset($_SESSION['tmp_per_page_val'])){
				$per_page_val = $_SESSION['tmp_per_page_val'];
			} 	 
			
			
	if(isset($_POST['module_id'])){
		$sel_module_id = $this->input->post('module_id');  
		if($sel_module_id >0){
			$_SESSION['tmp_module_id_val'] = $sel_module_id;
			$paras_arrs = array_merge($paras_arrs, array("module_id_val" => $sel_module_id)); 
		}else{
			unset($_SESSION['tmp_module_id_val']);
		}
		
	}else if(isset($_SESSION['tmp_module_id_val'])){  ///
		$sel_module_id = $_SESSION['tmp_module_id_val']; 
		$paras_arrs = array_merge($paras_arrs, array("module_id_val" => $sel_module_id));
	} 
	
		 
	if(isset($_POST['user_type_id'])){
		$sel_user_type_id = $this->input->post('user_type_id');  
		if($sel_user_type_id >0){
			$_SESSION['tmp_user_type_val'] = $sel_user_type_id;  
			
			$paras_arrs = array_merge($paras_arrs, array("user_type_id_val" => $sel_user_type_id));
		}else{
			unset($_SESSION['tmp_user_type_val']);
		}
		
	}else if(isset($_SESSION['tmp_user_type_val'])){  ///
		$sel_user_type_id = $_SESSION['tmp_user_type_val']; 
		$paras_arrs = array_merge($paras_arrs, array("user_type_id_val" => $sel_user_type_id));
	} 
		
		
		if(isset($_SESSION['tmp_per_page_val'])){
			$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
		}else{
			$show_pers_pg = $this->perPage;
		}
		 
		//total rows count
		$totalRec = count($this->admin_model->get_all_permission_with_user_modules_roles($paras_arrs)); 
		
		//pagination configuration
		$config['target']      = '#fetch_dya_list';
		$config['base_url']    = site_url('/accounts/permissions_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
		
	   $data['records'] = $this->admin_model->get_all_permission_with_user_modules_roles($paras_arrs);
		
	 	//$data['records'] = $this->admin_model->get_all_permission_with_user_types($sel_module_id,$sel_user_type_id);
		
		$data['page_headings']="Permissions List";
		$this->load->view('accounts/permissions_list2',$data); 
	
}
	 
	function trash_permission($args2=''){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_permission',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
			
			$data['page_headings']="Permissions List";
			if($args2 >1){
				$this->admin_model->trash_permission($args2);
			}
			redirect('admin/permissions_list');  
			
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}
	
	 function trash_permission_aj(){  
		 $res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','delete_method_name','trash_permission',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
		
			 if(isset($_POST["args1"]) && $_POST["args1"]>1){
				$args1 = $this->input->post("args1"); 
				$this->admin_model->trash_permission($args1);
			 }  
			 
			 $this->permissions_list2();
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	 } 
	 
	function operate_permission($args1=''){ 
	
		$res_nums =  $this->general_model->check_controller_method_permission_access('Accounts','add_method_name','operate_permission',$this->login_vs_role_id,'1'); 
		if($res_nums>0){
			 
		$perid =0;
		if(isset($args1) && $args1!=''){ 
			$perid = $args1;
			$data['args1'] = $args1;//
			$data['page_headings'] = 'Update Permission';  
			$data['record'] = $this->admin_model->get_permission_by_id_with_chk($args1);
		}else{
			$data['page_headings'] = 'Add Permission';
		}  
		$data['role_arrs'] = $this->admin_model->get_all_roles();
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$module_id = $this->input->post("module_id"); 
			$role_id = $this->input->post("role_id"); 
			 
			$is_add_permission = (isset($_POST['is_add_permission']) && $_POST['is_add_permission']==1) ? 1 : 0;
			$is_update_permission = (isset($_POST['is_update_permission']) && $_POST['is_update_permission']==1) ? 1 : 0;
			$is_delete_permission = (isset($_POST['is_delete_permission']) && $_POST['is_delete_permission']==1) ? 1 : 0;
			$is_view_permission = (isset($_POST['is_view_permission']) && $_POST['is_view_permission']==1) ? 1 : 0; 
			  
			// form validation
			$this->form_validation->set_rules("module_id","Module(s)","trim|required|xss_clean");  
			$this->form_validation->set_rules("role_id","Role Name","trim|required|xss_clean");
			  
			$rec_nums = $this->general_model->get_permission_by_module_role($perid,$module_id,$role_id);
			 
			if($this->form_validation->run() == FALSE){
				// validation fail
				$this->load->view('accounts/operate_permission',$data);
			}else if((isset($args1) && $args1!='') && (isset($rec_nums) && $rec_nums>0)){
				$this->session->set_flashdata('error_msg','Error: This moodule and role data are already added!');
				$this->load->view('accounts/operate_permission',$data);
				
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('role_id' => $role_id,'module_id' => $module_id,'is_add_permission' => $is_add_permission,'is_update_permission' => $is_update_permission,'is_delete_permission' => $is_delete_permission,'is_view_permission' => $is_view_permission); 
				$res = $this->admin_model->update_permission_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("accounts/permissions_list");
					
			}else if(isset($rec_nums) && $rec_nums>0){
				
				$this->session->set_flashdata('error_msg','Error: This moodule and role data are already added!');
				$this->load->view('accounts/operate_permission',$data);	
				 
			}else{
				 $vs_id = $this->session->userdata('us_id');
				 $created_on = date('Y-m-d H:i:s');
				   	  
				$datas = array('role_id' => $role_id,'module_id' => $module_id,'is_add_permission' => $is_add_permission,'is_update_permission' => $is_update_permission,'is_delete_permission' => $is_delete_permission,'is_view_permission' => $is_view_permission,'added_by' => $vs_id,'created_on' => $created_on); 
				$res = $this->admin_model->insert_permission_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				}  
				 
				if(isset($_POST['saves_and_new'])){
					redirect("accounts/operate_permission");
				}else{
					redirect("accounts/permissions_list");	
				}
				  
			} 	 
			
		}else{
			$this->load->view('accounts/operate_permission',$data);
		}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	
	}
	
	/* Permission module ends */
	
	
	
	
	
	
	
		
	}
	?>