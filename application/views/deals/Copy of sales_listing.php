<?php $this->load->view('widgets/meta_tags');
$this->ajax_base_paging =1; ?>
<body>
<section class="body">
  <?php $this->load->view('widgets/header'); ?>
  <div class="inner-wrapper"> 
	<?php $this->load->view('widgets/left_sidebar'); ?>
    <section role="main" class="content-body"> 
	<?php $this->load->view('widgets/breadcrumbs'); ?>
    <!-- start: page -->
	<?php  
		if($this->session->flashdata('success_msg')){ ?>
			<div class="row">
				<div class="col-lg-12">
				<div class="alert alert-success">
				  <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Success!</strong> <?php echo $this->session->flashdata('success_msg'); ?> </div>
		   </div>
		 </div>
	<?php } if($this->session->flashdata('error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php } if($this->session->flashdata('photo_error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('photo_error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php } if($this->session->flashdata('other_medias_error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('other_medias_error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php } if($this->session->flashdata('documents_error_msg')){ ?>
		 	<div class="row">
         	 <div class="col-lg-12">
            	<div class="alert alert-danger">
              		<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
				  <strong>Error!</strong> <?php echo $this->session->flashdata('documents_error_msg'); ?> </div>
			   </div>
       		 </div>
     <?php }  ?> 
	<section class="panel">  
        <header class="panel-heading">
          <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
          <h2 class="panel-title"><?php echo $page_headings; ?></h2>
        </header>
		<?php $vs_user_type_id = $this->session->userdata('us_user_type_id'); ?>
        <div class="panel-body"> 
        <style>
			.col-md-1 {
				padding-right:1px;
				padding-left:3px;
				width:11%;	
			}
			.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td{
				padding:2px;
			}
			
			.table > tbody > tr > td, .table > tfoot > tr > td {
				padding:4px;
			}
		</style> 
         <script>
        function operate_deals_properties(){
			jQuery.noConflict()(function($){	 	  
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
                url: "<?php echo site_url('/properties/deals_list2/'); ?>",
                data: { page: 0, sel_per_page_val:sel_per_page_val, refer_no: refer_no, unit_no: unit_no, price: price, to_price: to_price1, sel_emirate_location_id_val: sel_emirate_location_id_val, sel_property_status_val: sel_property_status_val, sel_assigned_to_id_val: sel_assigned_to_id_val, sel_est_deal_date_val : est_deal_date_val, contact_id_val: sel_contact_id_val, owner_id_val: sel_owner_id_val },
                beforeSend: function(){
                    $('.loading').show();    
                },
                success: function(data){
                    $('.loading').hide();
                    $('#fetch_properties_list').html(data);
					
					$( '[data-toggle=popover]' ).popover();
					
					$('.simple-ajax-modal').magnificPopup({
						type: 'ajax',
						modal: true
					});
                }
            });
			});
			});
        }
        </script> 
		 <form name="datas_form" id="datas_form" action="" method="post"> 
          
          <div class="row">
            <div class="col-md-12"> 
             <?php if(isset($this->properties_dealt_add_module_access) && $this->properties_dealt_add_module_access==1){ ?> <a class="mb-xs mr-xs btn btn-sm btn-success" href="<?= site_url('properties/operate_deal/1'); ?>"> <i class="fa fa-plus"></i> Add New Deal</a> <?php } ?>  
          </div>
        </div>
         
		</form>
		 <style>
		 #datatable-default_filter{
		 	display:none !important;
		 }
		 .table-responsive {
		 	overflow-x:visible !important;
		 }
		 </style>
         <div> 
              <table class="table table-bordered table-striped mb-none" <?php echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
              
              <thead>
              	<tr>
                <td width="5%">    
                <input name="owner_id" id="owner_id" type="hidden" value="">
                <input name="contact_id" id="contact_id" type="hidden" value="">     
                <input name="emirate_location_id" id="emirate_location_id" type="hidden" value="">
                <input name="assigned_to_id" id="assigned_to_id" type="hidden" value="">     
                </td> 
                <td width="8%"> <input name="refer_no" id="refer_no" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('refer_no'); ?>" placeholder="Ref No ..." onKeyUp="operate_deals_properties();"> </td>
                <td width="9%">
                <select name="status" id="status" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_deals_properties();">
                  <option value="">Select </option>
                  <option value="Pending" <?php if(isset($_POST['status']) && $_POST['status']=='Pending'){ echo 'selected="selected"'; } ?>> Pending </option>
                      <option value="Close" <?php if(isset($_POST['status']) && $_POST['status']=='Close'){ echo 'selected="selected"'; } ?>> Close </option>
                      <option value="Cancelled" <?php if(isset($_POST['status']) && $_POST['status']=='Cancelled'){ echo 'selected="selected"'; } ?>> Cancelled </option> 
                </select></td>
                <td width="10%"> 
                <select name="owner_ids" id="owner_ids" class="form-control input-sm mb-md populate" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "enableCaseInsensitiveFiltering": true }'> 
                  <?php  
					$owners_arrs = $this->general_model->get_gen_all_owners_list();
                    if(isset($owners_arrs) && count($owners_arrs)>0){
                        foreach($owners_arrs as $owners_arr){ ?>
                            <option value="<?= $owners_arr->id; ?>" <?php echo (isset($_POST['owner_ids']) && $_POST['owner_ids']==$owners_arr->id) ? 'selected="selected"':''; ?>> <?= stripslashes($owners_arr->name).' ( '.stripslashes($owners_arr->email).' - '.stripslashes($owners_arr->phone_no).' )'; ?> </option>
                  <?php 
                        }
                    } ?>
                </select>
                </td>
                <td width="10%">
                <select name="contact_ids" id="contact_ids" class="form-control input-sm mb-md populate" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "enableCaseInsensitiveFiltering": true }'> 
                  <?php  
                    if(isset($contact_arrs) && count($contact_arrs)>0){
                        foreach($contact_arrs as $contact_arr){ ?>
                            <option value="<?= $contact_arr->id; ?>" <?php echo (isset($_POST['contact_ids']) && $_POST['contact_ids']==$contact_arr->id) ? 'selected="selected"':''; ?>> <?= stripslashes($contact_arr->name).' ( '.stripslashes($contact_arr->email).' - '.stripslashes($contact_arr->phone_no).' )'; ?> </option>
                  <?php 
                        }
                    } ?>
                </select></td>
                <td width="10%"><select name="emirate_location_ids" id="emirate_location_ids" class="form-control input-sm mb-md populate" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "enableCaseInsensitiveFiltering": true }'>
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
                </select></td>
                <td width="9%"><input name="unit_no" id="unit_no" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('unit_no'); ?>" placeholder="Unit No ..." onKeyUp="operate_deals_properties();"> </td>
                <td width="9%"><input name="price" id="price" type="text" class="form-control input-sm" value="<?php echo set_value('price'); ?>" placeholder="From Price" onKeyUp="operate_deals_properties();">
                  -
                  <input name="to_price" id="to_price" type="text" class="form-control input-sm" value="<?php echo set_value('to_price'); ?>" placeholder="To Price" onKeyUp="operate_deals_properties();"></td>
                <td width="10%"><?php if($vs_user_type_id==1 || $vs_user_type_id==2){ ?>
                   <select name="assigned_to_ids" id="assigned_to_ids" class="form-control input-sm mb-md populate" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "enableCaseInsensitiveFiltering": true }'>
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
                  <?php } ?></td>
                <td width="10%" class="center"> 
                <input name="est_deal_date" id="est_deal_date" type="text" class="form-control" value="<?php //echo $est_deal_date; ?>" style="text-align:center;" placeholder="Est. Date..."> </td>
                <td width="10%" class="center">  <a class="mb-xs mr-xs btn btn-sm btn-primary" href="<?= site_url('properties/deals_list'); ?>" title="Clear Filters"> <i class="fa fa-refresh"></i> Clear</a>  
                <script>
					jQuery.noConflict()(function($){	 	  
						$(document).ready(function(){  
						$('#est_deal_date').datepicker({
						  format: "yyyy-mm-dd"
							}).on('change', function(){
								$('.datepicker').hide();
								operate_deals_properties();
							}); 
						});
					});
				</script>
                    </td>
                  </tr>      
                </thead>
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
            <tbody id="fetch_properties_list">
			<?php 
			$permission_results_arr = $this->Permission_Results; 
			$chk_rets = $this->general_model->in_array_field('19', 'module_id','1', 'is_view_permission', $permission_results_arr);  
			if($chk_rets){ 
				$sr=1; 
				if(isset($records) && count($records)>0){
					foreach($records as $record){ 
						$details_url = 'properties/deal_detail/'.$record->id;
						$details_url = site_url($details_url); 
						
						$operate_url = 'properties/operate_deal/1/'.$record->id;
						$operate_url = site_url($operate_url);
						
						$trash_url = 'properties/trash_deal/1/'.$record->id;
						$trash_url = site_url($trash_url);  
						
						$dtls_url = 'public_properties/property_detail/'.$record->property_id;
						$dtls_url = site_url($dtls_url); ?>
                        
                        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
						 <td><?= $sr; ?></td>
						<td> <!--<a href="<?php echo $dtls_url; ?>" target="_blank"><?= stripslashes($record->ref_no); ?></a>--> <?= stripslashes($record->ref_no); ?> </td>
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
						<td class="center"> 
						<div class="btn-group dropup">
							<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu"> 
							<?php if(isset($this->properties_dealt_edit_module_access) && $this->properties_dealt_edit_module_access==1){ ?> <li> <a href="<?php echo $operate_url; ?>"><i class="fa fa-pencil"></i> Update </a> </li> <?php } if(isset($this->properties_dealt_view_module_access) && $this->properties_dealt_view_module_access==1){ ?><li> <a href="<?php echo $details_url; ?>"><i class="fa fa-search-plus"></i> Detail </a> </li> <?php } if(isset($this->properties_dealt_delete_module_access) && $this->properties_dealt_delete_module_access==1){ ?> <li> <a href="<?php echo $trash_url; ?>" title="Delete" onClick="return confirm('Do you want to delete this?');"><i class="fa fa-times"></i> Delete </a> </li><?php } ?> 
							</ul>
						</div> 
						</td>  
                       </tr> 
				<?php 
					$sr++;
					}  ?> 
                       <tr>
                       <td colspan="11">
                       <div style="float:left;">  <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_deals_properties();">
                      <option value="25"> Pages</option>
                      <option value="25"> 25 </option>
                      <option value="50"> 50 </option>
                      <option value="100"> 100 </option> 
                    </select>  </div>
                        <div style="float:right;"> <?php echo $this->ajax_pagination->create_links(); ?>  </div> </td>  
                      </tr> 
                  <?php
				}else{ ?>	
                	 <tr>
                       <td colspan="11" align="center">
                       <div style="float:left;"> <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_deals_properties();">
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
					<td colspan="11" class="center"> <strong> No Permission to access this area! </strong> </td>
				</tr>
			<?php } ?>  
            </tbody>
          </table> 
         </div>
         <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
          <script> 
			jQuery.noConflict()(function($){    
				var str_val_temp ='';
				var str_val ='';
				$('#emirate_location_ids').multiselect({
					nonSelectedText: 'Sub Location',
					enableClickableOptGroups: true,
					enableCollapsibleOptGroups: true,
					enableCaseInsensitiveFiltering: true,
					includeSelectAllOption: false,
					maxHeight: 400,
					buttonWidth: '100%',
					dropUp: true, 
					onChange: function(option, checked, select) {
						str_val_temp = ""; 
						$('#emirate_location_ids :selected').each(function(i, sel){  
							 str_val_temp += (str_val_temp == "") ? "" : ",";
							 str_val_temp += $(sel).val();
						}); 
						
						str_val = str_val_temp; 
						str_val = String(str_val);  
						str_val = str_val.replace(',undefined','');
						str_val = str_val.replace('undefined',''); 
						document.getElementById("emirate_location_id").value = str_val;
						operate_deals_properties(); 
					}
				});
				 
				<?php if($vs_user_type_id==1 || $vs_user_type_id==2){ ?>  
					var str_val_temp ='';
					var str_val ='';
				 
					$('#assigned_to_ids').multiselect({
						nonSelectedText: 'Agent',
						enableClickableOptGroups: true,
						enableCollapsibleOptGroups: true,
						enableCaseInsensitiveFiltering: true,
						includeSelectAllOption: false,
						maxHeight: 400,
						buttonWidth: '100%',
						dropUp: true, 
						onChange: function(option, checked, select) {
							str_val_temp = ""; 
							$('#assigned_to_ids :selected').each(function(i, sel){  
								 str_val_temp += (str_val_temp == "") ? "" : ",";
								 str_val_temp += $(sel).val();
							}); 
							
							str_val = str_val_temp; 
							str_val = String(str_val);  
							str_val = str_val.replace(',undefined','');
							str_val = str_val.replace('undefined',''); 
							document.getElementById("assigned_to_id").value = str_val;
							operate_deals_properties(); 
						}
					});
			
			<?php } ?>
			
			
				var str_val_temp ='';
				var str_val =''; 
				$('#contact_ids').multiselect({
					nonSelectedText: 'Buyer(s)',
					enableClickableOptGroups: true,
					enableCollapsibleOptGroups: true,
					enableCaseInsensitiveFiltering: true,
					includeSelectAllOption: false,
					maxHeight: 400,
					buttonWidth: '100%',
					dropUp: true, 
					onChange: function(option, checked, select) {
						str_val_temp = ""; 
						$('#contact_ids :selected').each(function(i, sel){  
							 str_val_temp += (str_val_temp == "") ? "" : ",";
							 str_val_temp += $(sel).val();
						}); 
						
						str_val = str_val_temp; 
						str_val = String(str_val);  
						str_val = str_val.replace(',undefined','');
						str_val = str_val.replace('undefined',''); 
						document.getElementById("contact_id").value = str_val;
						operate_deals_properties(); 
					}
				}); 
				
				var str_val_temp ='';
				var str_val =''; 
				$('#owner_ids').multiselect({
					nonSelectedText: 'Seller(s)',
					enableClickableOptGroups: true,
					enableCollapsibleOptGroups: true,
					enableCaseInsensitiveFiltering: true,
					includeSelectAllOption: false,
					maxHeight: 400,
					buttonWidth: '100%',
					dropUp: true, 
					onChange: function(option, checked, select) {
						str_val_temp = ""; 
						$('#owner_ids :selected').each(function(i, sel){  
							 str_val_temp += (str_val_temp == "") ? "" : ",";
							 str_val_temp += $(sel).val();
						}); 
						
						str_val = str_val_temp; 
						str_val = String(str_val);  
						str_val = str_val.replace(',undefined','');
						str_val = str_val.replace('undefined',''); 
						document.getElementById("owner_id").value = str_val;
						operate_deals_properties(); 
					}
				});
				   
			});	  
			
		</script>  
        </div>
      </section>         
	 
  <!--  class="simple-ajax-modal"  end: page -->
  </section>
  </div> 
</section>
<?php $this->load->view('widgets/footer'); ?>