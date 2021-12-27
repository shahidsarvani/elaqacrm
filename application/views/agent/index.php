<?php $this->load->view('widgets/meta_tags'); ?>
<body>
<section class="body">
  <?php $this->load->view('widgets/header'); ?>
  <div class="inner-wrapper"> 
	<?php $this->load->view('widgets/left_sidebar'); 
		$vs_user_type_id = $this->session->userdata('us_user_type_id'); 
		$vs_id = $this->session->userdata('us_id'); ?>
    <section role="main" class="content-body">
    <header class="page-header">
      <h2>Dashboard</h2>
      <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
          <li> <a href="<?php echo site_url(); ?>"> <i class="fa fa-home"></i> </a> </li>
          <li><span>Dashboard</span></li>
        </ol>
		&nbsp; &nbsp;
         </div>
    </header>
    <!-- start: page -->
    <div class="row">  
	  <div class="col-md-12">
		<div class="row">
		  <div class="col-md-12 col-lg-6 col-xl-6">
			<section class="panel panel-featured-left panel-featured-primary">
			  <div class="panel-body">
				<div class="widget-summary">
				  <div class="widget-summary-col widget-summary-col-icon">
					<div class="summary-icon bg-primary"> <i class="fa fa-life-ring"></i> </div>
				  </div>
				  <div class="widget-summary-col">
					<div class="summary">
					  <h4 class="title">Active Properties</h4>
					  <div class="info"> <strong class="amount"><?php echo $nos_of_active_properties; ?></strong> </div>
					</div>
					<div class="summary-footer"> &nbsp; <!--<a href="<?php echo site_url('properties/properties_list'); ?>" class="text-muted text-uppercase">View</a>--> </div>
				  </div>
				</div>
			  </div>
			</section>
		  </div>
		  <div class="col-md-12 col-lg-6 col-xl-6">
			<section class="panel panel-featured-left panel-featured-secondary">
			  <div class="panel-body">
				<div class="widget-summary">
				  <div class="widget-summary-col widget-summary-col-icon">
					<div class="summary-icon bg-secondary"> <i class="fa fa-usd"></i> </div>
				  </div>
				  <div class="widget-summary-col">
					<div class="summary">
					  <h4 class="title">Archived Properties</h4>
					  <div class="info"> <strong class="amount"><?php echo $nos_of_archived_properties; ?></strong> </div>
					</div>
					<div class="summary-footer"> <a href="<?php echo site_url('properties/archived_properties_list'); ?>" class="text-muted text-uppercase">View</a> </div>
				  </div>
				</div>
			  </div>
			</section>
		  </div>
		  <div class="col-md-12 col-lg-6 col-xl-6">
			<section class="panel panel-featured-left panel-featured-tertiary">
			  <div class="panel-body">
				<div class="widget-summary">
				  <div class="widget-summary-col widget-summary-col-icon">
					<div class="summary-icon bg-tertiary"> <i class="fa fa-shopping-cart"></i> </div>
				  </div>
				  <div class="widget-summary-col">
					<div class="summary">
					  <h4 class="title">Total Properties</h4>
					  <div class="info"> <strong class="amount"><?php echo $nos_of_active_properties + $nos_of_archived_properties; ?></strong> </div>
					</div>
					<div class="summary-footer"> </div>
				  </div>
				</div>
			  </div>
			</section>
		  </div> 
		</div>
	  </div>
	  </div> 
      
    <div class="row">	
		<div class="col-md-12">
		  <section class="panel">
			<header class="panel-heading">
			  <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> <a href="#" class="fa fa-times"></a> </div>
			  <h2 class="panel-title">Recent Properties</h2>
			</header>
			<div class="panel-body" id="fetch_properties_list">
			<table class="table table-bordered table-striped mb-none" <?php echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
            <thead> 
             <tr>
                <th width="5%">#</th> 
                <th width="10%">Ref No </th>
                <th width="12%">Sub Location</th>
                <th width="11%">Unit No</th>
                <th width="10%">Bedrooms </th>
                <th width="14%">Owner </th>
                <th width="10%">Price</th>
                <th width="9%" class="center">Status</th>
                <th width="12%">Assigned To</th>
              </tr>
            </thead>
            <tbody>
			<?php 
			$permission_results_arr = $this->Permission_Results; 
			$chk_rets = $this->general_model->in_array_field('1', 'module_id','1', 'is_view_permission', $permission_results_arr);  
			if($chk_rets){ 
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
							<td>   
                            <?php echo $sr;
						    echo ($record->is_new==1 && $vs_id==$record->assigned_to_id) ? ' <span class="badge_mini label-danger">new</span>':'';  ?> 
                            </td>
                            <td><a href="<?php echo $details_url; ?>" target="_blank"><?= stripslashes($record->ref_no); ?></a></td>
                            <td><?php echo stripslashes($record->sub_loc_name); ?> </td>
                            <td><?= stripslashes($record->unit_no); ?></td>
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
									<a data-plugin-popover data-plugin-options='{"placement": "top"}' tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Contact Nos." data-content="<?php echo $ph_txt; ?>">more</a>
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
                                    $bg_cls = 'label-success';
                                }else if($record->property_status==2){
                                    $bg_cls = 'label-primary';
                                }else if($record->property_status==3){
                                    $bg_cls = 'label-warning';
                                }else if($record->property_status==6){
                                    $bg_cls = 'label-danger';
                                }else{
                                    $bg_cls = 'label-info';
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
					<td colspan="9" class="center"> <strong> No Record Found! </strong> </td>
				</tr>
				<?php 
				} 
			}else{ ?>	
				<tr class="gradeX"><td colspan="9" class="center"> <strong> No Permission to access this area! </strong> </td>
				</tr>
		<?php } ?>  
            </tbody>
          </table>
            <?php echo $this->ajax_pagination->create_links(); ?> 
			</div>
		  </section>
		</div> 
  	</div>
  	<!-- end: page -->
  </section>
  </div> 
</section>
<!-- Vendor --> 
<script src="<?= asset_url();?>vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= asset_url();?>vendor/nanoscroller/nanoscroller.js"></script> 
<script src="<?= asset_url();?>vendor/magnific-popup/magnific-popup.js"></script>
<!-- Specific Page Vendor -->
<script src="<?= asset_url();?>vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?= asset_url();?>vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="<?= asset_url();?>vendor/jquery-appear/jquery.appear.js"></script>
<script src="<?= asset_url();?>vendor/morris/morris.js"></script>
<!-- Theme Base, Components and Settings -->
<script src="<?= asset_url();?>vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?= asset_url();?>javascripts/theme.js"></script>
<!-- Theme Custom -->
<script src="<?= asset_url();?>javascripts/theme.custom.js"></script>
<!-- Theme Initialization Files -->
<script src="<?= asset_url();?>javascripts/theme.init.js"></script>
<script src="<?= asset_url();?>javascripts/forms/examples.advanced.form.js"></script>
<!-- Examples -->
<!--<script src="<?= asset_url();?>javascripts/tables/examples.datatables.default.js"></script>-->   
</body>
</html>
