<?php 
	add_theme_support('post-thumbnails');
	add_theme_support('menus');
	add_theme_support('widgets');
	add_theme_support('title-tag');
	add_theme_support( 'title-tag' );


	 
		function my_custom_styles() {

			/* enqueue styles */
			wp_enqueue_style('fontawesome-min','https://cdn.jsdelivr.net/fontawesome/4.6.3/css/font-awesome.min.css');
			wp_enqueue_style('bootstrap-css', get_template_directory_uri(). 'themes/bootshop/bootstrap.min.css');
			wp_enqueue_style('bootstrap-css', get_template_directory_uri(). 'themes/css/bootstrap-responsive.min.css');
			//wp_enqueue_style('mdb-css', get_template_directory_uri(). '/css/mdb.min.css');
			
      		wp_enqueue_style('style', get_template_directory_uri(). '/style.css');
      		wp_enqueue_style('base-css', get_template_directory_uri(). 'themes/css/base.css');
      		wp_enqueue_style('prettify-css', get_template_directory_uri(). 'themes/js/google-code-prettify/prettify.css');
      		wp_enqueue_style('googlefont', 'https://fonts.googleapis.com/css?family=Lato:400,700,900');

			
			/* enqueue scripts */
			wp_enqueue_script('bootstrap-js', get_template_directory_uri(). 'themes/js/bootstrap.min.js', array(), false,true);
			wp_enqueue_script('jquery', get_template_directory_uri(). 'themes/js/jquery.js', array(), false,true); 
			wp_enqueue_script('prettify-js', get_template_directory_uri(). 'themes/js/google-code-prettify/prettify.js', array(), false,true); 
			wp_enqueue_script('bootshop-js', get_template_directory_uri(). 'themes/js/bootshop.js', array(), false,true);
			wp_enqueue_script('lightbox-js', get_template_directory_uri(). 'themes/js/jquery.lightbox-0.5.js', array(), false,true); 
     			
			
       wp_enqueue_script('custom', get_template_directory_uri(). '/js/custom.js', array(), false,true);
			//wp_enqueue_script('myjs', get_template_directory_uri(). '/js/myjs.js', array(), false,true);

		}
		add_action ('wp_enqueue_scripts', 'my_custom_styles');
	

?>