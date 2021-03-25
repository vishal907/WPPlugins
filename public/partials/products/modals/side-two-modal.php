<div id="side-two-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Side Two</h4>
            </div>
            <div class="modal-body">
                <div class="btn-group btn-group-iof" data-toggle="buttons">
					<?php
					foreach ( $available_sides as $side ) { ?>
                        <div class="row vertical-align">
                            <div class="col-xs-4">
                                <label class="btn btn-secondary side-two-radio-label">
                                    <div class="row vertical-align">
                                        <div class="col-xs-3"><input type="radio" name="side-two-radio" value="<?= $side['title'] ?>">
                                        </div>
                                        <div class="col-xs-9 side-thmbnl"><?= $side["image"] ?></div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-8"><?= $side["title"] ?></div>
                        </div>
					<?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-side-two" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>