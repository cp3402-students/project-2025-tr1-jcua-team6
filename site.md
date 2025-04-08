# Site Management Guide

The **Baizonn Learning Center** website uses the custom **Viridian** WordPress theme. This guide outlines how to update content, manage styling, use navigation, and perform essential site maintenance.

---

## Pages vs Posts

All content on the site is structured using **pages**.

- Use **Pages** (not Posts) to create and manage content for the site.
- Navigate to the WordPress dashboard -> Pages to edit existing content or create a new page.
- When creating a new page, you can choose between the "Default template" and "Full-Width page" under Quick Edit -> Template.

---

## Adding new content
- All the content of the theme is contained in individual pages.
- Select the pages tab and the specific page required to add or remove content.
- Create a new page to add additonal page content.
- There is the option in the "Quick Edit" link of each page in the "Templates" tab to choose the "Default template" or "Full-Width page" template.  

## Styling content
- Most of the unique Viridian CSS style is automatically mapped to [WordPress core block elements](https://developer.wordpress.org/block-editor/reference-guides/core-blocks/#embed) through the functions.php file:
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
- Additional defaults and mappings can be added in the commented areas of the functions above if required. Please note that the relative CSS class still needs to be coded into the appropriate section of the styles.css file.
- A number of additional unmapped custom CSS classes are also provided for use in well described sections of the styles.css file.

## Navigation
- To see any new pages created in the menu they must be added to Appearance/menus.
- The menu to be selected to edit is "nav-menu(Primary)".
- Select your new page from the left panel and then move into the required order and save.

## Back-ups and Migration
- The plug-in 'All-In-On WP Migration and Back-up' is installed for setting up scheduled back-ups and organising migration to the production server as a manual process.
- If you require an automatic migration process this plug-in has a paid option for this functionality available.

## Settings
- Permalink settings are set to 'Custom Structure' for development and testing. This can be changed to 'Post name' in the production site to meet best SEO standards and practices.
