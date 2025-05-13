<?php
defined('ABSPATH') || exit;

function wzpfil_track_post_views() {
    if (is_single()) {
        global $post;

        $views = (int) get_post_meta($post->ID, 'views', true);
        $views++;
        update_post_meta($post->ID, 'views', $views);
    }
}
add_action('wp_head', 'wzpfil_track_post_views');
