<!--<select name="location_id" id="location_id" class="form-control" onChange="get_emirate_sub_location(this.value,'<?php //echo site_url('properties/fetch_property_emirate_sub_locations'); ?>','fetch_emirate_sub_locations');">--> 
<select name="location_id" id="location_id" class="form-control select" onChange="get_property_emirate_sub_location(this.value,'<?php echo site_url('properties/fetch_property_emirate_sub_locations'); ?>','fetch_emirate_sub_locations');" data-error="#location_id1"> 
 <option value="">Select Emirate Location </option> 
 <?php  
	if(isset($emirate_location_arrs) && count($emirate_location_arrs)>0){
		foreach($emirate_location_arrs as $emirate_location_arr){ ?>
			<option value="<?= $emirate_location_arr->id; ?>"> <?= stripslashes($emirate_location_arr->name); ?></option> 	
	<?php 
		}
	} ?> 
 </select>