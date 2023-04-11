<?php
/**
 * GamiPress Progress Map Class
 *
 * @package     GamiPress\Progress_Map\Progress_Map_Render
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class GamiPress_Progress_Map_Render {

    /**
     * Progress map ID
     *
     * @var int
     */
    protected $progress_map_id = 0;

    /**
     * The progress map type
     *
     * Available options: specific-achievements, all-achievements, specific-ranks, all-ranks
     *
     * @var string
     */
    protected $type = '';

    /**
     * The progress map item type
     *
     * Available options: achievement, rank
     *
     * @var string
     */
    protected $item_type = '';

    /**
     * Array of arguments
     *
     * @var int
     */
    protected $args = array();

    protected $items = array();

    protected $first_incomplete = false;

    public function __construct( $progress_map_id = null, $args = array() ) {

        if( $progress_map_id === null )
            $progress_map_id = get_the_ID();

        $this->progress_map_id = $progress_map_id;

        $this->type = $this->get_post_meta( 'type', 'specific-achievements' );

        $this->args = wp_parse_args( $args, array(
            'user_id' => get_current_user_id(),
            'direction' => $this->get_post_meta( 'direction', 'vertical' ),
            'alignment' => $this->get_post_meta( 'alignment', 'left' ),
            'bar_color' => $this->get_post_meta( 'bar_color', '#0098d7' ),
            'bar_background_color' => $this->get_post_meta( 'bar_background_color', '#eeeeee' ),
            'mark_text_color' => $this->get_post_meta( 'mark_text_color', '#000000' ),
            'mark_background_color' => $this->get_post_meta( 'mark_background_color', '#eeeeee' ),
            'completed_mark_text_color' => $this->get_post_meta( 'completed_mark_text_color', '#ffffff' ),
            'completed_mark_background_color' => $this->get_post_meta( 'completed_mark_background_color', '#0098d7' ),
            'hide_upcoming_achievements' => $this->get_post_meta( 'hide_upcoming_achievements', false ) ? 'yes' : 'no',
        ) );
    }

    public function display() {

        if( gamipress_get_post_field( 'post_type', $this->progress_map_id ) !== 'progress-map' )
            return;

        // Setup items
        $this->prepare_items();

        if( empty( $this->items ) )
            return;

        // Setup achievements template args
        $template_args = array(
            'user_id' => $this->args['user_id']
        );

        if( $this->item_type === 'achievement' ) {

            // Setup the template args for gamipress_render_achievement()
            $shortcode_fields = GamiPress()->shortcodes['gamipress_achievement']->fields;

            // Remove achievement id field
            unset( $shortcode_fields['id'] );

            foreach( $shortcode_fields as $field_id => $field_args ) {

                if( $field_args['type'] === 'checkbox' ) {
                    $template_args[$field_id] = ( (bool) $this->get_post_meta( $field_id, false ) ) ? 'yes' : 'no';
                } else {
                    $template_args[$field_id] = $this->get_post_meta( $field_id, isset( $field_args['default'] ) ? $field_args['default'] : '' );
                }

            }

        } else if( $this->item_type === 'rank' ) {

            // Setup the template args for gamipress_render_rank()
            $shortcode_fields = GamiPress()->shortcodes['gamipress_rank']->fields;

            // Remove rank id field
            unset( $shortcode_fields['id'] );

            foreach( $shortcode_fields as $field_id => $field_args ) {

                // Need to add prefix 'rank_' to avoid issues with achievement fields
                if( $field_args['type'] === 'checkbox' ) {
                    $template_args[$field_id] = ( (bool) $this->get_post_meta( 'rank_' . $field_id, false ) ) ? 'yes' : 'no';
                } else {
                    $template_args[$field_id] = $this->get_post_meta( 'rank_' . $field_id, isset( $field_args['default'] ) ? $field_args['default'] : '' );
                }

            }
        }

        $classes = $this->get_classes();

        ?>
        <div id="gamipress-progress-map-<?php echo $this->progress_map_id; ?>" class="<?php echo implode(' ', $classes); ?>">

            <div class="gamipress-progress-map-bar" style="background-color: <?php echo $this->args['bar_background_color']; ?>;"></div>
            <div class="gamipress-progress-map-completed-bar" style="background-color: <?php echo $this->args['bar_color']; ?>;"></div>

            <?php foreach( $this->items as $index => $item_id ) :

                // Ensure int ID
                $item_id = absint( $item_id );

                // Check if user has earned this item
                $earned = count( gamipress_get_user_achievements( array(
                        'user_id' => $this->args['user_id'],
                        'achievement_id' => $item_id
                    ) ) ) > 0;

                if( $this->item_type === 'rank' && gamipress_is_lowest_priority_rank( $item_id ) )
                    $earned = true;

                $item_classes = array(
                    'gamipress-progress-map-item',
                    'gamipress-progress-map-' . ( ( $earned ) ? 'completed' : 'incompleted' )
                );

                if( ! $this->first_incomplete && ! $earned )
                    $item_classes[] = 'gamipress-progress-map-item-current';
                ?>

                <div id="gamipress-progress-map-item-<?php echo $item_id; ?>" class="<?php echo implode( ' ', $item_classes ); ?>">

                    <?php $this->render_mark( $index, $item_id, $earned, $template_args ); ?>

                    <?php $this->render_item( $index, $item_id, $earned, $template_args ); ?>

                </div>

                <?php if( ! $earned ) :
                    $this->first_incomplete = true;
                endif; ?>

            <?php endforeach; ?>

        </div>
        <?php

    }

    /**
     * Prepare the progress map items based on settings
     */
    private function prepare_items() {

        global $wpdb;

        $items = array();
        $posts = GamiPress()->db->posts;

        switch( $this->type ) {
            case 'specific-achievements':
                // Get an array of specific achievements
                $achievements = $this->get_post_meta( 'achievements', array(), false );

                if( is_array( $achievements ) ) {
                    $items = $achievements;
                }

                $this->item_type = 'achievement';
                break;
            case 'all-achievements':
                // Get an array of all achievements by type
                $achievement_type = $this->get_post_meta( 'achievement_type', '' );

                $items = $wpdb->get_col( $wpdb->prepare(
                    "SELECT p.ID
                    FROM {$posts} AS p
                    WHERE p.post_type = %s
                      AND p.post_status = %s
                    ORDER BY p.post_date DESC", // We need to reverse the order
                    $achievement_type,
                    'publish'
                ) );

                $this->item_type = 'achievement';
                break;
            case 'specific-ranks':
                // Get an array of specific ranks
                $ranks = $this->get_post_meta( 'ranks', array(), false );

                if( is_array( $ranks ) ) {
                    $items = $ranks;
                }

                $this->item_type = 'rank';
                break;
            case 'all-ranks':
                // Get an array of all ranks by type
                $rank_type = $this->get_post_meta( 'rank_type', '' );

                $items = $wpdb->get_col( $wpdb->prepare(
                    "SELECT p.ID
                    FROM {$posts} AS p
                    WHERE p.post_type = %s
                      AND p.post_status = %s
                    ORDER BY p.menu_order ASC", // We need to reverse the order
                    $rank_type,
                    'publish'
                ) );

                $this->item_type = 'rank';
                break;
        }

        // Assign our items
        $this->items = $items;

    }

    /**
     * Get the progress map classes
     *
     * @return array
     */
    public function get_classes() {

        $classes = array(
            'gamipress-progress-map-render',
            'gamipress-progress-map-' . $this->args['direction'],
            'gamipress-progress-map-' . $this->args['alignment'],
            'gamipress-progress-map-' . $this->type,
            'gamipress-progress-map-' . $this->item_type . 's',
        );

        // Only add drag scroll on horizontal progress maps
        if( $this->args['direction'] === 'horizontal' ) {
            $classes[] = 'dragscroll';
        }

        return $classes;
    }

    /**
     * Render progress map item mark
     *
     * @param integer   $index              The current index
     * @param integer   $item_id            The item ID
     * @param boolean   $earned             If achievement has been earned
     * @param array     $template_args      Template arguments
     */
    public function render_mark( $index, $item_id, $earned, $template_args ) {

        $mark_text_color = $earned ? $this->args['completed_mark_text_color'] : $this->args['mark_text_color'];
        $mark_background_color = $earned ? $this->args['completed_mark_background_color'] : $this->args['mark_background_color'];

        ?>

        <?php
        /**
         * Before progress map marker
         *
         * @param $index            integer                         The current index
         * @param $item_id          integer                         The item ID
         * @param $earned           boolean                         If achievement has been earned
         * @param $template_args    array                           Template arguments
         * @param $this             GamiPress_Progress_Map_Render
         */
        do_action( 'gamipress_before_progress_map_marker', $index, $item_id, $earned, $template_args, $this ); ?>

        <div class="gamipress-progress-map-mark" style="color: <?php echo $mark_text_color; ?>; background-color: <?php echo $mark_background_color; ?>;">

            <div class="gamipress-progress-map-mark-label"><?php echo $index + 1; ?></div>

        </div>

        <?php
        /**
         * After progress map marker
         *
         * @param $index            integer                         The current index
         * @param $achievement_id   integer                         The achievement ID
         * @param $earned           boolean                         If achievement has been earned
         * @param $template_args    array                           Template arguments
         * @param $this             GamiPress_Progress_Map_Render
         */
        do_action( 'gamipress_after_progress_map_marker', $index, $item_id, $earned, $template_args, $this ); ?>

        <?php
    }

    /**
     * Render progress map item
     *
     * @param integer   $index              The current index
     * @param integer   $item_id            The item ID
     * @param boolean   $earned             If achievement has been earned
     * @param array     $template_args      Template arguments
     */
    public function render_item( $index, $item_id, $earned, $template_args ) {

        ?>

        <?php if( $this->first_incomplete && $this->args['hide_upcoming_achievements'] === 'yes' && ! $earned ) : ?>
            <?php gamipress_progress_map_enable_unknown_items(); ?>
        <?php endif; ?>

        <div class="gamipress-progress-map-item-content gamipress-progress-map-<?php echo $this->item_type; ?>">

            <?php
            /**
             * Before progress map item
             *
             * @param $index            integer                         The current index
             * @param $achievement_id   integer                         The achievement ID
             * @param $earned           boolean                         If achievement has been earned
             * @param $template_args    array                           Template arguments
             * @param $this             GamiPress_Progress_Map_Render
             */
            do_action( "gamipress_before_progress_map_{$this->item_type}", $index, $item_id, $earned, $template_args, $this ); ?>

            <?php

            if( $this->item_type === 'achievement' ) {
                // Render the achievement
                echo gamipress_render_achievement( $item_id, $template_args );
            } else if( $this->item_type === 'rank' ) {
                // Render the rank
                echo gamipress_render_rank( $item_id, $template_args );
            }

            ?>

            <?php
            /**
             * After progress map item
             *
             * @param $index            integer                         The current index
             * @param $achievement_id   integer                         The achievement ID
             * @param $earned           boolean                         If achievement has been earned
             * @param $template_args    array                           Template arguments
             * @param $this             GamiPress_Progress_Map_Render
             */
            do_action( "gamipress_after_progress_map_{$this->item_type}", $index, $item_id, $earned, $template_args, $this ); ?>

        </div>

        <?php if( $this->first_incomplete && $this->args['hide_upcoming_achievements'] === 'yes' && ! $earned ) : ?>
            <?php gamipress_progress_map_disable_unknown_items(); ?>
        <?php endif; ?>

        <?php
    }

    /**
     * Helper function to easily get progress map meta field value
     *
     * @since 1.0.0
     *
     * @param string   $meta_key        The meta key to retrieve.
     * @param mixed    $default         Default value to return.
     * @param bool     $single          Optional. Whether to return a single value.
     *
     * @return mixed
     */
    private function get_post_meta( $meta_key, $default = '', $single = true ) {
        $prefix = '_gamipress_progress_map_';

        $value = gamipress_get_post_meta( $this->progress_map_id, $prefix . $meta_key, $single );

        return $value ? $value : $default;
    }

}