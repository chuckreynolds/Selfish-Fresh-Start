<?php
/**
 * @link         https://chuckreynolds.com
 * @since        1.1.0
 * @package      Selfish_Fresh_Start
 *
 * Plugin Name:  Selfish Fresh Start
 * Plugin URI:   https://wordpress.org/plugins/selfish-fresh-start/
 * Description:  Removes clutter and commonly unneeded things in WordPress. Full details in the plugin description.
 * Version:      1.3.0-beta1
 * Requires at least: 4.0
 * Requires PHP: 7.4
 * Author:       Chuck Reynolds
 * Author URI:   https://chuckreynolds.com
 * License:      GPL-2.0+
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  selfish-fresh-start
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Selfish_Fresh_Start' ) ) :

/**
 * The core plugin class. Does all the things.
 *
 * @since       1.0.0
 * @package     Selfish_Fresh_Start
 * @author      Chuck Reynolds <chuck@rynoweb.com>
 */
class Selfish_Fresh_Start {

	/**
	 * Set the file-edit constant immediately, then register hooks.
	 * Admin-only hooks stay off the frontend.
	 *
	 * @return void
	 */
	public function __construct() {

		$this->nuke_file_edit();

		add_action( 'init', array( $this, 'nuke_wp_head' ) );
		add_action( 'wp_default_scripts', array( $this, 'nuke_jquery_migrate' ) );
		add_action( 'pre_ping', array( $this, 'nuke_self_pings' ) );
		add_filter( 'the_content_more_link', array( $this, 'nuke_more_jump_link_anchor' ) );
		add_filter( 'content_save_pre', array( $this, 'nuke_curly_other_chars' ) );
		add_filter( 'title_save_pre', array( $this, 'nuke_curly_other_chars' ) );

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'nuke_admin_init' ) );
			add_action( 'wp_dashboard_setup', array( $this, 'nuke_dashboard_metaboxes' ), 999 );
			add_action( 'do_meta_boxes', array( $this, 'nuke_plugin_metaboxes' ), 99, 1 );
			add_action( 'add_meta_boxes_post', array( $this, 'nuke_post_metaboxes' ) );
			add_action( 'add_meta_boxes_page', array( $this, 'nuke_page_metaboxes' ) );
		}

	}

	/**
	 * Admin-only work that should not run on the public site.
	 *
	 * @return void
	 */
	public function nuke_admin_init() {

		$this->nuke_trackbacks_smilies();
		$this->nuke_hello_dolly();
		$this->nuke_welcome_panel();
		$this->nuke_update_notification_non_admins();

	}

	/**
	 * Removes theme and plugin editor links if not defined already.
	 * Defined at plugin load so it is in place before admin menus and cap checks.
	 *
	 * @return void
	 */
	public function nuke_file_edit() {

		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}

	}

	/**
	 * Force ping/trackback flags. Core options, hardcoded values, admins only.
	 *
	 * @return void
	 */
	public function nuke_trackbacks_smilies() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options = array(
			'default_ping_status'   => 'closed',
			'default_pingback_flag' => 0,
		);

		foreach ( $options as $key => $value ) {

			if ( get_option( $key ) != $value ) {
				update_option( $key, $value );
			}

		}

	}

	/**
	 * Strip leftover cruft from wp_head, plus the shortlink HTTP header.
	 *
	 * @return void
	 */
	public function nuke_wp_head() {

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

	}

	/**
	 * Drop jquery-migrate on the frontend. Core still lists it as a jquery dep.
	 * Admin keeps it. Dequeue is not enough; strip the dependency.
	 *
	 * @param WP_Scripts $scripts WordPress scripts registry.
	 * @return void
	 */
	public function nuke_jquery_migrate( $scripts ) {

		if ( is_admin() ) {
			return;
		}

		if ( isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];

			if ( ! empty( $script->deps ) ) {
				$script->deps = array_values( array_diff( $script->deps, array( 'jquery-migrate' ) ) );
			}
		}

	}

	/**
	 * Hide the dashboard welcome panel.
	 *
	 * @return void
	 */
	public function nuke_welcome_panel() {

		remove_action( 'welcome_panel', 'wp_welcome_panel' );

	}

	/**
	 * Removes some dashboard widgets.
	 *
	 * @return void
	 */
	public function nuke_dashboard_metaboxes() {

		#remove_meta_box( 'dashboard_right_now',      'dashboard', 'normal' );  // At a Glance
		#remove_meta_box( 'network_dashboard_right_now', 'dashboard', 'normal' ); // Network Right Now
		#remove_meta_box( 'dashboard_activity',       'dashboard', 'normal' );  // Activity
		remove_meta_box( 'dashboard_quick_press',    'dashboard', 'side' );   // Quick Draft / Your Recent Drafts
		remove_meta_box( 'dashboard_primary',        'dashboard', 'side' );   // WordPress Events and News

		// from older than WP ~4.0 versions
		#remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); // incoming links box (deprecated in 3.8)
		#remove_meta_box( 'dashboard_plugins',        'dashboard', 'normal' ); // new plugins box (deprecated in 3.8)
		#remove_meta_box( 'dashboard_recent_comments','dashboard', 'normal' );  // recent comments sub (now part of activity)
		#remove_meta_box( 'dashboard_recent_drafts',  'dashboard', 'side' );   // recent drafts (now part of quick_press)
		#remove_meta_box( 'dashboard_secondary',      'dashboard', 'side' );   // other wordpress news (deprecated in 3.8)

	}

	/**
	 * Removes some plugin dashboard widgets.
	 * Yup I'm goin there. Sorry not sorry.
	 *
	 * @param string|WP_Screen $screen Current screen id or screen object from do_meta_boxes.
	 * @return void
	 */
	public function nuke_plugin_metaboxes( $screen = '' ) {

		$screen_id = $screen;

		if ( is_object( $screen ) && isset( $screen->id ) ) {
			$screen_id = $screen->id;
		}

		if ( 'dashboard' !== $screen_id ) {
			return;
		}

		$boxes = array(
			'wpseo-dashboard-overview', // Yoast SEO Posts Overview
			'tribe_dashboard_widget',   // The Events Calendar news
			'aioseo-rss-feed',          // All in One SEO news
		);

		foreach ( $boxes as $id ) {
			foreach ( array( 'normal', 'side' ) as $context ) {
				remove_meta_box( $id, 'dashboard', $context );
			}
		}

	}

	/**
	 * Removes some meta boxes from default posts screen.
	 * Hooked after core registers the boxes.
	 *
	 * @return void
	 */
	public function nuke_post_metaboxes() {

		remove_meta_box( 'trackbacksdiv',      'post', 'normal' ); // trackbacks metabox
		#remove_meta_box( 'postcustom',       'post', 'normal' ); // custom fields metabox
		#remove_meta_box( 'postexcerpt',      'post', 'normal' ); // excerpt metabox
		#remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); // comments metabox
		#remove_meta_box( 'slugdiv',          'post', 'normal' ); // slug metabox (breaks edit permalink update)
		#remove_meta_box( 'authordiv',        'post', 'normal' ); // author metabox
		#remove_meta_box( 'revisionsdiv',     'post', 'normal' ); // revisions metabox
		#remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' ); // tags metabox
		#remove_meta_box( 'categorydiv',      'post', 'normal' ); // comments metabox

	}

	/**
	 * Removes some meta boxes from default pages screen.
	 * Hooked after core registers the boxes.
	 *
	 * @return void
	 */
	public function nuke_page_metaboxes() {

		remove_meta_box( 'commentstatusdiv', 'page', 'normal' ); // discussion metabox
		remove_meta_box( 'commentsdiv',      'page', 'normal' ); // comments metabox
		#remove_meta_box( 'postcustom',     'page', 'normal' ); // custom fields metabox
		#remove_meta_box( 'slugdiv',        'page', 'normal' ); // slug metabox (breaks edit permalink update)
		#remove_meta_box( 'authordiv',      'page', 'normal' ); // author metabox
		#remove_meta_box( 'revisionsdiv',   'page', 'normal' ); // revisions metabox
		#remove_meta_box( 'postimagediv',   'page', 'side' );   // featured image metabox

	}

	/**
	 * Removes update notifications for everybody except users who can update core.
	 *
	 * @return void
	 */
	public function nuke_update_notification_non_admins() {

		if ( ! current_user_can( 'update_core' ) ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
		}

	}

	/**
	 * Drop pings that target this site. Compare hosts, not URL prefixes.
	 *
	 * @param string[] $links URLs WordPress is about to ping, passed by reference.
	 * @return void
	 */
	public function nuke_self_pings( &$links ) {

		if ( ! is_array( $links ) || empty( $links ) ) {
			return;
		}

		$home_host = wp_parse_url( home_url(), PHP_URL_HOST );

		if ( ! is_string( $home_host ) || '' === $home_host ) {
			return;
		}

		$home_host = strtolower( $home_host );

		foreach ( $links as $index => $link ) {

			if ( ! is_string( $link ) ) {
				continue;
			}

			$link_host = wp_parse_url( $link, PHP_URL_HOST );

			if ( is_string( $link_host ) && strtolower( $link_host ) === $home_host ) {
				unset( $links[ $index ] );
			}

		}

	}

	/**
	 * Removes Hello Dolly if it exists. sorry @photomatt
	 *
	 * @return void
	 */
	public function nuke_hello_dolly() {

		if ( ! current_user_can( 'delete_plugins' ) ) {
			return;
		}

		$plugins = array();

		if ( file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) {
			$plugins[] = 'hello.php';
		}

		if ( file_exists( WP_PLUGIN_DIR . '/hello-dolly/hello.php' ) ) {
			$plugins[] = 'hello-dolly/hello.php';
		}

		if ( ! $plugins ) {
			return;
		}

		if ( ! function_exists( 'deactivate_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		deactivate_plugins( $plugins, true );

		if ( ! function_exists( 'get_filesystem_method' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		// delete_plugins() can print a credentials form and exit the request.
		if ( 'direct' !== get_filesystem_method() ) {
			return;
		}

		delete_plugins( $plugins );

	}

	/**
	 * Strip the #more-N fragment from the more link.
	 *
	 * @param string $link More-link HTML from the_content_more_link.
	 * @return string
	 */
	public function nuke_more_jump_link_anchor( $link ) {

		if ( ! is_string( $link ) || '' === $link ) {
			return $link;
		}

		$stripped = preg_replace( '/#more-\d+/', '', $link );

		return is_string( $stripped ) ? $stripped : $link;

	}

	/**
	 * Fixes curly quotes and badly formatted characters. One of my bigger pet peeves is curly quotes from word pastes
	 *
	 * @param string $fix_chars Content or title on save.
	 * @return string
	 */
	public function nuke_curly_other_chars( $fix_chars ) {

		if ( ! is_string( $fix_chars ) ) {
			return $fix_chars;
		}

		static $utf8_search = array( "\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6" );
		static $utf8_replace = array( "'", "'", '"', '"', '-', '&mdash;', '&hellip;' );
		static $win_search = array();
		static $win_replace = array( "'", "'", '"', '"', '-', '&mdash;', '&hellip;' );
		static $latin1_search = array( 'â„¢', 'Â©', 'Â®' );
		static $latin1_replace = array( '&trade;', '&copy;', '&reg;' );

		if ( empty( $win_search ) ) {
			$win_search = array( chr( 145 ), chr( 146 ), chr( 147 ), chr( 148 ), chr( 150 ), chr( 151 ), chr( 133 ) );
		}

		$fix_chars = str_replace( $utf8_search, $utf8_replace, $fix_chars );
		$fix_chars = str_replace( $win_search, $win_replace, $fix_chars );
		$fix_chars = str_replace( $latin1_search, $latin1_replace, $fix_chars );

		return $fix_chars;

	}

}

endif;

if ( ! function_exists( 'run_selfish_fresh_start' ) ) {
	/**
	 * Singleton bootstrap so activation can reuse the same instance.
	 *
	 * @since 1.1.0
	 * @return Selfish_Fresh_Start
	 */
	function run_selfish_fresh_start() {

		static $plugin = null;

		if ( null === $plugin ) {
			$plugin = new Selfish_Fresh_Start();
		}

		return $plugin;

	}
}

if ( ! function_exists( 'selfish_fresh_start_activate' ) ) {
	/**
	 * Set discussion flags on activation. admin_init does not run during activate.
	 *
	 * @return void
	 */
	function selfish_fresh_start_activate() {

		run_selfish_fresh_start()->nuke_trackbacks_smilies();

	}
}

if ( class_exists( 'Selfish_Fresh_Start' ) ) {
	register_activation_hook( __FILE__, 'selfish_fresh_start_activate' );
	run_selfish_fresh_start();
}
