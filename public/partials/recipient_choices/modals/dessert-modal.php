<div id="dessert-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
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
                        <?php $m=0; foreach ( $available_desserts as $dessert ) { $m++; ?>
                            <div class="thumbnail <?php if( strcmp($default_dessert, $dessert['title']) == 0 ) { echo 'item-selected'; } ?>" >
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
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-dessert" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>