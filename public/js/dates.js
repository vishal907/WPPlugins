var body = jQuery("body"); 

/*setTimeout(function () {
    jQuery("button.single_add_to_cart_button").removeClass('disabled');
}, 800);*/
/* 
if(window.location.pathname === "/product/filet-mignon-lobster-tail/" ) {
    var meal_select_options = [
        "<option value=''>Choose an option</option>",
        "<option value='gourmet-meal-for-1' class='attached enabled'>Gourmet Meal for 1</option>"
    ];

    $('select#pa_meal-size').each(function () {
        $(this).html(meal_select_options);
        $(this).val('gourmet-meal-for-1');
        $('select#servings').val(1);
        $('select#servings').change();
    });


    body.on('change', 'select#pa_meal-size', function () {
        $("button.single_add_to_cart_button").removeClass('disabled');
        var value = $(this).val();
        if (value) {
            var number = 1;
            $('select#servings').val(number);
            $('select#servings').change();
            $(this).html(meal_select_options);
            $(this).val(value);
        }
    });
} else {
    var meal_select_options = [
        "<option value=''>Choose an option</option>",
        "<option value='gourmet-meal-for-2' class='attached enabled'>Gourmet Meal for 2</option>",
        "<option value='gourmet-meal-for-4' class='attached enabled'>Gourmet Meal for 4</option>",
        "<option value='gourmet-meal-for-6' class='attached enabled'>Gourmet Meal for 6</option>"
    ];

    $('select#pa_meal-size').each(function () {
        $(this).html(meal_select_options);
        $(this).val('gourmet-meal-for-2');
        $('select#servings').val(2);
        $('select#servings').change();
    });


    body.on('change', 'select#pa_meal-size', function () {
        $("button.single_add_to_cart_button").removeClass('disabled');
        var value = $(this).val();
        if (value) {
            var number = 2;
            if (value === 'gourmet-meal-for-4') number = 4;
            if (value === 'gourmet-meal-for-6') number = 6;
            $('select#servings').val(number);
            $('select#servings').change();
            $(this).html(meal_select_options);
            $(this).val(value);
        }
    });
} */
if (window.location.pathname === '/cart/') {
    
	
    var rc_error = jQuery('#iof-rc-wc-error');

    if(rc_error.length !== 0) {
        jQuery('.woocommerce-message').hide();
    }

    setTimeout(function () {
        jQuery("input[name='update_cart']").removeAttr("disabled");
    }, 100);

    //jQuery("[data-toggle='iof-tooltip']").tooltip();

    var maxDate = '';
    var last_selected_dates = [];
    var selected_dates = get_selected_dates();
    var all_data       = jQuery("form.woocommerce-cart-form").serialize();

    var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
    var shipping_arr = (typeof(shipping_val) != "undefined" && shipping_val !== null) ? shipping_val : 'local_pickup:24';
    var arr = shipping_arr.split(':');
    var shipping_method = arr[0];
   
    var maxDate = '';
    var last_selected_dates = [];
    var selected_dates = get_selected_dates();
    var all_data       = jQuery("form.woocommerce-cart-form").serialize();

    /*var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
   
    var shipping_arr = (typeof(shipping_val) != "undefined" && shipping_val !== null) ? shipping_val : 'local_pickup:24';
    var arr = shipping_arr.split(':');
    var shipping_method = arr[0];*/


    var zip = jQuery('#calc_shipping_postcode').val()
    jQuery.post(
        ajax_object.ajax_url,
        {
            "action": "get_all_disabled_dates",
            "selected_dates": selected_dates,
            "all_data": all_data,
            "zip": zip
        }
    )
        .done(function (data) {
            if (!data.error) {

                jQuery(".iof-datepicker").each(function () {
                    var input_element = jQuery(this);
                    var order_item_num = jQuery(this).parent().parent().prev().prev().find('.iof-order-item').val();
                    var order_item_del = jQuery(this).parent().parent().prev().prev().find('.iof-delivery-row-num').val() - 1;

                    try{
                       var date = data.selected_dates[order_item_num][order_item_del];
                    }catch(e){
                       date = '';
                    }
			   
			    	input_element.datetimepicker({
                        format: 'dddd, MMM Do YYYY',
                        allowInputToggle: true,
                        useCurrent: false,
                        defaultDate: date,
                        disabledDates: data.disabled_dates,
                        daysOfWeekDisabled: data.disabled_week_days,
                        //maxDate: data.max_date,
                        minDate: data.min_date,
                        ignoreReadonly: true,
                        debug: true
                    });

                    input_element.val(data.min_date);
                });
                var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
                if (typeof(shipping_val) != "undefined" && shipping_val !== null) {
                    // shipping methods loaded, do nothing
                } else {
                    // shipping methods not loaded, update cart
                    // if (data.zip) {
                    //     setTimeout(function () {
                    //         $('input[name=update_cart]').click();
                    //     }, 800);
                    // }
                }
            }
        })
        .fail(function (data) {
            alert('Failed to load calendar.');
        });
	
    // var cart_empty_node = $("p.cart-empty");

    // if(cart_empty_node.length === 0) {
    //     $.post(
    //         ajax_object.ajax_url,
    //         {
    //             "action": "get_all_disabled_dates",
    //             "selected_dates": selected_dates,
    //             "all_data": all_data
    //         }
    //     )
    //         .done(function (data) {
    //             if (!data.error) {
    //                 $(".iof-datepicker").each(function () {
    //                     var input_element = $(this);
    //                     var order_item_num = $(this).parent().parent().prev().prev().find('.iof-order-item').val();
    //                     var order_item_del = $(this).parent().parent().prev().prev().find('.iof-delivery-row-num').val() - 1;
    //                     var date = data.selected_dates[order_item_num][order_item_del];
    //                     input_element.datetimepicker({
    //                         format: 'dddd, MMM Do YYYY',
    //                         allowInputToggle: true,
    //                         useCurrent: false,
    //                         defaultDate: date,
    //                         disabledDates: data.disabled_dates,
    //                         daysOfWeekDisabled: data.disabled_week_days,
    //                         maxDate: data.max_date,
    //                         minDate: data.min_date,
    //                         ignoreReadonly: true
    //                     });
    //                     input_element.val(date);
    //                 });
    //                 var shipping_val = $("input:radio[name=shipping_method\\[0\\]]:checked").val();
    //                 if (typeof(shipping_val) != "undefined" && shipping_val !== null) {
    //                     // shipping methods loaded, do nothing
    //                 } else {
    //                     // shipping methods not loaded, update cart
    //                     // if (data.zip) {
    //                     //     setTimeout(function () {
    //                     //         $('input[name=update_cart]').click();
    //                     //     }, 800);
    //                     // }
    //                 }
    //             }
    //         })
    //         .fail(function (data) {
    //             alert('Failed to load calendar.');
    //         });
    // }


      body.on('propertychange keyup change input paste', 'input.qty', function () {
        var input = $(this);
        if (input.val() != '' && input.val() != input.data('old_val')) {
            input.data('old_val', input.val());
            setTimeout(function () {
                jQuery('input[name=update_cart]').click();
            }, 800);
        }
    });

    jQuery('#calc_shipping_postcode').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    

	jQuery(document).on('click', 'div.iof-datepicker', function(e) {
		

        var order_item_num = jQuery(this).parent().parent().parent().prev().prev().find('.iof-order-item').val();
        last_selected_dates[order_item_num] = jQuery('input.iof-delivery-date').val();
        selected_dates = get_selected_dates();
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "get_all_disabled_dates",
                "selected_dates": selected_dates
            }
        ).done(function (data) {

           	jQuery(".iof-datepicker").each(function () {

                    var date = moment( jQuery(this).find('input.iof-delivery-date').val(), 'dddd, MMM Do YYYY');

                  	jQuery(this).datetimepicker({
                        format: 'dddd, MMM Do YYYY',
                        allowInputToggle: true,
                        useCurrent: false,
                        defaultDate: date,
                        disabledDates: data.disabled_dates,
                        minDate: data.min_date,
                        daysOfWeekDisabled: data.disabled_week_days,
                        //maxDate: data.max_date,
                        ignoreReadonly: true
                    }).on('dp.change',function(e){

                    	var lst_to1 = [];
					    jQuery("input:text.iof-delivery-date").each(function() {
					    	if($(this).val() == ''){ lst_to1.push(0); }else{ lst_to1.push(1);	 }
					    });
                         var added=false;
                        $.map(lst_to1, function(elementOfArray, indexInArray) {
                            if (elementOfArray == 0) {
                                added = true;
                             }
                        });

					    if( added ){}else{

	                         var currentProductID = jQuery(this).find('input.iof-delivery-date').data('prodid');
                            var currentProductName = jQuery(this).find('input.iof-delivery-date').data('prodname');

                            var currentProductSideId = jQuery(this).find('input.iof-delivery-date').data('sideid');
                            var currentProductSideName = jQuery(this).find('input.iof-delivery-date').data('sidename');

                            var currentProductVegId = jQuery(this).find('input.iof-delivery-date').data('vegitableid');
                            var currentProductVegName = jQuery(this).find('input.iof-delivery-date').data('vegetablename');

                            var currentProductSaladId = jQuery(this).find('input.iof-delivery-date').data('saladid');
                            var currentProductSaladName = jQuery(this).find('input.iof-delivery-date').data('saladname');

                            var currentProductDesId = jQuery(this).find('input.iof-delivery-date').data('dessertid');
                            var currentProductDesName = jQuery(this).find('input.iof-delivery-date').data('dessertname');
                            


							const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
							const d = new Date();
							var product_arr = "";
							if( monthNames[d.getMonth()] == 'December' && ( currentProductID == 1612 || currentProductID == 5588 || currentProductID == 5711 || currentProductID == 5677 || currentProductSideId == 5588 || currentProductVegId == 5711 || currentProductDesId == 5677 || currentProductVegId == 5588 || currentProductSideId == 5711 ) ){
                        
                                if(currentProductSideId == 5588){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5711){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductDesId == 5677){
                                    var product_arr = currentProductDesName;    
                                }else if(currentProductVegId == 5588){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5711){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }
                            if( monthNames[d.getMonth()] == 'February' && ( currentProductID == 1733  ||currentProductID == 5682  ||  currentProductSideId == 5682  || currentProductVegId == 5682 ) ) {

                                if(currentProductDesId == 5682){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5682){
                                    var product_arr = currentProductVegName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

                             if( monthNames[d.getMonth()] == 'March' && ( currentProductID == 1662  ||currentProductID == 5687  || currentProductID == 5692 || currentProductSideId == 5687  || currentProductVegId == 5692 || currentProductSideId == 5692  || currentProductVegId == 5687  ) ) {


                                 if(currentProductSideId == 5687){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5692){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5687){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5692){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }

                            }
                            if( monthNames[d.getMonth()] == 'April' && ( currentProductID == 1788  ||currentProductID == 9697  || currentProductID == 5702 || currentProductSideId == 9697  || currentProductVegId == 5702 || currentProductSideId == 5702  || currentProductVegId == 9697  ) ) {

                                if(currentProductSideId == 9697){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5702){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 9697){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5702){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

                            if( monthNames[d.getMonth()] == 'May' && ( currentProductID == 1872  ||currentProductID == 5707  || currentProductID == 5711 || currentProductSideId == 5707  || currentProductVegId == 5711 || currentProductSideId == 5711  || currentProductVegId == 5707  ) ) {


                                if(currentProductSideId == 5707){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5711){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5707){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5711){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }
                            
                            if( monthNames[d.getMonth()] == 'June' && ( currentProductID == 1775  ||currentProductID == 5715  || currentProductID == 5719 || currentProductSideId == 5715  || currentProductVegId == 5719 || currentProductSideId == 5719  || currentProductVegId == 5715  ) ) {

                                if(currentProductSideId == 5715){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5719){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5715){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5719){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

                            if( monthNames[d.getMonth()] == 'July' && ( currentProductID == 1918  ||currentProductID == 5723  || currentProductSideId == 5723  || currentProductVegId == 5723  ) ) {

                                if(currentProductSideId == 5723){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5723){
                                    var product_arr = currentProductVegName;    
                                }else{
                                    var product_arr = currentProductName;
                                }


                            }

                            if( monthNames[d.getMonth()] == 'August' && ( currentProductID == 1752  ||currentProductID == 5727  || currentProductID == 5732 || currentProductSideId == 5727  || currentProductVegId == 5732 || currentProductSideId == 5732  || currentProductVegId == 5727  ) ) {

                                if(currentProductSideId == 5727){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5732){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5727){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5732){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }

                            }
                            if( monthNames[d.getMonth()] == 'September' && ( currentProductID == 1800  ||currentProductID == 5650  || currentProductID == 5646 || currentProductSideId == 5650  || currentProductVegId == 5646 || currentProductSideId == 5646  || currentProductVegId == 5650  ) ) {

                                if(currentProductSideId == 5650){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5646){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductVegId == 5650){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5646){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                                
                            }
                            if( monthNames[d.getMonth()] == 'October' && (currentProductID == 4570  ||currentProductID == 5655 ||currentProductID == 30002181849  || currentProductSideId == 5655 || currentProductVegId == 30002181849 ) ) {
                               
                                if(currentProductSideId == 5655){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 30002181849){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 30002181849){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5655){
                                    var product_arr = currentProductVegName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                                
                            }
                            //November
                            if( monthNames[d.getMonth()] == 'November' && ( currentProductID == 4574 || currentProductID == 5660 || currentProductID == 5665 || currentProductID == 5823 || currentProductSideId == 5660 || currentProductVegId == 5665 || currentProductSaladId == 5823 || currentProductVegId == 5660 || currentProductSideId == 5665 ) ){

                                if(currentProductSideId == 5660){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5665){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSaladId == 5823){
                                    var product_arr = currentProductSaladName;    
                                }else if(currentProductVegId == 5660){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5665){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    if(currentProductID == 4574){
                                        var product_arr = currentProductName;    
                                    }else if(currentProductID == 5660){
                                        var product_arr = currentProductSideName;    
                                    }else if(currentProductID == 5665){
                                        var product_arr = currentProductVegName;    
                                    }else if(currentProductID == 5823){
                                        var product_arr = currentProductSaladName;    
                                    }

                                }
                                
                            }
                             if( monthNames[d.getMonth()] == 'December' && ( currentProductID == 1612 || currentProductID == 5588 || currentProductID == 5711 || currentProductID == 5677 || currentProductSideId == 5588 || currentProductVegId == 5711 || currentProductDesId == 5677 || currentProductVegId == 5588 || currentProductSideId == 5711 ) ){
                        
                                if(currentProductSideId == 5588){
                                    var product_arr = currentProductSideName;    
                                }else if(currentProductVegId == 5711){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductDesId == 5677){
                                    var product_arr = currentProductDesName;    
                                }else if(currentProductVegId == 5588){
                                    var product_arr = currentProductVegName;    
                                }else if(currentProductSideId == 5711){
                                    var product_arr = currentProductSideName;    
                                }else{
                                    var product_arr = currentProductName;
                                }
                            }

							var selected = moment( jQuery(this).find('input.iof-delivery-date').val(), 'dddd, MMM Do YYYY'); 
					    	var tttt = new Date(selected);
							//var dataProductdatetime =  ("0" + tttt.getDate()).slice(-2) + "/" + ("0" + (tttt.getMonth() + 1)).slice(-2) + "/" + 		    tttt.getFullYear();



							var myDate = new Date();
							var firstDay = new Date(myDate.getFullYear(), myDate.getMonth(), 1);
							var lastDay = new Date(myDate.getFullYear(), myDate.getMonth() + 1, 0);
							var lastDayWithSlashes =  (lastDay.getDate()) + '/' + (lastDay.getMonth() + 1) + '/' + lastDay.getFullYear();
							var dmy = lastDayWithSlashes.split("/");
							var joindate = new Date(
							parseInt(
							    dmy[2], 10),
							    parseInt(dmy[1], 10) - 1,
							    parseInt(dmy[0], 10)
							);
							joindate.setDate(joindate.getDate() + 7);
							//var monthlySpecialLastDate =   ("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" +  joindate.getFullYear();
							if(product_arr != ""){
								if( tttt.getTime() <= joindate.getTime() ) {
									jQuery("input[name='update_cart']").removeAttr("disabled");
				                    jQuery('input[name=update_cart]').click();	 
							    }else{
									jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Monthly Special ('+product_arr+') cannot be ordered past 7 days of the upcoming month.</li></ul>');
				    				 jQuery('html, body').animate({
								        scrollTop: $(".page").offset().top
								    }, 1500);
				    				jQuery('.checkout-button').addClass("disabled");
				    				$("a.checkout-button").removeAttr("href");
							    }
							}else{
								jQuery("input[name='update_cart']").removeAttr("disabled");
		                    	jQuery('input[name=update_cart]').click();	 
							}
		    				
					    }	    
                   	
                    });
                });
            })
            .fail(function (data) {
                alert('Failed to load calendar.');
            });
        });


        /*=== LIMIT ZIP MAX NUMBERS ===*/
        var calc_shipping_postcode = jQuery('#calc_shipping_postcode').val();
        body.on("keyup paste change", "#calc_shipping_postcode", function () {
              var shipping_postcode = $(this).val().length;
               if(shipping_postcode != '' && shipping_postcode == 5){
                 //jQuery('#popup-zip-btn').trigger('click');
               }else{
                if(calc_shipping_postcode == ''){
                    jQuery('span.form-row.form-row-wide.text-center').html('Please click Update to confirm your ZIP Code entry.');   
                }else{
                    jQuery('span.form-row.form-row-wide.text-center').html('Please click Update to confirm your ZIP Code entry. <BR> <i style="font-size: 10px;text-align: left; color: red;">Changing the ZIP Code may require you to re-select your delivery date(s).</i> ');
                }
                  jQuery('a.checkout-button').addClass('disabled');
                  jQuery('a.checkout-button').attr("href","#");

               }
        });

       /* jQuery(".CBShipping button[type=submit]").click(function(e) {
            e.preventDefault();
            jQuery('#popup-zip-btn').trigger('click'); 
        });


        jQuery('#popup-zip-btn').click(function(e) {
            e.preventDefault();
            var zip = jQuery('#calc_shipping_postcode').val()
             var state = jQuery('#calc_shipping_state').val()
            jQuery.post(
                ajax_object.ajax_url,
                {
                    "action": "save_checkout_zip_code",
                    "zip": zip,
                    "state": state
                }
            )
            .done(function (data) {
              jQuery('input[name=update_cart]').click();
              location.reload(true);
              return true;         
            })
           
        });
*/
		  

    body.on("click", ".iof-add-delivery", function () {
        var button = jQuery(this);
        var num = parseInt(button.parent().parent().prev().find('.iof-delivery-row-num').val());
               
       var myCartBoxKey = jQuery(this).find('.myCartBoxKey').val();
       var myCartBoxKey_arr = [];
	    $("input:hidden.myCartBoxKey").each(function() {
	    	myCartBoxKey_arr.push(1);	
	    });

	    var lst_to = [];
	    $("input:text.iof-delivery-date").each(function() {
	    	if($(this).val() == ''){ lst_to.push(0); }else{ lst_to.push(1);	 }
	    });
	    if(myCartBoxKey_arr.length > 1){
	    	if(myCartBoxKey_arr.length == 2){
	    		var myIofDeliveryDate = 10;	
	    	}else if(myCartBoxKey_arr.length == 3){
	    		var myIofDeliveryDate = 15;	
	    	}else if(myCartBoxKey_arr.length == 4){
	    		var myIofDeliveryDate = 20;	
	    	}else if(myCartBoxKey_arr.length == 5){
	    		var myIofDeliveryDate = 25;	
	    	}else if(myCartBoxKey_arr.length == 6){
	    		var myIofDeliveryDate = 30;	
	    	}else if(myCartBoxKey_arr.length == 7){
	    		var myIofDeliveryDate = 35;	
	    	}else if(myCartBoxKey_arr.length == 8){
	    		var myIofDeliveryDate = 40;	
	    	}else if(myCartBoxKey_arr.length == 9){
	    		var myIofDeliveryDate = 45;	
	    	}
	    	
	    }else{
	    	var myIofDeliveryDate = 5;
	    }

        if(num < 5){
        	if(myIofDeliveryDate == 45){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 || lst_to[30]==0 || lst_to[31]==0 || lst_to[32]==0 || lst_to[33]==0 || lst_to[34]==0 || lst_to[35]==0 || lst_to[36]==0 || lst_to[37]==0 || lst_to[38]==0 || lst_to[39]==0  || lst_to[40]==0 || lst_to[41]==0 || lst_to[42]==0 || lst_to[43]==0 || lst_to[44]==0){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 40){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 || lst_to[30]==0 || lst_to[31]==0 || lst_to[32]==0 || lst_to[33]==0 || lst_to[34]==0 || lst_to[35]==0 || lst_to[36]==0 || lst_to[37]==0 || lst_to[38]==0 || lst_to[39]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 35){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 || lst_to[30]==0 || lst_to[31]==0 || lst_to[32]==0 || lst_to[33]==0 || lst_to[34]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 30){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 || lst_to[25]==0 || lst_to[26]==0 || lst_to[27]==0 || lst_to[28]==0 || lst_to[29]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	if(myIofDeliveryDate == 25){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 || lst_to[20]==0 || lst_to[21]==0 || lst_to[22]==0 || lst_to[23]==0 || lst_to[24]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        	if(myIofDeliveryDate == 20){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 || lst_to[15]==0 || lst_to[16]==0 || lst_to[17]==0 || lst_to[18]==0 || lst_to[19]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	
        	if(myIofDeliveryDate == 15){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 || lst_to[10]==0 || lst_to[11]==0 || lst_to[12]==0 || lst_to[13]==0 || lst_to[14]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	if(myIofDeliveryDate == 10){
        		if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 || lst_to[5]==0 || lst_to[6]==0 || lst_to[7]==0 || lst_to[8]==0 || lst_to[9]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}
        	if (myIofDeliveryDate == 5){
			    if( lst_to[0]==0 || lst_to[1]==0 || lst_to[2]==0 || lst_to[3]==0 || lst_to[4]==0 ){
			    	jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
					jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
			    }else{
			    	var btnprodid = button.data('btnprodid');
					var btnprodname = button.data('btnprodname');	
			    	addDeliveryRow(button, num + 1,btnprodid,btnprodname);	
			    	return true;		
			    }	
        	}

        }else{
           jQuery('.'+myCartBoxKey).html('<span class="text-danger">Sorry, you can only have a maximum of 5 delivery dates for all combined products.</span>');
        }

        
    });

    body.on("click", ".iof-btn-delivery-remove", function () {
        removeDeliveryRow( jQuery(this));
        adjustCartSubtotal();
        jQuery("input[name='update_cart']").removeAttr("disabled");
        setTimeout(function () {
            jQuery('input[name=update_cart]').click();
        }, 800);
    });

    body.on("click",'.checkout-button',function(){
    	var shipping_val = jQuery("input:radio[name=shipping_method\\[0\\]]:checked").val();
	    var shipping_arr = (typeof(shipping_val) != "undefined" && shipping_val !== null) ? shipping_val : 'local_pickup:24';
	    var arr = shipping_arr.split(':');
	    var shipping_method = arr[0];

	    var lst_to = [];
	    jQuery("input:text.iof-delivery-date").each(function() {
	    	if($(this).val() == ''){ lst_to.push(0); }else{ lst_to.push(1);	 }
	    });

        var added=false;
        $.map(lst_to, function(elementOfArray, indexInArray) {
            if (elementOfArray == 0) {
                added = true;
             }
        });
    
	    if(shipping_method){
	    	var checkzipcode = jQuery('#calc_shipping_postcode').val();

		    	if(checkzipcode == ""){
		    		jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please enter shipping zipcode!</li></ul>');
    				 jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
		    		jQuery('#calc_shipping_postcode').focus();
		    		return false;
		    	}else if(added ){
		    		jQuery('.woocommerce-notices-wrapper').html('<ul class="woocommerce-error" role="alert"><li>Please select delivery dates!</li></ul>');
    				 jQuery('html, body').animate({
				        scrollTop: $(".page").offset().top
				    }, 1500);
		    		jQuery("input:text:visible:first").focus();
					return false;
		    	}else{
	    			jQuery("input[name='update_cart']").removeAttr("disabled");
                    jQuery('input[name=update_cart]').click();
					return true;
		    	}
	    }
 	
    
    });

    /**
     * Adjust the subtotal in the cart.
     */
    function adjustCartSubtotal() {
        var subtotal = 0;
        var cart_subtotal_obj = jQuery("#iof-cart-subtotal").find(".amount");
        var order_items_obj = jQuery(".iof-item-subtotal");
        order_items_obj.each(function (index, element) {
            subtotal += parseFloat(jQuery(element).val());
        });
        cart_subtotal_obj.html("<span class='woocommerce-Price-currencySymbol'>$</span>" + subtotal.toFixed(2));
    }

    /**
     * Add one delivery row per item quantity.
     *
     * @param button
     * @param num
     */
   function addDeliveryRow(button, num, btnprodid,btnprodname) {
    	selected_dates = get_selected_dates();
    
    		  jQuery.post(
		            ajax_object.ajax_url,
		            {
		                "action": "get_all_disabled_dates",
		                "selected_dates": selected_dates
		            }
		        )
		            .done(function (data) {
						
		                if (!data.max_date_msg) {
		                    var order_item_num = button.children(".iof-order-item").val();
		                    var delivery_row = button.parent().parent().prev();
		                    var delivery_row_new = delivery_row.clone(true, true);
		                    var delivery_row_label_new = delivery_row_new.find(".iof-lbl-delivery-row");
		                    var delivery_calendar_name = delivery_row_new.find(".iof-delivery-date").attr("name");
		                    var delivery_calendar_new = jQuery('<div class="input-group date iof-datepicker"><input type="text"  data-prodId="'+btnprodid+'" data-prodName="'+btnprodname+'"  class="form-control iof-delivery-date"/><span class="input-group-addon"><span class="fa fa-calendar"></span></span></div>');

		                    delivery_row_label_new.removeClass("col-md-offset-4 col-lg-offset-3");
		                    delivery_row_label_new.children("strong").html("Delivery " + num);
		                    delivery_row_new.find(".iof-btn-delivery-remove").parent().removeClass("hidden");
		                    delivery_row_new.find(".iof-delivery-row-num").val(num);
		                    delivery_row_new.find(".iof-datepicker").remove();
		                    delivery_row_new.find(".form-group").html(delivery_calendar_new);
		                    delivery_calendar_new.find('.iof-delivery-date').attr("name", delivery_calendar_name);
		                    delivery_row_new.find(".iof-datepicker").attr("id", "datepicker-" + order_item_num + "-" + num);
		                    var date = data.available_dates[order_item_num];
		                    delivery_row_new.find(".iof-datepicker").datetimepicker({
		                        format: 'dddd, MMM Do YYYY',
		                        allowInputToggle: true,
		                        useCurrent: false,
		                        disabledDates: data.disabled_dates,
		                        minDate: data.available_dates[order_item_num],
		                        daysOfWeekDisabled: data.disabled_week_days,
		                        maxDate: data.max_date,
		                        ignoreReadonly: true
		                    });
		                    delivery_row.after(delivery_row_new);
							 
		                } else {
							 
		                    alert(data.max_date_msg);
		                }
		            })
		            .fail(function (data) {
		                alert('Failed to load calendar.');
		            });
    	
           
    }
	
    function addDeliveryRow1(button, num) {
        selected_dates = get_selected_dates();

        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "get_all_disabled_dates",
                "selected_dates": selected_dates
            }
        )
            .done(function (data) {
				
                if (!data.max_date_msg) {
                    var order_item_num = button.children(".iof-order-item").val();
                    var delivery_row = button.parent().parent().prev();
                    var delivery_row_new = delivery_row.clone(true, true);
                    var delivery_row_label_new = delivery_row_new.find(".iof-lbl-delivery-row");
                    var delivery_calendar_name = delivery_row_new.find(".iof-delivery-date").attr("name");
                    var delivery_calendar_new = jQuery('<div class="input-group date iof-datepicker"><input type="text" class="form-control iof-delivery-date"/><span class="input-group-addon"><span class="fa fa-calendar"></span></span></div>');

                    delivery_row_label_new.removeClass("col-md-offset-4 col-lg-offset-3");
                    delivery_row_label_new.children("strong").html("Delivery " + num);
                    delivery_row_new.find(".iof-btn-delivery-remove").parent().removeClass("hidden");
                    delivery_row_new.find(".iof-delivery-row-num").val(num);
                    delivery_row_new.find(".iof-datepicker").remove();
                    delivery_row_new.find(".form-group").html(delivery_calendar_new);
                    delivery_calendar_new.find('.iof-delivery-date').attr("name", delivery_calendar_name);
                    delivery_row_new.find(".iof-datepicker").attr("id", "datepicker-" + order_item_num + "-" + num);
                    var date = data.available_dates[order_item_num];
                    delivery_row_new.find(".iof-datepicker").datetimepicker({
                        format: 'dddd, MMM Do YYYY',
                        allowInputToggle: true,
                        useCurrent: false,
                        defaultDate: data.min_date,
                        disabledDates: data.disabled_dates,
                        minDate: data.min_date,
                        daysOfWeekDisabled: data.disabled_week_days,
                        maxDate: data.max_date,
                        ignoreReadonly: true
                    });
                    delivery_row.after(delivery_row_new);
					      var subtotal = 0;
				var cart_subtotal_obj = jQuery("#iof-cart-subtotal").find(".amount");
				var order_items_obj = jQuery(".iof-item-subtotal");
				order_items_obj.each(function (index, element) {
					subtotal += parseFloat(jQuery(element).val());
				});
				cart_subtotal_obj.html("<span class='woocommerce-Price-currencySymbol'>$</span>" + subtotal.toFixed(2));
				jQuery("input[name='update_cart']").removeAttr("disabled"); 
				jQuery('input[name=update_cart]').trigger('click');
                } else {
					 
                    alert(data.max_date_msg);
                }
            })
            .fail(function (data) {
                alert('Failed to load calendar.');
            });
    }

    /**
     * Remove a delivery row for an order item.
     *
     * @param button
     */
    function removeDeliveryRow(button) {
        var delivery_row = button.parent().parent();
        var delivery_num = delivery_row.find(".iof-delivery-row-num").val();
        
        if (delivery_row.next().hasClass("iof-row-delivery-date")) {
            var order_item_row = delivery_row.parent();
            var delivery_rows = order_item_row.find(".iof-row-delivery-date");
            for (var i = 0; i < delivery_rows.length; i++) {
                var row = delivery_rows[i];
                var input_hidden = $(row).find(".iof-delivery-row-num");
                var row_num = parseInt(input_hidden.val());
                if (row_num > delivery_num) {
                    var row_num_new = row_num - 1;
                    var row_label = $(row).find(".iof-lbl-delivery-row");
                    var row_calendar = $(row).find(".iof-datepicker");
                    var order_item_num = button.children(".iof-order-item").val();
                    input_hidden.val(row_num_new);
                    row_label.children("strong").html("Delivery " + row_num_new);
                    row_calendar.attr("id", "datepicker-" + order_item_num + "-" + row_num_new);

                }
            }
        }
        

        delivery_row.remove();
    }

    /**
     * Get the dates already selected for delivery.
     *
     * @return  An array of all selected delivery dates.
     */
    function get_selected_dates() {
        var selected_dates = [];
        jQuery(".iof-order-item-row").each(function (index, item_row) {
        	selected_dates[index] = [];
            jQuery(".iof-datepicker").each(function () {
                selected_dates[index].push(jQuery(this).find('input.iof-delivery-date').val());
            });
        });
        return selected_dates;
    }

    /**
     * Get the delivery dates, formatted with cart item keys.
     *
     * TODO: get_selected_dates can probably be refactored into this, but need to check and test all backend logic
     *
     * @return  An array of all selected delivery dates.
     */
   function get_delivery_dates() {
        var delivery_dates = [];
        jQuery("input[name='delivery-dates']").map( function() {
            delivery_dates.push( jQuery(this) );
        });
    }

}
