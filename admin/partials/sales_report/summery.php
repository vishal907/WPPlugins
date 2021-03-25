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
        var data_table = $('table#sales_report').DataTable({
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
            order: [[ 1, 'asc' ]],
            displayLength: 25,
        });

    

       


    });
</script>

<div class="wrap" style="background-color: #F1F1F1;">
    <h2><i class="dashicons dashicons-clipboard"></i> GC Summary (January 2019 TO October 2020) Report</h2>
    <div class="container">
        
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="sales_report" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Purchase Amount</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($refunds as $refund) { ?>
                        <tr>
                            <td><?= $refund['month'] ?></td>
                            <td><?= $refund['year'] ?></td>
                            
                            <td><?= $refund['purchase_value'] ?></td>
                       
                           
                            
                          
                           
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>