<?php

/*************************************************

	Retirection to user profile after login

*************************************************/

/*add_filter( 'bp_login_redirect', 'riot_redirect_to_profile', 11, 3 );

function riot_redirect_to_profile( $redirect_to_calculated, $redirect_url_specified, $user ){

	if( empty( $redirect_to_calculated ) )

		$redirect_to_calculated = admin_url();


	//if the user is not site admin,redirect to his/her profile

	if( isset( $user->ID) && ! is_super_admin( $user->ID ) )

		return bp_core_get_user_domain( $user->ID );

	else

		return $redirect_to_calculated;


}
*/




/*************************************************

	Error login prevent to redirect in wp-login

*************************************************/

/*function riot_frontend_login_fail( $username ) {



     $referrer = $_SERVER['HTTP_REFERER'];  //URL

     // if there's a valid referrer, and it's not the default log-in screen

     if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {

          wp_redirect(home_url() . '/login?status=failed' );  // let's append some information (login=failed) to the URL for the theme to use

          exit;

     }



}

add_action( 'wp_login_failed', 'riot_frontend_login_fail' ); */ // hook failed login





/*************************************************

	Hide start a club menu after user logged in

*************************************************/

/*function riot_exclude_menu_items( $items, $menu, $args ) {

    // Iterate over the items to search and destroy

	//check if user is logged in

    if( is_user_logged_in() == true && !is_admin() ){

    foreach ( $items as $key => $item ) {

        if ( $item->object_id == 197 )

        	unset( $items[$key] );

    }



    }



    return $items;



}

add_filter( 'wp_get_nav_menu_items', 'riot_exclude_menu_items', null, 3 );

*/



/*************************************************

	shortcode to display bbpress profile

*************************************************/

/*function riot_remove_admin_bar() {

 show_admin_bar(false);

}*/

//add_action('after_setup_theme', 'riot_remove_admin_bar');





/*************************************************

	shortcode to display bbpress profile

*************************************************/

function riot_display_members( $args ){

	 $riot_members = '';

	 if( !empty($args['list_user']) ):
	 	$user_id = $args['list_user'];
	 	//change string to array
		$array_one   = explode(',', $user_id);
	 endif;

	 if( empty($args['list']) ){
	 	$args['list'] = '';
	 }

	 if( $args['list'] == 'directory' ){

	 	$container = 'container';
	 	$row = 'row';

	 }else{

	 	$container = '';
	 	$row = '';
	 	$number_of_posts = 5;

	 }

	 $riot_members .= '<div id="riot_memberwrap" class="'. $container .'">';

	 //Directory Filter Starts-----------------------------------------
	 if( $args['list'] == 'directory' ){
		$riot_members .= '
		<h2>Registered Clubs <span><select id="dir_filter_club">
		 <option>All</option>';
		$location_collection = array();
	 	$users_detail = get_users();
	 		$counter = 0;
		 	foreach( $users_detail as $user ){
		 		$counter++ ;
		 		$location = xprofile_get_field_data( 'Location' , $user->ID );

			 		if( !in_array($location, $location_collection ) && !empty( $location ) ){
			 			$location_collection[] = $location;
			 			$riot_members .= '<option value="'. $location .'">'. $location .'</option>';
			 		}

		 	}

		 	$number_of_posts = $counter;

		$riot_members .= '</select></span>

			<div class="loading">
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			</div>

		</h2>';

	 }else{}
	 //Directory Filter Ends------------------------------------

	 $riot_members .= '<div id="riot_member_rowwrap" class="' . $row . '">';
	 $all_users = get_users();
	 $count = 0;

	 foreach( $all_users as $list_users ){

	 	if( $args['list'] == 'directory' ){

			if( $count < $number_of_posts ):

		 	if( $list_users->ID != 1 ):

		 	//get club faculty data------------

		 	$faculity = xprofile_get_field_data( 'Faculty' , $list_users->ID );

		 	if( !empty( $faculity ) ):
		 		//$faculty_view = '<div class="faculty">'. $faculity .'</div>';
		 		$faculty_view = '<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i> '. $faculity .'</div>';
		 	else:
		 		$faculty_view = '';
		 	endif;



		 	//get club contact person data------------

		 	$contact_person = xprofile_get_field_data( 'Contact Person' , $list_users->ID );
		 	if( !empty( $contact_person ) ):
		 		$contact = '<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>';
		 	else:
		 		$contact = '';
		 	endif;


		 	//Main loop------------------

		 	$riot_members .='

		 	<div id="' . $list_users->ID . '" class="col-sm-4 riot_profile">
		 		<a>
			 		<div class=" reg-club-blk">
						<div class="image-wrap">'
			 			. get_avatar( $list_users->ID ) .

			 			'</div>

						<div class="content-wrap">
							<h4>'. $list_users->data->display_name .'</h4>
							'. $faculty_view .'
							'. $contact .'
						</div>

			 		</div>
			 	</a>
		 	</div>
		 	';
	 	    $count++ ;
		 	endif;

		 endif;

	 	}else{

	 		if( in_array($list_users->ID, $array_one) ):

				if( $count < $number_of_posts ):

			 	if( $list_users->ID != 1 ):

			 	//get club faculty data------------

			 	$faculity = xprofile_get_field_data( 'Faculty' , $list_users->ID );

			 	if( !empty( $faculity ) ):
			 		//$faculty_view = '<div class="faculty">'. $faculity .'</div>';
			 		$faculty_view = '<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i> '. $faculity .'</div>';
			 	else:
			 		$faculty_view = '';
			 	endif;



			 	//get club contact person data------------

			 	$contact_person = xprofile_get_field_data( 'Contact Person' , $list_users->ID );
			 	if( !empty( $contact_person ) ):
			 		$contact = '<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>';
			 	else:
			 		$contact = '';
			 	endif;


			 	//Main loop------------------

			 	$riot_members .='

			 	<div id="' . $list_users->ID . '" class="col-sm-4 riot_profile">
			 		<a>
				 		<div class=" reg-club-blk">
							<div class="image-wrap">'
				 			. get_avatar( $list_users->ID ) .

				 			'</div>

							<div class="content-wrap">
								<h4>'. $list_users->data->display_name .'</h4>
								'. $faculty_view .'
								'. $contact .'
							</div>

				 		</div>
				 	</a>
			 	</div>
			 	';
		 	    $count++ ;
			 	endif;

			 endif;

	 		endif;

		}

	 }



	/* if( $args['list'] == 'directory' ):
	 	$riot_members .= '
	 	<a href="'. get_home_url('/start-a-club') .'">
			<div class="col-md-4 register-club">
                <div class="register-club-body">
                    <div class="register-club-meta">
                        <h3 class="name">CONNECT WITH <br> A CLUB </h3>
                        <span>Get in contact with other clubs to start tournaments, share information or ask advice.</span>
                    </div>
                </div>
            </div>
        </a>
	  ';
	 endif;*/


	 $riot_members .=

	 '
	 </div>
	</div>
	';



	if( $args['list'] == 'directory' ){
	$riot_members .=  '<div class="load_more_wrap"><button id="load_more_profile">Load More <i class="fa fa-arrow-right" aria-hidden="true"></i></button></div>
	<div class="clearfix"></div>
	 ';

	}

	return $riot_members;

}

