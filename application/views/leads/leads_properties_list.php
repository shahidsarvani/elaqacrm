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
   	 function operate_leads_properties(){  
		
		jQuery.noConflict()(function($){	 	  
			$(document).ready(function(){
					
			var sel_per_page_val =0;  
			var sel_emirate_location_id_val ='';
			var sel_no_of_beds_id_val ='';
			var sel_owner_id_val ='';
			var sel_property_status_val =0;
			var sel_assigned_to_id_val ='';
			 
			var refer_no = document.getElementById("refer_no").value; 
			var price = document.getElementById("price").value;
			var to_price = document.getElementById("to_price").value;
			
			var sel_per_page = document.getElementById("per_page");
			sel_per_page_val = sel_per_page.options[sel_per_page.selectedIndex].value;

			var sel_emirate_location_id_val = document.getElementById("emirate_location_id").value;
			var sel_no_of_beds_id_val = document.getElementById("no_of_beds_id").value;
			var plot_area = document.getElementById("plot_area").value;
			 
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('/properties/leads_properties_list2/'); ?>",
				data: { page: 0, sel_per_page_val:sel_per_page_val, refer_no: refer_no, price: price, to_price: to_price, sel_emirate_location_id_val: sel_emirate_location_id_val, sel_no_of_beds_id_val: sel_no_of_beds_id_val, plot_area: plot_area },
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
             <?php if(isset($this->properties_leads_add_module_access) && $this->properties_leads_add_module_access==1){ ?> <!--<a class="mb-xs mr-xs btn btn-sm btn-success" href="<?= site_url('properties/operate_property'); ?>"> <i class="fa fa-plus"></i> Add New Property</a>--> <?php } ?> 
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
                <input name="emirate_location_id" id="emirate_location_id" type="hidden" value="">
                <input name="no_of_beds_id" id="no_of_beds_id" type="hidden" value=""> 
                 </td> 
                <td width="8%"> <input name="refer_no" id="refer_no" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('refer_no'); ?>" placeholder="Ref No ..." onKeyUp="operate_leads_properties();"> </td>
                <td width="11%"> <select name="emirate_location_ids" id="emirate_location_ids" class="form-control input-sm mb-md populate" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "enableCaseInsensitiveFiltering": true }'>  
                  <?php  	
        $emirate_sub_location_arrs = $this->admin_model->get_all_emirate_sub_locations(); 
        if(isset($emirate_sub_location_arrs) && count($emirate_sub_location_arrs)>0){
            foreach($emirate_sub_location_arrs as $emirate_sub_location_arr){
            
            $sel_1 = '';
            if(isset($_POST['emirate_location_id']) && $_POST['emirate_location_id']==$emirate_sub_location_arr->id){
                $sel_1 = 'selected="selected"';
            } ?>
                  <option value="<?= $emirate_sub_location_arr->id; ?>" <?php echo $sel_1; ?>> <?= stripslashes($emirate_sub_location_arr->name); ?></option>
                  <?php 
            } 
        } ?>	 
                  
                </select> </td>
                <td width="11%">   
                  <select name="no_of_beds_ids" id="no_of_beds_ids" class="form-control input-sm mb-md populate" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "enableCaseInsensitiveFiltering": true }'>  
                    <?php  
            if(isset($beds_arrs) && count($beds_arrs)>0){
                foreach($beds_arrs as $beds_arr){
                $sel_1 = '';
                if(isset($_POST['no_of_beds_id']) && $_POST['no_of_beds_id']==$beds_arr->id){
                    $sel_1 = 'selected="selected"';
                } ?>
                    <option value="<?= $beds_arr->id; ?>" <?php echo $sel_1; ?>>
                      <?= stripslashes($beds_arr->title); ?>
                      </option>
                    <?php 
                }
            } ?>
                  </select> </td>
                <td width="9%"> <input name="price" id="price" type="text" class="form-control input-sm" value="<?php echo set_value('price'); ?>" placeholder="From Price" onKeyUp="operate_leads_properties();"> - <input name="to_price" id="to_price" type="text" class="form-control input-sm" value="<?php echo set_value('to_price'); ?>" placeholder="To Price" onKeyUp="operate_leads_properties();"></td>
                <td width="8%"><input name="plot_area" id="plot_area" type="text" class="form-control input-sm mb-md" value="<?php echo set_value('plot_area'); ?>" placeholder="Size ..." onKeyUp="operate_leads_properties();"></td>
                <td width="11%" class="center">  <a class="mb-xs mr-xs btn btn-sm btn-primary" href="<?= site_url('properties/leads_properties_list'); ?>" title="Clear Filters"> <i class="fa fa-refresh"></i> Clear</a>   
                </td>
              </tr>
            </thead> 
            
            <thead>
               <tr>
                <th>#</th> 
                <th>Ref No </th>
                <th>Sub Location</th>
                <th>Bedrooms </th>
                <th>Price</th>
                <th>Size</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <tbody id="fetch_properties_list">
			<?php 
			$permission_results_arr = $this->Permission_Results; 
			$chk_rets = $this->general_model->in_array_field('21', 'module_id','1', 'is_view_permission', $permission_results_arr);  
			if($chk_rets){ 
				$sr=1; 
				if(isset($records) && count($records)>0){
					foreach($records as $record){ 
						$details_url = 'public_properties/property_detail/'.$record->id;
						$details_url = site_url($details_url); 
						
						$archv_url = 'properties/property_to_archive/3/'.$record->id;
						$archv_url = site_url($archv_url); 
						
						$dealts_url = 'properties/property_to_dealt/3/'.$record->id;
						$dealts_url = site_url($dealts_url); 
						
						$trash_url = 'properties/delete_property/5/'.$record->id;
						$trash_url = site_url($trash_url);
						
						
						$get_lead_property_brief = 'properties/get_lead_property_brief/'.$record->id.'/';
                        $get_lead_property_brief = site_url($get_lead_property_brief); 
						
						 ?>
						<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
                             <td><?php echo $sr;
								echo ($record->is_new==1) ? ' <span class="badge_mini label-danger">new</span>':'';  ?></td>
                            <td><?= stripslashes($record->ref_no); ?></td>
                            <td><?php echo stripslashes($record->sub_loc_name); ?> </td>
                            <td><?php echo stripslashes($record->bed_title); ?> </td>
                            <td><?php echo CRM_CURRENCY.' '.number_format($record->price,2,".",","); ?> </td>
                            <td><?= stripslashes($record->plot_area); ?></td>
                          <td class="center"> 
						  <div class="btn-group dropup">
							<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button> 
  <ul class="dropdown-menu" role="menu"> <?php if(isset($this->properties_leads_edit_module_access) && $this->properties_leads_edit_module_access==1){ ?> <!--<li> <a href="<?php echo $operate_url; ?>"><i class="fa fa-pencil"></i> Update </a> </li> --><?php } if(isset($this->properties_leads_view_module_access) && $this->properties_leads_view_module_access==1){ ?> <li> <!--<a href="<?php echo $details_url; ?>" target="_blank"><i class="fa fa-search-plus"></i> Detail </a>--> <a class="simple-ajax-modal" href="<?php echo $get_lead_property_brief; ?>"><i class="fa fa-search-plus"></i> Detail</a> </li> <?php } if(isset($this->properties_leads_delete_module_access) && $this->properties_leads_delete_module_access==1){ ?>  <li> <a href="<?php echo $trash_url; ?>" title="Delete" onClick="return confirm('Do you want to delete this?');"><i class="fa fa-times"></i> Delete </a> </li> <?php } ?> </ul> 
                         </div>   
						</td> 
                        </tr>
				<?php 
					$sr++;
					} ?> 
                       <tr>
                       <td colspan="7">
                       <div style="float:left;"> <select name="per_page" id="per_page" data-plugin-selectTwo class="form-control input-sm mb-md populate" onChange="operate_leads_properties();">
                  <option value="25"> Pages</option>
                  <option value="25"> 25 </option>
                  <option value="50"> 50 </option>
                  <option value="100"> 100 </option> 
                </select>  </div>
                        <div style="float:right;">  <?php echo $this->ajax_pagination->create_links(); ?> </div> </td>  
                      </tr> 
                  <?php   
				}else{ ?>	
				<tr class="gradeX"> 
					<td colspan="7" class="center"> <strong> No Record Found! </strong> </td>
				</tr>
				<?php 
				} 
			}else{ ?>	
				<tr class="gradeX"><td colspan="7" class="center"> <strong> No Permission to access this area! </strong> </td>
				</tr>
		<?php } ?>  
            </tbody>
          </table>
          
         </div>
         <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
          <script> 
			jQuery.noConflict()(function($){	 	  
			//$(document).ready(function(){
				  
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
						operate_leads_properties(); 
					}
				}); 
				
				var str_val_temp ='';
				var str_val =''; 
				$('#no_of_beds_ids').multiselect({
					nonSelectedText: 'Bedrooms',
					enableClickableOptGroups: true,
					enableCollapsibleOptGroups: true,
					enableCaseInsensitiveFiltering: true,
					includeSelectAllOption: false,
					maxHeight: 400,
					buttonWidth: '100%',
					dropUp: true, 
					onChange: function(option, checked, select) {
						str_val_temp = ""; 
						$('#no_of_beds_ids :selected').each(function(i, sel){  
							 str_val_temp += (str_val_temp == "") ? "" : ",";
							 str_val_temp += $(sel).val();
						}); 
						
						str_val = str_val_temp; 
						str_val = String(str_val);  
						str_val = str_val.replace(',undefined','');
						str_val = str_val.replace('undefined',''); 
						document.getElementById("no_of_beds_id").value = str_val;
						operate_leads_properties(); 
					}
				});
			});	 
		 //});	   
		</script>  
        </div>
      </section>
	 
  <!--  class="simple-ajax-modal"  end: page -->
  </section>
  </div> 
</section>
<?php $this->load->view('widgets/footer'); ?>