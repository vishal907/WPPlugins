<?php 
	if(!empty($arr)){
		$order_ids_arr = array();
		foreach($arr as $key => $value){
			$no = count($value['order_ids']);
			for($i = 0;$i<$no;$i++){
				$order_ids_arr[] = $value['order_ids'][$i] ;
			}
		}
	}
	$order_ids_arr = array_reverse(array_unique($order_ids_arr));
    $array_chunk = array_chunk($order_ids_arr, 50);
    $order_ids1 = array();
    foreach ($array_chunk as $order_ids) {
         $order_ids1[] = implode('x', $order_ids);
    }

    $implode_order_ids = implode(',', $order_ids1);
?>
<thead>
<tr>
	<th>Shipping Method</th>
	<th>Order ID</th>
	 <th>Shipping Address</th>
	  <th>Total Orders</th>
	<th>Phone</th>
</tr>
</thead>
<tbody>
	<?php 
	if(!empty($arr)){
		foreach($arr as $key => $value){
			$no = count($value['oid']);
			for($i = 0;$i<$no;$i++){
				?><tr>
					<td><?php echo $value['ship'] ; ?> </td>
					<td><?php echo $value['oid'][$i] ; ?> </td>
					<td><?php echo $value['ship_address'][$i] ; ?> </td>
					<td><?php echo $value['counter'][$i] ; ?> </td>
					<td><?php echo $value['phone'][$i] ; ?> </td>
					<input type="hidden" name="package_slipIds" class="package_slipIds" value="<?php echo $implode_order_ids; ?>">
				</tr>
			<?php	
			}
		}
	}

	
	?>


</tbody>
</table>