add_shortcode( 'riot_clubs', 'riot_display_members' );


function riot_display_members_directory( $args ){

	 $riot_members = '';

	 if( !empty($args['list_user']) ):
	 	$user_id = $args['list_user'];
	 	//change string to array
		$array_one   = explode(',', $user_id);
	 endif;

	 if( empty($args['list']) ){
	 	$args['list'] = '';
	 }

	 if( $args['list'] == 'directory' ){

	 	$container = 'container';
	 	$row = 'row';

	 }else{

	 	$container = '';
	 	$row = '';
	 	$number_of_posts = 3;

	 }

	 $riot_members .= '<div id="riot_memberwrap" class="'. $container .'">';

	 //Directory Filter Starts-----------------------------------------
	 if( $args['list'] == 'directory' ){
		$riot_members .= '
		<h2>Registered Clubs <span><ul id="dir_filter_club">
		 <li class="riot_memberwraps active" data-value="All">All</li>';
		$location_collection = array();
	 	$users_detail = get_users();
	 	//print_r($users_detail);
	 		$counter = 0;
		 	foreach( $users_detail as $user ){
		 		$counter++ ;
		 		$location = xprofile_get_field_data( 'Location' , $user->ID );
		 		//print_r($location);
			 		if( !in_array($location, $location_collection ) && !empty( $location ) ){
			 			$location_collection[] = $location;
			 			$riot_members .= '<li class="riot_memberwraps" data-value="'. $location .'">'. $location .'</li>';
			 		}

		 	}

		 	$number_of_posts = $counter;

		$riot_members .= '</ul></span>

			<div class="loading">
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			</div>

		</h2>';

	 }else{}
	 //Directory Filter Ends------------------------------------

	 $riot_members .= '<div id="riot_member_rowwrap" class="' . $row . '">';
	 $argscontent = array(

	'orderby'      => 'display_name',
	'order'        => 'ASC'

 );
	 $all_users = get_users($argscontent);
	 //$all_users = get_users();
	 $count = 0;

	 foreach( $all_users as $list_users ){

	 	if( $args['list'] == 'directory' ){

	 		//get club dictory listing data------------
		    $club_dir = xprofile_get_field_data( 'Club Directory List' , $list_users->ID );

		 	if( $club_dir == 'Yes' ):

					if( $count < $number_of_posts ):

				 	if( $list_users->ID != 1 ):

				 	//get club faculty data------------
				 	$faculity = xprofile_get_field_data( 'Faculty' , $list_users->ID );
				 	if( !empty( $faculity ) ):
				 		//$faculty_view = '<div class="faculty">'. $faculity .'</div>';
				 		$faculty_view = '<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i> '. $faculity .'</div>';
				 	else:
				 		$faculty_view = '';
				 	endif;


				 	//get club contact person data------------
				 	$contact_person = xprofile_get_field_data( 'Contact Person' , $list_users->ID );
				 	if( !empty( $contact_person ) ):
				 		$contact = '<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>';
				 	else:
				 		$contact = '';
				 	endif;


				 	//Main loop------------------

				 	$riot_members .='
				 	<div id="' . $list_users->ID . '" class="col-sm-4 riot_profile">
				 		<a>
					 		<div class=" reg-club-blk">
								<div class="image-wrap">'
					 			. get_avatar( $list_users->ID ) .

					 			'</div>

								<div class="content-wrap">
									<h4>'. $list_users->data->display_name .'</h4>
									'. $faculty_view .'
									'. $contact .'
								</div>

					 		</div>
					 	</a>
				 	</div>
				 	';
			 	    $count++ ;
				 	endif;

				 endif;

			endif;

	 	}else{

	 		if( in_array($list_users->ID, $array_one) ):

				if( $count < $number_of_posts ):

			 	if( $list_users->ID != 1 ):

			 	//get club faculty data------------

			 	$faculity = xprofile_get_field_data( 'Faculty' , $list_users->ID );

			 	if( !empty( $faculity ) ):
			 		//$faculty_view = '<div class="faculty">'. $faculity .'</div>';
			 		$faculty_view = '<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i> '. $faculity .'</div>';
			 	else:
			 		$faculty_view = '';
			 	endif;



			 	//get club contact person data------------

			 	$contact_person = xprofile_get_field_data( 'Contact Person' , $list_users->ID );
			 	if( !empty( $contact_person ) ):
			 		$contact = '<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>';
			 	else:
			 		$contact = '';
			 	endif;


			 	//Main loop------------------

			 	$riot_members .='

			 	<div id="' . $list_users->ID . '" class="col-sm-4 riot_profile">
			 		<a>
				 		<div class=" reg-club-blk">
							<div class="image-wrap">'
				 			. get_avatar( $list_users->ID ) .

				 			'</div>

							<div class="content-wrap">
								<h4>'. $list_users->data->display_name .'</h4>
								'. $faculty_view .'
								'. $contact .'
							</div>

				 		</div>
				 	</a>
			 	</div>
			 	';
		 	    $count++ ;
			 	endif;

			 endif;

	 		endif;

		}

	 }


/*
	 if( $args['list'] == 'directory' ):
	 	$riot_members .= '
	 	<a href="'. get_home_url('/start-a-club') .'">
			<div class="col-md-4 register-club">
                <div class="register-club-body">
                    <div class="register-club-meta">
                        <h3 class="name">CONNECT WITH <br> A CLUB </h3>
                        <span>Get in contact with other clubs to start tournaments, share information or ask advice.</span>
                    </div>
                </div>
            </div>
        </a>
	  ';
	 endif;
*/

	 $riot_members .=

	 '
	 </div>
	</div>
	';



/*	if( $args['list'] == 'directory' ){
	$riot_members .=  '<div class="load_more_wrap"><button id="load_more_profile">Load More <i class="fa fa-arrow-right" aria-hidden="true"></i></button></div>
	<div class="clearfix"></div>
	 ';

	}*/

	return $riot_members;

}

