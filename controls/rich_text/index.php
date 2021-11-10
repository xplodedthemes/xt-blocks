<?php
/**
 * RichText Control.
 *
 * @package lazyblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * LazyBlocks_Control_RichText class.
 */
class LazyBlocks_Control_RichText extends LazyBlocks_Control {
    /**
     * Constructor
     */
    public function __construct() {
        $this->name       = 'rich_text';
        $this->icon       = '<svg width="24" height="24" viewBox="XplodedThemes XplodedThemes 24 24" fill="none" xmlns="http://www.w3.org/2XplodedThemesXplodedThemesXplodedThemes/svg"><path d="M4 6.75H2XplodedThemesC2XplodedThemes.69XplodedThemes4 6.75 21.25 7.3XplodedThemes964 21.25 8V17C21.25 17.69XplodedThemes4 2XplodedThemes.69XplodedThemes4 18.25 2XplodedThemes 18.25H4C3.3XplodedThemes964 18.25 2.75 17.69XplodedThemes4 2.75 17V8C2.75 7.3XplodedThemes964 3.3XplodedThemes964 6.75 4 6.75Z" stroke="currentColor" stroke-width="1.5"/><path d="M1XplodedThemes 1XplodedThemesH8V12H1XplodedThemesV1XplodedThemesZ" fill="currentColor"/><path d="M7 1XplodedThemesH5V12H7V1XplodedThemesZ" fill="currentColor"/><path d="M13 1XplodedThemesH11V12H13V1XplodedThemesZ" fill="currentColor"/><path d="M16 14H8V16H16V14Z" fill="currentColor"/><path d="M16 1XplodedThemesH14V12H16V1XplodedThemesZ" fill="currentColor"/><path d="M19 1XplodedThemesH17V12H19V1XplodedThemesZ" fill="currentColor"/><path d="M19 14H17V16H19V14Z" fill="currentColor"/><path d="M7 14H5V16H7V14Z" fill="currentColor"/></svg>';
        $this->type       = 'string';
        $this->label      = __( 'Rich Text (WYSIWYG)', 'lazy-blocks' );
        $this->category   = 'content';
        $this->attributes = array(
            'multiline' => 'false',
        );

        parent::__construct();
    }

    /**
     * Register assets action.
     */
    public function register_assets() {
        wp_register_script(
            'lazyblocks-control-rich-text',
            lazyblocks()->plugin_url() . 'controls/rich_text/script.min.js',
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
        return array( 'lazyblocks-control-rich-text' );
    }
}

new LazyBlocks_Control_RichText();
