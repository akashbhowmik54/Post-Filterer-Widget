<?php
/**
 * Plugin Name: Post Filterer
 * Description: Filter posts in the widget area by recent, popular, or oldest.
 * Version: 1.0.0
 * Author: whizPlugins
 * Text Domain: post-filterer
 */

defined('ABSPATH') || exit;

// Define constants
define('PFTR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PFTR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PFTR_PLUGIN_VERSION', '1.0.0');

// Activation/Deactivation hooks
require_once PFTR_PLUGIN_PATH . 'includes/class-activator.php';
require_once PFTR_PLUGIN_PATH . 'includes/class-deactivator.php';

register_activation_hook(__FILE__, ['PFTR\PostFilterer\Activator', 'activate']);
register_deactivation_hook(__FILE__, ['PFTR\PostFilterer\Deactivator', 'deactivate']);

// Load the core plugin class
require_once PFTR_PLUGIN_PATH . 'includes/class-plugin.php';

use PFTR\PostFilterer\Plugin;

function pftr_run_plugin() {
    $plugin = new Plugin();
    $plugin->run();
}
pftr_run_plugin();
