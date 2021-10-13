
  <table class="table datatable-button-init-custom">
     <thead>
      <tr>
        <th width="6%">#</th>
        <th width="11%">Name</th>
        <th width="10%">URL</th>
        <th width="10%" class="text-center">Controller</th>
        <th width="11%" class="text-center">Add Method</th>
        <th width="11%" class="text-center">Update Method</th>
        <th width="11%" class="text-center">Delete Method</th>
        <th width="11%" class="text-center">View Method</th>
        <th width="7%" class="text-center">Orders</th>
        <th width="10%" class="text-center">Action </th> 
      </tr>
    </thead> 
    <tbody>
	<?php 
		$sr=1;  
		$par_modules_arrs = $this->admin_model->get_all_parent_modules('0'); 			  
		if(isset($par_modules_arrs) && count($par_modules_arrs)>0){
			foreach($par_modules_arrs as $par_modules_arr){
				$operate_url = 'accounts/operate_module/'.$par_modules_arr->id;
                $operate_url = site_url($operate_url);
                
                $trash_url = 'accounts/trash_module_aj/'.$par_modules_arr->id;
                $trash_url = site_url($trash_url); ?>
				   
                <tr>
                    <td>  
                        <div class="checkbox">
                        <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $par_modules_arr->id; ?>" value="<?php echo $par_modules_arr->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                        </div>  
                    </td>
                    <td><?= stripslashes($par_modules_arr->name); ?></td>
                    <td><?= stripslashes($par_modules_arr->url_address); ?></td>
                    <td class="text-center"><?= stripslashes($par_modules_arr->controller_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->add_method_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->update_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->delete_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($par_modules_arr->view_method_name);  ?></td>
                    <td class="text-center"><?= stripslashes($par_modules_arr->sort_order); ?></td>
                    <td class="text-center"> 
                       <ul class="icons-list">
                            <li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li> 
                            <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $par_modules_arr->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li>  
                        </ul>  
                      </td> 
                    </tr> 
                
			<?php  
			$sr++;
			$chd_modules_arrs = $this->admin_model->get_all_parent_modules($par_modules_arr->id); 			
			if(isset($chd_modules_arrs) && count($chd_modules_arrs)>0){
				foreach($chd_modules_arrs as $chd_modules_arr){
					$operate_url_2 = 'accounts/operate_module/'.$chd_modules_arr->id;
					$operate_url_2 = site_url($operate_url_2);
					
					$trash_url_2 = 'accounts/trash_module_aj/'.$chd_modules_arr->id;
					$trash_url_2 = site_url($trash_url_2);  ?>
					 
                    <tr>
                    <td>  
                        <div class="checkbox">
                        <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $chd_modules_arr->id; ?>" value="<?php echo $chd_modules_arr->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                        </div>  
                    </td>
                    <td> &nbsp; - &nbsp; <?= stripslashes($chd_modules_arr->name); ?></td>
                    <td><?= stripslashes($chd_modules_arr->url_address); ?></td>
                    <td class="text-center"><?= stripslashes($chd_modules_arr->controller_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->add_method_name); ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->update_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->delete_method_name);  ?></td>
                    <td class="text-center"><?php echo stripslashes($chd_modules_arr->view_method_name);  ?></td>
                    <td class="text-center"><?= stripslashes($chd_modules_arr->sort_order); ?></td>
                    <td class="text-center"> 
                       <ul class="icons-list">
                            <li class="text-primary-600"><a href="<?php echo $operate_url_2; ?>"><i class="icon-pencil7"></i></a></li> 
                            <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url_2; ?>','<?php echo $chd_modules_arr->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li>  
                        </ul>  
                      </td> 
                    </tr>
                    
				<?php  
				$sr++; 
				} 
			} 
		}
	}else{ ?>	
        <tr class="gradeX"> 
        <td colspan="10" class="text-center"> <strong> No Record Found! </strong></td>
        </tr>
    <?php } ?>  
      </tbody>  
    </table>