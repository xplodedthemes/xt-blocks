<?php
/**
 * Rest API functions
 *
 * @package xt-blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class XT_Blocks_Rest
 */
class XT_Blocks_Rest extends WP_REST_Controller {
    /**
     * Namespace.
     *
     * @var string
     */
    protected $namespace = 'xt-blocks/v';

    /**
     * Version.
     *
     * @var string
     */
    protected $version = '1';

    /**
     * XT_Blocks_Rest constructor.
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register rest routes.
     */
    public function register_routes() {
        $namespace = $this->namespace . $this->version;

        // Get Lazy Block Editor Preview.
        register_rest_route(
            $namespace,
            '/block-render/',
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'get_block' ),
                'permission_callback' => array( $this, 'get_block_permission' ),
            )
        );

        // Get Lazy Block Data.
        register_rest_route(
            $namespace,
            '/get-block-data/',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_block_data' ),
                'permission_callback' => array( $this, 'get_block_data_permission' ),
            )
        );

        // Update Lazy Block Data.
        register_rest_route(
            $namespace,
            '/update-block-data/',
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'update_block_data' ),
                'permission_callback' => array( $this, 'update_block_data_permission' ),
            )
        );

        // Get WP post types.
        register_rest_route(
            $namespace,
            '/get-post-types/',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_post_types' ),
                'permission_callback' => array( $this, 'get_post_types_permission' ),
            )
        );
    }

    /**
     * Checks if a given request has access to read blocks.
     *
     * @since 2.8.0
     * @access public
     *
     * @param WP_REST_Request $request Request.
     *
     * @return WP_REST_Response|true
     */
    public function get_block_permission( $request ) {
        global $post;

        $post_id = isset( $request['post_id'] ) ? intval( $request['post_id'] ) : 0;

        if ( 0 < $post_id ) {
            // phpcs:ignore
            $post = get_post( $post_id );
            if ( ! $post || ! current_user_can( 'edit_post', $post->ID ) ) {
                return $this->error( 'lazy_block_cannot_read', esc_html__( 'Sorry, you are not allowed to read Gutenberg blocks of this post.', 'xt-blocks' ) );
            }
        } else {
            if ( ! current_user_can( 'edit_posts' ) ) {
                return $this->error( 'lazy_block_cannot_read', esc_html__( 'Sorry, you are not allowed to read Gutenberg blocks as this user.', 'xt-blocks' ) );
            }
        }

        return true;
    }

    /**
     * Get read block data permissions.
     *
     * @return WP_REST_Response|true
     */
    public function get_block_data_permission() {
        global $post;

        $post_id = isset( $request['post_id'] ) ? intval( $request['post_id'] ) : 0;

        if ( 0 < $post_id ) {
            // phpcs:ignore
            $post = get_post( $post_id );
            if ( ! $post || ! current_user_can( 'edit_post', $post->ID ) ) {
                return $this->error( 'lazy_block_data_cannot_read', esc_html__( 'Sorry, you are not allowed to read Gutenberg blocks data.', 'xt-blocks' ) );
            }
        } else {
            if ( ! current_user_can( 'edit_posts' ) ) {
                return $this->error( 'lazy_block_data_cannot_read', esc_html__( 'Sorry, you are not allowed to read Gutenberg blocks data as this user.', 'xt-blocks' ) );
            }
        }

        return true;
    }

    /**
     * Get edit block data permissions.
     *
     * @return WP_REST_Response|true
     */
    public function update_block_data_permission() {
        return $this->get_block_data_permission();
    }

    /**
     * Get read wp post types permissions.
     *
     * @return WP_REST_Response|true
     */
    public function get_post_types_permission() {
        if ( ! current_user_can( 'edit_posts' ) ) {
            return $this->error( 'lazy_block_data_cannot_read', esc_html__( 'Sorry, you are not allowed to read Gutenberg blocks data as this user.', 'xt-blocks' ) );
        }

        return true;
    }

    /**
     * Returns block output from block's registered render_callback.
     *
     * @since 2.8.0
     * @access public
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return WP_REST_Response
     */
    public function get_block( $request ) {
        global $post;

        $post_id          = $request->get_param( 'post_id' ) ? intval( $request->get_param( 'post_id' ) ) : 0;
        $block_context    = $request->get_param( 'context' );
        $block_name       = $request->get_param( 'name' );
        $block_attributes = $request->get_param( 'attributes' );

        // add global data to fix meta data output in preview.
        global $xtb_preview_block_data;
        $xtb_preview_block_data = array(
            'post_id'          => $post_id,
            'block_context'    => $block_context,
            'block_name'       => $block_name,
            'block_attributes' => $block_attributes,
        );

        if ( 0 < $post_id ) {
            // phpcs:ignore
            $post = get_post( $post_id );

            // Set up postdata since this will be needed if post_id was set.
            setup_postdata( $post );
        }
        $block = xtblocks()->blocks()->get_block( $block_name );

        if ( ! $block ) {
            return $this->error( 'lazy_block_invalid', esc_html__( 'Invalid block.', 'xt-blocks' ) );
        }

        $block_result = xtblocks()->blocks()->render_callback( $block_attributes, null, $block_context );

        if ( isset( $block_result ) && null !== $block_result ) {
            return $this->success( $block_result );
        } else {
            return $this->error( 'lazy_block_no_render_callback', esc_html__( 'Render callback is not specified.', 'xt-blocks' ) );
        }
    }

    /**
     * Update block data.
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return WP_REST_Response
     */
    public function update_block_data( $request ) {
        $post_id = isset( $request['post_id'] ) ? intval( $request['post_id'] ) : 0;
        $data    = isset( $request['data'] ) ? $request['data'] : false;
        $meta    = array();

        if ( 0 < $post_id && $data ) {
            $meta_prefix = 'xtblocks_';

            // add 'xtblocks_' prefix.
            foreach ( $data as $k => $val ) {
                $meta[ $meta_prefix . $k ] = $val;
            }

            xtblocks()->blocks()->save_meta_boxes( $post_id, $meta );
        }

        return $this->success( $meta );
    }

    /**
     * Get block data.
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return WP_REST_Response
     */
    public function get_block_data( $request ) {
        $post_id = isset( $request['post_id'] ) ? intval( $request['post_id'] ) : 0;
        $meta    = array();

        if ( 0 < $post_id ) {
            $post_meta   = xtblocks()->blocks()->get_meta_boxes( $post_id );
            $meta_prefix = 'xtblocks_';

            // remove 'xtblocks_' prefix.
            foreach ( $post_meta as $k => $val ) {
                if ( substr( $k, 0, strlen( $meta_prefix ) ) === $meta_prefix ) {
                    $meta[ substr( $k, strlen( $meta_prefix ) ) ] = $val;
                }
            }
        }

        return $this->success( $meta );
    }

    /**
     * Get WP post types.
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return WP_REST_Response
     */
    public function get_post_types( $request ) {
        $args     = isset( $request['args'] ) ? $request['args'] : array();
        $output   = isset( $request['output'] ) ? $request['output'] : 'names';
        $operator = isset( $request['operator'] ) ? $request['operator'] : 'and';

        $result = get_post_types( $args, $output, $operator );

        return $this->success( $result );
    }

    /**
     * Success rest.
     *
     * @param mixed $response response data.
     *
     * @return WP_REST_Response
     */
    public function success( $response ) {
        return new WP_REST_Response(
            array(
                'success'  => true,
                'response' => $response,
            ),
            200
        );
    }

    /**
     * Error rest.
     *
     * @param string $code     error code.
     * @param string $response response data.
     *
     * @return WP_REST_Response
     */
    public function error( $code, $response ) {
        return new WP_REST_Response(
            array(
                'error'      => true,
                'success'    => false,
                'error_code' => $code,
                'response'   => $response,
            ),
            200
        );
    }
}
new XT_Blocks_Rest();
