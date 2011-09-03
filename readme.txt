=== Selfish Fresh Start ===
Contributors: ryno267
Donate link: http://rynoweb.com/wordpress-plugins/
Tags: clean, fresh start, new install, clean admin, remove meta box, remove widgets, editor, profile fields, no smilies, no trackbacks, no pings, self pings, organize, declutter, clutter, theme editor,  
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk



== Description ==

This WordPress plugin removes some, in my opinion, unused crappy dashboard, post & page widgets, checks for and nukes Hello Dolly, removes junk header tags, removes update notifications for non-admins, removes old user profile fields like aim, prevents self pining, removes smilies and trackbacks, and a few other settings that nobody needs either. This is built to be very generalized so it'll work with every site as a good clean-up fresh start.

= Current Operations =
REM wp_head post links, wlm, rsd, generator
REM dashboard widgets
REM post / page metabox redundancies
REM appearance theme editor
REM more jump link to anchor hash
REM update notifications for non-admins
REM self ping backs
REM hello dolly plugin
REM user yim, aim, jabber fields
ADD user twitter, facebook fields
OFF global trackback setting
OFF global formatting smilies

== Installation ==

1. Upload the `selfish-fresh-start` folder to the `/wp-content/plugins/` directory
1. Activate the plugin
1. That's it... seriously. Everything is done already. Enjoy.

== Changelog ==

= 0.2 =
* removed generator tag. not really needed either, helps with security scanning.

= 0.1 =
* take functions I use regularly and bundle for IPO (initial public offering)

== Other Notes ==

* Built on a hack-night at GangplankHQ.com. I always used a lot of these functions on every site to help clean up the admin stuff and do some basic settings and based on some twitter replies others wanted it as a plugin. So... here we go. Feel free to ask for features on my <a href="http://rynoweb.com/wordpress-plugins/">Wordpress Plugins</a> form.
