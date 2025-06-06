<?php
namespace WZPFIL;

defined('ABSPATH') || exit;

class WZPFIL_Post_Filterer_Plugin {

    private static $instance = null;

    private function __construct() {
        require_once WZPFIL_PATH . 'includes/class-post-filterer-shortcode.php';
        require_once WZPFIL_PATH . 'includes/class-post-filterer-widget.php';
        require_once WZPFIL_PATH . 'includes/functions.php';

        add_action('widgets_init', [$this, 'register_widget']);
    }

    public static function get_instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register_widget(): void {
        register_widget(WZPFIL_Post_Filterer_Widget::class);
    }
}
