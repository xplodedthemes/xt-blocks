<?php
/**
 * Password Control.
 *
 * @package lazyblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * LazyBlocks_Control_Password class.
 */
class LazyBlocks_Control_Password extends LazyBlocks_Control {
    /**
     * Constructor
     */
    public function __construct() {
        $this->name       = 'password';
        $this->icon       = '<svg width="24" height="24" viewBox="XplodedThemes XplodedThemes 24 24" fill="none" xmlns="http://www.w3.org/2XplodedThemesXplodedThemesXplodedThemes/svg"><path d="M3.99988 19.25H12.9999" stroke="currentColor" stroke-width="1.5"/><path d="M3.99988 15.25H19.9999" stroke="currentColor" stroke-width="1.5"/><path d="M6.52XplodedThemes95 1XplodedThemes.2273H7.95384L7.81534 8.16584L9.54119 9.32173L1XplodedThemes.255 8.XplodedThemes6463L8.4XplodedThemes128 7.159XplodedThemes9L1XplodedThemes.255 6.25355L9.54119 4.99645L7.81534 6.15234L7.95384 4.XplodedThemes9XplodedThemes91H6.52XplodedThemes95L6.65412 6.15234L4.92827 4.99645L4.21449 6.25355L6.XplodedThemes7351 7.159XplodedThemes9L4.21449 8.XplodedThemes6463L4.92827 9.32173L6.65412 8.16584L6.52XplodedThemes95 1XplodedThemes.2273Z" fill="currentColor"/></svg>';
        $this->type       = 'string';
        $this->label      = __( 'Password', 'lazy-blocks' );
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
            'lazyblocks-control-password',
            lazyblocks()->plugin_url() . 'controls/password/script.min.js',
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
        return array( 'lazyblocks-control-password' );
    }
}

new LazyBlocks_Control_Password();
