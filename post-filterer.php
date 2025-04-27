<?php
/**
 * Plugin Name: Benariz Filter Posts
 * Description: Displays a list of recent or popular posts with an image, date, and reading time.
 * Version: 1.0
 * Author: Akash Kumar Bhowmik
 * Text Domain: nobo-core
 */
// add_filter( 'use_widgets_block_editor', '__return_false' );

// Register the widget
add_action('widgets_init', function() {
    register_widget('Benariz_Filter_Post');
});

// Widget Class
if( !class_exists('Benariz_Filter_Post') ) {
    class Benariz_Filter_Post extends WP_Widget {
        public function __construct() {
            parent::__construct(
                'benariz_filter_posts_widget',
                esc_html__( 'SZ Filter Posts', 'nobo-core' ),
                array( 'description' => esc_html__( 'Displays a list of recent or popular posts', 'nobo-core' ) )
            );
        }

        public function widget( $args, $instance ) {
            echo $args['before_widget'];

            $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Filter Posts', 'nobo-core' );
            $num_posts = ! empty( $instance['num_posts'] ) ? absint( $instance['num_posts'] ) : 3;
            $post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : 'recent';

            if ( $post_type === 'popular' ) {
                $query_args = array(
                    'posts_per_page' => $num_posts,
                    'post_status'    => 'publish',
                    'meta_key'       => 'views',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                );
            } else {
                $query_args = array(
                    'posts_per_page' => $num_posts,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );
            }

            $custom_query = new WP_Query( $query_args );

            if ( $custom_query->have_posts() ) {
                echo '<div class="blog__recent-post content-wrapper" id="blog__recent-post">';
                echo '<div class="categories__heading"><h3 class="widget-title heading-title">' . esc_html( $title ) . '</h3></div>';
                echo '<ul>';

                while ( $custom_query->have_posts() ) {
                    $custom_query->the_post();

                    $post_thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : get_template_directory_uri() . '/assets/img/blog/recent_img01.png';
                    $post_title     = get_the_title();
                    $trimmed_title  = $this->benariz_trim_title($post_title, 40);
                    $post_url       = get_permalink();
                    $post_date      = get_the_date( 'd F, Y' );
                    $word_count     = str_word_count( wp_strip_all_tags( get_the_content() ) );
                    $reading_time   = ceil( $word_count / 200 );

                    echo '<li class="recent__post-wrapper">
                            <div class="row">
                                <div class="col-xxl-3 col-xl-4 col-lg-12 col-md-2 col-sm-2">
                                    <div class="recent__img">
                                        <a href="' . esc_url( $post_url ) . '">
                                            <img src="' . esc_url( $post_thumbnail ) . '" alt="recent image">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xxl-9 col-xl-8 col-lg-12 col-md-10 col-sm-10 recent__content-wrapper">
                                    <div class="recent__content">
                                        <a href="' . esc_url( $post_url ) . '">
                                            <h5>' . esc_html( $trimmed_title ) . '</h5>
                                        </a>
                                        <div class="blog__author">
                                            <img src="' . esc_url(get_template_directory_uri()) . '/assets/img/blog/blog-icon/Vector.png" alt="blog-icon">
                                            <a href=" ' . esc_url(get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'))) . '">
                                                <span>' . esc_html( $post_date ) . '</span>
                                            </a>
                                            <span class="ml-20">' . esc_html( $reading_time ) . ' min read</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>';
                }

                echo '</ul></div>';
            }

            wp_reset_postdata();
            echo $args['after_widget'];
        }

        private function benariz_trim_title($title, $max_length) {
            if (mb_strlen($title) > $max_length) {
                return mb_substr($title, 0, $max_length) . '..';
            }
            return $title;
        }

        public function form( $instance ) {
            $title     = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Filter Posts', 'nobo-core' );
            $num_posts = ! empty( $instance['num_posts'] ) ? absint( $instance['num_posts'] ) : 3;
            $post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : 'recent';
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'nobo-core' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'num_posts' ) ); ?>"><?php esc_attr_e( 'Number of posts to show:', 'nobo-core' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'num_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'num_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $num_posts ); ?>" min="1" max="10">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_attr_e( 'Select Post Type:', 'nobo-core' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
                    <option value="recent" <?php selected( $post_type, 'recent' ); ?>><?php esc_attr_e( 'Recent Posts', 'nobo-core' ); ?></option>
                    <option value="popular" <?php selected( $post_type, 'popular' ); ?>><?php esc_attr_e( 'Popular Posts', 'nobo-core' ); ?></option>
                </select>
            </p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['num_posts'] = ( ! empty( $new_instance['num_posts'] ) ) ? absint( $new_instance['num_posts'] ) : 3;
            $instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? sanitize_text_field( $new_instance['post_type'] ) : 'recent';
            return $instance;
        }
    }
}
