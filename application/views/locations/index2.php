<?php  
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','update',$this->vs_usr_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','trash',$this->vs_usr_role_id,'1');
	
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	} 
	
	if(isset($records) && count($records)>0){
		foreach($records as $record){ 
			$operate_url = 'locations/update/'.$record->id;
			$operate_url = site_url($operate_url); 
			
			$trash_url = 'locations/trash_aj/'.$record->id;
			$trash_url = site_url($trash_url); ?>
		<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
		  <td>  
			<div class="checkbox">
				<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> 
		  </td> 	
		  <td><?= stripslashes($record->name); ?></td>
		  <td><?= stripslashes($record->parent_id); ?></td>
		  <td class="text-center">
		  <?php 
				$bg_cls ='';
				if($record->status==1){
					$bg_cls = 'label-success';
				}else{
					$bg_cls = 'label-danger';
				} ?>
				<span class="label <?php echo $bg_cls; ?>"> <?php echo ($record->status==1) ? 'Active' : 'Inactive'; ?> </span> </td> 
		  <td class="text-center"> 
			<ul class="icons-list">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
					<ul class="dropdown-menu dropdown-menu-right">  
				  <?php if($update_res_nums>0){ ?> 
							<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
					<?php } 
						if($trash_res_nums>0){ ?>  
						   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
				  <?php } ?>  
					</ul>
				</li>
			</ul>   
		  </td> 
		</tr>
		<?php 
		$sr++;
		} ?> 
	   <tr>
	   <td colspan="5">
	   <div style="float:left;">  <select name="per_page" id="per_page" class="form-control input-sm select2" onChange="operate_locations_list();">
		  <option value="25"> Pages</option>
		  <option value="25" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==25) ? 'selected="selected"':''; ?>> 25 </option>
		  <option value="50" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==50) ? 'selected="selected"':''; ?>> 50 </option>
		  <option value="100" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==100) ? 'selected="selected"':''; ?>> 100 </option> 
		</select>  </div>
		<div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
	  </tr> 
  <?php 
	}else{ ?>
<tr>
  <td colspan="5" align="center"><strong> No Record Found! </strong></td>
</tr>
<?php } ?> 