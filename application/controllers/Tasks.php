<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tasks extends CI_Controller{

    public function __construct(){
        parent::__construct();
		
		$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
		$this->login_vs_role_id = $this->dbs_role_id= $vs_role_id = $this->session->userdata('us_role_id');
		
		if(isset($vs_id) && (isset($vs_role_id) && $vs_role_id>=1)){
			/* ok */
		}else{
			redirect('/');
		}
		
		$this->load->helper(array('form','url','security','utility','html'));
        $this->load->library(array('form_validation','user_agent','email')); 
        $this->load->model('admin_model');
		$this->load->model('tasks_model');
		$this->load->model('general_model'); 
		$perms_arrs = array('role_id'=> $vs_role_id);
		
		$this->load->library('Ajax_pagination');
		$this->perPage = 25;
    }  
	
	
	function tasks(){  
		
		$datas['page_headings']="Tasks to Do";
		$assigned_to_id_val = $status_val = $sel_from_date = $sel_to_date = '';
		
		if(isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']>0){
			$assigned_to_id_val = $this->input->post("assigned_to_id"); 
		}
		 
		if(isset($_POST['from_date']) && strlen($_POST['from_date'])>0){
			$sel_from_date = $this->input->post("from_date"); 
		}  
		 
		if(isset($_POST['to_date']) && strlen($_POST['to_date'])>0){ 
			$sel_to_date = $this->input->post("to_date");   
		} 
		
		if(isset($_POST['status']) && $_POST['status'] >=0){
			$status_val = $this->input->post("status"); 
		}
		 
		 $datas['user_arrs'] = $this->general_model->get_gen_all_users_assigned();
		 $datas['records'] = $this->tasks_model->get_all_tasks_to_do($assigned_to_id_val,$status_val,$sel_from_date,$sel_to_date);
		 $this->load->view('tasks/tasks_list',$datas);
	}
	
	
	
	
	function tasks_list(){
		$data['page_headings'] = "Task to Do List";
		$data['user_arrs'] = $this->general_model->get_gen_all_users_assigned();
		$sel_module_id = $sel_user_type_id =''; 
		$paras_arrs = array();	
		
		
		if($this->input->post('sel_per_page_val')){
			$per_page_val = $this->input->post('sel_per_page_val'); 
			$_SESSION['tmp_per_page_val'] = $per_page_val;  
			
		}else if(isset($_SESSION['tmp_per_page_val'])){
				unset($_SESSION['tmp_per_page_val']);
			} 
		
		
		if($this->input->post('sel_assigned_to_val')){
			$assigned_to_val = $this->input->post('sel_assigned_to_val'); 
			$_SESSION['tmp_assigned_to_val'] = $assigned_to_val;
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_val" => $assigned_to_val));
			
		}else if(isset($_SESSION['tmp_assigned_to_val'])){
				unset($_SESSION['tmp_assigned_to_val']);
			} 
			
			
		if($this->input->post('sel_status_val')){
			$status_val = $this->input->post('sel_status_val'); 
			$_SESSION['tmp_status_val'] = $status_val;
			$paras_arrs = array_merge($paras_arrs, array("status_val" => $status_val));
			
		}else if(isset($_SESSION['tmp_status_val'])){
				unset($_SESSION['tmp_status_val']);
			}		
		
		
		if($this->input->post('sel_from_date_val')){
			$from_date_val = $this->input->post('sel_from_date_val'); 
			$_SESSION['tmp_from_date_val'] = $from_date_val;
			$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
			
		}else if(isset($_SESSION['tmp_from_date_val'])){
				unset($_SESSION['tmp_from_date_val']);
			}	
			
			
		if($this->input->post('sel_to_date_val')){
			$to_date_val = $this->input->post('sel_to_date_val'); 
			$_SESSION['tmp_to_date_val'] = $to_date_val;
			$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
			
		}else if(isset($_SESSION['tmp_to_date_val'])){
				unset($_SESSION['tmp_to_date_val']);
			}		
			
		
		if(isset($_SESSION['tmp_per_page_val'])){
			$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
		}else{
			$show_pers_pg = $this->perPage;
		}
		
		//total rows count
		$totalRec = count($this->tasks_model->get_all_tasks_to_do($paras_arrs));
		
		//pagination configuration
		$config['target']      = '#fetch_dya_list';
		$config['base_url']    = site_url('/tasks/tasks_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
		
	    $data['records'] = $this->tasks_model->get_all_tasks_to_do($paras_arrs);
		  
		$this->load->view('tasks/tasks_list',$data); 
	 
	}


	function tasks_list2(){
	  
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
			
			
		if(isset($_POST['sel_assigned_to_val'])){
			$assigned_to_val = $this->input->post('sel_assigned_to_val');  
			if($assigned_to_val >0){
				$_SESSION['tmp_assigned_to_val'] = $assigned_to_val;
			 $paras_arrs = array_merge($paras_arrs, array("assigned_to_val" => $assigned_to_val)); 
			}else{
				unset($_SESSION['tmp_assigned_to_val']);
			}
			
		}else if(isset($_SESSION['tmp_assigned_to_val'])){  ///
			$assigned_to_val = $_SESSION['tmp_assigned_to_val']; 
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_val" => $assigned_to_val));
		}  
	 
	 
	 	if(isset($_POST['sel_status_val'])){
			$status_val = $this->input->post('sel_status_val');  
			if($status_val >0){
				$_SESSION['tmp_status_val'] = $status_val;
			 	$paras_arrs = array_merge($paras_arrs, array("status_val" => $status_val)); 
			}else{
				unset($_SESSION['tmp_status_val']);
			}
			
		}else if(isset($_SESSION['tmp_status_val'])){
			$status_val = $_SESSION['tmp_status_val']; 
			$paras_arrs = array_merge($paras_arrs, array("status_val" => $status_val));
		}   
			
		
		if(isset($_POST['sel_from_date_val'])){
			$from_date_val = $this->input->post('sel_from_date_val');  
			if(strlen($from_date_val) >0){
				$_SESSION['tmp_from_date_val'] = $from_date_val;
			 	$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val)); 
			}else{
				unset($_SESSION['tmp_from_date_val']);
			}
			
		}else if(isset($_SESSION['tmp_from_date_val'])){
			$from_date_val = $_SESSION['tmp_from_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("from_date_val" => $from_date_val));
		} 
		  
		
	 	if(isset($_POST['sel_to_date_val'])){
			$to_date_val = $this->input->post('sel_to_date_val');  
			if(strlen($to_date_val) >0){
				$_SESSION['tmp_to_date_val'] = $to_date_val;
			 	$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val)); 
			}else{
				unset($_SESSION['tmp_to_date_val']);
			}
			
		}else if(isset($_SESSION['tmp_to_date_val'])){
			$to_date_val = $_SESSION['tmp_to_date_val']; 
			$paras_arrs = array_merge($paras_arrs, array("to_date_val" => $to_date_val));
		} 
		 
		
		if(isset($_SESSION['tmp_per_page_val'])){
			$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
		}else{
			$show_pers_pg = $this->perPage;
		}
		 
		//total rows count 
		$totalRec = count($this->tasks_model->get_all_tasks_to_do($paras_arrs));
		//pagination configuration
		$config['target']      = '#fetch_dya_list';
		$config['base_url']    = site_url('/tasks/tasks_list2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array('start' => $offset, 'limit'=> $show_pers_pg)); 
	    $data['records'] = $this->tasks_model->get_all_tasks_to_do($paras_arrs);
		   
		$this->load->view('tasks/tasks_list2',$data); 
	
	}
	 
	function task_to_do_detail($args1=''){  
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;
			$record_arr = $this->tasks_model->get_tasks_to_do_by_id($args1);
			$data['record'] = $record_arr;
			$data['page_headings'] = 'Task to Do - Detail';  
			$updated_on = date('Y-m-d H:i:s'); 
			$tmp_assignid = $this->session->userdata('us_id'); 
			
			
			if((isset($args1) && $args1!='') && (isset($record_arr) && $record_arr->assigned_to==$tmp_assignid)){
				$datas = array('updated_on' => $updated_on,'is_new' => '0'); 
				$this->tasks_model->update_tasks_to_do_data($args1,$datas); 	   
			}	 
			$this->load->view('tasks/task_to_do_detail',$data);
		}  
	}  
	
	function suggest_property_references($args1=''){  
		
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
		 
		if(isset($args1)){ 
			echo "<div class='well info'>";
			$rows_arr = $this->general_model->get_gen_property_info_by_ref($args1);
			if(isset($rows_arr)){
				$cstm_property_type = ($rows_arr->property_type==1) ? 'Sale' : 'Rent';
				echo "<strong>Property Type: </strong> ".$cstm_property_type."<br> <strong>Title: </strong>".stripslashes($rows_arr->title)."<br> <strong>Price : </strong>".number_format($rows_arr->price,2,".",","); 
			}
			echo "</div>"; 
			
		}
		
	}
	
	function operate_task_to_do($args1=''){ 
		 
		$this->load->model('admin_model');
		$created_on = $updated_on = date('Y-m-d H:i:s'); 
		$tmp_assignid = $this->session->userdata('us_id'); 
		
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
			if($this->login_vs_role_id >=3){
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
			
			if($this->login_vs_role_id ==1 || $this->login_vs_role_id ==2){
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
				
					redirect("tasks/tasks_list");
			}else{ 
				$datas = array('title' => $title,'lead_ref' => $lead_ref,'property_ref' => $property_ref,'assigned_to' => $assigned_to,'due_date' => $due_date,'due_timing' => $due_timing,'status' => $status,'created_by' => $created_by,'created_on' => $created_on); 
				$res = $this->tasks_model->insert_tasks_to_do_data($datas); 
				if(isset($res)){
					$last_task_id = $this->db->insert_id(); 
					
					
				$temp_usrs_arr = $this->general_model->get_user_info_by_id($assigned_to);
				if(isset($temp_usrs_arr) && count($temp_usrs_arr)>0){
					$mail_to = $temp_usrs_arr->email;
					$mail_to_name = $temp_usrs_arr->name;
					$tmp_user_type_id = $temp_usrs_arr->role_id;
					$details_url = 'tasks/tasks_list';
					$details_url = site_url($details_url); 
					
					$usrrole_name = '';
					$usrtyp_arr = $this->admin_model->get_role_by_id($tmp_user_type_id);
					if(isset($usrtyp_arr) && count($usrtyp_arr)>0){
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
					$this->email->send();
				}
					
					
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
				 
				if(isset($_POST['saves_and_new'])){
					redirect("tasks/operate_task_to_do");
				}else{
					redirect("tasks/tasks_list");	
				}
			} 	 
			
		}else{
			$this->load->view('tasks/operate_task_to_do',$data);
		}
	}
	
	
	function operate_agent_task_to_do($args1=''){  
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;
			$data['record'] = $this->tasks_model->get_tasks_to_do_by_id($args1);
			$data['page_headings'] = 'Update Task to Do';
		}else{
			$data['page_headings'] = 'Add Task to Do';
		}
		
		if(isset($_POST) && !empty($_POST)){
		 
			$comments = $this->input->post("comments");   
			$percentage_of_completion = $this->input->post("percentage_of_completion");  
			$created_on = $updated_on = date('Y-m-d H:i:s'); 
			
			$this->form_validation->set_rules("comments", "Comments", "trim|required|xss_clean");  
			//$this->form_validation->set_rules("percentage_of_completion", "Percentage of Completion", "trim|required|xss_clean");   
			
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('tasks/operate_agent_task_to_do',$data);
			}else if(isset($args1) && $args1!=''){
				 
				$datas = array('comments' => $comments,'percentage_of_completion' => $percentage_of_completion,'updated_on' => $updated_on); 
				$res = $this->tasks_model->update_tasks_to_do_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				}
				
					redirect("tasks/tasks_list");
			}	 
			
		}else{
			$this->load->view('tasks/operate_agent_task_to_do',$data);
		}
	}
	
	
	 function trash_task_to_do($args2=''){  
		$data['page_headings']="Tasks to Do";
		$this->tasks_model->trash_tasks_to_do($args2);
		redirect('tasks/tasks_list');   
	 }
	 
	 
	  function trash_task_to_do_aj(){  
		
		if(isset($_POST["args1"]) && $_POST["args1"]>0){
			$args1 = $this->input->post("args1"); 
			$this->tasks_model->trash_tasks_to_do($args1); 
		 }  
		 
		 $this->tasks_list2();
	 } 
	 
		
 } ?>