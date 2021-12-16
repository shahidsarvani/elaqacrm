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
                <form name="datas_form" id="datas_form" method="post" action="<?php echo site_url('settings/config'); ?>" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="company_name">Company Name <span class="reds"> *</span></label>
                      <div class="col-md-6">
                        <input name="company_name" id="company_name" type="text" class="form-control" value="<?php echo (isset($_POST['company_name'])) ? set_value('company_name') : $vs_company_name; ?>" data-error="#company_name1">
                        <span id="company_name1" class="text-danger"><?php echo form_error('company_name'); ?></span> 
                      </div> 
                    </div>  
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="sale_inititals">Sale Inititals <span class="reds"> *</span></label>
                      <div class="col-md-6">
                        <input name="sale_inititals" id="sale_inititals" type="text" class="form-control" value="<?php echo (isset($_POST['sale_inititals'])) ? set_value('sale_inititals') : $vs_sale_inititals; ?>" data-error="#sale_inititals1">
                        <span id="sale_inititals1" class="text-danger"><?php echo form_error('sale_inititals'); ?></span> 
                      </div> 
                    </div> 
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="rent_inititals">Rent Inititals <span class="reds"> *</span></label>
                      <div class="col-md-6">
                        <input name="rent_inititals" id="rent_inititals" type="text" class="form-control" value="<?php echo (isset($_POST['rent_inititals'])) ? set_value('rent_inititals') : $vs_rent_inititals; ?>" data-error="#rent_inititals1">
                        <span id="rent_inititals1" class="text-danger"><?php echo form_error('rent_inititals'); ?></span> 
                      </div> 
                    </div> 
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="email">Email <span class="reds"> *</span></label>
                      <div class="col-md-6">
                        <input name="email" id="email" type="text" class="form-control" value="<?php echo (isset($_POST['email'])) ? set_value('email') : $vs_email; ?>" data-error="#email1"> 
                        <span id="email1" class="text-danger"><?php echo form_error('email'); ?></span> 
                      </div> 
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="phone_no">Phone No <span class="reds"> *</span></label>
                      <div class="col-md-6">
                        <input name="phone_no" id="phone_no" type="text" class="form-control" value="<?php echo (isset($_POST['phone_no'])) ? set_value('phone_no') : $vs_phone_no; ?>" data-error="#phone_no1"> <span id="phone_no1" class="text-danger"><?php echo form_error('phone_no'); ?></span> 
                      </div> 
                    </div> 
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="website">Website <span class="reds"> *</span></label>
                      <div class="col-md-6">
                        <input name="website" id="website" type="text" class="form-control" value="<?php echo (isset($_POST['website'])) ? set_value('website') : $vs_website; ?>" data-error="#website1"> <span id="website1" class="text-danger"><?php echo form_error('website'); ?></span> 
                      </div> 
                    </div> 
					
					<div class="form-group">
                      <label class="col-md-2 control-label" for="currency_id"> Site Currency <span class="reds"> *</span></label>
                      <div class="col-md-6"> 						
						<select name="currency_id" id="currency_id" class="form-control select2" data-error="#currency_id1">  
						<option value=""> Select Currency </option>
							<?php 
								if($currencies_arrs){
									foreach($currencies_arrs as $currencies_arr){
										$sel_1 = '';
										if(isset($_POST['currency_id']) && $_POST['currency_id']==$currencies_arr->id){
											$sel_1 = 'selected="selected"';
										}else if(isset($vs_currency_id) && $vs_currency_id == $currencies_arr->id){
											$sel_1 = 'selected="selected"';
										} ?>
										<option value="<?= $currencies_arr->id; ?>" <?php echo $sel_1; ?>>
											<?= stripslashes($currencies_arr->name) .' ('. stripslashes($currencies_arr->symbol) .')'; ?>
										</option>
									<?php 
									}
								} ?>
						  </select>
						
						<span id="currency_id1" class="text-danger"><?php echo form_error('currency_id'); ?></span> 
                      </div> 
                    </div>
					
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="image">Logo</label>
                      <div class="col-md-6">
                        <input type="file" name="image" id="image" class="file-styled" data-error="#image1">
                        <?php  
                        if(isset($vs_image) && strlen($vs_image)>0){ ?>
                            <input type="hidden" name="old_image" id="old_image" value="<?php echo $vs_image; ?>"> <?php echo '( '.$vs_image.'	)'; } ?>  
                            <span id="image1" class="text-danger"><?php 
                            echo form_error('image'); 
                            if(isset($_SESSION['prof_img_error'])){
                                echo $_SESSION['prof_img_error'];
                            } ?></span> 
                      </div> 
                    </div>  
                    
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="summary">Summary <span class="reds"> *</span></label>
                      <div class="col-md-6">
                      <textarea name="summary" id="summary" class="form-control" rows="5" data-error="#summary1"><?php echo (isset($_POST['summary'])) ? set_value('summary') : $vs_summary; ?></textarea>
                       <span id="summary1" class="text-danger"><?php echo form_error('summary'); ?></span> 
                      </div> 
                    </div> 
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="disclaimer">Disclaimer <span class="reds"> *</span></label>
                      <div class="col-md-6">
                      <textarea name="disclaimer" id="disclaimer" class="form-control" rows="5" data-error="#disclaimer1"><?php echo (isset($_POST['disclaimer'])) ? set_value('disclaimer') : $vs_disclaimer; ?></textarea>
                       <span id="disclaimer1" class="text-danger"><?php echo form_error('disclaimer'); ?></span> 
                      </div> 
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="address_1">Address 1 <span class="reds"> *</span></label>
                      <div class="col-md-6">
                      <textarea name="address_1" id="address_1" class="form-control" rows="5" data-error="#address_11"><?php echo (isset($_POST['address_1'])) ? set_value('address_1') : $vs_address_1; ?></textarea>
                       <span id="address_11" class="text-danger"><?php echo form_error('address_1'); ?></span> 
                      </div> 
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="address_2">Address 2 <span class="reds"> *</span></label>
                      <div class="col-md-6">
                      <textarea name="address_2" id="address_2" class="form-control" rows="5" data-error="#address_21"><?php echo (isset($_POST['address_2'])) ? set_value('address_2') : $vs_address_2; ?></textarea>
                       <span id="address_21" class="text-danger"><?php echo form_error('address_2'); ?></span> 
                      </div> 
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="copyrights">Copyrights <span class="reds"> *</span></label>
                      <div class="col-md-6">
                      <textarea name="copyrights" id="copyrights" class="form-control" rows="5" data-error="#copyrights1"><?php echo (isset($_POST['copyrights'])) ? set_value('copyrights') : $vs_copyrights; ?></textarea>
                       <span id="copyrights1" class="text-danger"><?php echo form_error('copyrights'); ?></span> 
                      </div> 
                    </div> 
                    
                <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-6"> 
                    <button class="btn border-slate text-slate-800 btn-flat" type="submit" name="updates" id="updates"><i class="glyphicon glyphicon-ok position-left"></i>Update Configuration</button>       
                    </div>
                  </div>
              </form> 
              
			  <script type="text/javascript">  
                $(document).ready(function(){ 
                    var validator = $('#datas_form').validate({
                    rules: {  
                        company_name: {
                            required: true 
                        }, 
                        sale_inititals: {
                            required: true 
                        }, 
                        rent_inititals: {
                            required: true 
                        }, 
                        email: {
                            required: true, 
                            email: true
                        }, 
                        phone_no: {
                            required: true,
                            digits: true 
                        },
                        website: {
                            required: true,
                            url: true 
                        }, 
						currency_id: {
                            required: true, 
                        }, 
                        summary: {
                            required: true 
                        }, 
                        disclaimer: {
                            required: true 
                        },   
                        address_1: {
                            required: true 
                        }, 
                        address_2: {
                            required: true 
                        }, 
                        copyrights: {
                            required: true 
                        },   
                        image: {
                            required: false,
                            accept:"gif|png|jpg|jpeg" 
                        }  
                    },
                    messages: {
                        company_name: {
                            required: "This is required field"  
                        }, 
                        sale_inititals: {
                            required: "This is required field"  
                        }, 
                        rent_inititals: {
                            required: "This is required field"  
                        }, 
                        email: {
                            required: "This is required field" , 
                            email: "Please enter a valid Email address!" 
                        }, 
                        phone_no: {
                            required: "This is required field" ,
                            digits: "Enter a Numbers only!"  
                        },
                        website: {
                            required: "This is required field",
                            url: "Please enter a valid URL Address!"  
                        },
						currency_id: {
                            required: "This is required field",
                        },  
                        summary: {
                            required: "This is required field"  
                        }, 
                        disclaimer: {
                            required: "This is required field"  
                        },   
                        address_1: {
                            required: "This is required field"  
                        }, 
                        address_2: {
                            required: "This is required field"  
                        }, 
                        copyrights: {
                            required: "This is required field" 
                        },   
                        image: {
                            required: "This is required field" ,
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