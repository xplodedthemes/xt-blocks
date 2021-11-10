<?php
/**
 * Number Control.
 *
 * @package xtblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * XT_Blocks_Control_Number class.
 */
class XT_Blocks_Control_Number extends XT_Blocks_Control {
    /**
     * Constructor
     */
    public function __construct() {
        $this->name       = 'number';
        $this->icon       = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.99988 19.25H12.9999" stroke="currentColor" stroke-width="1.5"/><path d="M3.99988 15.25H19.9999" stroke="currentColor" stroke-width="1.5"/><path d="M3.87713 12H5.46449L8.48295 6.00213V4.72727H3.37997V5.98438H6.89205V6.03409L3.87713 12ZM10.0137 12H11.6011L14.6195 6.00213V4.72727H9.51655V5.98438H13.0286V6.03409L10.0137 12Z" fill="currentColor"/></svg>';
        $this->type       = 'number';
        $this->label      = __( 'Number', 'xt-blocks' );
        $this->attributes = array(
            'min'         => '',
            'max'         => '',
            'step'        => '',
            'placeholder' => '',
        );

        parent::__construct();
    }

    /**
     * Register assets action.
     */
    public function register_assets() {
        wp_register_script(
            'xtblocks-control-number',
            xtblocks()->plugin_url() . 'controls/number/script.min.js',
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
        return array( 'xtblocks-control-number' );
    }
}

new XT_Blocks_Control_Number();
