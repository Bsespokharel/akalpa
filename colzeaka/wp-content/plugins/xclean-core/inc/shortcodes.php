<?php 
/**
 *
 * Main shortcodes file.
 *
 */


if ( ! function_exists( 'et_shortcodes_scripts' ) ) :
	/**
	 *
	 * Load plugin shortcodes and styles.
	 *
	 */

	function et_shortcodes_scripts() {

		/**
		 * Register plugin scripts.
		 */
		wp_register_script( 'et-plugin-scripts' ,plugins_url( '/shortcodes/js/shortcodes.js', __FILE__ ),array( 'jquery' ), false, true );

		/**
		 * Load the plugin scripts.
		 */
		wp_enqueue_script( 'et-plugin-scripts' );

		/**
		 * Load the plugin scripts.
		 */
		wp_enqueue_style( 'et-plugin-style', plugins_url( '/shortcodes/css/shortcodes.css', __FILE__ ) );
	}

	add_action( 'wp_enqueue_scripts', 'et_shortcodes_scripts' );

endif;


if ( ! function_exists( 'et_shortcodes_plugin' ) ) :
	/**
	 *
	 * Initial shortcodes.
	 *
	 */

	function et_shortcodes_plugin() {

		// Check if xclean theme is enabled.
		if ( function_exists( 'xclean_is_woo_exists' ) ) {
			$shortcodes = array( 'banner', 'heading', 'row', 'col', 'toggle', 'latest_posts' );

			foreach ($shortcodes as $shortcode) {
				require_once('shortcodes/' . $shortcode . '.php');
				add_shortcode('et_' . $shortcode, 'et_' . $shortcode . '_shortcode');
			}
		}
	}

	add_action('init', 'et_shortcodes_plugin');

endif;


if ( ! function_exists( 'et_add_mce_button' ) ) :
	/**
	 *
	 * Add shortcodes button to MCE.
	 *
	 */

	function et_add_mce_button() {
	    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
	        return;
	    }
	    if ( 'true' == get_user_option( 'rich_editing' ) ) {
	        add_filter( 'mce_external_plugins', 'et_add_tinymce_plugin' );
	        add_filter( 'mce_buttons', 'et_register_mce_button' );
	    }
	}
	add_action( 'admin_head', 'et_add_mce_button' );

endif;


if ( ! function_exists( 'et_add_tinymce_plugin' ) ) :
	/**
	 *
	 * Declare script for new button.
	 *
	 */

	function et_add_tinymce_plugin( $plugin_array ) {
		$plugin_array['et_mce_button'] =  plugins_url( '/shortcodes/js/mce.js' , __FILE__ );
	    return $plugin_array;
	}

endif;


	if ( ! function_exists( 'et_register_mce_button' ) ) :
	/**
	 *
	 * Register new button in the editor.
	 *
	 */

	function et_register_mce_button( $buttons ) {
	    array_push( $buttons, 'et_mce_button' );
	    return $buttons;
	}

endif;

?>