(function( $wcfew ) {

	$wcfew(function() {
       if ($wcfew('.wcfew-datepicker').length) {
		 $wcfew('.wcfew-datepicker').datepicker({
           dateFormat : 'dd-mm-yy'
       });
	   }
	   var dateToday = new Date(); 
	   if ($wcfew('.wcfew-datepicker-disable-past').length) {
		 $wcfew('.wcfew-datepicker-disable-past').datepicker({
           dateFormat : 'dd-mm-yy',
		   minDate: dateToday
       });
	   }
	   
    });
   	
    $wcfew(function() {
	 
	 if ($wcfew('.wcfew-multiselect').length) {
		 $wcfew('.wcfew-multiselect').chosen();
	 }
	 
	 if ($wcfew('.wcfew-singleselect').length) {
		 $wcfew('.wcfew-singleselect').chosen();
	 }
      
    });
})(jQuery);