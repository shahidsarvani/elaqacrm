<div class="sidebar sidebar-main">
  <div class="sidebar-content"> 
<?php 
	$us_prof_img = asset_url()."images/placeholder.jpg";
	$vs_id = $this->session->userdata('us_id'); 
	$rw = $this->general_model->get_user_role_info_by_id($vs_id); 
	if(isset($rw)){
		if(strlen($rw->image)>0){
			$us_prof_img = $rw->image;
			$us_prof_img = base_url()."downloads/profile_pictures/thumbs/".$us_prof_img;
		}  
	} ?>
    <!-- User menu -->
    <div class="sidebar-user">
      <div class="category-content">
        <div class="media"> <a href="<?php echo site_url('settings/my_profile'); ?>" class="media-left"><img src="<?= $us_prof_img; ?>" class="img-circle img-sm" alt="<?php //echo $rw->name; ?>"></a>
          <div class="media-body"> <span class="media-heading text-semibold"><?php //echo $rw->name; ?></span>
            <div class="text-size-mini text-muted"> <i class="icon-pin text-size-small"></i> &nbsp;<?php //echo stripslashes($rw->address); ?> </div>
          </div> 
        </div>
      </div>
    </div>
    <!-- /user menu --> 
   <?php 
		$db_controller_name = $this->uri->segment(1);
		$db_method_name = $this->uri->segment(2);
		 
		$vs_user_type_id = $this->session->userdata('us_role_id'); ?> 
    <!-- Main navigation -->
    <div class="sidebar-category sidebar-category-visible">
      <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion"> 
          <!-- Main -->
          <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li> 
          <?php  	
            $par_modules_arrs = $this->admin_model->get_all_parent_modules('0'); 			  
            if(isset($par_modules_arrs) && count($par_modules_arrs)>0){
                foreach($par_modules_arrs as $par_modules_arr){
					$mod_id_1 = $par_modules_arr->id; 
					 
					$nums_1 = $this->general_model->get_permission_by_module_role('',$mod_id_1,$vs_user_type_id);
					if($nums_1>0){
						/*if(strlen($par_modules_arr->url_address)>0){
							 $par_link_address = $par_modules_arr->url_address;
							 $par_link_address = site_url("$par_link_address");
						}else{
							$par_link_address = "#";
						} */
						
						if(strlen($par_modules_arr->controller_name)>0){
							$par_controller_name = $par_modules_arr->controller_name; 
							$par_controller_name = strtolower($par_controller_name);  
							$par_link_address = $par_controller_name.'/index/';  
							$par_link_address = site_url("$par_link_address");
						}else{
							$par_link_address = "#";
						} ?> 
                        
						<li><a href="<?php echo $par_link_address; ?>"><i class="<?php echo $par_modules_arr->icon_name; ?>"></i> <span><?php echo $par_modules_arr->name; ?></span></a>
					 
					<?php  
					$chd_modules_arrs = $this->admin_model->get_all_parent_modules($par_modules_arr->id); 			  
					if(isset($chd_modules_arrs) && count($chd_modules_arrs)>0){ ?>
						<ul>  
						<?php 
						foreach($chd_modules_arrs as $chd_modules_arr){
							$current_controller_name = $current_method_name = ''; 
							$mod_id_2 = $chd_modules_arr->id;  
							
							$nums_2 = $this->general_model->get_permission_by_module_role('',$mod_id_2,$vs_user_type_id);
							if($nums_2>0){ 
								$current_controller_name = $chd_modules_arr->controller_name; 
								$current_controller_name = strtolower($current_controller_name);
								$current_method_name = $chd_modules_arr->method_name; 
								if(strlen($current_method_name)>0){
									$chd_link_address = $current_controller_name.'/'.strtolower($current_method_name).'/';  
								}else{
									$chd_link_address = $current_controller_name.'/index/';  
								}
								$chd_link_address = site_url("$chd_link_address");
								 
								/*if(strlen($chd_modules_arr->url_address)>0){
									 $chd_link_address = $chd_modules_arr->url_address;
									 
									 $chd_link_arr = explode('/',$chd_link_address);
									 $current_controller_name = $chd_link_arr[0];
									 $current_method_name = $chd_link_arr[1];
									 
									 $chd_link_address = site_url("$chd_link_address");
								}else{
									$chd_link_address = "#";
								}  ($db_controller_name==$current_controller_name && $db_method_name==$current_method_name) ?'class="active"':''; */ ?> 
								<li <?php echo ($db_controller_name==$current_controller_name) ?'class="active"':''; ?>><a href="<?php echo $chd_link_address; ?>"> <?php echo $chd_modules_arr->name; ?> </a></li> 
							<?php 
							}
						}  ?>
						 </ul>  
						<?php 
					}  ?> 
					</li> 
              <?php  
				}
			}
		} ?>   
           
          <!-- /page kits --> 
        </ul>
      </div>
    </div>
    <!-- /main navigation --> 
    
  </div>
</div>
