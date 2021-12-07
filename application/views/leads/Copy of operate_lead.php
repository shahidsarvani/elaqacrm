<?php $this->load->view('widgets/meta_tags'); ?>
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
	<?php }   
	 if($this->session->flashdata('error_msg')){ ?>
		<div class="row">
		 <div class="col-lg-12">
			<div class="alert alert-danger">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error_msg'); ?> </div>
		   </div>
		 </div>
	<?php } ?> 	
      <?php 
		if(isset($args1) && $args1>0){
			$form_act = "properties/operate_lead/".$args1;
		}else{
			$form_act = "properties/operate_lead";
		} ?> 
      <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal form-bordered" enctype="multipart/form-data"> 
            <section class="panel">
              <header class="panel-heading">
                <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
                <h2 class="panel-title">Lead Details</h2>
              </header>
              <div class="panel-body"> 
			    
			   <div class="row"> 
				<div class="col-lg-6">  
                <div class="form-group">
              <label class="col-md-3 control-label" for="lead_ref"> Ref No. <span class="reds">*</span> </label>
              <div class="col-md-8">
                <input name="lead_ref" id="lead_ref" type="text" class="form-control" value="<?php if(isset($_POST['lead_ref'])){ echo $_POST['lead_ref']; }else if(isset($record)){ echo stripslashes($record->ref_no); }else{ echo $auto_ref_no; } ?>" readonly>
                <span class="text-danger"><?php echo form_error('lead_ref'); ?></span> 
              </div>  
            </div>
            
	<div class="form-group">
      <label class="col-md-3 control-label" for="contact_id">Contact <span class="reds">*</span> </label>
      <div class="col-md-8">
      <div id="fetch_new_contacts">
      <input type="text" name="contact_id" id="contact_id" class="form-control populate" value="<?php echo (isset($record) && $record->contact_id >0) ? $record->contact_id:'0'; ?>" onChange="operate_contact_info(this.value);">
      <?php $temp_contact_sl_email =  $temp_contact_sl_phone_no = ''; ?>
      <div id="fetch_contacts_info">
        <?php if(isset($record) && $record->contact_id >0){
        $db_docs_arr0 = $this->general_model->get_gen_contact_info_by_id($record->contact_id); 
        if(isset($db_docs_arr0) && count($db_docs_arr0)>0){ 
            $temp_contact_sl_email = $db_docs_arr0->email;
            $temp_contact_sl_phone_no = $db_docs_arr0->phone_no;  
        } ?>
        <div class="text-info"> <i class="fa fa-envelope-o"></i> <?php echo $temp_contact_sl_email; ?> </div>
        <div class="text-info"> <i class="fa fa-phone"></i> <?php echo $temp_contact_sl_phone_no; ?> </div>
        <?php } ?>
      </div>
      </div> 
        <span class="text-danger"><?php echo form_error('contact_id'); ?></span> 
        <?php
        $cnt_popup_url = 'contacts/leads_contacts_popup_list';
        $cnt_popup_url = site_url($cnt_popup_url);  
        if($this->contacts_add_module_access==1){ ?> 
            <a class="simple-ajax-modal" href="<?php echo $cnt_popup_url; ?>"><i class="fa fa-plus"></i> Add Contacts</a>
        <?php } ?>
    </div>  
	</div> 
		<?php 
            if($this->login_vs_user_type_id!=3){ ?>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="assigned_to_id">Agent <span class="reds">*</span></label>
                  <div class="col-md-8">
                    <select name="assigned_to_id" id="assigned_to_id" data-plugin-selectTwo class="form-control populate">
                      <option value="">Select Agent </option>
                      <?php
					  	$usrid = $this->session->userdata('us_id');     
                        if(isset($user_arrs) && count($user_arrs)>0){
                            foreach($user_arrs as $user_arr){
                            $sel_1 = '';
                            if(isset($_POST['assigned_to_id']) && $_POST['assigned_to_id']==$user_arr->id){
                                $sel_1 = 'selected="selected"';
                            }else if(isset($record) && $record->agent_id==$user_arr->id){
                                $sel_1 = 'selected="selected"';
                            }else if(isset($usrid) && $usrid==$user_arr->id){
								$sel_1 = 'selected="selected"';
							} ?>
                            <option value="<?= $user_arr->id; ?>" <?php echo $sel_1; ?>> <?= stripslashes($user_arr->name); ?> </option>
                         <?php 
                            }
                        } ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('assigned_to_id'); ?></span> 
                    </div>
                </div>
              <?php } ?>   		
            
            <div class="form-group">
              <label class="col-md-3 control-label" for="enquiry_date">Enquiry Date </label>
              <div class="col-md-4">
            <?php 
				$enquiry_date = '';
                if(isset($_POST['enquiry_date'])){
					$enquiry_date = $_POST['enquiry_date'];
				}else if(isset($record) && $record->enquiry_date!='0000-00-00'){
                    $enquiry_date = $record->enquiry_date;
                }else{
						$enquiry_date = date('Y-m-d');
					}
					
				$enquiry_time = '';
                if(isset($_POST['enquiry_time']) && $_POST['enquiry_time']!=''){
					$enquiry_time = $_POST['enquiry_time'];
				}else if(isset($record) && $record->enquiry_time!=''){
                    $enquiry_time = $record->enquiry_time;
                }else{
					$enquiry_time = date("g:i A");
				} ?> 
                <input name="enquiry_date" placeholder="Adjust Enquiry Date" id="enquiry_date" type="text" class="form-control" value="<?php echo $enquiry_date; ?>" style="text-align:center;" readonly> <span class="text-danger"><?php echo form_error('enquiry_date'); ?></span> </div>
                
              <div class="col-md-4"> 
                <input class="form-control" placeholder="Adjust Enquiry Time" id="enquiry_time" name="enquiry_time" value="<?php echo $enquiry_time; ?>" style="text-align:center;" readonly>
                <span class="text-danger"><?php echo form_error('enquiry_time'); ?></span>
                </div>
            </div>
                    
                
            <div class="form-group">
              <label class="col-md-3 control-label" for="lead_type">Lead Type <span class="reds">*</span></label>
              <div class="col-md-8"> 
                <select name="lead_type" id="lead_type" data-plugin-selectTwo class="form-control populate">
                  <option value="">Select </option>  
                    <option value="Tenant" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Tenant') || (isset($record) && $record->lead_type=='Tenant')){ echo 'selected="selected"'; } ?>> Tenant </option> 
                    
                    <option value="Buyer" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Buyer') || (isset($record) && $record->lead_type=='Buyer')){ echo 'selected="selected"'; } ?>> Buyer </option> 
                    
                    <option value="Landlord" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord') || (isset($record) && $record->lead_type=='Landlord')){ echo 'selected="selected"'; } ?>> Landlord </option> 
                    
                    <option value="Seller" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Seller') || (isset($record) && $record->lead_type=='Seller')){ echo 'selected="selected"'; } ?>> Seller </option> 
                    
                    <option value="Landlord+Seller" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Landlord+Seller') || (isset($record) && $record->lead_type=='Landlord+Seller')){ echo 'selected="selected"'; } ?>> Landlord+Seller </option> 
                    
                    <option value="Not Specified" <?php if((isset($_POST['lead_type']) && $_POST['lead_type']=='Not Specified') || (isset($record) && $record->lead_type=='Not Specified')){ echo 'selected="selected"'; } ?>> Not Specified </option>     
                </select>
                <span class="text-danger"><?php echo form_error('lead_type'); ?></span> </div>
            </div>  	
             
            <div class="form-group">
              <label class="col-md-3 control-label" for="lead_status">Status <span class="reds">*</span></label>
              <div class="col-md-8"> 
                  <select name="lead_status" id="lead_status" data-plugin-selectTwo class="form-control populate">
  <option value="">Select </option>
  <option value="Closed" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Closed') || (isset($record) && $record->lead_status=='Closed')){ echo 'selected="selected"'; } ?>> Closed </option> 
  
  <option value="Not yet contacted" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Not yet contacted') || (isset($record) && $record->lead_status=='Not yet contacted')){ echo 'selected="selected"'; } ?>> Not yet contacted </option> 
   
   <option value="Called no reply" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Called no reply') || (isset($record) && $record->lead_status=='Called no reply')){ echo 'selected="selected"'; } ?>> Called no reply </option> 
   
   <option value="Client not reachable" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Client not reachable') || (isset($record) && $record->lead_status=='Client not reachable')){ echo 'selected="selected"'; } ?>> Client not reachable </option> 
  
  <option value="Follow up" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Follow up') || (isset($record) && $record->lead_status=='Follow up')){ echo 'selected="selected"'; } ?>> Follow up </option> 
   
   <option value="Viewing arranged" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Viewing arranged') || (isset($record) && $record->lead_status=='Viewing arranged')){ echo 'selected="selected"'; } ?>> Viewing arranged </option> 
  <option value="Searching for options" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Searching for options') || (isset($record) && $record->lead_status=='Searching for options')){ echo 'selected="selected"'; } ?>> Searching for options </option> 
  
  <option value="Offer made" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Offer made') || (isset($record) && $record->lead_status=='Offer made')){ echo 'selected="selected"'; } ?>> Offer made </option> 
   
   <option value="Incorrect contact details" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Incorrect contact details') || (isset($record) && $record->lead_status=='Incorrect contact details')){ echo 'selected="selected"'; } ?>> Incorrect contact details </option>
   
   <option value="Invalid inquiry" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Invalid inquiry') || (isset($record) && $record->lead_status=='Invalid inquiry')){ echo 'selected="selected"'; } ?>> Invalid inquiry </option> 

