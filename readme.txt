=== Selfish Fresh Start ===
Contributors: ryno267
Donate link: http://rynoweb.com/wordpress-plugins/
Tags: clean, fresh start, new install, clean admin, curly quotes, remove meta box, remove widgets, editor, profile fields, no smilies, no trackbacks, no pings, self pings, organize, declutter, clutter, theme editor, rsd links, wlw manifest links, shortlink, dashboard widgets, quick press, dashboard news, remove edit menu, remove editor, remove plugin editor, remove theme editor, aim, jabber, yim
Requires at least: 3.0
Tested up to: 3.8.1
Stable tag: 0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Built to run on EVERY install you have, fresh start removes unneeded admin clutter and sets up the needed settings for every site.

== Description ==
This WordPress plugin removes some, in my opinion, unused crappy dashboard, post & page widgets, fixes formatted curly quote problems, checks for and nukes Hello Dolly, removes junk header tags including the generator tag for extra security, removes update notifications for non-admins, removes old user profile fields like aim, prevents self pinging, removes smilies and trackbacks, and a few other settings that nobody needs either. This is built to be very generalized so it'll work with every site as a good clean-up fresh start and help keep clients out of the edit menus.

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
	* incoming links box
* Removed: post metabox's
	* trackbacks
* Removed: page metabox's
	* comments box
	* discussion box
* Removed: appearance menu theme editor *(some ppl may not like this but it's great for client admins)*
* Removed: plugins editor menu
* Removed: plugins list edit links
* Removed: more jump link to #anchor
* Removed: update notifications for non-admin users
* Removed: potential for self ping backs
* Removed: checks for and nukes Hello Dolly plugin *(sorry @photomatt)*
* Removed: admin user yim, aim, jabber fields
* Off: turn off global trackback/pingback setting
* Off: turn off global formatting of text to graphic smilies

== Installation ==
1. Upload the `selfish-fresh-start` folder to the `/wp-content/plugins/` directory
1. Activate the plugin
1. That's it. seriously. Everything is done already. Enjoy.

== Changelog ==
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
= 0.6 =
Some new features and cleaner code. overall a pretty big update.
= 0.5 =
Some sites reporting issues w/ comments always off on posts. put back comment div for now until more testing.
= 0.2 =
Added additional features, one of which helps secure your WP site. Always stay up to date!

== Other Notes ==
* Built in Chandler AZ, Updated in San Francisco, CA. I always used a lot of these functions on every site to help clean up the admin stuff and do some basic settings and based on some twitter replies others wanted this too as a public plugin. So... here we go. Feel free to ask for features on my [Chuck Reynolds WordPress Plugins](http://rynoweb.com/wordpress-plugins/ "Chuck Reynolds WordPress Plugins") page.