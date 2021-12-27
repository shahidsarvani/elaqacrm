   
    <?php  
    if(isset($row) && count($row->NUMS)>0){ ?>
        <tr class="gradeX">
            <td colspan="2"> <strong><u> Total Leads : </u> </strong></td>
            <td class="center"><?php echo $total_nums = $row->NUMS;   ?></td>
            <td class="center"><?php echo ($total_nums >0) ? '100.00%' : '00.00%'; ?></td>
        </tr>
    <?php 
    }
    
    $sr=1; 
    $frmt_arrs ='';
    if(isset($records) && count($records)>0){
        foreach($records as $record){ ?>
            <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
            <td><?= $sr; ?></td>
            <td><?php echo $propty_typ = $record->lead_type; ?></td>
            <td class="center"><?= stripslashes($record->NUMS); ?></td>
            <td class="center"><?php  
                $total_nums = $row->NUMS;  
                $curr_nums = $record->NUMS; 
                
                if($total_nums>0 && $curr_nums>0){
                    
                    $percet_nums = ($curr_nums/$total_nums)*100;
                    $percet_nums = number_format($percet_nums,2,".",",");
                    echo $percet_nums1 = $percet_nums.'%';
                    
                    $clr_code = $this->general_model->get_gen_colors($sr);
                     
                    $cate_name = $propty_typ;
                    
                    $frmt_arrs .= "{ label: \" $cate_name \", data:[ [1, $percet_nums] ], color: \"$clr_code\" },";
                    
                    
                    
                }else{
                    echo '0.00 %';
                } ?></td>
            </tr>
    <?php 
            $sr++;
        }
        
        if(strlen($frmt_arrs ) >0){
            $frmt_arrs = substr($frmt_arrs,0,-1);
        }
        
    }else{ ?>	
    <tr class="gradeX"> 
        <td colspan="4" class="center"> <strong> No Record Found! </strong> </td>
    </tr>
    <?php 
    } ?>  
   