<option value="Unsuccessful" <?php if((isset($_POST['lead_status']) && $_POST['lead_status']=='Unsuccessful') || (isset($record) && $record->lead_status=='Unsuccessful')){ echo 'selected="selected"'; } ?>> Unsuccessful </option>   
   
</select>
                <span class="text-danger"><?php echo form_error('lead_status'); ?></span> </div>
            </div> 
                
			<div class="form-group">
              <label class="col-md-3 control-label" for="priority">Priority <span class="reds">*</span></label>
              <div class="col-md-8"> 
                <select name="priority" id="priority" data-plugin-selectTwo class="form-control populate">
                  <option value="">Select </option>
                  <option value="Urgent" <?php if((isset($_POST['priority']) && $_POST['priority']=='Urgent') || (isset($record) && $record->priority=='Urgent')){ echo 'selected="selected"'; } ?>> Urgent </option> 
                  <option value="High" <?php if((isset($_POST['priority']) && $_POST['priority']=='High') || (isset($record) && $record->priority=='High')){ echo 'selected="selected"'; } ?>> High </option> 
                  <option value="Low" <?php if((isset($_POST['priority']) && $_POST['priority']=='Low') || (isset($record) && $record->priority=='Low')){ echo 'selected="selected"'; } ?>> Low </option> 
                   <option value="Normal" <?php if((isset($_POST['priority']) && $_POST['priority']=='Normal') || (isset($record) && $record->priority=='Normal')){ echo 'selected="selected"'; } ?>> Normal </option>  
                </select>
                <span class="text-danger"><?php echo form_error('priority'); ?></span> </div>
            </div> 
            
            <div class="form-group">
              <label class="col-md-3 control-label" for="source_of_listing">Source <span class="reds">*</span> </label>
              <div class="col-md-8">
                <select name="source_of_listing" id="source_of_listing" data-plugin-selectTwo class="form-control populate">
                  <option value="">Select </option>
                <?php  
                if(isset($source_of_listing_arrs) && count($source_of_listing_arrs)>0){
                    foreach($source_of_listing_arrs as $source_of_listing_arr){
                        $sel_1 = '';
                        if(isset($_POST['source_of_listing']) && $_POST['source_of_listing']==$source_of_listing_arr->id){
                            $sel_1 = 'selected="selected"';
                        }else if(isset($record) && $record->source_of_listing==$source_of_listing_arr->id){
                            $sel_1 = 'selected="selected"';
                        } ?>
                      <option value="<?= $source_of_listing_arr->id; ?>" <?php echo $sel_1; ?>>  <?= stripslashes($source_of_listing_arr->title); ?> </option>
                      <?php 
                    }
                } ?> </select>
                    <span class="text-danger"><?php echo form_error('source_of_listing'); ?></span> </div>
                </div> 	
                
                	    	
			</div>
				
            <div class="col-lg-6">    
           
            <div class="form-group">
              <label class="col-md-3 control-label" for="no_of_views">Property View </label>
              <div class="col-md-8">
              <input name="no_of_views" id="no_of_views" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->no_of_views): set_value('no_of_views'); ?>"> <span class="text-danger"><?php echo form_error('no_of_views'); ?></span>  
                </div>
            </div>
        
        
            
        <div class="col-md-12"> 
            <div class="form-group">
    	<?php
            $sel_property_id_1 = ''; 
			$pp_ref_no_1  = ''; 
			$pp_ref_no_title_1 = 'Select Property...'; 
			$pp_title_1 = ''; 
			$pp_price_1 = ''; 
			$pp_type_1 = '';  
			$pp_cate_name_1 = ''; 
			 
			if(isset($_POST['property_id_1']) && $_POST['property_id_1']>0){
                $sel_property_id_1 = $_POST['property_id_1'];
            }else if(isset($record) && $record->property_id_1 >0) { 
                $sel_property_id_1 = $record->property_id_1;  
            }
					
			if($sel_property_id_1 >0) {  
				$prop_data_arr1 = $this->general_model->get_gen_lead_property_info_by_id($sel_property_id_1); 
				$pp_ref_no_title_1 = stripslashes($prop_data_arr1->ref_no);
				$pp_ref_no_1  = stripslashes($prop_data_arr1->ref_no);
				$pp_title_1 = stripslashes($prop_data_arr1->title);
				$pp_price_1 = $prop_data_arr1->price;  
				$pp_price_1 = 'AED '.number_format($pp_price_1,2,".",","); 
				$pp_type_1 = ($prop_data_arr1->property_type==1) ? 'Sale' : 'Rent';;  
				 
				$cates_arr1 = $this->admin_model->get_category_by_id($prop_data_arr1->category_id);
				if(isset($cates_arr1) && count($cates_arr1) >0){
					$pp_cate_name_1 = stripslashes($cates_arr1->name);
				}  
			}   ?>
                
                <input type="hidden" id="property_id_1" name="property_id_1" value="<?php echo $sel_property_id_1; ?>">
            
                <label class="col-md-3 control-label" for="property_id_1">Property 1 </label>
                <div class="col-md-8"> 
                <div class="panel-group" id="accordionSuccess">
                    <div class="panel panel-accordion panel-accordion-default">
                        <div class="panel-heading" style="height:35px; clear:both;">
                            
                        <a class="accordion-toggle collapsed fa fa-caret-down" data-toggle="collapse" data-parent="#accordionSuccess" href="#collapseSuccessOne" aria-expanded="false" id="property_title_1" style="display:inline; float:left; padding:0px; margin:10px;"> &nbsp; <?php echo $pp_ref_no_title_1; ?> </a>  
                         
                        <a style=" <?php echo ($sel_property_id_1 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="javascript:operate_remove_property('1');" id="propery_remove_link_txt_1"> <i class="fa fa-minus"> </i> </a>     	
				<?php  
                    if($sel_property_id_1 >0){ 
                        $lead_prop_update_popup_url_1 = "properties/leads_properties_popup_update/{$sel_property_id_1}/1";
                        $lead_prop_update_popup_url_1 = site_url($lead_prop_update_popup_url_1);
                    }else{ 
                        $lead_prop_update_popup_url_1 = "properties/leads_properties_popup_update/";
                        $lead_prop_update_popup_url_1 = site_url($lead_prop_update_popup_url_1);
                    } ?> 
                    
                    <a style=" <?php echo ($sel_property_id_1 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="<?php echo $lead_prop_update_popup_url_1; ?>" id="propery_pencil_link_txt_1" class="simple-ajax-modal"> <i class="fa fa-pencil"> </i> </a>
                                
                        <?php 
                        $lead_prop_popup_url_1 = 'properties/leads_properties_popup_list/1';
                        $lead_prop_popup_url_1 = site_url($lead_prop_popup_url_1);    ?> 
                        <a style="display:inline; float:right; padding:0px; margin:8px 4px 8px 8px;" class="simple-ajax-modal" href="<?php echo $lead_prop_popup_url_1; ?>" id="propery_link_txt_1"> <i class="fa fa-plus"> </i> </a>   
                                    
                </div>
                
            <div id="collapseSuccessOne" class="accordion-body collapse" aria-expanded="false">
                <div class="panel-body" id="property_detail_1">          
            <?php 
                if($sel_property_id_1 >0) { ?>
                    <strong>Property Title: </strong>  <?php echo $pp_title_1; ?>  <br> 
                    <strong>Property Ref #: </strong> <?php echo $pp_ref_no_1; ?> <br> 
                    <strong>Price: </strong> <?php echo $pp_price_1; ?> <br> 
                    <strong>Property Type: </strong>  <?php echo $pp_type_1; ?> <br> 
                    <strong>Category: </strong>  <?php echo $pp_cate_name_1; ?> <br>   
               <?php }else{
                        echo "<strong>Select Property!</strong>";
                     } ?>   
                    
                    </div>
                </div>
            </div> 
        </div>
    </div> 
    </div>
		</div>  

		<div class="col-md-12"> 
        <div class="form-group">
    <?php
        $sel_property_id_2 = ''; 
        $pp_ref_no_2  = ''; 
        $pp_ref_no_title_2 = 'Select Property...'; 
        $pp_title_2 = ''; 
        $pp_price_2 = ''; 
        $pp_type_2 = '';  
        $pp_cate_name_2 = ''; 
         
        if(isset($_POST['property_id_2']) && $_POST['property_id_2']>0){
            $sel_property_id_2 = $_POST['property_id_2'];
        }else if(isset($record) && $record->property_id_2 >0) { 
            $sel_property_id_2 = $record->property_id_2;  
        }
                
        if($sel_property_id_2 >0) {  
            $prop_data_arr1 = $this->general_model->get_gen_lead_property_info_by_id($sel_property_id_2); 
            $pp_ref_no_title_2 = stripslashes($prop_data_arr1->ref_no);
            $pp_ref_no_2  = stripslashes($prop_data_arr1->ref_no);
            $pp_title_2 = stripslashes($prop_data_arr1->title);
            $pp_price_2 = $prop_data_arr1->price;  
            $pp_price_2 = 'AED '.number_format($pp_price_2,2,".",","); 
            $pp_type_2 = ($prop_data_arr1->property_type==1) ? 'Sale' : 'Rent';;  
             
            $cates_arr2 = $this->admin_model->get_category_by_id($prop_data_arr1->category_id);
            if(isset($cates_arr2) && count($cates_arr2) >0){
                $pp_cate_name_2 = stripslashes($cates_arr2->name);
            }  
        }   ?>
            
            <input type="hidden" id="property_id_2" name="property_id_2" value="<?php echo $sel_property_id_2; ?>">
        
            <label class="col-md-3 control-label" for="property_id_2">Property 2 </label>
            <div class="col-md-8"> 
            <div class="panel-group" id="accordionSuccess">
                <div class="panel panel-accordion panel-accordion-default">
                    <div class="panel-heading" style="height:35px; clear:both;">
                        
                    <a class="accordion-toggle collapsed fa fa-caret-down" data-toggle="collapse" data-parent="#accordionSuccess" href="#collapseSuccess2" aria-expanded="false" id="property_title_2" style="display:inline; float:left; padding:0px; margin:10px;"> &nbsp; <?php echo $pp_ref_no_title_2; ?> </a> 
                    
                    <a style=" <?php echo ($sel_property_id_2 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="javascript:operate_remove_property('2');" id="propery_remove_link_txt_2"> <i class="fa fa-minus"> </i> </a>  
                     
                    <?php  
                    if($sel_property_id_2 >0){ 
                        $lead_prop_update_popup_url_2 = "properties/leads_properties_popup_update/{$sel_property_id_2}/2";
                        $lead_prop_update_popup_url_2 = site_url($lead_prop_update_popup_url_2);
                    }else{ 
                        $lead_prop_update_popup_url_2 = "properties/leads_properties_popup_update/";
                        $lead_prop_update_popup_url_2 = site_url($lead_prop_update_popup_url_2);
                    } ?> 
                    
                    <a style=" <?php echo ($sel_property_id_2 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="<?php echo $lead_prop_update_popup_url_2; ?>" id="propery_pencil_link_txt_2" class="simple-ajax-modal"> <i class="fa fa-pencil"> </i> </a> 
                    
                             
                    <?php 
                    $lead_prop_popup_url_2 = 'properties/leads_properties_popup_list/2';
                    $lead_prop_popup_url_2 = site_url($lead_prop_popup_url_2);    ?> 
                    <a style="display:inline; float:right; padding:0px; margin:8px 4px 8px 8px;" class="simple-ajax-modal" href="<?php echo $lead_prop_popup_url_2; ?>" id="propery_link_txt_2"> <i class="fa fa-plus"> </i> </a>              
            </div>
            
        <div id="collapseSuccess2" class="accordion-body collapse" aria-expanded="false">
            <div class="panel-body" id="property_detail_2">          
        <?php 
            if($sel_property_id_2 >0) { ?>
                <strong>Property Title: </strong> <?php echo $pp_title_2; ?>  <br> 
                <strong>Property Ref #: </strong> <?php echo $pp_ref_no_2; ?> <br> 
                <strong>Price: </strong> <?php echo $pp_price_2; ?> <br> 
                <strong>Property Type: </strong>  <?php echo $pp_type_2; ?> <br> 
                <strong>Category: </strong>  <?php echo $pp_cate_name_2; ?> <br>   
           <?php }else{
                    echo "<strong>Select Property!</strong>";
                 } ?>   
                
                </div>
            </div>
        </div> 
    </div>
