<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Permissions extends CI_Controller{
		   
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
			$this->load->model('users_model'); 
			$this->load->model('roles_model'); 
			$this->load->model('admin_model'); 
			$perms_arrs = array('role_id'=> $vs_role_id);
			
			$this->load->library('Ajax_pagination');
			$this->perPage = 25;
		}   
		
		
		/* Permission module starts */
		function index(){ 
			
			$res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','index',$this->dbs_role_id,'1'); 
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
			$totalRec = count($this->permissions_model->get_all_permission_with_user_modules_roles($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#fetch_dya_list';
			$config['base_url']    = site_url('/permissions/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$records = $data['records'] = $this->permissions_model->get_all_permission_with_user_modules_roles($paras_arrs);
			 
			$data['page_headings']="Permissions List";
			$this->load->view('permissions/index',$data); 
			
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
	
	
		function index2(){
		 
			$data['role_arrs'] = $this->roles_model->get_all_roles();
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
			$totalRec = count($this->permissions_model->get_all_permission_with_user_modules_roles($paras_arrs)); 
			
			//pagination configuration
			$config['target']      = '#fetch_dya_list';
			$config['base_url']    = site_url('/permissions/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg));
			
		   $data['records'] = $this->permissions_model->get_all_permission_with_user_modules_roles($paras_arrs); 
			
			$data['page_headings']="Permissions List";
			$this->load->view('permissions/index2',$data); 
		
		}
		 
		function trash($args2=''){    
			
			$res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','trash',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				
				$data['page_headings']="Permissions List";
				if($args2 >1){
					$this->permissions_model->trash_permission($args2);
				}
				redirect('permissions/index');  
				
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		}
		
		 function trash_aj(){  
			 $res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','trash',$this->dbs_role_id,'1'); 
			if($res_nums>0){
			
				 if(isset($_POST["args1"]) && $_POST["args1"]>1){
					$args1 = $this->input->post("args1"); 
					$this->permissions_model->trash_permission($args1);
				 }  
				 
				 $this->index2();
				 
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		 }
		 
		 
		  function trash_multiple(){    
		
			$res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','trash',$this->dbs_role_id,'1');  
			if($res_nums>0){
					
			$data['page_headings']="Permissions";  
				
				if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
					$del_checks = $_POST["multi_action_check"]; 
					foreach($del_checks as $args1){  
						if($args1>0){ 
							$this->permissions_model->trash_permission($args1);
						} 
					}
				 } 
				 $this->index2();
				 
			}else{
				$this->load->view('no_permission_access'); 
			}
		 }   
		 
		function add(){ 
		
			$res_nums = $this->general_model->check_controller_method_permission_access('Permissions','add',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				 
			$perid =0; 
			$data['page_headings'] = 'Add Permission';
			 
			$data['role_arrs'] = $this->roles_model->get_all_roles();
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
					$this->load->view('permissions/add',$data);
				}else if((isset($args1) && $args1!='') && (isset($rec_nums) && $rec_nums>0)){
					$this->session->set_flashdata('error_msg','Error: This moodule and role data are already added!');
					$this->load->view('permissions/add',$data);
					
				}else if(isset($args1) && $args1!=''){
					  
					$datas = array('role_id' => $role_id,'module_id' => $module_id,'is_add_permission' => $is_add_permission,'is_update_permission' => $is_update_permission,'is_delete_permission' => $is_delete_permission,'is_view_permission' => $is_view_permission); 
					$res = $this->permissions_model->update_permission_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("permissions/index");
						
				}else if(isset($rec_nums) && $rec_nums>0){
					
					$this->session->set_flashdata('error_msg','Error: This moodule and role data are already added!');
					$this->load->view('permissions/add',$data);	
					 
				}else{
					 $vs_id = $this->session->userdata('us_id');
					 $created_on = date('Y-m-d H:i:s');
						  
					$datas = array('role_id' => $role_id,'module_id' => $module_id,'is_add_permission' => $is_add_permission,'is_update_permission' => $is_update_permission,'is_delete_permission' => $is_delete_permission,'is_view_permission' => $is_view_permission,'added_by' => $vs_id,'created_on' => $created_on); 
					$res = $this->permissions_model->insert_permission_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					}  
					 
					if(isset($_POST['saves_and_new'])){
						redirect("permissions/add");
					}else{
						redirect("permissions/index");	
					}
					  
				} 	 
				
			}else{
				$this->load->view('permissions/add',$data);
			}
			
			}else{ 
				$this->load->view('no_permission_access'); 
			}  
		} 
		
		
		function update($args1=''){ 
		
			$res_nums =  $this->general_model->check_controller_method_permission_access('Permissions','update',$this->dbs_role_id,'1'); 
			if($res_nums>0){
				 
			$perid =0;
			if(isset($args1) && $args1!=''){ 
				$perid = $args1;
				$data['args1'] = $args1;//
				$data['page_headings'] = 'Update Permission';  
				$data['record'] = $this->permissions_model->get_permission_by_id_with_chk($args1);
			}else{
				$data['page_headings'] = 'Add Permission';
			}  
			$data['role_arrs'] = $this->roles_model->get_all_roles();
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
					$this->load->view('permissions/update',$data);
				}else if((isset($args1) && $args1!='') && (isset($rec_nums) && $rec_nums>0)){
					$this->session->set_flashdata('error_msg','Error: This moodule and role data are already added!');
					$this->load->view('permissions/update',$data);
					
				}else if(isset($args1) && $args1!=''){
					  
					$datas = array('role_id' => $role_id,'module_id' => $module_id,'is_add_permission' => $is_add_permission,'is_update_permission' => $is_update_permission,'is_delete_permission' => $is_delete_permission,'is_view_permission' => $is_view_permission); 
					$res = $this->permissions_model->update_permission_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					}
					
						redirect("permissions/index");
						
				}else if(isset($rec_nums) && $rec_nums>0){
					
					$this->session->set_flashdata('error_msg','Error: This moodule and role data are already added!');
					$this->load->view('permissions/update',$data);	
					 
				} 	 
				
			}else{
				$this->load->view('permissions/update',$data);
			}
			
			}else{ 
				$this->load->view('no_permission_access'); 
			} 
		
		}
		
		/* Permission module ends */
		
		 
			
		}
	?>