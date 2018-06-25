=== OpenHook ===
Contributors: BrazenlyGeek, KingdomGeek
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=HBM68KTMGMC7W
Tags: hooks, Headway, PHP, phpinfo, shortcodes, Thesis, Flat, THA, Theme Hook Alliance
Requires at least: 3.3.1
Tested up to: 4.1.1
Stable tag: 4.1
License: GPLv3 or later

Infinite customization in infinite combinations. Wanna play hooky?

== Description ==

Editing files is so passé. An increasing number of themes come equipped with a myriad of _hooks_ — points within its code which can receive user customizations, known as _actions_ — which can be customized without modifying any files directly.

OpenHook brings the world of hooks & actions to the mainstream, providing an easy to use admin interface in which you can customize your site without limit, whether you're using HTML or PHP!

***Features***

* Customize the hooks present in your favorite themes!
    * [Flat](http://wordpress.org/extend/themes/flat)
    * [Headway](http://headwaythemes.com/) — only statically named hooks are accessible to OpenHook
    * [Thesis 1.8.x](http://j.mp/GetThesis2)
    * ..and any theme that supports [Theme Hook Alliance](https://github.com/zamoose/themehookalliance/) hooks!
* OpenBox, a PHP-friendly "box" for Thesis 2
* Quick access to the header & footer hooks of WordPress
* All hooks can be customized with text, HTML, PHP, or shortcodes
* All actions can be selectively disabled
* A variety of actions already present in Flat, Thesis 1.8.x, and WordPress can be selectively disabled
* Hook visualization allows you to see exactly where each hook is fired on the front-end of your site
* New shortcodes
    * [email], for masking email addresses from some spam robots
    * [global], which makes use of custom fields on a draft page in order to provide a library of reusable strings
    * [php], an admin-only shortcode for including PHP code within posts
* Ability to disable _all_ shortcodes
* Display of `phpinfo()` in the admin panel
* Options management, including tools to upgrade from OpenHook 2 and to uninstall (delete) all OpenHook options

== Installation ==

After you have downloaded the file and extracted the `thesis-openhook/` directory from the archive...

1. Upload the entire `thesis-openhook/` directory to the `wp-content/plugins/` directory.
1. Activate the plugin through the Plugins menu in WordPress.
1. Visit Settings -> OpenHook and customize to your heart's content!

Alternatively, you can use WordPress' automatic plugin installer. Go ahead, it's easier!

== Upgrade Notice ==

= 4.1 =
This long-overdue update adds support for the Flat theme as well as any theme supporting Theme Hook Alliance hooks while also fixing a few bugs and cleaning things up a little! For Thesis 2 users, OpenBox should now function properly!

= 4.0 =
Now providing support for the theme Headway as well as adding several custom shortcodes! Numerous more minor changes have been made, so dive in and check 'em out!

= 3 =
OpenHook 3 provides a leaner, cleaner interface for managing your customizations. If you are upgrading from 2.x.x, be sure to FIRST upgrade your options via Settings -> OpenHook; otherwise, you may find your customizations have vanished!

== Screenshots ==

1. An example of one of the many hooks to which OpenHook provides access. This is one of WordPress'.
2. How the Headway theme page of OpenHook looks. There is a toggle on the General page to choose to view all pages at once.
3. A snapshot of the shortcodes page.
4. How OpenBox appears on Thesis' box management screen.
5. An example of OpenBox in action in Thesis' skin editor.

== Frequently Asked Questions ==

= How does OpenBox work in Thesis 2.1.x? =

First, ensure you have enabled OpenBox in the Thesis 2.1.x "boxes" screen (OpenBox should be checkmarked and you'll need to press the save button).

Second, visit the Thesis skin editor. Add instances of OpenBox from the boxes dropdown menu, and drag them into your skin template wherever you would like them to be. I recommend opening each instance of OpenBox (via the gear icon) and giving it a unique name so that they are not all "OpenBox."

Finally, once you have saved your template, return to the regular admin panel and visit Thesis' skin content page. On this page,  you'll be shown a list of all of the custom boxes, including OpenBoxes, you've added to your template, at which point you can edit them to your liking.

Yes, this is convoluted, and for that I apologize; fortunately, it isn't my fault.

= I upgraded from OpenHook 2.x.x; where did all of my customizations go? =

OpenHook 3 and newer does not automatically import pre-existing customizations. You will need to visit the OpenHook settings page accessible at Settings -> OpenHook; once there, you can use the "Upgrade from OpenHook 2" button to import your pre-existing customizations to the new schema. You'll then need to activate the Thesis & WordPress action groups as needed from the same settings page.

= I don't use one of the supported themes; can I still use this plugin? =

Of course! However, what you are able to do with OpenHook will be limited. Still, you will have access to WordPress' few public-facing hooks, the new shortcodes, and the `phpinfo()` panel.

= Where can I get the supported themes? =

* Flat can be downloaded via [the theme repository](http://wordpress.org/extend/themes/flat).
* Headway can be purchased at [Headway Themes](http://headwaythemes.com/).
* Thesis can be purchased at [DIYthemes](http://j.mp/GetThesis2).
* Themes which support the Theme Hook Alliance hooks are [listed at GitHub](https://github.com/zamoose/themehookalliance).

= What about the code in my theme's custom functions file? =

If you have already modified your theme's installation via `functions.php`, `custom_functions.php`, or some other file, you are welcome to port those changes into OpenHook to manage all of your changes in one place.

Note that your blog will use both your theme's custom functions and OpenHook, so the two are complementary.

Likewise, your theme's custom functions file will be processed *after* OpenHook, so you can override OpenHook via the custom functions file, if you need to.

= Why can't I edit my custom files with OpenHook? =

Prior to version 2.3, OpenHook provided panels for editing Thesis' custom CSS & custom functions files. Thesis now provides those features by default, and so there's no reason for OpenHook to provide the same thing.

= Why can only certain users on my site access OpenHook? =

Do to the powerful nature of OpenHook, access is restricted only to the highest level of users (i.e., those with the authority to edit files from within WordPress).

= What are the security risks involved in using OpenHook? =

OpenHook is a powerful tool for customizing your site; however, with great power comes, ahem, great responsibility. You are able to use any (ANY!) PHP code within your OpenHook-managed customizations; any other administrators on your site with access to OpenHook can do the same. The freedom allowed means that database credentials could be displayed, your database could be deleted, or your entire site could be defaced. Therefore, while OpenHook certainly can be dangerous, if you have only trusted administrators on your site, you have nothing to worry about.

== Changelog ==

= 4.1 =
* [added] Flat hooks
* [added] Theme Hook Alliance hooks
* [fixed] OpenBox is now compatible with Thesis 2.1.x
* [changed] Various text & links throughout OpenHook admin panel
* [changed] Optimized various bits of code, bringing it inline with WP coding standards

= 4.0.1 =
* [fixed] Fixed broken class calls in options management functions

= 4.0 =
* [added] Now supporting Headway theme hooks!
* [added] Shortcodes manager introduced!
* [added] Users can now choose whether all hook panels are displayed or just one at a time
* [added] PHP shortcode - Arbitrary PHP code in your posts! (Admin users only.)
* [added] Email shortcode - Encodes email addresses for use in posts to thrwart harvesters
* [added] Global shortcode - Take advantage of custom fields on a draft post to create a library of strings which may be used in any post
* [changed] Various code optimizations

= 3.4 =
* [added] OpenBox - a box added to Thesis 2's box management, allowing for arbitrary code in Thesis 2's skin editor
* [changed] OpenHook is now programmed as a class to allow its code to be self-contained. More code refinements will be coming
* [changed] Plugin is now named simply "OpenHook." Viva la simplicity!

= 3.3.1 =
* [fixed] thesis_hook_after_post_box restored. Hat tip: Doug Foster

= 3.3 =
* [added] Hook visualization (Based upon http://headwaythemes.com/headway-hooks-visualized/)
* [changed] Improved handling of the options management functions (upgrade/delete options)
* [changed] When action groups are disabled, the hook pages now include a nag stating as much
* [fixed] Warnings about empty arrays when activating action groups

= 3.2.1 =
* [fixed] Bumped to make the repository update

= 3.2 =
* [added] Hooks with customizations are marked with asterisks in the dropdown select box
* [changed] Add link to phpinfo() under Tools menu
* [changed] Verbiage for unhooking updated
* [fixed] Many undefined variable errors
* [fixed] Slashes are now properly stripped when upgrading from 2.x.x
* [fixed] Default Thesis 404 content can now be properly removed

= 3.1 =
* [fixed] Rare issue where the general settings panel doesn't fully appear

= 3 =
* [changed] Total rewrite of the plugin
* [added] phpinfo() panel
* [added] per-hook disabling of custom actions
* [added] option to process shortcodes on custom actions
* [added] ability to choose which actions to process (WordPress' or Thesis' or both's)
* [added] ability to remove all OpenHook options
* [removed] several deprecated options

= 2.3.2 =
* [fixed] Remember the typos fixed in 2.3.1? There were others I should have caught then. I'm a terrible proofreader, but thanks, Dean (http://www.doublejoggingstrollershq.com/), for catching them!

= 2.3.1 =
* [fixed] Fixed two stupid typos that killed everything that was right with the world. Well, they broke the plugin anyway. Thanks, Jim (http://doggybytes.ca/), for reporting so quickly!

= 2.3 =
* [added] Thesis 1.7's four new hooks are now included.
* [removed] OpenHook's file editing panels have been removed -- Thesis has these by default now.
* [changed] Readme.txt updated.

= 2.2.5 =
* [fixed] Reverted change introduced in 2.2.3 regarding stripping of slashes

= 2.2.4 =
* [fixed] Fixed a syntax error, reported by multiple users.

= 2.2.3 =
* [fixed] Fixed a bug which prevented the After Teasers Box hook from saving properly. Thanks, Michael Curving.
* [fixed] Fixed an issue where the file editors would strip slashes unnecessarily. Thanks, Kristarella.