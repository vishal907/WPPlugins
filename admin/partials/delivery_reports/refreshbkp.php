
                    <thead>

                    <th style="background-color:#fff;padding:10px;width:150px;">Shipping Method</th>

                    <th style="background-color:#fff; padding:10px;"><table width="100%"><tr><td>Order ID</td><!--<td>Product Name/Meal Size</td>--><td>Shipping Address</td><td>Phone</td><td>Order Comments</td></tr></table></th>

                    </thead>

                    <tbody>

                    <?php 

					if(!empty($arr)){

					foreach($arr as $key => $value){?><tr>

                    <td style="background-color:#fff;"><?php echo $value['ship']; ?></td>

                    <td style="background-color:#fff;">

					<table width="100%" cellpadding="0" cellspacing="0" class="product_dt">

                 	<?php 

					$nooford=count($value['oid']);

					$i=0;

					

					$pre_oid=array();

					

					$new_values=array();

					while($i < $nooford ){

						if($value['meal_size'][$i])

						$meal="<br/><strong>Meal size: </strong>".$value['meal_size'][$i];

						else

						$meal='';

					if(!in_array($value['oid'][$i], $pre_oid, true )){

						$pre_oid[]=$value['oid'][$i];

						$new_values[$value['oid'][$i]]=array('or_id'=>$value['oid'][$i], 'item_n'=>array($value['item_name'][$i].$meal ),'ship_ad'=>$value['ship_address'][$i],'ph'=>$value['phone'][$i],'or_com'=>$value['order_comment'][$i] );

					

					}

					else{

						$ts1=$new_values[$value['oid'][$i]]['item_n'];

					array_push($ts1, $value['item_name'][$i].$meal);

					$new_values[$value['oid'][$i]]['item_n']=$ts1;

					

					/*$m_s=$new_values[$value['oid'][$i]]['meal_s'];

					array_push($m_s, $value['meal_size'][$i]);

					$new_values[$value['oid'][$i]]['meal_s']=$m_s;*/

						}

								$i++;

						}

						

						foreach($new_values as $key => $v){

						echo '<tr><td>'.$v['or_id'].'</td>';

						//echo '<td >'.implode('<br/><br/>', $v['item_n']).'</td><td>'.$v['ship_ad'].'</td><td>'.$v['ph'].'</td><td>'.$v['or_com'].'</td></tr>';

						echo '<td>'.$v['ship_ad'].'</td><td>'.$v['ph'].'</td><td>'.$v['or_com'].'</td></tr>';

						}

				

					?>

                    </table>

                        </td>

                    </tr>

                    <?php }

					}
				
					?>

                    </tbody>
