<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

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
<style>
    div#wpcontent {
        background-color: #F1F1F1;
    }

    .dt-buttons, div#order_delivery_report_filter {
        display: none;
        visibility: hidden;
        opacity: 0;
        height: 0;
        width: 0;
        padding: 0;
        margin: 0;
    }

    .itemDetails ul li:first-child {
        font-weight: 500;
    }
    .itemDetails ul li {
        margin: 0px;
    }

    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
</style>

<script>
    $(document).ready(function() {
        
        var data_table = $('table#order_delivery_report').DataTable({
            dom: 'Bfrtip',
            columnDefs: [
                { "visible": false, "targets": 0 }
            ],
            order: [[ 0, 'asc' ]],
            displayLength: 25,
            drawCallback: function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                     if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="6">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                } );
            }
        });

        $('button.pull_order_date_report').on('click', function(e) {
            e.preventDefault();
            var date = $('input[name=date]').val();
            var storeName = $('select[name=storeName]').val();
            var el = $(this);
             el.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            $.post(
                ajaxurl,
                {
                    "action": "pull_order_delivery_report",
                    "date": date,
                    "storeName": storeName,
                }
            ).done(function(data) {
                     data_table.destroy();
					 console.log(data);
                    $('table#order_delivery_report').html(data.display);
                    data_table = $('table#order_delivery_report').DataTable({
                        paging: false,
						dom: 'Bfrtip',
                        columnDefs: [
                            { "visible": false, "targets": 0 }
                        ],
                        order: [[ 0, 'asc' ]],
                        displayLength: 25,
                        drawCallback: function ( settings ) {
                            var api = this.api();
                            var rows = api.rows( {page:'current'} ).nodes();
                            var last=null;

                            api.column(0, {page:'current'} ).data().each( function ( group, i ) {

                                if ( last !== group ) {
                                    $(rows).eq( i ).before(
                                        '<tr class="group"><td colspan="6">'+group+'</td></tr>'
                                    );

                                    last = group;
                                }
                            } );
                        }
                    }); 
                     el.html('Go');
                })
                .fail(function(data) {
                    alert('Sorry, could not fetch the report!');
                });
        });

       
		$('input[name=date]').datepicker({
            format: 'YYYY-MM-DD',
            defaultDate: ''
        });
		
		$(".pull_order_date_report").trigger('click');
    });
</script>

<div class="wrap" style="background-color: #F1F1F1;">
    <h2><i class="dashicons dashicons-clipboard"></i> Kitchen Order Delivery Reports</h2>
    <div class="container">
        <div class="row ml-1 mt-5">
            <div class="col-md-12">
                <form class="form-inline">
                    <input type="text" name="date" class="form-control form-control-sm " value="<?php echo date("m/d/Y");?>">
                    <select name="storeName" class="ml-1">
                        <option value="">All Store Locations</option>
                        <option value="FL">Florida Store</option>
                        <option value="GA">Georgia Store</option>
                    </select>
                    <button class="btn btn-sm btn-primary pull_order_date_report ml-1">Go</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="order_delivery_report" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
						<th>Shipping Method</th>
                        <th>Order ID</th>
                        <th>Product Details</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
							

						if(!empty($arr)){

						foreach($arr as $key => $value){
                            $no = count($value['oid']);
							for($i = 0;$i<$no;$i++){
								?><tr>
									<td><?php echo $value['ship'] ; ?></td>
									<td><?php echo $value['oid'][$i] ; ?></td>
									<td><?php echo $value['product_detail'][$i] ; ?></td>
                                    
								</tr>
							<?php	
							}
							
						}
						
						}
							
									?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>