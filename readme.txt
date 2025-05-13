=== Post Filterer ===
Contributors: whizplugins, eleaswp, akash054, almumeetu, hazrathali  
Tags: posts, shortcode, widget, filter, popular posts, recent posts, most commented    
Requires at least: 5.0  
Tested up to: 6.8  
Requires PHP: 7.0  
Stable tag: 1.0.0  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Filter and display WordPress posts based on view count, recency, or number of comments. Includes both a widget and shortcode for flexibility.

== Description ==

**Post Filterer** allows you to display filtered lists of posts using either a widget or a shortcode. You can filter posts by:

- Recent posts  
- Popular posts (based on view count stored in custom field `views`)  
- Most commented posts  

**Features:**
- Widget support (with title, filter type, and number of posts)
- Shortcode support: `[post_filterer type="popular" posts="5"]`
- Lightweight and easy to use
- Developer-friendly (uses namespaced PHP classes)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/post-filterer` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the **Post Filterer Widget** from the Appearance > Widgets screen.
4. Or use the shortcode `[post_filterer type="recent" posts="5"]` inside any post, page, or template.

== Frequently Asked Questions ==

= What filter types are supported? =  
You can choose from:
- `recent`: Latest posts
- `popular`: Posts with the highest `views` meta key
- `comments`: Posts with the most comments

= Where does the view count come from? =  
You need a plugin or custom code to store post views in a custom field named `views`.

= Can I style the list? =  
Yes. The output is wrapped in a `<ul>` with class `wzpfil-post-list`. You can style it using custom CSS.

== Changelog ==

= 1.0 =
* Initial release with shortcode and widget support.

== Upgrade Notice ==

= 1.0 =
First release – no upgrade needed.

== Screenshots ==

1. Widget configuration
2. Shortcode output on the front end

