<?php
/**
 * Textarea Control.
 *
 * @package xtblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * XT_Blocks_Control_TextArea class.
 */
class XT_Blocks_Control_TextArea extends XT_Blocks_Control {
    /**
     * Constructor
     */
    public function __construct() {
        $this->name       = 'textarea';
        $this->icon       = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19.2501H20" stroke="currentColor" stroke-width="1.5"/><path d="M4 14.4167H20" stroke="currentColor" stroke-width="1.5"/><path d="M4 9.58337H20" stroke="currentColor" stroke-width="1.5"/><path d="M4 4.75H16" stroke="currentColor" stroke-width="1.5"/></svg>';
        $this->type       = 'string';
        $this->label      = __( 'Text Area', 'xt-blocks' );
        $this->attributes = array(
            'placeholder'      => '',
            'characters_limit' => '',
        );

        parent::__construct();
    }

    /**
     * Register assets action.
     */
    public function register_assets() {
        wp_register_script(
            'xtblocks-control-textarea',
            xtblocks()->plugin_url() . 'controls/textarea/script.min.js',
            array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ),
            '2.5.1',
            true
        );
    }

    /**
     * Get script dependencies.
     *
     * @return array script dependencies.
     */
    public function get_script_depends() {
        return array( 'xtblocks-control-textarea' );
    }
}

new XT_Blocks_Control_TextArea();
