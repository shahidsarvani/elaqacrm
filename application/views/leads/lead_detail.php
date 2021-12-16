<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	$this->load->view('widgets/meta_tags');
	//$chk_add_contact_permission =  $this->general_model->check_controller_method_permission_access('Contacts','add',$this->dbs_role_id,'1'); ?>  
</head>
<body class="pace-done sidebar-xs">
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
            <div class="alert alert-success no-border">
              <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
              <?php echo $this->session->flashdata('success_msg'); ?> </div>
            <?php } 
        if($this->session->flashdata('error_msg')){ ?>
            <div class="alert alert-danger no-border">
              <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
              <?php echo $this->session->flashdata('error_msg'); ?> </div>
            <?php } ?>
            <!-- Horizontal form -->
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h5 class="panel-title"> <?= $page_headings; ?> Form </h5>
              </div>
              <div class="panel-body">  
                <form name="datas_form" id="datas_form" method="post" action="" class="form-horizontal form-bordered">
                     
					  <div class="row show-grid">
						<div class="col-md-6"> 
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Ref No: </strong> <?php echo $record->ref_no; ?>  
							</div>
						  </div>
						   <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Contact : </strong> <?php $arr1 = $this->general_model->get_gen_contact_info_by_id($record->contact_id);
							if(isset($arr1)){
								echo stripslashes($arr1->name);
							} ?> 
							</div>
						  </div>
						  <hr class="cstms-dash">
						  <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Assigned To : </strong> <?php $arr2 = $this->general_model->get_user_info_by_id($record->agent_id);
							if(isset($arr2)){
								echo stripslashes($arr2->name);
							}  ?> 
							</div>
						  </div>
						  
						  <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Enquiry Date : </strong> <?php echo date('d-M-Y',strtotime($record->enquiry_date)).' '.$record->enquiry_time; ?>   
							</div>
						  </div> 
						  <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Lead Type : </strong> <?php echo $record->lead_type; ?>   
							</div>
						  </div>
						  <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Status : </strong> <?php echo $record->lead_status; ?>   
							</div>
						  </div>  
							
						</div>
						
						<div class="col-md-6">   
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Priority : </strong> <?php echo $record->priority; ?>   
							</div>
						  </div>
						   
						   <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Source : </strong> 
					<?php 
						if(isset($record->source_of_listing) && $record->source_of_listing>0){
							$src_arr = $this->admin_model->get_source_of_listing_by_id($record->source_of_listing);
							if(isset($src_arr)){
								echo $src_arr->title;
							}
						} ?>   
							</div>
					  </div>
						  
						  <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Reminder : </strong> <?php echo date('d-M-Y',strtotime($record->remind_date_1)).' '.$record->remind_time_1; ?>    
							</div>
						  </div>
						  
						  <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Notes : </strong> <?php echo stripslashes($record->notes); ?>   
							</div>
						  </div>
						  
						   <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Views : </strong> <?php echo $record->no_of_views; ?>   
							</div>
						  </div>
						  
						   <hr class="cstms-dash">
						   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Created By : </strong> 
								<?php 
									$arr3 = $this->general_model->get_user_info_by_id($record->created_by);
									if(isset($arr3)){
										echo stripslashes($arr3->name);
									}  ?> 
								</div> 
							  </div> 
							  
						   <hr class="cstms-dash">
						   <div class="row show-grid">
							<div class="col-md-12 mb-md mt-md">
							<strong class="text-semibold "> Created On : </strong> <?php echo date('d-M-Y H:i:s',strtotime($record->created_on)); ?>   
							</div>
							</div>
						</div>
					  </div>  
					<?php 
					if(isset($record->property_id_1) && $record->property_id_1>0){
						$prop_arr1 = $this->properties_model->get_property_by_id($record->property_id_1);
						if(isset($prop_arr1)){  ?>
						  <hr class="cstms"> 
						  <div class="row show-grid">
							  <div class="col-md-12">   
								   <h3> Property 1 </h3> 
							  </div>
						  </div>
						  <div class="row show-grid">
							<div class="col-md-6">  
							   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Category : </strong>  
								<?php
								if(isset($prop_arr1) && $prop_arr1->category_id >0){ 
									$cates_arr = $this->categories_model->get_category_by_id($prop_arr1->category_id);
									if(isset($cates_arr)){
										echo stripslashes($cates_arr->name);
									} 
								}  ?> 
								</div>
							  </div>
							  <hr class="cstms-dash">
							  <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> No. of Bedrooms : </strong> 
								 <?php
									if(isset($prop_arr1) && $prop_arr1->no_of_beds_id >0){ 
										$beds_arr = $this->no_of_bedrooms_model->get_no_of_beds_by_id($prop_arr1->no_of_beds_id);
										if(isset($beds_arr)){
											echo stripslashes($beds_arr->title);
										} 
									}  ?> 
								</div>
							  </div>
							  <hr class="cstms-dash">
							   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Emirate(s) : </strong> 
					<?php 
						if($prop_arr1->emirate_id >0){
							$emrt_arr =  $this->admin_model->get_emirate_by_id($prop_arr1->emirate_id);
							echo stripslashes($emrt_arr->name);
						} ?>  
								</div>  
								
							  </div>
							  <hr class="cstms-dash">
							   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Location(s) : </strong> 
								<?php
									if($prop_arr1->location_id >0){
										$locts_arr =  $this->admin_model->get_emirate_location_by_id($prop_arr1->location_id);
										echo stripslashes($locts_arr->name);
									} ?>    
								</div>
							  </div>  
							  
							</div>
							
							<div class="col-md-6">  
								
							   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Sub Location(s) : </strong> 
								<?php  
									if($prop_arr1->sub_location_id >0){
										$sublocts_arr =  $this->admin_model->get_emirate_sub_location_by_id($prop_arr1->sub_location_id);
										echo stripslashes($sublocts_arr->name);
									} ?>
								  
								</div>
							  </div> 
							   <hr class="cstms-dash">
							   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Property Type : </strong> <?php echo ($prop_arr1->property_type==2) ? 'Rent' : 'Sale'; ?> 
								</div>
							  </div> 
								
							   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Size : </strong> <?php echo $prop_arr1->plot_area; ?> 
								</div>
							  </div> 
							  
							   <hr class="cstms-dash">
							   <div class="row show-grid">
								<div class="col-md-12 mb-md mt-md">
								<strong class="text-semibold "> Price : </strong> 
								<?php echo (isset($prop_arr1) && $prop_arr1->price!='') ? CRM_CURRENCY.' '.number_format($prop_arr1->price,0,".",",") :''; ?>
								</div>
							  </div>
							   
							</div>
						  </div> 
					  <?php 
						} 
					  } ?> 
					   
					<?php 
					 if(isset($record->property_id_2) && $record->property_id_2>0){
				$prop_arr2 = $this->properties_model->get_property_by_id($record->property_id_2);
				if(isset($prop_arr2)){  ?>
				  <hr class="cstms"> 
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <h3> Property 2 </h3> 
					  </div>
				  </div>
				  <div class="row show-grid">
					<div class="col-md-6">  
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Category : </strong>  
						<?php
						if(isset($prop_arr2) && $prop_arr2->category_id >0){ 
							$cates_arr = $this->admin_model->get_category_by_id($prop_arr2->category_id);
							if(isset($cates_arr)){
								echo stripslashes($cates_arr->name);
							} 
						}  ?> 
						</div>
					  </div>
					  <hr class="cstms-dash">
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> No. of Bedrooms : </strong> 
						 <?php
							if(isset($prop_arr2) && $prop_arr2->no_of_beds_id >0){ 
								$beds_arr = $this->no_of_bedrooms_model->get_no_of_beds_by_id($prop_arr2->no_of_beds_id);
								if(isset($beds_arr)){
									echo stripslashes($beds_arr->title);
								} 
							}  ?> 
						</div>
					  </div>
					  <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Emirate(s) : </strong> 
			<?php 
				if($prop_arr2->emirate_id >0){
					$emrt_arr =  $this->admin_model->get_emirate_by_id($prop_arr2->emirate_id);
					echo stripslashes($emrt_arr->name);
				} ?>  
						</div>  
						
					  </div>
					  <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Location(s) : </strong> 
						<?php
							if($prop_arr2->location_id >0){
								$locts_arr =  $this->admin_model->get_emirate_location_by_id($prop_arr2->location_id);
								echo stripslashes($locts_arr->name);
							} ?>    
						</div>
					  </div> 
					   
					  
					</div>
					
					<div class="col-md-6">  
						<div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Sub Location(s) : </strong> 
						<?php  
							if($prop_arr2->sub_location_id >0){
								$sublocts_arr =  $this->admin_model->get_emirate_sub_location_by_id($prop_arr2->sub_location_id);
								echo stripslashes($sublocts_arr->name);
							} ?>
						  
						</div>
					  </div>
					  
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Property Type : </strong> <?php echo ($prop_arr2->property_type==2) ? 'Rent' : 'Sale'; ?> 
						</div>
					  </div> 
					   <hr class="cstms-dash">	
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Size : </strong> <?php echo $prop_arr2->plot_area; ?> 
						</div>
					  </div> 
					  
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Price : </strong> 
						<?php echo (isset($prop_arr2) && $prop_arr2->price!='') ? CRM_CURRENCY.' '.number_format($prop_arr2->price,0,".",",") :''; ?>
						</div>
					  </div>
					   
					</div>
				  </div> 
			  <?php 
				} 
			  } ?>      		
					<?php 
					 if(isset($record->property_id_3) && $record->property_id_3>0){
				$prop_arr3 = $this->properties_model->get_property_by_id($record->property_id_3);
				if(isset($prop_arr3)){  ?>
				  <hr class="cstms"> 
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <h3> Property 3 </h3> 
					  </div>
				  </div>
				  <div class="row show-grid">
					<div class="col-md-6">  
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Category : </strong>  
						<?php
						if(isset($prop_arr3) && $prop_arr3->category_id >0){ 
							$cates_arr = $this->categories_model->get_category_by_id($prop_arr3->category_id);
							if(isset($cates_arr)){
								echo stripslashes($cates_arr->name);
							} 
						}  ?> 
						</div>
					  </div>
					  <hr class="cstms-dash">
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> No. of Bedrooms : </strong> 
						 <?php 
							if(isset($prop_arr3) && $prop_arr3->no_of_beds_id >0){ 
								$beds_arr = $this->no_of_bedrooms_model->get_no_of_beds_by_id($prop_arr3->no_of_beds_id);
								if(isset($beds_arr)){
									echo stripslashes($beds_arr->title);
								} 
							}  ?> 
						</div>
					  </div>
					  <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Emirate(s) : </strong> 
			<?php 
				if($prop_arr3->emirate_id >0){
					$emrt_arr =  $this->admin_model->get_emirate_by_id($prop_arr3->emirate_id);
					echo stripslashes($emrt_arr->name);
				} ?>  
						</div>  
						
					  </div>
					  <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Location(s) : </strong> 
						<?php
							if($prop_arr3->location_id >0){
								$locts_arr =  $this->admin_model->get_emirate_location_by_id($prop_arr3->location_id);
								echo stripslashes($locts_arr->name);
							} ?>    
						</div>
					  </div>   
					  
					</div>
					
					<div class="col-md-6">  
						<div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Sub Location(s) : </strong> 
						<?php  
							if($prop_arr3->sub_location_id >0){
								$sublocts_arr =  $this->admin_model->get_emirate_sub_location_by_id($prop_arr3->sub_location_id);
								echo stripslashes($sublocts_arr->name);
							} ?>
						  
						</div>
					  </div>
					  
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Property Type : </strong>  <?php echo ($prop_arr3->property_type==2) ? 'Rent' : 'Sale'; ?>  
						</div>
					  </div> 
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Size : </strong> <?php echo $prop_arr3->plot_area; ?> 
						</div>
					  </div> 
					  
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Price : </strong> 
						<?php echo (isset($prop_arr3) && $prop_arr3->price!='') ? CRM_CURRENCY.' '.number_format($prop_arr3->price,0,".",",") :''; ?>
						</div>
					  </div>
					   
					</div>
				  </div> 
			  <?php 
				} 
			  } ?> 
					
					 <?php 
					 if(isset($record->property_id_4) && $record->property_id_4>0){
				$prop_arr4 = $this->properties_model->get_property_by_id($record->property_id_4);
				if(isset($prop_arr4)){  ?>
				  <hr class="cstms"> 
				  <div class="row show-grid">
					  <div class="col-md-12">   
						   <h3> Property 4 </h3> 
					  </div>
				  </div>
				  <div class="row show-grid">
					<div class="col-md-6">  
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Category : </strong>  
						<?php
						if(isset($prop_arr4) && $prop_arr4->category_id >0){ 
							$cates_arr = $this->categories_model->get_category_by_id($prop_arr4->category_id);
							if(isset($cates_arr)){
								echo stripslashes($cates_arr->name);
							} 
						}  ?> 
						</div>
					  </div>
					  <hr class="cstms-dash">
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> No. of Bedrooms : </strong> 
						 <?php
							if(isset($prop_arr4) && $prop_arr4->no_of_beds_id >0){ 
								$beds_arr = $this->no_of_bedrooms_model->get_no_of_beds_by_id($prop_arr4->no_of_beds_id);
								if(isset($beds_arr)){
									echo stripslashes($beds_arr->title);
								} 
							}  ?> 
						</div>
					  </div>
					  <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Emirate(s) : </strong> 
			<?php 
				if($prop_arr4->emirate_id >0){
					$emrt_arr =  $this->admin_model->get_emirate_by_id($prop_arr4->emirate_id);
					echo stripslashes($emrt_arr->name);
				} ?>  
						</div>  
						
					  </div>
					  <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Location(s) : </strong> 
						<?php
							if($prop_arr4->location_id >0){
								$locts_arr =  $this->admin_model->get_emirate_location_by_id($prop_arr4->location_id);
								echo stripslashes($locts_arr->name);
							} ?>    
						</div>
					  </div>   
					  
					</div>
					
					<div class="col-md-6">  
						
					  <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Sub Location(s) : </strong> 
						<?php  
							if($prop_arr4->sub_location_id >0){
								$sublocts_arr =  $this->admin_model->get_emirate_sub_location_by_id($prop_arr4->sub_location_id);
								echo stripslashes($sublocts_arr->name);
							} ?>
						  
						</div>
					  </div>
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Property Type : </strong> <?php echo ($prop_arr4->property_type==2) ? 'Rent' : 'Sale'; ?> 
						</div>
					  </div> 
					   
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Size : </strong> <?php echo $prop_arr4->plot_area; ?> 
						</div>
					  </div>
					   
					   <hr class="cstms-dash">
					   <div class="row show-grid">
						<div class="col-md-12 mb-md mt-md">
						<strong class="text-semibold "> Price : </strong> 
						<?php echo (isset($prop_arr4) && $prop_arr4->price!='') ? CRM_CURRENCY.' '.number_format($prop_arr4->price,0,".",",") :''; ?>
						</div>
					  </div>
					   
					</div>
				  </div> 
			  <?php 
				} 
			  } ?> 
					   <br>
					   <a href="javascript:history.back()"> &laquo; Go Back </a>
					 
					   
                   
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
