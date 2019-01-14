=== Caredove widgets ===
Contributors: steedancrowe, caredove
Donate link: https://caredove.com
Tags: caredove, integration, api
Requires at least: 3.0.1
Tested up to: 4.4
Stable tag: 0.1.12
Requires PHP: 6.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A Wordpress plugin that allows populating Wordpress with content from Caredove, such as referral buttons, search pages, and service listings.

== Description ==

A Wordpress plugin that allows populating Wordpress with content from Caredove, such as referral buttons, search pages, and service listings.

== Installation ==

1. Upload `caredove.zip` by going to Plugins->Add New and clicking Upload Plugin, then Choose File
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your User ID and API key to Settings->Caredove
4. Use the shortcode buttons above the visual editor on any post or page to insert buttons, or listings.

== Frequently Asked Questions ==

= Who do I contact if I need support? =

This plugin is built for and maintained by Caredove. Please direct any support questions to support@caredove.com

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.1.12 =
* Fixed error where 'button color' field was pulling in next option title
* A better Regex to solve above issue also allows for single quotes

= 0.1.11 =
* Added additional error message details
* Accounted for more data caching scenarios

= 0.1.10 =
* Improved error handling on settings page
* Added Ability to clear cache from settings page
* Added custom cache handling for more reliable API results

= 0.1.9 =
* added additional API error responses

= 0.1.8 =
* updated API structure to include 'results'
* +Caredove Button function now working, user can insert booking buttons

= 0.1.7 =
* auto update and check for updates now working

= 0.1.6 =
* added basic API functionality
* updates to readme.txt

= 0.1.5 =
* test release tagging in GitHub

= 0.1.4 =
* added back in ?embed=1 for iFrame urls

= 0.1.3 =
* Changed out custom modal for modaal by @wearehuman
* Added lazy loading for first modal iframe
* Customized modal with header and footer
* Added additional space for button styles - styles need refinement and testing

= 0.1.2 =
* Testing updating by changing version number

= 0.1.0 =
* First release
* The Caredove Search shortcode works

= 0.0.1 =
* Very first version, initial setup and configuration

== Upgrade Notice ==

= 0.1.11 =
This is the latest test version 