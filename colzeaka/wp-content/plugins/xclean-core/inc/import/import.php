<?php 
/**
 *
 * Main import file.
 *
 */


if ( ! function_exists( 'et_import_data' ) ) :
	/**
	 *
	 * The main import function.
	 *
	 */

	function et_import_data() {

		$et_import_resoult = array();

		$file = plugin_dir_path( __FILE__ ) . "dummy/Dummy.xml";

		if ( file_exists( $file ) ) {
			$out  = '<li class="et-admin-success">Xml file exist</li>';
			$out .= et_import_xml( $file )[1];
		} else {
			$out  = '<li class="et-admin-error">Xml file was\'t exist</li>';
		}

		$file = plugin_dir_path( __FILE__ ) . "dummy/options.json";

		if ( file_exists( $file ) ) {
			$file = plugins_url( '/dummy/options.json', __FILE__ );
			$out .= '<li class="et-admin-success">options file exist</li>';
			$out .= et_update_options( $file );
		} else {
			$out .= '<li class="et-admin-error">options file was\'t exist</li>';
		}
		
		$out .= et_update_pages();

		$out .= et_update_menus();

		$out .= et_update_widgets();

		echo '<ul>' . $out . '</ul>';

		update_option( 'et_demo_importer', 1 );

	}

	add_action( 'wp_ajax_et_import_ajax', 'et_import_data' );

endif;


if ( ! function_exists( 'et_import_xml' ) ) :
	/**
	 *
	 * Function that import data from xml file.
	 *
	 */

	function et_import_xml( $file ) {

		//Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';
		$importerError = false;

		if ( ! class_exists( 'WP_Importer' ) ) {

			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

			if ( file_exists( $class_wp_importer ) ) {
				require_once( $class_wp_importer );
			} else {
				$importerError = true;
			}
		}

		if( $importerError !== false ) {
			$out = '<li class="et-admin-error">The Auto importing script could not be loaded. Please use the wordpress importer and import the XML file that is located in your themes folder manually.<li>';
		} else {

			if( class_exists( 'WP_Importer' ) ) {

			try {

				ob_start();

				$importer = new WP_Import();

				$importer->fetch_attachments = true;

				$importer->import( $file );

				$result = ob_get_clean();

				$out = '<li class="et-admin-success">Xml data was installed</li>';

			} catch ( Exception $e ) {
				$result = false;
				$out = '<li class="et-admin-error">Error with Xml installing</li>';
			}

			return array( $result, $out );

			}
		}
	}

endif;


if ( ! function_exists( 'et_update_pages' ) ) :
	/**
	 *
	 * Function that update pages.
	 *
	 */

	function et_update_pages() {

		$home_id = get_page_by_title( 'Home' );
		$blog_id = get_page_by_title( 'Blog' );

		if ( update_option( 'show_on_front', 'page' ) ) {
			$out = '<li class="et-admin-success">"Show on front" option was activated!</li>';
		} elseif ( get_option( 'show_on_front' ) == 'page' ) {
			$out = '<li class="et-admin-success">"Show on front" already activated!</li>';
		} else {
			$out = '<li class="et-admin-error">"Show on front" option was\'t activated!</li>';
		}

		if ( get_post_status( $home_id->ID ) && update_option( 'page_on_front', $home_id->ID ) ) {
			$out .= '<li class="et-admin-success">Front page was updated</li>';
		} elseif ( get_option( 'page_on_front' ) == $home_id->ID ) {
			$out .= '<li class="et-admin-success">Front already updated!</li>';

		} else {
			$out .= '<li class="et-admin-error">Front page was\'t updated</li>';
		}

		if ( get_post_status( $blog_id->ID ) && update_option( 'page_for_posts', $blog_id->ID ) ) {
			$out .= '<li class="et-admin-success">Blog page was updated</li>';

		} elseif ( get_option( 'page_for_posts' ) == $blog_id->ID ) {
			$out .= '<li class="et-admin-success">Blog already updated!</li>';
			
		} else {
			$out .= '<li class="et-admin-error">Blog page was\'t updated</li>';
		}

		return $out;
	}

endif;


