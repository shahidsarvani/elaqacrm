<select name="category_id" id="category_id" data-plugin-selectTwo class="form-control populate">
<option value="">Category Name</option>
<?php  
	if(isset($cate_arrs) && count($cate_arrs)>0){
		foreach($cate_arrs as $cate_arr){ ?>
			<option value="<?= $cate_arr->id; ?>"> <?= stripslashes($cate_arr->name); ?></option> 	
	<?php 
		}
	} ?> 
</select>