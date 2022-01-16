<!DOCTYPE html>
<html lang="en">
<head> 
<?php $this->load->view('widgets/meta_tags'); ?>
</head>
<body>

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
		
		<!-- Quick stats boxes -->
		<div class="row">
		  <div class="col-lg-3">   
			<div class="panel bg-teal-400">
			  <div class="panel-body">
				<div class="heading-elements"> <!--<span class="heading-text badge bg-teal-800">+53,6%</span>--> 
					 <a class="badge bg-teal-800 badge-pill align-self-center ml-auto" href="<?= site_url("properties/sales_listings/"); ?>">View Details</a>
				</div>
				<h3 class="no-margin"><?php echo $nos_of_sale_properties; ?></h3>
				Total Sale Properties
				<!--<div class="text-muted text-size-small">489 avg</div>-->
			  </div>
			  <div class="container-fluid">
				<div id="members-online"></div>
			  </div>
			</div> 
		  </div>
		  <div class="col-lg-3">   
			<div class="panel bg-pink-400">
			  <div class="panel-body">
				<div class="heading-elements">
					<a class="badge bg-pink-800 badge-pill align-self-center ml-auto" href="<?= site_url("properties/rent_listings/"); ?>">View Details</a> 
				</div>
				<h3 class="no-margin"> <?php echo $nos_of_rent_properties; ?> </h3>
				Total Rentals Properties
				<!--<div class="text-muted text-size-small">34.6% avg</div>-->
			  </div>
			  <div id="server-load"></div>
			</div> 
		  </div>
		  <div class="col-lg-3">  	 
			<div class="panel bg-indigo-400">
			  <div class="panel-body">
				<div class="heading-elements"> <a class="badge bg-indigo-800 badge-pill align-self-center ml-auto" href="<?= site_url('properties/archived_listings'); ?>">View Details</a> 
				</div>
				<h3 class="no-margin"><?php echo $nos_of_archived_properties; ?></h3>
				Total Archived Properties
				<!--<div class="text-muted text-size-small">$37,578 avg</div>-->
			  </div>
			  <div id="today-revenue"></div>
			</div> 
		  </div>
		  
		  <div class="col-lg-3">   
			<div class="panel bg-blue-400">
			  <div class="panel-body">
				<div class="heading-elements"> 
				  <a class="badge bg-blue-800 badge-pill align-self-center ml-auto" href="<?= site_url("properties/sales_listings/"); ?>">View Details</a>
				</div>
				<h3 class="no-margin"> <?php echo $nos_of_active_properties; ?> </h3>
				Total Active Properties
				<!--<div class="text-muted text-size-small">$37,578 avg</div>-->
			  </div>
			  <div id="today-revenue"></div>
			</div> 
		  </div>  
		</div>
		<!-- /quick stats boxes -->  
		
		
		<script type="text/javascript"> 
				function view_property(paras1){  
					if(paras1>0){			
						$(document).ready(function(){    
						<?php
							$prpty_dtl_popup_url = 'properties/property_detail/';
							$prpty_dtl_popup_url = site_url($prpty_dtl_popup_url); ?> 
							
							var cstm_urls = "<?php echo $prpty_dtl_popup_url; ?>"+paras1;
							
							$('#modal_remote_property_detail').on('show.bs.modal', function() {
								$(this).find('.modal-body').load(cstm_urls, function() {
						  
								});
							});   
						});    
					} 
				}  
			 </script> 
      
	<div id="modal_remote_property_detail" class="modal fade" data-backdrop="false"> 
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Property Detail</h5>
				</div>
				<div class="modal-body"> </div>
				<div class="modal-footer">
					<button id="close_users_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
				</div>
			</div>
		</div>
	</div>
	<!-- Dashboard content -->
	<?php 
		$vs_id = $this->session->userdata('us_id');
		$vs_role_id = $this->session->userdata('us_role_id');
		if($vs_role_id == 1){ ?>
			<div class="row">
			  <div class="col-lg-12">   
				<div class="panel panel-flat">
				  <div class="panel-heading">
					<h6 class="panel-title">Companies Manager</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a onClick="window.location='<?= site_url('dashboard/index/'); ?>';" data-action="reload"></a></li> 
						</ul> 
					</div>
				  </div> 		   
				  <div class="table-responsive">
					 <table class="table text-nowrap">
						<thead>  
							<tr>
								<th width="5%">#</th> 
								<th width="12%">Name </th> 
								<th width="15%">Email </th>
								<th width="12%">Contact # </th>
								<th width="11%">Company </th>
								<th width="12%">Total Agents </th> 
								<th width="10%">Package</th>
								<th width="10%">End Date</th>
								<th width="12%">Last Login </th> 
								<th width="10%" class="center">Status</th> 	
							  </tr>
						</thead>
						<tbody>
						<?php  
							/*$permission_results_arr = $this->Permission_Results; 
							$chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_view_permission', $permission_results_arr);  
							if($chk_rets){ */
							$sr=1; 
							if(isset($results)){
								foreach($results as $result){ 
									/*$details_url = 'properties/property_detail/'.$record->id;
									$details_url = site_url($details_url); 
									
									$archv_url = 'properties/property_to_archive/'.$record->id;
									$archv_url = site_url($archv_url); 
									
									$dealts_url = 'properties/property_to_dealt/'.$record->id;
									$dealts_url = site_url($dealts_url); 
									
									$operate_url = 'properties/operate_property/0/'.$record->id;
									$operate_url = site_url($operate_url);
									
									$trash_url = 'properties/delete_property/0/'.$record->id;
									$trash_url = site_url($trash_url);*/ ?> 
									
									<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>"> 
									<td> <?php echo $sr; ?>  </td>
									<!--onClick="return view_property('<?php //echo $result->id; ?>');" data-toggle="modal" data-target="#modal_remote_property_detail"-->
									<td> <a href="javascript:void(0);" > <?= stripslashes($result->name); ?> </a> </td> 
									<td><?php echo stripslashes($result->email); ?> </td>
									<td><?php echo stripslashes($result->phone_no).'/ '.stripslashes($result->mobile_no); ?></td>
									<td><?php echo stripslashes($result->company_name); ?> </td>
									<td><?php  	
									//	if($vs_role_id == 2){
											$agnt_arrs = $this->general_model->get_gen_all_manager_agents_list($result->id);
											if(isset($agnt_arrs)){
												echo count($agnt_arrs);
											}
											//if(isset($agnt_arrs) && count($agnt_arrs)>0)
										//}  ?> </td>
									<td><?php echo stripslashes($result->package_name); ?> </td>
									<td><?php echo stripslashes($result->package_end_date); ?> </td>
									<td><?php echo date('d-M-Y H:i:s',strtotime($result->last_login_on)); ?> </td>
									<td class="center"><?php 
										$bg_cls ='';
										if($result->status==1){
											$bg_cls = 'badge-success';
										}else{
											$bg_cls = 'badge-danger';
										} ?>
									  <span class="badge <?php echo $bg_cls; ?>"> <?php echo ($result->status==1) ? 'Active' : 'Inactive';  ?></span></td>
									<!--<td><?php 
									/**/?></td>  -->
									  </tr>
							<?php 
								$sr++;
								}
							}else{ ?>	
							<tr class="gradeX"> 
								<td colspan="10" style="text-align:center;" class="center"> <strong> No Record Found! </strong> </td>
							</tr>
							<?php 
							} 
						/*}else{ ?>	
							<tr class="gradeX"><td colspan="10" class="center"> <strong> No Permission to access this area! </strong> </td>
							</tr>
					<?php } */?>   
							<!--<tr class="gradeX"> 
								<td colspan="10" style="text-align:center;" class="center"><?php //echo $this->ajax_pagination->create_links(); ?>  </td> 
							</tr>-->  
						</tbody>
					 </table>
					</div> 
				</div>
				<!-- /marketing campaigns -->
				
			  </div> 
			</div>
	<?php } ?>
	
        <div class="row">
          <div class="col-lg-12">   
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h6 class="panel-title">Recent Properties</h6>
                <div class="heading-elements">
					<ul class="icons-list">
						<li><a onClick="window.location='<?= site_url('dashboard/index/'); ?>';" data-action="reload"></a></li> 
					</ul> 
                </div>
              </div>
			   			   
              <div class="table-responsive">
                 <table class="table text-nowrap">
						<thead>  
							<tr>
								<th width="5%">#</th> 
								<th width="10%">Ref No </th> 
								<th width="10%">Bedrooms </th>
								<th width="14%">Owner </th>
								<th width="10%">Price (<?php echo $conf_currency_symbol; ?>)</th>
								<th width="9%" class="center">Status</th>
								<th width="12%">Assigned To</th>
							  </tr>
						</thead>
						<tbody>
						<?php 
							$vs_id = $this->session->userdata('us_id');
							/*$permission_results_arr = $this->Permission_Results; 
							$chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_view_permission', $permission_results_arr);  
							if($chk_rets){ */
							$sr=1; 
							if(isset($records) && count($records)>0){
								foreach($records as $record){ 
									$details_url = 'properties/property_detail/'.$record->id;
									$details_url = site_url($details_url); 
									
									$archv_url = 'properties/property_to_archive/'.$record->id;
									$archv_url = site_url($archv_url); 
									
									$dealts_url = 'properties/property_to_dealt/'.$record->id;
									$dealts_url = site_url($dealts_url); 
									
									$operate_url = 'properties/operate_property/0/'.$record->id;
									$operate_url = site_url($operate_url);
									
									$trash_url = 'properties/delete_property/0/'.$record->id;
									$trash_url = site_url($trash_url); ?> 
									
									<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>"> 
									<td><?php echo $sr;
										echo ($record->is_new==1 && $vs_id==$record->assigned_to_id) ? ' <span class="badge_mini label-danger">new</span>':'';  ?> 
									 </td>
									<td>
									<a href="javascript:void(0);" onClick="return view_property('<?php echo $record->id; ?>');" data-toggle="modal" data-target="#modal_remote_property_detail"> <?= stripslashes($record->ref_no); ?> </a>
									</td> 
									<td><?php echo stripslashes($record->bed_title); ?> </td>
									<td><?php echo stripslashes($record->ownr_name);
										if(strlen($record->ownr_phone_no)>0){
											echo ' ( ';
											$ownr_phn_no_arrs = explode(',',$record->ownr_phone_no); 
											if(isset($ownr_phn_no_arrs) && count($ownr_phn_no_arrs)>1){
												echo $ownr_phn_no_arrs[0];
												$n=1; 
												$ph_txt=''; 
												foreach($ownr_phn_no_arrs as $ownr_phn_no_arr){
													if($n==1){
														$n++;
														continue;
													}
													$ph_txt .= $ownr_phn_no_arr.', '; 
													$n++;
												}
												$ph_txt = substr($ph_txt,0,-2); ?>
												<a href="javascript:void(0)" data-popup="popover-custom" data-placement="top" title="Contact Nos." data-content="<?php echo $ph_txt; ?>"> more</a>  
											<?php 
											}else{ 
												 echo stripslashes($record->ownr_phone_no); 
											} 
										echo ' )';
										} ?> 
										</td>
									<td><?php echo number_format($record->price,2,".",","); ?> </td>
									<td class="center"><?php 
										$bg_cls ='';
										if($record->property_status==1){
											$bg_cls = 'badge-success';
										}else if($record->property_status==2){
											$bg_cls = 'badge-primary';
										}else if($record->property_status==3){
											$bg_cls = 'badge-warning';
										}else if($record->property_status==6){
											$bg_cls = 'badge-danger';
										}else{
											$bg_cls = 'badge-info';
										} ?>
									  <span class="badge <?php echo $bg_cls; ?>"> <?php echo $this->general_model->get_gen_property_status($record->property_status); ?></span></td>
									<td><?php 
									if($record->assigned_to_id>0){
										$usr_arr =  $this->general_model->get_user_info_by_id($record->assigned_to_id);
										echo stripslashes($usr_arr->name);
									} ?></td>  
									  </tr>
							<?php 
								$sr++;
								}
							}else{ ?>	
							<tr class="gradeX"> 
								<td colspan="8" class="center"> <strong> No Record Found! </strong> </td>
							</tr>
							<?php 
							} 
						/*}else{ ?>	
							<tr class="gradeX"><td colspan="8" class="center"> <strong> No Permission to access this area! </strong> </td>
							</tr>
					<?php } */?>   
							<!--<tr class="gradeX"> 
								<td colspan="8" class="center"><?php //echo $this->ajax_pagination->create_links(); ?>  </td> 
							</tr> --> 
						</tbody>
					  </table>
              </div> 
            </div>
            <!-- /marketing campaigns -->
			
          </div> 
        </div>
        <!-- /dashboard content --> 
        
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