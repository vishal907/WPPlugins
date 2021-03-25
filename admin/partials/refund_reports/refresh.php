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