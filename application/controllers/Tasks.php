<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Tasks extends CI_Controller{

		public function __construct(){
			parent::__construct();
			 
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $this->dbs_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($this->dbs_role_id) && $this->dbs_role_id>=1)){
				/* ok */
				$res_nums = $this->general_model->check_controller_permission_access('Tasks',$this->dbs_role_id,'1');
				if($res_nums>0){
					 /* ok */
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			} 
			 
			$this->load->model('tasks_model');
			$this->load->model('admin_model'); 
			$this->load->model('general_model'); 
		}   
		   
		 
	/* Tasks operations starts */   
	function index(){   
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','index',$this->dbs_role_id,'1'); 
		if($res_nums>0){
			
			$data['records'] = $this->tasks_model->get_all_tasks_to_do();
			$data['page_headings'] = "Tasks List";
			$this->load->view('tasks/index',$data);
			
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	}
	 
	 function trash($args2=''){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','trash',$this->dbs_role_id,'1');
		if($res_nums>0){ 
		
			$data['page_headings'] = "Tasks List";
			$this->tasks_model->get_all_emirates($args2);
			redirect('tasks/index'); 
			
		}else{ 
			$this->load->view('no_permission_access'); 
		}  
	 }
	 
	 function trash_aj(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','trash',$this->dbs_role_id,'1');
		if($res_nums>0){
			
			if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1"); 
				$res = $this->tasks_model->trash_emirate($args1);
			 } 
			 
			 $data['records'] = $this->tasks_model->get_all_emirates(); 
			 $this->load->view('tasks/index_aj',$data); 
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }  
	 
	 function trash_multiple(){  
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','trash',$this->dbs_role_id,'1');  
		if($res_nums>0){ 
		
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){  
					$res = $this->tasks_model->trash_emirate($args2);   
				}  
			} 
			
			$data['records'] = $this->tasks_model->get_all_emirates(); 
			$this->load->view('tasks/index_aj',$data);
			
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }
	 
	 
	 function add(){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','add',$this->dbs_user_role_id,'1');  
		if($res_nums>0){ 
		 
			$data['page_headings'] = 'Add Task';
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name"); 
				$status = isset($_POST['status']) ? 1 : 0;
				 
				// form validation
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('tasks/add',$data);
				}else{ 
					$datas = array('name' => $name,'status' => $status); 
					$res = $this->tasks_model->insert_emirate_data($datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record inserted successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while inserting record!');
					}  
					
					if(isset($_POST['saves_and_new'])){
						redirect("tasks/add");
					}else{
						redirect("tasks/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('tasks/add',$data);
			}
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	}  
	
	
	 function update($args1=''){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','update',$this->dbs_user_role_id,'1');
		if($res_nums>0){ 
		 	$data['page_headings'] = 'Update Task';
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1; 
				$data['record'] = $this->tasks_model->get_emirate_by_id($args1);
			}
			
			if(isset($_POST) && !empty($_POST)){
			
				// get form input
				$name = $this->input->post("name"); 
				$status = isset($_POST['status']) ? 1 : 0;
				 
				// form validation
				$this->form_validation->set_rules("name", "Name", "trim|required|xss_clean");    
				
				if($this->form_validation->run() == FALSE){
				// validation fail
					$this->load->view('tasks/update',$data);
				}else if(isset($args1) && $args1!=''){
					 
					$datas = array('name' => $name,'status' => $status); 
					$res = $this->tasks_model->update_emirate_data($args1,$datas); 
					if(isset($res)){
						$this->session->set_flashdata('success_msg','Record updated successfully!');
					}else{
						$this->session->set_flashdata('error_msg','Error: while updating record!');
					} 
					
					redirect("tasks/index");
				} 	 
				
			}else{
				$this->load->view('tasks/update',$data);
			}
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	} 
	/* end of emirates */
	 
	}
?>
