    Array.prototype.filterAssoc = function(callback) {
        var a = this.slice();
        a.map(function(v, k, a) {
            if(!callback(v, k, a)) delete a[k];
        });
        return a;
    };
    

    jQuery(document).on('click', 'a.show_me_how', function() {
        jQuery('.yourMeals').css('display','block');
    });
    jQuery(document).on('click', 'button.close', function() {
        jQuery('.yourMeals').css('display','none');
    });
  

   // Popup Modal of sides

    jQuery(document).on('click', '.AllinonePopup #btn-side', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var side_title = jQuery(".sides_radio_buttons input:checked").val();
    	 var side_id    = jQuery(".sides_radio_buttons input:checked").next("input[name='side-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof side_id === "undefined") {}else{
    			if(jQuery.isNumeric(side_id)){
                    var myMealChoice = side_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-sideId='+side_id+' data-sideName="'+side_title+'" name="_Side" value="'+side_title+'">';
	    			
	             	jQuery(this).find('td.side-title'+choice_id+meal_id).html(myMealChoice);
	         	} 
	         }
        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-vegetable', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var vegetable_title = jQuery(".vegetables_radio_buttons input:checked").val();
    	 var vegetable_id    = jQuery(".vegetables_radio_buttons input:checked").next("input[name='vegetable-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof vegetable_id === "undefined") {}else{
    			if(jQuery.isNumeric(vegetable_id)){
                    var myMealChoice = vegetable_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-vegId='+vegetable_id+' data-vegName="'+vegetable_title+'"  name="_Vegetable" value="'+vegetable_title+'">';
		             jQuery(this).find('td.vegetable-title'+choice_id+meal_id).html(myMealChoice);
         		}
         	}
        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-salad', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
    	 var choice_id    =   jQuery(this).data('choiceid');
    	 var salad_title = jQuery(".salads_radio_buttons input:checked").val();
    	 var salad_id    = jQuery(".salads_radio_buttons input:checked").next("input[name='salad-id-choice']").val();

    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof salad_id === "undefined") {}else{
	    		if(jQuery.isNumeric(salad_id)){
                    var myMealChoice = salad_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-saladId='+salad_id+' data-saladName="'+salad_title+'" name="_Salad" value="'+salad_title+'">';
		             jQuery(this).find('td.salad-title'+choice_id+meal_id).html(myMealChoice);
	         	}
	         }
        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-bread', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var bread_title = jQuery(".breads_radio_buttons_rc input:checked").val();
    	 var bread_id    = jQuery(".breads_radio_buttons_rc input:checked").next("input[name='bread-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof bread_id === "undefined") {}else{
    			if(jQuery.isNumeric(bread_id)){
                    var myMealChoice = dessert_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" data-dessertId='+dessert_id+' data-dessertName="'+dessert_title+'"  name="_Dessert" value="'+dessert_title+'">';
	             	jQuery(this).find('td.bread-title'+choice_id+meal_id).html(myMealChoice);	
	    		}
    		}

        });
	
    });

    jQuery(document).on('click', '.AllinonePopup #btn-dessert', function(e) {
    	e.preventDefault();
    	 var meal_id    =   jQuery(this).data('mealid');
          var choice_id    =   jQuery(this).data('choiceid');
    	 var dessert_title = jQuery(".desserts_radio_buttons input:checked").val();
    	 var dessert_id    = jQuery(".desserts_radio_buttons input:checked").next("input[name='dessert-id-choice']").val();
    	jQuery(".rcSides tr.iofSidesDetails").each(function(){
    		if (typeof dessert_id === "undefined") {}else{
    			if(jQuery.isNumeric(dessert_id)){
	    			var myMealChoice = dessert_title + '<input type="hidden" class="_meal_side_'+choice_id+meal_id+'" name="_Dessert" value="'+dessert_title+'">';
	             	jQuery(this).find('td.dessert-title'+choice_id+meal_id).html(myMealChoice);
             	}
         	}
        });
	
    });
  

    jQuery(document).on('click', '.AllinonePopup .thumbnail', function() {
        if(! jQuery(this).hasClass('item-selected') ) {
            var old_selected = jQuery(this).closest(".modal-body").find(".item-selected");
            old_selected.find('label').html('');
            old_selected.find('input[type=radio]').attr('checked', false);
            old_selected.removeClass('item-selected');
            jQuery(this).addClass('item-selected');
            jQuery(this).find('input[type=radio]').attr('checked', true);
            jQuery(this).find('label').html('<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>');
        }
    });

    // End JS
        
    jQuery('form#recipient_code_form').on('submit', function(e) {
        e.preventDefault();
        var recipient_code = jQuery(this).find('input#recipient_code').val();
        jQuery(this).find('p#recipient_message').slideUp();
        jQuery(this).find('button[type=submit]').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "verify_recipient_code",
                "recipient_code": recipient_code
            }
        )
        .done(function(data) {
            display_recipient_message(data.status, false);
            jQuery('div#recipient_code_container').after(data.data);
        })
        .fail(function(data) {
            var response = data.responseText;
            response = jQuery.parseJSON(response);
            if(response) {
                display_recipient_message(response.error, true);
            } else {
                display_recipient_message('Unexpected error occurred!', true);
            }

        });
    });


    jQuery(document).on('click','button.addMyWalletBtn',function(){
  
        var recipient_code = jQuery('#recipient_code').val();
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "add_to_rc_wallet",
                "recipient_code": recipient_code
            }
        ).done(function(data) {
            jQuery('div#recipient_code_container').after(data.data);
            setTimeout(function(){     jQuery('.myWalletMsg').fadeOut('slow');  }, 1500);
        }).fail(function(data) {

        });

    });

    jQuery(document).on('click','button#logingRegister',function(){
        var recipient_code = jQuery('#recipient_code').val();
        jQuery('#loginRegisterModalPopup .woocommerce-form-login__submit').before('<input type="hidden" id="pop_recipient_code" name="pop_recipient_code" value="'+recipient_code+'">');
        jQuery('#loginRegisterModalPopup .woocommerce-form-register__submit').before('<input type="hidden" id="pop_recipient_code" name="pop_recipient_code" value="'+recipient_code+'">');
    });


    jQuery('#myTabs a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
    });

	body.on('click', '#RCTab li a', function(e) {
    	jQuery('div.devThum.item-selected').each(function(i, obj) {
    		jQuery(this).find('input[type=checkbox]').click();
            jQuery(this).find('input[type=number]').attr('disabled', false);
            jQuery(this).removeClass('item-selected');
		});
    	var choiceID = jQuery(this).attr('data-choiceid');
    	var num_delivery = jQuery('input[name=_num_delivery_' + choiceID + ']').val();
        var my_num_qty = jQuery('input[name=_num_qty_' + choiceID + ']').val(); 
        var myPendingDateDelivery = parseInt(num_delivery) - parseInt(my_num_qty);
        var myPendingDelivery = '('+( (myPendingDateDelivery != 0)?myPendingDateDelivery:'NaN' )+')';
        jQuery('span.totalOrderPending').html(myPendingDelivery);
	});

    jQuery(document).on('click', 'a.pick_btn_toggle', function(e) {
        e.preventDefault();
        var meal_id = jQuery(this).data('meal_id');
        var item_id = jQuery(this).data('item_id');

        switch_meal_selection_toggle(e, meal_id, item_id, false,0);
    });

    jQuery(document).on('click', 'input[type=checkbox]', function(e) {
        var meal_id = jQuery(this).data('meal_id');
        var item_id = jQuery(this).data('item_id');
   
        switch_meal_selection_toggle(e, meal_id, item_id, true,1);
    });

    var deliveries = {};
    var deliveries_count = 0;
    jQuery(document).on('click', 'button.add_meals_delivery', function() {
		
        var item_id = jQuery(this).data('item_id');
        var deliveries_limit = parseInt(jQuery('div.choice_container_' + item_id).find('input[name=_num_delivery_' + item_id + ']').val());
        var deliveries_qty = parseInt(jQuery('div.choice_container_' + item_id).find('input[name=_choice_qty_' + item_id + ']').val());
        var delivery_date = jQuery('div.choice_container_' + item_id).find('input.pick_delivery_date').val();
        deliveries_limit = deliveries_limit * deliveries_qty;

        var my_deliveries_qty =  jQuery('input[name=_num_qty_' + item_id + ']').val(); 
        if(delivery_date) {
           	if (deliveries_limit >= parseInt(get_current_choice_qty(item_id)) + parseInt(my_deliveries_qty) ) {
                var selected_meals = jQuery('div.choice_container_' + item_id).find('.item-selected');

                if (selected_meals.length) {

                    var pick_limit = parseInt(jQuery('input[name=_choice_qty_' + item_id + ']').val());
                    var num_delivery = jQuery('input[name=_num_delivery_' + item_id + ']').val();
                    var num_total_deleveries = jQuery('input[name=_num_total_deleveries' + item_id + ']').val();
                    var qty_sum = 0;
                    selected_meals.each(function () {
                        var qty = jQuery(this).find('input[name=qty]').val();
                        qty_sum = qty_sum + parseInt(qty);
                    });
                    var my_num_qty = jQuery('input[name=_num_qty_' + item_id + ']').val(); 
                    if(isNaN(qty_sum)){
		            	jQuery('div.choice_container_' + item_id ).each(function () {
			                qty_sum = jQuery(this).find('input[name=qty').val();
			            });
		            }
		            	
		            var totalQtyUser = parseInt(qty_sum) +  parseInt(my_num_qty);	
		            if (num_delivery >=  totalQtyUser) {
	                         // Adujstment for multiple qty order on same
	                       	jQuery('input[name=_num_qty_' + item_id + ']').val(parseInt(get_current_choice_qty(item_id)) + parseInt(my_deliveries_qty));
	                        var myPendingDateDelivery = parseInt( num_delivery) - jQuery('input[name=_num_qty_' + item_id + ']').val();
	                        var myPendingDelivery = '('+( (myPendingDateDelivery != 0)?myPendingDateDelivery:'0' )+')';
	                        var myPendingDeliveryTab = ( (myPendingDateDelivery != 0)?myPendingDateDelivery:'0' );
	                        var totalNumberOFDeliveries = jQuery('span.totalNumberOFDeliveries').html();
	                        var oldTabValue = jQuery('a.nav-link.active span.badge.badge-light').html();

	                        jQuery('span.totalOrderPending').html( myPendingDelivery);
	                        jQuery('a.nav-link.active span.badge.badge-light').html(myPendingDeliveryTab);
	                        if(myPendingDeliveryTab != '0'){
	                        	var myTabQty = oldTabValue - myPendingDeliveryTab;
	                        }else{
	                        	var myTabQty = oldTabValue;
	                        }
	                       	jQuery('span.totalNumberOFDeliveries').html( totalNumberOFDeliveries - myTabQty );

	                        selected_meals.each(function () {
	                            var sides = {};
	                            var id = jQuery(this).find('input[name=_meal_id]').val();
	                            if(id){
	                            	var qty = jQuery(this).find('input[name=qty]').val();
		                            var title = jQuery(this).find('input[name=meal_title]').val();
		                            jQuery(this).find('input._meal_side_'+item_id+id).each(function (id) {
		                                var name = jQuery(this).attr('name');
		                                var value = jQuery(this).attr('value');
		                                sides[name] = value;
		                            });
		                            sides.qty = parseInt(qty);
		                            sides.title = title;
		                            if (!deliveries[item_id]) {
		                                deliveries[item_id] = {};
		                            }
		                            if (!deliveries[item_id][delivery_date]) {
		                                deliveries[item_id][delivery_date] = {};
		                            }
		                            //Adjustment made to go around the bug of same item added on same date.
		                            if (!deliveries[item_id][delivery_date][id]) {
		                                deliveries_count = deliveries_count + sides.qty;
		                            }else{
		                                deliveries_count = deliveries_count + (parseInt(my_deliveries_qty) + parseInt(qty_sum));
		                            }
		                            deliveries[item_id][delivery_date][id] = sides;
	                            }
	                            
	                        });

	                        show_new_delivery(item_id, deliveries, qty_sum, parseInt(get_current_choice_qty(item_id)),'' );
	                        refresh_summary(deliveries,item_id);
	                         
	                        setTimeout(function() {
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
						    }, 50);
	                            
	                    } else {
	                    	if(num_delivery == my_num_qty){
	                    		alert('You have (NaN) deliveries for this item!');
	                    	}else{
	                    		alert('You have ' + num_delivery + ' deliveries for this item!');	
	                    	}
	                        //alert('Please pick ' + pick_limit + ' meal(s) for each delivery!');
	                    }
		                               
                } else {
                    alert('No meal has been picked for this delivery!');
                }
            } else {
                alert('You only have (' + deliveries_limit + ') deliveries for this item!');
                 setTimeout(function() {
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
						       	jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
						    }, 50);
            }
            //code for ArrowHighlits
            if(jQuery('input[name=_num_qty_' + item_id + ']').val() > 0){
                jQuery('button.review_complete_deliveries').addClass('iofArrowHighlight');
                jQuery([document.documentElement, document.body]).animate({
                    scrollTop: jQuery("#recipient_code_container").offset().top
                }, 2000);
            }
        } else {
            alert('No delivery date selected!');
        }
    });

    jQuery(document).on('click', 'a.delete_delivery', function(e) {
    	e.preventDefault();
    	if(confirm("Are you sure you want to delete this?")){
    		var date = jQuery(this).data('delivery_date');
	        var item_id = jQuery(this).data('item_id');
	        var myqty = jQuery(this).data('myqty');
	        var count_vav = Object.keys(deliveries[item_id][date]).length;
	        deliveries_count = deliveries_count - count_vav;

	        var delivery_boxs_arr = [];
	        var counter_arr = [];
        	jQuery('div.deliveries_details_' + item_id).find('.delivery_box').each(function () {
        		if(jQuery(this).find('a.delete_delivery').data('delivery_date') === date){
        			delivery_boxs_arr.push(jQuery(this).find('a.delete_delivery').data('myqty'));		
        		}
        		counter_arr.push(1);
            });
        	var myQtyFinal = '';
            if(counter_arr.length > 1){
            	if(counter_arr.length==2){
            		var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 1;
            	}else if(counter_arr.length==3){
					var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 2;
            	}else if(counter_arr.length==4){
					var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 3;
            	}else if(counter_arr.length==5){
					var myQtyFinal = parseInt(delivery_boxs_arr[0]) - 4;
            	}
            }

            var resetQty = jQuery('input[name=_num_qty_' + item_id + ']').val();
            if(myQtyFinal == 0){
            	var resetFinal = parseInt(resetQty) - parseInt(delivery_boxs_arr[0]);
            }else{
            	var resetFinal = parseInt(resetQty) - parseInt(myQtyFinal);	
            }
	        
			jQuery('input[name=_num_qty_' + item_id + ']').val(resetFinal);
	        

	        var num_qty_item = jQuery('input[name=_num_qty_' + item_id + ']').val();
	        var num_delivery_item = jQuery('input[name=_num_delivery_' + item_id + ']').val();
	        var resetTabs = num_delivery_item - num_qty_item;

	        jQuery('span.totalOrderPending').html( '('+ resetTabs+')');

	        var oldTabValue = jQuery('a.nav-link.active span.badge.badge-light').html();
			jQuery('a.nav-link.active span.badge.badge-light').html( resetTabs);

			
			var spanArr = [];
			jQuery('#RCTab li a').find('span.badge').each(function () {
       			spanArr.push(jQuery(this).html());		
            });

            var allListOfTabs = 0;
			for (var i = 0; i < spanArr.length; i++) {
			    allListOfTabs += spanArr[i] << 0;
			}
			jQuery('span.totalNumberOFDeliveries').html(allListOfTabs);

            //code for ArrowHighlits
            if(deliveries_count == 0){
                jQuery('button.review_complete_deliveries').removeClass('iofArrowHighlight');
            }

	        delete deliveries[item_id][date];
	        show_new_delivery(item_id, deliveries,'','', resetFinal);
	        refresh_summary(deliveries,item_id);
	        return true;
	    }
	    else{
	        return false;
	    }
       
    });

    jQuery(document).on('click', 'input.qty', function() {
        jQuery("input[name='update_cart']").attr("disabled", false);
    });

    jQuery(document).on('click', 'button.review_complete_deliveries', function() {
         var num_qty =  parseInt( jQuery('input:hidden.num_qty').val() );
        var containers = jQuery('div.choice_container');
        var num_delivery =jQuery('.num_delivery').val();
        var limit = 0;
        var myQty = 0;
        containers.each(function() {
            var deliveries_limit = parseInt( jQuery(this).find('input:hidden.num_delivery').val() );
            var num_tot_qty =  parseInt(  jQuery(this).find('input:hidden.num_qty').val() );
            var deliveries_qty = parseInt( jQuery(this).find('input.num_qty').val() );
            limit = limit + ( deliveries_limit * deliveries_qty );
            myQty = myQty + num_tot_qty;
        });
   
        /*if(deliveries_count === limit) {*/
        if(myQty >= 1){
            jQuery('div.pick_your_meals_container').fadeToggle(1000);
            jQuery('div.review_confirm_container').fadeToggle(1000);
        } else {
        	if(limit == 0 && myQty == 0){
        		alert('You still have (' + ( num_delivery) + ') meal(s) to pick.');
        	}else{
        		alert('You still have (' + ( limit - myQty) + ') meal(s) to pick.');
        	}
            
        }
    });

    jQuery(document).on('click', 'button.back_to', function() {
        jQuery('div.pick_your_meals_container').fadeToggle(1000);
        jQuery('div.review_confirm_container').fadeToggle(1000);
    });

    jQuery(document).on('click', 'button.complete_order', function() {
        jQuery(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        var recipient_code = jQuery('input[name=recipient_code]').val();
        var customer_note = jQuery('textarea[name=customer_note]').val();
		var lst_to = [];
	    $("input:hidden.num_qty").each(function() {
	        lst_to.push($(this).val());
	    });
	    var devidedByTabArr = lst_to.join();
	    var totNumQty_to = [];
	    $("input:hidden.num_tot_qty").each(function() {
	        totNumQty_to.push($(this).val());
	    });
	    var totalNumArr = totNumQty_to.join();
    
        jQuery.post(
            ajax_object.ajax_url,
            {
                "action": "complete_recipient_choice",
                "recipient_code": recipient_code,
                "myQtyArr":devidedByTabArr,
                "totalNumArr":totalNumArr,
                "recipient_choice": deliveries,
                "customer_note": customer_note
            }
        )
            .done(function(data) {
                jQuery('button.complete_order').html('Confirm!');
                var el = jQuery('div#recipient_code_container');
                var pick_your_meal_container = el.next();
                var back_to = jQuery('button.back_to');
                var complete_order = jQuery('button.complete_order');
                jQuery('textarea[name=customer_note]').attr('disabled', true);

                el.find('p#recipient_message').slideToggle();
                back_to.remove();
                complete_order.remove();
                pick_your_meal_container.remove();
                jQuery('span.thankyoumsg').css('display','block');
                
                if(data.shipping_method_id == 'flat_rate' || data.shipping_method_id == 'flat_rate'){
                    jQuery('div.getShippingDetailAfterOrder').after('<ul class="flatRateOrder full"><li><div class="flatRateBox"><p class="localPickTitle" style="background-color:#eef6e1">Delivery Details</p><p> Your order number is <strong>#'+data.orderid+'</strong></p><p>Your Meal will be delivered between the hours of 3 & 6 PM </p></div></li></ul>');    
                }
                if(data.shipping_method_id == 'local_pickup' || data.shipping_method_id == 'local_pickup'){
                    jQuery('div.getShippingDetailAfterOrder').after('<ul class="flatRateOrder full"><li><div class="flatRateBox"><p class="localPickTitle">Local Pickup Information</p><p class="localPickSubTitle">You Selected Local Pickup for your order. Please note the following pickup information</p><p> Your order number is <strong>#'+data.orderid+'</strong></p><p>Time Frame - <strong>1:00 PM to 6:00PM EST</strong></p><p>Location - <strong>'+data.location+'</strong></p></div></li></ul>'   );    
                }

                el.find('form#recipient_code_form').append('<button type="submit" class="btn btn-lg btn-success">Redeem!</button>');
                display_recipient_message(data.success, false);
            })
            .fail(function(data) {
                jQuery('div#recipient_code_container').find('p#recipient_message').slideToggle();
                jQuery('button.complete_order').html('Confirm!');
                var response = data.responseText;
                response = jQuery.parseJSON(response);
                if(response) {
                    display_recipient_message(response.error, true);
                } else {
                    display_recipient_message('Unexpected error occurred!', true);
                }
            });
    });

    function get_current_choice_qty(item_id) {
        var tmp_del = deliveries[item_id];
        var count = 0;

        /*jQuery.each(tmp_del, function(index, items) {
            jQuery.each(items, function(key, item) {
            	 count = count + item.qty;
			});
        });*/
        /*if(count == 0){*/
        	var qty_d = [];
        	jQuery('div.choice_container_' + item_id).find('.item-selected').each(function () {
        		if(jQuery(this).find('input[name=qty]').val()){
        			qty_d.push(jQuery(this).find('input[name=qty]').val());	
        		}
            });

            var totalQty = 0;
			for (var i = 0; i < qty_d.length; i++) {
			    totalQty += qty_d[i] << 0;
			}
            count = totalQty;
        /*}*/
       
        /*if(isNaN(count)){
        	count = 1;
        }*/
        
        return count;
    }

    
    function display_recipient_message(message, is_error) {
        var el = jQuery('form#recipient_code_form');
        if(is_error) {
            el.find('p#recipient_message')
                .find('small')
                .html(message)
                .removeClass('text-success')
                .addClass('text-danger');
            el.find('p#recipient_message').slideToggle();
            el.find('button[type=submit]').html('Redeem!');
        } else {
            el.find('p#recipient_message')
                .find('small')
                .html(message)
                .removeClass('text-danger')
                .addClass('text-success');
            el.find('p#recipient_message').slideToggle();
            el.find('button[type=submit]').html('Redeem!').remove();
        }
    }

    function switch_meal_selection_toggle(e, meal_id, item_id, is_checkbox,mycheck) {
        var pick_limit = jQuery('input[name=_choice_qty_' + item_id + ']').val();
        var num_delivery = jQuery('input[name=_num_delivery_' + item_id + ']').val();
        var num_total_deleveries = jQuery('input[name=_num_total_deleveries' + item_id + ']').val();

        var el = jQuery('div.meal_container_' + meal_id);
        var qty_sum = parseInt(el.find('input[name=qty]').val());
        

        if(qty_sum) {
      
 			jQuery('div.choice_container_' + item_id).find('.item-selected').each(function () {
                var qty = jQuery(this).find('input[name=qty]').val();
                qty_sum = qty_sum + parseInt(qty);
            });
            if(isNaN(qty_sum) || qty_sum == 'NaN'){
            	jQuery('div.choice_container_' + item_id).each(function () {
	                	qty_sum = jQuery(this).find('input[name=qty').val();
	            });
            }
            if (parseInt(num_total_deleveries) >=  parseInt(num_delivery) || el.hasClass('item-selected')) {
            	var checked = jQuery(".meal_details input[type=checkbox]:checked").length;
            	if(mycheck == 1){
            		if (checked > 0) {
		                highlight_meal_selection(el, meal_id, is_checkbox,checked,11);
		                return true;
		            } else {
		                highlight_meal_selection(el, meal_id, is_checkbox,0,11);
		                return false;
		            }
            	}else{
            		if (checked > 0) {
		                highlight_meal_selection(el, meal_id, is_checkbox,checked,22);
		                return true;
		            } else {
		                highlight_meal_selection(el, meal_id, is_checkbox,0,22);
		                return false;
		            }
            	}

            	
	            

               
            } else {
                e.preventDefault();
                alert('You can only pick ' + num_delivery + ' meal(s) per delivery!');
            }
        }
    }

    function show_new_delivery(item_id, deliveries,qty_sum, myQty,deleteVal) {
    	var my_num_qty = jQuery('input[name=_num_qty_' + item_id + ']').val();


        if(deliveries[item_id]) {
            var tmp_del = deliveries[item_id];

            var html = '';
            jQuery.each(tmp_del, function(index, value) {

            	if(myQty == '' || myQty == null){
    				FinalDeliveryBoxs = deleteVal;
    			}else{
    				var delivery_boxs = [];
		        	jQuery('div.deliveries_details_' + item_id).find('.delivery_box').each(function () {
		        		if(jQuery(this).find('a.delete_delivery').data('delivery_date') === index){
		        			delivery_boxs.push(jQuery(this).find('a.delete_delivery').data('myqty'));		
		        		}
		            });

		           	var FianlQty = 0;
					for (var i = 0; i < delivery_boxs.length; i++) {
					    FianlQty += delivery_boxs[i] << 0;
					}
					
		            if(parseInt(FianlQty)){
		            	var FinalDeliveryBoxs = parseInt(myQty) + parseInt(FianlQty);
		            }else{
		            	var FinalDeliveryBoxs = parseInt(myQty);
		            }
    			}



            	

            	var len = Object.keys(value).length;
             	html += '<div class="card delivery_box">' +
                    '  <div class="card-body">' +
                    '  <span class="delTitle"> Delivery Date: </span><span class="delDate"> <i>' + index + '</i></span><span class="delItems"> ' + len + ' items </span> ' + 
                    '  <span class="pull-right">' +
                    '<span class="delDelete"><a href="#" class="text-danger delete_delivery" data-myQty="'+FinalDeliveryBoxs+'" data-delivery_date="' + index + '" data-item_id="' + item_id + '"></a></span>' +
                    '</div>' +
                    '</div>';
            });
            jQuery('.deliveries_details_' + item_id).html(html);
            reset_item_selections(item_id);
        }
    }

     function reset_item_selections(item_id) {
        jQuery('div.choice_container_' + item_id).find('.item-selected').each(function() {
            jQuery(this).find('input[type=checkbox]').click();
            jQuery(this).find('input[type=number]').attr('disabled', false);
            jQuery(this).removeClass('item-selected');
        });
        /*jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('hideDiv');*/
        /*jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('showDiv');*/

    }

    function highlight_meal_selection(el, meal_id, is_checkbox,checked,toggleCheck) {
        if(!is_checkbox) {
            var checkbox = jQuery('input[name=meal_' + meal_id + ']');
            checkbox.prop('checked', !checkbox.prop("checked"));
        }

        if(toggleCheck == 11){
        	 if(checked != 0){
	        	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('hideDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('showDiv');
	        }else{
	        	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
	        }
        }else{

        	if(checked != 0){
        		jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('showDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('hideDiv');
	        	
	        }else{
	        	jQuery('.chooseDelivery .chooseDeliveryLeft').removeClass('hideDiv');
	            jQuery('.chooseDelivery .chooseDeliveryLeft').addClass('showDiv');
	        }

        }

        if (el.hasClass('item-selected')) {
            el.removeClass('item-selected');
            el.find('input[name=qty]').attr('disabled', false);
            jQuery('div.devThum').each(function(i, obj) {
                jQuery(this).find('input[type=checkbox]').attr('disabled',false);
                jQuery(this).find('input[type=number]').attr('disabled', false);
                jQuery(this).find('a.pick_btn_toggle').removeClass('disabled');
                jQuery('input.pick_delivery_date').val('');
                    
            });
        } else {
            el.addClass('item-selected');
            el.find('input[name=qty]').attr('disabled', true);
             jQuery('div.devThum').each(function(i, obj) {
                if(jQuery(this).hasClass('item-selected')){}else{
                    jQuery(this).find('input[type=checkbox]').attr('disabled',true);
                    jQuery(this).find('input[type=number]').attr('disabled', true);
                    jQuery(this).find('a.pick_btn_toggle').addClass('disabled');
                   jQuery('input.pick_delivery_date').val('');
                    
                }
            });
        }
    }

    function refresh_summary(deliveries,item_id) {
        var html = '<input type="hidden" value="'+item_id+'" class="my_item_id" value="myItemId" />';
        jQuery.each(deliveries, function(item, dates) {
        	html += '<div class="deliveryList">';
            jQuery.each(dates, function(date, items) {
            	html += '<div class="delivery_box rcDeliveryDateBox">';
                html += '<p> Delivery Date: <span>' + date + '</span></p>';
                jQuery.each(items, function(key, item) {
                	//alert(JSON.stringify(item));
                    var side_html = build_sides_summary(item);
                    html += '<h5>' + item.title + '</h5>' + side_html ;
                });
                html += '</div>';
            });
            html += '</div>';
        });

        jQuery('div.meals_summary').html(html);
    }

    function build_sides_summary(sides) {
        var side_html = '<ul>';
        if(sides._Side) {
            side_html += '<li><strong>Starches: </strong>' + sides._Side + '</li>';
        }
        if(sides._Vegetable) {
            side_html += '<li><strong>Vegetable: </strong>' + sides._Vegetable + '</li>';
        }
        if(sides._Salad) {
            side_html += '<li><strong>Salad: </strong>' + sides._Salad + '</li>';
        }
        if(sides._Bread) {
            side_html += '<li><strong>Bread: </strong>' + sides._Bread + '</li>';
        }
        if(sides._Dessert) {
            side_html += '<li><strong>Dessert: </strong>' + sides._Dessert + '</li>';
        }

         side_html += '</ul>';
        return side_html;
    }
