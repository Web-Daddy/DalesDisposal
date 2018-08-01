jQuery(document).ready(function(wcfew) {
var wcfewcheckoutfield = wcfew(".checkoutfield");

wcfew("#add-billing-field").on("click", function () {
   var wcfewnewPanel = wcfewcheckoutfield.clone();
    wcfewnewPanel.find(".collapse").removeClass("in");
    wcfewnewPanel.find(".accordion-toggle").attr("href", "#wcfew" + (hash));
    wcfewnewPanel.find(".new-field-label").append(wcfewadmin.checkoutfieldtext4 + hash);
		
	wcfewnewPanel.find(".checkoutfield").attr("id", "wcfew_list_items_" + (hash));
	wcfewnewPanel.find(".panel-collapse").attr("id", "wcfew" + (hash));
	 
         var randomnumber=Math.floor(Math.random()*1000);


    
	wcfewnewPanel.find(".checkout_field_type").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][type]");
	wcfewnewPanel.find(".checkout_field_label").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][label]");
	wcfewnewPanel.find(".checkout_field_label").attr("value", "" + wcfewadmin.checkoutfieldtext4 + hash + "");     
	wcfewnewPanel.find(".checkout_field_width").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][width]");
	wcfewnewPanel.find(".checkout_field_required").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][required]");
	
	wcfewnewPanel.find(".checkout_field_clear").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][clear]");
	wcfewnewPanel.find(".checkout_field_placeholder").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][placeholder]");
	wcfewnewPanel.find(".checkout_field_options").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][options]");
	wcfewnewPanel.find(".checkout_field_visibility").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][visibility]");
	wcfewnewPanel.find(".checkout_field_products").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber+ "][products][]");
	wcfewnewPanel.find(".checkout_field_category").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber+ "][category][]");
	wcfewnewPanel.find(".checkout_field_validate").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber+ "][validate][]");
	wcfewnewPanel.find(".checkout_field_orderedition").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][orderedition]");
	wcfewnewPanel.find(".checkout_field_emailfields").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][emailfields]");
	
	wcfewnewPanel.find(".checkout_field_disable_past_dates").attr("name", "wcfew_billing_settings[" + wcfewadmin.checkoutfieldtext + randomnumber + "][disable_past]");
	
	wcfewnewPanel.find(".checkout_field_width").chosen({width: "250px","disable_search": true});
	wcfewnewPanel.find(".checkout_field_visibility").chosen({width: "250px","disable_search": true});
	wcfewnewPanel.find(".row-validate-multiselect").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_type").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_validate").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_products").chosen({width: "400px" }); 
    wcfewnewPanel.find(".checkout_field_category").chosen({width: "400px" }); 
	
	wcfew("#accordion").append(wcfewnewPanel.fadeIn());
	hash++;
	
});

wcfew("#add-shipping-field").on("click", function () {
   var wcfewnewPanel = wcfewcheckoutfield.clone();
   wcfewnewPanel.find(".collapse").removeClass("in");
   wcfewnewPanel.find(".accordion-toggle").attr("href", "#wcfew" + (hash));
   wcfewnewPanel.find(".new-field-label").append(wcfewadmin.checkoutfieldtext5 + hash);
    
		
	wcfewnewPanel.find(".checkoutfield").attr("id", "wcfew_list_items_" + (hash));
	wcfewnewPanel.find(".panel-collapse").attr("id", "wcfew" + (hash));
	
        var randomnumber2=Math.floor(Math.random()*1000);
        
	wcfewnewPanel.find(".checkout_field_type").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][type]");
	wcfewnewPanel.find(".checkout_field_label").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][label]");
	wcfewnewPanel.find(".checkout_field_label").attr("value", "" + wcfewadmin.checkoutfieldtext5 + hash + "");
	wcfewnewPanel.find(".checkout_field_width").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][width]");
	wcfewnewPanel.find(".checkout_field_required").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][required]");
	
	wcfewnewPanel.find(".checkout_field_clear").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][clear]");
	wcfewnewPanel.find(".checkout_field_placeholder").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][placeholder]");
	wcfewnewPanel.find(".checkout_field_options").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][options]");
	wcfewnewPanel.find(".checkout_field_visibility").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][visibility]");
	wcfewnewPanel.find(".checkout_field_products").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][products][]");
	wcfewnewPanel.find(".checkout_field_category").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][category][]");
	wcfewnewPanel.find(".checkout_field_validate").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][validate][]");
	wcfewnewPanel.find(".checkout_field_orderedition").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][orderedition]");
	wcfewnewPanel.find(".checkout_field_emailfields").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][emailfields]");
	
	wcfewnewPanel.find(".checkout_field_disable_past_dates").attr("name", "wcfew_shipping_settings[" + wcfewadmin.checkoutfieldtext2 + randomnumber2 + "][disable_past]");
	
	wcfewnewPanel.find(".checkout_field_width").chosen({width: "250px","disable_search": true});
	wcfewnewPanel.find(".checkout_field_visibility").chosen({width: "250px","disable_search": true});
	wcfewnewPanel.find(".row-validate-multiselect").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_type").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_validate").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_products").chosen({width: "400px" }); 
    wcfewnewPanel.find(".checkout_field_category").chosen({width: "400px" }); 
	
	wcfew("#accordion").append(wcfewnewPanel.fadeIn());
	hash++;
	
});


