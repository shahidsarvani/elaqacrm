<!DOCTYPE html>
<html lang="en">
<head> 
<?php $this->load->view('widgets/meta_tags'); ?> 
<!-- Theme JS files --> 
<script type="text/javascript" src="<?= asset_url(); ?>js/plugins/ui/prism.min.js"></script> 
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/sidebar_dual.js"></script>
  
<script src="<?= asset_url();?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- /theme JS files -->
<?php 
$view_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','view',$this->dbs_role_id,'1'); 
 
$add_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','add',$this->dbs_role_id,'1'); 	
		
$update_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','update',$this->dbs_role_id,'1');   

$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Properties','trash',$this->dbs_role_id,'1');

if($add_res_nums>0 && $trash_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add_del.js"></script>
<?php 
}else
if($add_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add.js"></script>
<?php  
}else
if($trash_res_nums>0){ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_del.js"></script>
<?php 
}else{ ?>
	<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom.js"></script>
<?php 
} ?>   
<script> 
	function operate_properties(){   
		$(document).ready(function(){ 
					  
			var sel_per_page = document.getElementById("per_page");
			var sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value; 
			 
			var s_val = document.getElementById("s_val").value;  
			s_val = s_val.trim(); 
			 
			var category_id_vals = document.getElementById("category_ids").value;
			category_id_vals = category_id_vals.trim(); 
			
			var sl_location_id = $("#sl_location_id option:selected").val();
						
			var portal_id_vals = document.getElementById("portal_ids").value;
			portal_id_vals = portal_id_vals.trim(); 
			
			var assigned_to_id_vals = document.getElementById("assigned_to_ids").value;
			assigned_to_id_vals = assigned_to_id_vals.trim(); 
			
			var owner_id_vals = document.getElementById("owner_ids").value;
			owner_id_vals = owner_id_vals.trim();
			
			var property_status_vals = document.getElementById("m_property_status").value;
			property_status_vals = property_status_vals.trim();  
			 
			var price = document.getElementById("price").value;
			var to_price = document.getElementById("to_price").value;
			
			var from_date = document.getElementById("from_date").value;
			var to_date = document.getElementById("to_date").value;
			 
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/properties/rent_listings2/'); ?>", 
				
				//category_id_vals emirate_id_vals location_id_vals sub_location_id_vals portal_id_vals assigned_to_id_vals owner_id_vals property_status_vals 
				 
				data: { page: 0, sel_per_page_val:sel_per_page_val, s_val:s_val, category_id_vals:category_id_vals, sl_location_id: sl_location_id, portal_id_vals:portal_id_vals, assigned_to_id_vals:assigned_to_id_vals, owner_id_vals:owner_id_vals, property_status_vals:property_status_vals, price:price, to_price:to_price, from_date:from_date, to_date:to_date },
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(data){
					$('.loading').hide();
					$('#dyns_list').html(data);
					
					$('.select').select2({
						minimumResultsForSearch: Infinity
					});
					
					/*$( '[data-toggle=popover]' ).popover();
					
					$('.simple-ajax-modal').magnificPopup({
						type: 'ajax',
						modal: true
					});*/
				}
			});
		}); 
	} 
	
	function operate_archived_properties(){ 
		var conf_msg = confirm('Do you want to move the selected to archived properties ?');
		if(conf_msg){
			document.getElementById('datas_list_forms').action = "<?= site_url('properties/archived_selected_properties/');?>"; 	
			document.getElementById('datas_list_forms').submit();
		}else{
			return false;	
		}
	} 