</div> 
</div>
</div>
        
       <div class="col-md-12"> 
        <div class="form-group">
    <?php
        $sel_property_id_3 = ''; 
        $pp_ref_no_3  = ''; 
        $pp_ref_no_title_3 = 'Select Property...'; 
        $pp_title_3 = ''; 
        $pp_price_3 = ''; 
        $pp_type_3 = '';  
        $pp_cate_name_3 = ''; 
         
        if(isset($_POST['property_id_3']) && $_POST['property_id_3']>0){
            $sel_property_id_3 = $_POST['property_id_3'];
        }else if(isset($record) && $record->property_id_3 >0) { 
            $sel_property_id_3 = $record->property_id_3;  
        }
                
        if($sel_property_id_3 >0) {  
            $prop_data_arr1 = $this->general_model->get_gen_lead_property_info_by_id($sel_property_id_3); 
            $pp_ref_no_title_3 = stripslashes($prop_data_arr1->ref_no);
            $pp_ref_no_3  = stripslashes($prop_data_arr1->ref_no);
            $pp_title_3 = stripslashes($prop_data_arr1->title);
            $pp_price_3 = $prop_data_arr1->price;  
            $pp_price_3 = 'AED '.number_format($pp_price_3,2,".",","); 
            $pp_type_3 = ($prop_data_arr1->property_type==1) ? 'Sale' : 'Rent';;  
             
            $cates_arr3 = $this->admin_model->get_category_by_id($prop_data_arr1->category_id);
            if(isset($cates_arr3) && count($cates_arr3) >0){
                $pp_cate_name_3 = stripslashes($cates_arr3->name);
            }  
        }   ?>
            
            <input type="hidden" id="property_id_3" name="property_id_3" value="<?php echo $sel_property_id_3; ?>">
        
            <label class="col-md-3 control-label" for="property_id_3">Property 3 </label>
            <div class="col-md-8"> 
            <div class="panel-group" id="accordionSuccess">
                <div class="panel panel-accordion panel-accordion-default">
                    <div class="panel-heading" style="height:35px; clear:both;">
                        
                    <a class="accordion-toggle collapsed fa fa-caret-down" data-toggle="collapse" data-parent="#accordionSuccess" href="#collapseSuccess3" aria-expanded="false" id="property_title_3" style="display:inline; float:left; padding:0px; margin:10px;"> &nbsp; <?php echo $pp_ref_no_title_3; ?> </a>  
                    
                    <a style=" <?php echo ($sel_property_id_3 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="javascript:operate_remove_property('3');" id="propery_remove_link_txt_3"> <i class="fa fa-minus"> </i> </a>        
                    
                     <?php  
                    if($sel_property_id_3 >0){ 
                        $lead_prop_update_popup_url_3 = "properties/leads_properties_popup_update/{$sel_property_id_3}/3";
                        $lead_prop_update_popup_url_3 = site_url($lead_prop_update_popup_url_3);
                    }else{ 
                        $lead_prop_update_popup_url_3 = "properties/leads_properties_popup_update/";
                        $lead_prop_update_popup_url_3 = site_url($lead_prop_update_popup_url_3);
                    } ?> 
                    
                    <a style=" <?php echo ($sel_property_id_3 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="<?php echo $lead_prop_update_popup_url_3; ?>" id="propery_pencil_link_txt_3" class="simple-ajax-modal"> <i class="fa fa-pencil"> </i> </a>  
                            
                    <?php 
                    $lead_prop_popup_url_3 = 'properties/leads_properties_popup_list/3';
                    $lead_prop_popup_url_3 = site_url($lead_prop_popup_url_3);    ?> 
                    <a style="display:inline; float:right; padding:0px; margin:8px 4px 8px 8px;" class="simple-ajax-modal" href="<?php echo $lead_prop_popup_url_3; ?>" id="propery_link_txt_3"> <i class="fa fa-plus"> </i> </a>   
                               
            </div>
            
        <div id="collapseSuccess3" class="accordion-body collapse" aria-expanded="false">
            <div class="panel-body" id="property_detail_3">          
        <?php 
            if($sel_property_id_3 >0) { ?>
                <strong>Property Title: </strong> <?php echo $pp_title_3; ?>  <br> 
                <strong>Property Ref #: </strong> <?php echo $pp_ref_no_3; ?> <br> 
                <strong>Price: </strong> <?php echo $pp_price_3; ?> <br> 
                <strong>Property Type: </strong>  <?php echo $pp_type_3; ?> <br> 
                <strong>Category: </strong>  <?php echo $pp_cate_name_3; ?> <br>   
           <?php }else{
                    echo "<strong>Select Property!</strong>";
                 } ?>   
                
                </div>
            </div>
        </div> 
    </div>
    </div> 
    </div>
    </div>   
                   
     <div class="col-md-12"> 
    <div class="form-group">
