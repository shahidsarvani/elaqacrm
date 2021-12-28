<?php  
    if($row1){  
		$total_nums = $row1->NUMS;    
    }
    
    $sr=1; 
    $frmt_arrs ='';
    if($record1s){
        foreach($record1s as $record1){ 
			 
			$propty_source_of_listing_nm =''; 
			$propty_source_of_listing = $record1->source_of_listing;
			if($propty_source_of_listing>0){  
				$propty_source_of_listing_arr = $this->admin_model->get_source_of_listing_by_id($propty_source_of_listing);
				if(isset($propty_source_of_listing_arr)){
					$propty_source_of_listing_nm = stripslashes($propty_source_of_listing_arr->title);
				}
			}
			
			$total_nums = $row1->NUMS;  
			$curr_nums = $record1->NUMS; 
                
			if($total_nums>0 && $curr_nums>0){
				
				$percet_nums = ($curr_nums/$total_nums)*100;
				$percet_nums = number_format($percet_nums,2,".",",");
				$percet_nums1 = $percet_nums.'%';
				
				$clr_code = $this->general_model->get_gen_colors($sr);
				 
				$cate_name = $propty_source_of_listing_nm;
				
				$frmt_arrs .= '{ label: "'.$cate_name.'", data:[ [1, '.$percet_nums.'] ], color: "'.$clr_code.'" },';  
			} 
				
            $sr++;
        }
        
        if(strlen($frmt_arrs ) >0){
            $frmt_arrs = substr($frmt_arrs,0,-1);
        } 
    } 
	
	echo '['.$frmt_arrs.']'; ?>