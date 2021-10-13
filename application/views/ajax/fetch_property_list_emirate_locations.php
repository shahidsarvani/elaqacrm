<select name="location_id" id="location_id" multiple="multiple">  
 <?php  
	if(isset($emirate_location_arrs) && count($emirate_location_arrs)>0){
		foreach($emirate_location_arrs as $emirate_location_arr){ ?>
			<option value="<?= $emirate_location_arr->id; ?>"> <?= stripslashes($emirate_location_arr->name); ?></option> 	
	<?php 
		}
	} ?> 
 </select>