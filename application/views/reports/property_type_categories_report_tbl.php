<?php 
	$vs_user_type_id = $this->session->userdata('us_role_id');  
	if($ress){ ?>
        <tr class="gradeX">
          <td></td>
          <td></td>
          <td></td>
          <td class="center"><?php echo $total_nums = $ress->CNT_NUMS;   ?></td>
          <td class="center"><?php echo ($total_nums >0) ? '100.00%' : '00.00%'; ?></td>
        </tr>
	<?php 
        } 
		$sr=1; 
		$frmt_arrs ='';
		if($records){
			foreach($records as $record){ ?>
				<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
				<td><?= $sr; ?></td>
				<td><?= ($record->property_type==1) ? 'Sale' : 'Rent'; ?></td>
				<td><?php echo  $cate_name = stripslashes($record->cate_name); ?></td>
				<td class="center"><?= stripslashes($record->NUMS); ?></td>
				<td class="center">
				<?php  
					$total_nums = $ress->CNT_NUMS;  
					$curr_nums = $record->NUMS; 
					
					if($total_nums>0 && $curr_nums>0){
						
						$percet_nums = ($curr_nums/$total_nums)*100;
						$percet_nums = number_format($percet_nums,2,".",",");
						echo $percet_nums1 = $percet_nums.'%';
						
						$clr_code = $this->general_model->get_gen_colors($sr);
						
						$propty_typ = ($record->property_type==1) ? 'Sale' : 'Rent';
						$cate_name = $propty_typ.' - '.$cate_name;
						
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
			  <td colspan="5" class="center"><strong> No Record Found! </strong></td>
			</tr>
	<?php 
		} ?>
