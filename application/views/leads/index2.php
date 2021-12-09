<?php 
	$view_res_nums =  $this->general_model->check_controller_method_permission_access('Leads','view',$this->dbs_role_id,'1'); 	
	
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Leads','update',$this->dbs_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Leads','trash',$this->dbs_role_id,'1'); 	 			  
					   
	if($view_res_nums == 1){
		$sr=1; 
		if(isset($page) && $page >0){
			$sr = $page+1;
		} 

		if(isset($records) && count($records)>0){
			foreach($records as $record){ 
				$details_url = 'leads/lead_detail/'.$record->id;
				$details_url = site_url($details_url); 
				
				$operate_url = 'leads/operate_lead/'.$record->id;
				$operate_url = site_url($operate_url);
				
				$trash_url = 'leads/trash/'.$record->id;
				$trash_url = site_url($trash_url); ?>
				<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
				<td> <div class="checkbox"> <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?= $record->id; ?>" value="<?= $record->id; ?>" class="styled"> <?php echo $sr; ?> </label></div> <?php echo ($record->is_new==1) ? ' <span class="badge_mini badge badge-danger">new</span>' : '';  ?> </td>
				<td><?= stripslashes($record->ref_no); ?></td>
				<td><?php echo stripslashes($record->lead_type); ?> </td>
				<td><?= stripslashes($record->lead_status); ?></td>
				<td><?php echo stripslashes($record->priority); ?> </td>
				<td><?php 
					echo stripslashes($record->cnt_name); 
					 
					if(strlen($record->cnt_phone_no)>0){
						echo ' ( ';
						$cnt_phn_no_arrs = explode(',',$record->cnt_phone_no); 
						if(isset($cnt_phn_no_arrs) && count($cnt_phn_no_arrs)>1){
							echo $cnt_phn_no_arrs[0];
							$n=1; 
							$ph_txt=''; 
							foreach($cnt_phn_no_arrs as $cnt_phn_no_arr){
								/*if($n==1){
									$n++;
									continue;
								}*/
								$ph_txt .= $cnt_phn_no_arr.', '; 
								$n++;
							} 
							$ph_txt = substr($ph_txt,0,-2); ?>
							<a href="javascript:void(0)" data-popup="popover-custom" data-placement="top" title="Contact Nos." data-content="<?php echo $ph_txt; ?>"> more</a>
						<?php 
						}else{ 
							 echo stripslashes($record->cnt_phone_no); 
						} 
						echo ' )';
					} ?> </td> 
				<td><?php   
				 if(isset($record->sub_location_id) && $record->sub_location_id>0){
					$arr_lc = $this->emirates_sub_location_model->get_emirate_sub_location_by_id($record->sub_location_id);  
					if(isset($arr_lc)){
						echo stripslashes($arr_lc->name);
					}
				 }?> </td>
				<td><?php  
				 if(isset($record->category_id) && $record->category_id>0){
					$arr_cate = $this->categories_model->get_category_by_id($record->category_id); 
					if(isset($arr_cate)){
						echo stripslashes($arr_cate->name);
					}
				 } ?> </td>  
				<td><?php  
				 if(isset($record->no_of_beds_id) && $record->no_of_beds_id>0){
					$arr_bd = $this->no_of_bedrooms_model->get_no_of_beds_by_id($record->no_of_beds_id); 
					if(isset($arr_bd)){
						echo stripslashes($arr_bd->title);
					}
				 } ?> </td> 
				<td> <?php echo (isset($record) && $record->price!='') ? CRM_CURRENCY.' '.number_format($record->price,0,".",",") :''; ?> </td>
				<td><?php  
				 if(isset($record->enquiry_date) && $record->enquiry_date!='0000-00-00'){
					echo  date('d-M-Y',strtotime($record->enquiry_date));
				 } ?></td>
				<td><?php 
				if($record->agent_id>0){
					$usr_arr =  $this->general_model->get_user_info_by_id($record->agent_id);
					echo stripslashes($usr_arr->name);
				} ?></td> 
				<td><?php echo ($record->updated_on!='0000-00-00 00:00:00') ? date('d.M.y', strtotime($record->updated_on)):''; /* cnt_updated_on */ ?> </td>  
				<td class="center"> 
				  <ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a href="<?php echo $details_url; ?>"><i class="icon-search4"></i> Detail </a> </li>
													<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a></li>
													<li><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a></li>
												</ul>
											</li>
										</ul>
				</td>  
			   </tr> 
		<?php 
			$sr++;
			}  ?> 
			   <tr>
			   <td colspan="14">
			   <div style="float:left;">  <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">
			  <option value="25"> Pages</option>
			  <option value="25" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==25) ? 'selected="selected"':''; ?>> 25 </option>
			  <option value="50" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==50) ? 'selected="selected"':''; ?>> 50 </option>
			  <option value="100" <?php echo (isset($_SESSION['tmp_per_page_val']) && $_SESSION['tmp_per_page_val']==100) ? 'selected="selected"':''; ?>> 100 </option> 
			</select>  </div>
				<div style="float:right;"> <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
			  </tr> 
		  <?php
		}else{ ?>	
			 <tr>
			   <td colspan="14" align="center">
			   <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md select2" onChange="operate_leads_properties();">
			  <option value="25"> Pages</option>
			  <option value="25"> 25 </option>
			  <option value="50"> 50 </option>
			  <option value="100"> 100 </option> 
			</select>  </div>
			<div>  <strong> No Record Found! </strong> </div>  </td>  
		  </tr>  
			<?php 
			} 
		}else{ ?>	
			<tr class="gradeX"> 
				<td colspan="14" class="center"> <strong> No Permission to access this area! </strong> </td>
			</tr>
	<?php } ?>