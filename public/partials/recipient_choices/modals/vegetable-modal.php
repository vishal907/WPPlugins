<div id="side-two-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
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
                        <?php $i=0; foreach ( $available_vegetables as $vegetable ) { $i++;?>
                            <div class="thumbnail <?php if( strcmp($default_vegetable, $vegetable['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                <div class="iofVegetablesImage-<?php echo $vegetable['id']; ?>"><img src="<?php echo $vegetable["image"]; ?>" /></div>
                                <div class="caption">
                                    <p><?php echo $vegetable["title"]; ?>
                                        <br><small class="text-success"><i><?php if( strcmp($default_vegetable, $vegetable['title']) == 0 ) { echo 'Default selection'; }
                                        ?></i></small></p>
                                    <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                        <input type="radio" name="vegetable-radio" id="radiov<?=$i?>" value="<?=$vegetable['title']?>" >
                                        <input type="hidden" name="vegetable-id-choice" value="<?php echo $vegetable['id']; ?>" >
                                        <label for="radiov<?=$i?>">
	                                        <?php if ( strcmp( $default_vegetable, $vegetable['title'] ) == 0 ) {
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
                <button type="button" class="btn btn-primary" id="btn-vegetable" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>