<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 * File with grid row shortcode
 * based on bootstrap grid
 *
 */

if ( ! function_exists( 'et_row_shortcode' ) ) :
	/**
	 *
	 * Shortcode that output row section
	 * 
	 */

	function et_row_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
	      	'class' => ''
		), $atts ) );

	   $extra_class = '';

	   if ( ! empty( $class ) ) {
	      $extra_class .= ' '. $class;
	   }

		$out  = '';
		$out .= '<div class="row' . esc_attr( $extra_class ) . '">';
		$out .= do_shortcode( $content );
		$out .= '</div>';

		return $out;
	}

endif;

?>