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