<thead>
<tr>
     <th>Month</th>
                        <th>Year</th>
                        <th>Purchase Amount</th>



    
</tr>
</thead>
<tbody>
<?php foreach($refunds as $refund) { ?>
    <tr>
         <td><?= $refund['month'] ?></td>
                            <td><?= $refund['year'] ?></td>
                            
                            <td><?= $refund['purchase_value'] ?></td>
                       
    </tr>
<?php } ?>
</tbody>