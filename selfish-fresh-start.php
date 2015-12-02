<?php
/*
Plugin Name:    Selfish Fresh Start
Plugin URI:     http://wordpress.org/plugins/selfish-fresh-start
Description:    This WordPress plugin removes some, in my opinion, unused crappy dashboard, post & page widgets, fixes formatted curly quote problems, checks for and nukes Hello Dolly, removes junk header tags including the generator tag for extra security, removes update notifications for non-admins, removes old user profile fields like aim, prevents self pinging, removes smilies and trackbacks, and a few other settings that nobody needs either. This is built to be very generalized so it'll work with every site as a good clean-up fresh start and help keep clients out of the edit menus.
Version:        1.0-beta
Author:         Chuck Reynolds
Author URI:     http://rynoweb.com/wordpress-plugins/
License:        GPLv2 or later
License URI:    http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2011-2015 Chuck Reynolds (email : chuck@rynoweb.com)

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

Class RynoNuke {

	/**
	 * This is the constructor for RynoNuke Class
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'atInit' ) );
		add_action( 'after_setup_theme', array( $this, 'afterThemeSetup' ) );

	}

	/**
	 * Functions called at the init action
	 *
	 * @return void
	 */
	public function atInit() {

		$this->nukeFileEdit();
		$this->nukeTrackbacksSmilies();

	}

	/**
	 * Functions called after the after_setup_theme action
	 *
	 * @return void
	 */
	public function afterThemeSetup() {

		remove_action( 'wp_head',            'rsd_link' );
		remove_action( 'wp_head',            'wlwmanifest_link' );
		remove_action( 'wp_head',            'index_rel_link' );
		remove_action( 'wp_head',            'start_post_rel_link' );
		remove_action( 'wp_head',            'adjacent_posts_rel_link_wp_head' );
		remove_action( 'wp_head',            'wp_generator' );
		remove_action( 'wp_head',            'wp_shortlink_wp_head' );
		remove_action( 'welcome_panel',      'wp_welcome_panel' );

		add_action( 'wp_dashboard_setup',    array( $this, 'nuke_dashboard_metaboxes' ) );
		add_action( 'do_meta_boxes',         array( $this, 'nuke_plugin_metaboxes') );
		add_action( 'admin_menu',            array( $this, 'nuke_post_metaboxes' ) );
		add_action( 'admin_menu',            array( $this, 'nuke_page_metaboxes' ) );
		add_action( 'admin_head',            array( $this, 'nuke_update_notification_non_admins' ), 1 );
		add_action( 'pre_ping',              array( $this, 'nuke_self_pings' ) );
		add_action( 'admin_init',            array( $this, 'nuke_hello_dolly' ) );
		add_filter( 'the_content_more_link', array( $this, 'nuke_more_jump_link_anchor' ) );
		add_filter( 'user_contactmethods',   array( $this, 'nuke_contact_methods' ), 10, 1 );
		add_filter( 'content_save_pre',      array( $this, 'nuke_curly_other_chars' ) );
		add_filter( 'title_save_pre',        array( $this, 'nuke_curly_other_chars' ) );

	}

	/**
	 * Removes theme and plugin editor links if not defined already
	 *
	 * @return void
	 */
	public function nukeFileEdit() {

		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', 'true' );
		}

	}

	/**
	 * Sets db options table flags
	 *
	 * @return void
	 */
	public function nukeTrackbacksSmilies() {

		$options = array(
			'default_ping_status'   => 'closed',
			'default_pingback_flag'	=> 0,
			'use_smilies'           => 0
		);

		foreach( $options as $key => $value ) {

			$current = get_option( $key );

			if ( $current != $value ) {
				update_option( $key, $value );
			}

		}

	}

	/**
	 * Removes some dashboard widgets
	 *
	 * @return void
	 */
	public function nuke_dashboard_metaboxes() {

		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); // incoming links box
		remove_meta_box( 'dashboard_plugins',        'dashboard', 'normal' ); // new plugins box
		#remove_meta_box('dashboard_right_now',       'dashboard', 'normal');  // Right Now
    	#remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');  // Recent Comments
		remove_meta_box( 'dashboard_quick_press',    'dashboard', 'side' );   // quick draft box
		remove_meta_box( 'dashboard_recent_drafts',  'dashboard', 'side' );   // recent drafts box
		remove_meta_box( 'dashboard_primary',        'dashboard', 'side' );   // wordpress news blog box
		remove_meta_box( 'dashboard_secondary',      'dashboard', 'side' );   // other wordpress news box

	}

	/**
	 * Removes some plugin dashboard widgets.
	 * yup i'm goin there. sorry not sorry.
	 *
	 * @return void
	 */
	public function nuke_plugin_metaboxes() {

		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); // yoast seo overview
		remove_meta_box( 'aw_dashboard',             'dashboard', 'normal' ); // wp socializer box
		remove_meta_box( 'w3tc_latest',              'dashboard', 'normal' ); // w3 total cache news box
		remove_meta_box( 'rg_forms_dashboard',       'dashboard', 'normal' ); // gravity forms
		remove_meta_box( 'bbp-dashboard-right-now',  'dashboard', 'normal' ); // bbpress right now in forums
		remove_meta_box( 'jetpack_summary_widget',   'dashboard', 'normal' ); // jetpack

	}

	/**
	 * Removes some meta boxes from default posts screen
	 *
	 * @return void
	 */
	public function nuke_post_metaboxes() {

		remove_meta_box( 'trackbacksdiv',      'post', 'normal' ); // trackbacks metabox
		# remove_meta_box( 'postcustom',       'post', 'normal' ); // custom fields metabox
		# remove_meta_box( 'postexcerpt',      'post', 'normal' ); // excerpt metabox
		# remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); // comments metabox
		# remove_meta_box( 'slugdiv',          'post', 'normal' ); // slug metabox (breaks edit permalink update)
		# remove_meta_box( 'authordiv',        'post', 'normal' ); // author metabox
		# remove_meta_box( 'revisionsdiv',     'post', 'normal' ); // revisions metabox
		# remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' ); // tags metabox
		# remove_meta_box( 'categorydiv',      'post', 'normal' ); // comments metabox

	}

	/**
	 * Removes some meta boxes from default pages screen
	 *
	 * @return void
	 */
	public function nuke_page_metaboxes() {

		remove_meta_box( 'commentstatusdiv', 'page', 'normal' ); // discussion metabox
		remove_meta_box( 'commentsdiv',      'page', 'normal' ); // comments metabox
		# remove_meta_box( 'postcustom',     'page', 'normal' ); // custom fields metabox
		# remove_meta_box( 'slugdiv',        'page', 'normal' ); // slug metabox (breaks edit permalink update)
		# remove_meta_box( 'authordiv',      'page', 'normal' ); // author metabox
		# remove_meta_box( 'revisionsdiv',   'page', 'normal' ); // revisions metabox
		# remove_meta_box( 'postimagediv',   'page', 'side' );   // featured image metabox

	}

	/**
	 * Removes update notifications for everybody except admin users
	 *
	 * @return void
	 */
	public function nuke_update_notification_non_admins() {

		if ( ! current_user_can( 'update_core' ) ) {

			remove_action( 'admin_notices', 'update_nag', 3 );

		}
	}

	/**
	 * Disables potential to self-trackback
	 *
	 * @return void
	 */
	public function nuke_self_pings(&$links) {

		foreach ( $links as $l => $link ) {

			if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
				unset( $links[$l] );
			}


		}
	}

	/**
	 * Removes hellodolly plugin if it exists. sorry @photomatt
	 *
	 * @return void
	 */
	public function nuke_hello_dolly() {

		if ( file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) {

			delete_plugins( array( 'hello.php' ) );

		}

	}

	/**
	 * Modifies #more link to not use hashtag anchor
	 *
	 * @return void
	 */
	public function nuke_more_jump_link_anchor( $link ) {

		$offset = strpos( $link, '#more-' );

		if ( $offset ) {
			$end = strpos( $link, '"', $offset );
		}

		if ( $end ) {
			$link = substr_replace( $link, '', $offset, $end-$offset );
		}

		return $link;

	}

	/**
	 * Removes obsolete profile fields
	 *
	 * @return void
	 */
	public function nuke_contact_methods( $contactMethods ) {

		unset( $contactMethods['yim'] );
		unset( $contactMethods['aim'] );
		unset( $contactMethods['jabber'] );

		return $contactMethods;

	}

	/**
	 * Fixes curly quotes and badly formatted characters. One of my bigger pet peeves is curly quotes from word pastes
	 *
	 * @return void
	 */
	public function nuke_curly_other_chars( $fixChars ) {

		$fixChars = str_replace(
			array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
			array("'", "'", '"', '"', '-', '&mdash;', '&hellip;'), $fixChars);

		$fixChars = str_replace(
			array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
			array("'", "'", '"', '"', '-', '&mdash;', '&hellip;'), $fixChars);

		$fixChars = str_replace(
			array('â„¢', 'Â©', 'Â®'),
			array('&trade;', '&copy;', '&reg;'), $fixChars);

		return $fixChars;

	}

}

$rynonuke = new RynoNuke;
