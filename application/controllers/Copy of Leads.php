<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Leads extends CI_Controller{

    public function __construct(){ 
        parent::__construct();
		
		$this->login_vs_id = $vs_id = $this->session->userdata('us_id');
		$this->login_vs_user_role_id = $this->dbs_role_id = $this->dbs_user_role_id = $vs_user_role_id = $this->session->userdata('us_role_id');
		$this->load->model('general_model');
		if(isset($vs_id) && (isset($vs_user_role_id) && $vs_user_role_id >=1)){
			/* ok */
			$res_nums = $this->general_model->check_controller_permission_access('Leads',$vs_user_role_id,'1');
			if($res_nums>0){
				/* ok */	 
			}else{
				redirect('/');
			}  
			
		}else{
			redirect('/');
		}    
		
		$this->load->model('leads_model'); 
		//$this->load->model('portals_model'); 
		$this->load->model('categories_model'); 
		$this->load->model('emirates_model'); 
		$this->load->model('emirates_location_model'); 
		$this->load->model('emirates_sub_location_model');  
		//$this->load->model('source_of_listings_model');  
		//$this->load->model('property_features_model');
		
		$this->load->model('no_of_bedrooms_model'); 		 
		$this->load->model('admin_model');  
		$this->load->library('Ajax_pagination'); 
		$this->perPage = 25;
		$this->agent_chk_ystrdy_meeting = $this->general_model->chk_entry_of_yesterday_meetings_and_views();
    }   
	  
	/* leads operations starts */
	
	 
function index($args_vals=''){ /* $temps_property_type='' */ 
	
	if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
		redirect('agent/operate_meetings_views');
	}
	 
	$res_nums =  $this->general_model->check_controller_method_permission_access('Leads','index',$this->dbs_user_role_id,'1'); 
	if($res_nums>0){ 
		
		if(isset($args_vals) && $args_vals=="export_excel"){
			$paras_arrs = $data = array();	
			$offset = 0;
			$data['page'] = $page = 0;
			/* permission checks */
			$vs_user_type_id = $this->session->userdata('us_user_type_id');
			$vs_id = $this->session->userdata('us_id');
				
				if(isset($_POST['refer_no'])){
					$refer_no_val = $this->input->post('refer_no'); 
					if(strlen($refer_no_val)>0){
						$_SESSION['tmp_refer_no'] = $refer_no_val; 
						$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
					}else{
						unset($_SESSION['tmp_refer_no']);	
					}
					
				}else if(isset($_SESSION['tmp_refer_no'])){
					$refer_no_val = $_SESSION['tmp_refer_no']; 
					$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
				} 
						 
				if(isset($_POST['leads_type_val'])){
					$leads_type_val = $this->input->post('leads_type_val');  
					$_SESSION['tmp_leads_type_val'] = $leads_type_val; 
					$paras_arrs = array_merge($paras_arrs, array("leads_type_val" => $leads_type_val)); 
					
				}else if(isset($_SESSION['tmp_leads_type_val'])){  ///
					$leads_type_val = $_SESSION['tmp_leads_type_val']; 
					$paras_arrs = array_merge($paras_arrs, array("leads_type_val" => $leads_type_val));
				} 
			 
				if(isset($_POST['leads_status_val'])){
					$leads_status_val = $this->input->post('leads_status_val'); 
					$_SESSION['tmp_leads_status_val'] = $leads_status_val; 
					$paras_arrs = array_merge($paras_arrs, array("leads_status_val" => $leads_status_val));
					
				}else if(isset($_SESSION['tmp_leads_status_val'])){///
					$leads_status_val = $_SESSION['tmp_leads_status_val'];
					$paras_arrs = array_merge($paras_arrs, array("leads_status_val" => $leads_status_val));
				} 
				 
				if(isset($_POST['leads_sub_status_val'])){
					$leads_sub_status_val = $this->input->post('leads_sub_status_val');  
					$_SESSION['tmp_leads_sub_status_val'] = $leads_sub_status_val;
					$paras_arrs = array_merge($paras_arrs, array("leads_sub_status_val" => $leads_sub_status_val));  
					
				}else if(isset($_SESSION['tmp_leads_sub_status_val'])){///
					$leads_sub_status_val = $_SESSION['tmp_leads_sub_status_val'];
					$paras_arrs = array_merge($paras_arrs, array("leads_sub_status_val" => $leads_sub_status_val));
				}  
					 
				if(isset($_POST['prioritys_val'])){
					$prioritys_val = $this->input->post('prioritys_val');  
					$_SESSION['tmp_prioritys_val'] = $prioritys_val;
					$paras_arrs = array_merge($paras_arrs, array("prioritys_val" => $prioritys_val)); 
					
				}else if(isset($_SESSION['tmp_prioritys_val'])){ 
					$prioritys_val = $_SESSION['tmp_prioritys_val'];
					$paras_arrs = array_merge($paras_arrs, array("prioritys_val" => $prioritys_val));
				}  
					 
				if(isset($_POST['contact_id_val'])){
					$contact_id_val = $this->input->post('contact_id_val');  
					$_SESSION['tmp_contact_id_val'] = $contact_id_val;
					$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val)); 
					
				}else if(isset($_SESSION['tmp_contact_id_val'])){ ///
					$contact_id_val = $_SESSION['tmp_contact_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val));
				} 
				
				if(isset($_POST['assigned_to_id_val'])){
					$assigned_to_id_val = $this->input->post('assigned_to_id_val');  
					$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val)); 
					
				}else if(isset($_SESSION['tmp_assigned_to_id_val'])){ ///
					$assigned_to_id_val = $_SESSION['tmp_assigned_to_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
				}  
					 
	
				if(isset($_POST['sel_emirate_location_id_val'])){
					$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val');  
					$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val)); 
					
				}else if(isset($_SESSION['tmp_emirate_location_id_val'])){  ///
					$emirate_location_id_val = $_SESSION['tmp_emirate_location_id_val']; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
				}
					 
				if(isset($_POST['sel_no_of_beds_id_val'])){
					$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
					$_SESSION['tmp_no_of_beds_id_val'] = $no_of_beds_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
					
				}else if(isset($_SESSION['tmp_no_of_beds_id_val'])){///
					$no_of_beds_id_val = $_SESSION['tmp_no_of_beds_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
				} 
				
				if(isset($_POST['category_id'])){
					$category_id_val = $this->input->post('category_id'); 
					$_SESSION['tmp_category_id_val'] = $category_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $category_id_val));
					
				}else if(isset($_SESSION['tmp_category_id_val'])){///
					$category_id_val = $_SESSION['tmp_category_id_val'];
					$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $category_id_val));
				}   	
				
				if(isset($_POST['inquiry_from_date'])){
					$inquiry_from_date_val = $this->input->post('inquiry_from_date');  
					if(strlen($inquiry_from_date_val)>0){
						$_SESSION['tmp_inquiry_from_date_val'] = $inquiry_from_date_val; 
						$paras_arrs = array_merge($paras_arrs, array("inquiry_from_date_val" => $inquiry_from_date_val));
					}else{
						unset($_SESSION['tmp_inquiry_from_date_val']);	
					}
				}else if(isset($_SESSION['tmp_inquiry_from_date_val'])){ ///
					$inquiry_from_date_val = $_SESSION['tmp_inquiry_from_date_val']; 
					$paras_arrs = array_merge($paras_arrs, array("inquiry_from_date_val" => $inquiry_from_date_val));
				} 
				 
				if(isset($_POST['inquiry_to_date'])){
					$inquiry_to_date_val = $this->input->post('inquiry_to_date');  
					if(strlen($inquiry_to_date_val)>0){
						$_SESSION['tmp_inquiry_to_date'] = $inquiry_to_date_val; 
						$paras_arrs = array_merge($paras_arrs, array("inquiry_to_date_val" => $inquiry_to_date_val));
					}else{
						unset($_SESSION['tmp_inquiry_to_date']);	
					}
				}else if(isset($_SESSION['tmp_inquiry_to_date'])){ ///
					$inquiry_to_date_val = $_SESSION['tmp_inquiry_to_date']; 
					$paras_arrs = array_merge($paras_arrs, array("inquiry_to_date_val" => $inquiry_to_date_val));
				} 	 	
				
				if(isset($_POST['price'])){
					$price_val = $this->input->post('price');  
					if(strlen($price_val)>0){
						$_SESSION['tmp_price_val'] = $price_val; 
						$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
					}else{
						unset($_SESSION['tmp_price_val']);	
					}
				}else if(isset($_SESSION['tmp_price_val'])){ ///
					$price_val = $_SESSION['tmp_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				} 
				
				if(isset($_POST['to_price'])){
					$to_price_val = $this->input->post('to_price');  
					if(strlen($to_price_val)>0){
						$_SESSION['tmp_to_price_val'] = $to_price_val; 
						$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
					}else{
						unset($_SESSION['tmp_to_price_val']);	
					}
				}else if(isset($_SESSION['tmp_to_price_val'])){ ///
					$to_price_val = $_SESSION['tmp_to_price_val']; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				} 
					 
					
				//total rows count
				$export_data_arrs = $this->leads_model->get_all_cstm_leads_properties($paras_arrs); 
		  
				$dataToExports = []; 	 
				if(isset($export_data_arrs) && count($export_data_arrs)>0){
					foreach($export_data_arrs as $export_data_arr){ 
						$temp_arr = array();  
						
						$temp_arr['Ref No'] = stripslashes($export_data_arr->ref_no); 
						$temp_arr['Lead Type'] = stripslashes($export_data_arr->lead_type);
						$temp_arr['Status'] = stripslashes($export_data_arr->lead_status);
						$temp_arr['Priority'] = stripslashes($export_data_arr->priority); 
						$temp_arr['Contact(s)'] = stripslashes($export_data_arr->cnt_name);
						 
						$sub_locs = $cates_name = $bedrooms_title = $agent_nm = ''; 
						 
						if(isset($export_data_arr->sub_location_id) && $export_data_arr->sub_location_id>0){
							$arr_lc = $this->admin_model->get_emirate_sub_location_by_id($export_data_arr->sub_location_id);  
							if(isset($arr_lc)){
								$sub_locs = stripslashes($arr_lc->name);
							}
						 }
						$temp_arr['Sub Location'] = $sub_locs;	 
						
						
						if(isset($export_data_arr->category_id) && $export_data_arr->category_id>0){
							$arr_cate = $this->admin_model->get_category_by_id($export_data_arr->category_id); 
							if(isset($arr_cate)){
								$cates_name = stripslashes($arr_cate->name);
							}
						 }
						 
						 $temp_arr['Category'] = $cates_name;	 
						
						 if(isset($export_data_arr->no_of_beds_id) && $export_data_arr->no_of_beds_id>0){
							$arr_bd = $this->admin_model->get_no_of_beds_by_id($export_data_arr->no_of_beds_id); 
							if(isset($arr_bd)){
								 $bedrooms_title = stripslashes($arr_bd->title);
							}
						 }
						  $temp_arr['Bedrooms'] = $bedrooms_title;
						 
						  
						  $temp_arr['Budget'] = (isset($export_data_arr) && $export_data_arr->price!='') ? CRM_CURRENCY.' '.number_format($export_data_arr->price,0,".",",") :'';
						  
						  
						  $temp_arr['Inquiry Date'] = ($export_data_arr->enquiry_date!='0000-00-00 00:00:00') ? date('d-M-Y', strtotime($export_data_arr->enquiry_date)):'';
						 
						
						 if($export_data_arr->agent_id>0){
							$usr_arr =  $this->general_model->get_user_info_by_id($export_data_arr->agent_id);
							$agent_nm = stripslashes($usr_arr->name);
						}
						
						 $temp_arr['Agent'] = $agent_nm;
						 
						 $temp_arr['Updated'] = ($export_data_arr->updated_on!='0000-00-00 00:00:00') ? date('d.M.y', strtotime($export_data_arr->updated_on)):'';
						  
						$dataToExports[] = $temp_arr;
					}
				}   
		
				
				// set header
				$filename = "CRM-Leads-".date('d-M-Y H:i:s').".xls";
				
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				$this->general_model->exportExcelData($dataToExports);
				exit; 
			}
			
		$records = '';  
		$data = array();
		$data['page_headings']="Leads Management!";
		$paras_arrs = array();	 
		$data['contact_arrs'] = $this->general_model->get_gen_all_contacts_list(); 
		$data['beds_arrs'] = $this->no_of_bedrooms_model->get_all_no_of_beds();
		/* permission checks */
		$vs_user_type_id = $this->session->userdata('us_user_type_id');
		$vs_id = $this->session->userdata('us_id');
		
		$s_val= $category_id_val = $assigned_to_id_val= $is_featured_val= $is_property_type='';
		$emirate_location_id_val = $no_of_beds_id_val = $no_of_baths_val = '';
		
		if($this->input->post('sel_per_page_val')){
			$per_page_val = $this->input->post('sel_per_page_val'); 
			$_SESSION['tmp_per_page_val'] = $per_page_val;  
			
		}else if(isset($_SESSION['tmp_per_page_val'])){
				unset($_SESSION['tmp_per_page_val']);
			}  
		
		if($this->input->post('refer_no')){
			$refer_no_val = $this->input->post('refer_no'); 
			$_SESSION['tmp_refer_no'] = $refer_no_val; 
			$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
		}else if(isset($_SESSION['tmp_refer_no'])){
				unset($_SESSION['tmp_refer_no']);
			}
				
		if($this->input->post('leads_type_val')){
			$leads_type_val = $this->input->post('leads_type_val'); 
			$_SESSION['tmp_leads_type_val'] = $leads_type_val;
			$paras_arrs = array_merge($paras_arrs,array("leads_type_val" => $leads_type_val));
		}else if(isset($_SESSION['tmp_leads_type_val'])){
				unset($_SESSION['tmp_leads_type_val']);
			}	
			
		if($this->input->post('leads_status_val')){
			$leads_status_val = $this->input->post('leads_status_val'); 
			$_SESSION['tmp_leads_status_val'] = $leads_status_val;
			$paras_arrs = array_merge($paras_arrs,array("leads_status_val" => $leads_status_val));
		}else if(isset($_SESSION['tmp_leads_status_val'])){
				unset($_SESSION['tmp_leads_status_val']);
			}
			 
		if($this->input->post('leads_sub_status_val')){
			$leads_sub_status_val = $this->input->post('leads_sub_status_val'); 
			$_SESSION['tmp_leads_sub_status_val'] = $leads_sub_status_val;
			$paras_arrs = array_merge($paras_arrs, array("leads_sub_status_val" => $leads_sub_status_val));
		}else if(isset($_SESSION['tmp_leads_sub_status_val'])){
				unset($_SESSION['tmp_leads_sub_status_val']);
			}  
			
		if($this->input->post('prioritys_val')){
			$prioritys_val = $this->input->post('prioritys_val'); 
			$_SESSION['tmp_prioritys_val'] = $prioritys_val;
			$paras_arrs = array_merge($paras_arrs, array("prioritys_val" => $prioritys_val));
		}else if(isset($_SESSION['tmp_prioritys_val'])){
				unset($_SESSION['tmp_prioritys_val']);
			}  
			
		if($this->input->post('contact_id_val')){
			$contact_id_val = $this->input->post('contact_id_val'); 
			$_SESSION['tmp_contact_id_val'] = $contact_id_val;
			$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val));
		}else if(isset($_SESSION['tmp_contact_id_val'])){
				unset($_SESSION['tmp_contact_id_val']);
			}  
			
		if($this->input->post('assigned_to_id_val')){
			$assigned_to_id_val = $this->input->post('assigned_to_id_val'); 
			$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
			$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
		}else if(isset($_SESSION['tmp_assigned_to_id_val'])){
				unset($_SESSION['tmp_assigned_to_id_val']);
			} 
		
		if($this->input->post('sel_emirate_location_id_val')){
			$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val'); 
			$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
			$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
		}else if(isset($_SESSION['tmp_emirate_location_id_val'])){
				unset($_SESSION['tmp_emirate_location_id_val']);
			} 
		
		if($this->input->post('sel_no_of_beds_id_val')){
			$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
			$_SESSION['tmp_no_of_beds_id_val'] = $no_of_beds_id_val;
			
			$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
		}else if(isset($_SESSION['tmp_no_of_beds_id_val'])){
				unset($_SESSION['tmp_no_of_beds_id_val']);
			}
			
		if($this->input->post('price')){
			$price_val = $this->input->post('price'); 
			$_SESSION['tmp_price_val'] = $price_val; 
			$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
		}else if(isset($_SESSION['tmp_price_val'])){
				unset($_SESSION['tmp_price_val']);
			}
			
		if($this->input->post('to_price')){
			$to_price_val = $this->input->post('to_price'); 
			$_SESSION['tmp_to_price_val'] = $to_price_val; 
			$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
		}else if(isset($_SESSION['tmp_to_price_val'])){
				unset($_SESSION['tmp_to_price_val']);
			} 	
			 
			
		if($this->input->post('inquiry_from_date')){
			$inquiry_from_date_val = $this->input->post('inquiry_from_date'); 
			$_SESSION['tmp_inquiry_from_date_val'] = $inquiry_from_date_val; 
			$paras_arrs = array_merge($paras_arrs, array("inquiry_from_date_val" => $inquiry_from_date_val));
		}else if(isset($_SESSION['tmp_inquiry_from_date_val'])){
				unset($_SESSION['tmp_inquiry_from_date_val']);
			}
			
		if($this->input->post('inquiry_to_date')){
			$inquiry_to_date_val = $this->input->post('inquiry_to_date'); 
			$_SESSION['tmp_inquiry_to_date'] = $inquiry_to_date_val; 
			$paras_arrs = array_merge($paras_arrs, array("inquiry_to_date_val" => $inquiry_to_date_val));
		}else if(isset($_SESSION['tmp_inquiry_to_date'])){
				unset($_SESSION['tmp_inquiry_to_date']);
			}  
		 
		if($this->input->post('category_id')){
			$category_id_val = $this->input->post('category_id'); 
			$_SESSION['tmp_category_id_val'] = $category_id_val; 
			$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $category_id_val));
		}else if(isset($_SESSION['tmp_category_id_val'])){
				unset($_SESSION['tmp_category_id_val']);
			} 
		 	
		if(isset($_SESSION['tmp_per_page_val'])){
			$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
		}else{
			$show_pers_pg = $this->perPage;
		}
		 
		//total rows count
		$totalRec = count($this->leads_model->get_all_cstm_leads_properties($paras_arrs));
		
		//pagination configuration leads_model
		$config['target']      = '#dyns_list';
		$config['base_url']    = site_url('/leads/index2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
		
	    $records = $data['records'] = $this->leads_model->get_all_cstm_leads_properties($paras_arrs);
		
		$vs_user_type_id = $this->session->userdata('us_user_type_id');
		$vs_id = $this->session->userdata('us_id');
		
		if($vs_user_type_id==3){ 
			$arrs_field = array('id' => $vs_id); 
		}else if($vs_user_type_id==2){ 
			$arrs_field = array('user_type_id'=> '3','parent_id'=> $vs_id); 
		}else{
			$arrs_field = array('status'=> '1'); 
		}
		$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
		  
		$data['page_headings']="Leads Listing"; 
		$this->load->view('leads/index',$data); 
		  
	}else{
		$datas['page_headings']="Invalid Access!";
		$this->load->view('no_permission_page',$datas);
	} 
}

