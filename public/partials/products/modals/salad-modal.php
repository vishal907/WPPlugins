<div id="salad-modal" class="modal fade iofSinglePageModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Salads</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php 

                        $currentdate = date('F');
                        //$currentdate = 'October';
                        $option_fields = get_fields( 'option' );
                        if($currentdate == 'January') {
                            if($option_fields['january_month']) :
                               $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'February') {
                            if($option_fields['february_month']) :
                              $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'March') {
                            if($option_fields['march_month']) :
                                $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'April') {
                            if($option_fields['april_month']) :
                                $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'May') {
                            if($option_fields['may_month']) :
                                $pro_url = array(5823);

                            endif;
                        }
                        if($currentdate == 'June') {
                            if($option_fields['june_month']) :
                                $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'July') {
                            if($option_fields['july_month']) :
                                $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'August') {
                            if($option_fields['august_month']) :
                                $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'September') {
                            if($option_fields['september_month']) :
                                $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'October') {
                            if($option_fields['october_month']) :
                                 $pro_url = array(5823);
                            endif;
                        }
                        if($currentdate == 'November') {
                            if($option_fields['november_month']) :
                                $pro_url = array();
                            endif;
                        }
                        if($currentdate == 'December') {
                            if($option_fields['december_month']) :
                               $pro_url = array(5823);
                            endif;
                        } 

                       /* if(get_the_ID() == 1800 || get_the_ID() == 4570){}else{
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
                        $available_vegetables = array_values($available_vegetables);*/

                        /*echo "<pre>";
                        print_r($available_sides);
                        echo "<pre>";*/
                        
                        ?>


                    <div class="col-xs-12 salads_radio_buttons">
                        <?php $j=0; foreach ( $available_salads as $salad ) { $j++; 
                            if(!in_array($salad["id"], $pro_url)){
                            ?>
                            <div class="thumbnail <?php if( strcmp($default_salad, $salad['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                <div class="iofSaladImage-<?php echo $salad['id']; ?>"><img src="<?php echo $salad["image"]; ?>" /></div>
                                <div class="caption">
                                    <p><?php echo $salad["title"]; ?>
                                        <br><small class="text-success"><i><?php if( strcmp($default_salad, $salad['title']) == 0 ) { echo 'Default selection'; }
                                        ?></i></small></p></p>
                                    <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                        <input type="radio" name="salad-radio"  id="radios<?=$j?>" value="<?=$salad['title']?>" >
                                        <input type="hidden" name="salad-id-choice" value="<?php echo $salad['id']; ?>" >
                                        <label for="radios<?=$j?>">
	                                        <?php if ( strcmp( $default_salad, $salad['title'] ) == 0 ) {
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
                <button type="button" class="btn btn-primary" id="btn-salad" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>