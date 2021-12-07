  
     
    <?php  
    $sr=1; 
    if(isset($records) && count($records)>0){
        foreach($records as $record){   ?>  
        	<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>"> 
                <td><input type="radio" name="sel_lead_id_val" id="sel_lead_id_val_<?= $sr; ?>" value="<?= $record->id; ?>" onclick="sels_chk_box_vals2(this.value);"> </td>
                <td><label for="sel_lead_id_val_<?= $sr; ?>"><?= stripslashes($record->ref_no); ?></label></td> 
                <td><?php 
                //echo stripslashes($record->types);
                if($record->is_lead==1){
                    echo 'Lead';
                }else if($record->property_type==1){
                    echo 'Sales';
                }else if($record->property_type==2){
                    echo 'Rental';
                } ?> </td>
                <td><?php echo stripslashes($record->sub_loc_name); ?></td>
                <td><?= stripslashes($record->unit_no); ?></td>
                <td><?php echo stripslashes($record->bed_title); ?></td>
                <td><?php echo stripslashes($record->cate_name); ?> </td>
                <td><?php echo CRM_CURRENCY.' '.number_format($record->price,0,".",","); ?></td>
            </tr>  
    <?php 
        $sr++;
        }   
    }else{ ?>	
         <tr> 
            <td colspan="8" class="center"> <strong> No Record Found! </strong> </td> 
         </tr>  
        <?php 
        }  ?>  
    
   <tr> 
    <td colspan="8" class="right">  <?php echo $this->ajax_pagination->create_links(); ?> </td> 
 </tr> 
  