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
      <?php 
	  	$form_act = '';
		if(isset($args1) && $args1>0){
			$form_act = "users/update/".$args1;
		} ?>
		<form name="datas_form" id="datas_form" method="post" action="<?php echo site_url($form_act); ?>" class="form-horizontal" enctype="multipart/form-data">
		  <div class="form-group">
			<label class="control-label col-lg-2" for="name">Name <span class="reds"> *</span></label>
			<div class="col-lg-6">
			  <input name="name" id="name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->name): set_value('name'); ?>" data-error="#name1"> 
              <span id="name1" class="text-danger" generated="true"><?php echo form_error('name'); ?></span> 
               </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-2 control-label" for="role_id">Role Name <span class="reds"> *</span></label>
        <div class="col-md-6">
          <select name="role_id" id="role_id" class="form-control select2" onChange="get_parent_area(this.value);" data-error="#role_id1">
            <option value="">Select Role Name</option>
			<?php  
            if(isset($role_arrs) && count($role_arrs)>0){
                foreach($role_arrs as $role_arr){
                    $sel_1 = '';
                    if(isset($_POST['role_id']) && $_POST['role_id']==$role_arr->id){
                        $sel_1 = 'selected="selected"';
                    }else if(isset($record) && $record->role_id==$role_arr->id){
                        $sel_1 = 'selected="selected"';
                    } ?>
                    <option value="<?= $role_arr->id; ?>" <?php echo $sel_1; ?>>
                    <?= stripslashes($role_arr->name); ?>
                    </option>
                <?php 
                    }
                } ?>
              </select>  
              <span id="role_id1" class="text-danger" generated="true"><?php echo form_error('role_id'); ?></span>
              </div>
		  </div>
		  <script>
				function get_parent_area(vals){
					if(vals==3){
						document.getElementById("operate_parent_area").style.display='';
					}else{
						document.getElementById("operate_parent_area").style.display='none';
					}
				}
			</script>
		  <div id="operate_parent_area" class="form-group" <?php echo ((isset($_POST['role_id']) && $_POST['role_id']=='3') || (isset($record) && $record->role_id=='3')) ? '':'style="display:none;"'; ?>>
			<label class="col-md-2 control-label" for="parent_id">Assigned to Manager <span class="reds"> *</span></label>
			<div class="col-md-6">
			  <select name="parent_id" id="parent_id" class="form-control select2" data-error="#parent_id1">
				<option value="">Select Manager...</option>
				<?php  
				if(isset($manager_arrs) && count($manager_arrs)>0){
					foreach($manager_arrs as $manager_arr){
						$sel_1 = '';
						if(isset($_POST['parent_id']) && $_POST['parent_id']==$manager_arr->id){
							$sel_1 = 'selected="selected"';
						}else if(isset($record) && $record->parent_id==$manager_arr->id){
							$sel_1 = 'selected="selected"';
						} ?>
				<option value="<?= $manager_arr->id; ?>" <?php echo $sel_1; ?>>
				<?= stripslashes($manager_arr->name); ?>
				</option>
				<?php 
					}
				} ?>
			  </select>
              <span id="parent_id1" class="text-danger" generated="true"><?php echo form_error('parent_id'); ?></span>
              </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-2 control-label" for="email">Email <span class="reds"> *</span></label>
			<div class="col-md-6">
			  <input name="email" id="email" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->email): set_value('email'); ?>" data-error="#email1">
			  <span id="email1" class="text-danger" generated="true"><?php echo form_error('email'); ?></span> </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-2 control-label" for="password">Password <span class="reds"> *</span></label>
			<div class="col-md-6">
			  <?php 
				if(isset($record) && strlen($record->password)>0){
					$pwd_val0 = $record->password;   
					$pwd_val = $this->general_model->encrypt_data($pwd_val0);
				}else{
					$pwd_val = set_value('password');
				} ?>
			  <input name="password" id="password" type="password" class="form-control" value="<?php echo $pwd_val; ?>" style="display:inline; width:86%;" data-error="#password1">
			   <span> &nbsp; <input type="checkbox" name="show_hide_password" id="show_hide_password" value="1" onClick="if(password.type=='text')password.type='password'; else password.type='text';" class="styled"> Show </span>  
               <span id="password1" class="text-danger" generated="true"><?php echo form_error('password'); ?></span>
              </div>
		  </div>
          <div class="form-group">
          <label class="col-md-2 control-label" for="phone_no">Phone No <span class="reds">*</span></label>
          <div class="col-md-6">
            <input name="phone_no" id="phone_no" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->phone_no): set_value('phone_no'); ?>" data-error="#phone_no1"> <span id="phone_no1" class="text-danger" generated="true"><?php echo form_error('phone_no'); ?></span>  
          </div> 
        </div> 
          
		  <div class="form-group">
			<label class="col-md-2 control-label" for="mobile_no">Mobile No <span class="reds">*</span></label>
			<div class="col-md-6">
			  <input name="mobile_no" id="mobile_no" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->mobile_no): set_value('mobile_no'); ?>" data-error="#mobile_no1"> 
              <span id="mobile_no1" class="text-danger" generated="true"><?php echo form_error('mobile_no'); ?></span>
             </div>
		  </div>
          <div class="form-group">
              <label class="col-md-2 control-label" for="company_name">Company Name</label>
              <div class="col-md-6">
                <input name="company_name" id="company_name" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->company_name): set_value('company_name'); ?>"> <span class="text-danger"><?php echo form_error('company_name'); ?></span> 
              </div> 
            </div>
		  <div class="form-group">
			<label class="col-md-2 control-label" for="rera_no">RERA No </label>
			<div class="col-md-6">
			  <input name="rera_no" id="rera_no" type="text" class="form-control" value="<?php echo (isset($record)) ? stripslashes($record->rera_no): set_value('rera_no'); ?>" data-error="#rera_no1">  <span id="rera_no1" class="text-danger" generated="true"><?php echo form_error('rera_no'); ?></span> </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-2 control-label" for="address">Address <span class="reds"> *</span> </label>
			<div class="col-md-6">
            	<textarea name="address" id="address" class="form-control" rows="5" data-error="#address1"><?php echo (isset($record)) ? stripslashes($record->address): set_value('address'); ?></textarea> 
              <span id="address1" class="text-danger" generated="true"><?php echo form_error('address'); ?></span>
			  </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-2 control-label" for="status">Account Status <span class="reds"> *</span></label>
			<div class="col-md-6">
			  <select name="status" id="status" class="form-control select2">
				<option value="1" <?php if((isset($_POST['status']) && $_POST['status']==1) || (isset($record) && $record->status==1)){ echo 'selected="selected"'; } ?>> Active </option>
				<option value="0" <?php if((isset($_POST['status']) && $_POST['status']==0) || (isset($record) && $record->status==0)){ echo 'selected="selected"'; } ?>> Inactive </option>
			  </select>
              <span id="password1" class="text-danger" generated="true"><?php echo form_error('status'); ?></span>
			  </div>
		  </div>
		  <div class="form-group">
			<label class="col-md-2 control-label" for="image">Profile Picture</label>
			<div class="col-md-6">
			  <input type="file" name="image" id="image" class="file-styled" data-error="#image1">
			  <?php  
				if(isset($record) && strlen($record->image)>0){ ?>
			  <input type="hidden" name="old_image" id="old_image" value="<?php echo $record->image; ?>">
			  <?php echo '( '.$record->image.' )'; } ?>  
              <span id="image1" class="text-danger" generated="true"> 
			  <?php  
				echo form_error('image'); 
				if(isset($_SESSION['prof_img_error'])){
					echo $_SESSION['prof_img_error'];
				} ?>
			  </span> </div>
		  </div>
		    
          <div class="form-group">
            <label class="col-md-2 control-label"></label>
            <div class="col-md-6">
            
          <?php if(isset($record)){	?>
                  <input type="hidden" name="args1" id="args1" value="<?php echo $record->id; ?>"> 
                  <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update</button>   
          <?php } ?>
              &nbsp;
              <button type="button" class="btn border-slate text-slate-800 btn-flat" onClick="window.location='<?php echo site_url('users/index'); ?>';"><i class="glyphicon glyphicon-chevron-left position-left"></i>Cancel</button> 
              
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
				role_id: {
                    required: true 
                }, 
				email: {
                    required: true,
					email: true 
                }, 
				password: {
                    required: true, 
					minlength: 5
                }, 
				phone_no: {
                    required: true,
					digits: true 
                },
				mobile_no: {
                    required: true,
					digits: true 
                }, 
				address: {
                    required: true 
                }, 
				status: {
                    required: true 
                }, 
				image: {
                    required: false,
					accept:"gif|png|jpg|jpeg" 
                }  
            },
            messages: { 
				name: {
                    required: "This is required field" 
                }, 
				role_id: {
                    required: "This is required field" 
                }, 
				email: {
                    required: "This is required field",
					email: "Please enter a valid Email address!" 
                }, 
				password: {
                    required: "This is required field", 
					minlength: "Minimum 5 characters needed!"
                },
				phone_no: {
                    required: "This is required field",
					digits: "Enter a Numbers only!" 
                },
				mobile_no: {
                    required: "This is required field",
					digits: "Enter a Numbers only!" 
                },
				address: {
                    required: "This is required field" 
                },
				status: {
                    required: "This is required field" 
                }, 
				image: {
                    required: "This is required field",
					accept:"Accepts images having extension gif|png|jpg|jpeg" 
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