<?php    
    if((isset($from_date_val) && strlen($from_date_val)>0) && (isset($to_date_val) && strlen($to_date_val)>0)){ ?>
    <tr class="gradeX">
        <td> </td>
        <td class="center"> <strong>
        <?php echo date('d-M-Y',strtotime($from_date_val)).' to '.date('d-M-Y',strtotime($to_date_val));   ?></strong></td>
        <td class="center">
        <strong><?php $total_nos_meetings = $this->admin_model->get_total_custom_meetings_nums($assigned_to_id_val,$from_date_val,$to_date_val); 
        echo ($total_nos_meetings >0)? $total_nos_meetings : 0; ?></strong></td> 
         
         <td class="center">
        <strong><?php $total_nos_views = $this->admin_model->get_total_custom_views_nums($assigned_to_id_val,$from_date_val,$to_date_val); 
        echo ($total_nos_views >0)? $total_nos_views : 0; ?></strong></td> 
    </tr>
        
    <?php  
    $sr=1;  
    $nw_from_date = $from_date_val; 
    while($nw_from_date <= $to_date_val ) { 
        $nw_from_date2 = date('d-M-Y',strtotime($nw_from_date));  
         
        $total_dated_nos_meetings = $this->admin_model->get_total_dated_meetings_nums($assigned_to_id_val,$nw_from_date); 
        $total_dated_nos_views = $this->admin_model->get_total_dated_views_nums($assigned_to_id_val,$nw_from_date); 
        
        
        $total_dated_nos_meetings = ( $total_dated_nos_meetings >0) ? $total_dated_nos_meetings : 0;
        
        $total_dated_nos_views = ( $total_dated_nos_views >0) ? $total_dated_nos_views : 0;
         ?> 
        <tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
            <td><?= $sr; ?></td>
            <td class="center"><?= $nw_from_date2; ?></td> 
            <td class="center"> <?php echo $total_dated_nos_meetings; ?></td> 
            <td class="center"> <?php echo $total_dated_nos_views; ?></td>
        </tr>
     <?php  
        
        $frmt_arrs .= "{ y: \" $nw_from_date2 \", a: $total_dated_nos_meetings, b: $total_dated_nos_views },";
      
         $nw_from_date = strtotime(date("Y-m-d", strtotime($nw_from_date))." +1 day");
         $nw_from_date = date("Y-m-d",$nw_from_date);  
         $sr++; 
    }
            
        if(strlen($frmt_arrs ) >0){
            $frmt_arrs = substr($frmt_arrs,0,-1);
        }
            
    }else{ ?>	
    <tr class="gradeX"> 
        <td colspan="4" class="center"> <strong> Select From & To Data for Result! </strong> </td>
    </tr>
    <?php 
    } ?>  
 