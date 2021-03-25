<thead>
<tr>
    <th width="8%">Code</th>
    <th>Order Number</th>
    <th>Order Date</th>
    <th>Purchase Value</th>
    <th class="rc_hide">Current Value</th>
    <th class="rc_hide">Usage Count</th>
    <th class="gc_hide">Total Meal Count</th>
    <th class="gc_hide">Remaining Meal Count</th>
        <th class="gc_hide">Redeemed Date(s)</th>
    <th class="gc_hide">Redeemed Value</th>
    <th class="gc_hide">Remaining Value</th>
    
</tr>
</thead>
<tbody>
<?php foreach($refunds as $refund) { ?>
    <tr>
        <td width="8%"><?= $refund['coupon_code'] ?></td>
        <td><a href="/wp-admin/post.php?post=<?= $refund['order_id'] ?>&action=edit" target="_blank">#<?= $refund['order_id'] ?></a></td>
        <td><?= $refund['order_date'] ?></td>
        
       <td><?= $refund['purchase_value'] ?><input type="hidden" name="sum_purchase_value" class="sum_purchase_value" value="<?= $refund['sum_purchase_value'] ?>"></td>
        <td class="rc_hide"><?= $refund['current_value'] ?><input type="hidden" name="sum_current_value" class="sum_current_value" value="<?= $refund['sum_current_value'] ?>"></td>
        <td class="rc_hide"><?= $refund['usage_count'] ?></td>
        <td class="gc_hide"><?= $refund['total_meal_count'] ?><input type="hidden" name="sum_total_meal_count" class="sum_total_meal_count" value="<?= $refund['sum_total_meal_count'] ?>"></td>
        <td class="gc_hide"><?= $refund['remaining_meal_count'] ?><input type="hidden" name="sum_remaining_meal_count" class="sum_remaining_meal_count" value="<?= $refund['sum_remaining_meal_count'] ?>"></td>
         <td class="gc_hide"><?= $refund['child_order'] ?></td>
          <td class="gc_hide"><?= $refund['redeem_value'] ?><input type="hidden" class="sum_redeem_value" name="sum_redeem_value" value="<?= $refund['sum_redeem_value'] ?>"></td>
           <td class="gc_hide"><?= $refund['remaining_value'] ?><input type="hidden" name="sum_remaining_value" class="sum_remaining_value" value="<?= $refund['sum_remaining_value'] ?>"></td>
                           
       
      
    </tr>
<?php } ?>
</tbody>