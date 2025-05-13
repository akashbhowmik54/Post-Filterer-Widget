<?php
namespace WZPFIL;

use WP_Widget;

defined('ABSPATH') || exit;

class Post_Filterer_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'pfil_widget',
            __('Post Filterer', 'post-filterer'),
            ['description' => __('Filter posts by type.', 'post-filterer')]
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
        }

        $type = $instance['type'] ?? 'recent';
        $posts = $instance['posts'] ?? 5;

        echo do_shortcode("[post_filterer type='{$type}' posts='{$posts}']");

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = $instance['title'] ?? __('Filtered Posts', 'post-filterer');
        $type = $instance['type'] ?? 'recent';
        $posts = $instance['posts'] ?? 5;
        ?>
        <p>
            <label for="<?= $this->get_field_id('title'); ?>"><?= __('Title:', 'post-filterer'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('title'); ?>"
                   name="<?= $this->get_field_name('title'); ?>" type="text"
                   value="<?= esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?= $this->get_field_id('type'); ?>"><?= __('Filter Type:', 'post-filterer'); ?></label>
            <select id="<?= $this->get_field_id('type'); ?>"
                    name="<?= $this->get_field_name('type'); ?>" class="widefat">
                <option value="recent" <?= selected($type, 'recent'); ?>>Recent</option>
                <option value="popular" <?= selected($type, 'popular'); ?>>Popular</option>
                <option value="comments" <?= selected($type, 'comments'); ?>>Most Commented</option>
            </select>
        </p>
        <p>
            <label for="<?= $this->get_field_id('posts'); ?>"><?= __('Number of posts:', 'post-filterer'); ?></label>
            <input class="tiny-text" id="<?= $this->get_field_id('posts'); ?>"
                   name="<?= $this->get_field_name('posts'); ?>" type="number"
                   value="<?= esc_attr($posts); ?>" step="1" min="1">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array {
        return [
            'title' => sanitize_text_field($new_instance['title']),
            'type' => sanitize_text_field($new_instance['type']),
            'posts' => absint($new_instance['posts']),
        ];
    }
}