function index2($temps_property_type=''){ 
	$res_nums =  $this->general_model->check_controller_method_permission_access('Leads','index',$this->dbs_user_role_id,'1'); 
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
		$vs_user_type_id = $this->session->userdata('us_user_type_id');
		$vs_id = $this->session->userdata('us_id');
		
	
	if($this->input->post('sel_per_page_val')){
		$per_page_val = $this->input->post('sel_per_page_val'); 
		$_SESSION['tmp_per_page_val'] = $per_page_val;  
		
	}else if(isset($_SESSION['tmp_per_page_val'])){
			$per_page_val = $_SESSION['tmp_per_page_val'];
		}
		   
	if(isset($_POST['refer_no'])){
		$refer_no_val = $this->input->post('refer_no'); 
		if(strlen($refer_no_val)>0){
			$_SESSION['tmp_refer_no'] = $refer_no_val; 
			$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
		}else{
			unset($_SESSION['tmp_refer_no']);	
		}
		
	}else if(isset($_SESSION['tmp_refer_no'])){
		$refer_no_val = $_SESSION['tmp_refer_no']; 
		$paras_arrs = array_merge($paras_arrs, array("refer_no_val" => $refer_no_val));
	} 
			 
	if(isset($_POST['leads_type_val'])){
		$leads_type_val = $this->input->post('leads_type_val');  
		$_SESSION['tmp_leads_type_val'] = $leads_type_val; 
		$paras_arrs = array_merge($paras_arrs, array("leads_type_val" => $leads_type_val)); 
		
	}else if(isset($_SESSION['tmp_leads_type_val'])){
		$leads_type_val = $_SESSION['tmp_leads_type_val']; 
		$paras_arrs = array_merge($paras_arrs, array("leads_type_val" => $leads_type_val));
	} 
 
	if(isset($_POST['leads_status_val'])){
		$leads_status_val = $this->input->post('leads_status_val'); 
		$_SESSION['tmp_leads_status_val'] = $leads_status_val; 
		$paras_arrs = array_merge($paras_arrs, array("leads_status_val" => $leads_status_val));
		
	}else if(isset($_SESSION['tmp_leads_status_val'])){
		$leads_status_val = $_SESSION['tmp_leads_status_val'];
		$paras_arrs = array_merge($paras_arrs, array("leads_status_val" => $leads_status_val));
	} 
	 
	if(isset($_POST['leads_sub_status_val'])){
		$leads_sub_status_val = $this->input->post('leads_sub_status_val');  
		$_SESSION['tmp_leads_sub_status_val'] = $leads_sub_status_val;
		$paras_arrs = array_merge($paras_arrs, array("leads_sub_status_val" => $leads_sub_status_val));  
		
	}else if(isset($_SESSION['tmp_leads_sub_status_val'])){
		$leads_sub_status_val = $_SESSION['tmp_leads_sub_status_val'];
		$paras_arrs = array_merge($paras_arrs, array("leads_sub_status_val" => $leads_sub_status_val));
	}  
		 
	if(isset($_POST['prioritys_val'])){
		$prioritys_val = $this->input->post('prioritys_val');  
		$_SESSION['tmp_prioritys_val'] = $prioritys_val;
		$paras_arrs = array_merge($paras_arrs, array("prioritys_val" => $prioritys_val)); 
		
	}else if(isset($_SESSION['tmp_prioritys_val'])){ 
		$prioritys_val = $_SESSION['tmp_prioritys_val'];
		$paras_arrs = array_merge($paras_arrs, array("prioritys_val" => $prioritys_val));
	}  
		 
	if(isset($_POST['contact_id_val'])){
		$contact_id_val = $this->input->post('contact_id_val');  
		$_SESSION['tmp_contact_id_val'] = $contact_id_val;
		$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val)); 
		
	}else if(isset($_SESSION['tmp_contact_id_val'])){
		$contact_id_val = $_SESSION['tmp_contact_id_val'];
		$paras_arrs = array_merge($paras_arrs, array("contact_id_val" => $contact_id_val));
	} 
	
	if(isset($_POST['assigned_to_id_val'])){
		$assigned_to_id_val = $this->input->post('assigned_to_id_val');  
		$_SESSION['tmp_assigned_to_id_val'] = $assigned_to_id_val;
		$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val)); 
		
	}else if(isset($_SESSION['tmp_assigned_to_id_val'])){
		$assigned_to_id_val = $_SESSION['tmp_assigned_to_id_val'];
		$paras_arrs = array_merge($paras_arrs, array("assigned_to_id_val" => $assigned_to_id_val));
	}  
		 
	if(isset($_POST['sel_emirate_location_id_val'])){
		$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val');  
		$_SESSION['tmp_emirate_location_id_val'] = $emirate_location_id_val; 
		$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val)); 
		
	}else if(isset($_SESSION['tmp_emirate_location_id_val'])){
		$emirate_location_id_val = $_SESSION['tmp_emirate_location_id_val']; 
		$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
	}
		 
	if(isset($_POST['sel_no_of_beds_id_val'])){
		$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
		$_SESSION['tmp_no_of_beds_id_val'] = $no_of_beds_id_val; 
		$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
		
	}else if(isset($_SESSION['tmp_no_of_beds_id_val'])){
		$no_of_beds_id_val = $_SESSION['tmp_no_of_beds_id_val'];
		$paras_arrs = array_merge($paras_arrs, array("no_of_beds_id_val" => $no_of_beds_id_val));
	} 
	
	if(isset($_POST['category_id'])){
		$category_id_val = $this->input->post('category_id'); 
		$_SESSION['tmp_category_id_val'] = $category_id_val; 
		$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $category_id_val));
		
	}else if(isset($_SESSION['tmp_category_id_val'])){
		$category_id_val = $_SESSION['tmp_category_id_val'];
		$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $category_id_val));
	}   	
	
	if(isset($_POST['inquiry_from_date'])){
		$inquiry_from_date_val = $this->input->post('inquiry_from_date');  
		if(strlen($inquiry_from_date_val)>0){
			$_SESSION['tmp_inquiry_from_date_val'] = $inquiry_from_date_val; 
			$paras_arrs = array_merge($paras_arrs, array("inquiry_from_date_val" => $inquiry_from_date_val));
		}else{
			unset($_SESSION['tmp_inquiry_from_date_val']);	
		}
	}else if(isset($_SESSION['tmp_inquiry_from_date_val'])){
		$inquiry_from_date_val = $_SESSION['tmp_inquiry_from_date_val']; 
		$paras_arrs = array_merge($paras_arrs, array("inquiry_from_date_val" => $inquiry_from_date_val));
	} 
	 
	if(isset($_POST['inquiry_to_date'])){
		$inquiry_to_date_val = $this->input->post('inquiry_to_date');  
		if(strlen($inquiry_to_date_val)>0){
			$_SESSION['tmp_inquiry_to_date'] = $inquiry_to_date_val; 
			$paras_arrs = array_merge($paras_arrs, array("inquiry_to_date_val" => $inquiry_to_date_val));
		}else{
			unset($_SESSION['tmp_inquiry_to_date']);	
		}
	}else if(isset($_SESSION['tmp_inquiry_to_date'])){
		$inquiry_to_date_val = $_SESSION['tmp_inquiry_to_date']; 
		$paras_arrs = array_merge($paras_arrs, array("inquiry_to_date_val" => $inquiry_to_date_val));
	} 	 	
	
	if(isset($_POST['price'])){
		$price_val = $this->input->post('price');  
		if(strlen($price_val)>0){
			$_SESSION['tmp_price_val'] = $price_val; 
			$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
		}else{
			unset($_SESSION['tmp_price_val']);	
		}
	}else if(isset($_SESSION['tmp_price_val'])){
		$price_val = $_SESSION['tmp_price_val']; 
		$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
	} 
	
	if(isset($_POST['to_price'])){
		$to_price_val = $this->input->post('to_price');  
		if(strlen($to_price_val)>0){
			$_SESSION['tmp_to_price_val'] = $to_price_val; 
			$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
		}else{
			unset($_SESSION['tmp_to_price_val']);	
		}
	}else if(isset($_SESSION['tmp_to_price_val'])){
		$to_price_val = $_SESSION['tmp_to_price_val']; 
		$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
	}
	 
		  
		if(isset($_SESSION['tmp_per_page_val'])){
			$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
		}else{
			$show_pers_pg = $this->perPage;
		}   
		//total rows count
		$totalRec = count($this->leads_model->get_all_cstm_leads_properties($paras_arrs));
		
		//pagination configuration
		$config['target']      = '#dyns_list';
		$config['base_url']    = site_url('/leads/index2');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $show_pers_pg; //$this->perPage;
		
		$this->ajax_pagination->initialize($config); 
		
		$paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit'=> $show_pers_pg));
		
		$data['records'] = $this->leads_model->get_all_cstm_leads_properties($paras_arrs); 
		
		$this->load->view('leads/index2',$data); 
	 
	}else{
		$datas['page_headings']="Invalid Access!";
		$this->load->view('no_permission_page',$datas);
	} 
}