add_shortcode( 'riot_clubs_directory', 'riot_display_members_directory' );



/*************************************************

	shortcode to display bbpress profile  ends

*************************************************/



/*************************************************

	profile filter according to location starts

*************************************************/

function riot_location_filter(){



	$location = $_POST['location'];

	if( !empty( $location ) ):

		$filter_user = ''; $argscontent = array(
			'orderby'      => 'display_name',
			'order'        => 'ASC'
		 );
	 	$all_users = get_users($argscontent);
		//$all_users = get_users();
		foreach ($all_users as $display_users) {

		$club_dir = xprofile_get_field_data( 'Club Directory List' , $display_users->ID );
		if( $club_dir == 'Yes' ):

					//get club location data------------
					$club_location = xprofile_get_field_data( 'Location' , $display_users->ID );
					if( !empty( $club_location ) && $club_location == $location || $location == 'All' ):

						//get club faculty data-------------
					 	$faculity = xprofile_get_field_data( 'Faculty' , $display_users->ID );
					 	if( !empty( $faculity ) ):
					 		$faculty_view = '<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i> '. $faculity .'</div>';
					 	else:
					 		$faculty_view = '';
					 	endif;

					 	//get club contact person data------------
					 	$contact_person = xprofile_get_field_data( 'Contact Person' , $display_users->ID );
					 	if( !empty( $contact_person ) ):
					 		$contact = '<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>';
					 	else:
					 		$contact = '';
					 	endif;



					 	//make content ready to return
					 	echo '
					 	<div id="' . $display_users->ID . '" class="col-sm-4 riot_profile">
					 		<a>
						 		<div class=" reg-club-blk">
									<div class="image-wrap">'
						 			. get_avatar( $display_users->ID ) .
						 			'</div>

									<div class="content-wrap">
										<h4>'. $display_users->data->display_name .'</h4>
										'. $faculty_view .'
										'. $contact .'
									</div>
						 		</div>
						 	</a>
					 	</div>
					 	';
				 	endif;


				 	//reset $location variable
				 	$club_location = '';
		 	endif;

			}

		endif;

	die;



}

