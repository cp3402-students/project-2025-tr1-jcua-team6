# Site Management Guide

The **Baizonn Learning Center** website uses the custom **Viridian** WordPress theme. This guide outlines how to update content, manage styling, use navigation, and perform essential site maintenance.

---

## Pages vs Posts (adding new content)

All content on the site is structured using **pages**.

- Use **Pages** (not Posts) to create and manage content for the site.
- Navigate to the WordPress dashboard -> Pages to edit existing content or create a new page.
- When creating a new page, you can choose between the "Default template" and "Full-Width page" under Quick Edit -> Template.

---

## Styling content
### Automatic Styling
The Viridian theme automatically applies CSS styles to [WordPress core blocks](https://developer.wordpress.org/block-editor/reference-guides/core-blocks/#embed) using mappings defined in `functions.php`. <br>
The mapping can be broken down into four main sections:
- `get_default_classes_for_block`: Stores an array of 'default WordPress classes' for each core block element. This allows a later function to differentiate between default styles and custom CSS. 
- `block_class_mapping`: Uses an array to map core block elements with their respective Viridan custom theme styles
- `add_custom_classes`: Dynamic function that will inspect blocks for their applied classes. If a block only has the default WordPress classes or any extra classes manually permitted, it will apply the respective Viridian block theme. Otherwise, it assumes custom CSS is being used and will not apply the Viridian theme styles. 
- `dynamic_row_stack_classes`: Adds dynamic handling for when a row and stack are switched by identifying the relevant classes. (Note: rows and stacks cannot be uniquely identified until either of these options is applied)

<br>

**viridian_get_default_classes_for_block**
``` PHP
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
```
This function is where you would add a new core block element or define some more default classes that should not be treated as custom CSS. To add a core block, look for new undefined [WordPress core blocks](https://developer.wordpress.org/block-editor/reference-guides/core-blocks/#embed). Once found, you can add them to at '// Add more defaults as needed.', where the left hand column following the format `core/<coreblock>` and it matches to an array (=> array) of WordPress default classes in the format `('default-class-one', 'default-class-two')`. Following this process will successfully map a core block with an array of default styles which the Viridian theme will ignore and apply alongside. 

<br>

**viridian_block_class_mapping**
``` PHP
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
```
This function works very similar to the previous one, but instead maps core blocks with their new Viridian custom theme to append alongside the default WordPress styles. For example, a `core/paragraph` will be mapped to the Viridian style `viridian-paragraph`. <br>
This allows any blocks to have the Viridian styles applied to them automatically before the page has finished render, and removes the need to manually reference each style as 'Custom CSS Class' in WordPress.

<br>

**viridian_add_custom_classes**
``` PHP
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
```

This function consists of a sequence of simple checks and comparisons to identify what styles a core block already has and if the Viridian styles need to be applied. It consists of these main variables:
- `$mappings`: Maps WordPress block names to their corresponding Viridian custom classes.  
- `$viridian_class`: Holds the Viridian custom class for the current block type.  
- `$existing_classes`: Array of all CSS classes already present in the block's HTML.  
- `$default_classes`: Default CSS classes output by WordPress for the block type.  
- `$extra_classes`: Classes in the block that are not part of the default set.  
- `$allowed_extras`: Permitted extra classes that don't prevent adding the Viridian class.  
- `$filtered_extras`: Extra classes remaining after filtering out the allowed extras.  
- `$block_content`: The complete HTML output of the block being processed.

As a simplification, the process goes as follows: the function retrieves the block mappings so it knows what Viridian theme to apply to each block, then it verifies if the current block has a matching entry in those mappings. If found, it extracts the block’s existing CSS classes from the HTML, retrieves the default WordPress classes for that block type, and determines which classes are extra. It then filters out any allowed extra classes and, if no unexpected custom classes remain, appends the corresponding Viridian custom class (or adds it if no class attribute exists). The last step is to return the updated block content HTML.

<br>

**viridian_dynamic_row_stack_classes**
``` PHP
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
```
A simple function to handle WordPress rows and stacks, which do not have core block types. Instead, they are uniquely identified based on their individual classes `is-horizontal` and `is-vertical`. This then allows the Viridian custom style to be applied appropriately, automatically, and dynamically (if a row were to become a stack, and vice versa).

### Additional Styling
- Unmapped blocks can use manual CSS class names found in `style.css`.
- Each group member has their own dedicated 'Custom CSS sections'
- For unique styling, assign manual class names via the "Additional CSS Classes" field in the WordPress default editor.

---

## Navigation
To update the site's main menu:

1. Go to **Appearance > Menus**.
2. Select `nav-menu (Primary)`.
3. Check the box for any new page on the left and click "Add to Menu".
4. Drag to reorder the items.
5. Click "Save Menu".

## Back-ups and Migration
- The plug-in 'All-In-On WP Migration and Back-up' is installed for setting up scheduled back-ups and organising migration to the production server as a manual process.
- If you require an automatic migration process this plug-in has a paid option for this functionality available.

## Settings
- Permalink settings are set to 'Custom Structure' for development and testing. This can be changed to 'Post name' in the production site to meet best SEO standards and practices.
