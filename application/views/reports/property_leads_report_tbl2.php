   
    <?php  
	$total_nums1 = 0;
    if(isset($row1) && count($row1->NUMS)>0){ ?>
        <tr class="gradeX">
            <td colspan="2"> <strong><u> Total Leads : </u> </strong></td>
            <td class="center"><?php echo $total_nums1 = $row1->NUMS;   ?></td>
            <td class="center"><?php echo ($total_nums1 >0) ? '100.00%' : '00.00%'; ?></td>
        </tr>
<?php 
}

$sr=1; 
$frmt_arrs = '';
if(isset($record1s) && count($record1s)>0){
	foreach($record1s as $record1){ ?>
		<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
		<td><?= $sr; ?></td>
		<td>
<?php 
	$propty_source_of_listing_nm =''; 
	$propty_source_of_listing = $record1->source_of_listing;
	if($propty_source_of_listing>0){  
		$propty_source_of_listing_arr = $this->admin_model->get_source_of_listing_by_id($propty_source_of_listing);
		if(isset($propty_source_of_listing_arr)){
			echo $propty_source_of_listing_nm = stripslashes($propty_source_of_listing_arr->title);
		}
	} ?></td>
            <td class="center"><?= stripslashes($record1->NUMS); ?></td>
            <td class="center"><?php     
                $curr_nums = $record1->NUMS; 
                
                if($total_nums1>0 && $curr_nums>0){
                    
                    $percet_nums = ($curr_nums/$total_nums1)*100;
                    $percet_nums = number_format($percet_nums,2,".",",");
                    echo $percet_nums1 = $percet_nums.'%';
                    
                    $clr_code = $this->general_model->get_gen_colors($sr);
                     
                    $cate_name = $propty_source_of_listing_nm;
                    
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
    
    <tr class="gradeX"> 
        <td colspan="4" class="center"> <hr>   </td>
    </tr> 
     <tr class="gradeX">
        <td colspan="2"> <strong><u> Conversion: </u> </strong></td>
        <td class="center"> <strong><?php 
        if(isset($row2)){
            $sum_nos_of_views = $row2->sum_nos_of_views;
            
            if($total_nums1>0 && $sum_nos_of_views>0){
                $conversion = ($total_nums1/$sum_nos_of_views)*100; 
                echo $conversion = number_format($conversion,2,".",",").' %';
            }else{
				echo '00.00%';
			}
        }  ?> </strong></td> 
        <td class="center"> </td>
     </tr>  
   