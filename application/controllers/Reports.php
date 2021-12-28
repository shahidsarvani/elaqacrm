<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Reports extends CI_Controller{

		public function __construct(){
			parent::__construct();
			
			$this->dbs_user_id = $vs_id = $this->session->userdata('us_id');
			$this->dbs_user_role_id = $this->dbs_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
			$this->load->model('general_model');
			if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id>=1)){
				  
				$res_nums = $this->general_model->check_controller_permission_access('Reports',$vs_user_role_id,'1');
				if($res_nums>0){
					 
				}else{
					redirect('/');
				} 
				
			}else{
				redirect('/');
			}
			 
			$this->load->model('categories_model');
			$this->load->model('reports_model'); 
			$this->load->model('admin_model');
			$this->load->model('general_model'); 
		}   
		 
		/* Reports operations starts */   
		function property_listing_report(){ 
			$vs_user_type_id = $this->session->userdata('us_role_id');
			$vs_id = $this->session->userdata('us_id');
			
			if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
				redirect('agent/operate_meetings_views');
			}  
			/* permission checks */   
			$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
			if($res_nums>0){
			
				$data['page_headings'] = "Listings Report"; 
				$data['page_sub_headings'] = "Listings Source Report"; 
				
				if($vs_user_type_id==2){ 
					$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
				}else{
					$arrs_field = array('role_id'=> '3'); 
				}
				
				$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
				
				$data['category_arrs'] = $this->categories_model->get_all_categories(); 
				
				$category_id_val = $property_type_val = $assigned_to_id_val = $from_date_val = $to_date_val = ''; 
				
				if($this->input->post('category_id')){
					$category_id_val = $this->input->post('category_id');
				}  
				
				if($this->input->post('property_type')){
					$property_type_val = $this->input->post('property_type');
				} 
				
				if($this->input->post('assigned_to_id')){
					$assigned_to_id_val = $this->input->post('assigned_to_id');
				} 
				
				if($this->input->post('from_date')){
					$from_date_val = $this->input->post('from_date');
				} 
				
				if($this->input->post('to_date')){
					$to_date_val = $this->input->post('to_date');
				}
				
				$data['ress'] = $data['row'] = $this->reports_model->total_property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val); 
				 
				$data['records'] = $this->reports_model->property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val); 
				
				$source_of_listing_val = $property_type_val = $assigned_to_id_val = $from_date2_val = $to_date2_val = '';   
				 
				if($this->input->post('sel_assigned2_to_val')){
					$assigned_to_id_val = $this->input->post('sel_assigned2_to_val');
				} 
				
				if($this->input->post('sel_property_type_val')){
					$property_type_val = $this->input->post('sel_property_type_val');
				}
				
				if($this->input->post('sel_source_of_listing_val')){
					$source_of_listing_val = $this->input->post('sel_source_of_listing_val');
				} 
				 
				if($this->input->post('from_date2')){
					$from_date2_val = $this->input->post('from_date2');
				} 
				
				if($this->input->post('to_date2')){
					$to_date2_val = $this->input->post('to_date2');
				} 
				//s_title CNT_NUMS
				$data['ress1'] = $data['row1'] = $this->reports_model->total_property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date2_val,$to_date2_val); 
				 
				$data['record1s'] = $this->reports_model->property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date2_val,$to_date2_val); 
				
				$this->load->view('reports/property_listing_report',$data); 
				//$this->load->view('reports/property_type_categories_report_list',$data); 
				
			}else{
				$datas['page_headings']="Invalid Access!";
				$this->load->view('no_permission_page',$datas);
			} 
		}   
	
	function property_type_categories_report_tbl(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
		
			$data['page_headings']="Listings Report"; 
			$data['page_sub_headings']="Listings Source Report";
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id' => '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id' => '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			
			$data['category_arrs'] = $this->categories_model->get_all_categories(); 
			$category_id_val = $property_type_val = $assigned_to_id_val = $from_date_val = $to_date_val = ''; 
			if($this->input->post('sel_category_val')){
				$category_id_val = $this->input->post('sel_category_val');
			}  
			if($this->input->post('sel_property_type_val')){
				$property_type_val = $this->input->post('sel_property_type_val');
			} 
			
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			}
			
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			}
			 
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date');
			} 
			
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date');
			} 
			
			$data['ress'] = $data['row'] = $this->reports_model->total_property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val); 
			 
			$data['records'] = $this->reports_model->property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val);  
			  
			  
			$this->load->view('reports/property_type_categories_report_tbl',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	
	
	
	function property_type_categories_report_tbl2(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_sub_headings']="Listings Source Report"; 
			  
			$source_of_listing_val = $property_type_val = $assigned_to_id_val = $from_date2_val = $to_date2_val = '';   
			 
			if($this->input->post('sel_assigned2_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned2_to_val');
			} 
			
			if($this->input->post('sel_property_type_val')){
				$property_type_val = $this->input->post('sel_property_type_val');
			}
			
			if($this->input->post('sel_source_of_listing_val')){
				$source_of_listing_val = $this->input->post('sel_source_of_listing_val');
			} 
			 
			if($this->input->post('from_date2')){
				$from_date2_val = $this->input->post('from_date2');
			} 
			
			if($this->input->post('to_date2')){
				$to_date2_val = $this->input->post('to_date2');
			} 
			//s_title
			$data['ress1'] = $data['row1'] = $this->reports_model->total_property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date2_val,$to_date2_val); 
			 
			$data['record1s'] = $this->reports_model->property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date2_val,$to_date2_val);  
		
			$this->load->view('reports/property_type_categories_report_tbl2',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	function property_type_categories_report_chart2(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_sub_headings']="Listings Source Report"; 
			  
			$source_of_listing_val = $property_type_val = $assigned_to_id_val = $from_date2_val = $to_date2_val = '';   
			 
			if($this->input->post('sel_assigned2_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned2_to_val');
			} 
			
			if($this->input->post('sel_property_type_val')){
				$property_type_val = $this->input->post('sel_property_type_val');
			}
			
			if($this->input->post('sel_source_of_listing_val')){
				$source_of_listing_val = $this->input->post('sel_source_of_listing_val');
			} 
			 
			if($this->input->post('from_date2')){
				$from_date2_val = $this->input->post('from_date2');
			} 
			
			if($this->input->post('to_date2')){
				$to_date2_val = $this->input->post('to_date2');
			} 
			 
			$data['ress1'] = $data['row1'] = $this->reports_model->total_property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date2_val,$to_date2_val); 
			 
			$data['record1s'] = $this->reports_model->property_type_source_report($assigned_to_id_val,$source_of_listing_val,$property_type_val,$from_date2_val,$to_date2_val);  
		
			$this->load->view('reports/property_type_categories_report_chart2',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	
	
	
	function property_type_categories_report_chart(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Listings Report"; 
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			
			$data['category_arrs'] = $this->categories_model->get_all_categories(); 
			$category_id_val = $property_type_val = $assigned_to_id_val = $from_date_val = $to_date_val = '';  
			if($this->input->post('sel_category_val')){
				$category_id_val = $this->input->post('sel_category_val');
			}  
			if($this->input->post('sel_property_type_val')){
				$property_type_val = $this->input->post('sel_property_type_val');
			} 
			
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			} 
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date');
			} 
			
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date');
			}  
			
			$data['ress'] = $data['row'] = $this->reports_model->total_property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val); 
			 
			$data['records'] = $this->reports_model->property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val,$from_date_val,$to_date_val);  
		
			$this->load->view('reports/property_type_categories_report_chart',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	function property_type_categories_report_detail(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Listings Report"; 
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 

			
			$data['category_arrs'] = $this->categories_model->get_all_categories(); 
			$category_id_val = $property_type_val = $assigned_to_id_val = ''; 
			if($this->input->post('category_id')){
				$category_id_val = $this->input->post('category_id');
			}  
			if($this->input->post('property_type')){
				$property_type_val = $this->input->post('property_type');
			} 
			
			if($this->input->post('assigned_to_id')){
				$assigned_to_id_val = $this->input->post('assigned_to_id');
			} 
			
			$data['row'] = $this->reports_model->total_property_type_categories_report($assigned_to_id_val); 
			
			$data['records'] = $this->reports_model->property_type_categories_report($assigned_to_id_val,$category_id_val,$property_type_val);  
		
			$this->load->view('reports/property_type_categories_report_detail',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
	
	
	function meetings_viewing_report(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Meetings & Viewing Report"; 
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}  
			
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			 
			$from_date_val = $to_date_val = $assigned_to_id_val = '';	
			$data['from_date_val'] = $data['to_date_val'] = $data['assigned_to_id_val'] ='';
			
			if(isset($_POST['from_date'])){
				$data['from_date_val'] = $from_date_val = $_POST['from_date'];
			}  
			
			if(isset($_POST['to_date'])){
				$data['to_date_val'] = $to_date_val = $_POST['to_date'];
			}
			 
			if(isset($_POST['assigned_to_id']) && ($_POST['assigned_to_id'])>0){
				$data['assigned_to_id_val'] =  $assigned_to_id_val = $_POST['assigned_to_id'];
			}
			
			$data['total_nos_meetings'] =  $total_nos_meetings = $this->reports_model->get_total_custom_meetings_nums($assigned_to_id_val,$from_date_val,$to_date_val); 
			
			
			$data['total_nos_views'] = $total_nos_views = $this->reports_model->get_total_custom_views_nums($assigned_to_id_val,$from_date_val,$to_date_val);  
			
			$this->load->view('reports/meetings_viewing_report',$data); 
			//$this->load->view('reports/property_meetings_views_report_list',$data);  
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
	

	
	function property_meetings_views_report_tbl(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Views Meetings Report"; 
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['assigned_to_id_val'] = '';
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
				if($assigned_to_id_val >0){
					$data['assigned_to_id_val'] = $assigned_to_id_val;
				}
			}
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date');
				$data['from_date_val'] = $from_date_val;
			} 
			
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date');
				$data['to_date_val'] = $to_date_val;
			} 
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			 
			$this->load->view('reports/property_meetings_views_report_tbl',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	
	
	function property_meetings_views_report_chart(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Views Meetings Report"; 
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['assigned_to_id_val'] = '';
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
				if($assigned_to_id_val >0){
					$data['assigned_to_id_val'] = $assigned_to_id_val;
				}
			}
			
			if($this->input->post('from_date')){
				$from_date_val = $this->input->post('from_date');
				$data['from_date_val'] = $from_date_val;
			} 
			
			if($this->input->post('to_date')){
				$to_date_val = $this->input->post('to_date');
				$data['to_date_val'] = $to_date_val;
			} 
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			 
			$this->load->view('reports/property_meetings_views_report_chart',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	
	
	function property_meetings_views_report_detail(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Views Meetings Report"; 
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			 
			$this->load->view('reports/property_meetings_views_report_detail',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
	
	
	function deals_reports(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Deals Report";  
			$data['conf_currency_symbol'] = $this->general_model->get_gen_currency_symbol();  
			$assigned_to_id_val = $types_val = $status_val = ''; 
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			
			
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			}
			  
			if($this->input->post('types')){
				$types_val = $this->input->post('types');
			}  

			
			if($this->input->post('status')){
				$status_val = $this->input->post('status');
			} 
			
			$from_date1 = $to_date1 = '';	
			if(isset($_POST['from_date'])){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			if(isset($_POST['to_date'])){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			} 
			
			$data['row'] = $this->reports_model->get_all_total_property_deals_report($assigned_to_id_val,$types_val,$status_val,$from_date1,$to_date1); 
			
			$data['records'] = $this->reports_model->get_cstm_property_deals_report_list($assigned_to_id_val,$types_val,$status_val,$from_date1,$to_date1);  
			
			
			$this->load->view('reports/deals_reports',$data); 
			//$this->load->view('reports/property_deals_report_list',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}    
	
	
	function property_deals_report_tbl(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			   
			$assigned_to_id_val = $types_val = $status_val = $from_date1 = $to_date1 = ''; 
			
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			}
			
			if($this->input->post('sel_types_val')){
				$types_val = $this->input->post('sel_types_val');
			}  
			
			if($this->input->post('sel_status_val')){
				$status_val = $this->input->post('sel_status_val');
			} 
			 	
			if(isset($_POST['from_date'])){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			if(isset($_POST['to_date'])){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			} 
			
			$data['row'] = $this->reports_model->get_all_total_property_deals_report($assigned_to_id_val,$types_val,$status_val,$from_date1,$to_date1); 
			
			$data['records'] = $this->reports_model->get_cstm_property_deals_report_list($assigned_to_id_val,$types_val,$status_val,$from_date1,$to_date1);  
		
			$this->load->view('reports/property_deals_report_tbl',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	
	function property_deals_report_chart(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			 
			$assigned_to_id_val = $types_val = $status_val = $from_date1 = $to_date1 = ''; 
			
			if($this->input->post('sel_assigned_to_val')){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			}
			
			if($this->input->post('sel_types_val')){
				$types_val = $this->input->post('sel_types_val');
			}  
			
			if($this->input->post('sel_status_val')){
				$status_val = $this->input->post('sel_status_val');
			} 
			 	
			if(isset($_POST['from_date'])){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			if(isset($_POST['to_date'])){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			} 
			
			$data['row'] = $this->reports_model->get_all_total_property_deals_report($assigned_to_id_val,$types_val,$status_val,$from_date1,$to_date1); 
			
			$data['records'] = $this->reports_model->get_cstm_property_deals_report_list($assigned_to_id_val,$types_val,$status_val,$from_date1,$to_date1);  
		
			$this->load->view('reports/property_deals_report_chart',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	
	function property_deals_report_detail(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');

		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			
			$data['page_headings']="Deals Report";   
			
			$types_val = $status_val = ''; 
			if($this->input->post('types')){
				$types_val = $this->input->post('types');
			}  
			
			if($this->input->post('status')){
				$status_val = $this->input->post('status');
			} 
			
			$from_date1 = $to_date1 = '';	
			if(isset($_POST['from_date'])){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			if(isset($_POST['to_date'])){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			} 
			    
			
			$data['row'] = $this->reports_model->get_all_total_property_deals_report($types_val,$status_val,$from_date1,$to_date1); 
			
			$data['records'] = $this->reports_model->get_cstm_property_deals_report_list($types_val,$status_val,$from_date1,$to_date1);   
		
			$this->load->view('reports/property_deals_report_detail',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}  
	 
	function leads_report(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Leads Report";   
			$data['page_sub_headings']="Leads Source Report";
			
			if($vs_user_type_id==2){ 
				$arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
			}else{
				$arrs_field = array('role_id'=> '3'); 
			}
			
			$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field); 
			 
			$assigned_to_id_val = $types_val = $from_date1 = $to_date1 =''; 
			if($this->input->post('lead_type')){
				$types_val = $this->input->post('lead_type');
			}
			
			if($this->input->post('assigned_to_id')){
				$assigned_to_id_val = $this->input->post('assigned_to_id');
			} 
			
			$from_date1 = $to_date1 = '';	
			if(isset($_POST['from_date'])){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			if(isset($_POST['to_date'])){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			}
			  
			
			$data['row'] = $this->reports_model->get_all_total_property_leads_report($assigned_to_id_val,$types_val,$from_date1,$to_date1); 
			
			$data['records'] = $this->reports_model->get_cstm_property_leads_report_list($assigned_to_id_val,$types_val,$from_date1,$to_date1);  
			 
			$assigned_to_id_val2 = $source_of_listing_val = $from_date2 = $to_date2 =''; 
			   
			if($this->input->post('sel_assigned_to_val2')){
				$assigned_to_id_val2 = $this->input->post('sel_assigned_to_val2');
			} 
			
			if($this->input->post('sel_source_of_listing_val')){
				$source_of_listing_val = $this->input->post('sel_source_of_listing_val');
			}
			  
			if(isset($_POST['from_date2'])){
				$from_date2 = $data['from_date2'] = $_POST['from_date2'];
			}  
			if(isset($_POST['to_date2'])){
				$to_date2 = $data['to_date2'] = $_POST['to_date2'];
			}
			 
			$data['row2'] = $this->reports_model->get_all_total_agent_property_leads_source_report($assigned_to_id_val2);
			
			$data['row1'] = $this->reports_model->get_all_total_property_leads_source_report($assigned_to_id_val2,$source_of_listing_val,$from_date2,$to_date2); 
			
			$data['record1s'] = $this->reports_model->get_cstm_property_leads_report_source_list($assigned_to_id_val2,$source_of_listing_val,$from_date2,$to_date2);
			 
			 $this->load->view('reports/leads_report',$data);
			//$this->load->view('reports/property_leads_report_list',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}  
	
	
	
	function property_leads_report_tbl(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Leads Report";     
			 
			$assigned_to_id_val = $types_val = $from_date1 = $to_date1 = ''; 
			
			if(isset($_POST['sel_lead_type_val']) && strlen($_POST['sel_lead_type_val'])>0){
				$types_val = $this->input->post('sel_lead_type_val');
			} 
			 
			if(isset($_POST['sel_assigned_to_val']) && $_POST['sel_assigned_to_val']>0){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			}  
			 
			if(isset($_POST['from_date']) && strlen($_POST['from_date'])>0){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			 
			if(isset($_POST['to_date']) && strlen($_POST['to_date'])>0){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			} 
			  
			$data['row'] = $this->reports_model->get_all_total_property_leads_report($assigned_to_id_val,$types_val,$from_date1,$to_date1); 
			
			$data['records'] = $this->reports_model->get_cstm_property_leads_report_list($assigned_to_id_val,$types_val,$from_date1,$to_date1);  
		 
			$this->load->view('reports/property_leads_report_tbl',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
	
	function property_leads_report_tbl2(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			
			$assigned_to_id_val2 = $source_of_listing_val = $from_date2 = $to_date2 =''; 
			   
			if($this->input->post('sel_assigned_to_val2')){
				$assigned_to_id_val2 = $this->input->post('sel_assigned_to_val2');
			} 
			
			if($this->input->post('sel_source_of_listing_val')){
				$source_of_listing_val = $this->input->post('sel_source_of_listing_val');
			}
			  
			if(isset($_POST['from_date2'])){
				$from_date2 = $data['from_date2'] = $_POST['from_date2'];
			}  
			if(isset($_POST['to_date2'])){
				$to_date2 = $data['to_date2'] = $_POST['to_date2'];
			}
			 
			$data['row2'] = $this->reports_model->get_all_total_agent_property_leads_source_report($assigned_to_id_val2);
			
			$data['row1'] = $this->reports_model->get_all_total_property_leads_source_report($assigned_to_id_val2,$source_of_listing_val,$from_date2,$to_date2); 
			
			$data['record1s'] = $this->reports_model->get_cstm_property_leads_report_source_list($assigned_to_id_val2,$source_of_listing_val,$from_date2,$to_date2);
		 
			$this->load->view('reports/property_leads_report_tbl2',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
	
	
	function property_leads_report_chart(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Leads Report";     
			 
			$assigned_to_id_val = $types_val = $from_date1 = $to_date1 = ''; 
			
			if(isset($_POST['sel_lead_type_val']) && strlen($_POST['sel_lead_type_val'])>0){
				$types_val = $this->input->post('sel_lead_type_val');
			}
			 
			if(isset($_POST['sel_assigned_to_val']) && $_POST['sel_assigned_to_val']>0){
				$assigned_to_id_val = $this->input->post('sel_assigned_to_val');
			}  
			 
			if(isset($_POST['from_date']) && strlen($_POST['from_date'])>0){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			 
			if(isset($_POST['to_date']) && strlen($_POST['to_date'])>0){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			} 
			  
			$data['row'] = $this->reports_model->get_all_total_property_leads_report($assigned_to_id_val,$types_val,$from_date1,$to_date1); 
			
			$data['records'] = $this->reports_model->get_cstm_property_leads_report_list($assigned_to_id_val,$types_val,$from_date1,$to_date1);  
		 
			$this->load->view('reports/property_leads_report_chart',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
	
	function property_leads_report_chart2(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			$data['page_headings']="Leads Report";     
			 
			$assigned_to_id_val2 = $source_of_listing_val = $from_date2 = $to_date2 =''; 
			   
			if($this->input->post('sel_assigned_to_val2')){
				$assigned_to_id_val2 = $this->input->post('sel_assigned_to_val2');
			} 
			
			if($this->input->post('sel_source_of_listing_val')){
				$source_of_listing_val = $this->input->post('sel_source_of_listing_val');
			}
			  
			if(isset($_POST['from_date2'])){
				$from_date2 = $data['from_date2'] = $_POST['from_date2'];
			}  
			if(isset($_POST['to_date2'])){
				$to_date2 = $data['to_date2'] = $_POST['to_date2'];
			}
			 
			$data['row2'] = $this->reports_model->get_all_total_agent_property_leads_source_report($assigned_to_id_val2); 
			
			$data['row1'] = $this->reports_model->get_all_total_property_leads_source_report($assigned_to_id_val2,$source_of_listing_val,$from_date2,$to_date2); 
			
			$data['record1s'] = $this->reports_model->get_cstm_property_leads_report_source_list($assigned_to_id_val2,$source_of_listing_val,$from_date2,$to_date2);
		 
			$this->load->view('reports/property_leads_report_chart2',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	} 
	
	function property_leads_report_detail(){ 
		$vs_user_type_id = $this->session->userdata('us_role_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($this->dbs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		/* permission checks */  
		$res_nums =  $this->general_model->check_controller_method_permission_access('Reports','index',$this->dbs_user_role_id,'1');
		if($res_nums>0){
			
			$data['page_headings']="Leads Report";  
			 
			$types_val = ''; 
			if($this->input->post('lead_type')){
				$types_val = $this->input->post('lead_type');
			}
			
			$from_date1 = $to_date1 = '';	
			if(isset($_POST['from_date'])){
				$from_date1 = $data['from_date'] = $_POST['from_date'];
			}  
			if(isset($_POST['to_date'])){
				$to_date1 = $data['to_date'] = $_POST['to_date'];
			}  
			 
			$data['row'] = $this->reports_model->get_all_total_property_leads_report($types_val,$from_date1,$to_date1); 								    
			
			$data['records'] = $this->reports_model->get_cstm_property_leads_report_list($types_val,$from_date1,$to_date1);   
		
			$this->load->view('reports/property_leads_report_detail',$data); 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}    
		  
		/* end of Reports */   	 
	  
	}
?>
