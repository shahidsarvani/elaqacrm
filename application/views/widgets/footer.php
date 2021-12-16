<script>  
$(document).ready(function(){ 
	if($('.select').length >0){ 
		$('.select').select2({
			minimumResultsForSearch: Infinity
		});
	}
	
	if($('.select2').length >0){ 
		$('.select2').select2({
			minimumResultsForSearch: Infinity
		});
	}
	
	if($('.select2-search').length >0){ 
		$('.select2-search').select2();
	}
	
	/*if($('.select2-hidden-accessible').length >0){ 
		$('.select2-hidden-accessible').select2({
			minimumResultsForSearch: Infinity
		});
	}*/
	
	if($('.picks-date').length >0){
		$('.picks-date').datepicker({
		  format: "yyyy-mm-dd",
		}).on('change', function(){
			$('.datepicker').hide();
				///operate_sale_deals();
		}); 
	} 
});
</script>
<div class="footer text-muted"> &copy; <?php echo date('Y'); ?>. <a href="#">ilaqa CRM</a> by <a href="http://www.digitalpoin8.com/" target="_blank">DigitalPoin8</a> </div>