<?php
    $sel_property_id_4 = ''; 
    $pp_ref_no_4  = ''; 
    $pp_ref_no_title_4 = 'Select Property...'; 
    $pp_title_4 = ''; 
    $pp_price_4 = ''; 
    $pp_type_4 = '';  
    $pp_cate_name_4 = ''; 
     
    if(isset($_POST['property_id_4']) && $_POST['property_id_4']>0){
        $sel_property_id_4 = $_POST['property_id_4'];
    }else if(isset($record) && $record->property_id_4 >0) { 
        $sel_property_id_4 = $record->property_id_4;  
    }
            
    if($sel_property_id_4 >0) {  
        $prop_data_arr1 = $this->general_model->get_gen_lead_property_info_by_id($sel_property_id_4); 
        $pp_ref_no_title_4 = stripslashes($prop_data_arr1->ref_no);
        $pp_ref_no_4  = stripslashes($prop_data_arr1->ref_no);
        $pp_title_4 = stripslashes($prop_data_arr1->title);
        $pp_price_4 = $prop_data_arr1->price;  
        $pp_price_4 = 'AED '.number_format($pp_price_4,2,".",","); 
        $pp_type_4 = ($prop_data_arr1->property_type==1) ? 'Sale' : 'Rent';;  
         
        $cates_arr3 = $this->admin_model->get_category_by_id($prop_data_arr1->category_id);
        if(isset($cates_arr3) && count($cates_arr3) >0){
            $pp_cate_name_4 = stripslashes($cates_arr3->name);
        }  
    }   ?>
        
        <input type="hidden" id="property_id_4" name="property_id_4" value="<?php echo $sel_property_id_4; ?>">
    
        <label class="col-md-3 control-label" for="property_id_4">Property 4 </label>
        <div class="col-md-8"> 
        <div class="panel-group" id="accordionSuccess">
            <div class="panel panel-accordion panel-accordion-default">
                <div class="panel-heading" style="height:35px; clear:both;">
                    
                <a class="accordion-toggle collapsed fa fa-caret-down" data-toggle="collapse" data-parent="#accordionSuccess" href="#collapseSuccess4" aria-expanded="false" id="property_title_4" style="display:inline; float:left; padding:0px; margin:10px;"> &nbsp; <?php echo $pp_ref_no_title_4; ?> </a> 
                
                 <a style=" <?php echo ($sel_property_id_4 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="javascript:operate_remove_property('4');" id="propery_remove_link_txt_4"> <i class="fa fa-minus"> </i> </a>         
                   <?php  
                    if($sel_property_id_4 >0){ 
                        $lead_prop_update_popup_url_4 = "properties/leads_properties_popup_update/{$sel_property_id_4}/4";
                        $lead_prop_update_popup_url_4 = site_url($lead_prop_update_popup_url_4);
                    }else{ 
                        $lead_prop_update_popup_url_4 = "properties/leads_properties_popup_update/";
                        $lead_prop_update_popup_url_4 = site_url($lead_prop_update_popup_url_4);
                    } ?> 
                    
                    <a style=" <?php echo ($sel_property_id_4 >0) ? 'display:inline;' : 'display:none;'; ?> float:right; padding:0px; margin:8px 4px 8px 8px;" href="<?php echo $lead_prop_update_popup_url_4; ?>" id="propery_pencil_link_txt_4" class="simple-ajax-modal"> <i class="fa fa-pencil"> </i> </a>  
                  
                <?php 
                $lead_prop_popup_url_4 = 'properties/leads_properties_popup_list/4';
                $lead_prop_popup_url_4 = site_url($lead_prop_popup_url_4);    ?> 
                <a style="display:inline; float:right; padding:0px; margin:8px 4px 8px 8px;" class="simple-ajax-modal" href="<?php echo $lead_prop_popup_url_4; ?>" id="propery_link_txt_4"> <i class="fa fa-plus"> </i> </a>              
        </div>
        
    <div id="collapseSuccess4" class="accordion-body collapse" aria-expanded="false">
        <div class="panel-body" id="property_detail_4">          
    <?php 
        if($sel_property_id_4 >0) { ?>
            <strong>Property Title: </strong> <?php echo $pp_title_4; ?>  <br> 
            <strong>Property Ref #: </strong> <?php echo $pp_ref_no_4; ?> <br> 
            <strong>Price: </strong> <?php echo $pp_price_4; ?> <br> 
            <strong>Property Type: </strong>  <?php echo $pp_type_4; ?> <br> 
            <strong>Category: </strong>  <?php echo $pp_cate_name_4; ?> <br>   
       <?php }else{
                echo "<strong>Select Property!</strong>";
             } ?>   
            
            </div>
        </div>
    </div> 
