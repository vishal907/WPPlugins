
if (window.location.pathname === '/checkout/') {
    

   // Listen for error on billing / shipping form fields AJAX call
/*    jQuery(document).ajaxComplete(function (event, xhr, settings) {
        var result = xhr.responseJSON.result;
        if (result === 'failure') {
            var input = jQuery('input[name=woocommerce_checkout_place_order]');
            input.val('Place order');
            input.prop('disabled', false);
        }
    });*/

    var checkout_form = $('form.checkout');

	checkout_form.on('checkout_place_order', function () {
		if(jQuery('div#gift-certificate-receiver-form-single')){
          var gc_input_arr = [];
            jQuery('div#gift-certificate-receiver-form-single').find('input[type="text"]').each(function(e) {
              if($(this).val() == ''){ gc_input_arr.push(0); }else{ gc_input_arr.push(1);  }
            });

            if(gc_input_arr[0] == 0 && gc_input_arr[1] == 0 && gc_input_arr[2] == 0){
            	jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_receiver_name"><strong>Gift Receiver Name</strong> is a required field.		</li><li data-id="gift_sender_name"><strong>Gift Sender Name</strong> is a required field.</li><li data-id="gift_receiver_email"><strong>Gift Receiver Email</strong> is a required field.</li></ul></div>');
	            	jQuery('html, body').animate({
									        scrollTop: $(".page").offset().top
									    }, 1500);

						setTimeout(function () {
					    jQuery("div.woocommerce-NoticeGroup-checkout").remove();
					}, 7000);

            	return false;
            }else  if(gc_input_arr[0] == 0 || gc_input_arr[1] == 0 || gc_input_arr[2] == 0){
            	if(gc_input_arr[0] == 0){
            		jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_receiver_name"><strong>Gift Receiver Name</strong> is a required field.		</li></ul></div>');	
            	}else if(gc_input_arr[1] == 0){
            		jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_sender_name"><strong>Gift Sender Name</strong> is a required field.		</li></ul></div>');	
            	}else if(gc_input_arr[2] == 0){
            		jQuery('div#customer_details').before('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li data-id="gift_receiver_email"><strong>Gift Receiver Email</strong> is a required field.		</li></ul></div>');	
            	}
            	jQuery('html, body').animate({
								        scrollTop: $(".page").offset().top
								    }, 1500);

            	setTimeout(function () {
			    jQuery("div.woocommerce-NoticeGroup-checkout").remove();
			}, 7000);

            	return false;
            }else{
            	$(document.body).trigger('update_checkout');
            	return true;
            }

            

        }else{
        	$(document.body).trigger('update_checkout');	
        	return true;
        }
        
        
   	});

}

