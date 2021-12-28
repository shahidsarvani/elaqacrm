<?php  
    if($row){  
		$total_nums = $row->NUMS;    
    }
    
    $sr=1; 
    $frmt_arrs ='';
    if($records){
        foreach($records as $record){ 
			$propty_typ = $record->lead_type; 
			   
			$total_nums = $row->NUMS;  
			$curr_nums = $record->NUMS; 
                
			if($total_nums>0 && $curr_nums>0){
				
				$percet_nums = ($curr_nums/$total_nums)*100;
				$percet_nums = number_format($percet_nums,2,".",",");
				$percet_nums1 = $percet_nums.'%';
				
				$clr_code = $this->general_model->get_gen_colors($sr);
				 
				$cate_name = $propty_typ;
				
				$frmt_arrs .= '{ label: "'.$cate_name.'", data:[ [1, '.$percet_nums.'] ], color: "'.$clr_code.'" },';  
			} 
				
            $sr++;
        }
        
        if(strlen($frmt_arrs ) >0){
            $frmt_arrs = substr($frmt_arrs,0,-1);
        } 
    } 
	
	echo '['.$frmt_arrs.']'; ?>