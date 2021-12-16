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
                <h5 class="panel-title">
                  <?= $page_headings; ?>
                  Form </h5>
              </div>
              <div class="panel-body">
                <?php 
					if(isset($args1) && $args1>0){
						$form_act = "tasks/operate_task_to_do/".$args1;
					}else{
						$form_act = "tasks/operate_task_to_do";
					} ?>
                <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
                  <div class="form-group">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="property_ref"> Property Ref No. </label>
                        <div class="col-md-8">
                          <input name="property_ref" id="property_ref" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->property_ref): set_value('property_ref'); ?>" onKeyUp="operate_property_ref_suggestion();" onBlur="operate_property_ref_suggestion()" data-error="#property_ref1">
                          <span id="property_ref1" class="text-danger"><?php echo form_error('property_ref'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="lead_ref"> Lead Ref No. </label>
                        <div class="col-md-8">
                          <input name="lead_ref" id="lead_ref" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->lead_ref): set_value('lead_ref'); ?>" data-error="#lead_ref1">
                          <span id="lead_ref1" class="text-danger"><?php echo form_error('lead_ref'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="title"> Task Detail <span class="reds"> *</span></label>
                        <div class="col-md-8">  
                          <textarea name="title" id="title" class="form-control" rows="5" data-error="#title1"><?php echo (isset($record)) ? stripslashes($record->title): set_value('title'); ?></textarea> 
                          <span id="title1" class="text-danger"><?php echo form_error('title'); ?></span> </div>
                      </div>
                      <?php if($this->login_vs_role_id ==1 || $this->login_vs_role_id ==2){ ?>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="assigned_to">Assigned To <span class="reds"> *</span></label>
                        <div class="col-md-8">
              <select name="assigned_to" id="assigned_to" class="form-control select" data-error="#assigned_to1">
                <option value="">Select Assigned To </option>
                <?php  
                    if(isset($record_arrs) && count($record_arrs)>0){
                        foreach($record_arrs as $record_arr){
                            $sel_1 = '';
                            if(isset($_POST['assigned_to']) && $_POST['assigned_to']==$record_arr->id){
                                $sel_1 = 'selected="selected"';
                            }else if(isset($record) && $record->assigned_to==$record_arr->id){
                                $sel_1 = 'selected="selected"';
                            }
                            
                            if($record_arr->id==$this->login_vs_id){
                                $nw_txt = "Me";
                            }else{
                                $nw_txt = stripslashes($record_arr->name);	
                            } ?>
                            <option value="<?= $record_arr->id; ?>" <?php echo $sel_1; ?>>
                            <?= $nw_txt; ?>
                            </option>
                            <?php 
                        }
                    } ?>
             	  </select>
                  <span id="assigned_to1" class="text-danger"><?php echo form_error('assigned_to'); ?></span> </div>
              </div>
            <?php } ?>
      <div class="form-group">
        <label class="col-md-3 control-label" for="due_date">Due Date <span class="reds"> *</span> </label>
        <div class="col-md-8">
	   	<?php 
            if(isset($record) && $record->due_date!='0000-00-00'){
                $sel_due_date = $record->due_date;
            }else{
                $sel_due_date = set_value('due_date');
                if(isset($sel_due_date) && ($sel_due_date=='' || $sel_due_date=='0000-00-00')){
                    $sel_due_date = date('Y-m-d');
                } 
            } ?>
              <input name="due_date" id="due_date" type="text" class="form-control" value="<?php echo $sel_due_date; ?>" data-plugin-datepicker data-plugin-options='{"format": "yyyy-mm-dd"}' data-error="#due_date1">
              <span id="due_date1" class="text-danger"><?php echo form_error('due_date'); ?></span> </div>
          </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="due_timing">Due Timing <span class="reds"> *</span> </label>
                        <div class="col-md-8">
                          <input class="form-control" placeholder="Adjust Timings" id="due_timing" name="due_timing" data-plugin-timepicker value="<?php echo (isset($record) && $record->due_timing!='') ? $record->due_timing : set_value('due_timing'); ?>" data-error="#due_timing1">
                          <span id="due_timing1" class="text-danger"><?php echo form_error('due_timing'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="status"> Task Status <span class="reds"> *</span> </label>
                        <div class="col-md-8">
                          <?php  
                    $sel_1 = $sel_2 = $sel_3 = $sel_4 = $sel_5 = '';
                    if(isset($_POST['status']) && $_POST['status']==0){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($record) && $record->status==0){
                        $sel_1 = 'selected="selected"';
                    }
                    
                    if(isset($_POST['status']) && $_POST['status']==1){
                        $sel_2 = 'selected="selected"';
                    }else if(isset($record) && $record->status==1){
                        $sel_2 = 'selected="selected"';
                    }
                    
                    if(isset($_POST['status']) && $_POST['status']==2){
                        $sel_3 = 'selected="selected"';
                    }else if(isset($record) && $record->status==2){
                        $sel_3 = 'selected="selected"';
                    }
                    
                    if(isset($_POST['status']) && $_POST['status']==3){
                        $sel_4 = 'selected="selected"';
                    }else if(isset($record) && $record->status==3){
                        $sel_4 = 'selected="selected"';
                    }
                    
                    if(isset($_POST['status']) && $_POST['status']==4){
                        $sel_5 = 'selected="selected"';
                    }else if(isset($record) && $record->status==4){
                        $sel_5 = 'selected="selected"';
                    } ?>
                          <select name="status" id="status" class="form-control select" data-error="#status1">
                            <option value="">Select Status </option>
                            <option value="0" <?php echo $sel_1; ?>> Pending </option>
                            <option value="1" <?php echo $sel_2; ?>> Completed </option>
                            <option value="2" <?php echo $sel_3; ?>> In Progress </option>
                            <option value="3" <?php echo $sel_4; ?>> Rejected </option>
                            <option value="4" <?php echo $sel_5; ?>> Over Due </option>
                          </select>
                          <span id="status1" class="text-danger"><?php echo form_error('status'); ?></span> </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                          <?php if(isset($record)){	?>
                          <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>">
                          <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update</button>
                          <?php }else{	?>
                          <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>
                          &nbsp;
                          <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>
                          &nbsp;
                          <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
                          <?php }	?>
                          &nbsp;
                          <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('tasks/tasks_list'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button>
                        </div>
                      </div>
                    </div>
                    
        <div class="col-md-4" id="fetch_property_data">
          <div class='well info'>
            <?php 
                if(isset($_POST['property_ref']) && strlen($_POST['property_ref'])>0){
					$sl_property_ref = set_value('property_ref'); 
					$rows_arr = $this->general_model->get_gen_property_info_by_ref($sl_property_ref);
					if(isset($rows_arr)){ 
						$cstm_property_type = ($rows_arr->property_type==1) ? 'Sale' : 'Rent';
						echo "<strong>Property Type: </strong> ".$cstm_property_type."<br> <strong>Title: </strong>".stripslashes($rows_arr->title)."<br> <strong>Price : </strong>".number_format($rows_arr->price,2,".",",");
					}  
                }else if(isset($record) && strlen($record->property_ref)>0){  
                
					$rows_arr = $this->general_model->get_gen_property_info_by_ref($record->property_ref);
					if(isset($rows_arr)){ 
						$cstm_property_type = ($rows_arr->property_type==1) ? 'Sale' : 'Rent';
						echo "<strong>Property Type: </strong> ".$cstm_property_type."<br> <strong>Title: </strong>".stripslashes($rows_arr->title)."<br> <strong>Price : </strong>".number_format($rows_arr->price,2,".",",");
					}  
                }else{
               		echo "<strong>No property found!</strong>"; 
                }	?>
                  </div>
                </div>
              </div>
            </form>      
                <script type="text/javascript">  
					$(document).ready(function(){ 
						var validator = $('#datas_form').validate({
						rules: {
							title: {
								required: true 
							},
							assigned_to: {
								required: true 
							},
							due_date: {
								required: true 
							},
							due_timing: {
								required: true 
							},
							status: {
								required: true 
							}  
						},
						messages: {
							title: {
								required: "This is required field" 
							},
							assigned_to: {
								required: "This is required field" 
							},
							due_date: {
								required: "This is required field" 
							},
							due_timing: {
								required: "This is required field" 
							},
							status: {
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