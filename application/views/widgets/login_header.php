<div class="navbar navbar-inverse">
<?php  
	$logos_img = base_url()."assets/images/logo.png"; 
	$rws = $this->general_model->get_configuration(); 
	if(isset($rws)){
		if(strlen($rws->image)>0){
			$logos_img = $rws->image;
			$logos_img = base_url()."assets/images/".$logos_img;
		}  
	} ?> 
    
  <div class="navbar-header"> <a class="navbar-brand" href="<?= site_url();?>"><img src="<?php echo $logos_img; ?>" alt="Ilaqa CRM Logo"></a>
    <ul class="nav navbar-nav pull-right visible-xs-block" style="display:none">
      <li style="display:none"><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
    </ul>
  </div>
  <div class="navbar-collapse collapse" id="navbar-mobile" style="display:none">
    <ul class="nav navbar-nav navbar-right" style="display:none">
      <li style="display:none"> <a href="#"> <i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Go to website</span> </a> </li>
      <li style="display:none"> <a href="#"> <i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Contact admin</span> </a> </li>
      <li style="display:none" class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-cog3"></i> <span class="visible-xs-inline-block position-right"> Options</span> </a> </li>
    </ul>
  </div>
</div>