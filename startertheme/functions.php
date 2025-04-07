<?php
/**
 * starterTheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package starterTheme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function startertheme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on starterTheme, use a find and replace
		* to change 'startertheme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'startertheme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'startertheme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'startertheme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'startertheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function startertheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'startertheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'startertheme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function startertheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'startertheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'startertheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'startertheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function startertheme_scripts() {
	wp_enqueue_style( 'startertheme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'startertheme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'startertheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'startertheme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


// Test code for automatic group style applying
// function add_custom_class_to_group_blocks( $block_content, $block ) {
//     // Check if the block is a core group block.
//     if ( isset( $block['blockName'] ) && 'core/group' === $block['blockName'] ) {
//         // Append the custom class to the default group class.
//         $block_content = str_replace( 'wp-block-group', 'wp-block-group custom-gray-group', $block_content );
//     }
//     return $block_content;
// }
// add_filter( 'render_block', 'add_custom_class_to_group_blocks', 10, 2 );

/**
 * Retrieve the default CSS classes that WordPress outputs for a given block type.
 *
 * @param string $blockName The registered name of the block (e.g., 'core/paragraph').
 * @return array An array of default class names for the block.
 */
function viridian_get_default_classes_for_block( $blockName ) {
    $defaults = array(
        'core/paragraph' => array( 'wp-block-paragraph' ),
        'core/heading'   => array( 'wp-block-heading' ),
        'core/group'     => array( 'wp-block-group', 'wp-block-group__inner-container', 'is-layout-constrained', 'wp-block-group-is-layout-constrained' ),
        'core/columns'   => array( 'wp-block-columns', 'is-layout-flow', 'wp-block-columns-is-layout-flow' ),
        'core/column'    => array( 'wp-block-column', 'is-layout-flow', 'wp-block-column-is-layout-flow' ),
        'core/quote'     => array( 'wp-block-quote' ),
        'core/pullquote' => array( 'wp-block-pullquote' ),
        'core/table'     => array( 'wp-block-table' ),
        'core/code'      => array( 'wp-block-code' ),
        'core/button'    => array( 'wp-block-button' ),
        'core/list'      => array( 'wp-block-list' ),
        'core/embed'     => array( 'wp-block-embed__wrapper' ), // Sam's addition
        // Add more defaults as needed.
    );
    return isset( $defaults[ $blockName ] ) ? $defaults[ $blockName ] : array();
}

/**
 * Returns an array mapping WordPress block names to Viridian custom classes.
 *
 * These mappings allow us to add our custom theme styles automatically.
 *
 * @return array
 */
function viridian_block_class_mapping() {
    return array(
        'core/paragraph' => 'viridian-paragraph',
        'core/heading'   => 'viridian-heading',
        'core/group'     => 'viridian-group',
        'core/columns'   => 'viridian-columns',
        'core/column'    => 'viridian-column',
        'core/quote'     => 'viridian-blockquote',
        'core/pullquote' => 'viridian-pullquote',
        'core/table'     => 'viridian-table',
        'core/code'      => 'viridian-code',
        'core/button'    => 'viridian-button',
        'core/list'      => 'viridian-list',
        'core/embed'     => 'viridian-youtube-embed'
        // Add additional mappings as needed.
    );
}

/**
 * Adds Viridian custom classes to block content.
 *
 * This function inspects the rendered block's HTML. If the block's class attribute
 * contains only the default classes (as defined by WordPress) or extra classes that are
 * permitted (e.g. size editor classes), it appends the corresponding Viridian custom class.
 * If other custom classes are detected, it leaves the block content unchanged.
 *
 * @param string $block_content The rendered block HTML.
 * @param array  $block         The parsed block data (includes the 'blockName').
 * @return string The modified (or unmodified) block content.
 */
function viridian_add_custom_classes( $block_content, $block ) {
    // Retrieve the mapping of block names to Viridian custom classes.
    $mappings = viridian_block_class_mapping();

    // Check if this block has a mapping defined.
    if ( isset( $block['blockName'] ) && array_key_exists( $block['blockName'], $mappings ) ) {
        // Get the Viridian class for this block type.
        $viridian_class = $mappings[ $block['blockName'] ];

        // Check if the block content has a class attribute.
        if ( preg_match( '/class="([^"]+)"/', $block_content, $matches ) ) {
            // Convert the existing class list (a string) into an array.
            $existing_classes = preg_split( '/\s+/', trim( $matches[1] ) );
            // Retrieve the default classes that WordPress outputs for this block.
            $default_classes = viridian_get_default_classes_for_block( $block['blockName'] );

            // Identify any extra classes that are not part of the defaults.
            $extra_classes = array_diff( $existing_classes, $default_classes );

            // Define a list of allowed extra classes that should not block adding the Viridian class.
            // For example, the size editor may add 'has-custom-font-size'.
            $allowed_extras = array(
                'has-custom-font-size'
                // Add more allowed extras as needed per block type.
            );

            // Filter out the allowed extras from the extra classes.
            $filtered_extras = array_diff( $extra_classes, $allowed_extras );

            // If there are extra classes beyond the allowed list, assume custom styling is in place.
            if ( ! empty( $filtered_extras ) ) {
                return $block_content;
            }

            // Otherwise, append the Viridian class to the existing class attribute.
            $block_content = preg_replace(
                '/class="([^"]+)"/',
                'class="$1 ' . esc_attr( $viridian_class ) . '"',
                $block_content,
                1
            );
        } else {
            // If there is no class attribute, add one with the Viridian class.
            $block_content = preg_replace(
                '/^<([a-z0-9]+)/i',
                '<$1 class="' . esc_attr( $viridian_class ) . '"',
                $block_content
            );
        }
    }
    // Return the modified (or original) block content.
    return $block_content;
}
// Hook our function to the 'render_block' filter so it runs on every block render.
add_filter( 'render_block', 'viridian_add_custom_classes', 10, 2 );

/**
 * Dynamically adds Viridian classes for row and stack groups by detecting specific layout markers.
 *
 * Now the function will only check for 'is-horizontal' for rows and 'is-vertical' for stacks.
 *
 * @param string $block_content The rendered block HTML.
 * @return string The modified block content.
 */
function viridian_dynamic_row_stack_classes( $block_content ) {
    // Detect row: if the block contains 'is-horizontal'.
    if ( strpos( $block_content, 'is-horizontal' ) !== false ) {
        // Append the custom viridian row class.
        $block_content = preg_replace(
            '/class="([^"]+)"/',
            'class="$1 viridian-row"',
            $block_content,
            1
        );
    }

    // Detect stack: if the block contains 'is-vertical'.
    if ( strpos( $block_content, 'is-vertical' ) !== false ) {
        // Append the custom viridian stack class.
        $block_content = preg_replace(
            '/class="([^"]+)"/',
            'class="$1 viridian-stack"',
            $block_content,
            1
        );
    }

    return $block_content;
}
// Hook the dynamic row/stack class handler with a priority that ensures it runs after the main class function.
add_filter( 'render_block', 'viridian_dynamic_row_stack_classes', 11 );