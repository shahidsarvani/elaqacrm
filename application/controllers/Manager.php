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
