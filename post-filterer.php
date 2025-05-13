<?php
/**
 * Plugin Name: Post Filterer
 * Description: Filter posts by view count, recent, or most commented. Supports widget and shortcode.
 * Version: 1.0
 * Author: WhizPlugin
 * Text Domain: post-filterer
 */

defined('ABSPATH') || exit;

define('WZPFIL_PATH', plugin_dir_path(__FILE__));
define('WZPFIL_URL', plugin_dir_url(__FILE__));

require_once WZPFIL_PATH . 'includes/class-post-filterer.php';

function wzpfil_init_plugin() {
    \WZPFIL\Post_Filterer_Plugin::get_instance();
}
add_action('plugins_loaded', 'wzpfil_init_plugin');
