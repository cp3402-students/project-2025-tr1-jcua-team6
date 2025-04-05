# Baizonn Learning Center

**The Baizonn Learning Center website uses the Viridian theme.**  

## Adding new content
- All content of the theme are contained in individual pages.
- Select the pages tab and the the specific page required to add or remove content.
- Most of the unique Viridian CSS style is automatically mapped to [WordPress core block elements](https://developer.wordpress.org/block-editor/reference-guides/core-blocks/#embed) through the functions.php file. Additional defaults can be added if required and the relative CSS class can be coded into the appropriate section of the styles.css file.
```
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
        'core/group'     => array( 'wp-block-group', 'wp-block-group__inner-container', 'is-layout-constrained', 'wp-block-group-is-layout-constrained'),
        'core/columns'   => array( 'wp-block-columns', 'is-layout-flow', 'wp-block-columns-is-layout-flow' ),
        'core/column'    => array( 'wp-block-column', 'is-layout-flow', 'wp-block-column-is-layout-flow' ),
        'core/quote'     => array( 'wp-block-quote' ),
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
        'core/table'     => 'viridian-table',
        'core/code'      => 'viridian-code',
        'core/button'    => 'viridian-button',
        'core/list'      => 'viridian-list',
		    'core/embed'     => 'viridian-youtube-embed'
        // Add additional mappings as needed.
    );
}
```
- A number of additional unmapped custom CSS classes are also provided for use in well described sections of the styles.css file.

## Navigation
- To see any new pages created in the menu they must be added to Appearance/menus.
- The menu to be selected to edit is "nav-menu(Primary)".
- Select your new page from the left panel and then move into the required order and save. 
