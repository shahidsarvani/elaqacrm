<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Owners extends CI_Controller{
		   
		public function __construct(){
			parent::__construct();
			 
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_role_id = $this->dbs_role_id = $vs_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_role_id) && $vs_role_id>=1)){
				/* ok */ 
				$res_nums = $this->general_model->check_controller_permission_access('Permissions',$vs_role_id,'1');
				if($res_nums>0){
					/* ok */ 
				}else{
					redirect('/');
				} 
			}else{
				redirect('/');
			}
			$this->load->model('permissions_model'); 
			$this->load->model('owners_model'); 
			$this->load->model('admin_model');  
			$perms_arrs = array('role_id'=> $vs_role_id); 
			$this->load->library('Ajax_pagination');
			$this->perPage = 25;
		}   
		
		/* Owners module starts */
		function index(){ 
			
			$res_nums =  $this->general_model->check_controller_method_permission_access('Owners','index',$this->dbs_role_id,'1'); 
			if($res_nums>0){ 
		 
			$sel_module_id = $sel_user_type_id =''; 
			$paras_arrs = array();	
			 
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
			$totalRec = count($this->owners_model->get_all_filter_owners($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/owners/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->owners_model->get_all_filter_owners($paras_arrs);
			 
			$data['page_headings']="Owners List";
			$this->load->view('owners/index',$data); 
			
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
	
	
		function index2(){
		 	$data['page_headings']="Owners List";
	
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
			$totalRec = count($this->owners_model->get_all_filter_owners($paras_arrs)); 
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/owners/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
			
		   $data['records'] = $this->owners_model->get_all_filter_owners($paras_arrs); 
			 
			$this->load->view('owners/index2',$data); 
		
		} 
		
		function trash_aj(){  
			 $res_nums =  $this->general_model->check_controller_method_permission_access('Owners','trash',$this->dbs_role_id,'1'); 
			if($res_nums>0){
			
				 if(isset($_POST["args1"]) && $_POST["args1"]>1){
					$args1 = $this->input->post("args1"); 
					$this->owners_model->trash_owner($args1);
				 }  
				 
				 $this->index2();
				 
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		} 
		
		
	 
	 function trash_multiple(){    
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Owners','trash',$this->dbs_role_id,'1');  
		if($res_nums>0){
				
		$data['page_headings']="Owners";  
			
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args1){  
					if($args1>0){
						$this->owners_model->trash_owner($args1); 
					} 
				}
			 } 
			 $this->index2();
			 
		}else{
			$this->load->view('no_permission_access'); 
		}
	 }  
		
		 
	function add(){ 
	
		$res_nums = $this->general_model->check_controller_method_permission_access('Owners','add',$this->dbs_role_id,'1'); 
		if($res_nums>0){ 
		$data['page_headings'] = 'Add Owner'; 
		
		if(isset($_POST) && !empty($_POST)){ 
			// get form input
			$name = $this->input->post("name"); 
			$email = $this->input->post("email");  
			$company_name = $this->input->post("company_name"); 
			$mobile_no = $this->input->post("mobile_no");  
			$phone_no = $this->input->post("phone_no"); 
			$address = $this->input->post("address");  
				  
			// form validation
			$this->form_validation->set_rules("name","Name","trim|required|xss_clean");  
			$this->form_validation->set_rules("email","Email","trim|required|xss_clean|valid_email"); 
			$this->form_validation->set_rules("mobile_no","Mobile No","trim|required|xss_clean"); 
			$this->form_validation->set_rules("address","Address","trim|required|xss_clean");
					 
			if($this->form_validation->run() == FALSE){
				// validation fail
				$this->load->view('owners/add',$data);
			}else{
				 $vs_id = $this->session->userdata('us_id');
				 $created_on = date('Y-m-d H:i:s');
					  
				$datas = array('name' => $name,'email' => $email,'company_name' => $company_name,'mobile_no' => $mobile_no,'phone_no' => $phone_no,'address' => $address,'created_by' => $vs_id,'created_on' => $created_on); 
				$res = $this->owners_model->insert_owner_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				}  
				 
				if(isset($_POST['saves_and_new'])){
					redirect("owners/add");
				}else{
					redirect("owners/index");	
				} 
			} 	 
			
		}else{
			$this->load->view('owners/add',$data);
		}
		
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	} 
		
		
		function update($args1=''){ 
		
			$res_nums =  $this->general_model->check_controller_method_permission_access('Owners','update',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				 
			$perid =0;
			if(isset($args1) && $args1!=''){ 
				$perid = $args1;
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Owner';  
				$data['record'] = $this->owners_model->get_owner_by_id($args1);
			}   
			 
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name"); 
				$email = $this->input->post("email");  
				$company_name = $this->input->post("company_name"); 
				$mobile_no = $this->input->post("mobile_no");  
				$phone_no = $this->input->post("phone_no"); 
				$address = $this->input->post("address");
				   
				// form validation
				$this->form_validation->set_rules("name","Name","trim|required|xss_clean");  
				$this->form_validation->set_rules("email","Email","trim|required|xss_clean|valid_email"); 
				$this->form_validation->set_rules("mobile_no","Mobile No","trim|required|xss_clean"); 
				$this->form_validation->set_rules("address","Address","trim|required|xss_clean");
				   
				 
				if($this->form_validation->run() == FALSE){
					// validation fail
					$this->load->view('owners/update',$data);
				}else if(isset($args1) && $args1!=''){
					  
					$vs_id = $this->session->userdata('us_id');
					$updated_on = date('Y-m-d H:i:s');
						  
					$datas = array('name' => $name,'email' => $email,'company_name' => $company_name,'mobile_no' => $mobile_no,'phone_no' => $phone_no,'address' => $address,'updated_on' => $updated_on); 
					$res = $this->owners_model->update_owner_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
					redirect("owners/index"); 	
				} 	 
				
			}else{
				$this->load->view('owners/update',$data);
			}
			
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		}
		 
		
		function owners_popup_list(){  
			
			$res_nums = $this->general_model->check_controller_method_permission_access('Owners','add',$this->dbs_role_id,'1'); 
			if($res_nums>0){ 
			
				$data['page_headings']="Owners Listings";	
				
				$paras_arrs = array();	  
				
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
				$totalRec = count($this->owners_model->get_all_filter_owners($paras_arrs));
				 
				//pagination configuration
				$config['target']      = '#fetch_dyn_list';
				$config['base_url']    = site_url('/owners/owners_popup_list2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
				
				$data['records'] = $this->owners_model->get_all_filter_owners($paras_arrs);
				  
				$this->load->view('owners/owners_popup_list',$data); 
				  
			}else{
				$this->load->view('no_permission_access'); 
			} 
		}
		
		function owners_popup_list2(){  	
			$res_nums = $this->general_model->check_controller_method_permission_access('Owners','add',$this->dbs_role_id,'1'); 
			if($res_nums>0){ 
			
				$paras_arrs = $data = array();	
				$page = $this->input->post('page');
				if(!$page){
					$offset = 0;
				}else{
					$offset = $page;
				} 
				
				$data['page'] = $page;
				
				/* permission checks */  
		
				if($this->input->post('sel_per_page_val')){
					$per_page_val = $this->input->post('sel_per_page_val'); 
					$_SESSION['tmp_per_page_val'] = $per_page_val;  
					
				}else if(isset($_SESSION['tmp_per_page_val'])){
						$show_pers_pg = $_SESSION['tmp_per_page_val'];
					} 
				
				if(isset($_POST['q_val'])){
					$q_val = $this->input->post('q_val');  
					if(strlen($q_val)>0){
						$_SESSION['tmp_q_val'] = $q_val; 
						$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
					}else{
						unset($_SESSION['tmp_q_val']);	
					}
				
				}else if(isset($_SESSION['tmp_q_val'])){ ///
					$q_val = $_SESSION['tmp_q_val']; 
					$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
				}  
					   
				   
				if(isset($_SESSION['tmp_per_page_val'])){
					$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
				}else{
					$show_pers_pg = $this->perPage;
				}   
				   
				//total rows count
				$totalRec = count($this->owners_model->get_all_filter_owners($paras_arrs));
				
				//pagination configuration
				$config['target']      = '#fetch_dyn_list';
				$config['base_url']    = site_url('/owners/owners_popup_list2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $show_pers_pg; // $this->perPage;
				
				$this->ajax_pagination->initialize($config); 
				
				$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit' => $show_pers_pg));
				
				$data['records'] = $this->owners_model->get_all_filter_owners($paras_arrs); 
				
				$this->load->view('owners/owners_popup_list2',$data); 
			 
			}else{
				$this->load->view('no_permission_access'); 
			} 
		}  
		
		
	function owners_popup_add_list(){ 
		
		$res_nums = $this->general_model->check_controller_method_permission_access('Owners','add',$this->dbs_role_id,'1'); 
		if($res_nums>0){ 
			
			if(isset($_REQUEST['c_name']) && !empty($_REQUEST['c_name'])){
			 
				$name = $this->input->post_get("c_name"); 
				$email = $this->input->post_get("c_email"); 
				$mobile_no = $this->input->post_get("c_mobile_no");    
				$created_by = $this->session->userdata('us_id');
				$created_on = date('Y-m-d H:i:s');  
				 
				$rec_res1 = $this->owners_model->get_owner_by_name($name);
				$rec_res2 = $this->owners_model->get_owner_by_mobile_no($mobile_no);
				
				if(isset($rec_res1) && isset($rec_res2)){ 
				 	echo 'namesmobiles'; 
				}else if(isset($rec_res1)){ 
				 	echo 'names';
				 
				}else if(isset($rec_res2)){ 
					echo 'mobiles';
				}else{
					$datas = array('name' => $name,'email' => $email,'mobile_no' => $mobile_no,'created_by' => $created_by,'created_on' => $created_on); 
					$res = $this->owners_model->insert_owner_data($datas); 
					 
					if(isset($res)){
						$last_insert_id = $this->db->insert_id();
						echo $data['last_insert_id'] = $last_insert_id;
					
						//$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						//$this->session->set_flashdata('error_msg','Error: while inserting record!');
					} 
				} 
				
			}
			
			//$data['records'] = $this->owners_model->get_all_owners(); 
			//$this->load->view('owners/owners_popup_add_list',$data); 
	 	}else{
			$this->load->view('no_permission_access');
		}
	}  
		
	function fetch_owners_list($sel_owrid=''){
		$data['sel_owrid'] = $sel_owrid;
		$this->load->view('ajax/fetch_owners',$data); 
	}
		 
		 
		/* Owners module ends */
	 		
	}
	?>