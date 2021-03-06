<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Ethic
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function ethic_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'ethic_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function ethic_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
         if(get_theme_mod('ethic_color_scheme')) {
        $slug = strtolower(get_theme_mod('ethic_color_scheme'));
        $classes[] = 'ethic-' . $slug;
        
        }

	return $classes;
        
}
add_filter( 'body_class', 'ethic_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function ethic_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'ethic_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function ethic_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'ethic' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ethic_wp_title', 10, 2 );

/* Display icon for blog post using 
 * Post Format - get_post_format() function 
 * 
 * @since Ethic 1.0
 */

function ethic_post_format_icon() { 
    if(!is_single()) {
    ?>
     <?php $format = get_post_format();
      ?>
    <span class="post_format">
     <?php if ($format == 'video')  { ?>
     <i class="fa fa-film"></i>
     <?php } elseif ($format == 'gallery')  { ?>
     <i class="fa fa-picture-o"></i>
     <?php } elseif ($format == 'image')  { ?>
     <i class="fa fa-user"></i>
     <?php } elseif ($format == 'quote')  { ?>
     <i class="fa fa-quote-left"></i>
     <?php } elseif ($format == 'link')  { ?>
     <i class="fa fa-link"></i>
     <?php } else { ?>
     <i class="fa fa-file-text"></i>

     <?php } ?>
     </span>
<?php }
}

add_filter( 'woothemes_our_team_member_fields', 'ethic_fields' );
function ethic_fields( $fields ) {
    $fields['facebook'] = array(
        'name'            => __( 'Facebook', 'our-team-by-woothemes' ),
        'description'     => __( 'Facebook Username', 'our-team-by-woothemes' ),
        'type'            => 'text',
        'default'         => '',
        'section'         => 'info'
    );
    return $fields;
}
