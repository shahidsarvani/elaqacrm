<div class="navbar navbar-inverse">
<?php  
	$logos_img = base_url()."assets/images/logo.png"; 
	$rws = $this->general_model->get_configuration(); 
	if(isset($rws)){
		if(strlen($rws->image)>0){
			$logos_img = $rws->image;
			$logos_img = base_url()."downloads/site_logo/thumbs/".$logos_img;
		}  
	} ?> 
        
  <div class="navbar-header"> <a href="<?= site_url();?>" class="navbar-brand"><img src="<?= $logos_img; ?>" alt="Ilaqa CRM Logo"></a>
    <ul class="nav navbar-nav visible-xs-block">
      <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
      <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
    </ul>
  </div>
  <div class="navbar-collapse collapse" id="navbar-mobile">
     <ul class="navbar-nav" style="margin-top:10px;">
      <li class="nav-item" style="list-style:none"> <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block"> <i class="icon-paragraph-justify3"></i> </a> </li>
	  </ul>
     
    <ul class="nav navbar-nav navbar-right"> 
      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-bubbles4"></i> <span class="visible-xs-inline-block position-right">Messages</span> <span class="badge bg-warning-400">2</span> </a>
        <div class="dropdown-menu dropdown-content width-350">
          <div class="dropdown-content-heading"> Messages
            <ul class="icons-list">
              <li><a href="#"><i class="icon-compose"></i></a></li>
            </ul>
          </div>
          <ul class="media-list dropdown-content-body">
            <li class="media">
              <div class="media-left"> <img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""> <span class="badge bg-danger-400 media-badge">5</span> </div>
              <div class="media-body"> <a href="#" class="media-heading"> <span class="text-semibold">James Alexander</span> <span class="media-annotation pull-right">04:58</span> </a> <span class="text-muted">who knows, maybe that would be the best thing for me...</span> </div>
            </li>
            <li class="media">
              <div class="media-left"> <img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""> <span class="badge bg-danger-400 media-badge">4</span> </div>
              <div class="media-body"> <a href="#" class="media-heading"> <span class="text-semibold">Margo Baker</span> <span class="media-annotation pull-right">12:16</span> </a> <span class="text-muted">That was something he was unable to do because...</span> </div>
            </li>
            <li class="media">
              <div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
              <div class="media-body"> <a href="#" class="media-heading"> <span class="text-semibold">Jeremy Victorino</span> <span class="media-annotation pull-right">22:48</span> </a> <span class="text-muted">But that would be extremely strained and suspicious...</span> </div>
            </li>
            <li class="media">
              <div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
              <div class="media-body"> <a href="#" class="media-heading"> <span class="text-semibold">Beatrix Diaz</span> <span class="media-annotation pull-right">Tue</span> </a> <span class="text-muted">What a strenuous career it is that I've chosen...</span> </div>
            </li>
            <li class="media">
              <div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
              <div class="media-body"> <a href="#" class="media-heading"> <span class="text-semibold">Richard Vango</span> <span class="media-annotation pull-right">Mon</span> </a> <span class="text-muted">Other travelling salesmen live a life of luxury...</span> </div>
            </li>
          </ul>
          <div class="dropdown-content-footer"> <a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a> </div>
        </div>
      </li>
      <?php 
		$us_prof_img = asset_url()."images/placeholder.jpg";
		$vs_id = $this->session->userdata('us_id'); 
		$vs_role_id = $this->session->userdata('us_role_id');
		
		$rw = $this->general_model->get_user_role_info_by_id($vs_id); 
		if(isset($rw)){
			if(strlen($rw->image)>0){
				$us_prof_img = $rw->image;
				$us_prof_img = base_url()."downloads/profile_pictures/thumbs/".$us_prof_img;
			}  
		} ?>
        
      <li class="dropdown dropdown-user"> <a class="dropdown-toggle" data-toggle="dropdown"> <img src="<?= $us_prof_img;?>" alt="<?php //echo $rw->name; ?>" class="img-circle img-sm" /> <span><?php //echo $rw->name; ?></span> <i class="caret"></i> </a>
        <ul class="dropdown-menu dropdown-menu-right" style="position:inherit">
          <li><a href="<?php echo site_url('settings/my_profile'); ?>"><i class="icon-user-plus"></i> My Profile</a></li>
          <li><a href="<?php echo site_url('settings/change_password'); ?>"><i class="icon-coins"></i> Change Password</a></li>  
          <?php if($vs_id==1){ ?>
         		 <li><a href="<?php echo site_url('settings/config'); ?>"><i class="icon-wrench"></i> Configuration</a></li>
          <?php } ?>
          <li><a href="<?php echo site_url('settings/logoff'); ?>"><i class="icon-switch2"></i> Logoff</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
