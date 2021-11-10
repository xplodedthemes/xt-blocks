<?php
/**
 * XT_Blocks force enable gutenberg on constructor page.
 *
 * @package xtblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * XT_Blocks_Force_Gutenberg class. Class to work with XT_Blocks CPT.
 */
class XT_Blocks_Force_Gutenberg {
    /**
     * XT_Blocks_Force_Gutenberg constructor.
     */
    public function __construct() {
        // force enable Gutenberg editor in 'xtblocks' for Classic Editor plugin.
        add_action( 'classic_editor_enabled_editors_for_post_type', array( $this, 'classic_plugin_force_gutenberg' ), 150, 2 );
        add_action( 'use_block_editor_for_post_type', array( $this, 'classic_plugin_force_gutenberg_2' ), 150, 2 );
        add_action( 'use_block_editor_for_post', array( $this, 'classic_plugin_force_gutenberg_3' ), 150, 2 );

        // force enable Gutenberg in 'xtblocks' for users with disabled option "Visual Editor".
        add_filter( 'user_can_richedit', array( $this, 'user_can_richedit_force' ) );
    }

    /**
     * Force set Gutenberg editor for 'xtblocks' in Classic Editor plugin.
     *
     * @param array  $editors    Associative array of the editors and whether they are enabled for the post type.
     * @param string $post_type The post type.
     */
    public function classic_plugin_force_gutenberg( $editors, $post_type ) {
        if ( 'xtblocks' !== $post_type ) {
            return $editors;
        }

        return array(
            'classic_editor' => false,
            'block_editor'   => true,
        );
    }

    /**
     * Force set Gutenberg editor for 'xtblocks' in Classic Editor plugin.
     *
     * @param boolean $use_block_editor Use block editor.
     * @param string  $post_type The post type.
     */
    public function classic_plugin_force_gutenberg_2( $use_block_editor, $post_type ) {
        if ( 'xtblocks' !== $post_type ) {
            return $use_block_editor;
        }

        return true;
    }

    /**
     * Force set Gutenberg editor for 'xtblocks' in 3rd-party plugins/themes, that uses their own builders.
     *
     * @param boolean $use_block_editor Use block editor.
     * @param object  $post The post object.
     */
    public function classic_plugin_force_gutenberg_3( $use_block_editor, $post ) {
        if ( isset( $post->post_type ) && 'xtblocks' === $post->post_type ) {
            return true;
        }

        return $use_block_editor;
    }

    /**
     * Force enable Gutenberg in 'xtblocks' for users with disabled option "Visual Editor".
     *
     * @param boolean $enabled Rich edit enabled.
     */
    public function user_can_richedit_force( $enabled ) {
        global $post_type;

        if ( isset( $post_type ) && 'xtblocks' !== $post_type ) {
            return $enabled;
        }

        return true;
    }
}

new XT_Blocks_Force_Gutenberg();
