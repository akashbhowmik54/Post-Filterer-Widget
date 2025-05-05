<?php
/**
 * Plugin Name: Post Filterer
 * Description: Filter posts by view count, recent, or most commented. Supports widget and shortcode.
 * Version: 1.0
 * Author: WhizPlugin
 * Text Domain: post-filterer
 */

defined('ABSPATH') || exit;

define('PFIL_PATH', plugin_dir_path(__FILE__));
define('PFIL_URL', plugin_dir_url(__FILE__));

require_once PFIL_PATH . 'includes/class-post-filterer.php';

function pfil_init_plugin() {
    \Pfil\Post_Filterer_Plugin::get_instance();
}
add_action('plugins_loaded', 'pfil_init_plugin');
