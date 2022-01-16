<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Manager extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				  
				$res_nums = $this->general_model->check_controller_permission_access('Manager',$vs_user_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}  
			 
			$this->load->model('manager_model'); 
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
			$this->load->library('Ajax_pagination');
			$this->perPage = 25;
		}   
		 
		/* Reports operations starts */ 
		 
		 function agents_list(){ 
			
			$res_nums =  $this->general_model->check_controller_method_permission_access('Manager','index',$this->dbs_role_id,'1'); 
			if($res_nums>0){ 
			  	$vs_id = $this->session->userdata('us_id');  
				$paras_arrs = array("manager_id_val" => $vs_id);	 
				 
				if($this->input->post('sel_per_page_val')){
					$per_page_val = $this->input->post('sel_per_page_val'); 
					$_SESSION['tmp_per_page_val'] = $per_page_val;  
					
				}else if(isset($_SESSION['tmp_per_page_val'])){
						unset($_SESSION['tmp_per_page_val']);
					} 
				
				if($this->input->post('q_val')){
					$q_val = $this->input->post('q_val'); 
					$_SESSION['tmp_q_val'] = $q_val;
					$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
					
				}else if(isset($_SESSION['tmp_q_val'])){
						unset($_SESSION['tmp_q_val']);
					}  
				
				if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
				}else{
					$show_pers_pg = $this->perPage;
				}
				 
				//total rows count
				$totalRec = count($this->manager_model->get_filter_manager_agents_list($paras_arrs));
				
				//pagination configuration
				$config['target']      = '#dyns_list';
				$config['base_url']    = site_url('/manager/agents_list2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg; //$this->perPage;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
				
				$data['records'] = $this->manager_model->get_filter_manager_agents_list($paras_arrs);
				 
				$data['page_headings'] = "Agents List";
				$this->load->view('manager/agents_list', $data); 
				
				}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
	
	
	function agents_list2(){
		$data['page_headings'] = "Agents List";
 
		$vs_id = $this->session->userdata('us_id');  
		$paras_arrs = array("manager_id_val" => $vs_id);
		
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
			
		if(isset($_POST['q_val'])){
			$q_val = $this->input->post('q_val');   
			if(strlen($q_val)>0){
				$_SESSION['tmp_q_val'] = $q_val;
				$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val)); 
			}else{
				unset($_SESSION['tmp_q_val']);
			}
			
		}else if(isset($_SESSION['tmp_q_val'])){
			$q_val = $_SESSION['tmp_q_val']; 
			$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
		}  
		
		
		if(isset($_SESSION['tmp_per_page_val'])){
			$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
		}else{
			$show_pers_pg = $this->perPage;
		}
		 
		//total rows count
		$totalRec = count($this->manager_model->get_filter_manager_agents_list($paras_arrs)); 
		
		//pagination configuration
		$config['target']      = '#dyns_list';
		$config['base_url']    = site_url('/manager/agents_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
		
		$data['records'] = $this->manager_model->get_filter_manager_agents_list($paras_arrs); 
		 
		$this->load->view('manager/agents_list2',$data);  
	}  
		
		
	function add_agent(){      
		$res_nums = $this->general_model->check_controller_method_permission_access('Manager','index',$this->dbs_role_id,'1'); 
		if($res_nums>0){
			$this->load->model('users_model'); 
			$data['page_headings'] = 'Add Agent';
			$vs_id = $this->session->userdata('us_id');
			
			if(isset($_POST) && !empty($_POST)){
				// get form input
				$name = $this->input->post("name");
				$email = $this->input->post("email");
				$password = $this->input->post("password"); 
				$phone_no = $this->input->post("phone_no");
				$mobile_no = $this->input->post("mobile_no");
				$company_name = $this->input->post("company_name");
				$address = $this->input->post("address");
				$status = $this->input->post("status");
				$parent_id = $vs_id; /* (isset($_POST['parent_id'])) ? $this->input->post("parent_id") : '0'; */
				 
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
				/*$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean{$is_unique_name}"); */
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("email", "Email-ID", "trim|required|xss_clean|valid_email{$is_unique_email}");
				$this->form_validation->set_rules("password", "Password", "trim|required|xss_clean");
				$this->form_validation->set_rules("phone_no", "Phone No","trim|required|xss_clean");
				$this->form_validation->set_rules("mobile_no", "Mobile No","trim|required|xss_clean{$is_unique_mobile_no}"); 
				$this->form_validation->set_rules("address", "Address", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("status", "Account Status", "trim|required|xss_clean");
				 
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('manager/add_agent',$data);
				}else if(strlen($prf_img_error)>0){ 
				 
					$this->session->set_flashdata('prof_img_error',$prf_img_error);
					$this->load->view('manager/add_agent',$data);
					
				}else{
					$created_on = date('Y-m-d H:i:s');
					$password = $this->general_model->encrypt_data($password);
					$datas = array('name' => $name,'role_id' => '3', 'email' => $email,'password' => $password,'mobile_no' => $mobile_no,'phone_no' => $phone_no,'company_name' => $company_name, 'address' => $address,'created_on' => $created_on,'status' => $status,'image' => $imagename,'parent_id' => $parent_id); 
					$res = $this->users_model->insert_user_data($datas);
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					}  
					
					if(isset($_POST['saves_and_new'])){
						redirect("manager/add_agent/");
					}else{
						redirect("manager/agents_list/");	
					} 
				}
				
			}else{
				$this->load->view('manager/add_agent',$data);
			}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}   
	} 
	
	
	function update_agent($args1=''){  
		$res_nums = $this->general_model->check_controller_method_permission_access('Manager','index',$this->dbs_role_id,'1'); 
		if($res_nums>0){
			$vs_id = $this->session->userdata('us_id');
			$this->load->model('users_model'); 	
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1;
				$data['page_headings'] = 'Update Agent';
				$update_record_arr = $data['record'] = $this->users_model->get_user_by_id($args1);
			}else{
				$data['page_headings'] = 'Add Agent';
			}  
			  
			if(isset($_POST) && !empty($_POST)){ 
				// get form input
				$name = $this->input->post("name"); 
				$email = $this->input->post("email");
				$password = $this->input->post("password"); 
				$phone_no = $this->input->post("phone_no");  
				$mobile_no = $this->input->post("mobile_no");  
				$company_name = $this->input->post("company_name"); 
				$address = $this->input->post("address"); 
				$status = $this->input->post("status");
				$parent_id = $vs_id; /*(isset($_POST['parent_id'])) ? $this->input->post("parent_id") : '0';*/
				
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
				/*$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean{$is_unique_name}");*/
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("email", "Email-ID", "trim|required|xss_clean|valid_email{$is_unique_email}");
				$this->form_validation->set_rules("password", "Password", "trim|required|xss_clean");
				$this->form_validation->set_rules("phone_no", "Phone No","trim|required|xss_clean");
				$this->form_validation->set_rules("mobile_no", "Mobile No","trim|required|xss_clean{$is_unique_mobile_no}"); 
				$this->form_validation->set_rules("address", "Address", "trim|required|xss_clean"); 
				$this->form_validation->set_rules("status", "Account Status", "trim|required|xss_clean");
				 
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('manager/update_agent',$data);
				}else if(strlen($prf_img_error)>0){ 
				 
					$this->session->set_flashdata('prof_img_error',$prf_img_error);
					$this->load->view('manager/update_agent',$data);
					
				}else if(isset($args1) && $args1!=''){   
					/*$password = md5($password);*/
					$password = $this->general_model->encrypt_data($password);
					$datas = array('name' => $name,'role_id' => '3', 'email' => $email,'password' => $password,'mobile_no' => $mobile_no,'phone_no' => $phone_no,'company_name' => $company_name, 'address' => $address,'status' => $status,'image' => $imagename,'parent_id' => $parent_id); 
					$res = $this->users_model->update_user_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
					redirect("manager/agents_list");
				}	 
				
			}else{
				$this->load->view('manager/update_agent',$data);
			}
			
		}else{ 
			$this->load->view('no_permission_access'); 
		}   
	} 
		 
		 
		  function agents_meetings_views_list(){ 
			
			$res_nums =  $this->general_model->check_controller_method_permission_access('Manager','index',$this->dbs_role_id,'1'); 
			if($res_nums>0){ 
			  	$vs_id = $this->session->userdata('us_id');  
				$paras_arrs = array("manager_id_val" => $vs_id);	 
				 
				if($this->input->post('sel_per_page_val')){
					$per_page_val = $this->input->post('sel_per_page_val'); 
					$_SESSION['tmp_per_page_val'] = $per_page_val;  
					
				}else if(isset($_SESSION['tmp_per_page_val'])){
						unset($_SESSION['tmp_per_page_val']);
					} 
				
				if($this->input->post('q_val')){
					$q_val = $this->input->post('q_val'); 
					$_SESSION['tmp_q_val'] = $q_val;
					$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
					
				}else if(isset($_SESSION['tmp_q_val'])){
						unset($_SESSION['tmp_q_val']);
					}  
				
				if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
				}else{
					$show_pers_pg = $this->perPage;
				}
				 
				//total rows count
				$totalRec = count($this->manager_model->get_filter_agents_meetings_views_list($paras_arrs));
				
				//pagination configuration
				$config['target']      = '#dyns_list';
				$config['base_url']    = site_url('/manager/agents_meetings_views_list2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg; //$this->perPage;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
				
				$data['records'] = $this->manager_model->get_filter_agents_meetings_views_list($paras_arrs);
				 
				$data['page_headings'] = "Agents Meetings & Views List";
				$this->load->view('manager/agents_meetings_views_list', $data); 
				
				}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
	
	
		function agents_meetings_views_list2(){
		 	$data['page_headings'] = "Agents Meetings & Views List";
	 
			$vs_id = $this->session->userdata('us_id');  
			$paras_arrs = array("manager_id_val" => $vs_id);
			
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
				
			if(isset($_POST['q_val'])){
				$q_val = $this->input->post('q_val');   
				if(strlen($q_val)>0){
					$_SESSION['tmp_q_val'] = $q_val;
					$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val)); 
				}else{
					unset($_SESSION['tmp_q_val']);
				}
				
			}else if(isset($_SESSION['tmp_q_val'])){
				$q_val = $_SESSION['tmp_q_val']; 
				$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
			}  
			
			
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			 
			//total rows count
			$totalRec = count($this->manager_model->get_filter_agents_meetings_views_list($paras_arrs)); 
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/manager/agents_meetings_views_list2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
			
		    $data['records'] = $this->manager_model->get_filter_agents_meetings_views_list($paras_arrs); 
			 
			$this->load->view('manager/agents_meetings_views_list2',$data); 
		
		}  
 		  
		/* end of Manager */   	 
	  
	}
?>
