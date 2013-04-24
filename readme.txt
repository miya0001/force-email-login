=== Force Email Login ===
Contributors: miyauchi
Donate link: http://wpist.me/
Tags: widget
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 0.2.0

Use email address for login to your WordPress.

== Description ==

Use email address for login to your WordPress.

It is easy way to protect from brute-force attacks.

[This plugin maintained on GitHub.](https://github.com/miya0001/force-email-login)

= Some features: =

* Use email address instead of the username to login.
* Login using the username is always denied.
* Automatically lockdown 10 seconds after login failed.

= filter hooks example =

You can customize lockdown time like below.

`<?php
    add_filter("force_email_login_lockdown", "my_force_email_login_lockdown");
    function my_force_email_login_lockdown($seconds) {
        return 60; // default 10
    }
?>`


Please contact to me.

* @miya0001 on twitter.
* http://wpist.me/ (en)
* http://firegoby.jp/ (ja)

= Contributors =

* [Takayuki Miyauchi](http://wpist.me/)

== Installation ==

* A plug-in installation screen is displayed on the WordPress admin panel.
* It installs it in `wp-content/plugins`.
* The plug-in is made effective.

== Changelog ==

= 0.1.0 =
* The first release.

== Credits ==

This plug-in is not guaranteed though the user of WordPress can freely use this plug-in free of charge regardless of the purpose.
The author must acknowledge the thing that the operation guarantee and the support in this plug-in use are not done at all beforehand.

