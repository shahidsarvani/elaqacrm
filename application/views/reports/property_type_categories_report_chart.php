<?php  
	$sr=1; 
	$frmt_arrs ='';	   
	$vs_user_type_id = $this->session->userdata('us_role_id');    
	if($records){
		foreach($records as $record){ 
			$cate_name = stripslashes($record->cate_name); 
			$total_nums = $ress->CNT_NUMS;  
			$curr_nums = $record->NUMS; 
			
			if($total_nums>0 && $curr_nums>0){
				
				$percet_nums = ($curr_nums/$total_nums)*100;
				$percet_nums = number_format($percet_nums,2,".",",");
				$percet_nums1 = $percet_nums.'%';
				
				$clr_code = $this->general_model->get_gen_colors($sr);
				
				$propty_typ = ($record->property_type==1) ? 'Sale' : 'Rent';
				$cate_name = $propty_typ.' - '.$cate_name;
				
				$frmt_arrs .= '{ label: "'.$cate_name.'", data:[ [1, '.$percet_nums.'] ], color: "'.$clr_code.'" },';  
				
			}  
			
			$sr++;
		}
			
		if(strlen($frmt_arrs ) >0){
			$frmt_arrs = substr($frmt_arrs,0,-1);
		} 
	} 
	
	echo '['.$frmt_arrs.']'; ?>