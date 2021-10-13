<?php  	
	$this->properties_list_module_access = 0;
	$this->properties_list_add_module_access = 0;
	$this->properties_list_edit_module_access = 0;
	$this->properties_list_delete_module_access = 0;
	$this->properties_list_view_module_access = 0;
	
	$this->properties_marketing_media_sec_access = 0;
	$this->properties_additional_info_sec_access = 0;
	$this->properties_portal_sec_access = 0;
	
	
	$this->properties_others_info_sec_access = 0;
	$this->properties_location_info_sec_access = 0; 
	  
	/* Permissions to properties list starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('1', 'module_id', $permission_results_arr);  
	if($chk_rets){
	 
		$db_module_section_ids_vals = $this->general_model->in_array_section_field('1', 'module_id', 'module_section_ids', $permission_results_arr);
		if(isset($db_module_section_ids_vals) && strlen($db_module_section_ids_vals)>0){ 
			$db_module_section_ids_arrs = explode(',',$db_module_section_ids_vals);
		}	
		$this->properties_list_module_access = 1;
		 
		$chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_list_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_list_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->properties_list_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_list_delete_module_access = 1;
		} 
		
		
		
		if(isset($db_module_section_ids_arrs) && count($db_module_section_ids_arrs)>0){
	
			if(in_array("1", $db_module_section_ids_arrs)) {
				$this->properties_marketing_media_sec_access = 1;
			}
			 
			if(in_array("2", $db_module_section_ids_arrs)) {
				$this->properties_additional_info_sec_access = 1;
			} 
			
			if(in_array("3", $db_module_section_ids_arrs)) {
				$this->properties_portal_sec_access = 1;
				//$this->properties_others_info_sec_access = 1;
			}
			 
			if(in_array("4", $db_module_section_ids_arrs)) {
				$this->properties_location_info_sec_access = 1;
			} 
		}  
	}
	/* Permissions to properties list ends */
 
	$this->properties_archived_list_module_access = 0;
	$this->properties_archived_add_module_access = 0;
	$this->properties_archived_edit_module_access = 0;
	$this->properties_archived_delete_module_access = 0;
	$this->properties_archived_view_module_access = 0;
	/* Permissions to Archived Properties starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('2', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->properties_archived_list_module_access = 1;   
		
		$chk_rets = $this->general_model->in_array_field('2', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_archived_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('2', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_archived_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('2', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_archived_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('2', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_archived_delete_module_access = 1;
		
		}  
	}
	/* Permissions to Archived Properties ends */

	$this->contacts_list_module_access = 0;
	$this->contacts_add_module_access = 0;
	$this->contacts_edit_module_access = 0;
	$this->contacts_delete_module_access = 0;
	$this->contacts_view_module_access = 0;
	/* Permissions to Contacts list starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('3', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->contacts_list_module_access = 1; 
		
		$chk_rets = $this->general_model->in_array_field('3', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->contacts_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('3', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->contacts_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('3', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->contacts_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('3', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->contacts_delete_module_access = 1;
		}  
	}
	/* Permissions to Contacts list ends */
	
	$this->portals_list_module_access = 0;
	$this->portals_add_module_access = 0;
	$this->portals_edit_module_access = 0;
	$this->portals_delete_module_access = 0;
	$this->portals_view_module_access = 0;
	/* Permissions to Portals starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('4', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->portals_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('4', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->portals_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('4', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->portals_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('4', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->portals_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('4', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->portals_delete_module_access = 1;
		}  	
	}
	/* Permissions to Portals ends */
	
	$this->categories_list_module_access = 0;
	$this->categories_add_module_access = 0;
	$this->categories_edit_module_access = 0;
	$this->categories_delete_module_access = 0;
	$this->categories_view_module_access = 0;
	/* Permissions to Categories starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('5', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->categories_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('5', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->categories_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('5', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->categories_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('5', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->categories_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('5', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
				$this->categories_delete_module_access = 1;
		}  	
	}
	/* Permissions to Categories ends */
	
	$this->property_features_list_module_access = 0;
	$this->property_features_add_module_access = 0;
	$this->property_features_edit_module_access = 0;
	$this->property_features_delete_module_access = 0;
	$this->property_features_view_module_access = 0;
	/* Permissions to Property Features starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('6', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->property_features_list_module_access = 1; 
		
		$chk_rets = $this->general_model->in_array_field('6', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->property_features_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('6', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->property_features_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('6', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->property_features_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('6', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->property_features_delete_module_access = 1;
		}  	
	}
	/* Permissions to Property Features ends */
	
	$this->source_of_listings_list_module_access = 0;
	$this->source_of_listings_add_module_access = 0;
	$this->source_of_listings_edit_module_access = 0;
	$this->source_of_listings_delete_module_access = 0;
	$this->source_of_listings_view_module_access = 0;
	/* Permissions to Source of Listings starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('7', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->source_of_listings_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('7', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->source_of_listings_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('7', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->source_of_listings_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('7', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->source_of_listings_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('7', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->source_of_listings_delete_module_access = 1;
		}  	
	}
	/* Permissions to Source of Listings ends */
	
	$this->neighbourhoods_list_module_access = 0;
	$this->neighbourhoods_add_module_access = 0;
	$this->neighbourhoods_edit_module_access = 0;
	$this->neighbourhoods_delete_module_access = 0;
	$this->neighbourhoods_view_module_access = 0;
	/* Permissions to Neighbourhoods starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('8', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->neighbourhoods_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('8', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->neighbourhoods_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('8', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->neighbourhoods_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('8', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->neighbourhoods_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('8', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->neighbourhoods_delete_module_access = 1;
		}  
	}
	/* Permissions to Neighbourhoods ends */
	
	$this->emirates_list_module_access = 0;
	$this->emirates_add_module_access = 0;
	$this->emirates_edit_module_access = 0;
	$this->emirates_delete_module_access = 0;
	$this->emirates_view_module_access = 0;
	/* Permissions to Emirate starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('9', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->emirates_list_module_access = 1; 
		
		$chk_rets = $this->general_model->in_array_field('9', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirates_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('9', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirates_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('9', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->emirates_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('9', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirates_delete_module_access = 1;
		}  	
	}
	/* Permissions to Emirate ends */
	
	
	$this->emirate_locations_list_module_access = 0;
	$this->emirate_locations_add_module_access = 0;
	$this->emirate_locations_edit_module_access = 0;
	$this->emirate_locations_delete_module_access = 0;
	$this->emirate_locations_view_module_access = 0;
	/* Permissions to Emirate Locations starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('10', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->emirate_locations_list_module_access = 1; 
		
		$chk_rets = $this->general_model->in_array_field('10', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirate_locations_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('10', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirate_locations_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('10', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->emirate_locations_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('10', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirate_locations_delete_module_access = 1;
		}  	
	}
	/* Permissions to Emirate Locations ends */
	
	$this->emirate_sub_locations_list_module_access = 0;
	$this->emirate_sub_locations_add_module_access = 0;
	$this->emirate_sub_locations_edit_module_access = 0;
	$this->emirate_sub_locations_delete_module_access = 0;
	$this->emirate_sub_locations_view_module_access = 0;
	/* Permissions to Emirate Sub Locations starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('11', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->emirate_sub_locations_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('11', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirate_sub_locations_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('11', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirate_sub_locations_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('11', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->emirate_sub_locations_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('11', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->emirate_sub_locations_delete_module_access = 1;
		}  
	}
	/* Permissions to Emirate Sub Locations ends */
	 
	
	$this->no_of_beds_list_module_access = 0;
	$this->no_of_beds_add_module_access = 0;
	$this->no_of_beds_edit_module_access = 0;
	$this->no_of_beds_delete_module_access = 0;
	$this->no_of_beds_view_module_access = 0;
	/* Permissions to Emirate Sub Locations starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('14', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->no_of_beds_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('14', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->no_of_beds_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('14', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->no_of_beds_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('14', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->no_of_beds_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('14', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->no_of_beds_delete_module_access = 1;
		}  
	}
	/* Permissions to Emirate Sub Locations ends */
	 
	$this->reports_list_module_access = 0;
	$this->reports_add_module_access = 0;
	$this->reports_edit_module_access = 0;
	$this->reports_delete_module_access = 0;
	$this->reports_view_module_access = 0;
	/* Permissions to Emirate Sub Locations starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('15', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->reports_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('15', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->reports_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('15', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->reports_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('15', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->reports_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('15', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->reports_delete_module_access = 1;
		}  
	}
	/* Permissions to Emirate Sub Locations ends */
	
	
	/* Permissions to Owners starts*/
	$this->owners_list_module_access = 0;
	$this->owners_add_module_access = 0;
	$this->owners_edit_module_access = 0;
	$this->owners_delete_module_access = 0;
	$this->owners_view_module_access = 0;
	
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('16', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->owners_list_module_access = 1;  
		
		$chk_rets = $this->general_model->in_array_field('16', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->owners_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('16', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->owners_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('16', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){ 
			$this->owners_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('16', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->owners_delete_module_access = 1;
		}  
	}
	/* Permissions to Owners ends */
	
	
	/* Permissions to sales properties list ends */
 
	$this->properties_sales_list_module_access = 0;
	$this->properties_sales_add_module_access = 0;
	$this->properties_sales_edit_module_access = 0;
	$this->properties_sales_delete_module_access = 0;
	$this->properties_sales_view_module_access = 0;
	/* Permissions to sales Properties starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('17', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->properties_sales_list_module_access = 1;   
		
		$chk_rets = $this->general_model->in_array_field('17', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_sales_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('17', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_sales_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('17', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_sales_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('17', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_sales_delete_module_access = 1;
		
		}  
	}
	/* Permissions to sales Properties ends */
	
	 
	/* Permissions to rentals properties list ends */
 
	$this->properties_rentals_list_module_access = 0;
	$this->properties_rentals_add_module_access = 0;
	$this->properties_rentals_edit_module_access = 0;
	$this->properties_rentals_delete_module_access = 0;
	$this->properties_rentals_view_module_access = 0;
	/* Permissions to rentals Properties starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('18', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->properties_rentals_list_module_access = 1;   
		
		$chk_rets = $this->general_model->in_array_field('18', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_rentals_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('18', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_rentals_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('18', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_rentals_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('18', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_rentals_delete_module_access = 1;
		
		}  
	}
	/* Permissions to rentals Properties ends */
	
	
	
	
	/* Permissions to dealt properties list ends */
 
	$this->properties_dealt_list_module_access = 0;
	$this->properties_dealt_add_module_access = 0;
	$this->properties_dealt_edit_module_access = 0;
	$this->properties_dealt_delete_module_access = 0;
	$this->properties_dealt_view_module_access = 0;
	/* Permissions to dealt Properties starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('19', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->properties_dealt_list_module_access = 1;   
		
		$chk_rets = $this->general_model->in_array_field('19', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_dealt_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('19', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_dealt_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('19', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_dealt_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('19', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_dealt_delete_module_access = 1;
		
		}  
	}
	/* Permissions to dealt Properties ends */
	
	
	/* Permissions to deleted properties list ends */
 
	$this->properties_deleted_list_module_access = 0;
	$this->properties_deleted_add_module_access = 0;
	$this->properties_deleted_edit_module_access = 0;
	$this->properties_deleted_delete_module_access = 0;
	$this->properties_deleted_view_module_access = 0;
	/* Permissions to deleted Properties starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('20', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->properties_deleted_list_module_access = 1;   
		
		$chk_rets = $this->general_model->in_array_field('20', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_deleted_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('20', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_deleted_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('20', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_deleted_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('20', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_deleted_delete_module_access = 1;
		
		}  
	}
	/* Permissions to deleted Properties ends */
	
	
	
	
	/* Permissions to deleted properties list ends */
 
	$this->properties_leads_list_module_access = 0;
	$this->properties_leads_add_module_access = 0;
	$this->properties_leads_edit_module_access = 0;
	$this->properties_leads_delete_module_access = 0;
	$this->properties_leads_view_module_access = 0;
	/* Permissions to deleted Properties starts*/
	$permission_results_arr = $this->Permission_Results; 
	$chk_rets = $this->general_model->check_gen_module_permission('21', 'module_id', $permission_results_arr);  
	if($chk_rets){
		$this->properties_leads_list_module_access = 1;   
		
		$chk_rets = $this->general_model->in_array_field('21', 'module_id','1', 'is_add_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_leads_add_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('21', 'module_id','1', 'is_update_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_leads_edit_module_access = 1; 
		}
		
		$chk_rets = $this->general_model->in_array_field('21', 'module_id','1', 'is_view_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_leads_view_module_access = 1;
		}
		
		$chk_rets = $this->general_model->in_array_field('21', 'module_id','1', 'is_delete_permission', $permission_results_arr);  
		if($chk_rets){
			$this->properties_leads_delete_module_access = 1;
		
		}  
	}
	/* Permissions to deleted Properties ends */
	
	
	 
	?>
