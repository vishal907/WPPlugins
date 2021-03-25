jQuery('.iof-easy-credit-value').on('click', function() {
    var amount = jQuery(this).data('value');
    jQuery('button.active').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('#iof-credit-amount').val('');
    jQuery('input#credit_called').val(amount);
    jQuery('input#credit_called').keyup();
});

jQuery('#iof-credit-amount').on('keyup', function () {
    var amount = jQuery(this).val();
    jQuery('button.active').removeClass('active');
    jQuery('input#credit_called').val(amount);
    jQuery('input#credit_called').keyup();
});

var search_closed = true;

jQuery(window).resize(function () {
    if (jQuery("li#wp-admin-bar-iof-search-forms-mobile").css("display") == "none") {
        jQuery("ul#wp-admin-bar-iof-search-forms").show();
    }

    if (jQuery("li#wp-admin-bar-iof-search-forms-mobile").css("display") == "block") {
        jQuery("ul#wp-admin-bar-iof-search-forms").hide();
    }
    search_closed = true;
});

jQuery("li#wp-admin-bar-iof-search-forms-mobile").click(function () {
    if (search_closed) {
        jQuery("ul#wp-admin-bar-iof-search-forms").show();
    } else {
        jQuery("ul#wp-admin-bar-iof-search-forms").hide();
    }
    search_closed = !search_closed;
});

jQuery("#btn-side").click( function() {
    var side_title = jQuery(".sides_radio_buttons input:checked").val();
    var side_id    = jQuery(".sides_radio_buttons input:checked").next("input[name='side-id-choice']").val();
    var side_img =  jQuery('.iofSideImage-'+side_id+' img').attr('src');

    jQuery("input.side-value").val(side_title);
    jQuery("input[name='side-id']").val(side_id);
    jQuery(".side-title").html(side_title);
    jQuery('#sidesImage img').attr('src',side_img);

});

jQuery("#btn-vegetable").click(function () {
    var vegetable_title = jQuery(".vegetables_radio_buttons input:checked").val();
    var vegetable_id    = jQuery(".vegetables_radio_buttons input:checked").next("input[name='vegetable-id-choice']").val();
    var vegetable_img =  jQuery('.iofVegetablesImage-'+vegetable_id+' img').attr('src');


    jQuery("input.vegetable-value").val(vegetable_title);
    jQuery("input[name='vegetable-id']").val(vegetable_id);
    jQuery(".vegetable-title").html(vegetable_title);
      jQuery('#VegetableImage img').attr('src',vegetable_img);
});

jQuery("#btn-salad").click(function () {
	var salad_title = jQuery(".salads_radio_buttons input:checked").val();
    var salad_id    = jQuery(".salads_radio_buttons input:checked").next("input[name='salad-id-choice']").val();
     var salad_img =  jQuery('.iofSaladImage-'+salad_id+' img').attr('src');

    jQuery("input.salad-value").val(salad_title);
    jQuery("input[name='salad-id']").val(salad_id);
    jQuery(".salad-title").html(salad_title);
          jQuery('#SaladImage img').attr('src',salad_img);

    
});

jQuery("#btn-bread").click(function () {
    var bread_title = jQuery(".breads_radio_buttons input:checked").val();
    var bread_id    = jQuery(".breads_radio_buttons input:checked").next("input[name='bread-id-choice']").val();
    var bread_img =  jQuery('.iofBreadImage-'+bread_id+' img').attr('src');
    jQuery("input.bread-value").val(bread_title);
    jQuery("input[name='bread-id']").val(bread_id);
    jQuery(".bread-title").html(bread_title);
     jQuery('#BreadImage img').attr('src',bread_img);
});

jQuery("#btn-dessert").click(function () {
    var dessert_title = jQuery(".desserts_radio_buttons input:checked").val();
    var dessert_id    = jQuery(".desserts_radio_buttons input:checked").next("input[name='dessert-id-choice']").val();
    var dessert_img =  jQuery('.iofDessertImage-'+dessert_id+' img').attr('src');

     
    jQuery("input.dessert-value").val(dessert_title);
    jQuery("input[name='dessert-id']").val(dessert_id);
    jQuery(".dessert-title").html(dessert_title);
         jQuery('#DessertImage img').attr('src',dessert_img);

});

jQuery(".thumbnail").on('click', function() {
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



jQuery('.item-selected').find('input[type=radio]:first').attr('checked', true);