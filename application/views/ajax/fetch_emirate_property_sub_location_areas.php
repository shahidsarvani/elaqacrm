<select name="sub_location_area_id" id="sub_location_area_id" class="form-control">
<option value="">Select Sub Location Areas</option> 
<?php  
	if(isset($emirate_sub_location_area_arrs) && count($emirate_sub_location_area_arrs)>0){
		foreach($emirate_sub_location_area_arrs as $emirate_sub_location_area_arr){ ?>
			<option value="<?= $emirate_sub_location_area_arr->id; ?>"> <?= stripslashes($emirate_sub_location_area_arr->name); ?></option> 	
	<?php 
		}
	} ?> 
</select>