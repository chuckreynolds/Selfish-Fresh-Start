=== Selfish Fresh Start ===
Contributors: ryno267
Donate link: https://cash.me/$chuckreynolds
Tags: dashboard, declutter, editor, admin, cleanup
Requires at least: 4.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Built to run on EVERY WordPress install, selfish fresh start removes unneeded admin and html meta clutter.

== Description ==
This WordPress plugin removes most, in my opinion, unneeded crappy dashboard, post and page widgets, fixes formatted curly quote problems, checks for and removes Hello Dolly plugin, removes junk header tags, removes generator header tag for extra security, removes update notifications for non-admins, prevents self-pinging, removes trackbacks, and a few other settings that nobody needs either. This is built to be very generalized so it will work with every WordPress site as a good clean-up fresh start and help keep clients out of the editing files.

= Current Operations =
* Removed: clean up unneeded header tags including:
	* rsd links
	* wordpress generator
	* shortlink in head and the shortlink HTTP header
* Removed: admin dashboard widgets:
	* core: quick draft / your recent drafts
	* core: wordpress events and news
	* plugin: yoast seo posts overview
	* plugin: the events calendar news
	* plugin: all in one seo news
* Removed: post metabox's
	* trackbacks
* Removed: page metabox's
	* comments box
	* discussion box
* Removed: appearance menu theme editor
* Removed: plugins editor menu
* Removed: plugins list edit links
* Removed: jquery migrate on the frontend (wp-admin keeps it)
* Removed: more jump link to #anchor
* Removed: update notifications for non-admin users
* Removed: potential for self ping backs
* Removed: checks for and nukes Hello Dolly plugin *(sorry @photomatt)*
* Off: turn off plugin/theme editor
* Off: turn off global trackback/pingback setting

= Additional Functionality =
* Emojis scripts and support removal? I almost included it in this plugin but just use this plugin: [Disable Emojis](https://wordpress.org/plugins/disable-emojis/)
* Want to remove the Tools Menu? There's a plugin for that: [Remove Tools Menu](https://wordpress.org/plugins/remove-tools-menu/)
* Want the post/page slug visible in the admin list? [Admin Slug Column](https://wordpress.org/plugins/admin-slug-column/)
* Want the posts list to default to Published instead of All? [Filter Admin Published Default](https://wordpress.org/plugins/filter-admin-published-default/)

= Development =
1.3.0 is currently beta (`1.3.0-beta1`) and is not the WordPress.org stable tag. Stable remains 1.2.0 until this ships.

Found a bug or have an idea? Open an issue: [GitHub Issues](https://github.com/chuckreynolds/Selfish-Fresh-Start/issues)

== Installation ==
1. Upload the `selfish-fresh-start` folder to the `/wp-content/plugins/` directory
1. Activate the plugin
1. That's it. seriously. Everything is done already. Enjoy.

== Changelog ==
= 1.3.0-beta1 =

Release Date - 2026-08-19 (beta, not shipped)

* tested up to WP 7.1
* requires PHP 7.4 (WordPress 7.1 minimum)
* admin-only hooks no longer register on the frontend
* ping/trackback options are written only by users with `manage_options`, on admin_init and activation, never on public requests
* Hello Dolly is deactivated first; files are deleted only when the filesystem method is `direct` so admin pages cannot be replaced by a credentials form
* Hello Dolly removal covers bundled `hello.php` and the `hello-dolly` plugin directory
* `DISALLOW_FILE_EDIT` is defined as boolean `true` at plugin load
* self-pings compare URL hosts instead of string prefixes
* more-link `#more-` stripping uses preg_replace and no longer notices on undefined `$end`
* post/page metabox removal runs on `add_meta_boxes_{type}` after core registers the boxes
* plugin dashboard widgets are removed on the dashboard screen only, both normal and side contexts
* core dashboard widget IDs/contexts verified against WP 7.1 (Quick Draft and Events and News are still the ones removed)
* dropped `wlwmanifest_link` and adjacent-posts rel unhooks; both are gone from core before 6.8
* third-party dashboard widgets: Yoast, The Events Calendar news, All in One SEO news
* Gravity Forms and Jetpack Stats dashboard widgets are left in place
* no longer forces `use_smilies` off
* also removes the shortlink HTTP header (`wp_shortlink_header`)
* jquery-migrate stripped from the frontend `jquery` handle; wp-admin is unchanged
* dropped dead IDs: WP Socializer (`aw_dashboard`), W3 Total Cache WP-dashboard news (`w3tc_latest`; their news box now lives on the W3TC dashboard), bbPress Right Now (`bbp-dashboard-right-now`; stats moved into At a Glance in 2.6), Thesis news, old AIOSEO `semperplugins-rss-feed` id

= 1.2.0 =

Release Date - 2017-11-14

* tested up to WP 4.9
* removed the removing of old IM profile fields that have been deprecated
* removed the removing of old dashboard widgets that have been merged or deprecated
* updated the minimum required version of WP to 4.0 due to the deprecated widgets
* removed, by request, another news rss feed dashboard box; this one from moderntribe plugins

= 1.1.0 =

Release Date - 2017-03-21

* new super duper plugin image assets for wp repo
* tested up to WP 4.7.3
* removed a couple deprecated calls but they didn't cause problems

= 1.0 =

Release Date - 2015-12-02

* tested to WP 4.4
* updated some functions to fire at a more appropriate time on load
* updated some metabox names that have changed
* fixes an ajax warning in admin area. nbd.
* content in this readme updated
* simple branding images for wp plugin repo

= 0.7 =
* removed dashboard widgets: bbpress, gravity forms
* add check for option settings before updating them
* test for WP 3.9

= 0.6.1 =
* fixed bug with & symbols

= 0.6 =
* all object oriented now and cleaned up code a lot. mo betta
* HUGE pet peeve of mine is people pasting from word (or others) with formatted text. so i'm tired of fixing it all the time so lets force fix curly quotes and some common unicode, ascii, and utf-8 problems
* remove dashboard welcome panel that was added in 3.5
* added back author metabox on posts only. seem to use this more often so back it goes
* no longer adding user profile fields: twitter, facebook, linkedin, google plus. I took it out as most plugins now like Yoast SEO & Facebook's add those fields in order to do authorship verification and twitter cards etc. used to be needed but other plugins have finally caught up. time to take it out of here.

= 0.5 =
* checking if DISALLOW_FILE_EDIT is defined or not to avoid issues. if not add it.
* comments div affecting some sites not able to turn them back on. spotty, so taking out for now

= 0.4 =
* temporarily removed removing 'slugdiv' from posts and pages as it was found to hinder the ajax edit permalink updating function. that's another issue with wordpress but had to stop hiding that until wp fixes that.

= 0.3 =
* added linkedin and google plus user fields

= 0.2 =
* removed generator tag. not really needed either, helps with security scanning.
* updated to new adjacent_posts_rel_link_wp_head from old. guess that changed recently.
* updated readme and better description of everything from developer geek speak to human english.

= 0.1 =
* take functions I use regularly and bundle for IPO *(initial public offering)*

== Upgrade Notice ==

== Other Notes ==
* Built in Chandler AZ, Updated in San Francisco, CA. I always used a lot of these functions on every site to help clean up the admin stuff and do some basic settings and based on some twitter replies others wanted this too as a public plugin. So... here we go. Bugs and ideas go here: [GitHub Issues](https://github.com/chuckreynolds/Selfish-Fresh-Start/issues)
