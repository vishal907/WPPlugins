<thead>
<tr>
    <th>Billing First Name</th>
    <th>Billing Last Name</th>
    <th>Company Name</th>
    <th>Email Address</th>
    <th>Order Count</th>
    <th>Amount</th>
</tr>
</thead>
<tbody>
<?php foreach($refunds as $refund) { ?>
    <tr>
          <td><?= $refund['billing_first_name'] ?></td>
            <td><?= $refund['billing_last_name'] ?></td>
            
            <td><?= $refund['billing_company'] ?></td>
            <td><?= $refund['billing_email'] ?></td>
            <td><?= $refund['order_count'] ?><input type="hidden" name="sum_refund_value" class="sum_refund_value" value="<?= $refund['sum_refund_value'] ?>"></td>
            <td><?= $refund['purchase_value'] ?><input type="hidden" name="sum_purchase_value" class="sum_purchase_value" value="<?= $refund['sum_purchase_value'] ?>"></td>


    </tr>
<?php } ?>
</tbody>