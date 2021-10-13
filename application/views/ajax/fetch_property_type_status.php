 
	<?php if(isset($property_type) && $property_type==2){ ?> 
        <select name="property_status" id="property_status" data-plugin-selectTwo class="form-control populate">
          <option value="">Select </option> 
          <option value="3"> Available </option>
          <option value="2"> Rented </option> 
          <option value="4"> Upcoming </option>  
        </select> 
    <?php }else{ ?> 
        <select name="property_status" id="property_status" data-plugin-selectTwo class="form-control populate">
          <option value="">Select </option>
          <option value="3"> Available </option>
          <option value="1"> Sold </option> 
        </select> 
<?php } ?>  