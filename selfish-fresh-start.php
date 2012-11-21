<?php
/*
Plugin Name: Selfish Fresh Start
Plugin URI: http://wordpress.org/extend/plugins/selfish-fresh-start
Description: This WordPress plugin removes some, in my opinion, unused crappy dashboard, post & page widgets, checks for and nukes Hello Dolly, removes junk header tags, removes update notifications for non-admins, removes old user profile fields like aim, prevents self pining, removes smilies and trackbacks, and a few other settings that nobody needs either. This is built to be very generalized so it'll work with every site as a good clean-up fresh start.
Version: 0.5BETA
Author: Chuck Reynolds
Author URI: http://rynoweb.com/wordpress-plugins/
License: GPL2
*/
/*
	Copyright 2011 Selfish Fresh Start plugin (email: chuck@rynoweb.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/
/* CHANGES FROM .4
* checking if DISALLOW_FILE_EDIT is defined or not to avoid issues
*/

add_action('after_setup_theme','rynonuke_setup');
function rynonuke_setup() {
	remove_action('wp_head','rsd_link');
	remove_action('wp_head','wlwmanifest_link');
	remove_action('wp_head','index_rel_link');
	remove_action('wp_head','start_post_rel_link');
	remove_action('wp_head','adjacent_posts_rel_link_wp_head');
	remove_action('wp_head','wp_generator');
	remove_action('wp_head','wp_shortlink_wp_head');
	
	add_action('admin_menu','rynonuke_dashboard_boxes');
	add_action('admin_menu','rynonuke_post_metaboxes');
	add_action('admin_menu','rynonuke_page_metaboxes');
	add_action('admin_notices','rynonuke_update_notification_nonadmins',1);
	add_action('pre_ping','rynonuke_self_pings');
	add_action('admin_init','rynonuke_dolly');
	
	add_filter('the_content_more_link','rynonuke_more_jump_link');
	add_filter('user_contactmethods','rynonuke_contactmethods',10,1);	
}

// remove dashboard widgets
function rynonuke_dashboard_boxes() {
	//remove_meta_box('dashboard_right_now','dashboard','core'); // right now overview box
	//remove_meta_box('dashboard_incoming_links','dashboard','core'); // incoming links box
	remove_meta_box('dashboard_quick_press','dashboard','core'); // quick press box
	remove_meta_box('dashboard_plugins','dashboard','core'); // new plugins box
	remove_meta_box('dashboard_recent_drafts','dashboard','core'); // recent drafts box
	//remove_meta_box('dashboard_recent_comments','dashboard','core'); // recent comments box
	remove_meta_box('dashboard_primary','dashboard','core'); // wordpress development blog box
	remove_meta_box('dashboard_secondary','dashboard','core'); // other wordpress news box
	
	// start removing plugin dashboard boxes. yup i'm goin there
	remove_meta_box('yoast_db_widget','dashboard','core'); // yoasts dash news
	remove_meta_box('aw_dashboard','dashboard','core'); // wp socializer box
	remove_meta_box('w3tc_latest','dashboard','core'); //w3 total cache news box
	 
}
// remove meta boxes from default posts screen
function rynonuke_post_metaboxes() {
	//remove_meta_box('postcustom','post','normal'); // custom fields metabox
	//remove_meta_box('postexcerpt','post','normal'); // excerpt metabox
	remove_meta_box('commentstatusdiv','post','normal'); // comments metabox
	remove_meta_box('trackbacksdiv','post','normal'); // trackbacks metabox
	//remove_meta_box('slugdiv','post','normal'); // slug metabox (breaks edit permalink update)
	remove_meta_box('authordiv','post','normal'); // author metabox
	//remove_meta_box('revisionsdiv','post','normal'); // revisions metabox
	remove_meta_box('tagsdiv-post_tag','post','normal'); // tags metabox
	//remove_meta_box('categorydiv','post','normal'); // comments metabox
}
// remove meta boxes from default pages screen
function rynonuke_page_metaboxes() {
	//remove_meta_box('postcustom','page','normal'); // custom fields metabox
	remove_meta_box('commentstatusdiv','page','normal'); // discussion metabox
	remove_meta_box('commentsdiv','page','normal'); // comments metabox
	//remove_meta_box('slugdiv','page','normal'); // slug metabox (breaks edit permalink update)
	remove_meta_box('authordiv','page','normal'); // author metabox
	//remove_meta_box('revisionsdiv','page','normal'); // revisions metabox
	//remove_meta_box('postimagediv','page','side'); // featured image metabox
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

// adios dolly
function rynonuke_dolly() {
    if (file_exists(WP_PLUGIN_DIR.'/hello.php')) {
        delete_plugins(array('hello.php'));
    }
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
	$contactmethods['rynonuke_googleplus']='Google +';
	$contactmethods['rynonuke_linkedin']='LinkedIn';
	return $contactmethods;
}

// if not defined already, remove theme editor
if(!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', 'true');
}

// options table flags
update_option('default_ping_status','closed');
update_option('default_pingback_flag','0');
update_option('use_smilies','0');
//update_option('uploads_use_yearmonth_folders','0');
?>