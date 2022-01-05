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
			$this->load->library('Ajax_pagination');
			$this->perPage = 25;
		}   
		   
		 
	/* Tasks operations starts */     
	function index(){
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','index',$this->dbs_role_id,'1');  
		if($res_nums>0){
			$paras_arrs = array(); 
			/* permission checks */
			 
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
			$totalRec = count($this->tasks_model->get_all_tasks_to_do($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/tasks/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			
			$data['records'] = $this->tasks_model->get_all_tasks_to_do($paras_arrs); 			  
			  
			$data['page_headings'] = "Tasks List"; 
			$this->load->view('tasks/index',$data); 	//deals_model  
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}

	function index2(){ 
	 	$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','index',$this->dbs_role_id,'1');  
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
			
			if(isset($_POST['sel_per_page_val'])){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				}
			
			if(isset($_POST['q_val'])){
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
			$totalRec = count($this->tasks_model->get_all_tasks_to_do($paras_arrs));
			
			//pagination configuration
			$config['target']      = '#dyns_list';
			$config['base_url']    = site_url('/tasks/index2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; //$this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit'=> $show_pers_pg));
			
			$data['records'] = $this->tasks_model->get_all_tasks_to_do($paras_arrs); 
			
			$this->load->view('tasks/index2',$data); 
		 
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
		 
	 function trash_aj(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','trash',$this->dbs_role_id,'1');
		if($res_nums>0){
			
			if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1"); 
				$res = $this->tasks_model->trash_task($args1);
			 } 
			 
			 $this->index2();
			 
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
					$res = $this->tasks_model->trash_task($args2);   
				}  
			} 
			
			$this->index2();
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }
	 
	 
 function operate_task_to_do($args1=''){ 
	if($this->dbs_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
		redirect('agent/operate_meetings_views');
	}
	$this->load->library('email'); 
	$created_on = $updated_on = date('Y-m-d H:i:s'); 
	$tmp_assignid = $this->session->userdata('us_id'); 
	$data['conf_currency_symbol'] = $this->general_model->get_gen_currency_symbol(); 
	if(isset($args1) && $args1!=''){ 
		$data['args1'] = $args1;
		$record_arr = $this->tasks_model->get_tasks_to_do_by_id($args1);
		$data['record'] = $record_arr;
		$data['page_headings'] = 'Update Task to Do';
		
		if((isset($args1) && $args1!='') && (isset($record_arr) && $record_arr->assigned_to==$tmp_assignid)){
			$datas1 = array('updated_on' => $updated_on,'is_new' => '0'); 
			$this->tasks_model->update_tasks_to_do_data($args1,$datas1); 	   
		}
	}else{
		$data['page_headings'] = 'Add Task to Do';
	}   
	
	$data['record_arrs'] = $this->general_model->get_gen_all_users_assigned();
	  
	if(isset($_POST) && !empty($_POST)){
	
		$title = $this->input->post("title");   
		$property_ref = $this->input->post("property_ref");  
		$lead_ref = $this->input->post("lead_ref");  
		if($this->login_vs_user_role_id >=3){
			$assigned_to = $this->session->userdata('us_id');
		}else{
			$assigned_to = $this->input->post("assigned_to");
		}
		
		$due_date = $this->input->post("due_date");  
		$due_timing = $this->input->post("due_timing");   
		$status = $this->input->post("status"); 
		$created_by = $this->session->userdata('us_id'); 
		
		// form validation 
		$this->form_validation->set_rules("title", "Task Detail", "trim|required|xss_clean"); 
		/*$this->form_validation->set_rules("property_ref", "Property Ref", "trim|required|xss_clean"); */  
		
		if($this->dbs_role_id ==1 || $this->dbs_role_id ==2){
			$this->form_validation->set_rules("assigned_to", "Assigned To", "trim|required|xss_clean");
		}
		
		$this->form_validation->set_rules("due_date", "Due Date", "trim|required|xss_clean"); 
		
		if($this->form_validation->run() == FALSE){
		// validation fail
			$this->load->view('tasks/operate_task_to_do',$data);
		}else if(isset($args1) && $args1!=''){
			 
			$datas = array('title' => $title,'lead_ref' => $lead_ref,'property_ref' => $property_ref,'assigned_to' => $assigned_to,'due_date' => $due_date,'due_timing' => $due_timing,'status' => $status,'updated_on' => $updated_on); 
			$res = $this->tasks_model->update_tasks_to_do_data($args1,$datas); 
			if(isset($res)){
				$this->session->set_flashdata('success_msg','Record updated successfully!');
			}else{
				$this->session->set_flashdata('error_msg','Error: while updating record!');
			}
			
				redirect("tasks/index");
		}else{ 
			$datas = array('title' => $title,'lead_ref' => $lead_ref,'property_ref' => $property_ref,'assigned_to' => $assigned_to,'due_date' => $due_date,'due_timing' => $due_timing,'status' => $status,'created_by' => $created_by,'created_on' => $created_on); 
			$res = $this->tasks_model->insert_tasks_to_do_data($datas); 
			if(isset($res)){
				$last_task_id = $this->db->insert_id(); 
					 
				$temp_usrs_arr = $this->general_model->get_user_info_by_id($assigned_to); 
				if($temp_usrs_arr){
					$mail_to = $temp_usrs_arr->email;
					$mail_to_name = $temp_usrs_arr->name;
					$tmp_user_type_id = $temp_usrs_arr->role_id;
					$details_url = 'tasks/index';
					$details_url = site_url($details_url); 
					
					$usrrole_name = '';
					$usrtyp_arr = $this->general_model->get_user_type_by_id($tmp_user_type_id);
					if($usrtyp_arr){
						$usrrole_name = $usrtyp_arr->name; 
					}	
					 
					$configs_arr = $this->general_model->get_configuration();
					$from_email = $configs_arr->email; 
					
					
					$config['mailtype'] = 'html';  
					$this->email->initialize($config); 

					$this->email->to($mail_to); 
					$this->email->from($from_email); 
					  
					$this->email->subject("A new task has been assigned – Buysellown CRM");
					$this->email->message("A new task has been assigned to you by {$mail_to_name} – {$usrrole_name} <a href=\"{$details_url}\" target=\"_blank\">{$lead_ref}</a>");  
					//$this->email->send();
				} 
					
				$this->session->set_flashdata('success_msg','Record inserted successfully!');
			}else{
				$this->session->set_flashdata('error_msg','Error: while inserting record!');
			} 
			
			redirect("tasks/index");
		} 	 
		
	}else{
		$this->load->view('tasks/operate_task_to_do',$data);
	}
}
 
	 
 	
	
	 function task_detail($args1=''){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','view',$this->dbs_user_role_id,'1');
		if($res_nums>0){ 
		 	$data['page_headings'] = 'Task Detail';
			if(isset($args1) && $args1!=''){ 
				$data['args1'] = $args1; 
				$data['record'] = $this->tasks_model->get_tasks_to_do_by_id($args1);
			}
			
			 $this->load->view('tasks/task_to_do_detail',$data);
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	} 
	
	
	function suggest_property_references($args1=''){ 
		if($this->dbs_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');  
		}
		
		if(isset($args1)){
			$txt =''; 
			$term = $args1 ; //$_GET['term'];
			$property_ref_arrs = array();  
			$rows_arrs = $this->general_model->get_gen_property_info_by_references($args1);
			
			if(isset($rows_arrs)){ 
				foreach($rows_arrs as $value => $rows_arr){ 
					$sug_ref_no = stripslashes($rows_arr->ref_no); 
					$property_ref_arrs[] = array("label"=>"$sug_ref_no","value"=>"$sug_ref_no");
				} 
				
				
				$ret_result = array();
				if(isset($property_ref_arrs) && count($property_ref_arrs)>0){
					foreach($property_ref_arrs as $property_ref_arr) {
						$propertyLabel = $property_ref_arr["label"];
						if(strpos(strtoupper($propertyLabel), strtoupper($term))!==false){
							array_push($ret_result, $property_ref_arr);
						}
					}
				}
				echo json_encode($ret_result); 
			}  
		}
	}  
	
	
		function get_property_by_ref($args1=''){ 
			if($this->dbs_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
				redirect('agent/operate_meetings_views');
			}
		
			if(isset($args1)){ 
				echo "<div class='well info'>";
				$rows_arr = $this->general_model->get_gen_property_info_by_ref($args1);
				if(isset($rows_arr)){
					$conf_currency_symbol = $this->general_model->get_gen_currency_symbol();
					$cstm_property_type = ($rows_arr->property_type==1) ? 'Sale' : 'Rent';
					echo "<strong>Property Type: </strong> ".$cstm_property_type."<br> <strong>Title: </strong>".stripslashes($rows_arr->title)."<br> <strong>Price (".$conf_currency_symbol."): </strong>".number_format($rows_arr->price,2,".",","); 
				}
				echo "</div>";  
			}
		}
		
		/* end of task */
	 
	} ?>