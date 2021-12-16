<?php 
	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','add',$this->dbs_role_id,'1');  		
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Tasks','trash',$this->dbs_role_id,'1');
		
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	}
	   
	$vs_id = $this->session->userdata('us_id'); 
	
	if(isset($records) && count($records)>0){
		foreach($records as $record){
			$operate_url = 'tasks/operate_task_to_do/'.$record->id; 
			$operate_url = site_url($operate_url);
			
			$trash_url = 'tasks/trash_aj/'.$record->id;
			$trash_url = site_url($trash_url);
			
			$detail_url = 'tasks/task_detail/'.$record->id;
			$detail_url = site_url($detail_url);
					
		$temp_usr_arr = $this->general_model->get_user_info_by_id($record->created_by);
		$created_by_nm = stripslashes($temp_usr_arr->name); 
		
		$assigned_to_nm ='';
		if($record->assigned_to >0){
			$temp_usr_arr = $this->general_model->get_user_info_by_id($record->assigned_to);
			if(isset($temp_usr_arr)){
				$assigned_to_nm = stripslashes($temp_usr_arr->name); 
			}
		}   ?>
		<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>"> 
			<td><?php echo $sr; echo ($record->is_new==1 && $record->assigned_to==$vs_id) ? ' <span class="badge_mini badge badge-danger">new</span>':'';  ?></td> 
			<td><?= stripslashes($record->property_ref); ?></td>
			<td><?= stripslashes($record->lead_ref); ?></td>  
			<td><?= stripslashes($record->title); ?></td>
			<td><?= $assigned_to_nm; ?></td>
			<td class="text-center"><?= date('d-M-Y',strtotime($record->due_date)); ?></td>
			<td class="text-center"><?= stripslashes($record->due_timing); ?></td>
			<td class="text-center"><?= date('d-M-Y',strtotime($record->created_on)); ?></td>
			<td class="text-center">
			<?php  
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
				} ?>
			</td>
			<td class="center">   
				<ul class="icons-list">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
						<ul class="dropdown-menu dropdown-menu-right">  	 
					  <?php if($update_res_nums>0){ ?> 
								<li><a href="<?php echo $detail_url; ?>" class="dropdown-item"><i class="icon-search4"></i> Detail</a> </li> <!-- <a class="simple-ajax-modal" href="<?php //echo $detail_url; ?>"><i class="fa fa-search-plus"></i> </a> -->
						<?php }
							if($update_res_nums>0){ ?> 
								<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
						<?php } 
							if($trash_res_nums>0 && $this->dbs_user_role_id==1 ){ ?>  
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
				   <td colspan="10">
				   <div style="float:left;">  <select name="per_page" id="per_page" class="form-control input-sm select2" onChange="operate_tasks_list();">
					  <option value="25"> Pages</option>
					  <option value="25"> 25 </option>
					  <option value="50"> 50 </option>
					  <option value="100"> 100 </option> 
					</select>  </div>
					<div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
				  </tr> 
			  <?php
			  
			}else{ ?>	
			<tr class="gradeX"> 
				<td colspan="10" class="center"> <strong> No Record Found! </strong> </td>
			</tr>
	<?php } ?>  