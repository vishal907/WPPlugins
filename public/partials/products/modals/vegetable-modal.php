<div id="side-two-modal" class="modal fade iofSinglePageModal" role="dialog">
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
                              $pro_url = array(5588,5711,5687,5692,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'March') {
                            if($option_fields['march_month']) :
                                $pro_url = array(5588,5711,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'April') {
                            if($option_fields['april_month']) :
                                $pro_url = array(5588,5711,5692,5687,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'May') {
                            if($option_fields['may_month']) :
                                $pro_url = array(5588,5711,5692,5687,5697,5702,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);

                            endif;
                        }
                        if($currentdate == 'June') {
                            if($option_fields['june_month']) :
                                $pro_url = array(5588,5711,5692,5687,5697,5702,5707,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'July') {
                            if($option_fields['july_month']) :
                                $pro_url = array(5588,5711,5692,5687,5697,5702,5707,5715,5719,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'August') {
                            if($option_fields['august_month']) :
                                $pro_url = array(5588,5711,5692,5687,5697,5702,5707,5715,5719,5723,5650,5646,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'September') {
                            if($option_fields['september_month']) :
                                $pro_url = array(5588,5711,5692,5687,5697,5702,5707,5715,5719,5723,5727,5732,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'October') {
                            if($option_fields['october_month']) :
                                $pro_url = array(5588,5711,5692,5687,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5660,5665,5823);
                            endif;
                        }
                        if($currentdate == 'November') {
                            if($option_fields['november_month']) :
                                $pro_url = array(5588,5711,5692,5687,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,30002184994);
                            endif;
                        }
                        if($currentdate == 'December') {
                            if($option_fields['december_month']) :
                              $pro_url = array(5687,5692,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                              
                            endif;
                        } 


                      /*  if(get_the_ID() == 1800 || get_the_ID() == 4570){}else{
                            $septkey1 = array_search(5650, array_column($available_sides, 'id')); // side model starch item
                            $septkey2 = array_search(5646, array_column($available_sides, 'id')); // side model veg item

                            $septvkey3 = array_search(5650, array_column($available_vegetables, 'id')); // veg model starch item
                            $septvkey4 = array_search(5646, array_column($available_vegetables, 'id')); // veg modal veg item


                            $octkey1 = array_search(5655, array_column($available_sides, 'id'));   // side item only
                            

                            unset($available_sides[$septkey1]);  
                            unset($available_sides[$septkey2]);  

                            unset($available_vegetables[$septvkey3]);  
                            unset($available_vegetables[$septvkey4]);  
                            
                            unset($available_sides[$octkey1]);  

                        }

                        $available_sides = array_values($available_sides);
                        $available_vegetables = array_values($available_vegetables);
*/


                         
                        ?>

                        <?php $i=0; foreach ( $available_vegetables as $vegetable ) { $i++;
                             if(!in_array($vegetable["id"], $pro_url)){
                            ?>
                            <div class="thumbnail <?php if( strcmp($default_vegetable, $vegetable['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                <div class="iofVegetablesImage-<?php echo $vegetable['id']; ?>"><img src="<?php echo $vegetable["image"]; ?>" /></div>
                                <div class="caption">
                                    <p><?php echo $vegetable["title"]; ?>
                                        <br><small class="text-success"><i><?php if( strcmp($default_vegetable, $vegetable['title']) == 0 ) { echo 'Default selection'; }
                                        ?></i></small></p>
                                    <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                        <input type="radio" name="vegetable-radio" id="radioveg<?=$i?>" value="<?=$vegetable['title']?>" >
                                        <input type="hidden" name="vegetable-id-choice" value="<?php echo $vegetable['id']; ?>" >
                                        <label for="radiov<?=$i?>">
	                                        <?php if ( strcmp( $default_vegetable, $vegetable['title'] ) == 0 ) {
		                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
	                                        } ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php } }  ?>


                        <ul class="nav nav-tabs" id="myTab" role="tablist"> 
                            <?php if ( ! empty( $default_side ) && strtolower( $default_side ) != 'none' ) { ?>
                                <li class="nav-item" role="presentation"> 
                                    <a class="nav-link" id="vside-tab" data-toggle="tab" href="#vside" role="tab" aria-controls="vside" aria-selected="true">Starches</a> 
                                </li> 
                            <?php } ?>
                        </ul> 
                        <div class="tab-content" id="myTabContent1"> 
                            <?php if ( ! empty( $default_side ) && strtolower( $default_side ) != 'none' ) { ?>
                            <div class="tab-pane fade" id="vside" role="tabpanel" aria-labelledby="vside-tab">
                                  <?php $o=0; foreach ( $available_sides as $side ) { $o++; 
                                     if(!in_array($side["id"], $pro_url)){

                                    ?>
                                        <div class="thumbnail">
                                            <div class="iofVegetablesImage-<?php echo $side['id']; ?>"><img src="<?php echo $side["image"]; ?>" /></div>
                                            <div class="caption">
                                                <p><?php echo $side["title"]; ?></p>
                                                <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                                    <input type="radio" name="vegetable-radio" id="radioveg<?=$o?>" value="<?=$side['title']?>" />
                                                    <input type="hidden" name="vegetable-id-choice" value="<?php echo $side['id']; ?>" />
                                                    <label for="radiosi<?=$o?>"></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } } ?>

                            </div> 
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-vegetable" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>