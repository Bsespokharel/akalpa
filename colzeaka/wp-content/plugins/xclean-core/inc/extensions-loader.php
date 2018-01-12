<?php 

/**
 *
 * File with extension loader.
 *
 */


if( ! function_exists( 'et_redux_register_extension_loader' ) ) :
	/**
	 *
	 * Register redux extension loader.
	 *
	 */
	
	function et_redux_register_extension_loader( $ReduxFramework ) {
		$path = dirname( __FILE__ ) . '/extensions/';
		$folders = scandir( $path, 1 );
		
		foreach( $folders as $folder ) {
			if ( $folder === '.' or $folder === '..' or !is_dir( $path . $folder ) ) {
				continue;	
			} 
			$extension_class = 'ReduxFramework_Extension_' . $folder;
			if( ! class_exists( $extension_class ) ) {
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/'.$ReduxFramework->args[ 'opt_name' ].'/'.$folder, $class_file );
				if( $class_file ) {
					require_once( $class_file );
					$extension = new $extension_class( $ReduxFramework );
				}
			}
		}
	}

	add_action("redux/extensions/before", 'et_redux_register_extension_loader', 0);

endif;

?>