add_action( 'wp_ajax_riot_location_filter' , 'riot_location_filter' );
add_action( 'wp_ajax_nopriv_riot_location_filter' , 'riot_location_filter' );

/*************************************************

	profile filter according to location ends

*************************************************/



/*************************************************

	load more profile starts

*************************************************/

function riot_load_more_profile(){

	$exclude_ids = $_POST['exclude_ids'];
	$location_filter = $_POST['location_filter'];
	$all_users = get_users();

	foreach ( $all_users as $view_users ) {

	$club_dir = xprofile_get_field_data( 'Club Directory List' , $display_users->ID );
	if( $club_dir == 'Yes' ):

			//get club location data------------
			$club_location = xprofile_get_field_data( 'Location' , $view_users->ID );
			if( (!in_array( $view_users->ID, $exclude_ids ) && $club_location == $location_filter) || ( !in_array( $view_users->ID, $exclude_ids ) && 'All' == $location_filter ) ):


				//get club faculty data-------------
			 	$faculity = xprofile_get_field_data( 'Faculty' , $view_users->ID );
			 	if( !empty( $faculity ) ):
			 		$faculty_view = '<div class="faculty">'. $faculity .'</div>';
			 	else:
			 		$faculty_view = '';
			 	endif;

			 	//get club contact person data------------

			 	$contact_person = xprofile_get_field_data( 'Contact Person' , $view_users->ID );
			 	if( !empty( $contact_person ) ):
			 		$contact = '<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>';
			 	else:
			 		$contact = '';
			 	endif;

			 	//make content ready to return
			 	echo '
			 	<div id="' . $view_users->ID . '" class="col-sm-4 riot_profile">
			 		<a>
				 		<div class=" reg-club-blk">
							<div class="image-wrap">'
				 			. get_avatar( $view_users->ID ) .
				 			'</div>
							<div class="content-wrap">
								<h4>'. $view_users->data->display_name .'</h4>
								'. $faculty_view .'
								'. $contact .'
							</div>
				 		</div>
				 	</a>
			 	</div>
			 	';

		 	endif;

	endif;


	}

	die;



}

add_action( 'wp_ajax_riot_load_more_profile' , 'riot_load_more_profile' );
add_action( 'wp_ajax_nopriv_riot_load_more_profile' , 'riot_load_more_profile' );

/*************************************************

	load more profile Ends

*************************************************/



/******************************************************

	shortcode to display bbpress recent discussion

******************************************************/

function riot_recent_discussion( $arg_one ){



if( !empty( $arg_one['numberposts'] ) ):

	$numberof_posts = $arg_one['numberposts'];

else:

	$numberof_posts = 5;

endif;



$args = array(

'post_type' 		=> 'reply',

'numberposts'     	=> $numberof_posts,

);

$postslist = get_posts( $args );



$recent_discussion = '';

$recent_discussion .= '<div class="discussion_wrap">';



foreach( $postslist as $reply ):

	//topic name

	$topics_id = $reply->post_parent;

	$topic_author_id = get_post_field( 'post_author', $topics_id );

	//author name

    $author = get_the_author_meta( 'user_nicename', $topic_author_id);



	$recent_discussion .= '

	<h3>'. $reply->post_content . '</h3>

	<div class="discussion_innerwrap">

	<div class="dis_author">Started by: <a href="'. bp_core_get_user_domain( $topic_author_id )  .'"><span><i class="fa fa-user" aria-hidden="true"></i> '. $author .' </span></a></div>

	<div class="dis_forum">Topic: <a href=" '. get_the_permalink( $topics_id ) .' "><span>' . substr(get_the_title( $topics_id ), 0, 15) . '</span></a></div>

	<div class="dis_comment"> <i class="fa fa-commenting-o" aria-hidden="true"></i> '. bbp_get_topic_post_count( $topics_id ) .' </div>

	</div>

	';



endforeach;



$recent_discussion .= '</div>';

return $recent_discussion;

}

