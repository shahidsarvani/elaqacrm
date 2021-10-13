<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Xmls extends CI_Controller {

    function __construct(){
        parent::__construct();
		
		$this->load->model('xmls_model');
		$this->load->model('general_model');
		$this->load->model('emirates_location_model');
		$this->load->model('properties_model');
		$this->load->model('property_features_model');
		
		
		//$this->config_arr = $this->general_model->get_configuration();
    }  
 
	
	function index_old(){
	
		$property_arrs = $this->xmls_model->get_all_xml_cstm_properties(); 
		if(isset($property_arrs) && count($property_arrs) >0){
			// Load XML writer library
			$this->load->library('xml_writer');
			
			// Initiate class
			$xml = new Xml_writer();
			$xml->setRootName('Listings');
			$xml->initiate();
			
			foreach($property_arrs as $property_arr){   
				//owner_id  assigned_to_id  project_id show_on_portal_ids  
				//$db_sizeunits = $this->general_model->get_property_ms_unit($property_arr->property_ms_unit);  
				$db_property_type = ($property_arr->property_type==2) ? 'Rent' : 'Sale';
				  
				$flood_sensitivity = ($property_arr->is_flood_sensitivity==1) ? 'Susceptible to flooding' : 'Not Susceptible to flooding';
				$o_level = ($property_arr->is_o_level==1) ? 'Yes' : 'No';
				$urbanization = ($property_arr->urbanization==1) ? 'Residential area' : 'Commercial area';
				$building_permission = ($property_arr->is_building_permission==1) ? 'Yes' : 'No';
				$verkaveling = ($property_arr->is_verkaveling==1) ? 'Yes' : 'No';   
				 
				$photos_arrs = $this->xmls_model->get_property_dropzone_photos_by_id($property_arr->id); 	
				$documents_arrs = $this->xmls_model->get_property_dropzone_documents_by_id($property_arr->id);  
				$techicals_arrs = ''; //$this->xmls_model->get_techicals_by_property_id($property_arr->id); 
				$layouts_arrs = ''; // $this->xmls_model->get_layouts_by_property_id($property_arr->id); 
				
				$project_arr = ''; //$this->xmls_model->get_project_by_id($property_arr->project_id);
				  
				$category_arr =  $this->xmls_model->get_category_by_id($property_arr->category_id);  
				   
				// Start branch 'List_Item'
				$xml->startBranch('Listing');
				$xml->addNode('item_no', $property_arr->id); 
				$xml->addNode('ref_no', $property_arr->ref_no); 
				if(isset($category_arr)){
				 	$category_name = stripslashes($category_arr->name);
				 	$xml->addNode('category_name', $category_name); 
			    }
				//$xml->addNode('ref_for_project', $property_arr->ref_for_project);  
				$xml->addNode('project_id', '992'); 
				$xml->addNode('property_type', $db_property_type);
				$xml->addNode('title', stripslashes($property_arr->title));  
				//$xml->addNode('sub_heading', stripslashes($property_arr->sub_heading));  
				//$xml->addNode('building_name', stripslashes($property_arr->building_name));  
				$xml->addNode('description', stripslashes($property_arr->description));
				//$xml->addNode('epb_ref', stripslashes($property_arr->epb_ref)); 
				//$xml->addNode('e_peil', stripslashes($property_arr->e_peil)); 
				//$xml->addNode('k_peil', stripslashes($property_arr->k_peil));  
				//$xml->addNode('year_of_construction', stripslashes($property_arr->year_of_construction));
				//$xml->addNode('residential_upside', stripslashes($property_arr->residential_upside));
				//$xml->addNode('total_up', stripslashes($property_arr->total_up));
				$xml->addNode('property_price', '15000');
				$xml->addNode('property_address', stripslashes($property_arr->property_address));
				 
				/*if($pp_no_of_baths==1){
					$pp_no_of_baths = $pp_no_of_baths." Bathroom";
				}else if($pp_no_of_baths >1){
					$pp_no_of_baths = $pp_no_of_baths." Bathrooms";
				}*/ 
				 
				$xml->addNode('no_of_beds',$property_arr->no_of_beds_id);   
				
				$xml->addNode('location_latitude', $property_arr->location_latitude); 
				$xml->addNode('location_longitude', $property_arr->location_longitude); 
				 
				$xml->addNode('created_on', $property_arr->created_on);
				$xml->addNode('updated_on', $property_arr->updated_on);  
				  
				$cstm_img_path = $photos_list = '';
				$k=1;
				if(isset($photos_arrs) && count($photos_arrs) >0){
					$cstm_img_path = base_url()."downloads/property_photos/".$photos_arrs[0]->image;
					  
					foreach($photos_arrs as $photos_arr){ 
						$photos_list .= base_url()."downloads/property_photos/".$photos_arr->image.'|';  
						$k++;
					} 
					$photos_list = substr($photos_list,0,-1); 
					
					$xml->addNode('featured_image', $cstm_img_path); 
				 
					$xml->addNode('gallery_images', $photos_list); 
					
				 } 
					  
					 
				if(isset($documents_arrs) && count($documents_arrs)>0){  
					$xml->startBranch('documents_list');
					foreach($documents_arrs as $documents_arr){ 
						if(stripslashes($documents_arr->name)){
							$xml->startBranch('document_item'); 
							$document_name = base_url()."downloads/property_documents/".$documents_arr->name;
							
							$xml->addNode('document_name', $document_name); 
							$xml->endBranch();
						}
					} 
					$xml->endBranch(); 
				}     
			 
					 
				if(isset($project_arr) && count($project_arr)>0){  
					$xml->startBranch('project_item'); 
					
						$xml->addNode('project_no', stripslashes($project_arr->id));
						$xml->addNode('project_title', stripslashes($project_arr->title));
						$xml->addNode('project_location', stripslashes($project_arr->location));
						$xml->addNode('project_sub_heading', stripslashes($project_arr->sub_heading)); 
						$xml->addNode('project_price', stripslashes($project_arr->project_price)); 
						$xml->addNode('project_is_sold', stripslashes($project_arr->sold_out));
						$xml->addNode('project_description', stripslashes($project_arr->description)); 
						  
						$project_is_featured = ($project_arr->is_featured==1) ? 'Yes':'No'; 
						$xml->addNode('project_is_featured', $project_is_featured);
						 
						if(strlen($project_arr->featured_image)>0){
							$project_featured_image = base_url()."downloads/project_featured_pictures/thumbs/".$project_arr->featured_image;
							$xml->addNode('project_featured_image', $project_featured_image);  
						}
						
						if(strlen($project_arr->image)>0){
							$project_image = base_url()."downloads/project_pictures/thumbs/".$project_arr->image;
							$xml->addNode('project_image', $project_image);  
						} 
						
						  
					$xml->endBranch(); 
				}  
					    	 	 	
				 
				$xml->endBranch();
			}
		
			$xml->endBranch(); 
				
			// Pass the XML to the view
			$data = array();
			$data['xml'] = $xml->getXml(FALSE);
		}else{
			$data = array();
		}
		$this->load->view('xmls', $data);
	} 
	
	 
	function index(){
	
		$property_arrs = $this->xmls_model->get_all_xml_cstm_properties(); 
		if(isset($property_arrs) && count($property_arrs) >0){
			// Load XML writer library
			$this->load->library('xml_writer');
			
			// Initiate class
			$xml = new Xml_writer();
			$xml->setRootName('Listings');
			$xml->initiate();
			
			foreach($property_arrs as $property_arr){    
				
				$is_featured = ($property_arr->is_featured==1) ? 'yes' : 'no'; 
				 
				$db_property_type = '';
				if($property_arr->property_type==1){
					$db_property_type = 'Sale';
				}else if($property_arr->property_type==2){
					$db_property_type = 'Rent';
				}
				
				$db_is_furnished = '';
				if($property_arr->is_furnished==0){
					$db_is_furnished = 'No';
				}else if($property_arr->is_furnished==1){
					$db_is_furnished = 'Yes';
				}else if($property_arr->is_furnished==2){
					$db_is_furnished = 'Partly';
				}     
				 
				$photos_arrs = $this->xmls_model->get_property_dropzone_photos_by_id($property_arr->id); 	
				$documents_arrs = $this->xmls_model->get_property_dropzone_documents_by_id($property_arr->id);  
  				$db_sizeunits = $this->general_model->get_property_ms_unit($property_arr->property_ms_unit); 
  				$db_property_status = $this->general_model->get_gen_property_status($property_arr->property_status);
				 
				// Start branch 'List_Item'
				$xml->startBranch('Listing');
					 
				$xml->addNode('item_no', $property_arr->id); 
				$xml->addNode('property_type', $db_property_type); 
				
				$xml->addNode('ref_no', $property_arr->ref_no);
				$xml->addNode('title', stripslashes($property_arr->title));  
				$xml->addNode('description', stripslashes($property_arr->description));  
				$xml->addNode('assigned_to_id', stripslashes($property_arr->assigned_to_id)); 
				$xml->addNode('assigned_to_name', stripslashes($property_arr->assign_usr_name)); 
				 
				$xml->addNode('category_id', stripslashes($property_arr->category_id));
				$xml->addNode('category_name', stripslashes($property_arr->cate_name));
				 
				$xml->addNode('no_of_beds_id', stripslashes($property_arr->no_of_beds_id)); 
				 	 	 	 	 	 	 
				$xml->addNode('no_of_baths', stripslashes($property_arr->no_of_baths));  
				$xml->addNode('emirate_id', stripslashes($property_arr->emirate_id)); 
				$xml->addNode('emirate_name', stripslashes($property_arr->emirat_name));  
				$xml->addNode('location_id', stripslashes($property_arr->location_id));  
				$xml->addNode('location_name', stripslashes($property_arr->emlc_name));  
				$xml->addNode('sub_location_id', stripslashes($property_arr->sub_location_id));
				$xml->addNode('sub_location_name', stripslashes($property_arr->sub_loc_name));
				 
				//$xml->addNode('sub_location_area_id', stripslashes($property_arr->sub_location_area_id)); 
				$xml->addNode('property_address', stripslashes($property_arr->property_address));  
				$xml->addNode('youtube_video_link', stripslashes($property_arr->youtube_video_link));
				$xml->addNode('property_ms_unit', $db_sizeunits);  
				$xml->addNode('plot_area', stripslashes($property_arr->plot_area));
				$xml->addNode('is_furnished', $db_is_furnished); 
				$xml->addNode('price', stripslashes($property_arr->price));    
				
	if(strlen($property_arr->private_amenities_data)>0){
		$private_amenities_arrs = $this->property_features_model->get_all_property_features_in_id($property_arr->private_amenities_data);
		if(isset($private_amenities_arrs) && count($private_amenities_arrs)>0){
				
			$xml->startBranch('private_amenities_list');
			foreach($private_amenities_arrs as $private_amenities_arr){  
				$xml->startBranch('private_amenities_item'); 
				 
				$xml->addNode('private_amenity_title', stripslashes($private_amenities_arr->title));
				$xml->addNode('private_amenity_short_tag', stripslashes($private_amenities_arr->short_tag)); 
				$xml->endBranch(); 
			} 
			$xml->endBranch();  	
		}  
	} 		
			
			
	if(strlen($property_arr->commercial_amenities_data)>0){
		$commercial_amenities_arrs = $this->property_features_model->get_all_property_features_in_id($property_arr->commercial_amenities_data);
		if(isset($commercial_amenities_arrs) && count($commercial_amenities_arrs)>0){
				
			$xml->startBranch('commercial_amenities_list');
			foreach($commercial_amenities_arrs as $commercial_amenities_arr){  
				$xml->startBranch('commercial_amenities_item'); 
				 
				$xml->addNode('commercial_amenity_title', stripslashes($commercial_amenities_arr->title));
				$xml->addNode('commercial_amenity_short_tag', stripslashes($commercial_amenities_arr->short_tag)); 
				$xml->endBranch(); 
			} 
			$xml->endBranch();  	
		}  
	}
				
				//$xml->addNode('private_amenities_data', stripslashes($property_arr->private_amenities_data));  
				//$xml->addNode('commercial_amenities_data', stripslashes($property_arr->commercial_amenities_data));
				
				
				
				$xml->addNode('owner_id', stripslashes($property_arr->owner_id));
				$xml->addNode('owner_name', stripslashes($property_arr->ownr_name));
				//$xml->addNode('owner_phone_no', stripslashes($property_arr->ownr_phone_no)); 
				$xml->addNode('property_status', $db_property_status);  
				$xml->addNode('source_of_listing', stripslashes($property_arr->src_title));
				//$xml->addNode('source_of_listing', stripslashes($property_arr->source_of_listing));
				$xml->addNode('is_featured', $is_featured);
				  
				$xml->addNode('location_latitude', stripslashes($property_arr->location_latitude));  
				$xml->addNode('location_longitude', stripslashes($property_arr->location_longitude));
				$xml->addNode('created_on', stripslashes($property_arr->created_on)); 
				 
				$xml->addNode('updated_on', stripslashes($property_arr->updated_on));  
				//$xml->addNode('created_by', stripslashes($property_arr->created_by));  
				 
				
				$cstm_img_path = $photos_list = '';
				$k=1;
				if(isset($photos_arrs) && count($photos_arrs) >0){
					$cstm_img_path = base_url()."downloads/property_photos/".$photos_arrs[0]->image;
					  
					foreach($photos_arrs as $photos_arr){ 
						$photos_list .= base_url()."downloads/property_photos/".$photos_arr->image.'|';  
						$k++;
					} 
					$photos_list = substr($photos_list,0,-1); 
					
					$xml->addNode('featured_image', $cstm_img_path); 
				 
					$xml->addNode('gallery_images', $photos_list); 
					
				} 
			  
				 
				if(isset($documents_arrs) && count($documents_arrs)>0){  
					$xml->startBranch('documents_list');
					foreach($documents_arrs as $documents_arr){ 
						if(stripslashes($documents_arr->name)){
							$xml->startBranch('document_item'); 
							$document_name = base_url()."downloads/property_documents/".$documents_arr->name;
							
							$xml->addNode('document_name', $document_name); 
							$xml->endBranch();
						}
					} 
					$xml->endBranch(); 
				}  	  	 	 	
				 
				$xml->endBranch();
			}
		
			$xml->endBranch(); 
				
			// Pass the XML to the view
			$data = array();
			$data['xml'] = $xml->getXml(FALSE);
		}else{
			$data = array();
		}
		$this->load->view('xmls', $data);
	}
	
	function propertyfinder(){

		$property_arrs = $this->xmls_model->get_all_propertyfinder_xmls_list_properties_list(); 
		$property_arrs_nums = count($property_arrs);
		if(isset($property_arrs) && $property_arrs_nums >0){
			$last_update_val = ''; //$property_arrs[0]->updated_on; 
			$property_ar0 = $this->xmls_model->get_single_propertyfinder_xml_property();
			if(isset($property_ar0)){
				$last_update_val = $property_ar0->updated_on;
			}
			// Load XML writer library
			$this->load->library('xml_writer');
			
			// Initiate class
			$xml = new Xml_writer();
			/*, $photos_val, array('last_update' => $photos_arr->datatimes,'watermark' => 'yes'), true)*/
			$xml->setRootName('list');  
			$xml->initiate();
			$xml->writeAttribute('last_update', $last_update_val);
			$xml->writeAttribute('listing_count', $property_arrs_nums); 
			//$xml->startBranch('list', array('country' => 'usa'));
			foreach($property_arrs as $property_arr){ 
			
				$db_assigned_to_name = $property_arr->asgn_usr_name;
				$db_assigned_to_email = $property_arr->asgn_email;
				$db_assigned_to_phone_no = $property_arr->asgn_phone_no;  
				$db_assigned_to_id = $property_arr->asgn_usr_id;
				$db_assigned_to_image = $property_arr->asgn_usr_image;
				$db_assigned_to_address = $property_arr->asgn_usr_address;
				$db_assigned_to_rera_no = $property_arr->asgn_usr_rera_no;
				$pp_cate_name = $property_arr->cate_name; 
				$db_property_type = $property_arr->property_type;
				  
				$db_cate_property_type = $property_arr->cate_property_type; 
				
				$db_no_of_beds = ''; //$property_arr->bed_title; 
				
				$db_location_name = $property_arr->emlc_name; 
				$db_sub_location_name = $property_arr->sub_loc_name; 
				  
				$sale_loc_text = $rent_loc_text = $loc_description = ''; 
				if($property_arr->location_id >0){
					$locts_arr =  $this->emirates_location_model->get_emirate_location_by_id($property_arr->location_id); 
					$sale_loc_text = stripslashes($locts_arr->sale_text);
					$rent_loc_text = stripslashes($locts_arr->rent_text);
					$loc_description = stripslashes($locts_arr->description);
				} 
				
				
				$db_assigned_to_rera_no = $temp_agt_name = $temp_agt_email = $temp_agt_mobile = $temp_agt_id = $temp_agt_company_name = $temp_agt_rera_no = '';
				if($property_arr->assigned_to_id >0){
					$usr_arr = $this->general_model->get_user_info_by_id($property_arr->assigned_to_id);
					$temp_agt_company_name = stripslashes($usr_arr->company_name);
					$db_assigned_to_rera_no = $temp_agt_rera_no = stripslashes($usr_arr->rera_no);
					$temp_agt_name = stripslashes($usr_arr->name);
					$temp_agt_email = stripslashes($usr_arr->email);
					$temp_agt_mobile = stripslashes($usr_arr->mobile_no);
					$temp_agt_id = stripslashes($usr_arr->id);
				}
					
				  
				$db_is_furnished = '';
				if($property_arr->is_furnished==0){
					$db_is_furnished = 'No';
				}else if($property_arr->is_furnished==1){
					$db_is_furnished = 'Yes';
				}else if($property_arr->is_furnished==2){
					$db_is_furnished = 'Partly';
				}  
				
				$db_frequency_vals ='';
				/*if($property_arr->frequency_vals==0){
					$db_frequency_vals = ''; //None';
				}else if($property_arr->frequency_vals==1){
					$db_frequency_vals = 'D'; //'Per Day';
				}else if($property_arr->frequency_vals==2){
					$db_frequency_vals = 'W'; //'Per Week'; 
				}else if($property_arr->frequency_vals==3){
					$db_frequency_vals = 'M'; //'Per Month'; 
				}else if($property_arr->frequency_vals==4){
					$db_frequency_vals = 'Y'; //'Per Year'; 
				}*/
				
				$db_is_published = ''; //($property_arr->is_published==1) ? 'Publish' : 'Un-Published';
				 
				$db_reminds = ''; //($property_arr->reminds==1) ? 'Yes' : 'Never'; 
				 
				$db_is_invite = ''; //($property_arr->is_invite==1) ? 'Yes' : 'No';  
				$db_is_poa = ''; //($property_arr->is_poa==1) ? 'Yes' : 'No'; 
				
				//$db_property_type = $this->general_model->get_gen_property_type($property_arr->property_type);
				$db_property_type = '';
				if($property_arr->property_type==1){
					$db_property_type = 'Sale';
				}else if($property_arr->property_type==2){
					$db_property_type = 'Rent';
				}
				
				
				$db_property_status = $this->general_model->get_gen_property_status($property_arr->property_status);
				
				$db_owner_name = $property_arr->ownr_name; 
				
				$db_sizeunits = $this->general_model->get_property_ms_unit($property_arr->property_ms_unit);
				
				$photos_arrs = $this->properties_model->get_property_dropzone_photos_by_id($property_arr->id); 	
				$documents_arrs = $this->properties_model->get_property_dropzone_documents_by_id($property_arr->id); 
				// Start branch 'List_Item'
				$xml->startBranch('property', array('last_update' => $property_arr->updated_on));
				$xml->addNode('reference_number', $property_arr->ref_no); 
				//$xml->addNode('permit_number', $property_arr->permit_number);  /* issues for values */
				 
				$offering_type = '';
				if($property_arr->property_type==1 && $db_cate_property_type==1){
					$offering_type = 'RS'; 
				}else if($property_arr->property_type==1 && $db_cate_property_type==2){
					$offering_type =  'CS'; 
				}else if($property_arr->property_type==2 && $db_cate_property_type==1){
					$offering_type = 'RR'; 
				}else if($property_arr->property_type==2 && $db_cate_property_type==2){
					$offering_type = 'CR';
				}
				
				$xml->addNode('offering_type', $offering_type);
	
				$property_type_val = '';
				/*
				check thissssssss
				if($property_arr->cate_id >0){ 
					$cate_prtl_arr = $this->admin_model->get_category_portal_abbrevations_data($property_arr->cate_id,'4');
					if(isset($cate_prtl_arr)){
						$property_type_val = $cate_prtl_arr->abbrevations;
						
					} 
				}*/ 
				 
				
				$pp_price1 = CRM_CURRENCY.' '.number_format($property_arr->price,2,".",","); 
				
				
				$pp_price = number_format($property_arr->price); 
				$pp_price = str_replace(',', '', $pp_price);
				$pp_price = str_replace('.', '', $pp_price);
  				 
				$xml->addNode('property_type', $property_type_val);
				
				$xml->addNode('price_on_application','');  
				$xml->addNode('price', $pp_price);
				$xml->addNode('service_charge','');
				$xml->addNode('rental_period',$db_frequency_vals);
				$xml->addNode('cheques',''); /* issue here */
				$xml->addNode('city', stripslashes($property_arr->emirat_name));
				$xml->addNode('community', $db_location_name); 
				$xml->addNode('sub_community', $db_sub_location_name);
				 
				$db_sub_location_area_id = $property_arr->sub_location_area_id; 
				if($db_sub_location_area_id >0){ 
					$subloc_area_arr =  $this->admin_model->get_emirate_sub_location_area_by_id($db_sub_location_area_id); 
					if(isset($subloc_area_arr )){
						$sub_loc_areas = stripslashes($subloc_area_arr->name);
						$xml->addNode('property_name', $sub_loc_areas);
					}
				}
				
				 /* issue here of difference */
				$xml->addNode('title_en', stripslashes($property_arr->title));
				$xml->addNode('title_ar', '');
				  
				$pp_title = stripslashes($property_arr->title);
				$pp_plot_area =  $property_arr->plot_area; 
				$pp_no_of_beds = $db_no_of_beds;
				$pp_no_of_views = $property_arr->no_of_views;
				 
				 
				$pp_closed_to = ''; //stripslashes($property_arr->closed_to);
				$pp_facilities = stripslashes($property_arr->facilities); 
				
	  
				$pp_property_ms_unit = $this->general_model->get_property_ms_unit($property_arr->property_ms_unit);  
				$pp_parking = ''; //stripslashes($property_arr->parking);
				
				 
				$pp_no_of_baths = $property_arr->no_of_baths;
				if($pp_no_of_baths==1){
					$pp_no_of_baths = $pp_no_of_baths." Bathroom";
				}else if($pp_no_of_baths >1){
					$pp_no_of_baths = $pp_no_of_baths." Bathrooms";
				}
				
				$temp_agt_email_1 = str_replace("@", "(at)", "$temp_agt_email");
				
				
				$property_complete_desc = $property_desc_heading = $property_desc_footer = '';
				if(isset($this->config_arr) && strlen($this->config_arr->property_desc_heading)>0){ 
					$property_desc_heading = stripslashes($this->config_arr->property_desc_heading);  
					
					$pp_no_of_beds = str_replace(" Beds", '', "$pp_no_of_beds");
					$pp_no_of_beds = str_replace(" Bed", '', "$pp_no_of_beds");
					 
					
					$property_desc_heading = str_replace("[[agent_name]]", "$temp_agt_name : ", "$property_desc_heading");
					$property_desc_heading = str_replace("[[agent_contact_no]]", "$temp_agt_mobile", "$property_desc_heading"); 
					
					$property_desc_heading = str_replace("[[agent_email]]", "$temp_agt_email_1", "$property_desc_heading"); 
									
					$property_desc_heading = str_replace("[[property_bedrooms]]", "$pp_no_of_beds", "$property_desc_heading");
					$property_desc_heading = str_replace("[[listing_category]]", "$pp_cate_name", "$property_desc_heading");
					$property_desc_heading = str_replace("[[property_bathroom]]", "$pp_no_of_baths", "$property_desc_heading");
					
					$property_desc_heading = str_replace("[[property_size]]", "$pp_plot_area", "$property_desc_heading");
	
					$property_desc_heading = str_replace("[[measuring_unit]]", "$pp_property_ms_unit", "$property_desc_heading");
					$property_desc_heading = str_replace("[[property_view]]", "$pp_no_of_views", "$property_desc_heading");
					
					$property_desc_heading = str_replace("[[parking_space]]", "$pp_parking", "$property_desc_heading");
					
					$property_desc_heading = str_replace("[[closed_to]]", "$pp_closed_to", "$property_desc_heading");
					$property_desc_heading = str_replace("[[facilities]]", "$pp_facilities", "$property_desc_heading");
					$property_desc_heading = str_replace("[[property_price]]", "$pp_price1", "$property_desc_heading"); 
					
					$property_complete_desc .= $property_desc_heading; 
				} 
				
				/*if(strlen($loc_description)>0){
					$property_complete_desc .= "<br>".$loc_description;
				}else if(strlen($this->config_arr->generic_location_desc)>0){
						$property_complete_desc .= "<br>".stripslashes($this->config_arr->generic_location_desc); 
					}*/
				
				if($property_arr->property_type==2){ 
					 
					if(strlen($rent_loc_text)>0){
						$property_complete_desc .= "<br>".$rent_loc_text;
					}else{
						//$property_complete_desc .= "<br>".stripslashes($this->config_arr->generic_rent_location_desc); 	
					}
					
				}else{ 
					 
					if(strlen($sale_loc_text)>0){
						$property_complete_desc .= "<br>".$sale_loc_text;
					}else{
						//$property_complete_desc .= "<br>".stripslashes($this->config_arr->generic_sale_location_desc); 	
					}
				} 	
						
				/*if(isset($this->config_arr) && strlen($this->config_arr->property_desc_footer)>0){ 
					$property_desc_footer = stripslashes($this->config_arr->property_desc_footer); 
					 
					if(strlen($property_desc_footer)>0){
						$property_complete_desc .= "<br>".$property_desc_footer;
					}
				}*/
				 
				$property_complete_desc = str_replace("<br>", "\n", "$property_complete_desc");
				$xml->addNode('description_en', $property_complete_desc, array(), true); 
				/* CDATA issue stripslashes($property_arr->description) */
				$xml->addNode('description_ar', '');
				
				/*$private_amenities_val = $this->general_model->get_private_featured_list_code('');
				$commercial_amenities_val = $this->general_model->get_commercial_featured_list_code(''); //SP - Shared Pool => not available
				 
			    $xml->addNode('private_amenities', $private_amenities_val);
				$xml->addNode('commercial_amenities', $commercial_amenities_val); */
				 
			/*$private_featured = $commercial_featured = '';
			
			$features_arr1s = $this->admin_model->get_portal_private_feature_properties_list('4',$property_arr->id);
			
			if(isset($features_arr1s) && count($features_arr1s)>0){  
				foreach($features_arr1s as $features_arr1){
					$private_featured .= $features_arr1->abbrevations.', '; 
				}  
				
				$private_featured = substr($private_featured,0,-2); 
			}
			 
			$features_arr2s = $this->admin_model->get_portal_commerical_feature_properties_list('4',$property_arr->id);
			
			if(isset($features_arr2s) && count($features_arr2s)>0){  
				foreach($features_arr2s as $features_arr2){
					$commercial_featured .= $features_arr2->abbrevations.', '; 
				}
				
				$commercial_featured = substr($commercial_featured,0,-2);  
			} */ 
			
			 
			
		/*$comb_featured_list = $private_featured = $commercial_featured = '';
		if($db_cate_property_type==1){ 
			
			$features_arr1s = $this->admin_model->get_portal_private_feature_properties_list('4',$property_arr->id);
			
			if(isset($features_arr1s) && count($features_arr1s)>0){  
				foreach($features_arr1s as $features_arr1){
					$temp_amenities_types = explode(',',$features_arr1->amenities_types);
					if(isset($temp_amenities_types) && (in_array($db_cate_property_type,$temp_amenities_types))) {
						$private_featured .= $features_arr1->abbrevations.', ';
						
						$comb_featured_list .= stripslashes($features_arr1->title).', ';
					}
				}  
				if(strlen($private_featured)>0){
					$private_featured = substr($private_featured,0,-2);
				}  
			}
		}	 
			 
		if($db_cate_property_type==2){ 
			 
			$features_arr2s = $this->admin_model->get_portal_commerical_feature_properties_list('4',$property_arr->id);
			
			if(isset($features_arr2s) && count($features_arr2s)>0){  
				foreach($features_arr2s as $features_arr2){  
					$temp_amenities_types = explode(',',$features_arr2->amenities_types);
					if(isset($temp_amenities_types) && count($temp_amenities_types)>0){
						 
						 if(in_array($db_cate_property_type,$temp_amenities_types)) {   
							$commercial_featured .= $features_arr2->abbrevations.', ';
							$comb_featured_list .= stripslashes($features_arr2->title).', ';
						 }
					} 
				}
				
				if(strlen($commercial_featured)>0){
					$commercial_featured = substr($commercial_featured,0,-2); 
				} 
			}  	
		}	
			  
		if(strlen($comb_featured_list)>0){ 
			$comb_featured_list = substr($comb_featured_list,0,-2); 
		}
		
		if(strlen($private_featured)>0){ 
			$xml->addNode('private_amenities', $private_featured);
		}
		
		if(strlen($commercial_featured)>0){
			$xml->addNode('commercial_amenities', $commercial_featured);
		} */
			
		$comb_featured_list = $private_featured = $commercial_featured = '';
		if(isset($property_arr->show_on_portal_ids) && strlen($property_arr->show_on_portal_ids)>0){
			$sel_portal_arr_ids = explode(',',$property_arr->show_on_portal_ids); 
			if(isset($sel_portal_arr_ids) && count($sel_portal_arr_ids)>0){
				if(in_array("4", $sel_portal_arr_ids)){
					
					if(strlen($property_arr->feature_ids)>0){
						$features_arrs = $this->admin_model->get_all_property_features_in_id($property_arr->feature_ids); 
						
						if(isset($features_arrs) && count($features_arrs)>0){
							 
							foreach($features_arrs as $features_arr){ 
								 
							if($features_arr->amenities_types==1){
											
								 $features_abs_arr = $this->admin_model->get_featured_portal_abbrevations_data($features_arr->id,'4');
								 if(isset($features_abs_arr)){
									 $private_featured .= $features_abs_arr->abbrevations.', '; 
									 $comb_featured_list .= $features_abs_arr->abbrevations.', ';
								 } 								
																
							}else if($features_arr->amenities_types==2){ 
								
								$features_abs_arr = $this->admin_model->get_featured_portal_abbrevations_data($features_arr->id,'4');
								 if(isset($features_abs_arr)){
									 $commercial_featured .= $features_abs_arr->abbrevations.', '; 
									 $comb_featured_list .= $features_abs_arr->abbrevations.', '; 
								 }
							}
									
								  
							}  
						} 
					}
				}
			}
		} 
			
			if(strlen($comb_featured_list)>0){ 
				$comb_featured_list = substr($comb_featured_list,0,-2); 
			}
			
			if($db_cate_property_type==1 && strlen($private_featured)>0){ 
				$private_featured = substr($private_featured,0,-2);  
				$xml->addNode('private_amenities', $private_featured);
			}
			
			if($db_cate_property_type==2 && strlen($commercial_featured)>0){
				$commercial_featured = substr($commercial_featured,0,-2); 
				$xml->addNode('commercial_amenities', $commercial_featured);
			}
			 
				  
				$is_featured = ($property_arr->is_featured==1) ? 'Yes' : 'No';
				
				$dbs_facilities = ''; //stripslashes($property_arr->facilities);
				$xml->addNode('features', $comb_featured_list); 
				/* issue here*/
				$xml->addNode('view', stripslashes($property_arr->no_of_views), array(), true); 
				$db_size = stripslashes($property_arr->plot_area);
				$plot_size = $db_size + 0.25 * $db_size;
				
				$xml->addNode('plot_size', $plot_size); /* issue here*/
				$xml->addNode('size', $db_size); 
				  
				
				if($db_no_of_beds=="None"){
					$db_no_of_beds = '';
				} 
				if($db_no_of_beds=="Studio"){
					$db_no_of_beds = 0;
				} 
				$db_no_of_beds = str_replace(' Beds','',$db_no_of_beds);
				$db_no_of_beds = str_replace(' Bed','',$db_no_of_beds); 
				
				/*issue for case for none and 9+ as 9, 10, +10 values*/
				if($db_cate_property_type==2){
					$xml->addNode('bedroom', "None"); 
				}else{
					$xml->addNode('bedroom', $db_no_of_beds);
				}
				$no_of_baths = stripslashes($property_arr->no_of_baths);
				if($no_of_baths >7){
					$no_of_baths = "7+";	
				}
				$xml->addNode('bathroom', $no_of_baths);
				 
				$xml->startBranch('agent');
					//$xml->addNode('id', $db_assigned_to_id);  
					$xml->addNode('name', $temp_agt_name);
					$xml->addNode('email', $temp_agt_email); 
					$xml->addNode('phone', $temp_agt_mobile); 
					$xml->addNode('license_no', $db_assigned_to_rera_no); 
					/*$xml->addNode('photo', $db_assigned_to_image);  
					$xml->addNode('info', $db_assigned_to_address);*/
				$xml->endBranch();   
				
				$xml->addNode('developer', '');
				$xml->addNode('build_year', '');
				$xml->addNode('floor', '');
				$xml->addNode('floors_number', '');
				$xml->addNode('stories', '');
				$xml->addNode('parking', stripslashes($property_arr->parking)); /* issue for alphas values*/
				$xml->addNode('furnished', $db_is_furnished);
				$xml->addNode('view360', $property_arr->youtube_video_link); /* issue for alphas values*/
				 
				$img_lmt =10;
				if(isset($documents_arrs) && count($documents_arrs) >0){
					$img_lmt = 8; 
				}
				
				$y=1;
				if(isset($photos_arrs) && count($photos_arrs) >0){
					$xml->startBranch('photo');   
					foreach($photos_arrs as $photos_arr){ 
						$photos_val = base_url()."downloads/property_photos/".$photos_arr->image;  
						$xml->addNode('url', $photos_val, array('last_updated' => $photos_arr->datatimes,'watermark' => 'yes'), true);
						 
						 
						/*if($img_lmt >$y){
							break; 
						}*/
						
						$y++;
					} 
					$xml->endBranch();
				 }  
				 
				 $z=1;
				 if(isset($documents_arrs) && count($documents_arrs) >0){
					$xml->startBranch('documents_item');  
						 
					foreach($documents_arrs as $documents_arr){ 
						$flrplan_val = base_url()."downloads/property_documents/".$documents_arr->name;  
						$xml->addNode('url', $flrplan_val, array('last_updated' => $documents_arr->datatimes,'watermark' => 'yes'), true);
						
						/*if($z >2){
							break; 
						}*/
						
						$z++;
						 
					} 
					$xml->endBranch();
				 }    
				
				$geopoints = '';
				if(strlen($property_arr->location_latitude)>0 && strlen($property_arr->location_longitude)>0){
					 $geopoints = $property_arr->location_latitude.', '.$property_arr->location_longitude;
				} 
				  
				$xml->addNode('geopoints', $geopoints);
				//$xml->addNode('permit_number', ''); /* issue here */
				 
				$xml->endBranch();
				 
			}
			// End branch 'bikes'
			$xml->endBranch(); 
				
			// Pass the XML to the view
			$data = array();
			$data['xml'] = $xml->getXml(FALSE);
		}else{
			$data = array();
		}
		$this->load->view('xmls', $data);
	} 
	
 
	
}



