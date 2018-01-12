<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 * File with toggle shortcode
 *
 */

if ( ! function_exists( 'et_toggle_shortcode' ) ) :
	/**
	 *
	 * Shortcode that output section with toggle
	 *
	 */

	function et_toggle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => 'your title',
			'class' => ''
		), $atts ) );

		$extra_class = '';

		if ( ! empty( $class ) ) {
			$extra_class .= ' '. $class;
		}

		$out  = '';
		$out .= '<div class="et-toggle' . esc_attr( $extra_class ) . '">';
		$out .= '<h4>' . esc_html__( $title, 'xclean-core' ) . '</h4>';
		$out .= '<div class="toggle-content">';
		$out .= $content;
		$out .= '</div><!-- End .toggle-content -->';
		$out .= '</div><!-- End .et-toggle -->';

		return $out;
	}

endif;

?>