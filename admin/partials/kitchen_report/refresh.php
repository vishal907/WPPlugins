<div class="row">
	<div class="col-12 mt-4">
		<table class="table table-striped table-bordered" id="kitchen_report">
			<thead class="thead-dark" >
				<tr>
					<th>Type</th>
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
	                <th width="10%">Kitchen Notes</th>
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
								<td class="text-left"><?php echo ( isset( $meal['order_note'] ) ) ?  $meal['order_note'] : ''; ?></td>
							</tr>
						<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>