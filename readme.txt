=== Google Analytics Tester ===
Contributors: David Karuri  
Tags: google analytics, analytics checker, ga4, seo tools, test analytics  
Requires at least: 5.0  
Tested up to: 6.8  
Requires PHP: 7.4  
Stable tag: 1.0  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple plugin that lets you test whether a website has Google Analytics tracking code installed correctly. Includes a shortcode for frontend use.

== Description ==

**Google Analytics Tester** is a lightweight tool that lets you (or your site visitors) check whether a website has Google Analytics installed correctly — right from your WordPress site.

Simply place the shortcode `[ga_tester_form]` on any page or post. It displays a clean, easy-to-use form where users can input any URL to test. The plugin then scans that page’s HTML to detect Google Analytics code — including both **GA4 (gtag.js)** and **Universal Analytics (analytics.js)**.

### Why this plugin matters:

Google recently **retired the old Tag Assistant Chrome Extension**, replacing it with a newer, more complex system that's harder to use for quick tests. This plugin brings back that simplicity — no extensions, no browser requirements, and no technical knowledge needed. Just type a URL, click "Test", and see if Google Analytics is working.

### Great for:
- SEO professionals who want a quick, no-login GA checker  
- Agency websites offering free SEO tools to attract traffic  
- Bloggers and developers looking to boost engagement by embedding useful utilities  
- Users who want to test their GA setup without technical hassle

This plugin is a valuable, low-friction lead magnet for websites offering **free SEO tools**. Embed it in a tools page and watch your organic traffic and engagement grow!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/google-analytics-tester` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the shortcode `[ga_tester_form]` in any post, page, or widget area to display the test form.

== Usage ==

Add the shortcode `[ga_tester_form]` where you'd like the form to appear. Users will enter a URL and click "Test" to see if the site has Google Analytics installed.

== Frequently Asked Questions ==

= Does this detect both Universal Analytics and GA4? =  
Yes, it checks for both `analytics.js` and `gtag.js` code snippets in the target website's source code.

= Can I use this plugin as a public SEO tool? =  
Absolutely! You can build a "Free SEO Tools" page and include this to drive more traffic and backlinks to your site.

= Does this check for Google Tag Manager as well? =  
Currently, the plugin focuses only on direct Google Analytics scripts. GTM detection will be added in future versions.

== Screenshots ==

1. Simple frontend form for testing Google Analytics.
2. Result showing whether GA tracking code is found or not.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
First release — install this to add a simple GA tester to your WordPress site.

== License ==

This plugin is licensed under the GPLv2 or later.  
Copyright © 2025 David Karuri, [qodewire.com](https://qodewire.com)