</div>
</div> 
</div>
</div>                
                	  
                  
      <div class="form-group">
          <label class="col-md-3 control-label" for="reminds">Remind </label>
          <div class="col-md-8">
            <select name="reminds" id="reminds" data-plugin-selectTwo class="form-control populate" onChange="operate_remind_area(this.value);"> 
              <option value="0" <?php if((isset($_POST['reminds']) && $_POST['reminds']==0) || (isset($record) && $record->reminds==0)){ echo 'selected="selected"'; } ?>> Never </option>
              <option value="1" <?php if((isset($_POST['reminds']) && $_POST['reminds']==1) || (isset($record) && $record->reminds==1)){ echo 'selected="selected"'; } ?>> Yes </option>
            </select>
            <span class="text-danger"><?php echo form_error('reminds'); ?></span> </div>
        </div>
        
		<script>
            function operate_remind_area(valss){
                if(valss==1){ 
                    document.getElementById('remind_area').style.display='';
                }else{
                    document.getElementById('remind_area').style.display='none';
                } 
            } 
        </script> 
            <?php 
                if((isset($_POST['reminds']) && $_POST['reminds']==1) || (isset($record) && $record->reminds==1)){ 
                    $remd_style ='style="display: ;"';
                }else{
                    $remd_style ='style="display:none;"';
                } ?> 
                <span id="remind_area" <?php echo $remd_style; ?>> <br>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="remind_date">Date </label>
                       <div class="col-md-4">
                <?php 
					 $remind_date_1 = '';
                    if(isset($record) && $record->remind_date_1!='0000-00-00'){
                        $remind_date_1 = $record->remind_date_1;
                    }else if(isset($_POST['remind_date_1'])){
                            $remind_date_1 = $_POST['remind_date_1'];
                        } ?> 
                    <input name="remind_date_1" id="remind_date_1" placeholder="Adjust Reminder Date" type="text" class="form-control" value="<?php echo $remind_date_1; ?>" style="text-align:center;"> <span class="text-danger"><?php echo form_error('remind_date_1'); ?></span> </div>
                    
                      <div class="col-md-4"> 
                        <input class="form-control" placeholder="Adjust Reminder Time" id="remind_time_1" name="remind_time_1" data-plugin-timepicker value="<?php echo (isset($record) && $record->remind_time_1!='') ? $record->remind_time_1 : set_value('remind_time_1'); ?>" style="text-align:center;">
                        <span class="text-danger"><?php echo form_error('remind_time_1'); ?></span>
                        </div>
                         
                    </div>
               
                    <br>
                </span> 
                     
                
                <script>
					jQuery.noConflict()(function($){	 	  
						$(document).ready(function(){   
							$('#remind_date_1').datepicker({
								format: "yyyy-mm-dd"
								}).on('change', function(){
									$('.datepicker').hide();
									operate_leads_properties();
							});   
						});
					});
				</script>      	 
					   
				<div class="form-group">
                  <label class="col-md-3 control-label" for="notes">Notes </label>
                  <div class="col-md-8">
                    <textarea name="notes" id="notes" class="form-control" rows="6"><?php echo (isset($record)) ? stripslashes($record->notes): set_value('notes'); ?></textarea>
    
                    <span class="text-danger"><?php echo form_error('notes'); ?></span> </div>
                </div> 
                	  
				</div>
				 
				</div>
				 
              </div>
            </section> 
			  
		 <footer class="panel-footer center">   
			 <?php if(isset($record)){	?>
                <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>"> 
                <button type="submit" name="updates" id="operate_lead_submit_form" class="btn btn-primary btn-lg">Update</button>
                <?php }else{	?>
                <button type="submit" name="adds" id="operate_lead_submit_form" class="btn btn-primary btn-lg">Add</button>
 
                <button type="reset" class="btn btn-default btn-lg">Clear</button>
               
                <?php }	?> 
                <button type="button" class="btn btn-default btn-lg" onClick="window.location='<?php echo site_url('properties/leads_list'); ?>';">Cancel</button>
                 
                </footer> 
              </form>
              <!-- end: page -->
            </section>
          </div>
        </section>

