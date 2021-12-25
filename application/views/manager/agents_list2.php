<?php  
	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','add',$this->dbs_role_id,'1'); 
	
	$view_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','view',$this->dbs_role_id,'1'); 
				
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Manager','trash',$this->dbs_role_id,'1'); 
	 
	if(isset($records) && count($records)>0){
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	} 
	
	foreach($records as $record){ ?>  
        
        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
          <td> <?php echo $sr; ?> </td> 	
          <td><?= stripslashes($record->name); ?></td>
          <td><?= stripslashes($record->email); ?></td>
          <td><?= stripslashes($record->phone_no); ?></td>
          <td><?= stripslashes($record->mobile_no); ?></td>  
        </tr> 
		<?php 
			$sr++;
			} ?> 
			<tr>
			   <td colspan="5">
			   <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md populate select" onChange="operate_agents_list();">
		  <option value="25"> Pages</option>
		  <option value="25" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==25) ? 'selected="selected"':''; ?>> 25 </option>
		  <option value="50" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==50) ? 'selected="selected"':''; ?>> 50 </option>
		  <option value="100" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==100) ? 'selected="selected"':''; ?>> 100 </option> 
		</select>  </div>
        <div style="float:right;"> <?php echo $this->ajax_pagination->create_links();?></div></td>  
      </tr> 
	<?php  
	}else{ ?> 
	  <tr>
	   <td colspan="5" align="text-center">
	   <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md populate select" onChange="operate_agents_list();">
		  <option value="25"> Pages</option>
		  <option value="25"> 25 </option>
		  <option value="50"> 50 </option>
		  <option value="100"> 100 </option> 
		</select>  </div>
		<div>  <strong> No Record Found! </strong></div>  </td>  
	  </tr> 
<?php } ?>