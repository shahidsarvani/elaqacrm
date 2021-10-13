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
        <h5 class="panel-title"> <?= $page_headings; ?> Form </h5>
      </div>
      <div class="panel-body">
       <?php $form_act = "property_features/add"; ?>
        <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
            <div class="form-group">
              <label class="col-md-2 control-label" for="title">Title <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="title" id="title" type="text" class="form-control" value="<?php echo set_value('title'); ?>" data-error="#title1">
                 <span id="title1" class="text-danger" generated="true"><?php echo form_error('title'); ?></span> 
              </div> 
            </div> 
            <div class="form-group">
              <label class="col-md-2 control-label" for="short_tag">Short Tag <span class="reds">*</span> </label>
              <div class="col-md-6">
                <input name="short_tag" id="short_tag" type="text" class="form-control" value="<?php echo set_value('short_tag'); ?>" data-error="#short_tag1">
                 <span id="short_tag1" class="text-danger" generated="true"><?php echo form_error('short_tag'); ?></span>  
              </div> 
            </div>   
            <div class="form-group">
              <label class="col-md-2 control-label" for="sort_order">Sort Order <span class="reds">*</span></label>
              <div class="col-md-6">
              <?php 
                  if(isset($_POST['sort_order']) && strlen($_POST['sort_order'])>0){
                    $temp_sort_order = $_POST['sort_order']; 
                  }else{
                    $temp_sort_order = $max_sort_val+1;
                  } ?>
                  <input name="sort_order" id="sort_order" type="text" class="form-control" value="<?php echo $temp_sort_order; ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" data-error="#sort_order1">
                <span id="sort_order1" class="text-danger" generated="true"><?php echo form_error('sort_order'); ?></span> 
              </div> 
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label" for="status">Status </label>
              <div class="col-md-6">
               <div class="checkbox">
               	<label for="status"> <input type="checkbox" name="status" id="status" value="1" <?php echo (isset($_POST['status']) && $_POST['status']==1) ? 'checked="checked"' : ''; ?> class="styled"> Active</label>
                </div> 
              </div> 
            </div>  
             
            <div class="form-group mb-md">
              <label class="col-md-2 control-label" for="amenities_types"> Amenity Type(s)</label>
              <div class="col-md-6">
                <div class="multi-select-full">
                  <select name="amenities_types[]" id="amenities_types" class="multiselect-method-rebuild" multiple="multiple" data-error="#amenities_types1">						
				<?php 
					$db_amenities_types_arrs = '';  
                    if(isset($_POST['amenities_types']) && count($_POST['amenities_types'])>0){ 
                        $db_amenities_types_arrs = $_POST['amenities_types'];   
                    }
                        
                    $sel_1 = $sel_2 = '';
                    if(isset($db_amenities_types_arrs) && count($db_amenities_types_arrs)>0){
                        if(in_array('1', $db_amenities_types_arrs)){
                            $sel_1 = 'selected="selected"';
                        }
                        
                        if(in_array('2', $db_amenities_types_arrs)){
                            $sel_2 = 'selected="selected"';
                        }
                    }  ?>    
						<option value="1" <?php echo $sel_1; ?>> Private </option>
						<option value="2" <?php echo $sel_2; ?>> Commercial </option>
                    </select>
               	 </div>
                           
                 <span id="amenities_types1" class="text-danger" generated="true"><?php echo form_error('amenities_types[]'); ?></span> 
				  </div> 
				</div>  
	 
			<?php 
				$portal_arrs = $this->portals_model->get_all_portals();
				if(isset($portal_arrs) && count($portal_arrs)>0){
					foreach($portal_arrs as $portal_arr){
						$portal_id = $portal_arr->id; 
						$portal_name = stripslashes($portal_arr->name);
						$insrt_abrv_val = '';
						if(isset($_POST["cate_portal_abbr_{$portal_id}"]) && strlen($_POST["cate_portal_abbr_{$portal_id}"])){
							$insrt_abrv_val = $_POST["cate_portal_abbr_{$portal_id}"];	
						}else if(isset($record) && $record->id >0){ 
							$cate_prtl_arr = $this->general_model->get_featured_portal_abbrevations_data($record->id,$portal_id);
							if(isset($cate_prtl_arr)){
								$insrt_abrv_val = $cate_prtl_arr->abbrevations;	
							}
						} ?>
												   
					 <div class="form-group">
					  <label class="col-md-2 control-label" for="cate_portal_abbr_<?php echo $portal_id; ?>"><?php echo $portal_name; ?> Abbrevation </label>
					  <div class="col-md-6">
						<input name="cate_portal_abbr_<?php echo $portal_id; ?>" id="cate_portal_abbr_<?php echo $portal_id; ?>" type="text" class="form-control" value="<?php echo $insrt_abrv_val; ?>">
						<span class="text-danger"><?php //echo form_error("cate_portal_abbr_{$portal_id}"); ?></span> 
					  </div> 
					</div>  
									 
				<?php 
					} 
				}  ?>      
                    
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-6"> 
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>  
              &nbsp;
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>  
              &nbsp;
              <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
     
          &nbsp;
          <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('property_features/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button> 
          
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
				short_tag: {
                    required: true 
                }, 
				sort_order: {
                    required: true
                }  
            },
            messages: { 
                title: {
                    required: "This is required field"
                },
				short_tag: {
                    required: "This is required field"
                },
				sort_order: {
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