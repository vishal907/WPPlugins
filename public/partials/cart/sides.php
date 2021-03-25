<?php 

if( (isset($cart_item['side']) && !empty( $cart_item['side'] ) && $cart_item['side'] != 'none') || ( isset($cart_item['vegetable']) && ! empty( $cart_item['vegetable'] ) && $cart_item['vegetable'] != 'none' ) || ( isset($cart_item['salad']) && ! empty( $cart_item['salad'] ) && $cart_item['salad'] != 'none' ) || ( isset($cart_item['bread']) && ! empty( $cart_item['bread'] ) && $cart_item['bread'] != 'none' ) || ( isset($cart_item['dessert']) && ! empty( $cart_item['dessert'] ) && $cart_item['dessert'] != 'none' ) ) { ?>

<ul>
<?php
if( isset($cart_item['side']) && !empty( $cart_item['side'] ) && $cart_item['side'] != 'none' ) { ?>
    <li>
        <b>Starches:</b>
        <?php 
            $side_one = $cart_item['side'];
            echo $side_one;
        ?>
    </li>
<?php }

if ( isset($cart_item['vegetable']) && ! empty( $cart_item['vegetable'] ) && $cart_item['vegetable'] != 'none' ) { ?>
    <li>
        <b>Vegetable:</b>
		<?php
		$side_two = $cart_item['vegetable'];
		echo $side_two;
		?>
    </li>
<?php }

if ( isset($cart_item['salad']) && ! empty( $cart_item['salad'] ) && $cart_item['salad'] != 'none' ) { ?>
    <li>
        <b>Salad:</b>
		<?php
            $salad = $cart_item['salad'];
            echo $salad;
        ?>
    </li>
<?php }

if ( isset($cart_item['bread']) && ! empty( $cart_item['bread'] ) && $cart_item['bread'] != 'none' ) { ?>
    <li>
        <b>Bread:</b>
		<?php
		    $bread = $cart_item['bread'];
		    echo $bread;
		?>
    </li>
<?php }

if ( isset($cart_item['dessert']) && ! empty( $cart_item['dessert'] ) && $cart_item['dessert'] != 'none' ) { ?>
    <li>
        <b>Dessert:</b>
	    <?php
            $dessert = $cart_item['dessert'];
            echo $dessert;
	    ?>
    </li>
<?php } ?>
</ul>
<?php  } ?>
<?php    

if ( isset($cart_item['number_of_deliveries']) && ! empty( $cart_item['number_of_deliveries'] ) ) { ?>
    <div class="numOfDelivery">
        <strong>Number of Deliveries:</strong>
        <?php
        $number = $cart_item['number_of_deliveries'];
        echo "<label>$number</label>";
        ?>
    </div>
<?php } ?>
