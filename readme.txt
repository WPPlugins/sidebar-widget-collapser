=== Sidebar Widget Collapser ===
Contributors: jaredbangs
Author: Jared Bangs
Author URI: http://freepressblog.org/
Plugin URI: http://wordpress.org/extend/plugins/sidebar-widget-collapser/
Tags: widget, sidebar, javascript
Requires at least: 2.6
Tested up to: 2.8
Stable tag: 1.4

Makes sidebar widgets collapsible, and optionally collapses specified widgets by default.

== Description ==

This plugin adds a script that will dynamically add the collapse and expand links to your sidebar widgets, as you can see in action on [my blog](http://freepressblog.org/).

== Installation ==

Standard plugin install procedure: copy files then activate. Check the options page to customize for your theme's particular widget setup, since some themes use different markup for their widgets.

The default options for this plugin make some initial assumptions about the structure of your sidebar. You may override these in the options page.

Specifically, the default settings assume that
* Your sidebar is (or is wrapped in) an element with the id of “sidebar”
* That sidebar element contains an unordered list (UL) that will contain all your sidebar widgets
* The list items (LI) in that list are your widgets, as identified with a class name containing the text “widget”
* And, finally that these widget list items contain a title, which is a direct child element (usually H2 or H3, but not required to be) with the class of “widgettitle”

== Frequently Asked Questions ==

None yet.

== Version log ==

* 1.0
	* Initial upload

== Future versions ==

TBD
