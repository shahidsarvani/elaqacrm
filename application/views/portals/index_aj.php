		
<table class="table datatable-button-init-custom">
 <thead>
   <tr>
    <th width="6%">#</th>
    <th width="15%">Name</th>
    <th width="20%">URL</th>
    <th width="20%" class="text-center"> No. of Properties</th>
    <th width="12%" class="text-center">Order </th>
    <th width="12%" class="text-center">Status</th>
    <th width="13%" class="text-center">Action </th>  
  </tr>
</thead> 
<tbody>
<?php
	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Portals','add',$this->dbs_user_role_id,'1'); 
				
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Portals','update',$this->dbs_user_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Portals','trash',$this->dbs_user_role_id,'1');  
    $sr=1; 
    if(isset($records) && count($records)>0){
        foreach($records as $record){ 
            $operate_url = 'portals/update/'.$record->id;
            $operate_url = site_url($operate_url);
            
            $trash_url = 'portals/trash_aj/'.$record->id;
            $trash_url = site_url($trash_url);
			
			$prtl_properties_url = 'properties/portal_properties_list/'.$record->id;
			$prtl_properties_url = site_url($prtl_properties_url); ?>
            <tr>
            <td>
                <div class="checkbox">
                <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                </div>  
            </td>
            <td class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>"><?= stripslashes($record->name); ?></td>
            <td class="text-center"><a href="<?= stripslashes($record->url_address); ?>" target="_blank">
              <?= stripslashes($record->url_address); ?>
            </a></td>
            <td class="text-center"> <a href="<?= $prtl_properties_url; ?>" target="_blank"> <strong><?php echo $this->portals_model->count_portal_assigned_properties_nums($record->id); ?></strong></a> </td>
            <td class="text-center"><?= stripslashes($record->sort_order); ?></td>
            <td class="text-center">
			<?php 
				$bg_cls ='';
				if($record->status==1){
					$bg_cls = 'label-success';
				}else{
					$bg_cls = 'label-danger';
				} ?>
              <span class="label <?php echo $bg_cls; ?>"> <?php echo ($record->status==1) ? 'Active' : 'Inactive'; ?></span></td>
              <td class="text-center"> 
                <ul class="icons-list">
			   <?php if($update_res_nums>0){ ?> 
                        <li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li> 
                <?php } 
                    if($trash_res_nums>0){ ?> 
                        <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li> 
              <?php } ?> 
                </ul>  
              </td> 
            </tr>
    <?php 
        $sr++;
        }
    }else{ ?>	
        <tr class="gradeX"> 
        <td colspan="7" class="text-center"> <strong> No Record Found! </strong></td>
        </tr>
    <?php } ?>  
  </tbody>  
</table>