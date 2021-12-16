<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	$this->load->view('widgets/meta_tags');  
	
 	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','add',$this->vs_usr_role_id,'1');
	
	$view_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','view',$this->vs_usr_role_id,'1'); 
	  
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','update',$this->vs_usr_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Locations','trash',$this->vs_usr_role_id,'1'); ?>
</head>
<body class="sidebar-xs has-detached-left">

<!-- Main navbar -->
<?php $this->load->view('widgets/header'); ?>
<!-- /main navbar --> 

<!-- Page container -->
<div class="page-container"> 
  
  <!-- Page content -->
  <div class="page-content"> 
    
    <!-- Main sidebar -->
    <?php $this->load->view('widgets/left_sidebar'); ?>
    <!-- /main sidebar --> 
    
    <!-- Main content -->
    <div class="content-wrapper"> 
      
      <!-- Page header -->
      <?php $this->load->view('widgets/content_header'); ?>
      <!-- /page header --> 
      
      <!-- Content area -->
      <div class="content"> 
        <!-- Dashboard content -->
        <?php if($this->session->flashdata('success_msg')){ ?>    
            	<div class="alert alert-success no-border">
                	<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                 <?php echo $this->session->flashdata('success_msg'); ?>
             	</div> 
		<?php } 
			if($this->session->flashdata('error_msg')){ ?>  
                <div class="alert alert-danger no-border">
                	<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                 <?php echo $this->session->flashdata('error_msg'); ?>
                </div>    
		<?php } ?> 
        <script>
        	function operate_locations_list(){  	  
				$(document).ready(function(){
					var sel_per_page_val = $("#per_page option:selected").val();
					var q_val = $("#q_val").val(); 
					 
					$.ajax({
						method: "POST",
						url: "<?php echo site_url('/locations/index2/'); ?>",
						data: { page: 0, sel_per_page_val:sel_per_page_val, q_val: q_val},
						beforeSend: function(){
							$('.loading').show();
						},
						success: function(data){
							$('.loading').hide();
							$('#dyns_list').html(data); 
						}
					});
				}); 
			}
    	</script>
          
        <div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title"><?php echo $page_headings; ?></h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<!--<li><a data-action="close"></a></li>-->
					</ul>
				</div>
			</div>   
      <div class="panel-body">   
     
		<input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('locations/add'); ?>">
		<input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
		
		<form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('locations/trash_multiple'); ?>" method="post">
        <div class="row">
            <div class="col-md-12"> 
             
            	<div class="form-group mb-md">   
                  <div class="col-md-1">    
                  <select name="per_page" id="per_page" class="form-control input-sm select2" onChange="operate_locations_list();">
                  <option value="25"> Pages</option>
                  <option value="25"> 25 </option>
                  <option value="50"> 50 </option>
                  <option value="100"> 100 </option> 
                </select> 
                  </div> 
                  
                  <div class="col-md-3">  
                  <input name="q_val" id="q_val" onKeyUp="operate_locations_list();" placeholder="Search..." type="text" class="form-control input-sm mb-md">   
            	  </div> 
                  <div class="col-md-3">   
                  </div>    
                    
                  <div class="col-md-3 pull-right"> 
                    <div class="dt-buttons"> 
                     <?php if($trash_res_nums>0){ ?>
                     	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="javascript:void(0);" onClick="return operate_multi_deletions('datas_list_forms');"> <span><i class="glyphicon glyphicon-remove-circle position-left"></i>Delete</span></a> 
                     
                    <?php } if($add_res_nums>0){ ?> 
                         	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('locations/add'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a>
                    <?php }
						
						if($add_res_nums==0 && $trash_res_nums==0){  ?>
							<a style="visibility:hidden;" class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1"><span><i class="glyphicon glyphicon-plus position-left"></i></span></a>
					<?php } ?> 
                        </div>
                    </div> 
                </div> 
                
            </div>
        </div>
		 
		 <style>
			 #datatable-default_filter{
				display:none !important;
			 }
		 </style> 
<table class="table table-bordered table-striped table-hover">
  <thead>
	<tr>
	  <th width="8%">#</th>
	  <th width="25%"> Location Name </th>
	  <th width="20%"> Parent Location </th> 
	  <th width="15%" class="text-center"> Status </th> 
	  <th width="14%" class="text-center">Action</th>
	</tr>
  </thead>
  <tbody id="dyns_list"> 
	<?php  
		$sr=0; 
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
				$record2s = $this->locations_model->get_parent_chaild_locations($record1->id);
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
							$record3s = $this->locations_model->get_parent_chaild_locations($record2->id);
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
										$record4s = $this->locations_model->get_parent_chaild_locations($record3->id);  
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
												$record5s = $this->locations_model->get_parent_chaild_locations($record4->id);   
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
														$record6s = $this->locations_model->get_parent_chaild_locations($record5->id);   
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
                          <option value="25"> 25 </option>
                          <option value="50"> 50 </option>
                          <option value="100"> 100 </option> 
                        </select>  </div>
                        <div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
                      </tr> 
                  <?php 
                    }else{ ?>
                <tr>
                  <td colspan="5" align="center"><strong> No Record Found! </strong></td>
                </tr>
                <?php } ?>
              </tbody>
            </table> 
     	</form>
     
      </div>
       <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
        </form>
        </div> 
        <!-- end of content --> 
        
        <!-- Footer -->
        <?php $this->load->view('widgets/footer'); ?>
        <!-- /footer --> 
        
      </div>
      <!-- /content area --> 
      
    </div>
    <!-- /main content --> 
    
  </div>
  <!-- /page content --> 
  
</div>
<!-- /page container -->
</body>
</html>