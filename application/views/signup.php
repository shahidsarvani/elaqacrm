<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('widgets/login_meta_tags'); ?> 
<script type="text/javascript" src="<?= asset_url();?>js/plugins/forms/wizards/stepy.min.js"></script>   
<!--<script type="text/javascript" src="<?= asset_url();?>js/plugins/forms/wizards/steps.min.js"></script>-->
<script type="text/javascript" src="<?= asset_url();?>js/plugins/forms/selects/select2.min.js"></script> 
<!--<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script> 
<script type="text/javascript" src="<?= asset_url();?>js/core/app.js"></script> -->
<!--<script type="text/javascript" src="<?= asset_url();?>js/pages/wizard_steps.js"></script>--> 
<script type="text/javascript" src="<?= asset_url();?>js/pages/wizard_stepy.js"></script>
<style>  
	#generic_price_table{
	  background-color: #f0eded;
	}
	
	/*PRICE COLOR CODE START*/
	#generic_price_table .generic_content{
	  background-color: #fff;
	}
	
	#generic_price_table .generic_content .generic_head_price{
	  background-color: #f6f6f6;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_head_content .head_bg{
	  border-color: #e4e4e4 rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #e4e4e4;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_head_content .head span{
	  color: #525252;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .price .sign{
		color: #414141;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .price .currency{
		color: #414141;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .price .cent{
		color: #414141;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .month{
		color: #414141;
	}
	
	#generic_price_table .generic_content .generic_feature_list ul li{  
	  color: #a7a7a7;
	}
	
	#generic_price_table .generic_content .generic_feature_list ul li span{
	  color: #414141;
	}
	#generic_price_table .generic_content .generic_feature_list ul li:hover{
	  background-color: #E4E4E4;
	  border-left: 5px solid #26A69A;
	}
	
	#generic_price_table .generic_content .generic_price_btn a{
	  border: 1px solid #26A69A; 
		color: #26A69A;
	} 
	
	#generic_price_table .generic_content.active .generic_head_price .generic_head_content .head_bg,
	#generic_price_table .generic_content:hover .generic_head_price .generic_head_content .head_bg{
	  border-color: #26A69A rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #26A69A;
	  color: #fff;
	}
	
	#generic_price_table .generic_content:hover .generic_head_price .generic_head_content .head span,
	#generic_price_table .generic_content.active .generic_head_price .generic_head_content .head span{
	  color: #fff;
	}
	
	#generic_price_table .generic_content:hover .generic_price_btn a,
	#generic_price_table .generic_content.active .generic_price_btn a{
	  background-color: #26A69A; /*#2ECC71;*/
	  color: #fff;
	} 
	#generic_price_table{
	  margin: 50px 0 50px 0;
		font-family: 'Raleway', sans-serif;
	}
	.row .table{
		padding: 28px 0;
	}
	
	/*PRICE BODY CODE START*/
	
	#generic_price_table .generic_content{
	  overflow: hidden;
	  position: relative;
	  text-align: center;
	}
	
	#generic_price_table .generic_content .generic_head_price {
	  margin: 0 0 20px 0;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_head_content{
	  margin: 0 0 50px 0;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_head_content .head_bg{
		border-style: solid;
		border-width: 90px 1411px 23px 399px;
	  position: absolute;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_head_content .head{
	  padding-top: 40px;
	  position: relative;
	  z-index: 1;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_head_content .head span{
		font-family: "Raleway",sans-serif;
		font-size: 28px;
		font-weight: 400;
		letter-spacing: 2px;
		margin: 0;
		padding: 0;
		text-transform: uppercase;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag{
	  padding: 0 0 20px;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .price{
	  display: block;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .price .sign{
		display: inline-block;
		font-family: "Lato",sans-serif;
		font-size: 28px;
		font-weight: 400;
		vertical-align: middle;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .price .currency{
		font-family: "Lato",sans-serif;
		font-size: 60px;
		font-weight: 300;
		letter-spacing: -2px;
		line-height: 60px;
		padding: 0;
		vertical-align: middle;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .price .cent{
		display: inline-block;
		font-family: "Lato",sans-serif;
		font-size: 24px;
		font-weight: 400;
		vertical-align: bottom;
	}
	
	#generic_price_table .generic_content .generic_head_price .generic_price_tag .month{
		font-family: "Lato",sans-serif;
		font-size: 18px;
		font-weight: 400;
		letter-spacing: 3px;
		vertical-align: bottom;
	}
	
	#generic_price_table .generic_content .generic_feature_list ul{
	  list-style: none;
	  padding: 0;
	  margin: 0;
	}
	
	#generic_price_table .generic_content .generic_feature_list ul li{
	  font-family: "Lato",sans-serif;
	  font-size: 18px;
	  padding: 15px 0;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table .generic_content .generic_feature_list ul li:hover{
	  transition: all 0.3s ease-in-out 0s;
	  -moz-transition: all 0.3s ease-in-out 0s;
	  -ms-transition: all 0.3s ease-in-out 0s;
	  -o-transition: all 0.3s ease-in-out 0s;
	  -webkit-transition: all 0.3s ease-in-out 0s;
	
	}
	#generic_price_table .generic_content .generic_feature_list ul li .fa{
	  padding: 0 10px;
	}
	#generic_price_table .generic_content .generic_price_btn{
	  margin: 20px 0 32px;
	}
	
	#generic_price_table .generic_content .generic_price_btn a{
		border-radius: 50px;
	  -moz-border-radius: 50px;
	  -ms-border-radius: 50px;
	  -o-border-radius: 50px;
	  -webkit-border-radius: 50px;
		display: inline-block;
		font-family: "Lato",sans-serif;
		font-size: 18px;
		outline: medium none;
		padding: 12px 30px;
		text-decoration: none;
		text-transform: uppercase;
	}
	
	#generic_price_table .generic_content,
	#generic_price_table .generic_content:hover,
	#generic_price_table .generic_content .generic_head_price .generic_head_content .head_bg,
	#generic_price_table .generic_content:hover .generic_head_price .generic_head_content .head_bg,
	#generic_price_table .generic_content .generic_head_price .generic_head_content .head h2,
	#generic_price_table .generic_content:hover .generic_head_price .generic_head_content .head h2,
	#generic_price_table .generic_content .price,
	#generic_price_table .generic_content:hover .price,
	#generic_price_table .generic_content .generic_price_btn a,
	#generic_price_table .generic_content:hover .generic_price_btn a{
	  transition: all 0.3s ease-in-out 0s;
	  -moz-transition: all 0.3s ease-in-out 0s;
	  -ms-transition: all 0.3s ease-in-out 0s;
	  -o-transition: all 0.3s ease-in-out 0s;
	  -webkit-transition: all 0.3s ease-in-out 0s;
	} 
	@media (max-width: 320px) { 
	}
	
	@media (max-width: 767px) {
	  #generic_price_table .generic_content{
		margin-bottom:75px;
	  }
	}
	@media (min-width: 768px) and (max-width: 991px) {
	  #generic_price_table .col-md-3{
		float:left;
		width:50%;
	  }
	  
	  #generic_price_table .col-md-4{
		float:left;
		width:50%;
	  }
	  
	  #generic_price_table .generic_content{
		margin-bottom:75px;
	  }
	}
	@media (min-width: 992px) and (max-width: 1199px) {
	}
	@media (min-width: 1200px) {
	}
	#generic_price_table_home{
	   font-family: 'Raleway', sans-serif;
	}
	
	.text-center h1,
	.text-center h1 a{
	  color: #7885CB;
	  font-size: 30px;
	  font-weight: 300;
	  text-decoration: none;
	}
	.demo-pic{
	  margin: 0 auto;
	}
	.demo-pic:hover{
	  opacity: 0.7;
	}
	
	#generic_price_table_home ul{
	  margin: 0 auto;
	  padding: 0;
	  list-style: none;
	  display: table;
	}
	#generic_price_table_home li{
	  float: left;
	}
	#generic_price_table_home li + li{
	  margin-left: 10px;
	  padding-bottom: 10px;
	}
	#generic_price_table_home li a{
	  display: block;
	  width: 50px;
	  height: 50px;
	  font-size: 0px;
	}
	#generic_price_table_home .blue{
	  background: #3498DB;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .emerald{
	  background: #26A69A;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .grey{
	  background: #7F8C8D;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .midnight{
	  background: #34495E;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .orange{
	  background: #E67E22;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .purple{
	  background: #9B59B6;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .red{
	  background: #E74C3C;
	  transition:all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .turquoise{
	  background: #1ABC9C;
	  transition: all 0.3s ease-in-out 0s;
	}
	
	#generic_price_table_home .blue:hover,
	#generic_price_table_home .emerald:hover,
	#generic_price_table_home .grey:hover,
	#generic_price_table_home .midnight:hover,
	#generic_price_table_home .orange:hover,
	#generic_price_table_home .purple:hover,
	#generic_price_table_home .red:hover,
	#generic_price_table_home .turquoise:hover{
	  border-bottom-left-radius: 50px;
		border-bottom-right-radius: 50px;
		border-top-left-radius: 50px;
		border-top-right-radius: 50px;
	  transition: all 0.3s ease-in-out 0s;
	}
	#generic_price_table_home .divider{
	  border-bottom: 1px solid #ddd;
	  margin-bottom: 20px;
	  padding: 20px;
	}
	#generic_price_table_home .divider span{
	  width: 100%;
	  display: table;
	  height: 2px;
	  background: #ddd;
	  margin: 50px auto;
	  line-height: 2px;
	}
	#generic_price_table_home .itemname{
	  text-align: center;
	  font-size: 50px ;
	  padding: 50px 0 20px ;
	  border-bottom: 1px solid #ddd;
	  margin-bottom: 40px;
	  text-decoration: none;
		font-weight: 300;
	}
	#generic_price_table_home .itemnametext{
		text-align: center;
		font-size: 20px;
		padding-top: 5px;
		text-transform: uppercase;
		display: inline-block;
	}
	#generic_price_table_home .footer{
	  padding:40px 0;
	}
	
	.price-heading{
		text-align: center;
	}
	.price-heading h1{
	  color: #666;
	  margin: 0;
	  padding: 0 0 50px 0;
	}
	.demo-button {
		background-color: #333333;
		color: #ffffff;
		display: table;
		font-size: 20px;
		margin-left: auto;
		margin-right: auto;
		margin-top: 20px;
		margin-bottom: 50px;
		outline-color: -moz-use-text-color;
		outline-style: none;
		outline-width: medium ;
		padding: 10px;
		text-align: center;
		text-transform: uppercase;
	}
	.bottom_btn{
	  background-color: #333333;
		color: #ffffff;
		display: table;
		font-size: 28px;
		margin: 60px auto 20px;
		padding: 10px 25px;
		text-align: center;
		text-transform: uppercase;
	}
	.demo-button:hover{
	  background-color: #666;
	  color: #FFF;
	  text-decoration:none;
	  
	}
	.bottom_btn:hover{
	  background-color: #666;
	  color: #FFF;
	  text-decoration:none;
	}
	
	/*#datas_form-step-1 .stepy-navigator {
		text-align: left !important;
	}*/
 </style>
