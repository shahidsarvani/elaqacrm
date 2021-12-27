<?php   
	$frmt_arrs ='';  
	if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){   

	
		$total_nos_meetings = $this->admin_model->get_total_custom_meetings_nums($assigned_to_id_val,$from_date_val,$to_date_val); 
		
		$total_nos_views = $this->admin_model->get_total_custom_views_nums($assigned_to_id_val,$from_date_val,$to_date_val); 
			   
		$nw_from_date = $from_date_val; 
		
		$sr = $seps = 1; 
		$date_diff ='';  
		$nw_from_date = $from_date_val; 
		
		if(strlen($to_date_val)>0 && strlen($nw_from_date)>0){	
			$date_diff = (strtotime($to_date_val)- strtotime($nw_from_date))/24/3600; 
			$seps = round($date_diff/20);
		}
		
		$tmps_dated_frmt = '';
		$tmps_total_dated_nos_meetings = $tmps_total_dated_nos_views = 0;
		$tmp_str = 0;
		$tmp_str_dt = '';
		while($nw_from_date <= $to_date_val ) { 
			$nw_from_date2 = date('d-M-Y',strtotime($nw_from_date));  
			 
			$total_dated_nos_meetings = $this->admin_model->get_total_dated_meetings_nums($assigned_to_id_val,$nw_from_date); 
			$total_dated_nos_views = $this->admin_model->get_total_dated_views_nums($assigned_to_id_val,$nw_from_date); 
			
			$total_dated_nos_meetings = ( $total_dated_nos_meetings >0) ? $total_dated_nos_meetings : 0;
			
			$total_dated_nos_views = ( $total_dated_nos_views >0) ? $total_dated_nos_views : 0;
			   	
				if($tmp_str==0){ 
					$tmp_str_dt_arr = explode('-',$nw_from_date2);
					$tmp_str_dt = $tmp_str_dt_arr[0];
				}
				
				if($date_diff >25){ 
					
					if($sr % $seps==0){
						$tmps_total_dated_nos_meetings += $total_dated_nos_meetings;
						$tmps_total_dated_nos_views += $total_dated_nos_views; 
						
						$tmp_str_frmt_dt = $tmp_str_dt.'-'.$nw_from_date2;
						
						$frmt_arrs .= '{ y: "'.$tmp_str_frmt_dt.'", a: '.$tmps_total_dated_nos_meetings.', b: '.$tmps_total_dated_nos_views.' },';
						
						$tmps_total_dated_nos_meetings = 0;
						$tmps_total_dated_nos_views = 0; 
						$tmp_str =0;
						
					}else{
						$tmp_str++;
						$tmps_total_dated_nos_meetings += $total_dated_nos_meetings;
						$tmps_total_dated_nos_views += $total_dated_nos_views; 
					}
					
				}else{
					$frmt_arrs .= '{ y: "'.$nw_from_date2.'", a: '.$total_dated_nos_meetings.', b: '.$total_dated_nos_views.' },'; 
				}
		  
			 $nw_from_date = strtotime(date("Y-m-d", strtotime($nw_from_date))." +1 day");
			 $nw_from_date = date("Y-m-d",$nw_from_date);  
			 $sr++; 
			
		}
				
		if(strlen($frmt_arrs ) >0){
			$frmt_arrs = substr($frmt_arrs,0,-1);
		}
	} 
	
	echo '['.$frmt_arrs.']'; ?> 