<script type="text/javascript">  

	<?php 
	$get_contact_info_url = 'contacts/operate_contact_info/';
	$get_contact_info_url = site_url($get_contact_info_url);   ?>
	
	function operate_contact_info(sels_vals) { 
		jQuery.noConflict()(function($){
			$(document).ready(function(){ 
				$.ajax({
					url: '<?php echo $get_contact_info_url; ?>'+sels_vals,
					cache: false,
					type: 'POST', 
					data: { 'submits':1 },
					success: function (result,status,xhr) { 
						document.getElementById("fetch_contacts_info").innerHTML = result;  
					}
				});  
			});
		});
	}   
 		
	jQuery.noConflict()(function($){
		$(document).ready(function(){   
		<?php  
			$tmp_ownr_pth = '/properties/get_jsoned_contacts_list';
			$tmp_ownr_pth = site_url($tmp_ownr_pth);
			$tmp_sel_contact_id = 0;
			if(isset($_POST['contact_id']) && $_POST['contact_id']>0){  
				$tmp_sel_contact_id = $_POST['contact_id']; 
			}else if(isset($record) && $record->contact_id>0){
				$tmp_sel_contact_id = $record->contact_id; 
			} 
			
			$tmp_owr_pth = '/properties/get_jsoned_contact_by_id/'.$tmp_sel_contact_id;
			$tmp_owr_pth = site_url($tmp_owr_pth);	?> 
			 
			$("#contact_id").select2({
				placeholder: "Search for a Contact", 
				ajax: {  
					url: "<?php echo $tmp_ownr_pth; ?>",
					dataType: 'json',
					quietMillis: 250,
					data: function (term, page) {
						return {
							q: term,  
							page: page  
						};
					},
					results: function (data, page) {   
						var more = (page * 30) < data.total_count; 
						var myResults = [];
						$.each(data, function (index, item) {
							myResults.push({
								'id': item.id,
								'text': item.name+' ( '+item.phone_no+' - '+item.email+' )'
							});
						});
						return {
							results: myResults, more: more 
						}; 
					},
					cache: false
				}, 
				initSelection: function (element, callback) {
					$.get('<?php echo $tmp_owr_pth; ?>', function(data) { 
						var txt1 = data[0].id; 
						var lbl_txt = data[0].name.trim(); 	
						if(lbl_txt=="Select Contact"){
							var txt2 = data[0].name; 
						}else{
						 var txt2 = data[0].name+' ( '+data[0].phone_no+' - '+data[0].email+' )'; 
						}
						
						callback({id: txt1, text: txt2 });
						document.getElementById("contact_id").value = txt1;
					});	 
				},
				//formatResult: repoFormatResult,  
				//formatSelection: repoFormatSelection,   
				dropdownCssClass: "bigdrop",  
				escapeMarkup: function (m) { return m; } 
			});  
		 });
	});

	function clickeds2(sels_vals) {  
		jQuery.noConflict()(function($){
			$(document).ready(function(){   
			<?php 
				$tmp_ownr_pth1 = '/properties/get_jsoned_contacts_list';
				$tmp_ownr_pth1 = site_url($tmp_ownr_pth1);	
				  
				$tmp_owr_pth1 = '/properties/get_jsoned_contact_by_id/';
				$tmp_owr_pth1 = site_url($tmp_owr_pth1);	?> 
			 
				$("#contact_id").select2({
					placeholder: "Search for a Contact", 
					ajax: {
						url: "<?php echo $tmp_ownr_pth1; ?>",
						dataType: 'json',
						quietMillis: 250,
						data: function (term, page) {
							return {
								q: term,
								page: page
							};
						},
						results: function (data, page) { 
							var more = (page * 30) < data.total_count; 
							var myResults = [];
							$.each(data, function (index, item) {
								
								myResults.push({
									'id': item.id,
									'text': item.name+' ( '+item.phone_no+' - '+item.email+' )'
								});
								
							});
							return {
								results: myResults, more: more 
							};
						},
						cache: false
					}, 
					initSelection: function (element, callback) {
						$.get('<?php echo $tmp_owr_pth1; ?>'+sels_vals, function(data) { 
							var txt1 = data[0].id;
							
					var lbl_txt = data[0].name.trim(); 	
					if(lbl_txt=="Select Contact"){
						var txt2 = data[0].name; 
					}else{
						var txt2 = data[0].name+' ( '+data[0].phone_no+' - '+data[0].email+' )'; 
					}
							
					callback({id: txt1, text: txt2 });
					document.getElementById("contact_id").value = txt1;
					operate_contact_info(txt1);
				});	 
			},
				//formatResult: repoFormatResult,
				//formatSelection: repoFormatSelection, 
				//dropdownCssClass: "bigdrop",
				//escapeMarkup: function (m) { return m; }
			}); 	 
				
		});
	});
}     
	
	
	<?php 
	$get_property_info_url = 'properties/get_lead_property_popup_detail/';
	$get_property_info_url = site_url($get_property_info_url);   ?>  
     
	function dyns_properties(sels_vals,paras1_val) {  
		jQuery.noConflict()(function($){
			$(document).ready(function(){     
							   
				 $.ajax({
					url: '<?php echo $get_property_info_url; ?>'+sels_vals,
					cache: false,
					type: 'POST', 
					data: { 'submits':1 },
					success: function (result,status,xhr) { 
						var db_property_id = result[0]['id'];
						var property_ref_no = result[0]['ref_no'];
						var property_title = result[0]['title'];
						var property_type = result[0]['property_type'];
						var property_price = result[0]['price'];
						var property_cate_name = result[0]['cate_name'];  
						
						var sel_property_id = "property_id_"+paras1_val;
						document.getElementById(sel_property_id).value = db_property_id;
						 
						var ret_txts = "<strong> Property Title: </strong>"+property_title+" <br>";
						ret_txts += "<strong> Property Ref #: </strong>"+property_ref_no+" <br>";
						ret_txts += "<strong> Price: </strong>"+property_price+" <br>";
						ret_txts += "<strong> Property Type: </strong>"+property_type+" <br>";
						ret_txts += "<strong> Category: </strong>"+property_cate_name+" <br>";
						
						var property_title_id = "property_title_"+paras1_val;
						var property_detail_id = "property_detail_"+paras1_val;
						var propery_link_txt_id = "propery_link_txt_"+paras1_val;
						var propery_remove_link_txt = "propery_remove_link_txt_"+paras1_val;
						var propery_pencil_link_txt = "propery_pencil_link_txt_"+paras1_val;		
						  
						document.getElementById(property_detail_id).innerHTML = ret_txts;  
				
						document.getElementById(property_title_id).innerHTML = " &nbsp; "+property_ref_no; 
						
						
						
						
					  document.getElementById(propery_pencil_link_txt).style.display = "inline";
						
				       document.getElementById(propery_remove_link_txt).style.display = "inline"; 
						
   <?php  
		$lead_prop_update_popup_url_1 = "properties/leads_properties_popup_update/";
		$lead_prop_update_popup_url_1 = site_url($lead_prop_update_popup_url_1);
		 ?>   
		 
		var linkid = '#'+propery_pencil_link_txt; 					
		var new_lnk = "<?php echo $lead_prop_update_popup_url_1;?>"+db_property_id+'/'+paras1_val;	
		$(linkid).attr('href',new_lnk); 	
		  
	
	
	
						
						//location.href=base_url+"main";
						
						
						
						// 
							 
						/*var property_title_nos = property_title.length; 
						if(property_title_nos >30){
							var frmt_property_title = property_title.substring(0,30);
							
							document.getElementById(property_title_id).innerHTML = " &nbsp; "+frmt_property_title+'...';
						}else{
							document.getElementById(property_title_id).innerHTML = " &nbsp; "+property_title;
						}*/	
						 
						  
					}
				});  
			});
		});
	}    
	
	function operate_remove_property(paras1_val) {
		var conf_txt = confirm('Do you want to remove this?');
		 
		var sel_property_id = "property_id_"+paras1_val;
		var property_title_id = "property_title_"+paras1_val;
		var property_detail_id = "property_detail_"+paras1_val; 
		var propery_remove_link_txt = "propery_remove_link_txt_"+paras1_val;
		var propery_pencil_link_txt = "propery_pencil_link_txt_"+paras1_val;
		
		if(conf_txt == true){ 
			document.getElementById(sel_property_id).value = '';
							
			document.getElementById(property_detail_id).innerHTML = '<strong>Select Property!</strong>';  
					
			document.getElementById(property_title_id).innerHTML = " &nbsp; Select Property..."; 
			
			document.getElementById(propery_remove_link_txt).style.display = "none";
			
			document.getElementById(propery_pencil_link_txt).style.display = "none";
		}
	}
	
	 
	  
	function operate_property_brief_popup(paras1_val,paras2_val) {  
		jQuery.noConflict()(function($){
			$(document).ready(function(){ 
		
			var to_targets = "fetch_lead_property_brief_"+paras2_val; 
			if(paras1_val >0){
				var tmps_urls = paras1_val+'/'+paras2_val; 
				<?php    	
					$get_lead_property_briefs = 'properties/get_lead_property_brief/';
					$get_lead_property_briefs = site_url($get_lead_property_briefs);  ?> 
						 
					var tmps_urls = '<a class="simple-ajax-modal" href="<?php echo $get_lead_property_briefs; ?>'+tmps_urls+'"><i class="fa fa-search-plus"></i> Show Detail</a>';
					
					document.getElementById(to_targets).innerHTML = tmps_urls;  
					$('.simple-ajax-modal').magnificPopup({
						type: 'ajax',
						modal: true
					});
					 
			}else{
				
				document.getElementById(to_targets).innerHTML = '';;
			}	
			
			});
		});	 
}         
	</script>

