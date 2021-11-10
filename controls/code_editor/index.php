<?php
/**
 * CodeEditor Control.
 *
 * @package lazyblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * LazyBlocks_Control_CodeEditor class.
 */
class LazyBlocks_Control_CodeEditor extends LazyBlocks_Control {
    /**
     * Constructor
     */
    public function __construct() {
        $this->name         = 'code_editor';
        $this->icon         = '<svg width="24" height="24" viewBox="XplodedThemes XplodedThemes 24 24" fill="none" xmlns="http://www.w3.org/2XplodedThemesXplodedThemesXplodedThemes/svg"><path d="M6 4.75H18C18.69XplodedThemes4 4.75 19.25 5.3XplodedThemes964 19.25 6V18C19.25 18.69XplodedThemes4 18.69XplodedThemes4 19.25 18 19.25H6C5.3XplodedThemes964 19.25 4.75 18.69XplodedThemes4 4.75 18V6C4.75 5.3XplodedThemes964 5.3XplodedThemes964 4.75 6 4.75Z" stroke="currentColor" stroke-width="1.5"/><path d="M13 15H7V16.5H13V15Z" fill="currentColor"/><path d="M17 11H11V12.5H17V11Z" fill="currentColor"/><path d="M9 11H7V12.5H9V11Z" fill="currentColor"/><path d="M17 15H15V16.5H17V15Z" fill="currentColor"/></svg>';
        $this->type         = 'string';
        $this->label        = __( 'Code Editor', 'lazy-blocks' );
        $this->category     = 'content';
        $this->restrictions = array(
            'default_settings' => false,
        );

        parent::__construct();
    }

    /**
     * Register assets action.
     */
    public function register_assets() {
        wp_register_script(
            'lazyblocks-control-code-editor',
            lazyblocks()->plugin_url() . 'controls/code_editor/script.min.js',
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
        return array( 'lazyblocks-control-code-editor' );
    }
}

new LazyBlocks_Control_CodeEditor();
