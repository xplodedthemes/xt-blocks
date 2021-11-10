<?php
/**
 * File Control.
 *
 * @package xtblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * XT_Blocks_Control_File class.
 */
class XT_Blocks_Control_File extends XT_Blocks_Control {
    /**
     * Constructor
     */
    public function __construct() {
        $this->name         = 'file';
        $this->icon         = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.1979 7.75L11.2111 5.77639C11.1264 5.607 10.9533 5.5 10.7639 5.5H5C4.72386 5.5 4.5 5.72386 4.5 6V17.75C4.5 18.0261 4.72386 18.25 5 18.25H19C19.2761 18.25 19.5 18.0261 19.5 17.75V8.25C19.5 7.97386 19.2761 7.75 19 7.75H12.1979ZM13.125 6.25L12.5528 5.10557C12.214 4.428 11.5215 4 10.7639 4H5C3.89543 4 3 4.89543 3 6V17.75C3 18.8546 3.89543 19.75 5 19.75H19C20.1046 19.75 21 18.8546 21 17.75V8.25C21 7.14543 20.1046 6.25 19 6.25H13.125Z" fill="currentColor"/></svg>';
        $this->type         = 'string';
        $this->label        = __( 'File', 'xt-blocks' );
        $this->category     = 'content';
        $this->restrictions = array(
            'default_settings' => false,
        );
        $this->attributes   = array(
            'allowed_mime_types' => array(),
        );

        // Filters.
        add_filter( 'xtb/block_render/attributes', array( $this, 'filter_xtb_block_render_attributes' ), 10, 3 );
        add_filter( 'xtb/get_meta', array( $this, 'filter_get_xtb_meta_json' ), 10, 4 );

        parent::__construct();
    }

    /**
     * Register assets action.
     */
    public function register_assets() {
        wp_register_script(
            'xtblocks-control-file',
            xtblocks()->plugin_url() . 'controls/file/script.min.js',
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
        return array( 'xtblocks-control-file' );
    }

    /**
     * Change block render attribute to array.
     *
     * @param string $attributes - block attributes.
     * @param mixed  $content - block content.
     * @param mixed  $block - block data.
     *
     * @return array filtered attribute data.
     */
    public function filter_xtb_block_render_attributes( $attributes, $content, $block ) {
        if ( ! isset( $block['controls'] ) || empty( $block['controls'] ) ) {
            return $attributes;
        }

        // prepare decoded array to actual array.
        foreach ( $block['controls'] as $control ) {
            if ( $this->name === $control['type'] && isset( $attributes[ $control['name'] ] ) && is_string( $attributes[ $control['name'] ] ) ) {
                $attributes[ $control['name'] ] = json_decode( rawurldecode( $attributes[ $control['name'] ] ), true );
            }
        }

        return $attributes;
    }

    /**
     * Change get_xtb_meta output to array.
     *
     * @param string $result - meta data.
     * @param string $name - meta name.
     * @param mixed  $id - post id.
     * @param mixed  $control - control data.
     *
     * @return array filtered meta.
     */
    public function filter_get_xtb_meta_json( $result, $name, $id, $control ) {
        if ( ! $control || $this->name !== $control['type'] || ! is_string( $result ) ) {
            return $result;
        }

        return json_decode( urldecode( $result ), true );
    }
}

new XT_Blocks_Control_File();
