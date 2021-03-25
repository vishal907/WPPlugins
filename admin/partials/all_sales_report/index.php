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
</style>

<script>
    $(document).ready(function() {
        var data_table = $('table#all_sales_report').DataTable({
            dom: 'Bfrtip',
            responsive: true,
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
        if(storeCoupon == ""){
            data_table.columns( [6,7,8,9,10] ).visible( false );
        }

        $('button.pull_all_sales_report').on('click', function(e) {
            e.preventDefault();
            var from_date = $('input[name=from_date]').val();
            var to_date = $('input[name=to_date]').val();
            var storeName = $('select[name=storeName]').val();
            var storeCoupon = $('select[name=storeCoupon]').val();

            if(storeName != ''){
                document.title = storeCoupon+' Sales Report ‹ Instead of Flowers — '+storeName+' Store From '+from_date+' To '+to_date;    
            }else{
                document.title = 'All Sales report ‹ Instead of Flowers — (GA / FL) Both Store From '+from_date+' To '+to_date;   
            }


            var el = $(this);
            el.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            el.attr('disabled', true);
            $.post(
                ajaxurl,
                {
                    "action": "pull_all_sales_report",
                    "from_date": from_date,
                    "to_date": to_date,
                    "storeName": storeName,
                    // "storeCoupon": storeCoupon,
                }
            )
                .done(function(data) {
                    data_table.destroy();
                   
                    $('table#all_sales_report').html(data.display);
                    data_table = $('table#all_sales_report').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
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

                    var sum_purchase_value = parseFloat($('.sum_purchase_value').val());
                    var sum_refund_value = parseFloat($('.sum_refund_value').val());

                    $('#all_sales_report_info').before('<span style="float:none;padding: 3px;"><p style="font-size: 19px;    font-weight: 600;text-transform: capitalize;">Summary for selected filter:</p> <B>Total Purchase Value</B>: $'+sum_purchase_value+'<B>&nbsp;&nbsp; Total Refund Value </B>: $'+sum_refund_value+'</span>');
                    
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
    <h2><i class="dashicons dashicons-clipboard"></i> All Sales Report</h2>
    <div class="container">
        <div class="row ml-1 mt-5">
            <div class="col-md-12">
                <form class="form-inline">
                    <label class="mr-1">From</label>
                    <input type="text" name="from_date" class="form-control form-control-sm date_selector" value="<?php echo date("m/d/Y");?>" autocomplete="off">
                    <label class="ml-2 mr-1">To</label>
                    <input type="text" name="to_date" class="form-control form-control-sm date_selector" value="<?php echo date("m/d/Y");?>" autocomplete="off">
                  <!--   <select name="storeCoupon" class="ml-1">
                        <option value="">All GC/RC</option>
                        <option value="GC">GC</option>
                        <option value="RC">RC</option>
                    </select> -->
                    <select name="storeName" class="ml-1">
                        <option value="">All Store Locations</option>
                        <option value="FL">Florida Store</option>
                        <option value="GA">Georgia Store</option>
                    </select>
                    <button class="btn btn-sm btn-primary pull_all_sales_report ml-1">Go</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="all_sales_report" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        
                        <th>Purchase Value</th>
                        <th>Refund Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($refunds as $refund) { ?>
                        <tr>
                            <td><a href="/wp-admin/post.php?post=<?= $refund['order_id'] ?>&action=edit" target="_blank">#<?= $refund['order_id'] ?></a></td>
                            <td><?= $refund['order_date'] ?><input type="hidden" name="sum_purchase_value" class="sum_purchase_value" value="<?= $refund['sum_purchase_value'] ?>"></td>
                            
                            <td><?= $refund['purchase_value'] ?></td>
                            <td><?= $refund['refund_value'] ?><input type="hidden" name="sum_refund_value" class="sum_refund_value" value="<?= $refund['sum_refund_value'] ?>"></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>