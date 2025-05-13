<?php
namespace WZPFIL;

defined('ABSPATH') || exit;

class WZPFIL_Post_Filterer_Shortcode {

    public function __construct() {
        add_shortcode('post_filterer', [$this, 'render_shortcode']);
    }

    public function render_shortcode($atts): string {
        $atts = shortcode_atts([
            'type'  => 'recent',
            'posts' => 5,
        ], $atts);

        $query_args = $this->get_query_args($atts['type'], (int)$atts['posts']);
        $query = new \WP_Query($query_args);

        if (!$query->have_posts()) {
            return '<p>No posts found.</p>';
        }

        $output = '<ul class="wzpfil-post-list">';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= sprintf(
                '<li><a href="%s">%s</a></li>',
                esc_url(get_permalink()),
                esc_html(get_the_title())
            );
        }
        wp_reset_postdata();
        $output .= '</ul>';

        return $output;
    }

    private function get_query_args(string $type, int $count): array {
        $args = [
            'post_type'      => 'post',
            'posts_per_page' => $count,
        ];

        switch ($type) {
            case 'popular':
                $args['meta_key'] = 'views';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'comments':
                $args['orderby'] = 'comment_count';
                $args['order'] = 'DESC';
                break;
            case 'recent':
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
        }

        return $args;
    }
}

new Post_Filterer_Shortcode();
