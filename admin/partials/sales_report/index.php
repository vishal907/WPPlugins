<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/popper.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="//cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">

<style>
    div#wpcontent {
        background-color: #F1F1F1;

    }
    .container {
    max-width: 1540px;
}
</style>

<script>
    $(document).ready(function() {
        var data_table = $('table#sales_report').DataTable({
            dom: 'Bfrtip',
            responsive: true,
                                    autoWidth: false,

            buttons: [
               {
                   extend: 'pdf',
                   exportOptions: {
                        columns: ':visible'
                    }
               },
               {
                   extend: 'excel',
                   exportOptions: {
                        columns: ':visible'
                    }
               },


            ],
            order: [[ 1, 'desc' ]],
            displayLength: 25,
        });




        var storeCoupon = $('select[name=storeCoupon]').val();
        
        if(storeCoupon == "GC"){
            data_table.columns( [6,7,8,10] ).visible( false );
        }

        $('button.pull_sales_report').on('click', function(e) {
            e.preventDefault();
            var from_date = $('input[name=from_date]').val();
            var to_date = $('input[name=to_date]').val();
            var storeName = $('select[name=storeName]').val();
            var storeCoupon = $('select[name=storeCoupon]').val();

            if(storeName != ''){
                document.title = storeCoupon+' Sales Report ‹ Instead of Flowers — '+storeName+' Store From '+from_date+' To '+to_date;    
            }else{
                document.title = 'RC/GC Sales Report ‹ Instead of Flowers — (GA / FL) Both Store From '+from_date+' To '+to_date;   
            }


            var el = $(this);
            el.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            el.attr('disabled', true);
            $.post(
                ajaxurl,
                {
                    "action": "pull_sales_report",
                    "from_date": from_date,
                    "to_date": to_date,
                    "storeName": storeName,
                    "storeCoupon": storeCoupon,
                }
            )
                .done(function(data) {
                    data_table.destroy();
                   
                    $('table#sales_report').html(data.display);
                    data_table = $('table#sales_report').DataTable({
                        dom: 'Bfrtip',
                        autoWidth: false,
                        buttons: [
                           {
                               extend: 'pdf',
                               exportOptions: {
                                    columns: ':visible'
                               }
                           },
                           {
                               extend: 'excel',
                               exportOptions: {
                                    columns: ':visible'
                                }
                           },

                        ],
                         
                        
                        order: [[ 1, 'desc' ]],
                        displayLength: 25,
                       

                    });
                    el.html('Go');
                    el.attr('disabled', false);
                    if(storeCoupon == ''){
                        
                        var sum_purchase_value = parseFloat($('.sum_purchase_value').val());
                        var sum_current_value = parseFloat($('.sum_current_value').val());
                        var sum_redeem_value = parseFloat($('.sum_redeem_value').val());
                        $('#sales_report_info').before('<span style="float:none;padding: 3px;"><p style="font-size: 19px;    font-weight: 600;text-transform: capitalize;">Summary for selected filter:</p> <B>Total Purchase Value</B>: $'+sum_purchase_value+'<B>&nbsp;&nbsp; Total Current Value </B>: $'+sum_current_value+'&nbsp;&nbsp; <B>Total Redeemed Value </B>: $'+sum_redeem_value+'</span>');
                    }

                    if(storeCoupon == 'GC'){
                        data_table.columns( [6,7,8,10] ).visible( false );
                        var sum_purchase_value = parseFloat($('.sum_purchase_value').val());
                        var sum_current_value = parseFloat($('.sum_current_value').val());
                        var sum_redeem_value = parseFloat($('.sum_redeem_value').val());
                        $('#sales_report_info').before('<span style="float:none;padding: 3px;"><p style="font-size: 19px;    font-weight: 600;text-transform: capitalize;">Summary for selected filter:</p> <B>Total Purchase Value</B>: $'+sum_purchase_value+'<B>&nbsp;&nbsp; Total Current Value </B>: $'+sum_current_value+'&nbsp;&nbsp; <B>Total Redeemed Value </B>: $'+sum_redeem_value+'</span>');
                    }

                    if(storeCoupon == 'RC'){
                        data_table.columns( [4,5] ).visible( false );
                        var sum_purchase_value = parseFloat($('.sum_purchase_value').val());
                        var sum_total_meal_count = parseFloat($('.sum_total_meal_count').val());
                        var sum_remaining_meal_count = parseFloat($('.sum_remaining_meal_count').val());
                        var sum_redeem_value = parseFloat($('.sum_redeem_value').val());
                        var sum_remaining_value = parseFloat($('.sum_remaining_value').val());

                        $('#sales_report_info').before('<span style="float:none;padding: 3px;"><p style="font-size: 19px;    font-weight: 600;text-transform: capitalize;">Summary for selected filter:</p> <B>Total Purchase Value</B>: $'+sum_purchase_value+'<B>&nbsp;&nbsp; Total Meal Count </B>: '+sum_total_meal_count+'&nbsp;&nbsp; <B>Total Remaining Meal </B>: '+sum_remaining_meal_count+'&nbsp;&nbsp; <B>Total Redeemed Value</B>: $'+sum_redeem_value+'&nbsp;&nbsp; <B>Total Remaining Value</B>: $'+sum_remaining_value+'</span>');
                    }



                   
                    
                })
                .fail(function(data) {
                    alert('Sorry, could not fetch the report!');
                });
        });


        



        $('input.date_selector').datepicker({
            format: 'YYYY-MM-DD',
            defaultDate: 'now'
        });
    });
