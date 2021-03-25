<thead>
<tr>
	<th>Shipping Method</th>
	<th>Order ID</th>
	<th>Note Cards</th>
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
					<td class="myComment"><?php echo $value['order_comment'][$i] ; ?></td>
				</tr>
			<?php	
			}
		}
	}
	?>
</tbody>
</table>