<?php
namespace PFTR\PostFilterer\Public;

defined('ABSPATH') || exit;

class QueryHandler {

    public static function get_posts(string $type = 'recent'): array {
        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        switch ($type) {
            case 'popular':
                $args['orderby'] = 'comment_count';
                break;
            case 'oldest':
                $args['order'] = 'ASC';
                break;
        }

        $query = new \WP_Query($args);
        return $query->have_posts() ? $query->posts : [];
    }
}
