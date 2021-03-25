<?php 

	global $product, $post;

	$before_price_text = "Meal for 2 from";

	if ( 'variable' === $product->get_type() ) {
		$variations = $product->get_available_variations();

		if ( is_array( $variations ) ) {
			foreach ( $variations as $variation ) {
				if ( isset( $variation['attributes']['attribute_pa_meal-size'] ) && $variation['attributes']['attribute_pa_meal-size'] === 'gourmet-meal-1' ) {
					$before_price_text = "Meal for 1 from";
				}
			}
		}
	}

	$terms = wp_get_post_terms( $post->ID, 'product_cat' );
	foreach ( $terms as $term ) {
		$categories[] = $term->slug;
	}
	if ( in_array( 'kids-meals', $categories ) ) {
		$before_price_text = "Meal for 1 from";
	}

?>

<span class="price iof-price">
	<?php echo $before_price_text; ?>
	<span class="woocommerce-Price-amount amount">
		<span class="woocommerce-Price-currencySymbol"> $</span>
		<?php echo $price; ?>
	</span>
</span>