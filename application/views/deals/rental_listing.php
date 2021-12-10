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
$view_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','view',$this->dbs_role_id,'1');

$add_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','add',$this->dbs_role_id,'1'); 	
		
$update_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','update',$this->dbs_role_id,'1');   

$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Deals','trash',$this->dbs_role_id,'1');

if($add_res_nums>0 && $trash_res_nums>0){ ?>
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add_del.js"></script>
<?php 
}else if($add_res_nums>0){ ?>
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_add.js"></script>
<?php  
}else if($trash_res_nums>0){ ?>
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom_del.js"></script>
<?php 
}else{ ?>
<script type="text/javascript" src="<?= asset_url(); ?>js/pages/datatables_extension_buttons_init_custom.js"></script>
<?php 
} ?>
<script type="text/javascript" src="<?= asset_url(); ?>js/custom_multiselect.js"></script>
<style>
.cstms_badges .badge-primary{
	margin-bottom:1px;
}
</style>
</head>
<?php $vs_user_type_id = $this->session->userdata('us_role_id'); ?>
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
      <script>
				function operate_rental_deals(){ 	 	  
					$(document).ready(function(){
							
						var sel_per_page_val =0;			
						var refer_no = document.getElementById("refer_no").value;
						var unit_no = document.getElementById("unit_no").value;
						var price = document.getElementById("price").value;
						var to_price1 = document.getElementById("to_price").value; 
						var est_deal_date_val = document.getElementById("est_deal_date").value;
						 
						var sel_per_page = document.getElementById("per_page");
						var sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value;
						
						var sel_status_val = document.getElementById("status");
						var sel_property_status_val = sel_status_val.options[sel_status_val.selectedIndex].value;
			
						var sel_emirate_location_id_val = document.getElementById("emirate_location_id").value;
						var sel_assigned_to_id_val = document.getElementById("assigned_to_id").value;
						var sel_contact_id_val = document.getElementById("contact_id").value;
						var sel_owner_id_val = document.getElementById("owner_id").value;
						 
						$.ajax({
							method: "POST",
							url: "<?php echo site_url('/deals/rental_listing2/'); ?>",
							data: { page: 0, sel_per_page_val:sel_per_page_val, refer_no: refer_no, unit_no: unit_no, price: price, to_price: to_price1, sel_emirate_location_id_val: sel_emirate_location_id_val, sel_property_status_val: sel_property_status_val, sel_assigned_to_id_val: sel_assigned_to_id_val, sel_est_deal_date_val : est_deal_date_val, contact_id_val: sel_contact_id_val, owner_id_val: sel_owner_id_val },
							beforeSend: function(){

								$('.loading').show();    
							},
							success: function(data){
								$('.loading').hide();
								$('#dyns_list').html(data);
								
								//$( '[data-toggle=popover]' ).popover();
								
								//$('.simple-ajax-modal').magnificPopup({
								//	type: 'ajax',
								//	modal: true
								//});
							}
						});
					});
				}
				</script>
      <!-- Content area -->
      <div class="content">
        <form name="datas_form" id="datas_form" action="" method="post">
          <!-- Detached sidebar -->
          <div class="sidebar-detached">
            <div class="sidebar sidebar-default">
              <div class="sidebar-content">
                <!-- <input name="owner_id" id="owner_id" type="hidden" value="">
	<input name="contact_id" id="contact_id" type="hidden" value="">     
	<input name="emirate_location_id" id="emirate_location_id" type="hidden" value="">
	<input name="assigned_to_id" id="assigned_to_id" type="hidden" value="">   -->
                <!-- Filter -->
                <div class="sidebar-category">
                  <div class="category-title"> <span>Search</span>
                    <ul class="icons-list">
                      <li><a onClick="window.location='<?= site_url('deals/rental_listing'); ?>';" data-action="reload"></a></li>
                      <li><a href="#" data-action="collapse"></a></li>
                    </ul>
                  </div>
                  <div class="category-content">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12">
                          <input name="refer_no" id="refer_no" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('refer_no'); ?>" placeholder="Ref No ..." onKeyUp="operate_rental_deals();">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12">
                          <select name="status" id="status" data-plugin-selectTwo class="form-control input-sm mb-md select2" onChange="operate_rental_deals();">
                            <option value="">Select </option>
                            <option value="Pending" <?php if(isset($_POST['status']) && $_POST['status']=='Pending'){ echo 'selected="selected"'; } ?>> Pending </option>
                            <option value="Close" <?php if(isset($_POST['status']) && $_POST['status']=='Close'){ echo 'selected="selected"'; } ?>> Close </option>
                            <option value="Cancelled" <?php if(isset($_POST['status']) && $_POST['status']=='Cancelled'){ echo 'selected="selected"'; } ?>> Cancelled </option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12">
                          <select name="owner_ids" id="owner_ids" class="form-control input-sm mb-md" multiple="multiple" onChange="operate_rental_deals();">
                            <?php  
		$owners_arrs = $this->general_model->get_gen_all_owners_list();
		if(isset($owners_arrs) && count($owners_arrs)>0){
			foreach($owners_arrs as $owners_arr){ ?>
                            <option value="<?= $owners_arr->id; ?>" <?php echo (isset($_POST['owner_ids']) && $_POST['owner_ids']==$owners_arr->id) ? 'selected="selected"':''; ?>>
                            <?= stripslashes($owners_arr->name).' ( '.stripslashes($owners_arr->email).' - '.stripslashes($owners_arr->phone_no).' )'; ?>
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
                          <select name="contact_ids" id="contact_ids" class="form-control input-sm mb-md" multiple="multiple" onChange="operate_rental_deals();">
                            <?php  
		if(isset($contact_arrs) && count($contact_arrs)>0){
			foreach($contact_arrs as $contact_arr){ ?>
                            <option value="<?= $contact_arr->id; ?>" <?php echo (isset($_POST['contact_ids']) && $_POST['contact_ids']==$contact_arr->id) ? 'selected="selected"':''; ?>>
                            <?= stripslashes($contact_arr->name).' ( '.stripslashes($contact_arr->email).' - '.stripslashes($contact_arr->phone_no).' )'; ?>
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
                          <select name="emirate_location_ids" id="emirate_location_ids" class="form-control input-sm mb-md" multiple="multiple" onChange="operate_rental_deals();">
                            <?php  	
$emirate_sub_location_arrs = $this->admin_model->get_all_emirate_sub_locations(); 
if(isset($emirate_sub_location_arrs) && count($emirate_sub_location_arrs)>0){
foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){

$sel_1 = '';
if(isset($_POST['emirate_location_id']) && $_POST['emirate_location_id']==$emirate_sub_location_arr->id){
	$sel_1 = 'selected="selected"';
} ?>
                            <option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>>
                            <?= stripslashes($emirate_sub_location_arr->name); ?>
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
                          <input name="unit_no" id="unit_no" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('unit_no'); ?>" placeholder="Unit No ..." onKeyUp="operate_rental_deals();">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12">
                          <input name="price" id="price" type="text" class="form-control input-sm" value="<?php echo set_value('price'); ?>" placeholder="From Price" onKeyUp="operate_rental_deals();">
                          -
                          <input name="to_price" id="to_price" type="text" class="form-control input-sm" value="<?php echo set_value('to_price'); ?>" placeholder="To Price" onKeyUp="operate_rental_deals();">
                        </div>
                      </div>
                    </div>
                    <?php if($vs_user_type_id==1 || $vs_user_type_id==2){ ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12">
                          <select name="assigned_to_ids" id="assigned_to_ids" class="multiselect_cls" multiple="multiple" onChange="operate_rental_deals();">
                            <?php  
			if(isset($user_arrs) && count($user_arrs)>0){
				foreach($user_arrs as $user_arr){ ?>
                            <option value="<?= $user_arr->id; ?>" <?php echo (isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id) ? 'selected="selected"':''; ?>>
                            <?= stripslashes($user_arr->name); ?>
                            </option>
                            <?php 
				}
			} ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12">
                          <input name="est_deal_date" id="est_deal_date" type="text" class="form-control" value="<?php //echo $est_deal_date; ?>" style="text-align:center;" placeholder="Est. Date...">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /filter -->
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
              <?php echo $this->session->flashdata('success_msg'); ?> </div>
            <?php } 
            if($this->session->flashdata('error_msg')){ ?>
            <div class="alert alert-danger no-border">
              <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
              <?php echo $this->session->flashdata('error_msg'); ?> </div>
            <?php } ?>
            <!-- Sidebars overview -->
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h5 class="panel-title"> <?php echo $page_headings; ?> </h5>
                <div class="heading-elements"> </div>
              </div>
              <input style="display:none" type="hidden" name="add_new_link" id="add_new_link" value="<?php echo site_url('deals/operate_deal/2'); ?>">
              <input style="display:none"  type="hidden" name="cstm_frm_name" id="cstm_frm_name" value="datas_list_forms">
              <form name="datas_list_forms" id="datas_list_forms" action="<?php echo site_url('deals/delete_selected_deals'); ?>" method="post">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group mb-md">
                        <div class="col-md-2">
                          <select name="per_page" id="per_page" class="form-control input-sm mb-md select2" onChange="operate_rental_deals();">
                            <option value="25"> Pages</option>
                            <option value="25"> 25 </option>
                            <option value="50"> 50 </option>
                            <option value="100"> 100 </option>
                          </select>
                        </div>
                        <div class="col-md-10 pull-right">
                          <div class="dt-buttons">
                            <?php if($trash_res_nums>0){ ?>
                            <!--<a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="javascript:void(0);" onClick="return operate_multi_deletions('datas_list_forms');"> <span><i class="glyphicon glyphicon-remove-circle position-left"></i>Delete</span></a> -->
                            <?php } if($add_res_nums>0){ ?>
                            <a class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1" href="<?= site_url('deals/operate_deal/2/'); ?>"><span><i class="glyphicon glyphicon-plus position-left"></i>New</span></a>
                            <?php }
						
						if($add_res_nums==0 && $trash_res_nums==0){  ?>
                            <!--<a style="visibility:hidden;" class="dt-button btn border-slate text-slate-800 btn-flat mrglft5" tabindex="0" aria-controls="DataTables_Table_1"><span><i class="glyphicon glyphicon-plus position-left"></i></span></a>-->
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
                  <script>  	  
			$(document).ready(function(){  
				$('#est_deal_date').datepicker({
				  format: "yyyy-mm-dd"
					}).on('change', function(){
						$('.datepicker').hide();
						operate_rental_deals();
				});
				
				
				$('.multiselect_cls').multiselect();
			}); 
		</script>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Deal Ref # </th>
                          <th>Status </th>
                          <th>Seller</th>
                          <th>Buyer</th>
                          <th>Sub Location</th>
                          <th>Unit No</th>
                          <th>Deal Price</th>
                          <th>Agent </th>
                          <th class="center">Estimated Date</th>
                          <th class="center">Action</th>
                        </tr>
                      </thead>
                      <tbody id="dyns_list">
                        <?php    
				if($view_res_nums >0){ 
					$sr=1; 
					if(isset($records) && count($records)>0){
						foreach($records as $record){ 
							$details_url = 'deals/deal_detail/'.$record->id;
							$details_url = site_url($details_url); 
							
							$operate_url = 'deals/operate_deal/2/'.$record->id;
							$operate_url = site_url($operate_url);
							
							$trash_url = 'deals/trash_deal/2/'.$record->id;
							$trash_url = site_url($trash_url);  
							
							$dtls_url = 'public_properties/property_detail/'.$record->property_id;
							$dtls_url = site_url($dtls_url); ?>
                        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                          <td><?= $sr; ?></td>
                          <td><!--<a href="<?php echo $dtls_url; ?>" target="_blank"><?= stripslashes($record->
                            ref_no); ?></a>-->
                            <?= stripslashes($record->ref_no); ?>
                          </td>
                          <td><?= stripslashes($record->status); ?></td>
                          <td><?php echo stripslashes($record->owner_name); ?></td>
                          <td><?php echo stripslashes($record->cnt_name); ?></td>
                          <td><?php echo stripslashes($record->sub_loc_name); ?></td>
                          <td><?= stripslashes($record->unit_no); ?></td>
                          <td><?php echo CRM_CURRENCY.' '.number_format($record->deal_price,0,".",","); ?></td>
                          <td><?php 
							if($record->agent1_id>0){
								$usr_arr =  $this->general_model->get_user_info_by_id($record->agent1_id);
								echo stripslashes($usr_arr->name)."<hr class=\"cstms-dash\">";
							} 
							
							if($record->agent2_id>0){
								$usr_arr =  $this->general_model->get_user_info_by_id($record->agent2_id);
								echo stripslashes($usr_arr->name);
							} 	 ?></td>
                          <td class="center"><?php echo date('d-M-Y',strtotime($record->est_deal_date)); ?> </td>
                          <td class="text-center"><ul class="icons-list">
                              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="icon-menu7"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                  <!-- icon-search4 -->
                                  <?php if($view_res_nums>0){ ?>
                                  <li><a href="<?php echo $details_url; ?>"><i class="glyphicon glyphicon-search"></i> Detail</a> </li>
                                  <?php } if($update_res_nums>0){ ?>
                                  <li><a href="<?php echo $operate_url; ?>" class="dropdown-item"><i class="icon-pencil7"></i> Update</a> </li>
                                  <?php } 
											if($trash_res_nums>0){ ?>
                                  <li> <a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a> </li>
                                  <?php } ?>
                                </ul>
                              </li>
                            </ul></td>
                        </tr>
                        <?php 
						$sr++;
						}  ?>
                        <tr>
                          <td colspan="11"><div style="float:left;">
                              <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md select2" onChange="operate_rental_deals();">
                                <option value="25"> Pages</option>
                                <option value="25"> 25 </option>
                                <option value="50"> 50 </option>
                                <option value="100"> 100 </option>
                              </select>
                            </div>
                            <div style="float:right;"> <?php echo $this->ajax_pagination->create_links(); ?> </div></td>
                        </tr>
                        <?php
					}else{ ?>
                        <tr>
                          <td colspan="11" align="center"><div style="float:left;">
                              <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md select2" onChange="operate_rental_deals();">
                                <option value="25"> Pages</option>
                                <option value="25"> 25 </option>
                                <option value="50"> 50 </option>
                                <option value="100"> 100 </option>
                              </select>
                            </div>
                            <div> <strong> No Record Found! </strong> </div></td>
                        </tr>
                        <?php 
						} 
					}else{ ?>
                        <tr class="gradeX">
                          <td colspan="11" class="center"><strong> No Permission to access this area! </strong> </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="loading" style="display: none;">
                    <div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div>
                  </div>
                </div>
                <input type="hidden" name="args0" id="args0" value="2" />
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