function operate_lead($args1=''){ 
	if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
		redirect('agent/operate_meetings_views');
	}  
	
	$this->load->model('contacts_model'); 
	 
	$data['contact_arrs'] = $this->contacts_model->get_all_contacts(); 
	$max_lead_id_val = $this->leads_model->get_max_lead_id();
	$max_lead_id_val = $max_lead_id_val+1; 
	$max_lead_id_val = str_pad($max_lead_id_val, 4, '0', STR_PAD_LEFT); 
	$data['auto_ref_no'] = "L-".$max_lead_id_val; 
	
	if(isset($args1) && $args1!=''){
		$data['args1'] = $args1;
		$data['page_headings'] = 'Update Lead';
		$data['record'] = $temp_recs = $this->leads_model->get_lead_by_id($args1);
	
	}else{ 
		$data['page_headings'] = 'Add Lead';
	}    
	
	$vs_user_type_id = $this->session->userdata('us_user_type_id');
	$vs_id = $this->session->userdata('us_id');
	  
	if($vs_id >0 && (isset($args1) && $args1>0)){ 
		if(isset($temp_recs) && $temp_recs->agent_id==$vs_id && $temp_recs->is_new==1){ 
			$datass = array('is_new' => '0'); 
			$this->leads_model->update_lead_data($args1,$datass);   	
		} 
	} 
	
	if($vs_user_type_id==3){ 
		$arrs_field = array('id' => $vs_id); 
	}else if($vs_user_type_id==2){ 
		$arrs_field = array('user_type_id'=> '3','parent_id'=> $vs_id); 
	}else{
		$arrs_field = array('status'=> '1'); 
	}
	$data['user_arrs'] = $this->general_model->get_gen_all_users_by_field($arrs_field);
	/*$data['user_arrs'] = $this->general_model->get_gen_all_users_assigned();*/  
	$data['contact_arrs'] = $this->general_model->get_gen_all_contacts_list();  
	$data['source_of_listing_arrs'] = $this->admin_model->get_all_leads_source_of_listings(); 
	
	if(isset($_POST) && !empty($_POST)){  
		$contact_id = (isset($_POST['contact_id']) && strlen($_POST['contact_id'])>0) ? $this->input->post("contact_id") :'';	
		
		$assigned_to_id = $this->input->post("assigned_to_id");
		$lead_ref = $this->input->post("lead_ref"); 
		$lead_type = $this->input->post("lead_type");
		
		$enquiry_date = $this->input->post("enquiry_date"); 
		$enquiry_time = $this->input->post("enquiry_time");
		
		$lead_status = $this->input->post("lead_status");  
		$priority = $this->input->post("priority");  
		$source_of_listing = $this->input->post("source_of_listing");  
		 
		/*$property_id_1 = $this->input->post("property_id_1");
		$property_id_2 = $this->input->post("property_id_2"); 
		$property_id_3 = $this->input->post("property_id_3"); 
		$property_id_4 = $this->input->post("property_id_4"); */
		
		$property_id_1 = (isset($_POST['property_id_1']) && strlen($_POST['property_id_1'])>0) ? $this->input->post("property_id_1") :'';	
		
		$property_id_2 = (isset($_POST['property_id_2']) && strlen($_POST['property_id_2'])>0) ? $this->input->post("property_id_2") :'';	
		
		$property_id_3 = (isset($_POST['property_id_3']) && strlen($_POST['property_id_3'])>0) ? $this->input->post("property_id_3") :'';	
		
		$property_id_4 = (isset($_POST['property_id_4']) && strlen($_POST['property_id_4'])>0) ? $this->input->post("property_id_4") :'';
		
		$reminds = $this->input->post("reminds"); 
		$remind_date_1 = (isset($_POST['remind_date_1']) && strlen($_POST['remind_date_1'])>0) ? $this->input->post("remind_date_1") :''; 
		 
		$remind_time_1 = (isset($_POST['remind_time_1']) && strlen($_POST['remind_time_1'])>0) ? $this->input->post("remind_time_1") :''; 
		 
		$notes = $this->input->post("notes"); 
		$no_of_views = $this->input->post("no_of_views");  
		 
		$updated_on = $created_on = date('Y-m-d H:i:s'); 
		$ip_address = $_SERVER['QUERY_STRING'];
		$created_by = $this->session->userdata('us_id');  
	
		$this->form_validation->set_rules("contact_id", "Contact", "trim|required|xss_clean"); 
		$this->form_validation->set_rules("assigned_to_id", "Assigned To", "trim|required|xss_clean");
		
		$this->form_validation->set_rules("lead_ref", "Ref No", "trim|required|xss_clean");  
		$this->form_validation->set_rules("lead_type", "Lead Type", "trim|required|xss_clean");    	
		$this->form_validation->set_rules("lead_status", "Lead Status", "trim|required|xss_clean");  
		$this->form_validation->set_rules("priority", "Priority", "trim|required|xss_clean"); 
		$this->form_validation->set_rules("source_of_listing", "Source", "trim|required|xss_clean");  
		
if($this->form_validation->run() == FALSE){
// validation fail
	$this->load->view('leads/operate_lead',$data);
	 
}else if(isset($args1) && $args1!=''){    
		
/*contact_id assigned_to_id lead_ref  lead_type lead_status lead_sub_status priority  is_hot_lead  source_of_listing property_id_1 property_id_2 property_id_3 property_id_4 remind_date_1 remind_time_1 remind_date_2 remind_time_2 notes no_of_views args1 */ 
  
$datas = array('contact_id' => $contact_id,'agent_id' => $assigned_to_id,'enquiry_date' => $enquiry_date,'enquiry_time' => $enquiry_time,'lead_type' => $lead_type,'lead_status' => $lead_status,'priority' => $priority,'source_of_listing' => $source_of_listing,'property_id_1' => $property_id_1,'property_id_2' => $property_id_2,'property_id_3' => $property_id_3,'property_id_4' => $property_id_4,'reminds' => $reminds,'remind_date_1' => $remind_date_1,'remind_time_1'=>$remind_time_1,'notes' => $notes,'no_of_views' => $no_of_views,'updated_on' => $updated_on); 
			
$res = $this->leads_model->update_lead_data($args1,$datas); 
if(isset($res)){
	
	if($reminds==1){  
		$cstm_datetimes = $remind_date_1.' '.$remind_time_1; 
		$cstm_datetimes = date('Y-m-d H:i:s',strtotime($cstm_datetimes)); 

		$rmd_arrs = $this->leads_model->chk_lead_reminds_data($assigned_to_id,$args1); 
		if(isset($rmd_arrs) && count($rmd_arrs)>0){ 
			$rmd_datas = array('datetimes' => $cstm_datetimes,'status' => '1');	 
			$update_rmd = $this->leads_model->update_lead_reminds_data($assigned_to_id,$args1,$rmd_datas);
			
		}else{ 
		
			$rmd_datas = array('assigned_id' => $assigned_to_id,'lead_id' => $args1,'datetimes' => $cstm_datetimes,'status' => '1');	 
			$insert_rmd = $this->leads_model->insert_lead_reminds_data($rmd_datas); 
		}  
	}else{
		 $this->leads_model->trash_lead_reminds_data($assigned_to_id,$args1);
	}
	 
	
if(isset($assigned_to_id) && $assigned_to_id>0){ 
	$usr_arr0 = $this->general_model->get_user_info_by_id($assigned_to_id);
	if(isset($usr_arr0)){
		$mail_to_name = $usr_arr0->name;
		$mail_to = $usr_arr0->email;
		if(strlen($mail_to)>0){ 
		
			$configs_arr = $this->general_model->get_configuration(); 
			$config_disclaimer = stripslashes($configs_arr->disclaimer);
			$config_disclaimer ="<u>Disclaimer:</u> \n{$config_disclaimer}";
			$from_email = "crm@buysellown.com";
			  
			$lead_details_url = 'leads/lead_detail/'.$args1;
			$lead_details_url = site_url($lead_details_url);
			 
			
			$subject = "A lead has been assigned – Buysellown CRM";
		
			$lead_title_urls = "<a href=\"$lead_details_url\" target=\"_blank\" title=\"{$lead_ref}\"><strong><u>{$lead_ref}</u></strong></a>";
				 
			$message = "Dear {$mail_to_name}, <br>
<br>
A new lead has been assigned to you with the Ref #: $lead_title_urls . <br>
Please do not reply to this mail. <br>
"; 
			
			$this->email->to($mail_to); 
			$this->email->from($from_email);
			$this->email->set_mailtype("html");
			$this->email->subject($subject);
			
			$cstm_email_template = CRM_EMAIL_TEMPLATE;
			
			$cstm_email_template = str_replace("[[body_txt]]", "$message", "$cstm_email_template");
			$cstm_email_msg = str_replace("[[footer_txt]]", "$config_disclaimer", "$cstm_email_template"); 
			$cstm_email_msg = str_replace("\n", "<br>
", "$cstm_email_msg"); 
			 
			$this->email->message($cstm_email_msg); 
			
			$this->email->send();
				
		} 
	}
} 
	
	$this->session->set_flashdata('success_msg','Record updated successfully!');
}else{
	$this->session->set_flashdata('error_msg','Error: while updating record!');
}
	 
	redirect("leads/index");
		
}else{
	
	$datas = array('contact_id' => $contact_id,'agent_id' => $assigned_to_id,'enquiry_date' => $enquiry_date,'enquiry_time' => $enquiry_time,'ref_no' => $lead_ref,'lead_type' => $lead_type,'lead_status' => $lead_status,'priority' => $priority,'source_of_listing' => $source_of_listing,'property_id_1' => $property_id_1,'property_id_2' => $property_id_2,'property_id_3' => $property_id_3,'property_id_4' => $property_id_4,'reminds' => $reminds,'remind_date_1' => $remind_date_1,'remind_time_1'=>$remind_time_1,'notes' => $notes,'no_of_views' => $no_of_views,'created_by' => $created_by,'created_on' => $created_on,'ip_address' => $ip_address); 
	$res = $this->leads_model->insert_lead_data($datas); 
	if(isset($res)){
		$last_lead_id = $this->db->insert_id(); 
		
		if($reminds==1){  
			$cstm_datetimes = $remind_date_1.' '.$remind_time_1; 
			$cstm_datetimes = date('Y-m-d H:i:s',strtotime($cstm_datetimes)); 
	 
			$rmd_datas = array('assigned_id' => $assigned_to_id,'lead_id' => $last_lead_id,'datetimes' => $cstm_datetimes,'status' => '1');	 
			$insert_rmd = $this->leads_model->insert_lead_reminds_data($rmd_datas);    
		}
		 
/*$temp_usrs_arr = $this->general_model->get_user_info_by_id($assigned_to_id);
if(isset($temp_usrs_arr) && count($temp_usrs_arr)>0){
	$mail_to = $temp_usrs_arr->email;
	$mail_to_name = $temp_usrs_arr->name;
	$tmp_user_type_id = $temp_usrs_arr->user_type_id;
	
	$configs_arr = $this->general_model->get_configuration();
	$from_email = $configs_arr->email; 
	
	 
	$details_url = 'leads/lead_detail/'.$last_lead_id;
	$details_url = site_url($details_url); 
	
	$usrrole_name = '';
	$usrtyp_arr = $this->admin_model->get_user_type_by_id($tmp_user_type_id);
	if(isset($usrtyp_arr) && count($usrtyp_arr)>0){
		$usrrole_name = $usrtyp_arr->name; 
	}	
	
	$config['mailtype'] = 'html';  
	$this->email->initialize($config); 	
	$this->email->to($mail_to); 
	$this->email->from($from_email); 
	$this->email->subject("A new lead has been assigned – Buysellown CRM");
	$this->email->message("A new lead has been assigned to you by {$mail_to_name} – {$usrrole_name} <a href=\"{$details_url}\" target=\"_blank\">{$lead_ref}</a>");  
	$this->email->send();
}*/  	
		
if(isset($assigned_to_id) && $assigned_to_id>0){ 
	$usr_arr0 = $this->general_model->get_user_info_by_id($assigned_to_id);
	if(isset($usr_arr0)){
		$mail_to_name = $usr_arr0->name;
		$mail_to = $usr_arr0->email;
		if(strlen($mail_to)>0){ 
		
			$configs_arr = $this->general_model->get_configuration(); 
			$config_disclaimer = stripslashes($configs_arr->disclaimer);
			$config_disclaimer ="<u>Disclaimer:</u> \n{$config_disclaimer}";
			$from_email = "crm@buysellown.com";
			  
			$lead_details_url = 'leads/lead_detail/'.$last_lead_id;
			$lead_details_url = site_url($lead_details_url);
			 
			
			$subject = "A lead has been assigned – Buysellown CRM";
		
			$lead_title_urls = "<a href=\"$lead_details_url\" target=\"_blank\" title=\"{$lead_ref}\"><strong><u>{$lead_ref}</u></strong></a>";
				 
			$message = "Dear {$mail_to_name}, <br>
<br>
A new lead has been assigned to you with the Ref #: $lead_title_urls . <br>
Please do not reply to this mail. <br>
";
			
			$this->email->to($mail_to); 
			$this->email->from($from_email);
			$this->email->set_mailtype("html");
			$this->email->subject($subject);
			
			$cstm_email_template = CRM_EMAIL_TEMPLATE;
			
			$cstm_email_template = str_replace("[[body_txt]]", "$message", "$cstm_email_template");
			$cstm_email_msg = str_replace("[[footer_txt]]", "$config_disclaimer", "$cstm_email_template"); 
			$cstm_email_msg = str_replace("\n", "<br>
", "$cstm_email_msg"); 
			 
			$this->email->message($cstm_email_msg); 
			
			$this->email->send(); 	
		} 
	}
}  
			
			$this->session->set_flashdata('success_msg','Record inserted successfully!');
		}else{
			$this->session->set_flashdata('error_msg','Error: while inserting record!');
		} 
		  
		redirect("leads/index");
	}
	
}else{
	$this->load->view('leads/operate_lead',$data);
}
}

	function trash($args2=''){ 
		if($this->login_vs_user_role_id==1){
			$data['page_headings']="Leads Listing";
			if($args2 >1){
				$this->admin_model->trash_lead($args2);
			}
			redirect('leads/index'); 
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		}
	}
	
	function leads_property_popup_list_old($paras1=''){ 
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}  
		$data['paras1'] = $paras1; 
		$data['page_headings'] = 'Property Requirements'; 
		$data['emirate_arrs'] = $this->admin_model->get_all_emirates();
		$data['emirate_location_arrs'] = $this->admin_model->fetch_emirate_locations('');
		$data['emirate_sub_location_arrs']= $this->admin_model->fetch_emirate_sub_locations('');
		
		$data['category_arrs'] = $this->admin_model->get_all_categories();
		$data['beds_arrs'] = $this->admin_model->get_all_no_of_beds(); 
		
		$this->load->view('leads/leads_property_popup_list',$data);
	}
	
	function leads_properties_popup_update($paras1='',$paras2=''){
		
		
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Leads','index',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){
			
			$data['paras1'] = $paras1; 
			$data['paras2'] = $paras2; 
			
			if($paras1 >0){
				$data['record'] = $this->admin_model->get_property_by_id($paras1);
			}
			$data['page_headings'] = 'Update Property'; 
			$data['emirate_arrs'] = $this->admin_model->get_all_emirates();
			$data['emirate_location_arrs'] = $this->admin_model->fetch_emirate_locations('');
			$data['emirate_sub_location_arrs']= $this->admin_model->fetch_emirate_sub_locations('');
			
			$data['category_arrs'] = $this->admin_model->get_all_categories();
			$data['beds_arrs'] = $this->admin_model->get_all_no_of_beds();  
			  
			$data['page_headings']="Update Property";
			$this->load->view('leads/leads_properties_popup_update',$data); 
				
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}




	function leads_properties_popup_list($paras1=''){ 
		if($this->login_vs_user_role_id==3 && $this->agent_chk_ystrdy_meeting==0){
			redirect('agent/operate_meetings_views');
		}
		
		$res_nums =  $this->general_model->check_controller_method_permission_access('Leads','index',$this->dbs_user_role_id,'1'); 
		if($res_nums>0){ 
		
			$data['paras1'] = $paras1; 
			$data['page_headings'] = 'Property Requirements'; 
			$data['emirate_arrs'] = $this->admin_model->get_all_emirates();
			$data['emirate_location_arrs'] = $this->admin_model->fetch_emirate_locations('');
			$data['emirate_sub_location_arrs']= $this->admin_model->fetch_emirate_sub_locations('');
			
			$data['category_arrs'] = $this->admin_model->get_all_categories();
			$data['beds_arrs'] = $this->admin_model->get_all_no_of_beds();  
				
			$paras_arrs = array();	 
			
			/* permission checks */  
			if($this->input->post('sel_per_page_val')){
				$per_page_val = $this->input->post('sel_per_page_val'); 
				$_SESSION['tmp_per_page_val'] = $per_page_val;  
				
			}else if(isset($_SESSION['tmp_per_page_val'])){
					unset($_SESSION['tmp_per_page_val']);
				}   
				
				
			if($this->input->post('sel_q_val')){
				$q_val = $this->input->post('sel_q_val'); 
				$_SESSION['tmp_q_val'] = $q_val; 
				$paras_arrs = array_merge($paras_arrs, array("q_val" => $q_val));
			}else if(isset($_SESSION['tmp_q_val'])){
					unset($_SESSION['tmp_q_val']);
				}  
				
				
			if($this->input->post('sel_unit_no_val')){
				$sel_unit_no = $this->input->post('sel_unit_no_val'); 
				$_SESSION['tmp_sel_unit_no'] = $sel_unit_no; 
				$paras_arrs = array_merge($paras_arrs, array("unit_no_val" => $sel_unit_no));
			}else if(isset($_SESSION['tmp_sel_unit_no'])){
					unset($_SESSION['tmp_sel_unit_no']);
				}	
		
					
			 if($this->input->post('sel_property_type_val')){
				$sel_property_type = $this->input->post('sel_property_type_val'); 
				$_SESSION['tmp_sel_property_type'] = $sel_property_type; 
				$paras_arrs = array_merge($paras_arrs, array("property_type_val" => $sel_property_type));
			}else if(isset($_SESSION['tmp_sel_property_type'])){
					unset($_SESSION['tmp_sel_property_type']);
				} 
				 
			if($this->input->post('sel_category_id_val')){
				$sel_category_id_val = $this->input->post('sel_category_id_val'); 
				$_SESSION['tmp_sel_category_id'] = $sel_category_id_val; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $sel_category_id_val));
			}else if(isset($_SESSION['tmp_sel_category_id'])){
					unset($_SESSION['tmp_sel_category_id']);
				}	 
				
			if($this->input->post('sel_emirate_location_id_val')){
				$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val'); 
				$_SESSION['tmp_emirate_location_id'] = $emirate_location_id_val; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
			}else if(isset($_SESSION['tmp_emirate_location_id'])){
					unset($_SESSION['tmp_emirate_location_id']);
				} 
			
			
			if($this->input->post('sel_no_of_beds_id_val')){
				$sel_no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val'); 
				$_SESSION['tmp_sel_of_beds_id'] = $sel_no_of_beds_id_val; 
				$paras_arrs = array_merge($paras_arrs, array("beds_id_val" => $sel_of_beds_id_val));
			}else if(isset($_SESSION['tmp_sel_of_beds_id'])){
					unset($_SESSION['tmp_sel_of_beds_id']);
				}  
				
				
			if($this->input->post('price')){
				$price_val = $this->input->post('price'); 
				$_SESSION['tmp_price_val'] = $price_val; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}else if(isset($_SESSION['tmp_price_val'])){
					unset($_SESSION['tmp_price_val']);
				}
				
			if($this->input->post('to_price')){
				$to_price_val = $this->input->post('to_price'); 
				$_SESSION['tmp_to_price_val'] = $to_price_val; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}else if(isset($_SESSION['tmp_to_price_val'])){
					unset($_SESSION['tmp_to_price_val']);
				}
			/* sel_prices: prices, sel_sizes: sizes, sel_property_type: property_type_val,sel_category_id_val: category_id_val, sel_of_beds_id_val: no_of_beds_id_val
			 
			 
			if($this->input->post('sel_prices')){
				$prices_val = $this->input->post('sel_prices'); 
				$_SESSION['tmp_prices_val'] = $prices_val; 
				$paras_arrs = array_merge($paras_arrs, array("prices_val" => $prices_val));
			}else if(isset($_SESSION['tmp_prices_val'])){
					unset($_SESSION['tmp_prices_val']);
				}
				
			if($this->input->post('sel_sizes')){
				$sizes_val = $this->input->post('sel_sizes'); 
				$_SESSION['tmp_sizes_val'] = $sizes_val; 
				$paras_arrs = array_merge($paras_arrs, array("sizes_val" => $sizes_val));
			}else if(isset($_SESSION['tmp_sizes_val'])){
					unset($_SESSION['tmp_sizes_val']);
				}*/ 
					
			 
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}
			  
			//total rows count 
			$totalRec = count($this->leads_model->get_all_cstm_properties_leads($paras_arrs)); 
			//pagination configuration
			$config['target']      = '#fetch_dyn_list';
			$config['base_url']    = site_url('/leads/leads_properties_popup_list2');
			$config['total_rows']  = $totalRec;				
			$config['per_page']    = $show_pers_pg;
			
			$this->ajax_pagination->initialize($config); 
			
			$paras_arrs = array_merge($paras_arrs, array("limit" => $show_pers_pg));
			 
			$data['records'] = $this->leads_model->get_all_cstm_properties_leads($paras_arrs);
			 
			$data['page_headings']="Leads Listings";
		 
			$this->load->view('leads/leads_properties_popup_list',$data); 
			 
			
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}
	


	function leads_properties_popup_list2(){ 
		$res_nums =  $this->general_model->check_controller_method_permission_access('Leads','index',$this->dbs_user_role_id,'1'); 
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
			}  
			
			if(isset($_SESSION['tmp_per_page_val'])){
				$show_pers_pg = $_SESSION['tmp_per_page_val'];	 
			}else{
				$show_pers_pg = $this->perPage;
			}  
			 
			if(isset($_POST['sel_q_val'])){
				$q_val = $this->input->post('sel_q_val');  
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
			
			if(isset($_POST['sel_unit_no_val'])){
				$sel_unit_no = $this->input->post('sel_unit_no_val');  
				if(strlen($sel_unit_no)>0){
					$_SESSION['tmp_sel_unit_no'] = $sel_unit_no; 
					$paras_arrs = array_merge($paras_arrs, array("unit_no_val" => $sel_unit_no));
				}else{
					unset($_SESSION['tmp_sel_unit_no']);	
				}
				
			}else if(isset($_SESSION['tmp_sel_unit_no'])){ 
				$sel_unit_no = $_SESSION['tmp_sel_unit_no']; 
				$paras_arrs = array_merge($paras_arrs, array("unit_no_val" => $sel_unit_no));
			}   
				
	
			if(isset($_POST['sel_property_type_val'])){
				$sel_property_type = $this->input->post('sel_property_type_val');  
				if(strlen($sel_property_type)>0){
					$_SESSION['tmp_sel_property_type'] = $sel_property_type; 
					$paras_arrs = array_merge($paras_arrs, array("property_type_val" => $sel_property_type));
				}else{
					unset($_SESSION['tmp_sel_property_type']);	
				}
				
			}else if(isset($_SESSION['tmp_sel_property_type'])){ ///
				$sel_property_type = $_SESSION['tmp_sel_property_type']; 
				$paras_arrs = array_merge($paras_arrs, array("property_type_val" => $sel_property_type));
			}
			
			
			 if(isset($_POST['sel_category_id_val'])){
				$sel_category_id_val = $this->input->post('sel_category_id_val');  
				if(strlen($sel_category_id_val)>0){
					$_SESSION['tmp_sel_category_id'] = $sel_category_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $sel_category_id_val));
				}else{
					unset($_SESSION['tmp_sel_category_id']);	
				}
				
			}else if(isset($_SESSION['tmp_sel_category_id'])){ ///
				$sel_category_id_val = $_SESSION['tmp_sel_category_id']; 
				$paras_arrs = array_merge($paras_arrs, array("category_id_val" => $sel_category_id_val));
			}
				
			
			if(isset($_POST['sel_emirate_location_id_val'])){
				$emirate_location_id_val = $this->input->post('sel_emirate_location_id_val');  
				if(strlen($emirate_location_id_val)>0){
					$_SESSION['tmp_emirate_location_id'] = $emirate_location_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
				}else{
					unset($_SESSION['tmp_emirate_location_id']);	
				}
				
			}else if(isset($_SESSION['tmp_emirate_location_id'])){ ///
				$emirate_location_id_val = $_SESSION['tmp_emirate_location_id']; 
				$paras_arrs = array_merge($paras_arrs, array("emirate_location_id_val" => $emirate_location_id_val));
			} 
			
			
			
			 if(isset($_POST['sel_no_of_beds_id_val'])){
				$no_of_beds_id_val = $this->input->post('sel_no_of_beds_id_val');  
				if(strlen($no_of_beds_id_val)>0){
					$_SESSION['tmp_sel_of_beds_id'] = $no_of_beds_id_val; 
					$paras_arrs = array_merge($paras_arrs, array("beds_id_val" => $no_of_beds_id_val));
				}else{
					unset($_SESSION['tmp_sel_of_beds_id']);	
				}
				
			}else if(isset($_SESSION['tmp_sel_of_beds_id'])){ ///
				$sel_of_beds_id_val = $_SESSION['tmp_sel_of_beds_id']; 
				$paras_arrs = array_merge($paras_arrs, array("beds_id_val" => $sel_of_beds_id_val));
			}  
			
			if(isset($_POST['price'])){
				$price_val = $this->input->post('price');  
				if(strlen($price_val)>0){
					$_SESSION['tmp_price_val'] = $price_val; 
					$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
				}else{
					unset($_SESSION['tmp_price_val']);	
				}
			}else if(isset($_SESSION['tmp_price_val'])){ ///
				$price_val = $_SESSION['tmp_price_val']; 
				$paras_arrs = array_merge($paras_arrs, array("price_val" => $price_val));
			}
			 
			
			if(isset($_POST['to_price'])){
				$to_price_val = $this->input->post('to_price');  
				if(strlen($to_price_val)>0){
					$_SESSION['tmp_to_price_val'] = $to_price_val; 
					$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
				}else{
					unset($_SESSION['tmp_to_price_val']);	
				}
			}else if(isset($_SESSION['tmp_to_price_val'])){ ///
				$to_price_val = $_SESSION['tmp_to_price_val']; 
				$paras_arrs = array_merge($paras_arrs, array("to_price_val" => $to_price_val));
			}
			   
			//total rows count 
			$totalRec = count($this->leads_model->get_all_cstm_properties_leads($paras_arrs));
			//pagination configuration
			$config['target']      = '#fetch_dyn_list';
			$config['base_url']    = site_url('/leads/leads_properties_popup_list2');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $show_pers_pg; // $this->perPage;
			
			$this->ajax_pagination->initialize($config); 
			
		   $paras_arrs = array_merge($paras_arrs, array('start'=>$offset,'limit' => $show_pers_pg));
			
		 
			$data['records'] = $this->leads_model->get_all_cstm_properties_leads($paras_arrs);
			$this->load->view('leads/leads_properties_popup_list2',$data); 
		 
		}else{
			$datas['page_headings']="Invalid Access!";
			$this->load->view('no_permission_page',$datas);
		} 
	}  	
	
}
?>