</script>
<script type="text/javascript" src="<?= asset_url(); ?>js/custom_multiselect.js"></script>    
<style>
.cstms_badges .badge-primary{
	margin-bottom:1px;
}
</style>    
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
    <form name="datas_form" id="datas_form" action="" method="post">
    <!-- Detached sidebar -->
    <div class="sidebar-detached">
    <div class="sidebar sidebar-default">
    <div class="sidebar-content">  
       <input name="category_ids" id="category_ids" type="hidden" value=""> 
       <input name="portal_ids" id="portal_ids" type="hidden" value=""> 
       <input name="assigned_to_ids" id="assigned_to_ids" type="hidden" value=""> 
       <input name="owner_ids" id="owner_ids" type="hidden" value="">
       <input name="m_property_status" id="m_property_status" type="hidden" value="">                         
    <!-- Filter -->  
    <div class="sidebar-category"> 
		<div class="category-title">
            <span>Search</span>
            <ul class="icons-list">
                <li><a onClick="window.location='<?= site_url('properties/rent_listings/'); ?>';" data-action="reload"></a></li>
                <li><a href="#" data-action="collapse"></a></li>
            </ul>
        </div>
        <div class="category-content">  
        <div class="form-group"> 
            <div class="row">
                <div class="col-xs-12">  
                  <input name="s_val" id="s_val" type="text" class="form-control" placeholder="Search..." onKeyUp="operate_properties();" value="<?php echo set_value('s_val'); ?>">
                </div>     
            </div> 
          </div> 
         
        <div class="form-group"> 
            <div class="row">
                <div class="col-xs-12">  
                 <select name="category_id" id="category_id" multiple="multiple"> 
                    <?php  
                 		$category_arrs = $this->categories_model->get_all_categories();       
                        if(isset($category_arrs) && count($category_arrs)>0){
                            foreach($category_arrs as $category_arr){
                                $sel_1 = '';
                                if(isset($_POST['category_id']) && $_POST['category_id']==$category_arr->id){
                                    $sel_1 = 'selected="selected"';
                                } ?>
                                <option value="<?= $category_arr->id; ?>" <?php echo $sel_1; ?>>
                                    <?= stripslashes($category_arr->name); ?>
                                </option>
                            <?php 
                            }
                        } ?>
                  </select>
                </div>     
            </div> 
          </div>    
