=== Selfish Fresh Start ===
Contributors: ryno267
Donate link: http://rynoweb.com/wordpress-plugins/
Tags: clean, fresh start, new install, clean admin, remove meta box, remove widgets, editor, profile fields, no smilies, no trackbacks, no pings, self pings, organize, declutter, clutter, theme editor, rsd links, wlw manifest links, shortlink, dashboard widgets, quick press, dashboard news
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk

This general plugin is built to run on EVERY install you have. Removes unneeded admin clutter and stuff.

== Description ==

This WordPress plugin Removes some, in my opinion, unused crappy dashboard, post & page widgets, checks for and nukes Hello Dolly, removes junk header tags including the generator tag for extra security, removes update notifications for non-admins, removes old user profile fields like aim, prevents self pining, removes smilies and trackbacks, and a few other settings that nobody needs either. This is built to be very generalized so it'll work with every site as a good clean-up fresh start.

= Current Operations =
* Removed: clean up unneeded header tags including:
	* index relation links
	* start relation links
	* wlw manifest links
	* rsd links
	* previous and next post links
	* wordpress generator
	* shortlink
* Removed: admin dashboard widgets:
	* quick press
	* recent drafts
	* recent plugins feed
	* wordpress development blog feed
	* other wordpress blog news feed
* Removed: post metabox's
	* comments box
	* trackbacks
	* slug *(can use the ajax one under post title)*
	* author *(if you must, use quick edit)*
	* tags box *(nobody uses tags right, just not needed)*
* Removed: page metabox's
	* comments box
	* slug *(can use the ajax one under page title)*
	* author *(if you must, use quick edit)*
	* discussion box
* Removed: appearance menu theme editor *(some ppl may not like this but use ftp; great for client admins)*
* Removed: more jump link to #anchor
* Removed: update notifications for non-admin users
* Removed: potential for self ping backs
* Removed: checks for and nukes Hello Dolly plugin *(sorry Matt)*
* Removed: user yim, aim, jabber fields
* Add: user profile twitter, facebook, linkedin, google plus fields
* Off: turn off global trackback/pingback setting
* Off: turn off global formatting of text to graphic smilies
* Off: turn off /year/month/ file upload archives

== Installation ==

1. Upload the `selfish-fresh-start` folder to the `/wp-content/plugins/` directory
1. Activate the plugin
1. That's it... seriously. Everything is done already. Enjoy.

== Changelog ==

= 0.3 =
* added linkedin and google plus user fields

= 0.2 =
* removed generator tag. not really needed either, helps with security scanning.
* updated to new adjacent_posts_rel_link_wp_head from old. guess that changed recently.
* updated readme and better description of everything from developer geek speak to human english.

= 0.1 =
* take functions I use regularly and bundle for IPO *(initial public offering)*

== Upgrade Notice ==

= 0.2 =
Added additional features, one of which helps secure your WP site. Always stay up to date!


== Other Notes ==

* Built on a hack-night at GangplankHQ.com. I always used a lot of these functions on every site to help clean up the admin stuff and do some basic settings and based on some twitter replies others wanted it as a plugin. So... here we go. Feel free to ask for features on my [WordPress Plugins](http://rynoweb.com/wordpress-plugins/ "Chuck's WordPress Plugins") form.
