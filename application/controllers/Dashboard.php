<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Dashboard extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->login_vs_user_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				/* ok */
				
				$res_nums = $this->general_model->check_controller_permission_access('Dashboard',$vs_user_role_id,'1');
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
			$this->load->model('general_model'); 
		}  
		
		function index(){
			$res_nums = $this->general_model->check_controller_method_permission_access('Dashboard','index',$this->dbs_user_role_id,'1');  
			if($res_nums>0){
			  
				$datas = array();
				$datas['page_headings']="Dashboard"; 
				
				$this->load->view('dashboard/index',$datas);
				
			 }else{ 
				$this->load->view('no_permission_access'); 
			}
		} 
		
		 
	  
	}
?>
