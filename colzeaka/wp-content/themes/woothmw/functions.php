<?php
/**
 * Xclean functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
*/

/**
 *
 * Define constants.
 *
 */

add_action( 'wp', 'redirect' );
function redirect() {
  if ( !is_page('my-account') && !is_user_logged_in() ) {
      wp_redirect( home_url('/my-account') );
      die();
  }
}
add_action( 'wp_logout', 'auto_redirect_external_after_logout');
function auto_redirect_external_after_logout(){
  wp_redirect( home_url('/my-account') );
  exit();
}

 define( 'XCLEAN_THEMEROOT', get_stylesheet_directory_uri() );
 define( 'XCLEAN_IMAGES' , XCLEAN_THEMEROOT . '/img' );
 define( 'XCLEAN_SCRIPTS' , XCLEAN_THEMEROOT . '/js' );
 define( 'XCLEAN_FRAMEWORK' , get_template_directory() . '/framework' );


/**
 *
 * Load the framework.
 *
 */
require_once( XCLEAN_FRAMEWORK . '/init.php' );



if ( function_exists( 'xclean_content_width' ) ) :
/**
 *
 * Set up the content width value based on the theme's design.
 *
 */
function xclean_content_width() {
	if ( ! isset( $content_width ) ) {
		$content_width = 800;
	}
}
endif;


