<?php
/**
 * Plugin Name:  XT Blocks
 * Description:  Gutenberg blocks visual constructor. Custom meta fields or blocks with output without hard coding.
 * Version:      2.5.1
 * Author:       XplodedThemes
 * Author URI:   https://xplodedthemes.com/
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  xt-blocks
 *
 * @package xtblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'XT_Blocks' ) ) :

    /**
     * XT_Blocks Class
     */
    class XT_Blocks {
        /**
         * The single class instance.
         *
         * @var null
         */
        private static $instance = null;

        /**
         * Main Instance
         * Ensures only one instance of this class exists in memory at any one time.
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }

        /**
         * The base path to the plugin in the file system.
         *
         * @var string
         */
        public $plugin_path;

        /**
         * URL Link to plugin
         *
         * @var string
         */
        public $plugin_url;

        /**
         * Icons class object.
         *
         * @var XT_Blocks_Icons
         */
        private $icons;

        /**
         * Controls class object.
         *
         * @var XT_Blocks_Controls
         */
        private $controls;

        /**
         * Blocks class object.
         *
         * @var XT_Blocks_Blocks
         */
        private $blocks;

        /**
         * Templates class object.
         *
         * @var XT_Blocks_Templates
         */
        private $templates;

        /**
         * Tools class object.
         *
         * @var XT_Blocks_Tools
         */
        private $tools;

        /**
         * XT_Blocks constructor.
         */
        public function __construct() {
            /* We do nothing here! */
        }

        /**
         * Activation Hook
         */
        public function activation_hook() {
            XT_Blocks_Dummy::add();
        }

        /**
         * Deactivation Hook
         */
        public function deactivation_hook() {}

        /**
         * Init.
         */
        public function init() {
            $this->plugin_path = plugin_dir_path( __FILE__ );
            $this->plugin_url  = plugin_dir_url( __FILE__ );

            $this->load_text_domain();
            $this->include_dependencies();

            $this->icons     = new XT_Blocks_Icons();
            $this->controls  = new XT_Blocks_Controls();
            $this->blocks    = new XT_Blocks_Blocks();
            $this->templates = new XT_Blocks_Templates();
            $this->tools     = new XT_Blocks_Tools();
        }

        /**
         * Get plugin_path.
         */
        public function plugin_path() {
            return apply_filters( 'xtb/plugin_path', $this->plugin_path );
        }

        /**
         * Get plugin_url.
         */
        public function plugin_url() {
            return apply_filters( 'xtb/plugin_url', $this->plugin_url );
        }

        /**
         * Sets the text domain with the plugin translated into other languages.
         */
        public function load_text_domain() {
            load_plugin_textdomain( 'xt-blocks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }

        /**
         * Set plugin Dependencies.
         */
        private function include_dependencies() {
            // Deprecations run before all features.
            require_once $this->plugin_path() . 'classes/class-deprecated.php';

            require_once $this->plugin_path() . '/classes/class-migration.php';
            require_once $this->plugin_path() . '/classes/class-admin.php';
            require_once $this->plugin_path() . '/classes/class-icons.php';
            require_once $this->plugin_path() . '/classes/class-controls.php';
            require_once $this->plugin_path() . '/classes/class-blocks.php';
            require_once $this->plugin_path() . '/classes/class-templates.php';
            require_once $this->plugin_path() . '/classes/class-tools.php';
            require_once $this->plugin_path() . '/classes/class-rest.php';
            require_once $this->plugin_path() . '/classes/class-dummy.php';
            require_once $this->plugin_path() . '/classes/class-force-gutenberg.php';
        }

        /**
         * Get xtblocks icons object.
         */
        public function icons() {
            return $this->icons;
        }

        /**
         * Get xtblocks controls object.
         */
        public function controls() {
            return $this->controls;
        }

        /**
         * Get xtblocks blocks object.
         */
        public function blocks() {
            return $this->blocks;
        }

        /**
         * Get xtblocks templates object.
         */
        public function templates() {
            return $this->templates;
        }

        /**
         * Get xtblocks tools object.
         */
        public function tools() {
            return $this->tools;
        }

        /**
         * Add xtblocks block.
         *
         * @param array $data - block data.
         */
        public function add_block( $data ) {
            return $this->blocks()->add_block( $data );
        }

        /**
         * Add xtblocks template.
         *
         * @param array $data - template data.
         */
        public function add_template( $data ) {
            return $this->templates()->add_template( $data );
        }
    }

    /**
     * The main cycle of the plugin.
     *
     * @return null|XT_Blocks
     */
    function xtblocks() {
        return XT_Blocks::instance();
    }

    // Initialize.
    xtblocks();

    // Activation / Deactivation hooks.
    register_activation_hook( __FILE__, array( xtblocks(), 'activation_hook' ) );
    register_deactivation_hook( __FILE__, array( xtblocks(), 'deactivation_hook' ) );

    /**
     * Function to get meta value with some improvements for Lazyblocks metas.
     *
     * @param string   $name - metabox name.
     * @param int|null $id - post id.
     *
     * @return array|mixed|object
     */
    // phpcs:ignore
    function get_xtb_meta( $name, $id = null ) {
        // global variable used to fix `get_xtb_meta` call inside block preview in editor.
        global $xtb_preview_block_data;

        $control_data = null;

        if ( null === $id ) {
            global $post;

            if ( isset( $post->ID ) ) {
                $id = $post->ID;
            }
        }

        // Find control data by meta name.
        $blocks = xtblocks()->blocks()->get_blocks();
        foreach ( $blocks as $block ) {
            if ( isset( $block['controls'] ) && is_array( $block['controls'] ) ) {
                foreach ( $block['controls'] as $control ) {
                    if ( $control_data || 'true' !== $control['save_in_meta'] ) {
                        continue;
                    }

                    $meta_name = false;

                    if ( isset( $control['save_in_meta_name'] ) && $control['save_in_meta_name'] ) {
                        $meta_name = $control['save_in_meta_name'];
                    } elseif ( $control['name'] ) {
                        $meta_name = $control['name'];
                    }

                    if ( $meta_name && $meta_name === $name ) {
                        $control_data = $control;
                    }
                }
            }
        }

        $result = null;

        if (
            isset( $xtb_preview_block_data ) &&
            is_array( $xtb_preview_block_data ) &&
            isset( $control_data['name'] ) &&
            isset( $xtb_preview_block_data['block_attributes'][ $control_data['name'] ] )
        ) {
            $result = $xtb_preview_block_data['block_attributes'][ $control_data['name'] ];
        } elseif ( $id ) {
            $result = get_post_meta( $id, $name, true );
        }

        return apply_filters( 'xtb/get_meta', $result, $name, $id, $control_data );
    }

endif;
