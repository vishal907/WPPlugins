

        var search_closed = true;

        $(window).resize( function () {
            if ($("li#wp-admin-bar-iof-search-forms-mobile").css("display") == "none") {
                $("ul#wp-admin-bar-iof-search-forms").show();
            }

            if ($("li#wp-admin-bar-iof-search-forms-mobile").css("display") == "block") {
                $("ul#wp-admin-bar-iof-search-forms").hide();
            }
            search_closed = true;
        });

        $("li#wp-admin-bar-iof-search-forms-mobile").click( function() {
            if ( search_closed ) {
                $("ul#wp-admin-bar-iof-search-forms").show();
            } else {
                $("ul#wp-admin-bar-iof-search-forms").hide();
            }
            search_closed = !search_closed;
        });

	    $('div#woocommerce-order-items').on('click', 'a.edit_sides_link', function (e) {
	        e.preventDefault();
	        var item_id = $(this).data('id');
	        $('.edit_sides_form_'+item_id).show();
            $('.edit_sides_form_'+item_id).next().hide();
        });

        $('div#woocommerce-order-items').on('click', 'a.edit-order-item', function () {
            var item_id = $(this).parent().parent().parent().data('order_item_id');
            $('.edit_sides_form_'+item_id).show();
            setTimeout(function() {
                $('.edit_sides_form_'+item_id).next().next().hide();
            }, 100);
        });

        $('div#woocommerce-order-items').on('change', 'select.create_sides_select', function() {
            var label = $(this).data('label');
            var item_id = $(this).data('id');
            var value = $(this).val();
            var item_container = $('table.edit_sides_form_' + item_id).next().next();
            var el = item_container.find('input[value=' + label + ']');
            if(el.length) {
                if(value.localeCompare('none') != 0) {
                    el.next().html(value);
                } else {
                    if(el.parent().parent().attr('data-meta_id')) {
                        el.next().html('');
                    } else {
                        el.parent().parent().remove();
                    }
                }
            } else {
                if(value.localeCompare('none') != 0) {
                    item_container.find('tbody.meta_items').append(
                        '<tr>' +
                        '<td>' +
                        '<input type="text" name="meta_key[' + item_id + '][]" value="' + label + '">' +
                        '<textarea name="meta_value[' + item_id + '][]">' + value + '</textarea>' +
                        '</td>' +
                        '</tr>'
                    );
                }
            }

        });

		$("#save_sides_button").click( function() {
            var product_id = $("#iof_product_id").val();
            var default_side = $("#default_side").val();
            var default_side_lock = $("#default_side_lock").is(':checked') ? 'ON' : 'OFF';
            var default_vegetable = $("#default_vegetable").val();
            var default_vegetable_lock = $("#default_vegetable_lock").is(':checked') ? 'ON' : 'OFF';
            var default_salad = $("#default_salad").val();
            var default_salad_lock = $("#default_salad_lock").is(':checked') ? 'ON' : 'OFF';
            var default_bread = $("#default_bread").val();
            var default_bread_lock = $("#default_bread_lock").is(':checked') ? 'ON' : 'OFF';
            var default_dessert = $("#default_dessert").val();
            var default_dessert_lock = $("#default_dessert_lock").is(':checked') ? 'ON' : 'OFF';
            $(this).prop("disabled", "disabled");
			$.post(
				ajaxurl,
				{
					"action": "save_product_sides_meta",
					"product_id": product_id,
					"default_side": default_side,
					"default_side_lock": default_side_lock,
					"default_vegetable": default_vegetable,
					"default_vegetable_lock": default_vegetable_lock,
					"default_salad": default_salad,
					"default_salad_lock": default_salad_lock,
					"default_bread": default_bread,
					"default_bread_lock": default_bread_lock,
					"default_dessert": default_dessert,
					"default_dessert_lock": default_dessert_lock
				},
				function (data) {
					$("#save_sides_button").removeProp("disabled");
					alert('Changes saved!');
				}
			);
			var lock_color = '#d9534f';
			var unlock_color = '#3C763D';
			if($("#default_side_lock").is(':checked')){
			    var el = $('label[for=default_side_lock] span.tooltip span.dashicons');
			    if( el.hasClass('dashicons-unlock') ) {
                    el.removeClass('dashicons-unlock');
                    el.addClass('dashicons-lock');
                    $('label[for=default_side_lock]').css('color', lock_color);;
                }
            } else {
                var el = $('label[for=default_side_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-lock') ) {
                    el.removeClass('dashicons-lock');
                    el.addClass('dashicons-unlock');
                    $('label[for=default_side_lock]').css('color', unlock_color);
                }
            }

            if($("#default_vegetable_lock").is(':checked')){
                var el = $('label[for=default_vegetable_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-unlock') ) {
                    el.removeClass('dashicons-unlock');
                    el.addClass('dashicons-lock');
                    $('label[for=default_vegetable_lock]').css('color', lock_color);
                }
            } else {
                var el = $('label[for=default_vegetable_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-lock') ) {
                    el.removeClass('dashicons-lock');
                    el.addClass('dashicons-unlock');
                    $('label[for=default_vegetable_lock]').css('color', unlock_color);
                }
            }

            if($("#default_salad_lock").is(':checked')){
                var el = $('label[for=default_salad_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-unlock') ) {
                    el.removeClass('dashicons-unlock');
                    el.addClass('dashicons-lock');
                    $('label[for=default_salad_lock]').css('color', lock_color);
                }
            } else {
                var el = $('label[for=default_salad_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-lock') ) {
                    el.removeClass('dashicons-lock');
                    el.addClass('dashicons-unlock');
                    $('label[for=default_salad_lock]').css('color', unlock_color);
                }
            }

            if($("#default_bread_lock").is(':checked')){
                var el = $('label[for=default_bread_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-unlock') ) {
                    el.removeClass('dashicons-unlock');
                    el.addClass('dashicons-lock');
                    $('label[for=default_bread_lock]').css('color', lock_color);
                }
            } else {
                var el = $('label[for=default_bread_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-lock') ) {
                    el.removeClass('dashicons-lock');
                    el.addClass('dashicons-unlock');
                    $('label[for=default_bread_lock]').css('color', unlock_color);
                }
            }

            if($("#default_dessert_lock").is(':checked')){
                var el = $('label[for=default_dessert_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-unlock') ) {
                    el.removeClass('dashicons-unlock');
                    el.addClass('dashicons-lock');
                    $('label[for=default_dessert_lock]').css('color', lock_color);
                }
            } else {
                var el = $('label[for=default_dessert_lock] span.tooltip span.dashicons');
                if( el.hasClass('dashicons-lock') ) {
                    el.removeClass('dashicons-lock');
                    el.addClass('dashicons-unlock');
                    $('label[for=default_dessert_lock]').css('color', unlock_color);
                }
            }
		});

        $("div#iof-phone-order-container").on('click', '.iof-add-product', function() {
            var has_variations = $(this).data('product_has_variations');
            var product_id = $(this).data('product_id');
            var order_id = $('input[name=post_ID]').val();
            var nonce = woocommerce_admin_meta_boxes.order_item_nonce;
            var el = $(this);
            el.attr('disabled', true);
            if(has_variations) {
                var variation_id = $('select#iof-phone-order-variations_' + product_id).val();
                if(variation_id) {
                    $.post(
                        ajaxurl,
                        {
                            "action": "woocommerce_add_order_item",
                            "item_to_add[]": variation_id,
                            "dataType": 'json',
                            "order_id": order_id,
                            'security': nonce,
                            'data': 'add_order_items%5B%5D=' + variation_id
                        },
                        function (data) {
                            $('div#woocommerce-order-items').find('div.inside').html(data.data.html);
                            el.attr('disabled', false);
                        }
                    );
                } else {
                    alert('Please select a variation!');
                }
            } else {
                $.post(
                    ajaxurl,
                    {
                        "action": "woocommerce_add_order_item",
                        "item_to_add[]": product_id,
                        "dataType": 'json',
                        "order_id": order_id,
                        'security': nonce,
                        'data': 'add_order_items%5B%5D=' + product_id
                    },
                    function (data) {
                        $('div#woocommerce-order-items').find('div.inside').html(data.data.html);
                        el.attr('disabled', false);
                    }
                );
            }
        });

        $('input[name=iof_product_search]').on('keyup', function(e) {
            if(e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
            var search = $(this).val();
            if(search.length >= 3) {
                $.get(
                    ajaxurl,
                    {
                        "term": search,
                        "action": "woocommerce_json_search_products_and_variations",
                        "post_type" : "product",
                        "security": woocommerce_admin_meta_boxes.search_products_nonce
                    },
                    function (data) {
                        $.post(
                            ajaxurl,
                            {
                                "action": "iof_process_phone_order_search",
                                "data": data
                            },
                            function (data) {
                                $("div#iof-phone-order-container").html(data);
                            }
                        );
                    }
                );
            }
        });

        $('input[name=iof_product_search]').on('keydown', function(event) {
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('button.add-order-item').hide();

        $("select#iof-product-cat").on('change', function() {
            var cat_slug = $(this).val();
            $('input[name=iof_product_search]').val('');
            $.post(
                ajaxurl,
                {
                    "action": "phone_order_product_by_cat",
                    "cat_slug": cat_slug
                },
                function (data) {
                    $("div#iof-phone-order-container").html(data);
                }
            );
        });

        var _billing_address_1 = $('input[name=_billing_address_1]').val();
        var _new_billing_address_1 = '';

        var _billing_address_2 = $('input[name=_billing_address_2]').val();
        var _new_billing_address_2 = '';

        var _billing_address_1 = $('input[name=_billing_address_1]').val();
        var _new_billing_address_1 = '';

        $('input[name=_billing_address_1]').on('change paste keyup', function() {
            _new_billing_address_1 = $(this).val();
            if(_billing_address_1 !== _new_billing_address_1)
            console.log('Value changed from: "' + _billing_address_1 + '" to: "' + _new_billing_address_1 + '"');
        });


        // Kitchen report 
        $('.date-filter input[name=date]').datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $('button.pull_date_report').click(function(){
             var el = $(this);
             alert($(this));
            el.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        })

        if ( typeof $.fn.DataTable !== 'undefined' ) {
            $('.date-filter form').submit(function(event) {
                event.preventDefault();

                var date = $(this).find('input[name=date]').val();
                var storeName = $(this).find('select[name=storeName]').val(); 
                if(storeName != ''){
                    document.title = 'Kitchen Report ‹ Instead of Flowers — '+storeName+' Store '+date;    
                }else{
                    document.title = 'Kitchen Report ‹ Instead of Flowers — (GA / FL) Both';    
                }
                
                $.post(
                    ajaxurl,
                    {
                        "action": "pull_kitchen_report",
                        "date": date,
                        "storeName": storeName,
                    }
                ).done(function(data) {
                    $('button.pull_date_report').html('Go');
                    $('#kitchen-report').html( data.data );
                    var data_table = $('#kitchen-report table').DataTable({
                        dom: 'Bfrtip',
                        paging: true,
                        ordering: false,
                        searching: false,
                         bInfo : false,
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                    })

                })
                .fail(function(data) {
                    console.log(data);
                    console.log('Sorry, could not fetch the report!');
                });
            });

            var data_table = $('#kitchen-report table').DataTable({
                dom: 'Bfrtip',
                paging: false,
                ordering: false,
                searching: false,
                 bInfo : false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            })
        }


jQuery(document).ready(function($) {
    $('.do-manual-refund').click(function(event) {
        console.log('Click')
        setTimeout(function(){
            location.reload()
        }, 3000);
    });
});