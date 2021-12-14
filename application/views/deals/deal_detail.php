<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/meta_tags'); ?>
</head>
<body class="pace-running sidebar-xs">
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
        <div class="row">
          <div class="col-lg-12">
		  
		<?php if($this->session->flashdata('success_msg')){ ?>
			 <div class="alert alert-success no-border"> <button data-dismiss="alert" class="close" type="button"><span>�</span><span class="sr-only">Close</span></button> <?php echo $this->session->flashdata('success_msg'); ?> </div>
		<?php } 
		if($this->session->flashdata('error_msg')){ ?>
			<div class="alert alert-danger no-border"> <button data-dismiss="alert" class="close" type="button"><span>�</span><span class="sr-only">Close</span></button> <?php echo $this->session->flashdata('error_msg'); ?> </div>
		<?php } ?>
		
		<!-- Horizontal form -->
		<div class="panel panel-flat">
		  <div class="panel-heading">
			<h5 class="panel-title"> <?= $page_headings; ?> Form </h5>
		  </div>
		  <div class="panel-body"> 
  		<?php 
			if(isset($args1) && $args1>0){
				$form_act = "deals/operate_deal/{$args0}/".$args1;
			}else if(isset($args0) && $args0>0){
				$form_act = "deals/operate_deal/{$args0}";
			}else{
				$form_act = "deals/operate_deal";
			} ?>
			  <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal form-bordered" enctype="multipart/form-data"> 
				<!--<div class="row">
					<div class="col-lg-12 col-md-12">   
					</div>
				</div>-->  
			 
				  <div class="row show-grid">
					  <div class="col-md-6">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold ">  Ref No : </strong>
							 <?php echo (isset($record) && $record->ref_no!='') ? $record->ref_no :''; ?>
						  </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Type : </strong>
							<?php echo (isset($record) && $record->types==1) ? 'Sales' :'Rental'; ?>
						  </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> <?php echo (isset($record) && $record->types==2) ? 'Landlord' :'Seller'; ?> : </strong>  
						  <?php $temp_owner_sl_name = $temp_owner_sl_email =  $temp_owner_sl_phone_no = ''; ?>  
							<?php if(isset($record) && $record->owner_id >0){
								$db_docs_arr0 = $this->general_model->get_gen_owner_info_by_id($record->owner_id); 
								if(isset($db_docs_arr0) && count($db_docs_arr0)>0){
									$temp_owner_sl_name = $db_docs_arr0->name; 
									$temp_owner_sl_email = $db_docs_arr0->email;
									$temp_owner_sl_phone_no = $db_docs_arr0->phone_no;    
									if(strlen($temp_owner_sl_name)>0){ ?>
										<div class="text-info"> <i class="fa fa-user"> </i>  <?php echo $temp_owner_sl_name; ?> </div>
								 <?php } 
									if(strlen($temp_owner_sl_email)>0){ ?>
										 <div class="text-info"> <i class="fa fa-envelope-o"> </i>  <?php echo $temp_owner_sl_email; ?> </div>
								 <?php }  
									 if(strlen($temp_owner_sl_phone_no)>0){ ?>
										 <div class="text-info"> <i class="fa fa-phone"> </i>  <?php echo $temp_owner_sl_phone_no; ?> </div>
								 <?php } 
									}
								 } ?>  
						  </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> 
						  <?php echo (isset($record) && $record->types==2) ? 'Tenant' :'Buyer'; ?> : </strong> 
						  <div id="fetch_new_owners">   
						  <?php 
						if(isset($record) && $record->contact_id >0){
							$db_docs_arr0 = $this->general_model->get_gen_contact_info_by_id($record->contact_id); 
							if(isset($db_docs_arr0) && count($db_docs_arr0)>0){ 
								$temp_contact_sl_name = $db_docs_arr0->name;
								$temp_contact_sl_email = $db_docs_arr0->email;
								$temp_contact_sl_phone_no = $db_docs_arr0->phone_no;   
								 
								if(strlen($temp_contact_sl_name)>0){ ?>
									<div class="text-info"> <i class="fa fa-user"> </i>  <?php echo $temp_contact_sl_name; ?> </div>
							 <?php } 
								if(strlen($temp_contact_sl_email)>0){ ?>
									 <div class="text-info"> <i class="fa fa-envelope-o"> </i>  <?php echo $temp_contact_sl_email; ?> </div>
							 <?php }  
								 if(strlen($temp_contact_sl_phone_no)>0){ ?>
									 <div class="text-info"> <i class="fa fa-phone"> </i>  <?php echo $temp_contact_sl_phone_no; ?> </div>
							 <?php } 
								}
							 } ?>  
						 </div>
						  
						   </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Status : </strong> <?php echo (isset($record) && $record->status!='') ? $record->status :''; ?>  </div>
						</div>  
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Deal Price : </strong>
						   <?php echo (isset($record) && $record->deal_price!='') ? CRM_CURRENCY.' '.number_format($record->deal_price,0,".",",") :''; ?>    
						  </div>
						</div>
						<hr class="cstms-dash">  
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Deposit : </strong> <?php echo (isset($record) && $record->deposit!='') ? CRM_CURRENCY.' '.number_format($record->deposit,0,".",",") :''; ?>   
						  </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Commission : </strong> <?php echo (isset($record) && $record->commission!='') ? CRM_CURRENCY.' '.number_format($record->commission,0,".",",") :''; ?> </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Agent 1 : </strong>
							<?php 
								if(isset($record) && $record->agent1_id >0){ 
									$arrs1 = $this->general_model->get_user_info_by_id($record->agent1_id);
									if(isset($arrs1)){
										echo $arrs1->name;
									}
								}  ?>
						  </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Commission : </strong> <?php echo (isset($record)) ? stripslashes($record->agent1_commission_percentage): set_value('agent1_commission_percentage'); ?> % = <?php echo (isset($record)) ? stripslashes($record->agent1_commission_value): set_value('agent1_commission_value'); ?> </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Agent 2 : </strong>
							<?php 
								if(isset($record) && $record->agent2_id >0){ 
									$arrs1 = $this->general_model->get_user_info_by_id($record->agent2_id);
									if(isset($arrs1)){
										echo $arrs1->name;
									}
								}  ?>
						  </div>
						</div>
						<hr class="cstms-dash">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Commission : </strong> <?php echo (isset($record)) ? stripslashes($record->agent2_commission_percentage): set_value('agent2_commission_percentage'); ?> % = <?php echo (isset($record)) ? stripslashes($record->agent2_commission_value): set_value('agent2_commission_value'); ?> </div>
						</div> 
		
					  </div>
					  
					<div class="col-md-6"> 
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Estimated Date : </strong>
							<?php 
								if(isset($record) && $record->est_deal_date!='0000-00-00'){
									echo date('d-M-Y',strtotime($record->est_deal_date));
								} ?>
						  </div>
						</div>
						<hr class="cstms-dash">
						
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Actual Deal Date : </strong>
							<?php 
								if(isset($record) && $record->act_deal_date!='0000-00-00'){
									echo date('d-M-Y',strtotime($record->act_deal_date));
								} ?>
						  </div>
						</div>
						<hr class="cstms-dash">
						
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Unit No : </strong> <?php echo (isset($record) && $record->unit_no!='') ? $record->unit_no :''; ?> </div>
					  </div>
					  <hr class="cstms-dash">
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Category : </strong> <?php
				if(isset($record) && $record->category_id >0){ 
					$cates_arr = $this->categories_model->get_category_by_id($record->category_id);
					if(isset($cates_arr)){
						echo stripslashes($cates_arr->name);
					} 
				}  ?>
						 </div>
					  </div>
					  <hr class="cstms-dash">
					  
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> No. of Bedrooms : </strong> <?php
							if(isset($record) && $record->no_of_beds_id >0){ 
								$beds_arr = $this->no_of_bedrooms_model->get_no_of_beds_by_id($record->no_of_beds_id);
								if($beds_arr){
									echo stripslashes($beds_arr->title);
								} 
							}  ?>  
						   </div>
					  </div> 
					  <hr class="cstms-dash">
					  
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Emirate(s): </strong> <?php 
						if($record->emirate_id >0){
							$emrt_arr =  $this->emirates_model->get_emirate_by_id($record->emirate_id); 
							if($emrt_arr){
								echo stripslashes($emrt_arr->name);
							}
						} ?> </div>
					  </div>
					  <hr class="cstms-dash">
					  
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Location(s) : </strong> 
						 <?php 
							if($record->location_id >0){
								$locts_arr =  $this->emirates_location_model->get_emirate_location_by_id($record->location_id);
								if($locts_arr){
									echo stripslashes($locts_arr->name);	
								} 
							} ?> </div>
					  </div>
					  <hr class="cstms-dash">
					 
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold ">Sub Location(s) : </strong> <?php  
								if($record->sub_location_id >0){
									$sublocts_arr =  $this->emirates_sub_location_model->get_emirate_sub_location_by_id($record->sub_location_id); 
									
									if($sublocts_arr){
										echo stripslashes($sublocts_arr->name);	
									}
								} ?>  
						</div>
					  </div> 
					  <hr class="cstms-dash">
					  
					  <div class="row show-grid" <?php echo (isset($record) && $record->types=='Rental') ? '':'style="display:none;"' ?>>
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Tenancy Renewal Date : </strong>
						  <?php 
							if(isset($record) && $record->renewal_date!='0000-00-00'){
								echo date('d-M-Y',strtotime($record->renewal_date));
							} ?>
						</div>
					  </div>
					  <hr class="cstms-dash">
					  
					  <div class="row show-grid" <?php echo (isset($record) && $record->types=='Rental') ? '':'style="display:none;"' ?>>
						<div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> Set Reminder : </strong>
						  <?php if(isset($record)){ echo stripslashes($record->set_reminder); } ?>
						</div>
					  </div> 
	
					</div>
					</div>
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <strong> Other Detail </strong> 
					  </div>
				  </div> 
				  <hr class="cstms">  
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <strong> Notes </strong> 
					  </div>
				  </div> 
				 
				  <div class="row show-grid">
					  <div class="col-md-6">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md"> <strong class="text-semibold "> </strong>
							 <?php echo (isset($record) && $record->notes!='') ? $record->notes :''; ?>
						  </div>
						</div>
						</div>
					</div>
					
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">   
					  <strong> <?php echo (isset($record) && $record->types==2) ? 'Landlord' :'Seller'; ?> </strong> 
					  </div>
				  </div> 
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md">           
						 <?php 						 
							if(isset($documents_arr1s) && count($documents_arr1s) >0){
								foreach($documents_arr1s as $documents_arr1){
									$fl_ext = substr(strrchr($documents_arr1->name, '.'), 1);
									if($fl_ext=="doc" || $fl_ext=="docx" || $fl_ext=="xls" || $fl_ext=="xlsx" || $fl_ext=="ppt" || $fl_ext=="pptx" || $fl_ext=="pdf"){  ?>	 
										 <span class="img-thumbnail" style="vertical-align:bottom"> <a href="<?php echo base_url(); ?>downloads/property_sellerlandlord_documents/<?php echo $documents_arr1->name; ?>" class="image-popup-no-margins" target="_blank"><?php echo $documents_arr1->name; ?></a> </span>   
								<?php }else{ ?>    
										<span class="img-thumbnail"> <a href="<?php echo base_url(); ?>downloads/property_sellerlandlord_documents/<?php echo $documents_arr1->name; ?>" class="image-popup-no-margins" target="_blank"><img alt="<?php echo $documents_arr1->name; ?>" src="<?php echo base_url(); ?>downloads/property_sellerlandlord_documents/<?php echo $documents_arr1->name; ?>" class="" width="300px" height="300px"></a> </span>  
									 <?php 
									}  
								 } 
							 } ?>
						  </div>
						</div>
					  </div> 
					</div>
					
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">   
					  <strong> <?php echo (isset($record) && $record->types==2) ? 'Tenant' :'Buyer'; ?> </strong> 
					  </div>
				  </div> 
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md">           
						 <?php 						 
							if(isset($documents_arr2s) && count($documents_arr2s) >0){
								foreach($documents_arr2s as $documents_arr2){
									$fl_ext = substr(strrchr($documents_arr2->name, '.'), 1); 
									if($fl_ext=="doc" || $fl_ext=="docx" || $fl_ext=="xls" || $fl_ext=="xlsx" || $fl_ext=="ppt" || $fl_ext=="pptx" || $fl_ext=="pdf"){ ?>   
										   <span class="img-thumbnail" style="vertical-align:bottom">  <a href="<?php echo base_url(); ?>downloads/property_buyertenant_documents/<?php echo $documents_arr2->name; ?>" class="image-popup-no-margins" target="_blank"><?php echo $documents_arr2->name; ?></a> </span>  
										<?php }else{ ?>    
										<span class="img-thumbnail"> <a href="<?php echo base_url(); ?>downloads/property_buyertenant_documents/<?php echo $documents_arr2->name; ?>" class="image-popup-no-margins" target="_blank"><img alt="<?php echo $documents_arr2->name; ?>" src="<?php echo base_url(); ?>downloads/property_buyertenant_documents/<?php echo $documents_arr2->name; ?>" class="" width="300px" height="300px"></a> </span>    
									 <?php 
									}  
								 } 
							 }	?>   
						  </div>
						</div>
						</div> 
					</div> 
					
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <strong> Deals documents  </strong> 
					  </div>
				  </div> 
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md">
							<?php 						 
							if(isset($documents_arr3s) && count($documents_arr3s) >0){
								foreach($documents_arr3s as $documents_arr3){
									$fl_ext = substr(strrchr($documents_arr3->name, '.'), 1); 
									if($fl_ext=="doc" || $fl_ext=="docx" || $fl_ext=="xls" || $fl_ext=="xlsx" || $fl_ext=="ppt" || $fl_ext=="pptx" || $fl_ext=="pdf"){ ?>   
										<span class="img-thumbnail" style="vertical-align:bottom"> <a href="<?php echo base_url(); ?>downloads/property_deal_documents/<?php echo $documents_arr3->name; ?>" class="image-popup-no-margins" target="_blank"><?php echo $documents_arr3->name; ?></a> </span>   
								<?php }else{ ?>    
										<span class="img-thumbnail"> <a href="<?php echo base_url(); ?>downloads/property_deal_documents/<?php echo $documents_arr3->name; ?>" class="image-popup-no-margins" target="_blank"><img alt="<?php echo $documents_arr3->name; ?>" src="<?php echo base_url(); ?>downloads/property_deal_documents/<?php echo $documents_arr3->name; ?>" class="" width="300px" height="300px"></a> </span> 
										 
									 <?php 
									}  
								 } 
							 }	?>  
						  </div>
						</div>
						</div> 
					</div>  
					 
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <strong> New Title Deed </strong> 
					  </div>
				  </div> 
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md">
						  <?php 						 
							if(isset($documents_arr4s) && count($documents_arr4s) >0){
								foreach($documents_arr4s as $documents_arr4){
									$fl_ext = substr(strrchr($documents_arr4->name, '.'), 1); 
									if($fl_ext=="doc" || $fl_ext=="docx" || $fl_ext=="xls" || $fl_ext=="xlsx" || $fl_ext=="ppt" || $fl_ext=="pptx" || $fl_ext=="pdf"){ ?> 
										<span class="img-thumbnail" style="vertical-align:bottom"> <a href="<?php echo base_url(); ?>downloads/property_newtitledeed_documents/<?php echo $documents_arr4->name; ?>" class="image-popup-no-margins" target="_blank"><?php echo $documents_arr4->name; ?></a> </span>
									<?php }else{ ?>
										 <span class="img-thumbnail"> <a href="<?php echo base_url(); ?>downloads/property_newtitledeed_documents/<?php echo $documents_arr4->name; ?>" class="image-popup-no-margins" target="_blank"><img alt="<?php echo $documents_arr4->name; ?>" src="<?php echo base_url(); ?>downloads/property_newtitledeed_documents/<?php echo $documents_arr4->name; ?>" class="" width="300px" height="300px"></a> </span>   					 <?php 
									}  
								 } 
							 }	?>  
						  </div>
						</div>
						</div> 
					</div>
				   
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <strong> Agency documents </strong> 
					  </div>
				  </div> 
				  <hr class="cstms">
				  <div class="row show-grid">
					  <div class="col-md-12">
						<div class="row show-grid">
						  <div class="col-md-12 mb-md mt-md">
						  <?php 						 
							if(isset($documents_arr5s) && count($documents_arr5s) >0){
								foreach($documents_arr5s as $documents_arr5){
									$fl_ext = substr(strrchr($documents_arr5->name, '.'), 1); 
									if($fl_ext=="doc" || $fl_ext=="docx" || $fl_ext=="xls" || $fl_ext=="xlsx" || $fl_ext=="ppt" || $fl_ext=="pptx" || $fl_ext=="pdf"){ ?>   	 
										 <span class="img-thumbnail" style="vertical-align:bottom"><a href="<?php echo base_url(); ?>downloads/property_agency_documents/<?php echo $documents_arr5->name; ?>" class="image-popup-no-margins" target="_blank"><?php echo $documents_arr5->name; ?></a> </span>  
									<?php }else{ ?>
									 	<span class="img-thumbnail"> <a href="<?php echo base_url(); ?>downloads/property_agency_documents/<?php echo $documents_arr5->name; ?>" class="image-popup-no-margins" target="_blank"><img alt="<?php echo $documents_arr5->name; ?>" src="<?php echo base_url(); ?>downloads/property_agency_documents/<?php echo $documents_arr5->name; ?>" class="" width="300px" height="300px"></a> </span>   						<?php 
									}  
								 } 
							 }	?> 
						  </div>
						</div>
					  </div>
					 <br> <br> &nbsp; &nbsp; <a href="javascript:history.back();">&laquo; Go Back</a>
				  </div>  
			  </form>
			  
			  </div>
            </div>
            <!-- /horizotal form -->
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