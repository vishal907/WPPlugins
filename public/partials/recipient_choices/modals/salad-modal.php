<div id="salad-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
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
                        <?php $j=0; foreach ( $available_salads as $salad ) { $j++; ?>
                            <div class="thumbnail <?php if( strcmp($default_salad, $salad['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                <div class="iofSaladImage-<?php echo $salad['id']; ?>"><img src="<?php echo $salad["image"]; ?>" /></div>
                                <div class="caption">
                                    <p><?php echo $salad["title"]; ?>
                                        <br><small class="text-success"><i><?php if( strcmp($default_salad, $salad['title']) == 0 ) { echo 'Default selection'; }
                                        ?></i></small></p></p>
                                    <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                        <input type="radio" name="side-radio"  id="radios<?=$j?>" value="<?=$salad['title']?>" >
                                        <input type="hidden" name="salad-id-choice" value="<?php echo $salad['id']; ?>" >
                                        <label for="radios<?=$j?>">
	                                        <?php if ( strcmp( $default_salad, $salad['title'] ) == 0 ) {
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
                <button type="button" class="btn btn-primary" id="btn-salad" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>