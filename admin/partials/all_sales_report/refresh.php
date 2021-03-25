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
        <td><?= $refund['order_date'] ?></td>
        
        <td><?= $refund['purchase_value'] ?><input type="hidden" name="sum_purchase_value" class="sum_purchase_value" value="<?= $refund['sum_purchase_value'] ?>"></td>
        <td><?= $refund['refund_value'] ?><input type="hidden" name="sum_refund_value" class="sum_refund_value" value="<?= $refund['sum_refund_value'] ?>"></td>
    </tr>
<?php } ?>
</tbody>