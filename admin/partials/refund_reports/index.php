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
        var data_table = $('table#refund_report').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [[ 0, 'asc' ]],
            displayLength: 25,
        });

        $('button.pull_date_report').on('click', function(e) {
            e.preventDefault();
            var from_date = $('input[name=from_date]').val();
            var to_date = $('input[name=to_date]').val();
            var storeName = $('select[name=storeName]').val();
            var el = $(this);
            el.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            el.attr('disabled', true);
            $.post(
                ajaxurl,
                {
                    "action": "pull_refund_report",
                    "from_date": from_date,
                    "to_date": to_date,
                    "storeName": storeName,
                }
            )
                .done(function(data) {
                    data_table.destroy();
                    $('table#refund_report').html(data.display);
                    data_table = $('table#refund_report').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        order: [[ 0, 'asc' ]],
                        displayLength: 25,
                    });
                    el.html('Go');
                    el.attr('disabled', false);
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
    <h2><i class="dashicons dashicons-clipboard"></i> Refund Reason Reports</h2>
    <div class="container">
        <div class="row ml-1 mt-5">
            <div class="col-md-12">
                <form class="form-inline">
                    <label class="mr-1">From</label>
                    <input type="text" name="from_date" class="form-control form-control-sm date_selector" autocomplete="off">
                    <label class="ml-2 mr-1">To</label>
                    <input type="text" name="to_date" class="form-control form-control-sm date_selector" autocomplete="off">
                    <select name="storeName" class="ml-1">
                        <option value="">All Store Locations</option>
                        <option value="FL">Florida Store</option>
                        <option value="GA">Georgia Store</option>
                    </select>
                    <button class="btn btn-sm btn-primary pull_date_report ml-1">Go</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="refund_report" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        <th>Billing Name</th>
                        <th>Billing Address</th>
                        <th>Billing Phone</th>
                       
                        <th>Grand Total</th>
                        <th>Refunded Amount</th>
                        <th>Reason For Refund</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($refunds as $refund) { ?>
                        <tr>
                            <td><a href="/wp-admin/post.php?post=<?= $refund['order_id'] ?>&action=edit" target="_blank">#<?= $refund['order_id'] ?></a></td>
                            <td><?= $refund['order_date'] ?></td>
                            <td><?= $refund['billing_name'] ?></td>
                            <td><?= $refund['billing_address'] ?></td>
                            <td><?= $refund['billing_phone'] ?></td>
                            <td><?= $refund['grand_total'] ?></td>
                            <td><?= $refund['refunded_amount'] ?></td>
                            <td><?= $refund['reason'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>