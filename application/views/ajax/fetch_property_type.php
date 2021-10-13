<select name="types" id="types" data-plugin-selectTwo class="form-control populate">
  <option value="">Select </option>
  <option value="Sales" <?php if(isset($res) && $res->property_type==1){ echo 'selected="selected"'; } ?>> Sales </option>
  <option value="Rental" <?php if(isset($res) && $res->property_type==2){ echo 'selected="selected"'; } ?>> Rental </option> 
  <option value="Not Specified"> Not Specified </option>
</select>