if ( ! function_exists( 'xclean_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own xclean_setup() function to override in a child theme.
 */

function xclean_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * to change 'an' to the name of your theme in all the template files
	 */

	$lang_dir = XCLEAN_THEMEROOT . '/languages';
	load_theme_textdomain( 'xclean', get_template_directory() . '/languages' );

	/**
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array(
			'gallery',
			'link',
			'image',
			'quote',
			'video',
			'audio'
	) );

	/**
	 * Add support for automatic feed links.
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Add support for post thumbnails.
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Register nav menus.
	 */
	register_nav_menus( array(
			'header-nav' => esc_html__( 'Header navigation', 'xclean' ),
	) );
}

add_action( 'after_setup_theme', 'xclean_setup' );
endif;


if ( ! function_exists( 'xclean_scripts' ) ) :
/**
 *
 * Load the custom scripts to the theme.
 *
 */

function xclean_scripts() {
	/**
	 * Add support for pages with comments.
	 */

	if( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Register scripts.
	 */
	wp_register_script( 'bootstrap-js', XCLEAN_SCRIPTS . '/bootstrap.min.js', array('jquery'), false, true );
	wp_register_script( 'owl.carousel', XCLEAN_SCRIPTS . '/owl-carousel/owl.carousel.js', array('jquery'), false, true );
 	wp_register_script( 'et-modernizr', XCLEAN_SCRIPTS . '/et-modernizr.js', array('jquery'), false, true );
	wp_register_script( 'et-scripts', XCLEAN_SCRIPTS . '/main-script.js', array('jquery'), false, true );

	/**
	 * Load the custom scripts.
	 */
	wp_enqueue_script( 'bootstrap-js' );
	wp_enqueue_script( 'owl.carousel' );
	wp_enqueue_script( 'et-scripts' );
	wp_enqueue_script( 'et-modernizr' );

	/**
	 * Load the stylesheets.
	 */
	wp_enqueue_style( 'bootstrap-style', XCLEAN_THEMEROOT . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', XCLEAN_THEMEROOT . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'style', XCLEAN_THEMEROOT . '/style.css' );
	wp_enqueue_style( 'responsive', XCLEAN_THEMEROOT . '/responsive.css' );
	wp_enqueue_style( 'custom-style', XCLEAN_THEMEROOT . '/css/custom-style.css' );

}

add_action( 'wp_enqueue_scripts', 'xclean_scripts' );
endif;


if ( ! function_exists( 'xclean_enqueue_google_font') ) :
/**
 *
 * Enqueue Google Fonts.
 *
 */

function xclean_enqueue_google_font() {

	$query_args = array(
		'family' => 'Roboto+Condensed:400,700,300'
	);

	wp_register_style( 'google-fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
	wp_enqueue_style( 'google-fonts' );

}
add_action( 'wp_enqueue_scripts', 'xclean_enqueue_google_font' );
endif;


if ( ! function_exists( 'xclean_widget_init' ) ) :
/**
 *
 * Register the widget area.
 *
 */

function xclean_widget_init() {
	if ( function_exists( 'register_sidebar' ) ){
		register_sidebar( array(
				'name' 		    => esc_html__( 'Main Widget Area', 'xclean' ),
				'id'   		    => 'main-sidebar',
				'desctiption'   => esc_html__( 'Appears on posts and pages', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
		) );

		register_sidebar( array(
				'name' 		    => esc_html__( 'First-footer Widget Area', 'xclean' ),
				'id'   		    => 'footer-sidebar-1',
				'desctiption'   => esc_html__( 'Appears on fotter', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
		) );

		register_sidebar( array(
				'name' 		    => esc_html__( 'Second-footer Widget Area', 'xclean' ),
				'id'   		    => 'footer-sidebar-2',
				'desctiption'   => esc_html__( 'Appears on fotter', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
		) );

		register_sidebar( array(
				'name' 		    => esc_html__( 'Full-width-footer Widget Area', 'xclean' ),
				'id'   		    => 'footer-sidebar-3',
				'desctiption'   => esc_html__( 'Appears on fotter', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
		) );

		register_sidebar( array(
				'name' 		    => esc_html__( 'First-copyright Widget Area', 'xclean' ),
				'id'   		    => 'copyright-sidebar-1',
				'desctiption'   => esc_html__( 'Appears on copyright', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="copyright-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
		) );

		register_sidebar( array(
				'name' 		    => esc_html__( 'Second-copyright Widget Area', 'xclean' ),
				'id'   		    => 'copyright-sidebar-2',
				'desctiption'   => esc_html__( 'Appears on copyright', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="copyright-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
		) );

		register_sidebar( array(
				'name' 		    => esc_html__( 'Full-width-copyright Widget Area', 'xclean' ),
				'id'   		    => 'copyright-sidebar-3',
				'desctiption'   => esc_html__( 'Appears on copyright', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="copyright-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
		) );

		if ( xclean_is_woo_exists() ) {
			register_sidebar( array(
				'name' 		    => esc_html__( 'Shop Widget Area', 'xclean' ),
				'id'   		    => 'shop-sidebar',
				'desctiption'   => esc_html__( 'Appears on Shop', 'xclean' ),
				'before_widget' => '<div id="%1$s" class="Shop-widgets %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title" >',
				'after_title'   => '</h5>',
			) );
		}
	}
}

add_action( 'widgets_init', 'xclean_widget_init' );
endif;


if ( ! function_exists( 'xclean_require_plugins' ) ) :
/**
 *
 * Register plagins thet nead to be instaled.
 *
 */

function xclean_require_plugins() {

	$plugins = array(
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),

		array(
			'name'      => 'WooCommerce Quantity Increment',
			'slug'      => 'woocommerce-quantity-increment',
			'required'  => false,
		),

		array(
			'name'      => 'WooCommerce Shortcodes',
			'slug'      => 'woocommerce-shortcodes',
			'required'  => false,
		),

		array(
			'name'      => 'contact-form-7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),

		array(
			'name'      => 'WP Google Maps',
			'slug'      => 'wp-google-maps',
			'required'  => false,
		),

		array(
			'name'      => 'Redux Framework',
			'slug'      => 'redux-framework',
			'required'  => false,
		),

		array(
			'name'      => 'Meta Slider',
			'slug'      => 'ml-slider',
			'required'  => false,
		),

		array(
			'name'      => 'YITH WooCommerce Zoom Magnifier',
			'slug'      => 'yith-woocommerce-zoom-magnifier',
			'required'  => false,
		),

		array(
			'name'      => 'xclean core',
			'slug'      => 'xclean-core',
			'source'    => 'http://8theme.com/import/xclean/plugins/xclean-core.zip',
			'required'  => false,
		)
	);

	$config = array(
		'id' => 'xclean-tgmpa',
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'xclean_require_plugins' );
endif;


/**
 *
 * Intedrate ReduxFramework.
 *
 */

if ( ! isset( $redux_demo ) && file_exists( XCLEAN_FRAMEWORK . '/theme-config.php' ) ) {
    require_once( XCLEAN_FRAMEWORK . '/theme-config.php' );
}


if ( ! function_exists( 'xclean_removeDemoModeLink' ) ) :
/**
 *
 * Remove redux demo mode link.
 *
 */
	function xclean_removeDemoModeLink() {
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
    }
}

add_action( 'init', 'xclean_removeDemoModeLink' );
endif;
add_action( 'woocommerce_after_shop_loop_item', function(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
}, 1 );




/*add_action( 'woocommerce_after_single_product_summary', 'content_after_addtocart_button' ,1);
 
function content_after_addtocart_button() {  ?>


<?php if( have_rows('product_description_') ):

 	// loop through the rows of data

	
	
    while ( have_rows('product_description_') ) : 
    	the_row(); 
    	?>
    <div class="price-content-section">
		<div class="row">

			<div class="col-md-6">
				<div class="website_title"><a target="_blank"  href="<?php echo get_sub_field(aka_website_link); ?>"><?php echo get_sub_field(aka_website_name);?></a></div>

			</div>
			<div class="col-md-6">
				<?php	
				
				$blocks[] = get_sub_field('aka_product_price');





				?>
			</div>
			
	</div>
</div>
<?php
        // display a sub field value
        

    endwhile;

    $numbers = $blocks;
    print_r($blocks);
sort($numbers);

$arrlength = count($numbers);
for($x = 0; $x < $arrlength; $x++) {
    echo $numbers[$x];
    echo "<br>";
}

else :

    // no rows found

endif;?>


	
	



</div>
<?php } 

add_action( 'woocommerce_after_shop_loop_item_title', 'aka_content_after_addtocart_button' );
 
function aka_content_after_addtocart_button() {  ?>
<div class="price-content-section">

<?php if( have_rows('product_description_') ):

 	// loop through the rows of data
    while ( have_rows('product_description_') ) : 
    	the_row(); ?>
		<div class="row">

		
		
			Starting From: <?php echo get_sub_field(aka_product_price); ?>
		
			</div>	
<?php
        // display a sub field value
        

    endwhile;

else :

    // no rows found

endif;?>


	
	



</div>
<?php } 

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

*/


add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

 

function custom_variation_price( $price, $product ) {

 

     $price = '';

 

     $price .= 'Best Price '.wc_price($product->get_price());

 

     return $price;

}

//sort price


add_action( 'woocommerce_after_add_to_cart_button', 'aka_content_after_addtocart_button' );
function aka_content_after_addtocart_button(){
    global $woocommerce, $product, $post;
        // test if product is variable
        if ($product->is_type( 'variable' )){
            $available_variations = $product->get_available_variations();
            $price_lists = [];
			//print_r($available_variations);
			foreach ($available_variations as $key => $value) { 
				$display_price = $value['display_price'];

				$val =  $value['attributes']; 
				// $val= asort($val);

				// print_r($value);
				$price_lists[$val['attribute_website']] = $value['display_price'];

				//$value['display_price'];
			}
            asort($price_lists);

            foreach ($price_lists as $key => $value) { ?>
                	<div class="comparing">
                        	<div class="row">
                                	<div class="col-md-6">
                                    			
                                    			<?php  

                                    			echo $key;?>
                                    </div>
                                    <div class="col-md-3">
                                    	<span>	<?php echo $value;?></span>
                                    		
                                    </div>

                            </div>
                    </div>

                          <?php      
            }
	}
}