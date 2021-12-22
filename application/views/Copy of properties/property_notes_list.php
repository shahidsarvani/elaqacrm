
<?php  
	if(isset($nt_arrs) && count($nt_arrs)>0){
		foreach($nt_arrs as $nt_arr){ ?> 	  
            <li class="media">
               <div class="media-left"> 
               <u><i> <?php 
                    $dbs_user_id = $nt_arr->user_id;
                    if($dbs_user_id>0){
                        $usr_arr =  $this->general_model->get_user_info_by_id($dbs_user_id);
                        echo stripslashes($usr_arr->name);
                    }  ?> 
                    </i> </u> </div> 
              <div class="media-body">
                <div class="media-content"><?= stripslashes($nt_arr->notes); ?></div>
                <span class="media-annotation display-block mt-10"><?php echo date('d F, Y',strtotime($nt_arr->datatimes)); ?>  </span> </div>
            </li> 
		<?php 
		}
	} ?>