</head>
<body class="login-container">
<!-- Main navbar -->
 <?php $this->load->view('widgets/login_header'); ?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
  <!-- Page content -->
  <div class="page-content">
    <!-- Main content -->
    <div class="content-wrapper">
      <!-- Content area -->
      <div class="content">
	  	 
        <!-- Registration form --> 
          <div class="row"> <!-- col-lg-offset-1 col-lg-10 col-lg-offset-1 -->
            <div class="col-lg-12 col-md-12"> 
			<?php if(isset($_SESSION['success_msg'])){ ?>    
					<div class="alert alert-success no-border">
						<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button> <?php echo $this->session->flashdata('success_msg'); ?>
					 </div> 
			<?php }
				if(isset($_SESSION['error_msg'])){ ?>  
					<div class="alert alert-danger no-border">
					<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button> <?php echo $this->session->flashdata('error_msg'); ?>
				  </div>    
			<?php } ?>  
			
			<style>
				#datas_form-step-0 .stepy-navigator .button-next {
					visibility:hidden;
				} 
			</style>
			<script>
				$(document).ready(function(){ 
					$("button#submit_trail").click(function(){
						$("#sel_package_id").val('1');  
						$("#package_no_1").css("border", "2px solid #339999");
						$("#package_no_2").css("border", "none");
						$("#package_no_3").css("border", "none");
						$("#package_no_4").css("border", "none");
						$("#datas_form-step-0 .stepy-navigator .button-next").click();
					});
					
					$("button#submit_basic").click(function(){
						$("#sel_package_id").val('2'); 
						$("#package_no_1").css("border", "none");
						$("#package_no_2").css("border", "2px solid #339999"); 	
						$("#package_no_3").css("border", "none");
						$("#package_no_4").css("border", "none");
						$("#datas_form-step-0 .stepy-navigator .button-next").click();
					});
					
					$("button#submit_regular").click(function(){
						$("#sel_package_id").val('3'); 
						$("#package_no_1").css("border", "1px solid #339999");
						$("#package_no_1").css("border", "none");
						$("#package_no_2").css("border", "none");
						$("#package_no_3").css("border", "2px solid #339999"); 	 
						$("#package_no_4").css("border", "none");
						$("#datas_form-step-0 .stepy-navigator .button-next").click();
					});
					
					$("button#submit_premium").click(function(){
						$("#sel_package_id").val('4'); 
						$("#package_no_1").css("border", "none");
						$("#package_no_2").css("border", "none");
						$("#package_no_3").css("border", "none");
						$("#package_no_4").css("border", "2px solid #339999"); 	
						$("#datas_form-step-0 .stepy-navigator .button-next").click(); 
					}); 
				});
			</script>
			
              <div class="panel registration-form">
                <div class="panel-body">
                  <div class="text-center">
                    <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                    <h5 class="content-group-lg">Create account <small class="display-block"> ilaqa CRM </small></h5>
                  </div> 
			  <input type="hidden" name="email_check_url" id="email_check_url" value="<?php echo site_url('/login/check_email_existance/'); ?>" />
				  
			   <form name="datas_form" id="datas_form" class="stepy-validation" method="post" action=""> 
			   	<input type="hidden" name="sel_package_id" id="sel_package_id" value="1" />
			    <fieldset title="1">  
					<legend class="text-semibold">Process Payment</legend>
					
					  <!-- <div class="row"> 
					  <div class="col-md-8 col-md-pull-0">
						 <div class="form-group">
						  <label for="package_id">Packages: <span class="text-danger">*</span></label>
						  <select name="package_id" id="package_id" class="form-control required select" data-error="#package_id1">
							<option value=""> Select Package </option> 						  
						   <?php  
							if(isset($packages_arrs) && count($packages_arrs)>0){
								foreach($packages_arrs as $packages_arr){
									$sel_1 = '';
									if(isset($_POST['package_id']) && $_POST['package_id']==$packages_arr->id){
										$sel_1 = 'selected="selected"';
									} ?>
								<option value="<?= $packages_arr->id; ?>" <?php echo $sel_1; ?>>
								<?php 
								$package_type_txt = '';
								if($packages_arr->package_type == 1){
									$package_type_txt = $packages_arr->duration." Day(s)";
								
								}else if($packages_arr->package_type == 2){
									$package_type_txt = $packages_arr->duration." Months(s)";
								
								}else if($packages_arr->package_type == 3){
									$package_type_txt = $packages_arr->duration." Year(s)"; 
								}  
								
								echo stripslashes($packages_arr->name) . ' ('. $package_type_txt.' @'.$packages_arr->price.' '.$conf_currency_symbol.')'; ?>
								</option>
								<?php 
								}   
							} ?>
						  </select>
						  <span id="package_id1" class="text-danger"><?php echo form_error('package_id'); ?></span> 
						</div>           
					  </div> </div> --> 
					  
					  <div class="row" style="display:none">
					  <div class="col-md-12">
						<div class="form-group"> 
						  <label>Payment Gateway: <span class="text-danger">*</span></label>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled" value="Payoneer" <?php if(isset($_POST['payment_gateway']) && $_POST['payment_gateway']=='Payoneer'){ echo 'checked="checked"'; } ?> /> Payoneer </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled" value="JazzCash" <?php if(isset($_POST['payment_gateway']) && $_POST['payment_gateway']=='JazzCash'){ echo 'checked="checked"'; } ?> /> JazzCash </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled" value="EasyPaisa" <?php if(isset($_POST['payment_gateway']) && $_POST['payment_gateway']=='EasyPaisa'){ echo 'checked="checked"'; } ?> /> EasyPaisa </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled" value="FonePay" <?php if(isset($_POST['payment_gateway']) && $_POST['payment_gateway']=='FonePay'){ echo 'checked="checked"'; } ?> /> FonePay </label>
						  </div>
						  <div class="radio">
							<label> <input type="radio" name="payment_gateway" class="styled" value="Keenu Wallet" <?php if(isset($_POST['payment_gateway']) && $_POST['payment_gateway']=='Keenu Wallet'){ echo 'checked="checked"'; } ?> /> Keenu Wallet </label>
						  </div>
						  
						  <span class="text-danger"><?php echo form_error('payment_gateway'); ?></span>
						</div>           
					  </div> 
					  </div>  
					  
					  <div id="generic_price_table" class="row">
					  <!-- <div class="col-md-12"> 
					   </div>-->
					<?php  
						$p = 1;
						if(isset($packages_arrs) && count($packages_arrs)>0){
							foreach($packages_arrs as $packages_arr){
								$sel_1 = '';
								/*if(isset($_POST['package_id']) && $_POST['package_id']==$packages_arr->id){
									$sel_1 = 'selected="selected"';
								}*/
								
								$package_type_txt = '';
								if($packages_arr->package_type == 1){
									$package_type_txt = "DAY";
								
								}else if($packages_arr->package_type == 2){
									$package_type_txt = "MON";
								
								}else if($packages_arr->package_type == 3){
									$package_type_txt = "YEAR"; 
									
								}  
								
								$price_whole_num = $packages_arr->price;
								$price_dec_num = '00';
								
								$price_arr = explode('.', $packages_arr->price);   
								if(isset($price_arr) && count($price_arr) == 2){
									$price_whole_num = $price_arr[0];
									$price_dec_num = $price_arr[1];
								} ?>
							 	
							 <div class="col-md-3"> 		 
								<div id="package_no_<?php echo $p; ?>" class="generic_content <?php echo ($p == 3) ? 'active' : ''; ?> clearfix">  
									<div class="generic_head_price clearfix">  
										<div class="generic_head_content clearfix">  
											<div class="head_bg"></div>
											<div class="head">
												<span> <?php echo stripslashes($packages_arr->name); ?> </span>
											</div>  
										</div>  
										<div class="generic_price_tag clearfix">  
											<span class="price"> 
											<?php if($p == 1){ ?> 
												  <span class="currency">Free</span>
												  <span class="month">/14 Days</span>
											<?php }else{ ?> 
													<span class="sign"><?php echo $conf_currency_symbol; ?></span>
													<span class="currency"><?php echo $price_whole_num; ?></span>
													<span class="cent">.<?php echo $price_dec_num; ?></span>
													<span class="month">/<?php echo $packages_arr->duration.' '.$package_type_txt; ?></span>
											<?php } ?> 
											</span>
										</div>  
									</div>    
					
									<div class="generic_feature_list">
									 <?php //echo stripslashes($packages_arr->description); ?> 
								<ul>
									<?php if($packages_arr->total_properties_nums >0){ ?> 
										<li><span><?php echo stripslashes($packages_arr->total_properties_nums); ?> </span> Manage up to Properties</li>
								<?php } if($packages_arr->total_contacts_nums >0){ ?> 
										<li><span><?php echo stripslashes($packages_arr->total_contacts_nums); ?> </span> Manage up to Contacts</li>
								<?php } if($packages_arr->total_owners_nums >0){ ?> 
										<li><span><?php echo stripslashes($packages_arr->total_owners_nums); ?> </span> Manage up to Owners</li>
								<?php } if($packages_arr->total_tasks_nums >0){ ?> 
										<li><span><?php echo stripslashes($packages_arr->total_tasks_nums); ?> </span> Manage up to Tasks</li>
								<?php } ?> 
									</ul>
								</div>
									 
									<div class="generic_price_btn clearfix"> 
									  <?php if($p == 1){ ?>
									  	 <button type="button" name="submit_trail" id="submit_trail" class="btn border-teal-400 text-teal-800 btn-flat btn-rounded"> &nbsp; &nbsp; Subscribe &nbsp; &nbsp; </button> 
										 <!--btn btn-danger btn-rounded-->
									  <?php }else if($p == 2){ ?>
									  	 <button type="button" name="submit_basic" id="submit_basic" class="btn border-teal-400 text-teal-800 btn-flat btn-rounded"> &nbsp; &nbsp; Subscribe &nbsp; &nbsp; </button>
									  <?php }else if($p == 3){ ?>
									  	 <button type="button" name="submit_regular" id="submit_regular" class="btn bg-teal-400 btn-rounded"> &nbsp; &nbsp; Subscribe &nbsp; &nbsp; </button>
									  <?php }else if($p == 4){ ?>
									  	 <button type="button" name="submit_premium" id="submit_premium" class="btn border-teal-400 text-teal-800 btn-flat btn-rounded"> &nbsp; &nbsp; Subscribe &nbsp; &nbsp; </button>
									  <?php } ?>
									 
									</div>  
								</div> 	
						   </div>
								
						<?php 
							$p++;
							}
						} ?> 
						
					 </div>  
					
				</fieldset>
				
				<fieldset title="2">  
				 <legend class="text-semibold">Personal info</legend> 
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="name">Name: <span class="text-danger">*</span></label>
						  <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" class="form-control" placeholder="Name" data-error="#name1"> <span id="name1" class="text-danger"><?php echo form_error('name'); ?></span> 
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="email">Email: <span class="text-danger">*</span></label>
						  <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" class="form-control" placeholder="Email Address" data-error="#email1"> <span id="name1" class="text-danger"><?php echo form_error('email'); ?></span> 
						</div>
					  </div>
					</div>
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="password">Password: <span class="text-danger">*</span></label>
						  <input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" class="form-control" placeholder="Password" data-error="#password1"> <span id="password1" class="text-danger"><?php echo form_error('password'); ?></span> 
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="conf_password">Confirm Password: <span class="text-danger">*</span></label>
						  <input type="password" name="conf_password" id="conf_password" value="<?php echo set_value('conf_password'); ?>" class="form-control" placeholder="Confirm Password" data-rule-equalTo="#password" data-error="#password2"> <span id="password2" class="text-danger"><?php echo form_error('conf_password'); ?></span>
						</div>
					  </div>
					</div>
					
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="phone_no">Phone Number:</label>
						  <input type="text" name="phone_no" id="phone_no" value="<?php echo set_value('phone_no'); ?>" class="form-control" placeholder="Phone #" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" />
						</div>
					  </div>
					  
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="mobile_no">Mobile Number: <span class="text-danger">*</span></label>
						  <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="<?php echo set_value('mobile_no'); ?>" placeholder="Mobile #" data-error="#mobile_no1" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" /> <span id="mobile_no1" class="text-danger"><?php echo form_error('mobile_no'); ?></span>
						</div>
					  </div> 
					</div>
						
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label for="company_name">Company Name: <span class="text-danger">*</span></label>
						  <input type="text" name="company_name" id="company_name" placeholder="Company Name" class="form-control" value="<?php echo set_value('company_name'); ?>" data-error="#company_name1"> <span id="company_name1" class="text-danger"><?php echo form_error('company_name'); ?></span>
						</div>
					  </div> 
					  <div class="col-md-6">
						<div class="form-group">
						  <label>No. of Employees: <span class="text-danger">*</span></label>
							<input type="text" name="no_of_employees" id="no_of_employees" placeholder="No. of Employees" class="form-control" value="<?php echo set_value('no_of_employees'); ?>" onKeyUp="this.value=this.value.replace(/\D/g,'')" onChange="this.value=this.value.replace(/\D/g,'')" />
						</div>
					  </div>
					</div>
				 </fieldset>
					   
				
					
				 <button type="submit" class="btn btn-primary stepy-finish"> Sign Up <i class="icon-check position-right"></i></button>
			  </form>
						
				  <div class="text-left"> 
				   <a href="<?php echo site_url('login/forgot_password'); ?>">Forgot password?</a>  &nbsp; | &nbsp;
				  <a href="<?php echo site_url('login/'); ?>">Sign In</a>  
				  
				  </div>
				  
                </div>
              </div>
            </div>
          </div> 
        <!-- /registration form -->
        <!-- Footer -->
         <?php $this->load->view('widgets/login_footer'); ?>
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