<table class="table datatable-button-init-custom">
 <thead>
  <tr>
    <th width="6%">#</th> 
    <th width="40%">Location Name</th>
    <th width="15%" class="text-center">Emirate</th>
    <th width="14%" class="text-center">Status</th>
    <th width="15%" class="text-center">Action</th>
  </tr>
</thead>
 <tbody>
<?php 
	$add_res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','add',$this->dbs_user_role_id,'1'); 
				
	$update_res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','update',$this->dbs_user_role_id,'1');   
	
	$trash_res_nums =  $this->general_model->check_controller_method_permission_access('Emirates_location','trash',$this->dbs_user_role_id,'1');  
	
    $sr=1; 
    if(isset($records) && count($records)>0){
        foreach($records as $record){ 
            $operate_url = 'emirates_location/update/'.$record->id;
            $operate_url = site_url($operate_url);
             
            $trash_url = site_url('emirates_location/trash_aj/'); ?>
            <tr>
            <td>
            <div class="checkbox">
            <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?>   </label>
            </div>  
            </td>
            <td><?= stripslashes($record->name); ?></td>
            <td class="text-center"><?= stripslashes($record->emirate_name); ?></td>
            <td class="text-center">
            <?php 
                $bg_cls ='';
                if($record->status==1){
                    $bg_cls = 'label-success';
                }else{
                    $bg_cls = 'label-danger';
                } ?>
                <span class="label <?php echo $bg_cls; ?>"> <?php echo ($record->status==1) ? 'Active' : 'Inactive'; ?> </span> </td>  
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
            <td colspan="5" class="text-center"> <strong> No Record Found! </strong> </td>
        </tr>
    <?php } ?>  
    </tbody>
    </table>