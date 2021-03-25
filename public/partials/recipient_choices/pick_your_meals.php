
<div class="pick_your_meals_container">
    <div class="card">
        <div class="card-header">
            <?php if ( is_user_logged_in() ) { }else{?>
                <div class="row">
                    <div class="offset-lg-3 col-lg-6 text-center mb-4">We encourage you to register or login to better manage your meal selections and allow you to make delivery date selections at your convenience.</div>
                </div>
            <?php } ?>
                <div class="row align-items-center">
                    <div class="col-lg-6 text-left"> Pick Your Meals! </div>
                    <div class="col-lg-6 text-right"> 
                    <?php if ( is_user_logged_in() ) { ?>
                        <button class="addMyWalletBtn">Add to my Account</button>
                    <?php } else { ?>
                        <button type="button" id="logingRegister" class="addMyWalletBtn" data-toggle="modal" data-target="#loginRegisterModal" data-backdrop="static" data-keyboard="false">Login/Register</button>
                    <?php   include_once( 'modals/loginRegisterModal.php' ); } ?>
                </div>
            </div>
        </div>
        <?php //echo "<pre>"; print_r($order_details['recipient_choices']); echo "</pre>"; ?>
        <div class="card-body">
            <div class="alert alert-success" role="alert">
                <div class="row">
                    <div class="col text-left">
                        <?php foreach($order_details['recipient_choices'] as $choice) {
                            $totalNumberOFDeliveries[] = $choice['iof_redeem_orders'];
                        }?>
                        <?php if(!empty($totalNumberOFDeliveries)){?>
                            <small class="text-success"><strong>Woohoo!</strong> You have <span class="totalNumberOFDeliveries"><?= array_sum($totalNumberOFDeliveries); ?></span> meal(s) to pick.</small>
                            <input type="hidden" name="iof_redeem_orders_hidden" value="<?= array_sum($totalNumberOFDeliveries); ?>">
                        <?php } ?>                        
                    </div>
                    <div class="col text-right hidden-xs">    
                        <a class="text-success pull-right show_me_how">Show me how</a>
                    </div>  
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col text-right"> 
                    <button class="btn btn-sm btn-success pull-right review_complete_deliveries">Review &amp; Confirm</button>
                </div>
            </div>  
            <div class="alert alert-warning hidden-xs yourMeals" role="alert">
                <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                <div class="row align-items-center">
                    <div class="col yourMealsLeft">
						<h3 class="mb-4">How to reedem your meal</h3>
                        <div class="ymrTitle">
                            <span class="badge badge-warning">NEW</span>
                            <span class="">Welcome to our new recipient choice redeem tool.</span>
                        </div>
                        <ol class="ymrList mb-4">
                            <li>Use the <strong>checkbox</strong> at the top right of the meal to select the meal you would like delivered from the categories presented</li>
                            <li>Use the <strong>Change</strong> buttons to the right of each of your selected meal's sides to change your sides as needed.</li>
                            <li>Use the <strong>Choose a delivery date </strong>on the date picker presented to the right of the website to select the date you would like your selected meal(s) to be delivered.</li>
                            <li>Repeat the process for each meal if you have multiple meals to pick.</li>
                            <li>Your scheduled delivery will be presented at the top of the meal list. Click <strong>Review & Confirm</strong> to proceed tot he next step.</li>
                        </ol> 
						<p><em>We encourage you to <a class="text-success" href="#" data-toggle="modal" data-target="#loginRegisterModal" data-backdrop="static" data-keyboard="false"><strong>register</strong></a> or <a class="text-success" href="#" data-toggle="modal" data-target="#loginRegisterModal" data-backdrop="static" data-keyboard="false"><strong>login</strong></a> and add your recipient's Choice code to your account. This will help you to better manage your meal selections and allow you to order your meals at your convenience.</em></p>
                    </div>
                    <?php /* <div class="col yourMealsRight">
                         <h3>How to reedem your meal</h3>
                        <iframe width="400" height="200" src="https://www.youtube.com/embed/-yAvCT_v3qQ" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>                     
                    </div> */ ?>
                </div>
            </div>

            <!-- Nav tabs -->
            <input type="hidden" name="recipient_code" value="<?= $order_details['coupon'] ?>">

            <!-- PRODUCTS TAB -->
            <ul class="nav nav-pills flex-column flex-sm-row" id="RCTab" role="tablist">
                <?php $i = 0; foreach($order_details['recipient_choices'] as $choice) { $i++; ?>
                    <?php if($choice['iof_redeem_orders'] != 0) {?> 
                        <li class="nav-item" role="presentation" >
                            <a class="<?php if($i == 1) { echo 'active'; } ?> nav-link" href="<?= '#tab'.$i ?>" aria-controls="<?= '#tab'.$i ?>" data-choiceid="<?php echo $choice['id']; ?>" role="tab" aria-selected="true" data-toggle="tab">
                                <span class="badge badge-light"><?= $choice['iof_redeem_orders']; ?></span> <small><?= $choice['title'] ?></small>

                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
            
            <div class="tab-content" id="">

                 <?php
                 if($cut_off_arr = get_option('iof_cut_off_times', false)) {
                    date_default_timezone_set('America/New_York');

                    $tmp = json_decode($cut_off_arr);
                    $courier = $tmp->courier_cut_off;
                    $outsourced = $tmp->outsourced_cut_off;
                    
                  
                    $current_time = date('h:i A');
                    $cut_off_time = $courier;
                    $dates_tomorrow = "false";
                    if(strtotime($current_time) >= strtotime($cut_off_time) ){
                        $dates_tomorrow = "true";
                    }

                }
                ?>
                <?php $j = 0;  foreach($order_details['recipient_choices'] as $choice) { $j++;  ?>
                    <div role="tabpanel" class="tab-pane choice_container choice_container_<?= $choice['id'] ?>
                        <?php if($j == 1) { echo 'active'; } ?>" id="<?= 'tab'.$j ?>">
                        <div class="row deliveriesInto">
                            <div class="col-md-12">
                                    <div class="text-success">Select one or more meals below then choose a delivery date for your selected meals.</div>
                            </div>
                        </div>
                        <div class="row chooseDelivery">
                            <div class="chooseDeliveryLeft hideDiv">
                                    <h5>Choose a delivery date</h5>
                                    <div class="CDForm">
                                        <input type='text' class="form-control form-control-sm pick_delivery_date" onkeydown="return false"/>
                                        <input type="hidden" class="choice_qty" name="_choice_qty_<?= $choice['id'] ?>" value="<?= $choice['qty'] ?>">
                                        <input type="hidden" class="num_delivery" name="_num_delivery_<?= $choice['id'] ?>" value="<?= $choice['iof_redeem_orders'] ?>">
                                        <input type="hidden" class="num_qty" name="_num_qty_<?= $choice['id'] ?>" value="0">
                                        <input type="hidden" class="num_tot_qty" name="_num_total_deleveries<?= $choice['id'] ?>" value="<?= $order_details['totoal_number_of_deliveries']; ?>">
                                        <input type="hidden" class="shipping_data_method_id" name="shipping_data_method_id" value="<?= $order_details['shipping_data_method_id']; ?>">
                                        <input type="hidden" class="dates_tomorrow" name="dates_tomorrow" value="<?= $dates_tomorrow; ?>">
                                      <button class="btn btn-info btn-sm add_meals_delivery" data-item_id="<?= $choice['id'] ?>">Add Delivery!</button>
                                    </div>
                                    <p class="text-success text-info"><small>You have <span class="totalOrderPending">(<?= $choice['iof_redeem_orders'] ?>)</span> deliveries for this item!</small></p>
                            </div>
                            <div class="col-md-12 MealOfMonthError_<?= $choice['id'] ?>"></div>
                            <div class="col-md-12 deliveriesDetails deliveries_details_<?= $choice['id'] ?>">

                            </div>
                        </div>
               

                            <div class="row breads_radio_buttons RCRedioSection">
                                    <?php $n=0; foreach ( $choice['meals'] as $meal ) { $n++; ?>
                                       <div class="col-lg-4 col-md-6 col-sm-12 RCRedioInner">
                                            <div class="thumbnail devThum meal_container_<?= $meal['id']?>">
                                                <div class="meal_details">
                                                    <input type="hidden" name="_meal_id" value="<?= $meal['id']?>" data-mealTitle="<?php echo $meal["title"]; ?>" />

                                                    <div class="checkbox checkbox-success" style="position:absolute; right:-16px; top: -11px;">

                                                        <input type="checkbox" name="meal_<?= $meal['id'] ?>" data-meal_id="<?= $meal['id'] ?>" data-item_id="<?= $choice['id'] ?>"
                                                               id="radio<?=$j.$n?>" value="<?=$meal['id']?>" >
                                                        <label for="radio<?=$j.$n?>"></label>
                                                    </div>
                                                    <?php echo $meal["image"]; ?>
                                                     <div class="caption">
                                                        <h5><?php echo $meal["title"]; ?></h5>
                                                        <input type="hidden" name="meal_title" value="<?php echo $meal["title"]; ?>">
                                                    </div>
                                                    <?php if(strlen($meal['small_description'])) { ?>
                                                        <p class="hidden-xs">
                                                            <small >
                                                                <?php echo $meal['small_description']; ?>
                                                                <?php if(strlen($meal['small_description']) != strlen($meal['short_description']))  { ?>
                                                                    ...<a href="#" class="meal_desc_pop btn-link">show all</a>
                                                                <?php } ?>
                                                            </small>
                                                        </p>
                                                    <?php } ?>
                                                </div>
                                                <table class="rcSides" cellspacing="0">
                                                    <tbody>
                                                         <?php  foreach ($meal['sides'] as $key => $value) { 
                                                                if(trim(strtolower($key)) == 'side'){
                                                                    $modalOpen = '#side-one-modal'.$choice['id'].$meal['id'];
                                                                    $title = 'side-title';
                                                                }else if(trim(strtolower($key)) == 'vegetable'){
                                                                    $modalOpen = '#side-two-modal'.$choice['id'].$meal['id'];
                                                                    $title = 'vegetable-title';
                                                                }else if(trim(strtolower($key)) == 'salad'){
                                                                    $modalOpen = '#salad-modal'.$choice['id'].$meal['id'];
                                                                    $title = 'salad-title';
                                                                }else if(trim(strtolower($key)) == 'bread'){
                                                                    $modalOpen = '#bread-modal'.$choice['id'].$meal['id'];
                                                                    $title = 'bread-title';
                                                                }else if(trim(strtolower($key)) == 'dessert'){
                                                                    $modalOpen = '#dessert-modal'.$choice['id'].$meal['id'];
                                                                    $title = 'dessert-title';
                                                                }
                                                          ?>
                                                            <?php  if(trim(strtolower($value)) != 'none') { ?>
                                                                <tr class="iofSidesDetails">
                                                                    <td class="rcSidesTitle"><?= ($key=='Side')?'Starch':$key; ?>:</td>
                                                                    <td class="rcSidesName <?= $title; ?><?= $choice['id']?><?=$meal['id']?>"><?= $value ?> <input type="hidden" class="_meal_side_<?= $choice['id']?><?= $meal['id']?>" name="_<?= $key?>" value="<?= $value ?>"></td>
                                                        <?php if(trim(strtolower($value)) != 'none') { ?>
                                                            <td class="rcSideChange"><button type="button" class="btn ibtn" data-toggle="modal" data-target="<?php echo $modalOpen; ?>" data-mealid="<?php echo $meal["id"]; ?>" data-backdrop="static" data-keyboard="false">Change</button></td>
                                                        <?php } ?>


                                                                </tr>
                                                              
                                                            <?php } ?>

      

                                                        <?php } ?>
                                                        
                                                    </tbody>
                                                </table>


                                                <div class="RCBtns">
                                                    <input type="number" class="form-control form-control-sm rcBtnInput" min="1" value="1" name="qty" style="display: none !important;">
                                                    <a href="#" class="btn btn-block btn-success pick_btn_toggle" data-meal_id="<?= $meal['id'] ?>"
                                                         data-item_id="<?= $choice['id'] ?>">Pick!</a>
                                                </div>

                                                  <?php 

                                                    $currentdate = date('F');
                                                    $option_fields = get_fields( 'option' );
                                                    if($currentdate == 'January') {
                                                        if($option_fields['january_month']) :
                                                           $pro_url = array(5687,5692,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'February') {
                                                        if($option_fields['february_month']) :
                                                          $pro_url = array(5588,5711,5677,5687,5692,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'March') {
                                                        if($option_fields['march_month']) :
                                                            $pro_url = array(5588,5711,5677,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'April') {
                                                        if($option_fields['april_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'May') {
                                                        if($option_fields['may_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5697,5702,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);

                                                        endif;
                                                    }
                                                    if($currentdate == 'June') {
                                                        if($option_fields['june_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5697,5702,5707,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'July') {
                                                        if($option_fields['july_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5697,5702,5707,5715,5719,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'August') {
                                                        if($option_fields['august_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5697,5702,5707,5715,5719,5723,5650,5646,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'September') {
                                                        if($option_fields['september_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5697,5702,5707,5715,5719,5723,5727,5732,5655,5660,5665,5823,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'October') {
                                                        if($option_fields['october_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5660,5665,5823);
                                                        endif;
                                                    }
                                                    if($currentdate == 'November') {
                                                        if($option_fields['november_month']) :
                                                            $pro_url = array(5588,5711,5677,5692,5687,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,30002184994);
                                                        endif;
                                                    }
                                                    if($currentdate == 'December') {
                                                        if($option_fields['december_month']) :
                                                            $pro_url = array(5687,5692,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                                                          
                                                        endif;
                                                    } 

                                                     
                                                    ?>
                                              
                                                <?php foreach ($meal['sides'] as $key => $value) : ?>

                                                    <?php if(trim(strtolower($key)) == 'side' && trim(strtolower($value)) != 'none'): ?>
                                                        <div id="side-one-modal<?php echo $choice['id'].$meal['id']; ?>" class="modal fade AllinonePopup" role="dialog">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Starches</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 sides_radio_buttons sideInner">

                                                                                <?php $o=0; foreach ( $meal['available_sides'] as $side ) { $o++; 
                                                                                      if(!in_array($side["id"], $pro_url)){
                                                                                    ?>
                                                                                    <div class="thumbnail <?php if( strcmp($value, $side['title']) == 0 ) { echo 'item-selected'; } ?>">
                                                                                        <div class="iofSideImage-<?php echo $side['id']; ?>"><img src="<?php echo $side["image"]; ?>" /></div>
                                                                                        <div class="caption">
                                                                                            <p><?php echo $side["title"]; ?>
                                                                                                <br><small class="text-success"><i><?php if( strcmp($value, $side['title']) == 0 ) { echo 'Default selection'; }
                                                                                                ?></i></small></p>
                                                                                            <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                                                                
                                                                                                <input type="radio" name="side-radio" id="rediosidep<?=$o?>" value="<?=$side['title']?>" />
                                                                                                <input type="hidden" name="side-id-choice" value="<?php echo $side['id']; ?>" />

                                                                                                <label for="radiosi<?=$o?>">
                                                                                                    <?php if( strcmp( $value, $side['title'] ) == 0 ) {
                                                                                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
                                                                                                    } ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } } ?>

                                                                               <?php if(trim(strtolower($meal['sides']['Vegetable'])) != 'none'): ?>
                                                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                                        <li class="nav-item" role="presentation"> 
                                                                                            <a class="nav-link" id="vegetable-tab<?= $meal['id'] ?>" data-toggle="tab" href="#vegetable<?= $meal['id'] ?>" role="tab" aria-controls="vegetable" aria-selected="true">Vegetables</a> 
                                                                                        </li> 
                                                                                    </ul> 
                                                                                    <div class="tab-content" id="myTabContent1"> 

                                                                                        <div class="tab-pane fade" id="vegetable<?= $meal['id'] ?>" role="tabpanel" aria-labelledby="vegetable-tab<?= $meal['id'] ?>">
                                                                                            <?php $p=0; foreach ( $meal['available_vegetables'] as $vegetable ) { 
                                                                                                if(!in_array($vegetable["id"], $pro_url)){
                                                                                                $p++;?>
                                                                                                <div class="thumbnail <?php if( strcmp($value, $vegetable['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                                                                                    <div class="iofSideImage-<?php echo $vegetable['id']; ?>"><img src="<?php echo $vegetable["image"]; ?>" /></div>
                                                                                                    <div class="caption">
                                                                                                        <p><?php echo $vegetable["title"]; ?>
                                                                                                        <br><small class="text-success"><i><?php if( strcmp($value, $vegetable['title']) == 0 ) { echo 'Default selection'; }
                                                                                                        ?></i></small></p>
                                                                                                        <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                                                                            <input type="radio" name="side-radio" id="rediosidep<?=$p?>" value="<?=$vegetable['title']?>" >
                                                                                                            <input type="hidden" name="side-id-choice" value="<?php echo $vegetable['id']; ?>" >
                                                                                                            <label for="radiov<?=$p?>">
                                                                                                                <?php if ( strcmp( $value, $vegetable['title'] ) == 0 ) {
                                                                                                                    echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
                                                                                                                } ?>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <?php } } ?>
                                                                                        </div> 

                                                                                    </div>

                                                                                <?php endif; ?>

                                                                              

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" id="btn-side" data-choiceid="<?= $choice['id'] ?>" data-mealid="<?php echo $meal['id']; ?>"  data-dismiss="modal">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if(trim(strtolower($key)) == 'vegetable' && trim(strtolower($value)) != 'none'): ?>
                                                        <div id="side-two-modal<?php echo $choice['id'].$meal['id']; ?>" class="modal fade AllinonePopup" role="dialog">
                                                           <div class="modal-dialog modal-lg modal-dialog-centered" >
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Vegetables</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 vegetables_radio_buttons">
                                                                                <?php $p=0; foreach ( $meal['available_vegetables'] as $vegetable ) {
                                                                                   if(!in_array($vegetable["id"], $pro_url)){ 
                                                                                 $p++;?>
                                                                                    <div class="thumbnail <?php if( strcmp($value, $vegetable['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                                                                        <div class="iofVegetablesImage-<?php echo $vegetable['id']; ?>"><img src="<?php echo $vegetable["image"]; ?>" /></div>
                                                                                        <div class="caption">
                                                                                            <p><?php echo $vegetable["title"]; ?>
                                                                                                <br><small class="text-success"><i><?php if( strcmp($value, $vegetable['title']) == 0 ) { echo 'Default selection'; }
                                                                                                ?></i></small></p>
                                                                                            <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                                                                <input type="radio" name="vegetable-radio" id="rediovegp<?=$p?>" value="<?=$vegetable['title']?>" >
                                                                                                <input type="hidden" name="vegetable-id-choice" value="<?php echo $vegetable['id']; ?>" >
                                                                                                <label for="radiov<?=$p?>">
                                                                                                    <?php if ( strcmp( $value, $vegetable['title'] ) == 0 ) {
                                                                                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
                                                                                                    } ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } }  ?>
                                                                                <?php if(trim(strtolower($meal['sides']['Side'])) != 'none'): ?>
                                                                                     <ul class="nav nav-tabs" id="myTab" role="tablist">

                                                                                        <li class="nav-item" role="presentation"> 
                                                                                            <a class="nav-link" id="side-tab<?= $meal['id'] ?>" data-toggle="tab" href="#side<?= $meal['id'] ?>" role="tab" aria-controls="side" aria-selected="true">Sides</a> 
                                                                                        </li> 

                                                                                        </ul> 
                                                                                        <div class="tab-content" id="myTabContent1"> 

                                                                                            <div class="tab-pane fade" id="side<?= $meal['id'] ?>" role="tabpanel" aria-labelledby="side-tab<?= $meal['id'] ?>">
                                                                                                <?php $p=0; foreach ( $meal['available_sides'] as $vegetablesids ) { 
                                                                                                     if(!in_array($vegetablesids["id"], $pro_url)){ 
                                                                                                    $p++;?>
                                                                                                    <div class="thumbnail <?php if( strcmp($value, $vegetablesids['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                                                                                        <div class="iofVegetablesImage-<?php echo $vegetablesids['id']; ?>"><img src="<?php echo $vegetablesids["image"]; ?>" /></div>
                                                                                                        <div class="caption">
                                                                                                            <p><?php echo $vegetablesids["title"]; ?>
                                                                                                                <br><small class="text-success"><i><?php if( strcmp($value, $vegetablesids['title']) == 0 ) { echo 'Default selection'; }
                                                                                                                ?></i></small></p>
                                                                                                            <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                                                                                <input type="radio" name="vegetable-radio" id="rediovegp<?=$p?>" value="<?=$vegetablesids['title']?>" >
                                                                                                                <input type="hidden" name="vegetable-id-choice" value="<?php echo $vegetablesids['id']; ?>" >
                                                                                                                <label for="radiov<?=$p?>">
                                                                                                                    <?php if ( strcmp( $value, $vegetablesids['title'] ) == 0 ) {
                                                                                                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
                                                                                                                    } ?>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                <?php } } ?>
                                                                                            </div> 


                                                                                        </div>

                                                                                <?php endif; ?>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-choiceid="<?= $choice['id'] ?>" data-mealid="<?php echo $meal['id']; ?>" id="btn-vegetable" data-dismiss="modal">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if(trim(strtolower($key)) == 'salad' && trim(strtolower($value)) != 'none'): ?>
                                                         <div id="salad-modal<?php echo $choice['id'].$meal['id']; ?>" class="modal fade AllinonePopup" role="dialog">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Salads:</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 salads_radio_buttons">
                                                                                <?php $q=0; foreach ( $meal['available_salads'] as $salad ) { 
                                                                                      if(!in_array($salad["id"], $pro_url)){
                                                                                        $q++; 
                                                                                    ?>
                                                                                    <div class="saladsId<?php echo $salad['id']; ?> thumbnail <?php if( strcmp($value, $salad['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                                                                        <div class="iofSaladImage-<?php echo $salad['id']; ?>"><img src="<?php echo $salad["image"]; ?>" /></div>
                                                                                        <div class="caption">
                                                                                            <p><?php echo $salad["title"]; ?>
                                                                                                <br><small class="text-success"><i><?php if( strcmp($value, $salad['title']) == 0 ) { echo 'Default selection'; }
                                                                                                ?></i></small></p></p>
                                                                                            <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                                                                <input type="radio" name="side-radio" id="radios<?=$q?>" value="<?=$salad['title']?>" >
                                                                                                <input type="hidden" name="salad-id-choice" value="<?php echo $salad['id']; ?>" >
                                                                                                <label for="radios<?=$q?>">
                                                                                                    <?php if ( strcmp( $value, $salad['title'] ) == 0 ) {
                                                                                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
                                                                                                    } ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } }?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-choiceid="<?= $choice['id'] ?>" data-mealid="<?php echo $meal['id']; ?>" id="btn-salad" data-dismiss="modal">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         </div>
                                                    <?php endif; ?>
                                                    <?php if(trim(strtolower($key)) == 'bread' && trim(strtolower($value)) != 'none'): ?>
                                                        <div id="bread-modal<?php echo $choice['id'].$meal['id']; ?>" class="modal fade AllinonePopup" role="dialog">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Breads</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 breads_radio_buttons_rc">
                                                                                <?php $r=0; foreach ( $meal['available_breads'] as $bread ) { $r++; ?>
                                                                                    <div class="breadId<?php echo $bread['id']; ?> thumbnail <?php if( strcmp($value, $bread['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                                                                        <div class="iofBreadImage-<?php echo $bread['id']; ?>"><img src="<?php echo $bread["image"]; ?>" /></div>
                                                                                        <div class="caption">
                                                                                            <p><?php echo $bread["title"]; ?>
                                                                                                <br><small class="text-success"><i><?php if( strcmp($value, $bread['title']) == 0 ) { echo 'Default selection'; }
                                                                                                ?></i></small></p>
                                                                                            <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                                                                <input type="radio"  name="bread-radio" id="radiob<?=$r?>" value="<?=$bread['title']?>"  >
                                                                                                <input type="hidden" name="bread-id-choice" value="<?php echo $bread['id']; ?>" >
                                                                                                <label for="radiob<?=$r?>">
                                                                                                    <?php if ( strcmp( $value, $bread['title'] ) == 0 ) {
                                                                                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
                                                                                                    } ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-choiceid="<?= $choice['id'] ?>" data-mealid="<?php echo $meal['id']; ?>" id="btn-bread" data-dismiss="modal">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if(trim(strtolower($key)) == 'dessert' && trim(strtolower($value)) != 'none'): ?>
                                                        <div id="dessert-modal<?php echo $choice['id'].$meal['id']; ?>" class="modal fade AllinonePopup" role="dialog">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Desserts</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 desserts_radio_buttons">
                                                                                <?php $m=0; foreach ( $meal['available_desserts'] as $dessert ) { 
                                                                                     if(!in_array($dessert["id"], $pro_url)){
                                                                                        $m++; 
                                                                                    ?>
                                                                                    <div class="thumbnail <?php if( strcmp($value, $dessert['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                                                                        <div class="iofDessertImage-<?php echo $dessert['id']; ?>"><img src="<?php echo $dessert["image"]; ?>" /></div>
                                                                                        <div class="caption">
                                                                                            <p><?php echo $dessert["title"]; ?>
                                                                                                <br><small class="text-success"><i><?php if( strcmp($value, $dessert['title']) == 0 ) { echo 'Default selection'; }
                                                                                                ?></i></small></p></p>
                                                                                            <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                                                                <input type="radio" name="dessert-radio" id="radiod<?=$m?>" value="<?=$dessert['title']?>"  >
                                                                                                <input type="hidden" name="dessert-id-choice" value="<?php echo $dessert['id']; ?>">
                                                                                                <label for="radiod<?=$m?>">
                                                                                                    <?php if ( strcmp( $value, $dessert['title'] ) == 0 ) {
                                                                                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
                                                                                                    } ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } }  ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-choiceid="<?= $choice['id'] ?>" data-mealid="<?php echo $meal['id']; ?>" id="btn-dessert" data-dismiss="modal">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>


                                            </div>
                                         </div>
                                    <?php } ?>

                            </div>
                    </div>
                <?php } ?>
            </div>
             <?php
                    $currentDate = date("Y-m-d");
                    $currentMonthLastDate = date("Y-m-t", strtotime($currentDate));
                    $ddd = date("Y-m-d",  strtotime("$currentMonthLastDate +7 days") );


            ?>
            <script type="text/javascript">
                (function($) {
                    'use strict';
                    $(function(){
                        var date = new Date();
                        var daysOfWeekDisabled = [];
                        var datesDisabled = [];

                        var shipping_method = $('.shipping_data_method_id').val();
                        var dates_tomorrow = $('.dates_tomorrow').val();


                        var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

                        var month = date.getMonth()+1;
                        var day = date.getDate();


                        
                        if(shipping_method == 'ups'){
                            if(dates_tomorrow == 'true'){
                                if(weekday[date.getDay()] == 'Friday' ){
                                    var mindete_cus = 4;
                                }else if(weekday[date.getDay()] == 'Saturday' ){
                                    var mindete_cus = 3;
                                }else if(weekday[date.getDay()] == 'Sunday' ){
                                    var mindete_cus = 2;
                                }else{
                                    var mindete_cus = 3;
                                }

                            }else{
                                if(weekday[date.getDay()] == 'Friday' ){
                                    var mindete_cus = 4;
                                }else if(weekday[date.getDay()] == 'Saturday' ){
                                    var mindete_cus = 3;
                                }else if(weekday[date.getDay()] == 'Sunday' ){
                                    var mindete_cus = 2;
                                }else{
                                    var mindete_cus = 2;
                                }

                            }
                            
                        }else{
                            if(dates_tomorrow == 'true'){
                               if(weekday[date.getDay()] == 'Friday' ){
                                    var mindete_cus = 4;
                                }else if(weekday[date.getDay()] == 'Saturday' ){
                                    var mindete_cus = 3;
                                }else if(weekday[date.getDay()] == 'Sunday' ){
                                    var mindete_cus = 2;
                                }else{
                                    var mindete_cus = 2;
                                }
                            }else{
                                 if(weekday[date.getDay()] == 'Friday' ){
                                    var mindete_cus = 3;
                                }else if(weekday[date.getDay()] == 'Saturday' ){
                                    var mindete_cus = 3;
                                }else if(weekday[date.getDay()] == 'Sunday' ){
                                    var mindete_cus = 2;
                                }else{
                                    var mindete_cus = 1;
                                }
                            }
                        }
                        
                        <?php
                            echo 'datesDisabled = ' . json_encode($all_blocked_dates) . ';';
                            echo 'daysOfWeekDisabled = ' . json_encode($week_disabled) . ';';
                       ?>
                        $('input.pick_delivery_date').datetimepicker({
                            format: 'YYYY-MM-DD',
                            useCurrent: false,
                            disabledDates: datesDisabled,
                            minDate: date.setDate(date.getDate() + mindete_cus),
                            daysOfWeekDisabled: daysOfWeekDisabled,
                            maxDate: '<?php date_default_timezone_set('America/New_York'); echo date("Y-m-d", strtotime("+10 week")); ?>'
                        }).on('dp.change',function(e){
                             var selected =  $(this).val();
                             var tttt = new Date(selected);

                            var myDate = new Date();
                            var firstDay = new Date(myDate.getFullYear(), myDate.getMonth(), 1);
                            var lastDay = new Date(myDate.getFullYear(), myDate.getMonth() + 1, 0);
                            var lastDayWithSlashes =  (lastDay.getDate()) + '/' + (lastDay.getMonth() + 1) + '/' + lastDay.getFullYear();
                            var dmy = lastDayWithSlashes.split("/");
                            var joindate = new Date(
                            parseInt(
                                dmy[2], 10),
                                parseInt(dmy[1], 10) - 1,
                                parseInt(dmy[0], 10)
                            );
                            joindate.setDate(joindate.getDate() + 7);
             

                            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                            const d = new Date();



                            var item_id = jQuery('#RCTab li a.active').attr('data-choiceid');
                            
                            var meal_id_arr = [];
                            jQuery('div.choice_container_' + item_id).find('.item-selected').each(function () {
                                if(jQuery(this).find('input[name=_meal_id]').val()){
                                    var meal_title = jQuery(this).find('input[name=_meal_id]').data('mealtitle');
                                    var meal_id = jQuery(this).find('input[name=_meal_id]').val();

                                    var currentProductSideId = jQuery(this).find('input[name=_Side]').data('sideid');
                                    var currentProductSideName = jQuery(this).find('input[name=_Side]').data('sidename');

                                    var currentProductVegId = jQuery(this).find('input[name=_Vegetable]').data('vegid');
                                    var currentProductVegName = jQuery(this).find('input[name=_Vegetable]').data('vegname');

                                    var currentProductSaladId = jQuery(this).find('input[name=_Salad]').data('saladid');
                                    var currentProductSaladName = jQuery(this).find('input[name=_Salad]').data('saladname');

                                    var currentProductDesId = jQuery(this).find('input[name=_Dessert]').data('dessertid');
                                    var currentProductDesName = jQuery(this).find('input[name=_Dessert]').data('dessertname');

                                    if( monthNames[d.getMonth()] == 'January' && ( meal_id == 1617 || currentProductSideId == 5588 || currentProductVegId == 5711 || currentProductDesId == 5677 || currentProductVegId == 5588 || currentProductSideId == 5711 ) ){

                                        if(currentProductSideId == 5588){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5711){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductDesId == 5677){
                                            meal_id_arr.push(currentProductDesName);    
                                        }else if(currentProductVegId == 5588){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5711){
                                           meal_id_arr.push(currentProductSideName);    
                                        }else{
                                           meal_id_arr.push(meal_title);
                                        }
                                       
                                    }
                                    if( monthNames[d.getMonth()] == 'February' && ( meal_id == 1733 || currentProductSideId == 5682  || currentProductVegId == 5682 ) ) {

                                        if(currentProductSideId == 5682){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5682){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else{
                                            meal_id_arr.push(meal_title); 
                                        }
                                    }

                                   if( monthNames[d.getMonth()] == 'March' && ( meal_id == 4383  || currentProductSideId == 5687  || currentProductVegId == 5692 || currentProductSideId == 5692  || currentProductVegId == 5687  ) ) {


                                         if(currentProductSideId == 5687){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5692){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductVegId == 5687){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5692){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else{
                                            meal_id_arr.push(meal_title); 
                                        }

                                    }

                                    if( monthNames[d.getMonth()] == 'April' && ( meal_id == 4386  || currentProductSideId == 5697  || currentProductVegId == 5702 || currentProductSideId == 5702  || currentProductVegId == 5697  ) ) {

                                        if(currentProductSideId == 5697){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5702){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductVegId == 5697){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5702){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else{
                                             meal_id_arr.push(meal_title); 
                                        }
                                    }

                                    if( monthNames[d.getMonth()] == 'May' && ( meal_id == 4389  || currentProductSideId == 5707  || currentProductVegId == 5711 || currentProductSideId == 5711  || currentProductVegId == 5707  ) ) {


                                        if(currentProductSideId == 5707){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5711){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductVegId == 5707){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5711){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else{
                                            meal_id_arr.push(meal_title); 
                                        }
                                    }

                                    if( monthNames[d.getMonth()] == 'June' && ( meal_id == 4392  || currentProductSideId == 5715  || currentProductVegId == 5719 || currentProductSideId == 5719  || currentProductVegId == 5715  ) ) {

                                        if(currentProductSideId == 5715){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5719){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductVegId == 5715){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5719){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else{
                                            meal_id_arr.push(meal_title); 
                                        }
                                    }

                                    if( monthNames[d.getMonth()] == 'July' && ( meal_id == 4380 ||  currentProductSideId == 5723  || currentProductVegId == 5723  ) ) {

                                        if(currentProductSideId == 5723){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5723){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else{
                                            meal_id_arr.push(meal_title); 
                                        }


                                    }

                                    if( monthNames[d.getMonth()] == 'August' && ( meal_id == 4396  || currentProductSideId == 5727  || currentProductVegId == 5732 || currentProductSideId == 5732  || currentProductVegId == 5727  ) ) {

                                        if(currentProductSideId == 5727){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5732){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductVegId == 5727){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5732){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else{
                                            meal_id_arr.push(meal_title); 
                                        }

                                    }

                                    if( monthNames[d.getMonth()] == 'September' && ( meal_id == 1806  || currentProductSideId == 5650  || currentProductVegId == 5646 || currentProductSideId == 5646  || currentProductVegId == 5650  ) ) {

                                        if(currentProductSideId == 5650){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5646){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductVegId == 5650){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5646){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else{
                                             meal_id_arr.push(meal_title); 
                                        }
                                        
                                    }

                                


                                    if( monthNames[d.getMonth()] == 'October' && (meal_id == 4571  || currentProductSideId == 5655 || currentProductVegId == 30002184994 || currentProductSideId == 30002184994 || currentProductVegId == 5655  ) ) {
                                        if(currentProductSideId == 5655){
                                            meal_id_arr.push(currentProductSideName);   
                                        }else if(currentProductVegId == 30002184994){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 30002184994){
                                            meal_id_arr.push(currentProductSideName);   
                                        }else if(currentProductVegId == 5655){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else{
                                            meal_id_arr.push(meal_title);    
                                        }
                                    }

                                    if( monthNames[d.getMonth()] == 'November' && ( meal_id == 4577 || currentProductSideId == 5660 || currentProductVegId == 5665 || currentProductSaladId == 5823 || currentProductVegId == 5660 || currentProductSideId == 5665 ) ) {

                                        if(currentProductSideId == 5660){
                                            vmeal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5665){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSaladId == 5823){
                                            meal_id_arr.push(currentProductSaladName);    
                                        }else if(currentProductVegId == 5660){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5665){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else{
                                            meal_id_arr.push(meal_title);
                                        }
                                        
                                    }

                                   

                                    if( monthNames[d.getMonth()] == 'December' && ( meal_id == 1617 || currentProductSideId == 5588 || currentProductVegId == 5711 || currentProductDesId == 5677 || currentProductVegId == 5588 || currentProductSideId == 5711 ) ){

                                        if(currentProductSideId == 5588){
                                            meal_id_arr.push(currentProductSideName);    
                                        }else if(currentProductVegId == 5711){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductDesId == 5677){
                                            meal_id_arr.push(currentProductDesName);    
                                        }else if(currentProductVegId == 5588){
                                            meal_id_arr.push(currentProductVegName);    
                                        }else if(currentProductSideId == 5711){
                                           meal_id_arr.push(currentProductSideName);    
                                        }else{
                                           meal_id_arr.push(meal_title);
                                        }
                                       
                                    }

                                    
                                }
                            });
                            /*console.log(monthNames[d.getMonth()]);
                            console.log(meal_id_arr);*/
                            if(meal_id_arr != ""){
                                if( tttt.getTime() <= joindate.getTime()  ) {
                                    jQuery('div.woocommerceError').remove();
                                    jQuery('button.add_meals_delivery').prop('disabled', false);
                                }else{
                                    jQuery('.MealOfMonthError_' + item_id).html('<div class="woocommerceError">' + 
                                    '  <ul class="woocommerce-error" role="alert"><li>Monthly Special ('+meal_id_arr[0]+') cannot be ordered past 7 days of the upcoming month.</li></ul>' + 
                                    '</div>');
                                     jQuery('html, body').animate({
                                        scrollTop: jQuery(".pick_your_meals_container").offset().top
                                    }, 1500);
                                    jQuery('button.add_meals_delivery').prop('disabled', true);
                                }
                            }else{
                                jQuery('div.woocommerceError').remove();
                                jQuery('button.add_meals_delivery').prop('disabled', false);
                            }

                        });
                    });
                })( jQuery );
            </script>
        </div>
        <div class="card-footer">
            <div class="row align-items-center">
            <div class="col text-right"> <button class="btn btn-sm btn-success pull-right review_complete_deliveries">Review &amp; Confirm</button>
            </div>
            </div>
        </div>
    </div>
</div>

<?php /*
<div class="pick_your_meals_container">

    <div class="panel panel-default">
        <div class="panel-heading">Pick Your Meals! <button class="btn btn-sm btn-success pull-right review_complete_deliveries">Review & Confirm</button></div>
        <div class="panel-body">
            <div class="alert alert-success" role="alert">
                <small><strong>Woohoo!</strong> You have <?= $order_details['total'] ?> meal(s) to pick.</small>
            </div>
           
        </div>
    </div>
</div> */?>

<div class="review_confirm_container reviewConfirm" style="display: none;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Review &amp; Confirm</h3>
                <div class="d-flex justify-content-between getShippingDetailAfterOrder">
                    <span class="thankyoumsg" style="display:none;text-align: center;width: 100%;">
                        <p class="thankyoutitle" style="color: #10a26f;font-weight: 600;">Thank you! Your Recipient's Choice meal has been successfully redeemed</p>
                        <small style="font-weight: :500;">Please check your email for your order details</small>
                    </span>
                    <button class="back_to">Back</button>
                    <button class="button complete_order">Complete your order</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="well meals_summary rcDeliveryDateList">...</div>
                <div class="rcDeliveryDateForm">
                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="customer_note" placeholder="Customer Note" class="form-control" rows="5"></textarea>
                    </div>
                    <?php /* <div class="form-group">
                        <label>Note</label>
                        <textarea name="customer_note" class="form-control" rows="5"></textarea>
                    </div> */ ?>
                    <div class="form-group">
                        <label>Street Address</label>
                        <input type="text" class="form-control" value="<?= $order_details['shipping_address']['address_1'] ?>, <?= $order_details['shipping_address']['address_2'] ?>" disabled>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Town / City</label>
                                <input type="text" class="form-control" value="<?= $order_details['shipping_address']['city'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" class="form-control" value="<?= $order_details['shipping_address']['state'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ZIP</label>
                                <input type="text" class="form-control" value="<?= $order_details['shipping_address']['zip'] ?>" disabled>
                            </div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" value="<?= $order_details['shipping_address']['phone'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="<?= $order_details['shipping_address']['email'] ?>" disabled>
                            </div>
                        </div>
                    </div>  
                </div>
         
            </div>
        </div>

</div>