<?php //$this->load->view('widgets/footer'); ?>
<!-- Vendor -->  
<script src="<?= asset_url();?>vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= asset_url();?>vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?= asset_url();?>vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="<?= asset_url();?>vendor/magnific-popup/magnific-popup.js"></script>
<!-- Specific Page Vendor -->
<script src="<?= asset_url();?>vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?= asset_url();?>vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="<?= asset_url();?>vendor/jquery-appear/jquery.appear.js"></script>
 
<script src="<?= asset_url();?>vendor/bootstrap-markdown/js/markdown.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-markdown/js/to-markdown.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script src="<?= asset_url();?>vendor/summernote/summernote.js"></script> 

<script src="<?= asset_url();?>vendor/select2/select2.js"></script>
<script src="<?= asset_url();?>vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
 
<!-- Theme Base, Components and Settings -->
<!--<script src="<?= asset_url();?>vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="<?= asset_url();?>vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>-->

<script src="<?= asset_url();?>javascripts/theme.js"></script>
<!-- Theme Custom -->
<script src="<?= asset_url();?>javascripts/theme.custom.js"></script>
<!-- Theme Initialization Files -->
<script src="<?= asset_url();?>javascripts/theme.init.js"></script>
<script src="<?= asset_url();?>javascripts/forms/examples.advanced.form.js"></script>
<!-- Examples -->
<!--<script src="<?= asset_url();?>javascripts/dashboard/examples.dashboard.js"></script>-->
<!--<script src="<?= asset_url();?>javascripts/tables/examples.datatables.default.js"></script> -->
<script src="<?= asset_url();?>javascripts/ui-elements/examples.modals.js"></script>
<?php 
	if(strlen($remind_date_1)>0){
		/* ok */
	}else{ ?> 
	<script> 
    jQuery.noConflict()(function($){
        $(document).ready(function(){ 
            document.getElementById("remind_date_1").value ='';
            document.getElementById("remind_time_1").value ='';
        });	
    });
    </script>
<?php 
	}   
	if(strlen($enquiry_date)>0){
		/* ok */
	}else{ ?>   
	<script> 
    /*jQuery.noConflict()(function($){
        $(document).ready(function(){ 
            document.getElementById("enquiry_date").value ='';
            document.getElementById("enquiry_time").value ='';
        });	
    });*/
    </script>
<?php } ?> 
</body>
</html> 