<?php
/**
 * XT_Blocks controls.
 *
 * @package xtblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * XT_Blocks_Controls class. Class to work with XT_Blocks Controls.
 */
class XT_Blocks_Controls {
    /**
     * XT_Blocks_Controls constructor.
     */
    public function __construct() {
        $this->include_controls();
    }

    /**
     * Get all controls.
     *
     * @return array
     */
    public function get_controls() {
        return apply_filters( 'xtb/controls/all', array() );
    }

    /**
     * Get all controls categories.
     *
     * @return array
     */
    public function get_controls_categories() {
        return apply_filters(
            'xtb/controls/categories',
            array(
                'basic'    => __( 'Basic', 'xt-blocks' ),
                'content'  => __( 'Content', 'xt-blocks' ),
                'choice'   => __( 'Choice', 'xt-blocks' ),
                'advanced' => __( 'Advanced', 'xt-blocks' ),
                'layout'   => __( 'Layout', 'xt-blocks' ),
            )
        );
    }

    /**
     * Include controls.
     */
    private function include_controls() {
        // Sort.
        $sort = array(
            '_base',

            // Basic.
            'text',
            'textarea',
            'number',
            'range',
            'url',
            'email',
            'password',

            // Content.
            'image',
            'gallery',
            'file',
            'rich_text',
            'classic_editor',
            'code_editor',
            'inner_blocks',

            // Choice.
            'select',
            'radio',
            'checkbox',
            'toggle',

            // Advanced.
            'color',
            'date_time',

            // Layout.
            'repeater',
        );

        $all_controls = glob( dirname( dirname( __FILE__ ) ) . '/controls/*/index.php' );

        // include sorted controls.
        foreach ( $sort as $file_name ) {
            foreach ( $all_controls as $k => $file_path ) {
                if ( $this->ends_with( $file_path, '/' . $file_name . '/index.php' ) ) {
                    require_once $file_path;
                    unset( $all_controls[ $k ] );
                }
            }
        }

        // include remaining controls.
        foreach ( $all_controls as $file ) {
            require_once $file;
        }
    }

    /**
     * Ends With Function
     *
     * @param string $haystack - string to check.
     * @param string $needle - needle string.
     *
     * @return boolean
     */
    private function ends_with( $haystack, $needle ) {
        return substr_compare( $haystack, $needle, -strlen( $needle ) ) === 0;
    }
}
