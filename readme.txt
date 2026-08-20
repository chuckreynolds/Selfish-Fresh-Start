=== Selfish Fresh Start ===
Contributors: ryno267
Donate link: https://cash.app/$chuckreynolds
Tags: dashboard, declutter, editor, admin, cleanup
Requires at least: 4.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.3.0
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Built to run on EVERY WordPress install, selfish fresh start removes unneeded admin and html meta clutter.

== Description ==
This plugin strips out the dashboard widgets, metaboxes, header tags and default settings that most WordPress sites never use. It fixes curly quotes and other mangled characters pasted in from Word, checks for and removes Hello Dolly, hides update notices from users who cannot act on them, stops your site pinging itself, and locks down the built-in file editors.

There is nothing to configure. Activate it and it works. It is deliberately generalized so it is safe to drop onto any WordPress site as a clean starting point, and it helps keep clients out of the plugin and theme file editors.

= Current Operations =
* Removed: clean up unneeded header tags including:
	* rsd links
	* wordpress generator
	* shortlink in head and the shortlink HTTP header
* Removed: admin dashboard widgets:
	* core: quick draft / your recent drafts
	* core: wordpress events and news
	* core: the welcome panel
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
* Fixed: curly quotes, en/em dashes, ellipses and other mangled characters on save
* Off: turn off plugin/theme editor
* Off: turn off global trackback/pingback setting

= Additional Functionality =
* Emojis scripts and support removal? I almost included it in this plugin but just use this plugin: [Disable Emojis](https://wordpress.org/plugins/disable-emojis/)
* Want to remove the Tools Menu? There's a plugin for that: [Remove Tools Menu](https://wordpress.org/plugins/remove-tools-menu/)
* Want the post/page slug visible in the admin list? [Admin Slug Column](https://wordpress.org/plugins/admin-slug-column/)
* Want the posts list to default to Published instead of All? [Filter Admin Published Default](https://wordpress.org/plugins/filter-admin-published-default/)

Found a bug or have an idea? Open an issue: [GitHub Issues](https://github.com/chuckreynolds/Selfish-Fresh-Start/issues)

== Installation ==
1. Upload the `selfish-fresh-start` folder to the `/wp-content/plugins/` directory
1. Activate the plugin
1. That's it. seriously. Everything is done already. Enjoy.

== Frequently Asked Questions ==

= Is there a settings page? =
No, and there will not be one. The whole point is that it does its thing the moment you activate it.

= My discussion settings keep reverting. Why? =
That is this plugin, and it is intentional. It forces `default_ping_status` to closed and turns off the default pingback flag, because self-pings and trackbacks are almost entirely spam at this point. If you need pingbacks on, deactivate the plugin.

= Will it really delete Hello Dolly? =
Yes. It deactivates it first, then deletes the files, but only when WordPress can write to the filesystem directly. If your install needs FTP credentials to modify files, it deactivates it and stops there rather than interrupting your admin with a credentials prompt.

= Does it change my existing content? =
Only on save. The character cleanup runs when a post or title is saved, so pasted curly quotes get straightened at that point. It does not touch content already in the database.

= Why is jquery-migrate still loading in wp-admin? =
On purpose. Plenty of admin screens and plugins still lean on it. Only the frontend has it stripped.

== Changelog ==
= 1.3.0 =

Release Date - 2026-08-19

First update in a long while. The plugin was rebuilt against modern WordPress: every hook was re-checked against core, dead code was dropped, and the parts that touch your site's data were tightened up.

**Compatibility**

* tested up to WordPress 7.1
* now requires PHP 7.4
* dropped the `wlwmanifest_link` and adjacent-posts rel unhooks; core removed both before 6.8

**Fixed**

* the curly quote cleanup no longer corrupts non-Latin text. The Windows-1252 pass worked on raw bytes, and those same bytes are valid inside multi-byte UTF-8 characters, so saving a post containing Cyrillic, CJK, emoji or accented characters could mangle it. That pass now only runs on content that is not already valid UTF-8.
* stripping `#more-` from the more link no longer throws a notice on an undefined variable
* self-ping detection compares URL hosts instead of matching string prefixes
* post and page metabox removal runs on `add_meta_boxes_{type}`, after core registers the boxes, so it actually takes effect
* `DISALLOW_FILE_EDIT` is defined as a real boolean at plugin load, before menus and capability checks run

**Security and safety**

* admin-only hooks no longer register on the frontend
* ping and trackback options are written only by users with `manage_options`, and only on admin_init or activation, never on a public request
* Hello Dolly is deactivated before deletion, and files are only deleted when the filesystem method is `direct`, so an admin page can never be replaced by a credentials form
* Hello Dolly removal now covers both a bundled `hello.php` and the `hello-dolly` plugin directory

**Changed**

* also strips the shortlink HTTP header, not just the tag in the head
* jquery-migrate is dropped from the frontend `jquery` handle; wp-admin is unchanged
* no longer forces `use_smilies` off
* dashboard widget removal is scoped to the dashboard screen, in both the normal and side contexts
* core dashboard widget ids and contexts re-verified against WP 7.1; quick draft and events and news are still the ones removed
* third-party dashboard widgets removed: yoast seo, the events calendar news, all in one seo news
* Gravity Forms and Jetpack Stats dashboard widgets are now left alone
* dropped dead widget ids that no longer exist: WP Socializer, W3 Total Cache news, bbPress Right Now, Thesis news, and the old all in one seo feed id

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

= 1.3.0 =
First update since 2017. Tested on WordPress 7.1 and now requires PHP 7.4. Fixes a bug where saving a post could corrupt Cyrillic, CJK, emoji or accented characters. It also removes less than it used to: Gravity Forms and Jetpack Stats dashboard widgets are left alone, and smilies are no longer forced off.

== Other Notes ==
* Built in Chandler AZ, Updated in San Francisco, CA. I always used a lot of these functions on every site to help clean up the admin stuff and do some basic settings and based on some twitter replies others wanted this too as a public plugin. So... here we go. Bugs and ideas go here: [GitHub Issues](https://github.com/chuckreynolds/Selfish-Fresh-Start/issues)
