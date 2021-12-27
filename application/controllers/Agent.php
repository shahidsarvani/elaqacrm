<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Agent extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				  
				/*$res_nums = $this->general_model->check_controller_permission_access('Categories',$vs_user_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				}*/ 
				
			}else{
				redirect('/');
			}
			 
			$this->load->model('agent_model');
			$this->load->model('portals_model'); 
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}   
		 
		/* agents operations starts */ 
		function index(){ 
			if($this->agent_chk_ystrdy_meeting==0){
				redirect('agent/operate_meetings_views');
			}
				
			if($this->dbs_user_role_id==3){
				$datas = array();
				$this->load->model('properties_model');
				$datas['page_headings']="Dashboard";  
				$datas['nos_of_active_properties'] = $this->agent_model->get_agent_active_properties();
				$datas['nos_of_archived_properties'] = $this->agent_model->get_agent_archived_properties(); 
				
				//total rows count
				$totalRec = count($this->properties_model->get_all_cstm_properties());
				//pagination configuration
				$config['target']      = '#fetch_properties_list';
				$config['base_url']    = site_url('/agent/index2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				
				$this->ajax_pagination->initialize($config);
				
				$datas['records'] = $this->properties_model->get_all_cstm_properties(array('limit'=>$this->perPage)); 
				
				$this->load->view('agent/index',$datas);
			
			}else if($this->dbs_user_role_id==2){
				redirect("manager/index");
			 }else if($this->dbs_user_role_id==1){
				redirect("admin/index");
			 }	 
		}  
	
		function index2(){ 	
			if($this->dbs_user_role_id==3){ 
				$datas = array();
				$page = $this->input->post('page');
				if(!$page){
					$offset = 0;
				}else{
					$offset = $page;
				}  
				$datas['page'] = $page;
				
			 
				 $this->load->model('admin_model');
				 $datas['page_headings']="Dashboard";  
				 $datas['nos_of_active_properties'] = $this->agent_model->get_agent_active_properties();
				 $datas['nos_of_archived_properties'] = $this->agent_model->get_agent_archived_properties();
				 //$datas['records'] = $this->admin_model->get_cstm_all_properties('','','','','','','','');
				 
				 //total rows count
				$totalRec = count($this->properties_model->get_all_cstm_properties());
				//pagination configuration
				$config['target']      = '#fetch_properties_list';
				$config['base_url']    = site_url('/agent/index2');
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				
				$this->ajax_pagination->initialize($config);
				 
				$datas['records'] = $this->properties_model->get_all_cstm_properties(array('start'=>$offset,'limit'=>$this->perPage)); 
				 
				 $this->load->view('agent/index2',$datas);
					 
				 }else if($this->dbs_user_role_id==2){
					redirect("manager/index");
				 }else if($this->dbs_user_role_id==1){
					redirect("admin/index");
				 }	 
			}  
		  
			function operate_meetings_views(){ 
				$curr_date = date("Y-m-d");
				$prev_date = strtotime(date("Y-m-d", strtotime($curr_date))." -1 day");
				$prev_date = date("Y-m-d",$prev_date);  
				$frmt_prev_date = date("d F, Y",strtotime($prev_date)); 
				
				$data['page_headings'] = $frmt_prev_date.': Meetings and Views';
				 
				if(isset($_POST) && !empty($_POST)){
				
					// get form input
					$nos_of_meetings = $this->input->post("nos_of_meetings");  
					$nos_of_views = $this->input->post("nos_of_views");   
					// form validation
					$this->form_validation->set_rules("nos_of_meetings", "No. of Meetings", "trim|required|numeric|less_than[16]|xss_clean");  
					$this->form_validation->set_rules("nos_of_views", "No. of Views", "trim|required|numeric|less_than[16]|xss_clean");
					
					if($this->form_validation->run() == FALSE){
					// validation fail
						$this->load->view('agent/operate_meetings_views',$data);
					}else{ 
						$added_on = date("Y-m-d H:i:s"); 
						$vs_id = $this->session->userdata('us_id');  	 
						$datas = array('user_id' => $vs_id,'nos_of_meetings' => $nos_of_meetings,'nos_of_views' => $nos_of_views,'dated' => $prev_date,'added_on' => $added_on);
						$res = $this->agent_model->insert_nos_of_meetings_views_data($datas); 
						if(isset($res)){
							$this->session->set_flashdata('success_msg','Record inserted successfully!');
						}else{
							$this->session->set_flashdata('error_msg','Error: while inserting record!');
						} 
						
						redirect("agent/index");
					} 	 
					
				}else{
					$this->load->view('agent/operate_meetings_views',$data);
				}
			} 
		
			function agent_meetings_views_list(){ 
				if($this->agent_chk_ystrdy_meeting==0){
					redirect('agent/operate_meetings_views');
				}
				$data['page_headings']="Agent Meetings & Views List";
				$vs_id = $this->session->userdata('us_id');  
				$data['records'] = $this->agent_model->get_agent_meetings_views_list($vs_id);
				$this->load->view('agent/agent_meetings_views_list',$data); 
			} 
			
		/* agent functions ends	*/
		  
	}
?>