add_shortcode( 'riot_forum_recent_discussion' , 'riot_recent_discussion' );

/******************************************************

	shortcode to display bbpress recent discussion ends

******************************************************/


/*************************************************

	Buddypress add meta box and shotcode to dispaly group start

*************************************************/
if( bp_is_active( 'groups' ) ) :
class bpgmq_feature_group {
    public function __construct() {
        $this->setup_hooks();
    }

    private function setup_hooks() {
        // in Group Administration screen, you add a new metabox to display a checkbox to featured the displayed group
        add_action( 'bp_groups_admin_meta_boxes', array( $this, 'admin_ui_edit_featured' ) );
        // Once the group is saved you store a groupmeta in db, the one you will search for in your group meta query
        add_action( 'bp_group_admin_edit_after',  array( $this, 'admin_ui_save_featured'), 10, 1 );
    }

    /**
     * registers a new metabox in Edit Group Administration screen, edit group panel
     */
    public function admin_ui_edit_featured() {
        add_meta_box(
            'bpgmq_feature_group_mb',
            __( 'Forum Options' ),
            array( &$this, 'admin_ui_metabox_featured'),
            get_current_screen()->id,
            'side',
            'core'
        );
    }

    /**
     * Displays the meta box
     */
    public function admin_ui_metabox_featured( $item = false ) {
        if( empty( $item ) )
            return;
        // Using groups_get_groupmeta to check if the group is featured
        $is_featured = groups_get_groupmeta( $item->id, '_bpgmq_featured_group' );
        $is_location = groups_get_groupmeta( $item->id, '_bpgmq_featured_location' );
        $is_faculty = groups_get_groupmeta( $item->id, '_bpgmq_featured_faculty' );
        ?>
            <p>
                <input type="checkbox" id="bpgmq-featured-cb" name="bpgmq-featured-cb" value="1" <?php checked( 1, $is_featured );?>> <?php _e( 'Mark this to List on the Club Directory' );?>
            </p>

            <p>
               <h4> <?php _e( 'Enter Faculty' );?> </h4>
            </p>
            <p>
                <input type="text" name="bpgmq_featured_faculty" value="<?php echo $is_faculty; ?>">
            </p>

            <p>
            	<h4><?php _e( 'Select Club Location'); ?></h4>
            </p>
            <p>
	            <select id="bpgmq-featured-location" name="bpgmq_featured_location">
				  <option value="ACT" <?php if( $is_location == 'ACT' ){ echo 'selected'; } ?>>ACT</option>
				  <option value="NSW" <?php if( $is_location == 'NSW' ){ echo 'selected'; } ?>>NSW</option>
				  <option value="NZ" <?php if( $is_location == 'NZ' ){ echo 'selected'; } ?>>NZ</option>
				  <option value="QLD" <?php if( $is_location == 'QLD' ){ echo 'selected'; } ?>>QLD</option>
				  <option value="SA" <?php if( $is_location == 'SA' ){ echo 'selected'; } ?>>SA</option>
				  <option value="VIC" <?php if( $is_location == 'VIC' ){ echo 'selected'; } ?>>VIC</option>
				  <option value="WA" <?php if( $is_location == 'WA' ){ echo 'selected'; } ?>>WA</option>
				</select>
			</p>
        <?php
        wp_nonce_field( 'bpgmq_featured_save_' . $item->id, 'bpgmq_featured_admin' );
    }

    function admin_ui_save_featured( $group_id = 0 ) {
        if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) || empty( $group_id ) )
            return false;

        check_admin_referer( 'bpgmq_featured_save_' . $group_id, 'bpgmq_featured_admin' );

        // You need to check if the group was featured so that you can eventually delete the group meta
        $was_featured = groups_get_groupmeta( $group_id, '_bpgmq_featured_group' );
        //$was_location = groups_get_groupmeta( $group_id, '_bpgmq_featured_location' );
        $to_feature = !empty( $_POST['bpgmq-featured-cb'] ) ? true : false;
        $location_filtr = $_POST['bpgmq_featured_location'];
        $faculty_filtr = $_POST['bpgmq_featured_faculty'];

        if( !empty( $to_feature ) && empty( $was_featured ) )
            groups_update_groupmeta( $group_id, '_bpgmq_featured_group', 1 );

        if( empty( $to_feature ) && !empty( $was_featured ) )
            groups_delete_groupmeta( $group_id, '_bpgmq_featured_group' );

        if( !empty( $location_filtr ) )
            groups_update_groupmeta( $group_id, '_bpgmq_featured_location', $location_filtr );

        if( !empty( $faculty_filtr ) )
            groups_update_groupmeta( $group_id, '_bpgmq_featured_faculty', $faculty_filtr );
    }

}

