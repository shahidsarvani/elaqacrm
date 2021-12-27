<?php  
	$sr=1; 
	$frmt_arrs ='';	   
	$vs_user_type_id = $this->session->userdata('us_user_type_id');    
	if(isset($record1s) && count($record1s)>0){
		foreach($record1s as $record1){ 
			$s_title = stripslashes($record1->s_title); 
			$total_nums = $ress1->CNT_NUMS;  
			$curr_nums = $record1->NUMS; 
			
			if($total_nums>0 && $curr_nums>0){
				
				$percet_nums = ($curr_nums/$total_nums)*100;
				$percet_nums = number_format($percet_nums,2,".",",");
				$percet_nums1 = $percet_nums.'%';
				
				$clr_code = $this->general_model->get_gen_colors($sr);
				
				$propty_typ = ($record1->property_type==1) ? 'Sale' : 'Rent';
				$s_title = $propty_typ.' - '.$s_title;
				
				$frmt_arrs .= '{ label: "'.$s_title.'", data:[ [1, '.$percet_nums.'] ], color: "'.$clr_code.'" },';  
				
			}  
			
			$sr++;
		}
			
		if(strlen($frmt_arrs ) >0){
			$frmt_arrs = substr($frmt_arrs,0,-1);
		} 
	} 
	
	echo '['.$frmt_arrs.']'; ?>
