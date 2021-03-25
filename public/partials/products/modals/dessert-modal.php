<div id="dessert-modal" class="modal fade iofSinglePageModal" role="dialog">
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
                         <?php 

                        $currentdate = date('F');
                        
                        $option_fields = get_fields( 'option' );
                        if($currentdate == 'January') {
                            if($option_fields['january_month']) :
                               $pro_url = array(5682,5687,5692,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                            endif;
                        }
                        if($currentdate == 'February') {
                            if($option_fields['february_month']) :
                              $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'March') {
                            if($option_fields['march_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'April') {
                            if($option_fields['april_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'May') {
                            if($option_fields['may_month']) :
                                $pro_url = array(5677);

                            endif;
                        }
                        if($currentdate == 'June') {
                            if($option_fields['june_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'July') {
                            if($option_fields['july_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'August') {
                            if($option_fields['august_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'September') {
                            if($option_fields['september_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'October') {
                            if($option_fields['october_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'November') {
                            if($option_fields['november_month']) :
                                $pro_url = array(5677);
                            endif;
                        }
                        if($currentdate == 'December') {
                            if($option_fields['december_month']) :
                                $pro_url = array(5682,5687,5692,5697,5702,5707,5715,5719,5723,5727,5732,5650,5646,5655,5660,5665,5823,30002184994);
                              
                            endif;
                        } 


                        ?>

                        <?php $m=0; foreach ( $available_desserts as $dessert ) {
                             if(!in_array($dessert["id"], $pro_url)){
                         $m++; ?>
                            <div class="thumbnail productModalPopup <?php if( strcmp($default_dessert, $dessert['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                <div class="iofDessertImage-<?php echo $dessert['id']; ?>"><img src="<?php echo $dessert["image"]; ?>" /></div>
                                <div class="caption">
                                    <p><?php echo $dessert["title"]; ?>
                                        <br><small class="text-success"><i><?php if( strcmp($default_dessert, $dessert['title']) == 0 ) { echo 'Default selection'; }
                                        ?></i></small></p></p>
                                    <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                        <input type="radio" name="dessert-radio" id="radiod<?=$m?>" value="<?=$dessert['title']?>" >
                                        <input type="hidden" name="dessert-id-choice" value="<?php echo $dessert['id']; ?>">
                                        <label for="radiod<?=$m?>">
	                                        <?php if ( strcmp( $default_dessert, $dessert['title'] ) == 0 ) {
		                                        echo '<i class="fa fa-check" style="left: -15px;position: absolute;top: 4px; color: #86BD3D;"></i>';
	                                        } ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php } } ?>
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-dessert" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>