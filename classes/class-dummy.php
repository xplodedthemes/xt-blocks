<?php
/**
 * XT_Blocks dummy.
 *
 * @package xtblocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * XT_Blocks_Dummy class. Class to work with XT_Blocks Controls.
 */
class XT_Blocks_Dummy {
    /**
     * Name of option that will prevent multiple example blocks creation.
     *
     * @var string
     */
    private static $option_name = 'xtb_dummy_added';

    /**
     * XT_Blocks_Dummy constructor.
     */
    public function __construct() {}

    /**
     * Add dummy block
     */
    public static function add() {
        // Check if already added example block.
        if ( get_option( self::$option_name, false ) ) {
            return;
        }

        // Check if any blocks already added.
        $blocks = get_posts(
            array(
                'post_type'   => 'xtblocks',
                'numberposts' => 1,
                'post_status' => 'any',
                'fields'      => 'ids',
            )
        );

        if ( count( $blocks ) > 0 ) {
            return;
        }

        // Create new post.
        $post_id = wp_insert_post(
            array(
                'post_title'  => esc_attr__( 'Example Block', 'xt-blocks' ),
                'post_status' => 'draft',
                'post_type'   => 'xtblocks',
            )
        );

        $code = '<?php if ( isset( $attributes[\'image\'][\'url\'] ) ) : ?>
    <p>
        <img src="<?php echo esc_url( $attributes[\'image\'][\'url\'] ); ?>" alt="<?php echo esc_attr( $attributes[\'image\'][\'alt\'] ); ?>">
    </p>

    <?php if ( isset( $attributes[\'button-label\'] ) ) : ?>
        <p>
            <a href="<?php echo esc_url( $attributes[\'button-url\'] ); ?>" class="button button-primary">
                <?php echo esc_html( $attributes[\'button-label\'] ); ?>
            </a>
        </p>
    <?php endif; ?>
<?php else: ?>
    <p>Image is required to show this block content.</p>
<?php endif; ?>';

        if ( $post_id ) {
            xtblocks()->blocks()->save_meta_boxes(
                $post_id,
                array(
                    'xtblocks_controls'               => array(
                        'control_005ad74de2' => array(
                            'type'                 => 'image',
                            'name'                 => 'image',
                            'default'              => '',
                            'label'                => 'Image',
                            'help'                 => '',
                            'child_of'             => '',
                            'placement'            => 'inspector',
                            'width'                => '100',
                            'hide_if_not_selected' => 'false',
                            'save_in_meta'         => 'false',
                            'save_in_meta_name'    => '',
                            'required'             => 'false',
                            'placeholder'          => '',
                            'characters_limit'     => '',
                        ),
                        'control_1729664f06' => array(
                            'type'                 => 'text',
                            'name'                 => 'button-label',
                            'default'              => '',
                            'label'                => 'Button Label',
                            'help'                 => '',
                            'child_of'             => '',
                            'placement'            => 'inspector',
                            'width'                => '100',
                            'hide_if_not_selected' => 'false',
                            'save_in_meta'         => 'false',
                            'save_in_meta_name'    => '',
                            'required'             => 'false',
                            'placeholder'          => '',
                            'characters_limit'     => '',
                        ),
                        'control_8b591545a2' => array(
                            'type'                 => 'url',
                            'name'                 => 'button-url',
                            'default'              => '',
                            'label'                => 'Button URL',
                            'help'                 => '',
                            'child_of'             => '',
                            'placement'            => 'inspector',
                            'width'                => '100',
                            'hide_if_not_selected' => 'false',
                            'save_in_meta'         => 'false',
                            'save_in_meta_name'    => '',
                            'required'             => 'false',
                            'placeholder'          => '',
                            'characters_limit'     => '',
                        ),
                    ),
                    'xtblocks_slug'                   => 'example-block',
                    'xtblocks_icon'                   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.25" width="15" height="15" rx="4" transform="matrix(-1 0 0 1 22 7)" fill="currentColor" /><rect width="15" height="15" rx="4" transform="matrix(-1 0 0 1 17 2)" fill="currentColor" /></svg>',
                    'xtblocks_description'            => esc_html__( 'Example block that helps you to get started with XT Blocks plugin', 'xt-blocks' ),
                    'xtblocks_keywords'               => 'example,sample,template',
                    'xtblocks_category'               => 'common',
                    'xtblocks_code_output_method'     => 'php',
                    'xtblocks_code_show_preview'      => 'always',
                    'xtblocks_code_single_output'     => 'true',
                    'xtblocks_code_frontend_html'     => $code,
                    'xtblocks_supports_multiple'      => 'true',
                    'xtblocks_supports_classname'     => 'true',
                    'xtblocks_supports_anchor'        => 'false',
                )
            );

            update_option( self::$option_name, $post_id );
        }
    }
}

new XT_Blocks_Dummy();