<div class="form-group"> 
	<div class="row">
		<div class="col-xs-12">   
		  <select name="sl_location_id" id="sl_location_id" class="form-control select2" onChange="operate_properties();"> 
			<option value="0"> Select Location </option> 
		<?php 		 
			if(isset($location_arrs)){
				foreach($location_arrs as $location_arr){ 
					
					$sel_1 = (isset($_POST['sl_location_id']) && $_POST['sl_location_id']==$location_arr->id) ? 'selected="selected"' : ''; ?>
					
					<option value="<?php echo $location_arr->id; ?>" <?php echo $sel_1; ?>> <?php echo stripslashes($location_arr->name); ?> </option> 			
				<?php  
					$record2s = $this->locations_model->get_parent_child_locations($location_arr->id);
					if(isset($record2s)){
						foreach($record2s as $record2){
							$sel_2 = (isset($_POST['sl_location_id']) && $_POST['sl_location_id']==$record2->id) ? 'selected="selected"' : ''; ?> 
							<option value="<?php echo $record2->id; ?>" <?php echo $sel_2; ?>> - <?php echo stripslashes($record2->name); ?> </option>  
							<?php     
								$record3s = $this->locations_model->get_parent_child_locations($record2->id);
								if(isset($record3s)){
									foreach($record3s as $record3){
										$sel_3 = (isset($_POST['sl_location_id']) && $_POST['sl_location_id']==$record3->id) ? 'selected="selected"' : '';  ?> 
										<option value="<?php echo $record3->id; ?>" <?php echo $sel_3; ?>> - - <?php echo  stripslashes($record3->name); ?> </option> 
											
										<?php 
											$record4s = $this->locations_model->get_parent_child_locations($record3->id);  
											if(isset($record4s)){
												foreach($record4s as $record4){
													$sel_4 = (isset($_POST['sl_location_id']) && $_POST['sl_location_id']==$record4->id) ?	'selected="selected"' : '';  ?> 
													<option value="<?php echo $record4->id; ?>" <?php echo $sel_4; ?>> - - -  <?php echo stripslashes($record4->name); ?> </option> 
												
												<?php    
													$record5s = $this->locations_model->get_parent_child_locations($record4->id);   
													if(isset($record5s)){
														foreach($record5s as $record5){ 
															$sel_5 = (isset($_POST['sl_location_id']) && $_POST['sl_location_id']==$record5->id) ?	'selected="selected"' : '';  ?> 
																<option value="<?php echo $record5->id; ?>" <?php echo $sel_5; ?>> - - - -  <?php echo stripslashes($record5->name); ?> </option>   	 
																
														<?php 
															$record6s = $this->locations_model->get_parent_child_locations($record5->id);   
															if(isset($record6s)){
																foreach($record6s as $record6){
																	$sel_6 = (isset($_POST['sl_location_id']) && $_POST['sl_location_id']==$record6->id) ?	'selected="selected"' : '';  ?>
																	<option value="<?php echo $record6->id; ?>" <?php echo $sel_6; ?>> - - - - - <?php echo stripslashes($record6->name); ?> </option>      
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
					}  
				} ?> 
			  </select>
		</div>     
	</div> 
</div>
		<div class="form-group"> 
			<div class="row">
				<div class="col-xs-12">  
				 <select name="portal_id" id="portal_id" multiple="multiple" onChange="operate_properties();"> 
					<?php   
						$portal_arrs = $this->portals_model->get_all_portals();
						$portal_nums = count($portal_arrs); 
						if(isset($portal_arrs) && $portal_nums>0){  
							foreach($portal_arrs as $portal_arr){ ?>  
							 <option value="<?= $portal_arr->id; ?>">
								<?= stripslashes($portal_arr->name); ?>
							 </option> 
							<?php  
							}
						} ?>
					</select>
				</div> 
			  </div>
            </div>
            
           <div class="form-group"> 
             <div class="row">
                <div class="col-xs-12">
                   <select name="assigned_to_id" id="assigned_to_id" multiple="multiple" onChange="operate_properties();"> 
                    <?php  
                        $vs_user_type_id = $this->session->userdata('us_role_id');
                        $vs_id = $this->session->userdata('us_id'); 
                        if($vs_user_type_id==2){ 
                            $arrs_field = array('role_id'=> '3','parent_id'=> $vs_id); 
                        }else{
                            $arrs_field = array('role_id'=> '3'); 
                        } 
                        $user_arrs = $this->general_model->get_gen_all_users_by_field($arrs_field); 
                        if(isset($user_arrs) && count($user_arrs)>0){
                            foreach($user_arrs as $user_arr){
                            $sel_1 = '';
                            if(isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id){
                                $sel_1 = 'selected="selected"';
                            } ?>
                            <option value="<?= $user_arr->id; ?>" <?php echo $sel_1; ?>>
                            <?= stripslashes($user_arr->name); ?>
                            </option>
                            <?php 
                            }
                        } ?>
                     </select>
                 </div> 
            </div>
        </div>
            
   <div class="form-group"> 
    <div class="row">
        <div class="col-xs-12"> 
           <select name="owner_id" id="owner_id" multiple="multiple" onChange="operate_properties();"> 
            <?php 
				$owner_arrs = $this->general_model->get_gen_all_owners_list(); 
                if(isset($owner_arrs) && count($owner_arrs)>0){
                    foreach($owner_arrs as $owner_arr){
                    $sel_1 = '';
                    if(isset($_POST['owner_id']) && $_POST['owner_id']==$owner_arr->id){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($record) && $record->owner_id==$owner_arr->id){
                        $sel_1 = 'selected="selected"';
                    } ?>
                    <option value="<?= $owner_arr->id; ?>" <?php echo $sel_1; ?>>
                        <?= stripslashes($owner_arr->name); ?>
                    </option>
                    <?php 
                    }
                } ?>
             </select>
            </div> 
         </div>
        </div>
            
            <div class="form-group">
             <div class="row">
        		<div class="col-xs-12">
            	<select name="property_status" id="property_status" multiple="multiple" onChange="operate_properties();"> 
                  <option value="1" <?php if(isset($_POST['property_status']) && $_POST['property_status']==1){ echo 'selected="selected"'; } ?>> Sold </option>
                  <option value="2" <?php if(isset($_POST['property_status']) && $_POST['property_status']==2){ echo 'selected="selected"'; } ?>> Rented </option>
                  <option value="3" <?php if(isset($_POST['property_status']) && $_POST['property_status']==3){ echo 'selected="selected"'; } ?>> Available </option>
                  <option value="4" <?php if(isset($_POST['property_status']) && $_POST['property_status']==4){ echo 'selected="selected"'; } ?>> Upcoming </option> 
             </select>
                 </div> 
             </div>
            </div>
             
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                    <input name="price" id="price" type="text" class="form-control input-sm" value="<?php echo set_value('price'); ?>" placeholder="From Price" onKeyUp="operate_properties();">  
                  </div>  
                 <div class="col-xs-6">
                   <input name="to_price" id="to_price" type="text" class="form-control input-sm" value="<?php echo set_value('to_price'); ?>" placeholder="To Price" onKeyUp="operate_properties();">  
                 </div>
                </div> 
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                     <input name="from_date" id="from_date" type="text" class="form-control input-sm" value="<?php echo set_value('from_date'); ?>" placeholder="From Date" onKeyUp="operate_properties();">  
                 </div>   
                 <div class="col-xs-6">
                    <input name="to_date" id="to_date" type="text" class="form-control input-sm" value="<?php echo set_value('to_date'); ?>" placeholder="To Date" onKeyUp="operate_properties();">  
                 </div>
                </div> 
            </div>  
        </div>
    </div>
    <!-- /filter -->
	<script>   
		$(document).ready(function(){   
			$('#from_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_properties();
			}); 
			
			$('#to_date').datepicker({
				format: "yyyy-mm-dd"
				}).on('change', function(){
					$('.datepicker').hide();
					operate_properties();
			});  
		});
	</script>
								 

    	</div>
	</div>
</div>

    <!-- /detached sidebar -->
    </form>

    <!-- Detached content -->
    <div class="container-detached">
        <div class="content-detached"> 
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
                            
    <!-- Sidebars overview -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"> <?php echo $page_headings; ?> </h5>
            <div class="heading-elements">
                 
            </div>
        </div> 
        
	<input type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('properties/add/4/'); ?>">
    <input type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
       
    <form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('properties/delete_selected_properties'); ?>" method="post">   
        <div class="panel-body"> 
            <div class="row">
            <div class="col-md-12"> 
                <div class="form-group mb-md">   
                  <div class="col-md-2">  
                   <div class="col-md-9">   
                      <select name="per_page" id="per_page" class="form-control input-sm mb-md select2" onChange="operate_properties();">
                      <option value="25"> Pages</option>
                      <option value="25"> 25 </option>
                      <option value="50"> 50 </option>
                      <option value="100"> 100 </option> 
                    </select> 
                    </div>
                     <div class="col-md-3">  </div>
                  </div>   
                  
				  <div class="col-md-8 pull-right"> 
                    <div class="dt-buttons"> 
					
						<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" href="<?= site_url('properties/rent_listings/export_excel'); ?>"> <span><i class="glyphicon glyphicon-file position-left"></i> Export </span></a>
                     <?php if($trash_res_nums>0){ ?>
                     	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="javascript:void(0);" onClick="return operate_multi_deletions('datas_list_forms');"> <span><i class="glyphicon glyphicon-remove-circle position-left"></i>Delete</span></a> 
                     
                    <?php } if($add_res_nums>0){ ?> 
                         	<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('properties/add/4/'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a>
                    <?php }
						
						if($add_res_nums==0 && $trash_res_nums==0){  ?>
							<a style="visibility:hidden;" class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1"><span><i class="glyphicon glyphicon-plus position-left"></i></span></a>
					<?php } ?> 
					
						<button type="button" name="submit_archive_properties" id="submit_archive_properties" class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" value="Archive Selected" onClick="operate_archived_properties();"> <i class="glyphicon glyphicon-repeat"></i> Archive Selected </button>  
					
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
				 
							$('.select2').select2({
								minimumResultsForSearch: Infinity
							});
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

                    <div class="modal-body"></div>

                    <div class="modal-footer">
                        <button id="close_users_modals" type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>
    <div class="table-responsive">                         
      <table class="table table-bordered table-striped table-hover">  
          <thead>
            <tr>
              <th width="7%">#</th>
              <th width="12%" class="text-center">Ref No.</th>
              <th width="14%">Title</th>
              <th width="13%">Category </th>
              <th width="13%">Assigned To </th>
              <th width="9%" class="text-center">Status</th>
              <th width="9%" class="text-center">Price (<?php echo $conf_currency_symbol; ?>)</th>
              <th width="12%" class="text-center">Created On</th>
              <th width="12%" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody id="dyns_list"> 	
	  <?php    
        $sr=1; 
        if(isset($records) && count($records)>0){
            foreach($records as $record){ 
                $operate_url = 'properties/update/4/'.$record->id;
                $operate_url = site_url($operate_url); 
                
                // $trash_url = 'properties/trash_aj/'.$record->id;
                $trash_url = 'properties/delete_property/4/'.$record->id;
			    $trash_url = site_url($trash_url); ?>
                
                <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                  <td class="text-center">
				  <div class="checkbox">
                	<label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                	</div> 
				  <?php //echo ($record->is_new==1) ? 'new' : ''; ?> </td> 	
                  <td class="text-center"><?= stripslashes($record->ref_no); ?></td>
                  <td><?= stripslashes($record->title); ?></td>
                  <td><?= stripslashes($record->cate_name); ?></td>
                  <td>
                    <?php 
					if($record->assigned_to_id>0){
						$usr_arr =  $this->general_model->get_user_info_by_id($record->assigned_to_id);
						echo stripslashes($usr_arr->name);
					} ?> 
                  </td>
                  <td class="text-center"> 
                  <?php  
					if(isset($record) && $record->property_status==1){ 
						echo '<span class="label label-info"> Sold </span>';
					} 
					if(isset($record) && $record->property_status==2){ 
						echo '<span class="label label-success"> Rented </span>';
					}
					if(isset($record) && $record->property_status==3){
						echo '<span class="label label-primary"> Available </span>';
					}
					if(isset($record) && $record->property_status==4){
						echo '<span class="label label-warning"> Upcoming </span>';
					} ?>
                  </td> 
                 <td class="text-center"><?php echo number_format($record->price,0,".",","); /*CRM_CURRENCY.' '.*/ ?></td>  
                 <td class="text-center"><?php echo date('d-M-Y',strtotime($record->created_on)); ?></td>   
                 <td class="text-center">   
					<ul class="icons-list">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a> 
							<ul class="dropdown-menu dropdown-menu-right"> <!-- icon-search4 --> 	 
						  <?php if($view_res_nums>0){ ?>   
								<li><a href="javascript:void(0);" onClick="return view_property('<?php echo $record->id; ?>');" data-toggle="modal" data-target="#modal_remote_property_detail"><i class="glyphicon glyphicon-search"></i> Detail</a> </li>  
						   <?php } if($update_res_nums>0){ ?> 
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
               <td colspan="9">
               <div style="float:left;"> <select name="per_page" id="per_page" class="form-control input-sm mb-md select2" onChange="operate_properties();">
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
                  <td colspan="9" align="center"><strong> No Record Found! </strong></td>
                </tr>
                <?php } ?>
              </tbody>
            </table> 
			</div>     						 
			<div class="loading" style="display: none;">
				<div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div>
			</div>   
		</div>  
		<input type="hidden" name="args0" id="args0" value="4" />
     </form>
        </div>
        <!-- /sidebars overview --> 

    </div>
</div>
<!-- /detached content -->


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
