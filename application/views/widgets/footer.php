<script>  
$(document).ready(function(){ 
	if($('.select2').length >0){ 
		$('.select2').select2({
			minimumResultsForSearch: Infinity
		});
	}
	
	if($('.select2-search').length >0){ 
		$('.select2-search').select2();
	}
});
</script>
<div class="footer text-muted"> &copy; <?php echo date('Y'); ?>. <a href="#">ilaqa CRM</a> by <a href="http://www.digitalpoin8.com/" target="_blank">DigitalPoin8</a> </div>
