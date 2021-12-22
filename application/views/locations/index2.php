<?php  
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','update',$this->vs_usr_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','trash',$this->vs_usr_role_id,'1'); 
	  
	$sr=1; 
	if(isset($page) && $page >0){
		$sr = $page+1;
	} 
	if(isset($records)){
		foreach($records as $record1){ 
			$sr++;
			
			$operate_url = 'locations/update/'.$record1->id;
			$operate_url = site_url($operate_url); 
			
			$trash_url = 'locations/trash_aj/'.$record1->id;
			$trash_url = site_url($trash_url); ?>
			
			<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
				<td> <div class="checkbox"> <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record1->id; ?>" value="<?php echo $record1->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> </td> 	
				 <td><?php echo $parent_loc1 = stripslashes($record1->name); ?></td>
				 <td> </td>
				 <td class="text-center">
				 <?php 
					$bg_cls ='';
					if($record1->status==1){
						$bg_cls = 'label-success';
					}else{
						$bg_cls = 'label-danger';
					} ?> <span class="label <?php echo $bg_cls; ?>"> <?php echo ($record1->status==1) ? 'Active' : 'Inactive'; ?> </span> </td> 
				  <td class="text-center"> 
					<ul class="icons-list">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
							<ul class="dropdown-menu dropdown-menu-right"> <!-- icon-search4 --> 	 
						  <?php if($update_res_nums>0){ ?> 
									<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
							<?php } 
								if($trash_res_nums>0){ ?>  
								   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record1->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
						  <?php } ?>  
							</ul>
						</li>
					</ul>   
				  </td> 
				</tr>
						
		<?php  
			$record2s = $this->locations_model->get_parent_child_locations($record1->id);
			if(isset($record2s)){
				foreach($record2s as $record2){ 
					$sr++;
					
					$operate_url = 'locations/update/'.$record2->id;
					$operate_url = site_url($operate_url); 
					
					$trash_url = 'locations/trash_aj/'.$record2->id;
					$trash_url = site_url($trash_url); ?>
						<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
						  <td>  
							<div class="checkbox">
								<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record2->id; ?>" value="<?php echo $record2->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> 
						  </td> 	
						  <td> - <?php echo $parent_loc2 = stripslashes($record2->name); ?></td>
						  <td> <?php echo $parent_loc1; ?> </td>
						  <td class="text-center">
						  <?php 
								$bg_cls ='';
								if($record2->status==1){
									$bg_cls = 'label-success';
								}else{
									$bg_cls = 'label-danger';
								} ?>
								<span class="label <?php echo $bg_cls; ?>"> <?php echo ($record2->status==1) ? 'Active' : 'Inactive'; ?> </span> </td> 
						  <td class="text-center"> 
							<ul class="icons-list">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
									<ul class="dropdown-menu dropdown-menu-right"> <!-- icon-search4 --> 	 
								  <?php if($update_res_nums>0){ ?> 
											<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
									<?php } 
										if($trash_res_nums>0){ ?>  
										   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record2->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
								  <?php } ?>  
									</ul>
								</li>
							</ul>   
						  </td> 
						</tr>
						 
					<?php     
						$record3s = $this->locations_model->get_parent_child_locations($record2->id);
						if(isset($record3s)){
							foreach($record3s as $record3){ 
								$sr++;
								$operate_url = 'locations/update/'.$record3->id;
								$operate_url = site_url($operate_url); 
								
								$trash_url = 'locations/trash_aj/'.$record3->id;
								$trash_url = site_url($trash_url); ?>
									<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
									  <td>  
										<div class="checkbox">
											<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record3->id; ?>" value="<?php echo $record3->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> 
									  </td> 	
									  <td> - - <?php echo $parent_loc3 = stripslashes($record3->name); ?></td>
									  <td> <?php echo $parent_loc2; ?> </td>
									  <td class="text-center">
									  <?php 
											$bg_cls ='';
											if($record3->status==1){
												$bg_cls = 'label-success';
											}else{
												$bg_cls = 'label-danger';
											} ?>
											<span class="label <?php echo $bg_cls; ?>"> <?php echo ($record3->status==1) ? 'Active' : 'Inactive'; ?> </span> </td> 
									  <td class="text-center"> 
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
												<ul class="dropdown-menu dropdown-menu-right"> <!-- icon-search4 --> 	 
											  <?php if($update_res_nums>0){ ?> 
														<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
												<?php } 
													if($trash_res_nums>0){ ?>  
													   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record3->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
											  <?php } ?>  
												</ul>
											</li>
										</ul>   
									  </td> 
									</tr>
									
								<?php 
									$record4s = $this->locations_model->get_parent_child_locations($record3->id);  
									if(isset($record4s)){
										foreach($record4s as $record4){ 
											$sr++;
											
											$operate_url = 'locations/update/'.$record4->id;
											$operate_url = site_url($operate_url); 
											
											$trash_url = 'locations/trash_aj/'.$record4->id;
											$trash_url = site_url($trash_url); ?>
												<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
												  <td>  
													<div class="checkbox">
														<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record4->id; ?>" value="<?php echo $record4->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> 
												  </td> 	
												  <td> - - - <?php echo $parent_loc4 = stripslashes($record4->name); ?></td>
												  <td> <?php echo $parent_loc3; ?> </td>
												  <td class="text-center">
												  <?php 
														$bg_cls ='';
														if($record4->status==1){
															$bg_cls = 'label-success';
														}else{
															$bg_cls = 'label-danger';
														} ?>
														<span class="label <?php echo $bg_cls; ?>"> <?php echo ($record4->status==1) ? 'Active' : 'Inactive'; ?> </span> </td> 
												  <td class="text-center"> 
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
															<ul class="dropdown-menu dropdown-menu-right"> <!-- icon-search4 --> 	 
														  <?php if($update_res_nums>0){ ?> 
																	<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
															<?php } 
																if($trash_res_nums>0){ ?>  
																   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record4->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
														  <?php } ?>  
															</ul>
														</li>
													</ul>   
												  </td> 
												</tr> 
												
										<?php    
											$record5s = $this->locations_model->get_parent_child_locations($record4->id);   
											if(isset($record5s)){
												foreach($record5s as $record5){ 
													$sr++;
													
													$operate_url = 'locations/update/'.$record5->id;
													$operate_url = site_url($operate_url); 
													
													$trash_url = 'locations/trash_aj/'.$record5->id;
													$trash_url = site_url($trash_url); ?>
														<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
														  <td>  
															<div class="checkbox">
																<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record5->id; ?>" value="<?php echo $record5->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> 
														  </td> 	
														  <td> - - - - <?php echo $parent_loc5 = stripslashes($record5->name); ?></td>
														  <td> <?php echo $parent_loc4; ?></td>
														  <td class="text-center">
														  <?php 
																$bg_cls ='';
																if($record5->status==1){
																	$bg_cls = 'label-success';
																}else{
																	$bg_cls = 'label-danger';
																} ?>
																<span class="label <?php echo $bg_cls; ?>"> <?php echo ($record5->status==1) ? 'Active' : 'Inactive'; ?> </span> </td> 
														  <td class="text-center"> 
															<ul class="icons-list">
																<li class="dropdown">
																	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
																	<ul class="dropdown-menu dropdown-menu-right"> <!-- icon-search4 --> 	 
																  <?php if($update_res_nums>0){ ?> 
																			<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
																	<?php } 
																		if($trash_res_nums>0){ ?>  
																		   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record5->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
																  <?php } ?>  
																	</ul>
																</li>
															</ul>   
														  </td> 
														</tr> 
														 
														
												<?php 
													$record6s = $this->locations_model->get_parent_child_locations($record5->id);   
													if(isset($record6s)){
														foreach($record6s as $record6){ 
															$sr++;
															
															$operate_url = 'locations/update/'.$record6->id;
															$operate_url = site_url($operate_url); 
															
															$trash_url = 'locations/trash_aj/'.$record6->id;
															$trash_url = site_url($trash_url); ?>
															<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
															  <td>  
																<div class="checkbox">
																	<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record6->id; ?>" value="<?php echo $record6->id; ?>" class="styled"> <?php echo $sr; ?> </label> </div> 
															  </td> 	
															  <td> - - - - - <?php echo $parent_loc6 = stripslashes($record6->name); ?></td>
															  <td> <?php echo $parent_loc5; ?> </td>
															  <td class="text-center">
															  <?php 
																	$bg_cls ='';
																	if($record6->status==1){
																		$bg_cls = 'label-success';
																	}else{
																		$bg_cls = 'label-danger';
																	} ?>
																	<span class="label <?php echo $bg_cls; ?>"> <?php echo ($record6->status==1) ? 'Active' : 'Inactive'; ?> </span> </td> 
															  <td class="text-center"> 
																<ul class="icons-list">
																	<li class="dropdown">
																		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
																		<ul class="dropdown-menu dropdown-menu-right"> <!-- icon-search4 --> 	 
																	  <?php if($update_res_nums>0){ ?> 
																				<li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
																		<?php } 
																			if($trash_res_nums>0){ ?>  
																			   <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record6->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
																	  <?php } ?>  
																		</ul>
																	</li>
																</ul>   
															  </td> 
															</tr> 
															  
															<?php 
															}
														} ?>  	
																  
													<?php  
													}
												} ?> 	
													  
										<?php 
										}
									} ?> 	
										  
							<?php 
							}
						} ?>  	  
				<?php  
				}
			} ?>  	
	<?php 
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