function bpgmq_feature_group() {
    if( bp_is_active( 'groups') )
    return new BPGMQ_Feature_Group();
}
add_action( 'bp_init', 'bpgmq_feature_group' );
endif;

function admin_ui_metabox_club_directory( $args ) {
	$riot_members = '';
	$riot_members .= '<div id="riot_memberwrap" class="">';
	$args = array(
    	'order'              => 'ASC',
    	'orderby'            => 'name'
    );
	if ( bp_has_groups($args) ) :
    $riot_members .= '<h2>Registered Clubs <span><ul id="dir_filter_club">
		 <li class="riot_memberwraps active" data-value-club="All">All</li>';
	$is_location_collection = array();
    while ( bp_groups($args) ) : bp_the_group($args);
    $is_featured = groups_get_groupmeta( bp_get_group_id(), '_bpgmq_featured_group' );
    $is_location = groups_get_groupmeta( bp_get_group_id(), '_bpgmq_featured_location' );
    if( !in_array($is_location, $is_location_collection ) && !empty($is_location) && $is_featured == 1 ){
	    	$is_location_collection[] = $is_location;
	    	$riot_members .= '<li class="riot_memberwraps" data-value-club="'. $is_location .'">'. $is_location .'</li>';
    }
    endwhile;
		$riot_members .= '</ul></span>
			<div class="loading">
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			  <div class="loading-bar"></div>
			</div>
		</h2>';
	endif;
	$args = array(
    	/*'order'              => 'ASC',*/
    	'orderby'            => 'date',
    	'per_page'			 => -1,
    	'max' 				 => 'false',
    );
	if ( bp_has_groups($args) ) :

    $riot_members .= '<div id="riot_member_rowwrap" class="row">';
    while ( bp_groups($args) ) : bp_the_group($args);

    $is_featured = groups_get_groupmeta( bp_get_group_id(), '_bpgmq_featured_group' );
    $is_faculty = groups_get_groupmeta( bp_get_group_id(), '_bpgmq_featured_faculty' );

    if ( $is_featured == 1 ){
    	$group_slug = bp_get_group_slug();
    	$group_id = BP_Groups_Group::group_exists($group_slug);
  		//echo $askjd = groups_is_user_admin( $group_id, bp_get_group_id() );
  		$groupadmins = groups_get_group_admins( $group_id );
  		$author_obj = get_userdata( $groupadmins[0]->user_id );
  		$contact_person_name = $author_obj->display_name;
  		$contact_person = xprofile_get_field_data( 'Contact Person' , $author_obj->ID );
  		//$contact_person_url = get_edit_user_link( $author_obj );
        $riot_members .= '
	        <div id="" class="col-sm-4 riot_profile">
	            <div class=" reg-club-blk">
					<div class="image-wrap">
	                	'. bp_get_group_avatar( 'type=full' ) .'
	            	</div>
	            	<div class="content-wrap">
						<h4>'. bp_get_group_name() .'</h4>
					</div>
					<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i>'. $is_faculty .'</div>
					<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>
		            <div class="clear"></div>
		        </div>
		    </div>';
 	}
    endwhile;
    $riot_members .= '</div>';
    do_action( 'bp_after_groups_loop' );
	else:
  	$riot_members .= '  <div id="message" class="info">
        <p>'. _e( 'Sorry, no groups found!', 'buddypress' ) .'</p></div>';
endif;
$riot_members .= '</div>';
return $riot_members;
}
add_shortcode('custom_club_directory_listings','admin_ui_metabox_club_directory');

/*************************************************

	Buddypress add meta box and shotcode to dispaly group ends

*************************************************/

/*************************************************

	Group filter according to location starts

*************************************************/

