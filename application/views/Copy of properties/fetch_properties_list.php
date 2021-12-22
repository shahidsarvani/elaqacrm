<?php if($_POST['paras1'] == 0){ ?>
	<select name="property_id" id="property_id" class="form-control select2-search" data-error="#property_id1">
		<option value="">Select Property...</option>
		<?php  
			if(isset($properties_arrs)){
				foreach($properties_arrs as $properties_arr){
					$sel_1 = '';
					if(isset($_POST['sl_propertyid']) && $_POST['sl_propertyid']==$properties_arr->id){
						$sel_1 = 'selected="selected"';
					} 
					 
					$pp_type_1 = ($properties_arr->property_type==1) ? 'Sale: ' : 'Rent: ';
					
					$property_title1 = $pp_type_1 . stripslashes($properties_arr->title).' ('.stripslashes($properties_arr->ref_no).') AED '.number_format($properties_arr->price,2,".",","); ?>
					<option value="<?= $properties_arr->id; ?>" <?php echo $sel_1; ?>> <?= $property_title1; ?> </option>
			<?php 
				}
			} ?>
		</select>

<?php }else{ ?>

	<select name="property_id_<?php echo $_POST['paras1']; ?>" id="property_id_<?php echo $_POST['paras1']; ?>" class="form-control select2-search" data-error="#property_id_<?php echo $_POST['paras1']; ?>1">
	<option value="">Select Property <?php echo $_POST['paras1']; ?>...</option>
	<?php  
		if(isset($properties_arrs)){
			foreach($properties_arrs as $properties_arr){
				$sel_1 = '';
				if(isset($_POST['sl_propertyid']) && $_POST['sl_propertyid']==$properties_arr->id){
					$sel_1 = 'selected="selected"';
				} 
				 
				$pp_type_1 = ($properties_arr->property_type==1) ? 'Sale: ' : 'Rent: ';
				
				$property_title1 = $pp_type_1 . stripslashes($properties_arr->title).' ('.stripslashes($properties_arr->ref_no).') AED '.number_format($properties_arr->price,2,".",","); ?>
				<option value="<?= $properties_arr->id; ?>" <?php echo $sel_1; ?>> <?= $property_title1; ?> </option>
		<?php 
			}
		} ?>
	</select>
<?php } ?>