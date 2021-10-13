		
<table class="table datatable-button-init-custom">
     <thead>
      <tr>
        <th width="8%">#</th>
        <th width="50%" class="text-center">Name</th>
        <th width="22%" class="text-center">Action </th> 
      </tr>
    </thead> 
    <tbody>
    <?php 
        $sr=1; 
        if(isset($records) && count($records)>0){
            foreach($records as $record){ 
                $operate_url = 'accounts/operate_role/'.$record->id;
				$operate_url = site_url($operate_url);
				
				$trash_url = 'accounts/trash_role_aj/'.$record->id;
				$trash_url = site_url($trash_url);  ?>
                <tr>
                <td>  
                    <div class="checkbox">
                    <label for="status"> <input type="checkbox" name="multi_action_check[]" id="multi_action_check_<?php echo $record->id; ?>" value="<?php echo $record->id; ?>" class="styled"> <?php echo $sr; ?> </label>
                    </div>  
                     
                </td>
                <td><?= stripslashes($record->name); ?></td>
                <td class="text-center"> 
                   <ul class="icons-list">
                        <li class="text-primary-600"><a href="<?php echo $operate_url; ?>"><i class="icon-pencil7"></i></a></li> 
                        <li class="text-danger-600"><a href="javascript:void(0);" onClick="return operate_deletions('<?php echo $trash_url; ?>','<?php echo $record->id; ?>','dyns_list');"><i class="icon-trash"></i></a></li>  
                    </ul>  
                  </td> 
                </tr>
        <?php 
            $sr++;
            }
        }else{ ?>	
            <tr class="gradeX"> 
            <td colspan="3" class="text-center"> <strong> No Record Found! </strong></td>
            </tr>
        <?php } ?>  
      </tbody>  
    </table>