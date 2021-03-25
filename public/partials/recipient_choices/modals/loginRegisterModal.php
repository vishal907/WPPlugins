 <div id="loginRegisterModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <div class="error"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loginRegisterModalPopup">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo do_shortcode('[woocommerce_my_account]'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>