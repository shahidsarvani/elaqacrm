<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller{
	public function __construct(){
        parent::__construct(); 
		
		$this->vs_user_id = $this->session->userdata('us_id');
		$this->vs_user_role_id = $this->session->userdata('us_role_id');
		$this->load->model('general_model');
		if(isset($this->vs_user_id) && (isset($this->vs_user_role_id) && $this->vs_user_role_id >=1)){
			/* ok */
			$res_nums = $this->general_model->check_controller_permission_access('Dashboard',$this->vs_user_role_id,'1');
			if($res_nums>0){
				/* ok */
			}else{
				redirect('/');
			}
			
		}else{
			redirect('/');
		} 
		
		$this->load->model('dashboard_model');
        $this->load->model('admin_model'); 
		$this->agent_chk_ystrdy_meeting = $this->general_model->chk_entry_of_yesterday_meetings_and_views();
		$this->load->library('Ajax_pagination');
		$this->perPage = 25;
    }   
	
	function index(){ 
		$datas = array();
		$curr_date = date("Y-m-d");
		$prev_date = strtotime(date("Y-m-d", strtotime($curr_date))." -1 day");
		$prev_date = date("Y-m-d",$prev_date); 
		$datas['prev_date']= $prev_date;
		$datas['page_headings'] = "Dashboard";
		$datas['conf_currency_symbol'] = $this->general_model->get_gen_currency_symbol();  
		 
		/*if($this->vs_user_role_id==2){
		
		}else if($this->vs_user_role_id==3){ 
		
		}*/ 
		
		//total rows count
		$totalRec = count($this->dashboard_model->get_all_recent_properties_list());
		//pagination configuration
		$config['target']      = '#properties_list';
		$config['base_url']    = site_url('/dashboard/index2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		
		$this->ajax_pagination->initialize($config); 		
		  
		$datas['results'] = $this->dashboard_model->get_all_users_list(array('role_id' => '2')); 
		
		$datas['records'] = $this->dashboard_model->get_all_recent_properties_list(array('limit'=>$this->perPage)); 
		
		$datas['nos_of_sale_properties'] = $this->dashboard_model->get_total_sale_properties_nums();
		$datas['nos_of_rent_properties']=$this->dashboard_model->get_total_rent_properties_nums();

		$datas['nos_of_active_properties'] = $this->dashboard_model->get_total_active_properties_nums();
		$datas['nos_of_archived_properties']=$this->dashboard_model->get_total_archived_properties_nums(); 
		 
		 $this->load->view('dashboard/index',$datas);
	}
	
	
	
	function index2(){
		if($this->vs_user_role_id==1){ 
			$datas = array();
			$page = $this->input->post('page');
			if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			} 
			
			$datas['page'] = $page;
			
			//total rows count
			$totalRec = count($this->admin_model->get_all_recent_properties_list());
			//pagination configuration
			$config['target']      = '#properties_list';
			$config['base_url']    = site_url('/dashboard/index2'); 
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			
			$this->ajax_pagination->initialize($config);
			
			$datas['records'] = $this->admin_model->get_all_recent_properties_list(array('start'=>$offset,'limit'=>$this->perPage)); 
			
			
			$this->load->view('dashboard/index2',$datas);
			
		 }else if($this->vs_user_role_id==2){
			redirect("manager/index");
		 }else if($this->vs_user_role_id==3){
			redirect("agent/index");
		 }
	}
	 
	function users_list(){ 
		if($this->vs_user_role_id==1){  
			$data['records'] = $this->admin_model->get_all_users_with_user_types();
			$data['page_heading']="Users List";
			$this->load->view('dashboard/users_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}
	 
	function trash_user($args2=''){ 
		if($this->vs_user_role_id==1){ 
			$data['page_heading']="Users List";
			$this->admin_model->trash_user($args2);
			redirect('dashboard/users_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}
	 
	 function operate_user($args1=''){ 
		if($this->vs_user_role_id==1){
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_heading'] = 'Update User';
				$update_record_arr = $data['record'] = $this->users_model->get_user_by_id($args1);
			}else{
				$data['page_heading'] = 'Add User';
			}  
			$arrs_field = array('user_type_id' => '2');
			$data['manager_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
			$data['role_arrs'] = $this->admin_model->get_all_user_types();
			
			if(isset($_POST) && !empty($_POST)){ 
				// get form input
				$name = $this->input->post("name");
				$user_type_id = $this->input->post("user_type_id"); 
				$email = $this->input->post("email");
				$password = $this->input->post("password"); 
				$mobile_no = $this->input->post("mobile_no"); 
				$address = $this->input->post("address"); 
				$status = $this->input->post("status");  
				$rera_no = $this->input->post("rera_no"); 
				
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
				$this->form_validation->set_rules("user_type_id", "User Type", "trim|required|xss_clean");
				$this->form_validation->set_rules("email", "Email-ID", "trim|required|xss_clean|valid_email{$is_unique_email}");
				$this->form_validation->set_rules("password", "Password", "trim|required|xss_clean");
				$this->form_validation->set_rules("mobile_no", "Mobile No","trim|required|xss_clean{$is_unique_mobile_no}");
				$this->form_validation->set_rules("address", "Address", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("status", "Account Status", "trim|required|xss_clean");
				
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('dashboard/operate_user',$data);
				}else if(strlen($prf_img_error)>0){ 
				 
					$this->session->set_flashdata('prof_img_error',$prf_img_error);
					$this->load->view('dashboard/operate_user',$data);
					
				}else if(isset($args1) && $args1!=''){
					/*$password = md5($password);*/
					$password = $this->general_model->encrypt_data($password);
					$datas = array('name' => $name,'user_type_id' => $user_type_id,'email' => $email,'password' => $password,'mobile_no' => $mobile_no,'address' => $address,'status' => $status,'image' => $imagename,'parent_id' => $parent_id,'rera_no' => $rera_no); 
					$res = $this->users_model->update_user_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("dashboard/users_list");
				}else{
					$created_on = date('Y-m-d H:i:s');
					/*$password = md5($password);*/
					$password = $this->general_model->encrypt_data($password);
					$datas = array('name' => $name,'user_type_id' => $user_type_id,'email' => $email,'password' => $password,'mobile_no' => $mobile_no,'address' => $address,'created_on' => $created_on,'status' => $status,'image' => $imagename,'parent_id' => $parent_id,'rera_no' => $rera_no); 
					$res = $this->users_model->insert_user_data($datas); 
					 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					redirect("dashboard/users_list");
				} 	 
				
			}else{
				$this->load->view('dashboard/operate_user',$data);
			}
			
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	} 
	
	
	function user_types_list(){
		if($this->vs_user_role_id==1){
			$data['records'] = $this->admin_model->get_all_user_types();
			$data['page_heading']="User Types List";
			$this->load->view('dashboard/user_types_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_user_type($args2=''){ 
		 if($this->vs_user_role_id==1){
			$data['page_heading']="User Types List";
			if($args2 >1){
				$this->admin_model->trash_user_type($args2);
			}
			redirect('dashboard/user_types_list');
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_user_type($args1=''){ 
		if($this->vs_user_role_id==1){
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_heading'] = 'Update User Type';
				$data['record'] = $this->admin_model->get_user_type_by_id($args1);
			}else{
				$data['page_heading'] = 'Add User Type';
			}  
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name");  
				  
				// form validation
				$this->form_validation->set_rules("name", "User Type", "trim|required|xss_clean");  
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('dashboard/operate_user_type',$data);
				}else if(isset($args1) && $args1!=''){ 
					$datas = array('name' => $name); 
					$res = $this->admin_model->update_user_type_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("dashboard/user_types_list");
				}else{ 
					$datas = array('name' => $name); 
					$res = $this->admin_model->insert_user_type_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					
					redirect("dashboard/user_types_list");
				} 	 
				
			}else{
				$this->load->view('dashboard/operate_user_type',$data);
			}
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}
	
	
	/* Permission module starts */
	function permissions_list(){
	 if($this->vs_user_role_id==1){
		$data['role_arrs'] = $this->admin_model->get_all_user_types();
		$sel_module_id = $sel_user_type_id ='';
		
		/*if($this->input->post("module_id")){
			$sel_module_id = $this->input->post("module_id");
		}
		if($this->input->post("user_type_id")){
			$sel_user_type_id = $this->input->post("user_type_id");
		}*/
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
		$totalRec = count($this->admin_model->get_all_permission_with_user_types($paras_arrs));
		
		//pagination configuration
		$config['target']      = '#fetch_dya_list';
		$config['base_url']    = site_url('/dashboard/permissions_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
		
	    $records = $data['records'] = $this->admin_model->get_all_permission_with_user_types($paras_arrs);
		
		
			
		
	 	//$data['records'] = $this->admin_model->get_all_permission_with_user_types($sel_module_id,$sel_user_type_id);
		
		$data['page_heading']="Permissions List";
		$this->load->view('dashboard/permissions_list',$data); 
	}else{
		$datas['page_heading']="Invalid Access!";
		$this->load->view('no_permission_page',$datas);
	}
}


function permissions_list2(){
	 if($this->vs_user_role_id==1){
		$data['role_arrs'] = $this->admin_model->get_all_user_types();
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
		$totalRec = count($this->admin_model->get_all_permission_with_user_types($paras_arrs)); 
		
		//pagination configuration
		$config['target']      = '#fetch_dya_list';
		$config['base_url']    = site_url('/dashboard/permissions_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
		
	   $data['records'] = $this->admin_model->get_all_permission_with_user_types($paras_arrs);
		
	 	//$data['records'] = $this->admin_model->get_all_permission_with_user_types($sel_module_id,$sel_user_type_id);
		
		$data['page_heading']="Permissions List";
		$this->load->view('dashboard/permissions_list2',$data); 
	}else{
		$datas['page_heading']="Invalid Access!";
		$this->load->view('no_permission_page',$datas);
	}
}
	 
	function trash_permission($args2=''){ 
		if($this->vs_user_role_id==1){
			$data['page_heading']="Permissions List";
			if($args2 >1){
				$this->admin_model->trash_permission($args2);
			}
			redirect('dashboard/permissions_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}
	 
		function operate_permission($args1=''){ 
			if($this->vs_user_role_id==1){
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;//
				$data['page_heading'] = 'Update Permission';
				$data['record'] = $this->admin_model->get_permission_by_id($args1);
			}else{
				$data['page_heading'] = 'Add Permission';
			}  
			$data['role_arrs'] = $this->admin_model->get_all_user_types();
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$module_id = $this->input->post("module_id"); 
				$user_type_id = $this->input->post("user_type_id");
				$is_add_permission = isset($_POST['is_add_permission']) ? 1 : 0;
				$is_update_permission = isset($_POST['is_update_permission']) ? 1 : 0;
				$is_delete_permission = isset($_POST['is_delete_permission']) ? 1 : 0;
				$is_view_permission = isset($_POST['is_view_permission']) ? 1 : 0;
				$module_section_ids_vals ='';
				if((isset($_POST['module_section_ids']) && count($_POST['module_section_ids']) >0)){ 
					$modulesection_ids = $_POST['module_section_ids'];
					$module_section_ids_vals  = implode(',',$modulesection_ids);
				}
				  
				// form validation
				$this->form_validation->set_rules("module_id", "Module(s)", "trim|required|xss_clean");  
				$this->form_validation->set_rules("user_type_id", "User Type(s)", "trim|required|xss_clean"); 
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('dashboard/operate_permission',$data);
				}else if(isset($args1) && $args1!=''){ 
					$datas = array('user_type_id' => $user_type_id,'module_id' => $module_id,'is_add_permission' => $is_add_permission,'is_update_permission' => $is_update_permission,'is_delete_permission' => $is_delete_permission,'is_view_permission' => $is_view_permission,'module_section_ids' => $module_section_ids_vals); 
					$res = $this->admin_model->update_permission_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("dashboard/permissions_list");
				}else{ 
					$datas = array('user_type_id' => $user_type_id,'module_id' => $module_id,'is_add_permission' => $is_add_permission,'is_update_permission' => $is_update_permission,'is_delete_permission' => $is_delete_permission,'is_view_permission' => $is_view_permission,'module_section_ids' => $module_section_ids_vals); 
					$res = $this->admin_model->insert_permission_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{

						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
					
					redirect("dashboard/permissions_list");
				} 	 
				
			}else{
				$this->load->view('dashboard/operate_permission',$data);
			}
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}
	
	/* Permission module ends */
	
 	/* categories operations starts */
	function categories_list(){
		if(isset($this->categories_list_module_access) && $this->categories_list_module_access==1){
			$data['records'] = $this->admin_model->get_all_categories();
			$data['page_heading']="Categories List";
			$this->load->view('dashboard/categories_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_category($args2=''){ 
	 	if(isset($this->categories_delete_module_access) && $this->categories_delete_module_access==1){
			$data['page_heading']="Categories List";
			$this->admin_model->trash_category($args2);
			
			$this->admin_model->trash_category_portal_abbrevations_data($args2);
			redirect('dashboard/categories_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_category($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;
			$data['page_heading'] = 'Update Category';
			$data['record'] = $this->admin_model->get_category_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Category';
		}  
		
		$data['max_sort_val'] = $this->admin_model->get_max_categories_sort_val();
		
		if(isset($_POST) && !empty($_POST)){
			// get form input
			$name = $this->input->post("name");
			$sort_order = $this->input->post("sort_order");
			$description = $this->input->post("description");
			$property_type = $this->input->post("property_type");
			$show_in_sale = isset($_POST['show_in_sale']) ? 1 : 0;
			$show_in_rent = isset($_POST['show_in_rent']) ? 1 : 0;
			$status = isset($_POST['status']) ? 1 : 0; 
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");
			$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
			$this->form_validation->set_rules("description", "description", "trim|xss_clean");  
			
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_category',$data);
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('name' => $name,'sort_order' => $sort_order,'show_in_sale' => $show_in_sale,'show_in_rent' => $show_in_rent,'description' => $description,'property_type' => $property_type,'status' => $status); 
				$res = $this->admin_model->update_category_data($args1,$datas); 
				if(isset($res)){
					
					//$last_cate_id = $this->db->insert_id();
					 
						
			$portal_arrs = $this->admin_model->get_all_portals();
			if(isset($portal_arrs) && count($portal_arrs)>0){
				foreach($portal_arrs as $portal_arr){
					$db_portals_id = $portal_arr->id; 
			
					$this->admin_model->trash_categories_portal_abbrevations_data($args1,$db_portals_id);  
					if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
						$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
						 	
						$datas3 = array('category_id' => $args1,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
						$this->admin_model->insert_categories_portal_abbrevations_data($datas3);		 
					} 
				}
			} 
				 	
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("dashboard/categories_list");
			}else{ 
				$datas = array('name' => $name,'sort_order' => $sort_order,'show_in_sale' => $show_in_sale,'show_in_rent' => $show_in_rent,'description' => $description,'property_type' => $property_type,'status' => $status); 
				$res = $this->admin_model->insert_category_data($datas); 
				if(isset($res)){
							
			$last_cate_id = $this->db->insert_id();
					
			$portal_arrs = $this->admin_model->get_all_portals();
			if(isset($portal_arrs) && count($portal_arrs)>0){
				foreach($portal_arrs as $portal_arr){
					$db_portals_id = $portal_arr->id; 
			 
					if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
						$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
						 
						$datas3 = array('category_id' => $last_cate_id,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
						$this->admin_model->insert_categories_portal_abbrevations_data($datas3);		
					} 
				}
			}	
					
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/categories_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_category',$data);
		}
	}
	/* end of categories */
	
	
	
	/* No of Beds operations starts */
	function no_of_beds_list(){
		if(isset($this->no_of_beds_list_module_access) && $this->no_of_beds_list_module_access==1){
			$data['records'] = $this->admin_model->get_all_no_of_beds();
			$data['page_heading']="No. of Bedrooms List";
			$this->load->view('dashboard/no_of_beds_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_no_of_beds($args2=''){ 
		 if(isset($this->no_of_beds_delete_module_access) && $this->no_of_beds_delete_module_access==1){
			$data['page_heading']="No. of Bedrooms List";
			$this->admin_model->trash_no_of_beds($args2);
			redirect('dashboard/no_of_beds_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_no_of_beds($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'No. of Bedrooms';
			$data['record'] = $this->admin_model->get_no_of_beds_by_id($args1);
		}else{
			$data['page_heading'] = 'Add No. of Bedrooms';
		}   
		
		$data['max_sort_val'] = $this->admin_model->get_max_beds_sort_val();
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$title = $this->input->post("title"); 
			$sort_order = $this->input->post("sort_order");  
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("title", "title", "trim|required|xss_clean"); 
			$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_no_of_beds',$data);
			}else if(isset($args1) && $args1!=''){
				 
				$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
				$res = $this->admin_model->update_no_of_beds_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("dashboard/no_of_beds_list");
			}else{ 
				$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
				$res = $this->admin_model->insert_no_of_beds_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/no_of_beds_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_no_of_beds',$data);
		}
	}
	/* end of No of Beds */
	
	/* emirates operations starts */
	function emirates_list(){
		if(isset($this->emirates_list_module_access) && $this->emirates_list_module_access==1){
			$data['records'] = $this->admin_model->get_all_emirates();
			$data['page_heading']="Emirates List";
			$this->load->view('dashboard/emirates_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_emirate($args2=''){
	 	if(isset($this->emirates_delete_module_access) && $this->emirates_delete_module_access==1){ 
			$data['page_heading']="Emirates List";
			$this->admin_model->trash_emirate($args2);
			redirect('dashboard/emirates_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_emirate($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Emirate';
			$data['record'] = $this->admin_model->get_emirate_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Emirate';
		}  
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$name = $this->input->post("name"); 
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
			
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_emirate',$data);
			}else if(isset($args1) && $args1!=''){
				 
				$datas = array('name' => $name,'status' => $status); 
				$res = $this->admin_model->update_emirate_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				} 
				
					redirect("dashboard/emirates_list");
			}else{ 
				$datas = array('name' => $name,'status' => $status); 
				$res = $this->admin_model->insert_emirate_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/emirates_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_emirate',$data);
		}
	}
	
	/* end of emirates */
	
	/* emirate locations operations starts */
	function emirate_locations_list(){
		if(isset($this->emirate_locations_list_module_access) && $this->emirate_locations_list_module_access==1){ 
			$data['records'] = $this->admin_model->get_all_emirate_with_locations();
			$data['page_heading']="Emirate Locations List";
			$this->load->view('dashboard/emirate_locations_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_emirate_location($args2=''){ 
		if(isset($this->emirate_locations_delete_module_access) && $this->emirate_locations_delete_module_access==1){ 
			$data['page_heading']="Emirate Locations List";
			$this->admin_model->trash_emirate_location($args2);
			redirect('dashboard/emirate_locations_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_emirate_location($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Emirate Location';
			$data['record'] = $this->admin_model->get_emirate_location_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Emirate Location';
		}  
		
		$data['emirate_arrs'] = $this->admin_model->get_all_emirates();
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$name = $this->input->post("name"); 
			$emirate_id = $this->input->post("emirate_id");  
			$description = $this->input->post("description");
			$sale_text = $this->input->post("sale_text");
			$rent_text = $this->input->post("rent_text");  
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
			$this->form_validation->set_rules("emirate_id", "Emirate Name", "trim|required|xss_clean");
			$this->form_validation->set_rules("description", "Description", "trim|required|xss_clean");
			
			$this->form_validation->set_rules("sale_text", "Sale Text", "trim|required|xss_clean");
			$this->form_validation->set_rules("rent_text", "Rent Text", "trim|required|xss_clean");
			
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_emirate_location',$data);
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('name' => $name,'emirate_id' => $emirate_id,'description' => $description,'sale_text' => $sale_text,'rent_text' => $rent_text,'status' => $status); 
				$res = $this->admin_model->update_emirate_location_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				} 
				
					redirect("dashboard/emirate_locations_list");
			}else{ 
				$datas = array('name' => $name,'emirate_id' => $emirate_id,'description' => $description,'sale_text' => $sale_text,'rent_text' => $rent_text,'status' => $status); 
				$res = $this->admin_model->insert_emirate_location_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/emirate_locations_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_emirate_location',$data);
		}
	}
	
	/* end of emirate locations */
	
	/* emirate sub locations operations starts */
	function emirate_sub_locations_list(){
		if(isset($this->emirate_sub_locations_list_module_access) && $this->emirate_sub_locations_list_module_access==1){ 
			$data['records'] = $this->admin_model->get_all_emirate_with_sub_locations();
			$data['page_heading']="Emirate Sub Locations List";
			$this->load->view('dashboard/emirate_sub_locations_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_emirate_sub_location($args2=''){ 
	 	if(isset($this->emirate_sub_locations_delete_module_access) && $this->emirate_sub_locations_delete_module_access==1){ 
			$data['page_heading']="Emirate Sub Locations List";
			$this->admin_model->trash_emirate_sub_location($args2);
			redirect('dashboard/emirate_sub_locations_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_emirate_sub_location($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Emirate Sub Location';
			$data['record'] = $this->admin_model->get_emirate_sub_location_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Emirate Sub Location';
		}  
		
		$data['emirate_arrs'] = $this->admin_model->get_all_emirates();
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$name = $this->input->post("name"); 
			$emirate_location_id = $this->input->post("emirate_location_id");   
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Sub Location Name", "trim|required|xss_clean");    
			$this->form_validation->set_rules("emirate_location_id", "Emirate Location", "trim|required|xss_clean"); 
			
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_emirate_sub_location',$data);
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('name' => $name,'emirate_location_id' => $emirate_location_id,'status' => $status); 
				$res = $this->admin_model->update_emirate_sub_location_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				} 
				
					redirect("dashboard/emirate_sub_locations_list");
			}else{ 
				$datas = array('name' => $name,'emirate_location_id' => $emirate_location_id,'status' => $status); 
				$res = $this->admin_model->insert_emirate_sub_location_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/emirate_sub_locations_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_emirate_sub_location',$data);
		}
	}
	
	/* end of emirate sub locations */
	
	
	
	
	
	
	/* emirate sub locations areas operations starts */
	function emirate_sub_location_areas_list(){
		if(isset($this->emirate_sub_locations_list_module_access) && $this->emirate_sub_locations_list_module_access==1){ 
			$data['records'] = $this->admin_model->get_all_emirate_with_sub_location_areas();
			$data['page_heading']="Emirate Sub Location Areas List";
			$this->load->view('dashboard/emirate_sub_location_areas_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_emirate_sub_location_area($args2=''){ 
	 	if(isset($this->emirate_sub_locations_delete_module_access) && $this->emirate_sub_locations_delete_module_access==1){ 
			$data['page_heading']="Emirate Sub Location Areas List";
			$this->admin_model->trash_emirate_sub_location_area($args2);
			redirect('dashboard/emirate_sub_location_areas_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_emirate_sub_location_area($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Emirate Sub Location Area';
			$data['record'] = $this->admin_model->get_emirate_sub_location_area_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Emirate Sub Location Area';
		}  
		$data['emirate_sub_location_arrs'] = $this->admin_model->get_all_emirate_sub_locations();
		
		//$data['emirate_sub_location_arrs'] = $this->admin_model->get_all_emirate_sub_location_areas();
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$name = $this->input->post("name"); 
			$emirate_sub_location_id = $this->input->post("emirate_sub_location_id");   
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Area Name", "trim|required|xss_clean");    
			$this->form_validation->set_rules("emirate_sub_location_id", "Emirate Sub Location", "trim|required|xss_clean"); 
			
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_emirate_sub_location_area',$data);
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('name' => $name,'emirate_sub_location_id' => $emirate_sub_location_id,'status' => $status); 
				$res = $this->admin_model->update_emirate_sub_location_area_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				} 
				
					redirect("dashboard/emirate_sub_location_areas_list");
			}else{ 
				$datas = array('name' => $name,'emirate_sub_location_id' => $emirate_sub_location_id,'status' => $status); 
				$res = $this->admin_model->insert_emirate_sub_location_area_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/emirate_sub_location_areas_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_emirate_sub_location_area',$data);
		}
	}
	
	/* end of emirate sub locations areas */
	
	
	
	
	
	
	
	/* neighbourhoods operations starts */
	function neighbourhoods_list(){
		if(isset($this->neighbourhoods_list_module_access) && $this->neighbourhoods_list_module_access==1){ 
			$data['records'] = $this->admin_model->get_all_neighbourhoods();
			$data['page_heading']="Neighbourhoods List";
			$this->load->view('dashboard/neighbourhoods_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_neighbourhood($args2=''){ 
	 	if(isset($this->neighbourhoods_delete_module_access) && $this->neighbourhoods_delete_module_access==1){ 
			$data['page_heading']="Neighbourhoods List";
			$this->admin_model->trash_neighbourhood($args2);
			redirect('dashboard/neighbourhoods_list');
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	 }
	 
	 function operate_neighbourhood($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Neighbourhood';
			$data['record'] = $this->admin_model->get_neighbourhood_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Neighbourhood';
		}  
		$data['max_sort_val'] = $this->admin_model->get_max_neighbourhood_sort_val();
		if(isset($_POST) && !empty($_POST)){
			//$this->load->library('custom_validation'); 
			// get form input
			$title = $this->input->post("title");  
			$sort_order = $this->input->post("sort_order");
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean");  
			$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean");   
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_neighbourhood',$data);
			}else if(isset($args1) && $args1!=''){
				 
				$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
				$res = $this->admin_model->update_neighbourhood_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("dashboard/neighbourhoods_list");
			}else{ 
				$datas = array('title' => $title,'sort_order' => $sort_order,'status' => $status); 
				$res = $this->admin_model->insert_neighbourhood_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/neighbourhoods_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_neighbourhood',$data);
		}
	}
	/* end of neighbourhood */
	
	/* portals operations starts */
	function portals_list(){
		if(isset($this->portals_list_module_access) && $this->portals_list_module_access==1){
			$data['records'] = $this->admin_model->get_all_portals();
			$data['page_heading']="Portals List";
			$this->load->view('dashboard/portals_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_portals($args2=''){ 
	 	if(isset($this->portals_delete_module_access) && $this->portals_delete_module_access==1){
			$data['page_heading']="Portals List";
			$this->admin_model->trash_portal($args2);
			redirect('dashboard/portals_list');
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	 }
	 
	 function operate_portal($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Portal';
			$data['record'] = $this->admin_model->get_portal_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Portal';
		}  
		$data['max_sort_val'] = $this->admin_model->get_max_portals_sort_val();
		if(isset($_POST) && !empty($_POST)){
			//$this->load->library('custom_validation'); 
			// get form input
			$name = $this->input->post("name");
			$sort_order = $this->input->post("sort_order");
			$url_address = $this->input->post("url_address");
			$description = $this->input->post("description"); 
			$status = isset($_POST['status']) ? 1 : 0;
			 
			// form validation
			$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean"); 
			$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean");  
			 $this->form_validation->set_rules('url_address',"URL Address", 'trim|required|xss_clean|prep_url|valid_url'); //modify this line
			$this->form_validation->set_rules("description", "description", "trim|xss_clean");  
			 
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_portal',$data);
			}else if(isset($args1) && $args1!=''){
				 
				$datas = array('name' => $name,'sort_order' => $sort_order,'url_address' => $url_address,'description' => $description,'status' => $status); 
				$res = $this->admin_model->update_portal_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("dashboard/portals_list");
			}else{ 
				$datas = array('name' => $name,'sort_order' => $sort_order,'url_address' => $url_address,'description' => $description,'status' => $status); 
				$res = $this->admin_model->insert_portal_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/portals_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_portal',$data);
		}
	}
	/* end of portals */
	
	/* property features operations starts */
	function property_features_list(){
		if(isset($this->property_features_list_module_access) && $this->property_features_list_module_access==1){
			$data['records'] = $this->admin_model->get_all_property_features();
			$data['page_heading']="Property Features List";
			$this->load->view('dashboard/property_features_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_property_feature($args2=''){
	 	if(isset($this->property_features_delete_module_access) && $this->property_features_delete_module_access==1){ 
			$data['page_heading']="Property Features List";
			$this->admin_model->trash_property_feature($args2);
			
			$this->admin_model->trash_feature_portal_abbrevation_data($args2);
			redirect('dashboard/property_features_list'); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function operate_property_feature($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Property Feature';
			$data['record'] = $this->admin_model->get_property_feature_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Property Feature';
		}  
		
		$data['max_sort_val'] = $this->admin_model->get_max_property_features_sort_val();
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$title = $this->input->post("title"); 
			$short_tag = $this->input->post("short_tag"); 
			$sort_order = $this->input->post("sort_order");
			/*$amenities_type = $this->input->post("amenities_type"); */
			$status = isset($_POST['status']) ? 1 : 0;
			
			$sel_amenities_types = (isset($_POST['amenities_types']) && count($_POST['amenities_types'])>0) ? implode(',',$_POST['amenities_types']) : ''; 
			 
			// form validation
			$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean");
			$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
			 
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_property_feature',$data);
			}else if(isset($args1) && $args1!=''){
				 
				$datas = array('title' => $title,'short_tag' => $short_tag,'sort_order' => $sort_order,'amenities_types' => $sel_amenities_types,'status' => $status); 
				$res = $this->admin_model->update_property_feature_data($args1,$datas); 
				if(isset($res)){
					
		$portal_arrs = $this->admin_model->get_all_portals();
		if(isset($portal_arrs) && count($portal_arrs)>0){
			foreach($portal_arrs as $portal_arr){
				$db_portals_id = $portal_arr->id; 
		
				$this->admin_model->trash_featured_portal_abbrevations_data($args1,$db_portals_id);  
				if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
					$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
						
					$datas3 = array('featured_id' => $args1,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
					$this->admin_model->insert_featured_portal_abbrevations_data($datas3);		 
				} 
			}
		} 
					
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("dashboard/property_features_list");
			}else{ 
				$datas = array('title' => $title,'short_tag' => $short_tag,'sort_order' => $sort_order,'amenities_types' => $sel_amenities_types,'status' => $status); 
				$res = $this->admin_model->insert_property_feature_data($datas); 
				if(isset($res)){
					
					$last_ftrd_id = $this->db->insert_id();
					$portal_arrs = $this->admin_model->get_all_portals();
					if(isset($portal_arrs) && count($portal_arrs)>0){
						foreach($portal_arrs as $portal_arr){
							$db_portals_id = $portal_arr->id; 
					   
							if(isset($_POST["cate_portal_abbr_{$db_portals_id}"]) && strlen($_POST["cate_portal_abbr_{$db_portals_id}"])>0){
								$cate_portal_abbrs = $_POST["cate_portal_abbr_{$db_portals_id}"];
									
								$datas3 = array('featured_id' => $last_ftrd_id,'portal_id' => $db_portals_id,'abbrevations' => $cate_portal_abbrs);
								$this->admin_model->insert_featured_portal_abbrevations_data($datas3);		 
							} 
						}
					} 
					
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/property_features_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_property_feature',$data);
		}
	}
	/* end of property features */
	
	
	/* property source of listings operations starts */
	function source_of_listings_list(){
		if(isset($this->source_of_listings_list_module_access) && $this->source_of_listings_list_module_access==1){
			$data['records'] = $this->admin_model->get_all_source_of_listings();
			$data['page_heading']="Source of Listings List";
			$this->load->view('dashboard/source_of_listings_list',$data); 
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	 }
	 
	 function trash_source_of_listing($args2=''){ 
	 	if(isset($this->source_of_listings_delete_module_access) && $this->source_of_listings_delete_module_access==1){
			$data['page_heading']="Source of Listings List";
			$this->admin_model->trash_source_of_listing($args2);
			redirect('dashboard/source_of_listings_list');
		}else{
			$datas['page_heading']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	 }
	 
	 function operate_source_of_listing($args1=''){ 
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_heading'] = 'Update Source of Listing';
			$data['record'] = $this->admin_model->get_source_of_listing_by_id($args1);
		}else{
			$data['page_heading'] = 'Add Source of Listing';
		}   
		$data['max_sort_val'] = $this->admin_model->get_max_source_of_listings_sort_val();
		
		if(isset($_POST) && !empty($_POST)){
		
			// get form input
			$title = $this->input->post("title"); 
			$sort_order = $this->input->post("sort_order");
			$status = isset($_POST['status']) ? 1 : 0;
			$show_in_properties = isset($_POST['show_in_properties']) ? 1 : 0;
			$show_in_leads = isset($_POST['show_in_leads']) ? 1 : 0;
			
			// form validation
			$this->form_validation->set_rules("title", "Title", "trim|required|xss_clean");
			$this->form_validation->set_rules("sort_order", "Sort Order", "trim|required|xss_clean"); 
			 
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('dashboard/operate_source_of_listing',$data);
			}else if(isset($args1) && $args1!=''){
				 
				$datas = array('title' => $title,'show_in_properties' => $show_in_properties,'show_in_leads' => $show_in_leads,'sort_order' => $sort_order,'status' => $status); 
				$res = $this->admin_model->update_source_of_listing_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("dashboard/source_of_listings_list");
			}else{ 
				$datas = array('title' => $title,'show_in_properties' => $show_in_properties,'show_in_leads' => $show_in_leads,'sort_order' => $sort_order,'status' => $status); 
				$res = $this->admin_model->insert_source_of_listing_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				
				redirect("dashboard/source_of_listings_list");
			} 	 
			
		}else{
			$this->load->view('dashboard/operate_source_of_listing',$data);
		}
	}
	/* end of property source of listings */
	 

	function agents_meetings_view_list($sel_dated=''){ 
		$data['page_heading']="Agents Meetings & Views List";
		 
		$arrs_field = array('user_type_id'=> '3'); 
		$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
		$sel_assigned_to_id = $nw_sel_dated = '';
		
		if(isset($sel_dated) && strlen($sel_dated)>0){
			$nw_sel_dated = $sel_dated;
		}
		
		if(isset($_POST) && !empty($_POST)){
			$nw_sel_dated = $this->input->post("s");
			$sel_assigned_to_id = $this->input->post("assigned_to_id");
		}
		$data["nw_sel_dated"] = $nw_sel_dated;
		$data['records'] = $this->admin_model->get_agents_meetings_view_list($nw_sel_dated, $sel_assigned_to_id);
		$this->load->view('dashboard/agents_meetings_view_list',$data); 
	} 
} ?>