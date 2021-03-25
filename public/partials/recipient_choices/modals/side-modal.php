<div id="side-one-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sides</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 sides_radio_buttons">
                        
                        <?php $o=0; foreach ( $available_sides as $side ) { $o++; ?>
                            <div class="thumbnail <?php if( strcmp($default_side, $side['title']) == 0 ) { echo 'item-selected'; } ?>">
                                <div class="iofSideImage-<?php echo $side['id']; ?>"><img src="<?php echo $side["image"]; ?>" /></div>
                                <div class="caption">
                                    <p><?php echo $side["title"]; ?>
                                        <br><small class="text-success"><i><?php if( strcmp($default_side, $side['title']) == 0 ) { echo 'Default selection'; }
                                        ?></i></small></p>
                                    <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                        <input type="radio" name="side-radio" id="radiosi<?=$o?>" value="<?=$side['title']?>" />
                                        <input type="hidden" name="side-id-choice" value="<?php echo $side['id']; ?>" />
                                        <label for="radiosi<?=$o?>">
                                            <?php if( strcmp( $default_side, $side['title'] ) == 0 ) {
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
                <button type="button" class="btn btn-primary" id="btn-side" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>