</script>

<div class="wrap" style="background-color: #F1F1F1;">
    <h2><i class="dashicons dashicons-clipboard"></i> RC/GC Sales Report</h2>
    <div class="container">
        <div class="row ml-1 mt-5">
            <div class="col-md-12">
                <form class="form-inline">
                    <label class="mr-1">From</label>
                    <input type="text" name="from_date" class="form-control form-control-sm date_selector" value="<?php echo date("m/d/Y");?>" autocomplete="off">
                    <label class="ml-2 mr-1">To</label>
                    <input type="text" name="to_date" class="form-control form-control-sm date_selector" value="<?php echo date("m/d/Y");?>" autocomplete="off">
                    <select name="storeCoupon" class="ml-1">
                        <?php /*<option value="">All Order</option> */ ?>
                        <option value="RC">RC</option>
                        <option value="GC">GC</option>
                        
                    </select>
                    <select name="storeName" class="ml-1">
                        <option value="">All Store Locations</option>
                        <option value="GA">Georgia Store</option> 
                        <option value="FL">Florida Store</option>
                        
                    </select>
                    <button class="btn btn-sm btn-primary pull_sales_report ml-1">Go</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="sales_report" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="8%">Code</th>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        
                        <th>Purchase Value</th>
                        <th class="rc_hide">Current Value</th>
                        <th class="rc_hide">Usage Count</th>
                        <th class="gc_hide">Total Meal Count</th>
                        <th class="gc_hide">Remaining Meal Count</th>
                        <th class="gc_hide">Redeemed Date(s)</th>
                        <th class="gc_hide">Redeemed Value</th>
                        <th class="gc_hide">Remaining Value</th>
                                               
                       
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($refunds as $refund) { ?>
                        <tr>
                            <td width="8%"><?= $refund['coupon_code'] ?></td>
                            <td><a href="/wp-admin/post.php?post=<?= $refund['order_id'] ?>&action=edit" target="_blank">#<?= $refund['order_id'] ?></a></td>
                            <td><?= $refund['order_date'] ?></td>
                            
                            <td><?= $refund['purchase_value'] ?><input type="hidden" name="sum_purchase_value" class="sum_purchase_value" value="<?= $refund['sum_purchase_value'] ?>"></td>

                            <td class="rc_hide"><?= $refund['current_value'] ?><input type="hidden" name="sum_current_value" class="sum_current_value" value="<?= $refund['sum_current_value'] ?>"></td>

                            <td class="rc_hide"><?= $refund['usage_count'] ?></td>
                            
                            <td class="gc_hide"><?= $refund['total_meal_count'] ?><input type="hidden" name="sum_total_meal_count" class="sum_total_meal_count" value="<?= $refund['sum_total_meal_count'] ?>"></td>
                            <td class="gc_hide"><?= $refund['remaining_meal_count'] ?><input type="hidden" name="sum_remaining_meal_count" class="sum_remaining_meal_count" value="<?= $refund['sum_remaining_meal_count'] ?>"></td>
                             <td class="gc_hide"><?= $refund['child_order'] ?></td>
                              <td class="gc_hide"><?= $refund['redeem_value'] ?><input type="hidden" class="sum_redeem_value" name="sum_redeem_value" value="<?= $refund['sum_redeem_value'] ?>"></td>
                               <td class="gc_hide"><?= $refund['remaining_value'] ?><input type="hidden" name="sum_remaining_value" class="sum_remaining_value" value="<?= $refund['sum_remaining_value'] ?>"></td>
                           
                            
                          
                           
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>