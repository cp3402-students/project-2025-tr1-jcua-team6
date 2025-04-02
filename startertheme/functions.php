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
 * Returns an array mapping WordPress block names to Viridian custom classes.
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
        'core/table'     => 'viridian-table',
        'core/code'      => 'viridian-code',
        'core/button'    => 'viridian-button',
        // Add additional mappings as needed.
    );
}

/**
 * Adds Viridian custom classes to block content.
 *
 * @param string $block_content The block content.
 * @param array  $block         The parsed block data.
 * @return string
 */
function viridian_add_custom_classes( $block_content, $block ) {
    $mappings = viridian_block_class_mapping();

    // Check if this block's name is in our mapping array.
    if ( isset( $block['blockName'] ) && array_key_exists( $block['blockName'], $mappings ) ) {
        $custom_class = $mappings[ $block['blockName'] ];

        // Append the custom class to the existing class attribute if present.
        if ( strpos( $block_content, 'class="' ) !== false ) {
            $block_content = preg_replace(
                '/class="([^"]*)"/',
                'class="$1 ' . esc_attr( $custom_class ) . '"',
                $block_content,
                1
            );
        } else {
            // If there is no class attribute, add one.
            $block_content = preg_replace(
                '/^<([a-z0-9]+)/i',
                '<$1 class="' . esc_attr( $custom_class ) . '"',
                $block_content
            );
        }
    }
    return $block_content;
}
add_filter( 'render_block', 'viridian_add_custom_classes', 10, 2 );
