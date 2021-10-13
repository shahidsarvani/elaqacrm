<?php  
	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Owners','add',$this->dbs_role_id,'1'); 
				
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Owners','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Owners','trash',$this->dbs_role_id,'1'); 
	 
	if(isset($records) && count($records)>0){
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	} 
	
	foreach($records as $record){ 
		$operate_url = 'owners/update/'.$record->id;
		$operate_url = site_url($operate_url);
		
		$trash_url = 'owners/trash_aj/'.$record->id;
		$trash_url = site_url($trash_url); ?>  
        
        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
          <td>  
            <div class="checkbox">
                <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> 
          </td> 	
          <td><?= stripslashes($record->name); ?></td>
          <td><?= stripslashes($record->email); ?></td>
          <td><?= stripslashes($record->phone_no); ?></td>
          <td><?= stripslashes($record->mobile_no); ?></td>
          <td><?= stripslashes($record->company_name); ?></td>
          <td><?= date('d-M-Y H:i:s',strtotime($record->created_on)); ?></td> 
          <td class="text-center"> 
            <ul class="icons-list">
			   <?php if($update_res_nums>0){ ?> 
                        <li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li> 
                <?php } 
                    if($trash_res_nums>0){ ?> 
                        <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li> 
              <?php } ?> 
                </ul>  
          </td> 
        </tr> 
		<?php 
			$sr++;
			} ?> 
			<tr>
			   <td colspan="8">
			   <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md populate select" onChange="operate_owners_list();">
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
           <td colspan="8" align="text-center">
           <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md populate select" onChange="operate_owners_list();">
              <option value="25"> Pages</option>
              <option value="25"> 25 </option>
              <option value="50"> 50 </option>
              <option value="100"> 100 </option> 
            </select>  </div>
            <div>  <strong> No Record Found! </strong></div>  </td>  
          </tr>
              
    <?php } ?>
              