if ( ! function_exists( 'et_update_options' ) ) :
	/**
	 *
	 * Function that update options.
	 *
	 */

	function et_update_options( $file ){


			global $xclean_settings;

			if( ! class_exists( 'ReduxFrameworkInstances' ) ) return;

			$new_options = wp_remote_get( $file );
			
			if( ! is_wp_error( $new_options ) ) {
				
				$new_options = json_decode( $new_options['body'], true );

				$new_options = wp_parse_args( $new_options, $xclean_settings );

				$redux = ReduxFrameworkInstances::get_instance( 'xclean_settings' );

				if ( isset ( $redux->validation_ran ) ) {
					unset ( $redux->validation_ran );
				}

				$redux->set_options( $redux->_validate_options( $new_options ) );

				$out = '<li class="et-admin-success">Options was installed</li>';

			} else {
				$out = '<li class="et-admin-error">Error with install options</li>';

			}

	return $out;

	}

endif;


if ( ! function_exists( 'et_update_widgets' ) ) :
	/**
	 *
	 * Function that update widgets.
	 *
	 */

	function et_update_widgets(){

		$widgets 	= require 'widgets-import.php';

		$active_widgets = get_option( 'sidebars_widgets' );
		$widgets_counter = 1;

		foreach ( $widgets as $area => $params ) {

			if ( ! empty( $active_widgets[ $area ] ) && $params['flush'] ) {
				unset( $active_widgets[ $area ] );
			}

			foreach ( $params['widgets'] as $widget => $args ) {
				$active_widgets[ $area ][] = $widget . '-' . $widgets_counter;
				$widget_content = get_option( 'widget_' . $widget );
				$widget_content[ $widgets_counter ] = $args;
				update_option(  'widget_' . $widget, $widget_content );
				$widgets_counter ++;
			}
		}

		if ( update_option( 'sidebars_widgets', $active_widgets ) ) {
			$out = '<li class="et-admin-success">Widgets was updated</li>';
		} elseif ( get_option( 'sidebars_widgets' ) ) {
			$out = '<li class="et-admin-success">Widgets was already updated</li>';
		} else {
			$out = '<li class="et-admin-error">Widgets was\'t updated</li>';
		}
		return $out;
	}

endif;


if ( ! function_exists( 'et_update_menus' ) ) :
	/**
	 *
	 * Function that update menus.
	 *
	 */

	function et_update_menus() {
		global $wpdb;

		$menuname = 'main menu';
		$bpmenulocation = 'header-nav';

		$tablename = $wpdb->prefix . 'terms';
		$menu_ids = $wpdb->get_results(
			"
		    SELECT term_id
		    FROM ".$tablename."
		    WHERE name= '".$menuname."'
		    "
		);

		// results in array
		foreach( $menu_ids as $menu ):
			$menu_id = $menu->term_id;
		endforeach;

		$shop_page = get_option( 'woocommerce_shop_page_id' ); 

		if ( ! empty( $shop_page ) ) {
			$itemData =  array(
				'menu-item-object-id'	=> $shop_page,
				'menu-item-parent-id'	=> 0,
				'menu-item-position'  	=> 2,
				'menu-item-object' 		=> 'page',
				'menu-item-type'      	=> 'post_type',
				'menu-item-status'    	=> 'publish'
			);

			if ( wp_update_nav_menu_item( $menu_id, 0, $itemData ) ) {
				$out = '<li class="et-admin-success">Menus was updated</li>';
			} else {
				$out = '<li class="et-admin-error">Menus was\'t updated</li>';
			}
		}

		if( ! has_nav_menu( $bpmenulocation ) ) {

			$menus = wp_get_nav_menus();

			if( $menus ) {
				foreach( $menus as $menu ) {
					if( $menu->name == 'Menu 1' ) {
						$locations['header-nav'] = $menu->term_id;
					}
				}	
			}

			set_theme_mod('nav_menu_locations', $locations);

			if ( get_theme_mod( 'nav_menu_locations' ) ==  $locations ) {
				$out .= '<li class="et-admin-success">Menus was set</li>';
			} else {
				$out .= '<li class="et-admin-error">Menus was\'t set</li>';
			}

		} else {
			$out .= '<li class="et-admin-success">Menus was already set</li>';
		}

		return $out;
	}
	
endif;


 ?>