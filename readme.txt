=== WP Infinity Responder ===
Contributors: majick
Donate link: http://pluginreview.net/donate/?plugin=wp-infinity-responder
Tags: infinity, autoresponder, mailer, newsletter, followup, email, sequential mailer, mailing list
Author URI: http://dreamjester.net
Plugin URI: http://pluginreview.net/wordpress-plugins/wp-infinity-responder/
Requires at least: 3.0.0
Tested up to: 4.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The fully featured Infinity Responder now for Wordpress! Unlimited mailing lists and followup autoresponders.

== Description ==

The fully featured Infinity Responder now for Wordpress! Unlimited mailing lists and followup autoresponders.
I so loved this autoresponder script that I ported it into Wordpress.  It just rocks. :-)

[WP Infinity Responder Home] (http://pluginreview.net/wordpress-plugins/wp-infinity-responder/)

Infinity Responder Features:
* Unlimited Lists and AutoResponders!
* Sequential and Absolute Timing Mailing
* Unlimited Mailburst Sending
* Single or Double Optin Mailing Lists
* Multipart Text and/or HTML Emails

and also comes with:
* Custom Tags for Message Personalization
* Custom Fields for Unlimited Form Options
* Per Send Run and Daily Send Limits
* Optin/Optout Redirection or Message
* Email Blacklisting Ability
* POP3 Bouncer Handling (untested for WP)

PLUS New Feature Additions for the Wordpress Version:
* Embedded Images Support! (cid method)
* Improved Style User Interface
* Multiple WYSIWYG Editor Options
* Send Full Message Sequence Test
* Subscription Management Shortcode
* Import / Export Subscribers (via CSV)
* Supports both Cron and WP Cron
* Use either wp_mail (phpmailer) or mail
* Notification Template Hierarchy
* Subscriber Optin Widget

Also comes with an Integration Module for customer list creation,
hooking into eStore, eMember and WP Affiliate Platform.
(For more detailed information visit the plugin homepage.)

[WP Infinity Responder Home] (http://pluginreview.net/wordpress-plugins/wp-infinity-responder/)
[Mailing Guide] (http://pluginreview.net/guides/mailing-guide/)

A big thank you to Aaron Colman for the creation of Infinite Responder!
[Original Infinite Responder] (http://infinite.ibasics.biz/)
[Infinity Responder Update] (http://infinityresponder.org/)


== Installation ==

1. Upload `wp-infinity-responder.zip` via the Plugins upload page.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Visit the Infinity Responder menu to create tables.
1. Choose your config and cron job options.

== Frequently Asked Questions ==

= Where is the documentation? =

The original documentation for Infinite Responder can be found in:
/wp-infinity-responder/docs/documentation.txt
Hopefully everything should be pretty much self-explanatory!

Further documentation is not planned at this time, sorry. This is it...
There are some notes here for features added to the Wordpress plugin version...

= How can I use SMTP mailing with this plugin? =

While there is no SMTP functionality directly inbuilt, this is easy to set up.
First, make sure you have the mailing option set to wp_ mail in the config page.

Then install a SMTP mailing Wordpress plugin to do this for you...
eg. Postman SMTP Mailer (recommended), Configure SMTP,  WP Mail SMTP,
WP SMTP, Easy WP SMTP, Easy SMTP Mail...

For more detailed information check out the Mailing Guide:
[Mailing Guide] (http://pluginreview.net/guides/mailing-guide/)

= Can subscribers manage their subscriptions? =

Yes, by using the shortcode `[ir-subscriptions]` in a post/page/widget area.
(if using in a widget you may need to add this to your theme's functions.php:)
`add_filter('widget_text','do_shortcode');`

If the logged in user's email matches a subscription in the Infinity Responder
database, a subscription option table will be provided for the user. Otherwise 
they can also unsubscribe via the standard unsubscribe link in emails.

= How are images embedded in emails? =

Images are embedded inline using the 'cid' method (not by the 'data' method)
since this method has been tested to have far higher deliverability rates.
This image embedding works for both the `wp_mail` and `mail` options.

There is also an option to embed external image URLs (in this context this means 
anything NOT in the specified email image directory.) If this is selected the images 
will be downloaded into a temporary directory and then embedded, as the embedding 
needs a local file path to embed (attach) the image.

= Can I change the default subscriber/admin notification templates? =

Yes, you can copy the text templates from `templates/messages/` to your current theme
in a subdirectory either at `templates/infinity-responder/` or `irmessages` eg,
`/wp-content/my-active-theme/templates/infinity-responder/subscribe.complete.txt`
or `/wp-content/my-active-theme/irmessages/subscribe.complete.txt`
(replacing my-active-theme with the corrent directory of course)

You can add a HTML version of these templates by changing the extension (note that the
text template uses `<SUBJ>` and `<MSG>` to get the subject and message, but there is no
need to add these to the HTML version, the subject is grabbed from the text template. eg,
`/wp-content/my-active-theme/templates/infinity-responder/subscribe.complete.html`
or `/wp-content/my-active-theme/irmessages/subscribe.complete.html`

Just be sure to include/modify the text version also if you are adding a HTML version, 
as this is sent as an alternative body for non-HTML email clients.

You can also override the notification template for a *specific* responder by creating
a file in those locations with the Responder ID in the filename. eg, for Responder 1
`templates/infinity-responder/subscribe.complete.1.txt` and/or
`templates/infinity-responder/subscribe.complete.1.html`

Finally, template hierarchy filters are available if you want to change the template 
locations to search for them in a different directory. Those filters are called:
`inf_resp_template_hierarchy_text` and `inf_resp_template_hierarchy_html`

= Does everything work? =

All functions and features are tested and working, with the exception of POP3 Bounce 
Handling which has not been tested for the Wordpress version. It has not been changed 
from the original Infinity Responder, so may or may not work as expected. If you have 
the experience and time, you can contribute by testing it yourself.


== Screenshots ==



== Changelog ==

= 1.6.0 =
* Added Template Hierarchy for HTML templates
* Improved Template Hierarchy for Text templates
* Added filter for HTML and Text template hierarchies
* Changed SMTP Plugin Recommendations
* Added Mailing Guide Link for SMTP
* Clear WP Cron on plugin deactivation

= 1.5.5 =
* Fix to table prefix variable for Wordpress 4

= 1.5.0 =
* Added detailed instructions on Integration page
* Added Signature and Address Options to Config
* Fixed unsubscribe link for Wordpress subdirectory installs
* Fixed some minor sidebar display bugs

= 1.4.0 =
* Created Secret Key Option for Cron Output
* Fix for WP Cron Clear Schedules on Frequency Change
* Added Refresh Buttons to Bottom of List Screens

= 1.3.5 =
* Bugfixes for Mailburst Sending 
* Update to Mailburst Menu Templates and Counts
* Added Pause/Activate Option and Menu Button for Responders
* Added Pause/Activate Menu Button to Mailburst List
* Added Pause/Play/Messages Graphical Icons
* Updates and fixes to import and export features.
* Added per responder message template functionality.
* Added Integration Module for customer list subscriptions.
* Added subscription management shortcode.
* Added Wordpress widget for subscriber optin.

= 1.3.0 =
* See DEVNotes.txt for all WP conversion notes prior to 1.3.5


== Upgrade Notice ==

= 1.5.5 =
* Important update for Wordpress 4 table prefix



== Other Notes ==

[WP Infinity Responder Home] (http://pluginreview.net/wordpress-plugins/wp-infinity-responder/)

Like this plugin? Check out more of our free plugins here: 
[Plugin Review Network] (http://pluginreview.net/wordpress-plugins/ "Plugin Review Network Plugins")

Looking for an awesome theme? Check out my theme framework:
[BioShip Theme Framework] (http://bioship.space "BioShip Theme Framework")

= Support =
For support or if you have an idea to improve this plugin:
[WP Infinity Responder Support Quests] (http://pluginreview.net/support/ "Plugin Review Network Support Quests")

= Development =
To contribute directly to development, fork on Github and do a pull request:
[WP Infinity Responder Github Home] (http://github.com/majick777/wp-infinity-responder/ "GitHub Project Home")

= Untested for Wordpress version = 
* POP3 Bounce Handling

= Planned Features and Improvements =
* Update Helper Objects for Page Items
* Better Debugging Mode
* Optin Source Tracking/Reporting
* Link Clickthrough Tracking
* Multisite: Single Global Table Option for SuperAdmin only 
* Multisite: SuperAdmin limit feature access for site Admins

= Planned Integrations = 
* WooCommerce Customer List Integration / Import
* eStore/eMembers/Affiliate Customers/Members/Affiliates Importer
