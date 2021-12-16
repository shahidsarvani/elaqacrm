<?php  

	if(isset($records) && count($records)>0){
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	} 
	
	foreach($records as $record){    
		
		$operate_url = 'tasks/operate_task_to_do/'.$record->id;
		$operate_url = site_url($operate_url);
		
		$trash_url = 'tasks/trash_task_to_do_aj/'.$record->id;
		$trash_url = site_url($trash_url);
		
		$detail_url = 'tasks/task_to_do_detail/'.$record->id;
		$detail_url = site_url($detail_url);
					
		$temp_usr_arr = $this->general_model->get_user_info_by_id($record->created_by);
		$created_by_nm = stripslashes($temp_usr_arr->name); 
		
		$assigned_to_nm ='';
		if($record->assigned_to >0){
			$temp_usr_arr = $this->general_model->get_user_info_by_id($record->assigned_to);
			if(isset($temp_usr_arr)){
				$assigned_to_nm = stripslashes($temp_usr_arr->name); 
			}
		} ?>

		<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
		  <td class="text-center"><?= $sr; ?></td>
		  <td class="text-center"><?= stripslashes($record->property_ref); ?></td>
		  <td class="text-center"><?= stripslashes($record->lead_ref); ?></td>
		  <td class="text-center"><?= stripslashes($record->title); ?></td>
		  <td class="text-center"><?= $assigned_to_nm; ?></td>
		  <td class="text-center"><?= date('d-M-Y',strtotime($record->due_date)); ?></td>
		  <td class="text-center"><?= stripslashes($record->due_timing); ?></td>
		  <td class="text-center"><?= date('d-M-Y',strtotime($record->created_on)); ?></td>
		  <td class="text-center"><?php  
			if(isset($record) && $record->status==0){ 
				echo '<span class="label label-info"> Pending </span>';
			} 
			if(isset($record) && $record->status==1){ 
				echo '<span class="label label-success"> Completed </span>';
			}
			if(isset($record) && $record->status==2){
				echo '<span class="label label-primary"> In Progress </span>';
			}
			if(isset($record) && $record->status==3){
				echo '<span class="label label-warning"> Rejected </span>';
			} 
			if(isset($record) && $record->status==4){
				echo '<span class="label label-danger"> Over Due </span>';
			} ?></td>
		  <td class="text-center"><ul class="icons-list">
			  <li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li>
			  <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','fetch_dya_list');"><i class="icon-trash"></i></a></li>
			</ul></td>
		</tr>
	<?php 
		$sr++;
		} ?>  
            
			<tr>
			   <td colspan="10" align="text-center">
			   <div style="float:left;"> <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate select" onChange="operate_table_datas();">
		  <option value="25"> Pages</option>
		  <option value="25" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==25) ? 'selected="selected"':''; ?>> 25 </option>
		  <option value="50" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==50) ? 'selected="selected"':''; ?>> 50 </option>
		  <option value="100" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==100) ? 'selected="selected"':''; ?>> 100 </option> 
		</select>  </div>
				<div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?> </div> </td>  
			  </tr> 
		<?php 
			
		}else{ ?> 
          <tr>
           <td colspan="10" align="text-center">
           <div style="float:left;"> <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate select" onChange="operate_table_datas();">
              <option value="25"> Pages</option>
              <option value="25"> 25 </option>
              <option value="50"> 50 </option>
              <option value="100"> 100 </option> 
            </select>  </div>
            <div>  <strong> No Record Found! </strong></div>  </td>  
          </tr>
              
    <?php } ?>
              