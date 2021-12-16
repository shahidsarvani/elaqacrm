<select name="lead_id" id="lead_id" class="form-control select2-search" data-error="#lead_id1">
	<option value="">Select Lead...</option>
	<?php  
	if(isset($leads_arrs)){
		foreach($leads_arrs as $leads_arr){
			$sel_1 = '';
			if(isset($_POST['sl_leadid']) && $_POST['sl_leadid']==$leads_arr->id){
				$sel_1 = 'selected="selected"';
			}   ?>
			<option value="<?= $leads_arr->id; ?>" <?php echo $sel_1; ?>> <?= $leads_arr->ref_no; ?> </option>
	<?php 
		}
	} ?>
</select> 