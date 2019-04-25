=== Caredove widgets ===
Contributors: steedancrowe, caredove
Donate link: https://caredove.com
Tags: caredove, integration, api
Requires at least: 3.0.1
Tested up to: 5.3
Stable tag: 0.2.6
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
= 0.2.6 =
* button preview now updates when any related field is changed
* added better solution for URL prefix on search page plugin insert
* Search Page settings: Added placeholder text on popup window title field
* Added "Button Type" option for referral for "Add a Caredove Referral Button" Link vs. Popup
* Removed delay on search page modal - this also removed iFrame checking, we will have to find a better way to show errors when an iFrame doesn't load

= 0.2.5 =
* Fixed bug with URL Field prefix on search page popup (admin side)
* Finished updating styling on 'direct link' buttons to match other buttons
* Updated tinyMCE popup button previews to better match front-end button styles
* Added font color option for buttons
* Added error handling to modaal popup on front-end


= 0.2.4 =
* Fixed issue causing Search popup loading animation not to appear
* Converted list of listings per page to be dropdown instead of textbox
* Fixed issue causing button color field to show when creating a new listings section
* Fixed In the wordpress Editor, Button width is now dynamic and expands with text
* Fixed issue with TinyMCE popup on small screens where content wasn't scrollable
* Added Button preview in TinyMCE popup


= 0.2.3 =
* Fixed typo on search modal title field tool tip
* Added ability to specify number of listings per page
* Fixed bug where pages navigation for listings wasn't showing after last update
* Fixed issue where button colour wasn't hiding when editing buttons with default style, only when clicking default style from dropdown options
* Added Prefill of "https://www.caredove.com/" in Search Page Settings URL
* Fixed Typo on Modal Title tool tip on Search Page Settings
* Temporarily disabled Tutorial links

= 0.2.2 =
* Changes to button size styles to match Bootstrap v3.3
* Refer Button - updated "button color" to not show if default style selected, and moved it below style
* Changed references of "Modal" to "Popup Window" in editor
* Added capital letters to buttons and Modal titles where missing
* Fixed listings shortcode output not showing in right order when with other shortcodes

= 0.2.1 =
* Fixed issue with more recent versions of WordPress, with Gutenberg editor, lists of listings were being processed on post edit page
* Added option to swap between www and sandbox for connection
* Added <br /> break tags to HTML content at top of TinyMCE Editor Popup Descriptions to stop oveflow

= 0.2.0 =
* Change default button color from theme default to Caredove blue
* Fixed button breaking in Chrome when adding colour (this was an encoding issue, fixed)
* Refer Button - Add descriptive text at top of the edit window
* Change "add a..." buttons text and positioning

= 0.1.19 =
* Fixing issue with paginated lists, where the first page wasn't showing on original page load
* Added loading animation to modal
* fixing modal close on form submit

= 0.1.18 =
* unnecessary fields now hide when editing an existing embedded Search
* Added more dynamic height calculations to Public Modal
* Added pagination to lists of listings

= 0.1.17 =
* Fixed issue that was preventing CSS and JS versioning from working
* Added custom svg for Caredove Listings in Visual Editor

= 0.1.16 =
* Added extra padding to modal if admin-bar is present
* Updated 'tested up to' version number to 5.3
* added 'padding-bottom' and 'margin-bottom' to modal header
* added additional button styling overrides
* making it so hidden fields are not visible when editing an existing button
* fixed disappearing logo on admin buttons
* added event listener code to close modal when form submitted (not tested)
* added button styles to Visual admin editor

= 0.1.15 =
* Adjusted padding on bottom of Modal window
* Adjusting and sanitizing formatting of modal footer
* Adjusting and sanitizing formatting of modal header
* Added rounded corners to modal
* Added description and logo to top of TinyMCE Editor popup windows

= 0.1.14 =
* Updated the TinyMCE "Add Buttons" design to include Caredove logo
* Updated Title of the "Caredove Button" Window to say name of button or value of Modal Title field, not "Search for Services"
* Updates to TinyMCE Add Search Page popup Design
	* Added ability to hide and show fields depending on chosen options
* Cleaned up the way public facing buttons were being generated, much more dynamic now
* Added more styles for buttons, and better defined them in CSS
* Fixed a few minor issues with the Styled list of lists with buttons)
* Added .gitignore to ignore mac .DS files

= 0.1.13 =
* Set max width for modal popup to 1140px
* Set consistent lineheight for Modal title and close button, vertically centred

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

= 0.2.1 =
Please upgrade to the latest release which has better support for the current version of WordPress
