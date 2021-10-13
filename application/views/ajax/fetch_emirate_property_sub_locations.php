<select name="sub_location_id" id="sub_location_id" class="form-control select">
<option value="">Select Emirate Sub Location </option> 
<?php  
	if(isset($emirate_sub_location_arrs) && count($emirate_sub_location_arrs)>0){
		foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){ ?>
			<option value="<?= $emirate_sub_location_arr->id; ?>"> <?= stripslashes($emirate_sub_location_arr->name); ?></option> 	
	<?php 
		}
	} ?> 
</select>

<!--onChange="get_property_emirate_sub_location_area(this.value,'<?php //echo site_url('properties/fetch_property_emirate_sub_location_areas'); ?>','fetch_emirate_sub_location_areas');"-->