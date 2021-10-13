<select name="sub_location_id" id="sub_location_id" multiple="multiple"> 
<?php  
	if(isset($emirate_sub_location_arrs) && count($emirate_sub_location_arrs)>0){
		foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){ ?>
			<option value="<?= $emirate_sub_location_arr->id; ?>"> <?= stripslashes($emirate_sub_location_arr->name); ?></option> 	
	<?php 
		}
	} ?> 
</select>