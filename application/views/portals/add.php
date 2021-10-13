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
       <?php $form_act = "portals/add"; ?>
        <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal">
          <div class="form-group">
            <label class="col-md-2 control-label" for="name"> Name <span class="reds">*</span></label>
              <div class="col-md-6">
                <input name="name" id="name" type="text" class="form-control" value="<?php echo set_value('name'); ?>" data-error="#name1"> 
                <span id="name1" class="text-danger" generated="true"><?php echo form_error('name'); ?></span>
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
			  <label class="col-md-2 control-label" for="url_address">URL Address<span class="reds">*</span></label>
			  <div class="col-md-6">
				<input name="url_address" id="url_address" type="text" class="form-control" value="<?php echo set_value('url_address'); ?>">
				<span class="text-danger"><?php echo form_error('url_address'); ?></span> 
			  </div> 
			</div>   
		
			<div class="form-group">
			  <label class="col-md-2 control-label" for="description">Description</label>
			  <div class="col-md-6">
			  <textarea name="description" id="description" class="form-control" rows="5" data-error="#description1"><?php echo set_value('description'); ?></textarea> 
				<span id="description1" class="text-danger" generated="true"><?php echo form_error('description'); ?></span> 
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
                    
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-6"> 
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves" id="saves"><i class="glyphicon glyphicon-ok position-left"></i>Save</button>  
              &nbsp;
              <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="saves_and_new" id="save_and_new"><i class="glyphicon glyphicon-repeat position-left"></i>Save & New</button>  
              &nbsp;
              <button type="reset" class="btn border-slate text-slate-800 btn-flat"><i class="glyphicon glyphicon-refresh position-left"></i>Clear</button>
 
          &nbsp;
          <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('portals/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button> 
          
        </div>
      </div>
    </form> 
    <script type="text/javascript">  
        $(document).ready(function(){ 
            var validator = $('#datas_form').validate({
            rules: {
                name: {
                    required: true 
                }, 
				sort_order: {
                    required: true 
                }, 
				url_address: {
                    required: true,
					url: true 
                }  
            },
            messages: { 
                name: {
                    required: "This is required field"
                },
				sort_order: {
                    required: "This is required field"
                },
				url_address: {
                    required: "This is required field",
					url: "Please enter a valid URL Address!"
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