/*function club_directories_filter(){
	$location_club = $_POST['location_club'];
	if( !empty( $location_club ) ):
		$args = array(
	    	'order'              => 'ASC',
	    	'per_page'			 => -1,
	    	'orderby'            => 'name'
	    );
		if ( bp_has_groups($args) ) :

	    echo '<div id="riot_member_rowwrap" class="row">';
	    while ( bp_groups($args) ) : bp_the_group($args);

	    $is_featured = groups_get_groupmeta( bp_get_group_id(), '_bpgmq_featured_group' );
	    $is_faculty = groups_get_groupmeta( bp_get_group_id(), '_bpgmq_featured_faculty' );
	    if( $location_club == 'All' ):
	    	$is_location = 'All';
	    else:
	    $is_location = groups_get_groupmeta( bp_get_group_id(), '_bpgmq_featured_location' );
		endif;

	    if ( $is_featured == 1 && $is_location == $location_club ){
	    	$group_slug = bp_get_group_slug();
	    	$group_id = BP_Groups_Group::group_exists($group_slug);
	  		//echo $askjd = groups_is_user_admin( $group_id, bp_get_group_id() );
	  		$groupadmins = groups_get_group_admins( $group_id );
	  		$author_obj = get_userdata( $groupadmins[0]->user_id );
	  		$contact_person_name = $author_obj->display_name;
	  		$contact_person = xprofile_get_field_data( 'Contact Person' , $author_obj->ID );
	  		//$contact_person_url = get_edit_user_link( $author_obj );
	        echo '
		        <div id="" class="col-sm-4 riot_profile">
		            <div class=" reg-club-blk">
						<div class="image-wrap">
		                	'. bp_get_group_avatar( 'type=full' ) .'
		            	</div>
		            	<div class="content-wrap">
							<h4>'. bp_get_group_name() .'</h4>
						</div>
						<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i>'. $is_faculty .'</div>
						<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: '. $contact_person .'</div>
			            <div class="clear"></div>
			        </div>
			    </div>';
	 	}
	    endwhile;
	    echo '</div>';
	    do_action( 'bp_after_groups_loop' );
	endif;
		else:

	  	echo '  <div id="message" class="info">
	        <p>'. _e( 'Sorry, no groups found!', 'buddypress' ) .'</p>
	    </div>';
	endif;
	die;
}

add_action( 'wp_ajax_club_directories_filter' , 'club_directories_filter' );
add_action( 'wp_ajax_nopriv_club_directories_filter' , 'club_directories_filter' );*/

/*************************************************

	Group filter according to location ends

*************************************************/

function club_directories_filter_shortcode( $args ) {

	$club_directory = array(
            'post_type' => 'club_directory',
            'posts_per_page' => -1,
            'orderby' => 'name',
            'order'   => 'ASC'
        );
		$filter = '';

        $query = new WP_Query( $club_directory );

        $tax = 'club_directory_categories';
        // $terms = get_terms( $tax );
		$terms	 = get_terms( array(
			'taxonomy' => $tax,
			'hide_empty' => false,
			) );
        $terms_id = get_terms( $tax );

        $count = count( $terms );
       
        $filter .= '<div id="riot_memberwrap" class="container">

            <h2>Registered Clubs <span><ul id="dir_filter_club">
		 <li class="riot_memberwraps active" data-value="All">All</li>';
            
            foreach ( $terms as $term ) {
                $term_link = get_term_link( $term, $tax );
                //echo '<a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a> ';
                $filter .= '<li id="'.$term->term_id.'" class="riot_memberwraps" data-value="'. $term->slug .'">'. $term->name .'</li>';
            } 
            $filter .= '</ul>
        </span>

				<div class="loading">
				  <div class="loading-bar"></div>
				  <div class="loading-bar"></div>
				  <div class="loading-bar"></div>
				  <div class="loading-bar"></div>
				</div>

			</h2>';
			 if ( $query->have_posts() ){ 
			$filter .= '<div id="riot_member_rowwrap" class="row">';
				  while ( $query->have_posts() ) { $query->the_post(); 
				$filter .= '<div  class="col-sm-4 riot_profile">
				 		<a>
					 		<div class=" reg-club-blk">
								<div class="image-wrap">'. get_the_post_thumbnail().' </div>
								<div class="content-wrap">
									<h4>'. get_the_title() .'</h4>
									<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i> ' .get_post_meta( get_the_ID(), 'faculty', true ) .'</div>
									<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: ' .get_post_meta( get_the_ID(), 'contactperson', true ) .'</div>
								</div>

					 		</div>
					 	</a>
				 	</div>';
				 	 } 
			$filter .= '</div>';
		 }

           $filter .= '</div>';
       
       return $filter;
}
add_shortcode( 'riot_clubs_directories_filter', 'club_directories_filter_shortcode' );

