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
    div#mainDIV{
        max-width: 80% !important;
    }
    div#wpcontent {
        background-color: #F1F1F1;
    }

</style>

<script>
    $(document).ready(function() {

        var data_table = $('table#all_quickbooks_report').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
              
               {
                   extend: 'excel',
                   exportOptions: {
                        columns: ':visible'
                    }
               },


            ],
            order: [[ 3, 'asc' ]],
            displayLength: 25,
        });

        var storeCoupon = $('select[name=storeCoupon]').val();
        if(storeCoupon == ""){
            data_table.columns( [6,7,8,9,10] ).visible( false );
        }

        $('button.pull_all_quickbooks_report').on('click', function(e) {
            e.preventDefault();
            var from_date = $('input[name=from_date]').val();
            var to_date = $('input[name=to_date]').val();
            var storeName = $('select[name=storeName]').val();
            var onlyForCorporate = $('#onlyForCorporate').val();
            

            if(storeName != ''){
                document.title = 'Corporate Sales Report ‹ Instead of Flowers — '+storeName+' Store From '+from_date+' To '+to_date;    
            }else{
                document.title = 'All Corporate Sales Report ‹ Instead of Flowers — (GA / FL) Both Store From '+from_date+' To '+to_date;   
            }


            var el = $(this);
            el.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            el.attr('disabled', true);
            $.post(
                ajaxurl,
                {
                    "action": "pull_all_quickbooks_report",
                    "from_date": from_date,
                    "to_date": to_date,
                    "storeName": storeName,
                    "onlyForCorporate": onlyForCorporate,
                    // "storeCoupon": storeCoupon,
                }
            )
                .done(function(data) {

                    data_table.destroy();
                   // $('div#customEmailFimter').html(data.emailFilterCommaseprated);

                   
                    $('table#all_quickbooks_report').html(data.display);

                    data_table = $('table#all_quickbooks_report').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        buttons: [
                          
                           {
                               extend: 'excel',
                               exportOptions: {
                                    columns: ':visible'
                                }
                           },

                        ],
                        
                        order: [[ 3, 'asc' ]],
                        displayLength: 25,
                    });
                    el.html('Go');
                    el.attr('disabled', false);

                    var sum_purchase_value = parseFloat($('.sum_purchase_value').val());
                    var sum_refund_value = parseFloat($('.sum_refund_value').val());

                    $('#all_quickbooks_report_info').before('<span style="float:none;padding: 3px;"><p style="font-size: 19px;    font-weight: 600;text-transform: capitalize;">Summary for selected filter:</p> <B>Total Order Value</B>: $'+sum_purchase_value+'<B>&nbsp;&nbsp; Total Order Count </B>: '+sum_refund_value+'</span>');
                    
                })
                .fail(function(data) {
                    alert('Sorry, could not fetch the report!');
                });


        });

    
        $('input.date_selector').datepicker({
            format: 'YYYY-MM-DD',
            defaultDate: 'now'
        });


        $('#onlyForCorporate').click(function(e){
           if(this.checked) {
                $(this).val(1);
           }else{
                $(this).val(0);
           }
        });
              

    });
</script>

<div class="wrap" style="background-color: #F1F1F1;">
    <h2><i class="dashicons dashicons-clipboard"></i> Corporate Sales Report</h2>
    <div class="container" id="mainDIV">
        <div class="row ml-1 mt-5">
            <div class="col-md-12">
                <form class="form-inline">
                    <label class="mr-1">From</label>
                    <input type="text" name="from_date" class="form-control form-control-sm date_selector" value="<?php echo date("m/d/Y");?>" autocomplete="off">
                    <label class="ml-2 mr-1">To</label>
                    <input type="text" name="to_date" class="form-control form-control-sm date_selector" value="<?php echo date("m/d/Y");?>" autocomplete="off">
                
                    <select name="storeName" class="ml-1">
                        <option value="">All Store Locations</option>
                        <option value="FL">Florida Store</option>
                        <option value="GA">Georgia Store</option>
                    </select>

                    <div class="ml-2 mr-3"> <input type="checkbox" name="onlyForCorporate" value="1" id="onlyForCorporate" checked="checked"> Corporate Users</div>

                    <button class="btn btn-sm btn-primary pull_all_quickbooks_report ml-1">Go</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">

                <table id="all_quickbooks_report" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
                    <thead>

                    <tr>
                        <th>Billing First Name</th>
                        <th>Billing Last Name</th>
                        <th>Company Name</th>
                        <th>Email Address</th>
                        <th>Order Count</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($refunds as $refund) { ?>
                        <tr>
                            <td><?= $refund['billing_first_name'] ?></td>
                            <td><?= $refund['billing_last_name'] ?></td>
                            
                            <td><?= $refund['billing_company'] ?></td>
                            <td><?= $refund['billing_email'] ?></td>
                            <td><?= $refund['order_count'] ?><input type="hidden" name="sum_refund_value" class="sum_refund_value" value="<?= $refund['sum_refund_value'] ?>"></td>
                            <td><?= $refund['purchase_value'] ?><input type="hidden" name="sum_purchase_value" class="sum_purchase_value" value="<?= $refund['sum_purchase_value'] ?>"></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

