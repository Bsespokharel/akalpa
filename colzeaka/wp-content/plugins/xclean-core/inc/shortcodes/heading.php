<?php

if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly
}

/**
 *
 * File with heading shortcode
 *
 */

if ( ! function_exists( 'et_heading_shortcode' ) ) :
	/**
	 *
	 * Shortcode that output heading section.
	 *
	 */

	function et_heading_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'title' => 'Your title',
			'subtitle' => 'Your subtitle',
			'link' => '',
	      	'class' => ''
		), $atts ) );
		    
		$extra_class = '';

		if ( ! empty( $class ) ) {
			$extra_class .= ' '. $class;
		}

		$out = '';
		$out .= '<div class="heading-section' . esc_attr( $extra_class ) . '">';
		$out .= '<div class="title-section">';
		$out .= '<h3>' . esc_html__( $title, 'xclean-core' ) . '</h3>';
		$out .= '<p>' . esc_html__( $subtitle, 'xclean-core' )  . '</p>';
		$out .= '</div><!-- End .title-section -->';

		if ( ( $link == 'categories' ) && xclean_is_woo_exists() ) {
			$type = 'type-category';
			$args = array(
				'taxonomy'     => 'product_cat',
			);

			$all_categories = get_categories( $args ); 
		}

		if ( ( $link == 'post') ) {
			$type = 'type-category';
			$all_categories = get_categories(); 
		}

		if ( $link == 'blog' ) {
			$type = 'type-blog';
			$url  = get_permalink( get_option( 'page_for_posts' ) );
			$text = esc_html__( 'Check out our blog', 'xclean-core' );
		}

		if ( ! empty( $type ) ) {
			$out .= '<div class="content-section ' . $type . '">';
			
			if ( $type !== 'type-blog' ) {
				foreach ( $all_categories as $cat ) {
					$out .= '<a href="' . get_category_link( $cat->term_id ) . '">' . $cat->name . '</a>';
				}
			} else {
				$out .= '<a href="' . $url . '">' . $text . '</a>';
			}

			$out .= '</div><!-- End .content-section -->';
		}

		$out .= '</div><!-- End .heading-section -->';

		return $out;
	}

endif;
?>