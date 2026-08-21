<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class BK_Pattern_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'bk_pattern_widget',
            'باران خانومی — الگوی ذخیره‌شده',
            array(
                'description' => 'نمایش یک الگوی ذخیره‌شده Gutenberg داخل ناحیه ابزارک.',
            )
        );
    }

    private function get_patterns() {
        $patterns = array();

        // User-created synced patterns are stored as wp_block posts.
        $posts = get_posts( array(
            'post_type'      => 'wp_block',
            'post_status'    => 'publish',
            'posts_per_page' => 100,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );

        foreach ( $posts as $post ) {
            $patterns[ 'post:' . $post->ID ] = array(
                'title'   => $post->post_title,
                'content' => $post->post_content,
            );
        }

        // Also expose patterns registered by the theme/plugins.
        if ( function_exists( 'WP_Block_Patterns_Registry' ) ) {
            $registry = WP_Block_Patterns_Registry::get_instance();
            foreach ( $registry->get_all_registered() as $pattern ) {
                if ( empty( $pattern['name'] ) || empty( $pattern['content'] ) ) continue;
                $key = 'registered:' . $pattern['name'];
                if ( isset( $patterns[ $key ] ) ) continue;
                $patterns[ $key ] = array(
                    'title'   => ! empty( $pattern['title'] ) ? $pattern['title'] : $pattern['name'],
                    'content' => $pattern['content'],
                );
            }
        }

        return $patterns;
    }

    public function form( $instance ) {
        $selected = isset( $instance['pattern'] ) ? $instance['pattern'] : '';
        $patterns = $this->get_patterns();
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'pattern' ) ); ?>">الگوی موردنظر:</label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pattern' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pattern' ) ); ?>">
                <option value="">— انتخاب الگو —</option>
                <?php foreach ( $patterns as $key => $pattern ) : ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $selected, $key ); ?>><?php echo esc_html( $pattern['title'] ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php if ( empty( $patterns ) ) : ?>
            <p>هنوز الگوی ذخیره‌شده‌ای پیدا نشد. ابتدا الگو را از بخش الگوها ذخیره کنید.</p>
        <?php else : ?>
            <p class="description">الگوی ساخته‌شده در «الگوها» را انتخاب کنید؛ محتوای همان الگو در این ناحیه ابزارک نمایش داده می‌شود.</p>
        <?php endif; ?>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        return array(
            'pattern' => isset( $new_instance['pattern'] ) ? sanitize_text_field( $new_instance['pattern'] ) : '',
        );
    }

    public function widget( $args, $instance ) {
        $selected = isset( $instance['pattern'] ) ? $instance['pattern'] : '';
        if ( ! $selected ) return;

        $patterns = $this->get_patterns();
        if ( empty( $patterns[ $selected ]['content'] ) ) return;

        echo $args['before_widget'];
        echo do_blocks( $patterns[ $selected ]['content'] );
        echo $args['after_widget'];
    }
}

add_action( 'widgets_init', function() {
    register_widget( 'BK_Pattern_Widget' );
} );
