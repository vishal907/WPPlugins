<div id="bread-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Breads</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 breads_radio_buttons">
                        <?php $n=0; foreach ( $available_breads as $bread ) { $n++; ?>
                            <div class="thumbnail <?php if( strcmp($default_bread, $bread['title']) == 0 ) { echo 'item-selected'; } ?>" >
                                <div class="iofBreadImage-<?php echo $bread['id']; ?>"><img src="<?php echo $bread["image"]; ?>" /></div>
                                <div class="caption">
                                    <p><?php echo $bread["title"]; ?>
                                        <br><small class="text-success"><i><?php if( strcmp($default_bread, $bread['title']) == 0 ) { echo 'Default selection'; }
                                        ?></i></small></p>
                                    <div class="radio radio-success" style="position:absolute; right:-16px; top: -12px;">
                                        <input type="radio" name="bread-radio" id="radiob<?=$n?>" value="<?=$bread['title']?>" >
                                        <input type="hidden" name="bread-id-choice" value="<?php echo $bread['id']; ?>" >
                                        <input type="hidden" name="bread-id-count" value="<?php echo count($available_breads); ?>">
                                        <label for="radiob<?=$n?>">
	                                        <?php if ( strcmp( $default_bread, $bread['title'] ) == 0 ) {
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
                <button type="button" class="btn btn-primary" id="btn-bread" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>