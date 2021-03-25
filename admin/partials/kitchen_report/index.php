<!-- CSS Styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

<!-- JS Scripts -->
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>


<style>
	#ignition-helper-product-activation-message {
		display: none;
	}
	#kitchen-report table thead {
		display: none;
	}
</style>

<!-- Report Warp -->
<div class="wrap container kitchen-report">
    <h3 class="border-bottom-1 mb-3" >Welcome to the Kitchen Report</h3>

	<div class="row">
		<div class="date-filter col-12">
			<form class="form-inline">
				<h5 class="mb-0 mr-2">Delivery Date: </h5>
	            <input type="text" name="date" class="form-control form-control-sm" data-date-format="YYYY-MM-DD" value="<?php echo date("Y-m-d");?>">
	            <select name="storeName">
                        <option value="">All Store Locations</option>
                        <option value="FL">Florida Store</option>
                        <option value="GA">Georgia Store</option>
                    </select>
	            <button class="btn btn-sm btn-primary pull_date_report ml-1">Go</button>
	        </form>
	    </div>
		
		<div id="kitchen-report" class="col-12">
			<div class="row">
				<div class="col-12 mt-4">
					<table class="table table-striped table-bordered" id="kitchen_report">
						<thead class="thead-dark" >
							<tr>
								<th width="20%">Type</th>
								<th>1</th>
				                <th>2&nbsp;(S)</th>
				                <th>3</th>
				                <th>4&nbsp;(M)</th>
				                <th>5</th>
				                <th>6&nbsp;(L)</th>
				                <th>3&nbsp;(S)</th>
				                <th>6&nbsp;(M)</th>
				                <th>9&nbsp;(L)</th>
				                <th>12&nbsp;(EL)</th>
				                <th width="43%" style="text-align: center;">Kitchen Notes</th>
				            </tr>
						</thead>
						<tbody>
							<?php foreach ( $meals as $key => $meal_type ): ?>
									<?php ksort($meal_type); ?>
									<tr class="thead-dark">
										<th width="20%"><?php echo ucfirst( $key ); ?></td>
						                <th>1</th>
						                <th>2&nbsp;(S)</th>
						                <th>3</th>
						                <th>4&nbsp;(M)</th>
						                <th>5</th>
						                <th>6&nbsp;(L)</th>
						                <th>3&nbsp;(S)</th>
						                <th>6&nbsp;(M)</th>
						                <th>9&nbsp;(L)</th>
						                <th>12&nbsp;(EL)</th>
						                <th width="43%" style="text-align: center;">Kitchen Notes</th>
									</tr>
									<?php foreach ( $meal_type as $key => $meal ): ?>
										<tr>
											<td><?php echo $key; ?></td>
												<td class="text-center"><?php echo ( isset( $meal['gourmet-meal-for-1'] ) ) ? $meal['gourmet-meal-for-1'] : ''; ?></td>
											<td class="text-center"><?php echo ( isset( $meal['gourmet-meal-for-2'] ) ) ? $meal['gourmet-meal-for-2'] : ''; ?></td>
											<td class="text-center"><?php echo ( isset( $meal['gourmet-meal-for-3'] ) ) ? $meal['gourmet-meal-for-3'] : ''; ?></td>
											<td class="text-center"><?php echo ( isset( $meal['gourmet-meal-for-4'] ) ) ? $meal['gourmet-meal-for-4'] : ''; ?></td>
											<td class="text-center"><?php echo ( isset( $meal['gourmet-meal-for-5'] ) ) ? $meal['gourmet-meal-for-5'] : ''; ?></td>
											<td class="text-center"><?php echo ( isset( $meal['gourmet-meal-for-6'] ) ) ? $meal['gourmet-meal-for-6'] : ''; ?></td>
												<td class="text-center"><?php echo ( isset( $meal['three_small'] ) ) ? $meal['three_small'] : ''; ?></td>
								<td class="text-center"><?php echo ( isset( $meal['six_medium'] ) ) ? $meal['six_medium'] : ''; ?></td>
								<td class="text-center"><?php echo ( isset( $meal['nine_large'] ) ) ? $meal['nine_large'] : ''; ?></td>
								<td class="text-center"><?php echo ( isset( $meal['twelve_large'] ) ) ? $meal['twelve_large'] : ''; ?></td>
											<td class="text-left"><?php echo ( isset( $meal['order_note'] ) ) ? $meal['order_note'] : ''; ?></td>
										</tr>
									<?php endforeach; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>