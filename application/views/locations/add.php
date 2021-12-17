<!DOCTYPE html>
<html lang="en">
<head>
<?php  
$this->load->view('widgets/meta_tags'); ?>
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
                <?php $form_act = "locations/add"; ?>
                <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
				  <div class="form-group">
                    <label class="col-md-2 control-label" for="parent_id">Parent Location(s)<span class="reds">*</span></label>
                    <div class="col-md-6">
                      <select name="parent_id" id="parent_id" class="form-control select2" data-error="#parent_id1">
                        <option value="0">Select Parent Location </option>
 
				<?php 		 
					if(isset($locations_arrs)){
						foreach($locations_arrs as $record1){ 
							
							$sel_1 = (isset($_POST['parent_id']) && $_POST['parent_id']==$record1->id) ? 'selected="selected"' : ''; ?>
							
							<option value="<?php echo $record1->id; ?>" <?php echo $sel_1; ?>> <?php echo $parent_loc1 = stripslashes($record1->name); ?> </option> 			
						<?php  
							$record2s = $this->locations_model->get_parent_child_locations($record1->id);
							if(isset($record2s)){
								foreach($record2s as $record2){
									$sel_2 = (isset($_POST['parent_id']) && $_POST['parent_id']==$record2->id) ? 'selected="selected"' : ''; ?> 
									<option value="<?php echo $record2->id; ?>" <?php echo $sel_2; ?>> - <?php echo $parent_loc2 = stripslashes($record2->name); ?> </option>  
									<?php     
										$record3s = $this->locations_model->get_parent_child_locations($record2->id);
										if(isset($record3s)){
											foreach($record3s as $record3){
												$sel_3 = (isset($_POST['parent_id']) && $_POST['parent_id']==$record3->id) ? 'selected="selected"' : '';  ?> 
												<option value="<?php echo $record3->id; ?>" <?php echo $sel_3; ?>> - - <?php echo $parent_loc3 = stripslashes($record3->name); ?> </option> 
													
												<?php 
													$record4s = $this->locations_model->get_parent_child_locations($record3->id);  
													if(isset($record4s)){
														foreach($record4s as $record4){
															$sel_4 = (isset($_POST['parent_id']) && $_POST['parent_id']==$record4->id) ?	'selected="selected"' : '';  ?> 
															<option value="<?php echo $record4->id; ?>" <?php echo $sel_4; ?>> - - -  <?php echo $parent_loc4 = stripslashes($record4->name); ?> </option> 
														
														<?php    
															$record5s = $this->locations_model->get_parent_child_locations($record4->id);   
															if(isset($record5s)){
																foreach($record5s as $record5){ 
																	$sel_5 = (isset($_POST['parent_id']) && $_POST['parent_id']==$record5->id) ?	'selected="selected"' : '';  ?> 
																		<option value="<?php echo $record5->id; ?>" <?php echo $sel_5; ?>> - - - -  <?php echo $parent_loc5 = stripslashes($record5->name); ?> </option>   	 
																		
																<?php 
																	$record6s = $this->locations_model->get_parent_child_locations($record5->id);   
																	if(isset($record6s)){
																		foreach($record6s as $record6){
																			$sel_6 = (isset($_POST['parent_id']) && $_POST['parent_id']==$record6->id) ?	'selected="selected"' : '';  ?>
																			<option value="<?php echo $record6->id; ?>" <?php echo $sel_6; ?>> - - - - - <?php echo $parent_loc6 = stripslashes($record6->name); ?> </option>      
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
                      <span id="parent_id1" class="text-danger"><?php echo form_error('parent_id'); ?></span> </div>
                  </div>
				  
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="name">Location Name <span class="reds">*</span></label>
                    <div class="col-md-6">
                      <input name="name" id="name" type="text" class="form-control" value="<?php echo set_value('name'); ?>" data-error="#name1">
                      <span id="name1" class="text-danger"><?php echo form_error('name'); ?></span> </div>
                  </div>
                  
				  
				  <div class="form-group">
					<label class="col-md-2 control-label" for="description">Description <span class="reds"> </span> </label>
					<div class="col-md-6">
						<textarea name="description" id="description" class="form-control" rows="5" data-error="#description1"><?php echo set_value('description'); ?></textarea> 
					  <span id="description1" class="text-danger"></span>
					  </div>
				  </div> 				  
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="status">Status </label>
                    <div class="col-md-6"> 
					 <select name="status" id="status" class="form-control select2" data-error="#status1">
						<option value="">Select Status</option>
						<option value="1" <?php if((isset($_POST['status']) && $_POST['status']=='1') || (isset($record) && $record->status=='1')){ echo 'selected="selected"'; } ?>> Active </option>
						<option value="0" <?php if((isset($_POST['status']) && $_POST['status']=='0') || (isset($record) && $record->status=='0')){ echo 'selected="selected"'; } ?>> Inactive </option> 
					  </select>
					  <span id="status1" class="text-danger"><?php echo form_error('status'); ?></span>  
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-6">
                      <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>
                      &nbsp;
                      <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>
                      &nbsp;
                      <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
                      &nbsp;
                      <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('locations/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button>
                    </div>
                  </div>
                </form>
                <script type="text/javascript"> 
                //jQuery.noConflict()(function($){ 
                    $(document).ready(function(){ 
                        var validator = $('#datas_form').validate({
                        rules: {
                            name: {
                                required: true 
                            },
                            parent_id: {
                                required: true 
                            }
                        },
                        messages: { 
                            name: {
                                required: "This is required field"
                            },
                            parent_id: {
                                required: "This is required field"
                            }
                        },
                        errorPlacement: function(error, element) {
                          var placement = $(element).data('error');
                          if (placement) {
                            $(placement).append(error)
                          } else {
                            error.insertAfter(element);
                          }
                        },  
                        submitHandler: function(){ 
                            document.forms["datas_form"].submit();
                        }  
                      });
                    });
                //}); 
                </script> 
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