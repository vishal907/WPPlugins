<table class="pdSides" cellspacing="0">
<tbody>
<?php if ( ! empty( $default_side ) && strtolower( $default_side ) != 'none' ) { //print_r($available_sides);?>
<tr class="iofSidesDetails">
    <td class="sidesTitle">Starch:</td>
    <td class="sidesImage" id="sidesImage">
        <?php $o=0; foreach ( $available_sides as $side ) { $o++; ?>
            <?php if( strcmp($default_side, $side['title']) == 0 ) :?>
                <img class="imageShow" src="<?php echo $side['image']; ?>">
                <div class="popoverImg"><img src="<?php echo $side['image']; ?>" width="500" height="500"></div>
            <?php endif; ?>
        <?php } ?>
    </td>
    <td class="sidesName side-title"><?= $default_side ?></td>
	<?php if ( strtolower( $default_side_lock ) == 'off' && ( isset( $global_lock ) && strtolower( $global_lock ) == '' ) ) { ?>
    <td class="sidesChange"><button type="button" class="btn ibtn" data-toggle="modal" data-target="#side-one-modal" data-backdrop="static" data-keyboard="false">Change</button></td>
    <?php } ?>
    <input type="hidden" class="side-value" name="side" value="<?php echo $default_side; ?>"> 
    <input type="hidden" name="side-id" value="<?php echo $default_side_id; ?>">
</tr>
<?php } ?>
<?php if ( ! empty( $default_vegetable ) && strtolower( $default_vegetable ) != 'none' ) { ?>
<tr class="iofVegetablesDetails">	
     
    <td class="sidesTitle">Vegetable:</td>
    <td class="sidesImage" id="VegetableImage">
        <?php $o=0; foreach ( $available_vegetables as $vegetable ) { $o++; ?>
            <?php if( strcmp($default_vegetable, $vegetable['title']) == 0 ) : ?>
                 <img src="<?php echo $vegetable['image']; ?>">
                 <div class="popoverImg"><img src="<?php echo $vegetable['image']; ?>"></div>
            <?php endif; ?>
        <?php } ?>
    </td>
    <td class="sidesName vegetable-title"><?= $default_vegetable ?> </td>
	<?php if ( strtolower( $default_vegetable_lock ) == 'off' && ( isset( $global_lock ) && strtolower( $global_lock ) == '' ) ) { ?>
	   <td class="sidesChange"><button type="button" class="btn ibtn" data-toggle="modal" data-target="#side-two-modal" data-backdrop="static" data-keyboard="false">Change</button></td>
    <?php } ?>
    <input type="hidden" class="vegetable-value" name="vegetable" value="<?= $default_vegetable; ?>">
    <input type="hidden" name="vegetable-id" value="<?php echo $default_vegetable_id; ?>">

</tr>
<?php } ?>
<?php if ( ! empty( $default_salad ) && strtolower( $default_salad ) != 'none' ) { ?>
<tr class="iofSaladDetails">   
    <td class="sidesTitle">Salad:</td>
    <td class="sidesImage" id="SaladImage">
        <?php $o=0; foreach ( $available_salads as $salad ) { $o++; ?>
            <?php if( strcmp($default_salad, $salad['title']) == 0 ) : ?>
                <img src="<?php echo $salad['image']; ?>" />
                <div class="popoverImg"><img src="<?php echo $salad['image']; ?>"></div>
            <?php endif; ?>
        <?php } ?>
    </td>

    <td class="sidesName salad-title"><?= $default_salad ?> </td>

    <?php if( strtolower( $default_salad_lock ) == 'off' && ( isset($global_lock) && strtolower( $global_lock ) == '')) { ?>
         <td class="sidesChange"><button type="button" class="btn ibtn" data-toggle="modal" data-target="#salad-modal" data-backdrop="static" data-keyboard="false">Change</button></td>
    <?php } ?>
    <input type="hidden" class="salad-value" name="salad" value="<?= $default_salad; ?>"> 
    <input type="hidden" name="salad-id" value="<?php echo $default_salad_id; ?>">

</tr>
<?php } ?>
<?php if ( ! empty( $default_bread ) && strtolower( $default_bread ) != 'none' ) { ?>
<tr class="iofBreadDetails">   
     <td class="sidesTitle">Bread:</td>
    <td class="sidesImage" id="BreadImage">
        <?php $o=0; foreach ( $available_breads as $bread ) { $o++; ?>
            <?php if( strcmp($default_bread, $bread['title']) == 0 ) : ?>
                <img src="<?php echo $bread['image']; ?>">
                <div class="popoverImg"><img src="<?php echo $bread['image']; ?>"></div>
            <?php endif; ?>
        <?php } ?>
    </td>
    <td class="sidesName bread-title"><?= $default_bread ?> <input type="hidden" class="bread-value" name="bread" value="<?= $default_bread ?>"> <input type="hidden" name="bread-id" value="<?php echo $default_bread_id; ?>"></td>

    <?php if( strtolower( $default_bread_lock ) == 'off' && ( isset($global_lock) && strtolower( $global_lock ) == '')) { ?>
         <td class="sidesChange"><button type="button" class="btn ibtn" data-toggle="modal" data-target="#bread-modal" data-backdrop="static" data-keyboard="false">Change</button></td>
    <?php } ?>
</tr>
<?php } ?>
<?php if ( ! empty( $default_dessert ) && strtolower( $default_dessert ) != 'none' ) { ?>
<tr class="iofDessertDetails">   

     <td class="sidesTitle">Dessert:</td>
    <td class="sidesImage" id="DessertImage">
        <?php $o=0; foreach ( $available_desserts as $dessert ) { $o++; ?>
            <?php if( strcmp($default_dessert, $dessert['title']) == 0 ) : ?>
                <img src="<?php echo $dessert['image']; ?>">
                 <div class="popoverImg"><img src="<?php echo $dessert['image']; ?>"></div>
            <?php endif; ?>
        <?php } ?>
    </td>
    <td class="sidesName dessert-title"><?= $default_dessert ?>  <input type="hidden" class="dessert-value" name="dessert" value="<?= $default_dessert ?>"> <input type="hidden" name="dessert-id" value="<?php echo $default_dessert_id; ?>"></td>

	<?php if ( strtolower( $default_dessert_lock ) == 'off' && ( isset( $global_lock ) && strtolower( $global_lock ) == '' ) ) { ?>
         <td class="sidesChange"><button type="button" class="btn ibtn" data-toggle="modal" data-target="#dessert-modal" data-backdrop="static" data-keyboard="false">Change</button></td>

    <?php } ?>
</tr>
<?php } ?>
</tbody>
</table>
<?php 
    if ( isset( $global_lock ) && strtolower( $global_lock ) == '' ) {
	    if ( ! empty( $default_side ) && strtolower( $default_side ) != 'none' ) {
		    include_once( 'modals/side-modal.php' );
	    }
	    if ( ! empty( $default_vegetable ) && strtolower( $default_vegetable ) != 'none' ) {
		    include_once( 'modals/vegetable-modal.php' );
	    }
	    if ( ! empty( $default_salad ) && strtolower( $default_salad ) != 'none' ) {
		    include_once( 'modals/salad-modal.php' );
	    }
	    if ( ! empty( $default_bread ) && strtolower( $default_bread ) != 'none' ) {
		    include_once( 'modals/bread-modal.php' );
	    }
	    if ( ! empty( $default_dessert ) && strtolower( $default_dessert ) != 'none' ) {
		    include_once( 'modals/dessert-modal.php' );
	    }
    }
?>