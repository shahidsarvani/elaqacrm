/* ------------------------------------------------------------------------------
*
*  # Bootstrap multiselect
*
*  Specific JS code additions for form_multiselect.html page
*
*  Version: 1.1
*  Latest update: Oct 20, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Basic examples
    // ------------------------------
	var str_val_temp = ""; 
	var str2_val_temp = ""; 
	$('#category_id').multiselect({
		nonSelectedText: 'Categories',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#category_id :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined',''); 
			document.getElementById("category_ids").value = str_val;
			operate_properties(); 
		}
	});
	
	
	
	$('#emirate_id').multiselect({
		nonSelectedText: 'Emirates',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#emirate_id :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined','');  
			
			var str_val_2 = str_val.replace(/,/g,'_'); 
			 
			document.getElementById("emirate_ids").value = str_val;
			var emirate_url = document.getElementById("emirate_url").value;
			
			get_property_list_emirate_location(str_val_2,emirate_url,'fetch_emirate_locations'); 
			operate_properties(); 
		}
	});
	
	$('#location_id').multiselect({
		nonSelectedText: 'Emirate Location',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#location_id :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined',''); 
			document.getElementById("location_ids").value = str_val;
			 
			var str_val_2 = str_val.replace(/,/g,'_'); 
			var location_url = document.getElementById("location_url").value;
			
			get_property_list_emirate_sub_location(str_val_2,location_url,'fetch_emirate_sub_locations');
			operate_properties();
		}
	});
	
	
	$('#sub_location_id').multiselect({
		nonSelectedText: 'Emirate Sub Location',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#sub_location_id :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined',''); 
			document.getElementById("sub_location_ids").value = str_val;
			operate_properties(); 
		}
	});
	
	
	
	$('#portal_id').multiselect({
		nonSelectedText: 'Portals',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#portal_id :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined',''); 
			document.getElementById("portal_ids").value = str_val;
			operate_properties(); 
		}
	});
	
	
	$('#assigned_to_id').multiselect({
		nonSelectedText: 'Assigned To',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#assigned_to_id :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined',''); 
			document.getElementById("assigned_to_ids").value = str_val;
			operate_properties(); 
		}
	});
	
	
	$('#owner_id').multiselect({
		nonSelectedText: 'Owners',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#owner_id :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined',''); 
			document.getElementById("owner_ids").value = str_val;
			operate_properties(); 
		}
	});
	
	
	$('#property_status').multiselect({
		nonSelectedText: 'Property Status',
		enableClickableOptGroups: true,
		enableCollapsibleOptGroups: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: false,
		maxHeight: 260,
		buttonWidth: '100%',
		dropUp: true, 
		onChange: function(option, checked, select) {
			str_val_temp = ""; 
			$('#property_status :selected').each(function(i, sel){  
				 str_val_temp += (str_val_temp == "") ? "" : ",";
				 str_val_temp += $(sel).val();
			}); 
			
			str_val = str_val_temp; 
			str_val = String(str_val);  
			str_val = str_val.replace(',undefined','');
			str_val = str_val.replace('undefined',''); 
			document.getElementById("m_property_status").value = str_val;
			operate_properties(); 
		}
	}); 
	
 
    // Related plugins
    // ------------------------------
    
    // Styled checkboxes and radios
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});

});
  

function adjust_multi_locations(){
	
	$(document).ready(function(){  
		$('#location_id').multiselect({
			nonSelectedText: 'Emirate Location',
			enableClickableOptGroups: true,
			enableCollapsibleOptGroups: true,
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: false,
			maxHeight: 260,
			buttonWidth: '100%',
			dropUp: true, 
			onChange: function(option, checked, select) {
				str_val_temp = ""; 
				$('#location_id :selected').each(function(i, sel){  
					 str_val_temp += (str_val_temp == "") ? "" : ",";
					 str_val_temp += $(sel).val();
				}); 
				
				str_val = str_val_temp; 
				str_val = String(str_val);  
				str_val = str_val.replace(',undefined','');
				str_val = str_val.replace('undefined',''); 
				document.getElementById("location_ids").value = str_val;
				 
				
				var str_val_2 = str_val.replace(/,/g,'_'); 
				var location_url = document.getElementById("location_url").value;	
				get_property_list_emirate_sub_location(str_val_2,location_url,'fetch_emirate_sub_locations'); 
				 
				operate_properties(); 
			}
		});	
		
		 $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'}); 
	});
}



function adjust_multi_sub_location(){
	
	$(document).ready(function(){  
		 $('#sub_location_id').multiselect({
			nonSelectedText: 'Emirate Sub Location',
			enableClickableOptGroups: true,
			enableCollapsibleOptGroups: true,
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: false,
			maxHeight: 260,
			buttonWidth: '100%',
			dropUp: true, 
			onChange: function(option, checked, select) {
				str_val_temp = ""; 
				$('#sub_location_id :selected').each(function(i, sel){  
					 str_val_temp += (str_val_temp == "") ? "" : ",";
					 str_val_temp += $(sel).val();
				}); 
				
				str_val = str_val_temp; 
				str_val = String(str_val);  
				str_val = str_val.replace(',undefined','');
				str_val = str_val.replace('undefined',''); 
				document.getElementById("sub_location_ids").value = str_val;
				operate_properties(); 
			}
		});
		
		 $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
	});
}


