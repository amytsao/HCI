<?php
//* Code goes here
/* Change home to name of site for HCI */
add_filter('avia_breadcrumbs_args', 'avia_change_home_breadcrumb', 10, 1);
function avia_change_home_breadcrumb($args){
	$args['show_home'] = get_option('blogname');
	return $args;
}

/* Add base HCI site as the breadcrumb head for subsites */
add_filter('avia_breadcrumbs_trail', 'avia_change_breadcrumb', 20, 1);
function avia_change_breadcrumb($trail) {
	$site = get_option('blogname');
	$homesitedetails = get_blog_details( array( 'blog_id' => 1 ) );
	if ( $site != $homesitedetails->blogname ) {
		$home = '<a href="' . $homesitedetails->siteurl . '" title="' . 'Healthy Campus Initiative' . '" rel="home">' . $homesitedetails->blogname . '</a>';
		// Place reversed trail in variable first to avoid PHP warning about references.
		$reversed_trail = array_reverse($trail);
		$first = array_pop($reversed_trail);
		$last = array_pop($trail);
		if ($first != null) {
			$trail = array(0 => $home, 1 => $first, 'trail_end' => $last);
		}
	}
	return $trail;
}

/* add css from parent styling */
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/* change author name to guest name */
add_filter( 'the_author', 'guest_author_name' );
add_filter( 'get_the_author_display_name', 'guest_author_name' );
 
function guest_author_name( $name ) {
global $post;
 
$author = get_post_meta( $post->ID, 'guest-author', true );
 
if ( $author )
$name = $author;
 
return $name;
}
