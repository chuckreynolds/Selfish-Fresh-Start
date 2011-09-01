<?php
/**
 * Plugin Name: Selfish Fresh Start
 * Plugin URI: http://wordpress.org/extend/plugins/-----
 * Description: This is a custom plugin that I like to use for all installs, one place to keep the best starter functions.
 * Author: Chuck Reynolds
 * Author URI: http://rynoweb.com/wordpress-plugins/
 * Version: 0.1
 */

add_action('after_setup_theme','rynonuke_setup');
function rynonuke_setup() {
	remove_action('wp_head','rsd_link');
	remove_action('wp_head','wlwmanifest_link');
	remove_action('wp_head','start_post_rel_link');
	remove_action('wp_head','index_rel_link');
	remove_action('wp_head','adjacent_posts_rel_link');
	
	add_action('admin_menu','rynonuke_dashboard_boxes');
	add_action('admin_menu','rynonuke_post_metaboxes');
	add_action('admin_menu','rynonuke_page_metaboxes');
	add_action('admin_notices','rynonuke_update_notification_nonadmins',1);
	add_action('pre_ping','rynonuke_self_pings');
	
	add_filter('the_content_more_link','rynonuke_more_jump_link');
	add_filter('user_contactmethods','rynonuke_contactmethods',10,1);	
}

// remove dashboard widgets
function rynonuke_dashboard_boxes() {
	//remove_meta_box('dashboard_right_now','dashboard','core'); // Right Now Overview Box
	//remove_meta_box('dashboard_incoming_links','dashboard','core'); // Incoming Links Box
	remove_meta_box('dashboard_quick_press','dashboard','core'); // Quick Press Box
	remove_meta_box('dashboard_plugins','dashboard','core'); // Plugins Box
	remove_meta_box('dashboard_recent_drafts','dashboard','core'); // Recent Drafts Box
	//remove_meta_box('dashboard_recent_comments','dashboard','core'); // Recent Comments
	remove_meta_box('dashboard_primary','dashboard','core'); // WordPress Development Blog
	remove_meta_box('dashboard_secondary','dashboard','core'); // Other WordPress News
}
// remove meta boxes from default posts screen
function rynonuke_post_metaboxes() {
	//remove_meta_box('postcustom','post','normal'); // Custom Fields Metabox
	//remove_meta_box('postexcerpt','post','normal'); // Excerpt Metabox
	remove_meta_box('commentstatusdiv','post','normal'); // Comments Metabox
	remove_meta_box('trackbacksdiv','post','normal'); // Trackbacks Metabox
	remove_meta_box('slugdiv','post','normal'); // Slug Metabox
	remove_meta_box('authordiv','post','normal'); // Author Metabox
	//remove_meta_box('revisionsdiv','post','normal'); // Revisions metabox
	remove_meta_box('tagsdiv-post_tag','post','normal'); // Tags metabox
	//remove_meta_box('categorydiv','post','normal'); // Comments metabox
}
// remove meta boxes from default pages screen
function rynonuke_page_metaboxes() {
	//remove_meta_box('postcustom','page','normal'); // Custom Fields Metabox
	remove_meta_box('commentstatusdiv','page','normal'); // Discussion Metabox
	remove_meta_box('commentsdiv','page','normal'); // Comments Metabox
	remove_meta_box('slugdiv','page','normal'); // Slug Metabox
	remove_meta_box('authordiv','page','normal'); // Author Metabox
	//remove_meta_box('revisionsdiv','page','normal'); // Revisions Metabox
	//remove_meta_box('postimagediv','page','side'); // Featured image metabox
}

// remove update notifications for everybody except admin users
function rynonuke_update_notification_nonadmins() {
	if (!current_user_can('administrator')) 
		remove_action('admin_notices','update_nag',3);
}

// disable self-trackbacking
function rynonuke_self_pings( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}

// mod more link to not use hashtag anchor
function rynonuke_more_jump_link($link) { 
	$offset = strpos($link,'#more-');
	if ($offset) {
		$end = strpos($link,'"',$offset);
	}
	if ($end) {
		$link = substr_replace($link,'', $offset, $end-$offset);
	}
	return $link;
}

// rem/add user profile fields
function rynonuke_contactmethods($contactmethods) {
	unset($contactmethods['yim']);
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	$contactmethods['rynonuke_twitter']='Twitter';
	$contactmethods['rynonuke_facebook']='Facebook';
	return $contactmethods;
}

// remove theme editor
define('DISALLOW_FILE_EDIT',true);

// options table flags
update_option('default_ping_status','closed');
update_option('default_pingback_flag','0');
update_option('use_smilies','0');
update_option('uploads_use_yearmonth_folders','0');

?>