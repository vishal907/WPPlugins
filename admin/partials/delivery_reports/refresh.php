<thead>
<tr>
	<th>Shipping Method</th>
	<th>Order ID</th>
	  <th>Shipping Address</th>
	  <th>Total Orders</th>
	<th>Phone</th>
	<th>Order Comments</th>
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
					<td><?php echo $value['order_comment'][$i] ; ?> </td>
				</tr>
			<?php	
			}
		}
	}
	?>
</tbody>
</table>