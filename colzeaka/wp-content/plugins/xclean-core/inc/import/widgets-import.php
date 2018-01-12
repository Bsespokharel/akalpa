<?php 

$term = get_term_by('name', 'main menu', 'nav_menu');
$menu_id = $term->term_id;

return array(
	'footer-sidebar-2' => array(
		'flush' => true,
		'create' => false,
		'widgets' => array(
			'nav_menu' => array(
				'title' => '',
				'nav_menu' => $menu_id
			),
		)
	),
	'copyright-sidebar-2' => array(
		'flush' => true,
		'create' => false,
		'widgets' => array(
			'social-widget' => array(
				'title'    => '',
				'facebook' => '#',
				'twitter'  => '#',
				'google'   => '#',
				'tumblr'   => '#',
				'dribbble' => '#'
			),
		)
	),
);
