<?php

if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly
}

/**
 *
 * File with banner shortcode.
 *
 */

if ( ! function_exists( 'et_banner_shortcode' ) ) :
	/**
	 *
	 * Shortcode that output section with banner.
	 *
	 */

	function et_banner_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title'            => 'your title',
			'horizontal'       => 'center',
			'vertical'         => 'middle',
			'image' 		   => '',
			'type' 			   => 'bordered',
			'url'              => '',
			'class'      	   => ''
		), $atts ) );



		$section_class = '';
		$section_class .= ' '. $type;

		if ( ! empty( $class ) ) {
			$section_class .= ' '. $class;
		}

		$class = '';
		$class .= 'horizontal-' . $horizontal;
		$class .= ' vertical-' . $vertical;

		$out = '';
		$out .= '<div class="banner-section' . esc_attr( $section_class ) . '">';

		if ( ! empty( $url ) ) {
			$out .= '<a href="' . esc_url( $url ) . '">';
		}
		
		if ( ! empty( $image ) ) {
			$out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '">';
		}
		
		$out .= '<div class="' . esc_attr( $class ) . '">';

		if ( ! empty( $title ) ) {
			$out .= '<h4>' . esc_html__( $title, 'xclean-core' ) . '</h4>';
		}
		$out .= '<div class="banner-content">';
		$out .= $content;
		$out .= '</div><!-- End .banner-content -->';
		$out .= '</div>';
		
		if ( ! empty( $url ) ) {
			$out .= '</a>';
		}
		
		$out .= '</div>';

		return $out;
	}

endif;

?>