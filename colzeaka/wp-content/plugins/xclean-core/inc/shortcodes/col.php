<?php 

if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly
}

/**
 *
 * File with grid col shortcode
 * based on bootstrap grid
 *
 */

if ( ! function_exists( 'et_col_shortcode' ) ) :
	/**
	 *
	 * Shortcode that output col section
	 *
	 */

	function et_col_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'md' => '12',
			'sm' => '12',
			'xs' => '12',
	      	'class' => ''
		), $atts ) );

	   $extra_class = '';

	   if ( ! empty( $class ) ) {
	      $extra_class .= ' '. $class;
	   }

		$class = '';

		if ( ! empty( $md ) ) {
			$class .= 'col-md-' . $md;
		}

		if ( ! empty( $sm ) ) {
			$class .= ' col-sm-' . $sm;
		}
		
		if ( ! empty( $xs ) ) {
			$class .= ' col-xs-' . $xs;
		}

		$out  = '';
		$out .= '<div class="' . esc_attr( $class ) . esc_attr( $extra_class ) . '">';
		$out .= do_shortcode( $content );
		$out .= '</div>';

		return $out;
	}

endif;

?>