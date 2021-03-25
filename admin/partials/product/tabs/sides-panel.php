<?php
    $tool_tip = "If checked, customers will not be able to select a side item different than the default.";
?>
<div id="sides_product_data" class="panel woocommerce_options_panel">
    <p>These are the default side items displayed to the customer for this product.</p>
    <input type="hidden" id="iof_product_id" value="<?= $product_id ?>">
    <div class="options_group">
        <p class="form-field">
            <label for="default_side">Default Starches:</label>
            <select name="default_side" id="default_side" class="select short">
                <option value="none">None</option>
                <?php foreach ( $available_sides as $side ) { ?>
                    <option value="<?= $side['id'] ?>" <?php selected($default_side, $side['title'])?>><?= $side['title'] ?></option>
                <?php } ?>
            </select>
            <span style="position:absolute;">
                <label for="default_side_lock" <?php if($default_side_lock == 'ON') { echo "style='position:relative;float:none;margin-left:16px;color:#d9534f'"; }
                else { echo "style='position:relative;float:none;margin-left:16px;color:#3C763D'"; } ?> >
                    <span class="tooltip">
                    <input type="checkbox" id="default_side_lock" name="default_side_lock" <?php if($default_side_lock == 'ON') { echo 'checked'; } ?> >
                        <span class="dashicons <?php if($default_side_lock == 'ON') { echo "dashicons-lock"; } else { echo "dashicons-unlock"; } ?>"></span>
                        <span class="tooltiptext"><?php echo $tool_tip; ?></span>
                    </span>
                </label>
            </span>
        </p>
        <p class="form-field">
            <label for="default_vegetable">Default Vegetable:</label>
            <select name="default_vegetable" id="default_vegetable" class="select short">
                <option value="none">None</option>
                <?php foreach ( $available_vegetables as $vegetable ) { ?>
                    <option value="<?= $vegetable['id'] ?>" <?php selected( $default_vegetable, $vegetable['title'] ) ?>><?= $vegetable['title'] ?></option>
                <?php } ?>
            </select>
            <span style="position:absolute;">
                <label for="default_vegetable_lock" <?php if($default_vegetable_lock == 'ON') { echo "style='position:relative;float:none;margin-left:16px;color:#d9534f'"; }
                else { echo "style='position:relative;float:none;margin-left:16px;color:#3C763D'"; } ?> >
                    <span class="tooltip">
                    <input type="checkbox" id="default_vegetable_lock" name="default_vegetable_lock" <?php if($default_vegetable_lock == 'ON') { echo 'checked'; } ?> >
                        <span class="dashicons <?php if($default_vegetable_lock == 'ON') { echo "dashicons-lock"; } else { echo "dashicons-unlock"; } ?>"></span>
                        <span class="tooltiptext"><?php echo $tool_tip; ?></span>
                    </span>
                </label>
            </span>
        </p>
        <p class="form-field">
            <label for="default_salad">Default Salad:</label>
            <select name="default_salad" id="default_salad" class="select short">
                <option value="none">None</option>
			    <?php foreach ( $available_salads as $salad ) { ?>
                    <option value="<?= $salad['id'] ?>" <?php selected( $default_salad, $salad['title'] ) ?>><?= $salad['title'] ?></option>
			    <?php } ?>
            </select>
            <span style="position:absolute;">
                <label for="default_salad_lock" <?php if($default_salad_lock == 'ON') { echo "style='position:relative;float:none;margin-left:16px;color:#d9534f'"; }
                else { echo "style='position:relative;float:none;margin-left:16px;color:#3C763D'"; } ?>>
                    <span class="tooltip">
                    <input type="checkbox" id="default_salad_lock" name="default_salad_lock" <?php if($default_salad_lock == 'ON') { echo 'checked'; } ?> >
                        <span class="dashicons <?php if($default_salad_lock == 'ON') { echo "dashicons-lock"; } else { echo "dashicons-unlock"; } ?>"></span>
                        <span class="tooltiptext"><?php echo $tool_tip; ?></span>
                    </span>
                </label>
            </span>
        </p>
        <p class="form-field">
            <label for="default_bread">Default Bread:</label>
            <select name="default_bread" id="default_bread" class="select short">
                <option value="none">None</option>
			    <?php foreach ( $available_breads as $bread ) { ?>
                    <option value="<?= $bread['id'] ?>" <?php selected( $default_bread, $bread['title'] ) ?>><?= $bread['title'] ?></option>
			    <?php } ?>
            </select>
            <span style="position:absolute;">
                <label for="default_bread_lock" <?php if($default_bread_lock == 'ON') { echo "style='position:relative;float:none;margin-left:16px;color:#d9534f'"; }
                else { echo "style='position:relative;float:none;margin-left:16px;color:#3C763D'"; } ?> >
                    <span class="tooltip">
                    <input type="checkbox" id="default_bread_lock" name="default_bread_lock" <?php if($default_bread_lock == 'ON') { echo 'checked'; } ?> >
                        <span class="dashicons <?php if($default_bread_lock == 'ON') { echo "dashicons-lock"; } else { echo "dashicons-unlock"; } ?>"></span>
                        <span class="tooltiptext"><?php echo $tool_tip; ?></span>
                    </span>
                </label>
            </span>
        </p>
        <p class="form-field">
            <label for="default_dessert">Default Dessert:</label>
            <select name="default_dessert" id="default_dessert" class="select short">
                <option value="0">None</option>
			    <?php foreach ( $available_desserts as $dessert ) { ?>
                    <option value="<?= $dessert['id'] ?>" <?php selected( $default_dessert, $dessert['title'] ) ?>><?= $dessert['title'] ?></option>
			    <?php } ?>
            </select>
            <span style="position:absolute;">
                <label for="default_dessert_lock" <?php if($default_dessert_lock == 'ON') { echo "style='position:relative;float:none;margin-left:16px;color:#d9534f'"; }
                else { echo "style='position:relative;float:none;margin-left:16px;color:#3C763D'"; } ?>>
                    <span class="tooltip">
                    <input type="checkbox" id="default_dessert_lock" name="default_dessert_lock" <?php if($default_dessert_lock == 'ON') { echo 'checked'; } ?> >
                        <span class="dashicons <?php if($default_dessert_lock == 'ON') { echo "dashicons-lock"; } else { echo "dashicons-unlock"; } ?>"></span>
                        <span class="tooltiptext"><?php echo $tool_tip; ?></span>
                    </span>
                </label>
            </span>
        </p>
        <p>
            <button type="button" class="button-primary" id="save_sides_button"><?php _e( 'Save changes', 'woocommerce' ); ?></button>
        </p>
    </div>
</div>