<?php
namespace PFTR\PostFilterer;

defined('ABSPATH') || exit;

final class Plugin {

    public function run(): void {
        $this->load_dependencies();
        $this->init_hooks();
    }

    private function load_dependencies(): void {
        require_once PFTR_PLUGIN_PATH . 'admin/class-widget.php';
        require_once PFTR_PLUGIN_PATH . 'public/class-query-handler.php';
    }

    private function init_hooks(): void {
        add_action('widgets_init', function () {
            register_widget(\PFTR\PostFilterer\Admin\Widget::class);
        });
    }
}