function club_directories_filter( $args ) {
	$location_club = $_POST['location_club'];



	if( !empty( $location_club ) ){
		if( $location_club == 'All' )
		{
	    	$club_directory = array(
	            'post_type' => 'club_directory',
	            'posts_per_page' => -1,
	            'orderby' => 'name',
	            'order'   => 'ASC'
	        );
		}
	    else{
	    	$club_directory = array(
	            'post_type' => 'club_directory',
	            'posts_per_page' => -1,
	            'orderby' => 'name',
            	'order'   => 'ASC',
	            'tax_query' => array(
				    array(
				      'taxonomy' => 'club_directory_categories',
				      'field' => 'slug',
				      'terms' => $location_club, // Where term_id of Term 1 is "1".
				      'include_children' => false
				    )
				  )
	        );
	    }
		

	        $query = new WP_Query( $club_directory );

	        $tax = 'club_directory_categories';
	        $terms = get_terms( $tax );
	        // $count = count( $terms );
	       ?><?php if ( $query->have_posts() ){ ?>
				
					<?php  while ( $query->have_posts() ) { $query->the_post(); ?>
					<div  class="col-sm-4 riot_profile">
					 		<a>
						 		<div class=" reg-club-blk">
									<div class="image-wrap"><?php the_post_thumbnail();?></div>

									<div class="content-wrap">
										<h4><?php the_title();?></h4>
										<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i> <?php echo get_post_meta( get_the_ID(), 'faculty', true ) ; ?></div>
										<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact: <?php echo get_post_meta( get_the_ID(), 'contactperson', true ) ; ?></div>
									</div>

						 		</div>
						 	</a>
					 	</div>
					 	<?php } ?>
				
			<?php }
			else{

		  	echo '  <div id="message" class="info">
		        <p>Sorry, no groups found!</p>
		    </div>';
		}


   }
   die;
}
add_action( 'wp_ajax_club_directories_filter' , 'club_directories_filter' );
add_action( 'wp_ajax_nopriv_club_directories_filter' , 'club_directories_filter' );

/* Start
shortcode for */

function display_post_per_id( $atts ){


	$ids =  $atts['show'];
	$arr_ids=explode(",",$ids);

    $args=array(
    	        'post_type' => 'club_directory',
    	        'post__in'  =>  $arr_ids
    );
    $my_query = null;
    $my_query = new WP_Query($args);
    $message .= '<div id="riot_memberwrap" class="">
    				<div id="riot_member_rowwrap" class="">';
    if( $my_query->have_posts() ) {
        while ($my_query->have_posts()) { $my_query->the_post(); 
            $message .= '<div id="" class="col-sm-4 riot_profile">
	            <div class=" reg-club-blk">
					<div class="image-wrap">'. get_the_post_thumbnail().'</div>
	            	<div class="content-wrap">
						<h4>'. get_the_title() .'</h4>
					</div>
					<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i>'.get_post_meta( get_the_ID(), 'faculty', true ) .'</div>
					<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact:'.get_post_meta( get_the_ID(), 'contactperson', true ) .'</div>
		            <div class="clear"></div>
		        </div>
		    </div>';
         }
     }
     $message .= '</div>
    				</div>';
     wp_reset_query();  
     return $message;
}
add_shortcode( 'display_post_riot_club', 'display_post_per_id' );
/*End shortcode for*/
 
/* function club_directories_filter(){
	
	if( !empty( $location_club ) ){
		$club_directory = array(
            'post_type' => 'club_directory',
            'posts_per_page' => -1,
        );

        $query = new WP_Query( $club_directory );

        $tax = 'club_directory_categories';
        $terms = get_terms( $tax );
        $count = count( $terms );
		if ( $query->have_posts() ){

	    echo '<div id="riot_member_rowwrap" class="row">';
	    while ( $query->have_posts() ) { $query->the_post(); 
	    	$faculty = get_post_meta( get_the_ID(), 'faculty', true );
	    	$contactperson = get_post_meta( get_the_ID(), 'contactperson', true );
	        echo '
	        		<div  class="col-sm-4 riot_profile">
				 		<a>
					 		<div class=" reg-club-blk">
								<div class="image-wrap">'. the_post_thumbnail() .'</div>

								<div class="content-wrap">
									<h4><?php the_title();?></h4>
									<div class="contact_info faculty-extend"><i class="fa fa-user" aria-hidden="true"></i>' . $faculty . '</div>
									<div class="contact_info"><i class="fa fa-user" aria-hidden="true"></i> Contact:'. $contactperson .'</div>
								</div>

					 		</div>
					 	</a>
				 	</div>' ;
	 	
	   }
	    echo '</div>';
	   
	}
		else{

	  	echo '  <div id="message" class="info">
	        <p>'. _e( 'Sorry, no groups found!', 'buddypress' ) .'</p>
	    </div>';
	}
	die;
}


add_action( 'wp_ajax_club_directories_filter' , 'club_directories_filter' );
add_action( 'wp_ajax_nopriv_club_directories_filter' , 'club_directories_filter' );*/

