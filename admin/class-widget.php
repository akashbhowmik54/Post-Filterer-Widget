<?php
namespace PFTR\PostFilterer\Admin;

use WP_Widget;
use PFTR\PostFilterer\Public\QueryHandler;

defined('ABSPATH') || exit;

class Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'pftr_post_filter_widget',
            __('Post Filterer', 'post-filterer'),
            ['description' => __('Display recent, popular, or oldest posts.', 'post-filterer')]
        );
    }

    public function widget($args, $instance): void {
        $type = $instance['type'] ?? 'recent';

        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
        }

        $posts = QueryHandler::get_posts($type);
        if (!empty($posts)) {
            echo '<ul class="pftr-post-list">';
            foreach ($posts as $post) {
                printf('<li><a href="%s">%s</a></li>',
                    esc_url(get_permalink($post)),
                    esc_html(get_the_title($post))
                );
            }
            echo '</ul>';
        } else {
            echo '<p>' . esc_html__('No posts found.', 'post-filterer') . '</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance): void {
        $title = $instance['title'] ?? __('Filtered Posts', 'post-filterer');
        $type = $instance['type'] ?? 'recent';
        ?>
        <p>
            <label><?= esc_html__('Title:', 'post-filterer'); ?></label>
            <input class="widefat" name="<?= esc_attr($this->get_field_name('title')); ?>" type="text" value="<?= esc_attr($title); ?>">
        </p>
        <p>
            <label><?= esc_html__('Filter Type:', 'post-filterer'); ?></label>
            <select class="widefat" name="<?= esc_attr($this->get_field_name('type')); ?>">
                <option value="recent" <?= selected($type, 'recent', false); ?>><?= esc_html__('Recent', 'post-filterer'); ?></option>
                <option value="popular" <?= selected($type, 'popular', false); ?>><?= esc_html__('Popular', 'post-filterer'); ?></option>
                <option value="oldest" <?= selected($type, 'oldest', false); ?>><?= esc_html__('Oldest', 'post-filterer'); ?></option>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array {
        return [
            'title' => sanitize_text_field($new_instance['title']),
            'type' => sanitize_text_field($new_instance['type']),
        ];
    }
}
