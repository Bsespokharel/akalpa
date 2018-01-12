<?php

if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly
}

/**
 *
 * File with latest posts shortcode.
 *
 */

if ( ! function_exists( 'et_latest_posts_shortcode' ) ) :
	/**
	 *
	 * Shortcode that output latest post
	 * 
	 */

	function et_latest_posts_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'quantity' => '4',
			'orderby' => 'ID',
			'order' => 'ASC',
			'category' => '',
			'class' => ''
		), $atts ) );

		if ( ! empty( $category ) ) {
			$category = explode( "," , $category );
		}

		if ( ! empty( $class ) ) {
			$extra_class = $class;
		}

		$class = '';
		$class = ' '. 'et-latest';

		if ( ! empty( $extra_class ) ) {
			$class .= ' '. $extra_class;
		}
		
		$quantity = intval( $quantity );
		
		$id= rand( 100, 999 );

		ob_start();

		$out = '';

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $quantity,
			'orderby' => esc_attr( $orderby ),
			'order' => esc_attr( $order ),
			'category__in' => $category,
		);

		xclean_post_carousel( $args, $class, $id );

		$out .= ob_get_clean();

		return $out;
	}

endif;

?>