wcfew("#add-additional-field").on("click", function () {
   var wcfewnewPanel = wcfewcheckoutfield.clone();
    wcfewnewPanel.find(".collapse").removeClass("in");
    wcfewnewPanel.find(".accordion-toggle").attr("href", "#wcfew" + (hash));
    wcfewnewPanel.find(".new-field-label").append(wcfewadmin.checkoutfieldtext6 + hash);
    
		
	wcfewnewPanel.find(".checkoutfield").attr("id", "wcfew_list_items_" + (hash));
	wcfewnewPanel.find(".panel-collapse").attr("id", "wcfew" + (hash));
	
        var randomnumber3=Math.floor(Math.random()*1000);
        
	wcfewnewPanel.find(".checkout_field_type").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][type]");
	wcfewnewPanel.find(".checkout_field_label").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][label]");
	wcfewnewPanel.find(".checkout_field_label").attr("value", "" + wcfewadmin.checkoutfieldtext6 + hash + "");
	wcfewnewPanel.find(".checkout_field_width").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][width]");
	wcfewnewPanel.find(".checkout_field_required").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][required]");
	
	wcfewnewPanel.find(".checkout_field_clear").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][clear]");
	wcfewnewPanel.find(".checkout_field_placeholder").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][placeholder]");
	wcfewnewPanel.find(".checkout_field_options").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][options]");
	wcfewnewPanel.find(".checkout_field_visibility").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][visibility]");
	wcfewnewPanel.find(".checkout_field_products").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][products][]");
	wcfewnewPanel.find(".checkout_field_category").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][category][]");
	wcfewnewPanel.find(".checkout_field_validate").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][validate][]");
	wcfewnewPanel.find(".checkout_field_orderedition").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][orderedition]");
	wcfewnewPanel.find(".checkout_field_emailfields").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][emailfields]");
	
	wcfewnewPanel.find(".checkout_field_disable_past_dates").attr("name", "wcfew_additional_settings[" + wcfewadmin.checkoutfieldtext3 + randomnumber3 + "][disable_past]");
	
	wcfewnewPanel.find(".checkout_field_width").chosen({width: "250px","disable_search": true});
	wcfewnewPanel.find(".checkout_field_visibility").chosen({width: "250px","disable_search": true});
	wcfewnewPanel.find(".row-validate-multiselect").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_type").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_validate").chosen({width: "250px"});
	wcfewnewPanel.find(".checkout_field_products").chosen({width: "400px" }); 
    wcfewnewPanel.find(".checkout_field_category").chosen({width: "400px" }); 
	
	wcfew("#accordion").append(wcfewnewPanel.fadeIn());
	hash++;
	
});


wcfew(".wcfew-sortable-list").sortable({
    items   : '.wcfew_list_item',
    opacity : 0.7,
	cursor  : 'move',
	
});

wcfew(function() {
wcfew('.checkout_field_type').live('change',function(){
    var typevalue = $(this).val();
	if (typevalue == "datepicker") {
		$(this).parents('table:eq(0)').find('.disable_datepicker_tr').show();
	} else {
		$(this).parents('table:eq(0)').find('.disable_datepicker_tr').hide();
	}
});
});

wcfew(function() {
wcfew('.checkout_field_visibility').live('change',function(){
    var visibilityvalue = $(this).val();
	if (visibilityvalue == "product-specific") {
		$(this).parents('table:eq(0)').find('.checkout_field_products_tr').show();
		$(this).parents('table:eq(0)').find('.checkout_field_category_tr').hide();
	} else if (visibilityvalue == "category-specific") {
		$(this).parents('table:eq(0)').find('.checkout_field_category_tr').show();
		$(this).parents('table:eq(0)').find('.checkout_field_products_tr').hide();
	} else {
		$(this).parents('table:eq(0)').find('.checkout_field_category_tr').hide();
		$(this).parents('table:eq(0)').find('.checkout_field_products_tr').hide();
	}
});
});


wcfew(document).on('click', '.glyphicon-remove-circle', function () {

   var result = confirm(wcfewadmin.removealert);
   if (result==true) {
     wcfew(this).parents('.panel').get(0).remove();
   }
   });

wcfew("#restore-billing-fields").click(function() {
   var result2 = confirm(wcfewadmin.restorealert);
   if (result2 == true) {
     
     wcfew.ajax({
            data: {action: "restore_billing_fields" },
            type: 'POST',
            url: ajaxurl,
            success: function( response ) { 
			  window.location.reload();
			}
        });
   }
});

wcfew("#restore-shipping-fields").click(function() {
   var result3 = confirm(wcfewadmin.restorealert);
   if (result3 == true) {
     
     wcfew.ajax({
            data: {action: "restore_shipping_fields" },
            type: 'POST',
            url: ajaxurl,
            success: function( response ) { 
			  window.location.reload();
			}
        });
   }
});
});



