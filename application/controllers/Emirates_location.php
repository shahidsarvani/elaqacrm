<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Emirates_location extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				/* ok */ 
				$res_nums = $this->general_model->check_controller_permission_access('Emirates_location',$vs_user_role_id,'1');
				if($res_nums>0){
					/* ok */ 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}
			$this->load->model('emirates_model');
			$this->load->model('emirates_location_model');
			$this->load->model('admin_model'); 
			$this->load->model('general_model'); 
		} 
		   
		  
	/* emirate locations operations starts */
	function index(){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			
			$data['records'] = $this->emirates_location_model->get_all_emirate_with_locations();
			$data['page_headings']="Emirate Locations List";
			$this->load->view('emirates_location/index',$data); 
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		} 
	 }
	 
	 function trash(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','trash',$this->dbs_user_role_id,'1');  
		if($res_nums>0){
		
			if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1");
				$data['page_headings']="Emirate Locations List";
				$res = $this->emirates_location_model->trash_emirate_location($args1);  
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Your selected record has been deleted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while deleting record!');
				} 	
			 }  
			 
		}else{ 
			$this->load->view('no_permission_access'); 
		}   
	 }
	 
	  function trash_aj(){   
		  
		  $res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','trash',$this->dbs_user_role_id,'1');
		  if($res_nums>0){
		
			 if(isset($_POST["args1"]) && $_POST["args1"]>0){
				$args1 = $this->input->post("args1"); 
				$res = $this->emirates_location_model->trash_emirate_location($args1);
			 } 
			 
			 $data['records'] = $this->emirates_location_model->get_all_emirate_with_locations(); 
			 $this->load->view('emirates_location/index_aj',$data); 
		 
		 }else{ 
			$this->load->view('no_permission_access'); 
		 } 
	 }  
	 
	 function trash_multiple(){   
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','trash',$this->dbs_user_role_id,'1');  
		if($res_nums>0){
	  
			if(isset($_POST["multi_action_check"]) && count($_POST["multi_action_check"])>0){
				
				$del_checks = $_POST["multi_action_check"]; 
				foreach($del_checks as $args2){  
					$res = $this->emirates_location_model->trash_emirate_location($args2);   
				}  
			} 
			
			 $data['records'] = $this->emirates_location_model->get_all_emirate_with_locations(); 
			 $this->load->view('emirates_location/index_aj',$data);
			
		 }else{ 
			$this->load->view('no_permission_access'); 
		 }
	 } 
	 
	 
	 function add(){  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','add',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){ 
		
		$data['page_headings'] = 'Add Emirate Location';  
		
		$data['emirate_arrs'] = $this->emirates_model->get_all_emirates();
		
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
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('emirates_location/add',$data);
			}else{
					 
				$datas = array('name' => $name,'emirate_id' => $emirate_id,'status' => $status, 'description' => $description, 'sale_text' => $sale_text, 'rent_text' => $rent_text); 
				$res = $this->emirates_location_model->insert_emirate_location_data($datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record inserted successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while inserting record!');
				} 
					
					if(isset($_POST['saves_and_new'])){
						redirect("emirates_location/add");
					}else{
						redirect("emirates_location/index");	
					} 
				} 	 
				
			}else{
				$this->load->view('emirates_location/add',$data);
			}
			
		 }else{ 
			$this->load->view('no_permission_access'); 
		 }
	 } 
	 
	  function update($args1=''){   
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','update',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){
		
		if(isset($args1) && $args1!=''){ 
			$data['args1'] = $args1;//
			$data['page_headings'] = 'Update Emirate Location';
			$data['record'] = $this->emirates_location_model->get_emirate_location_by_id($args1);
		}else{
			$data['page_headings'] = 'Add Emirate Location';
		}  
		
		$data['emirate_arrs'] = $this->emirates_model->get_all_emirates();
		
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
			if($this->form_validation->run() == FALSE){
			// validation fail
				$this->load->view('emirates_location/update',$data);
			}else if(isset($args1) && $args1!=''){
				  
				$datas = array('name' => $name,'emirate_id' => $emirate_id,'status' => $status, 'description' => $description, 'sale_text' => $sale_text, 'rent_text' => $rent_text); 
				$res = $this->emirates_location_model->update_emirate_location_data($args1,$datas); 
				if(isset($res)){
					$this->session->set_flashdata('success_msg','Record updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg','Error: while updating record!');
				} 
				
					redirect("emirates_location/index");
				} 	 
				
			}else{
				$this->load->view('emirates_location/update',$data);
			}
			
		 }else{ 
			$this->load->view('no_permission_access'); 
		 }
	 }
	
	/* end of emirate locations */
	 
	  
	}
?>
