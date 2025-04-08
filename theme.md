# Theme Developer Guide

This guide provides an overview for developers maintaining or extending the custom **Viridian** theme used in the Baizonn Learning Center website.

For full details on project structure, deployment, and site management, refer to the following:
- [Deployment Guide](deployment.md)
- [Site Management Guide](site.md)

---

## Theme Overview
Viridian is a fully custom WordPress theme based on a minimal starter framework. It focuses on a clean layout, accessibility, and a green colour palette to foster trust and approachability for a parent-focused educational website.

---

## Theme Colours
- **Primary**: `#c8ffea`
- **Secondary**: `#9ad99e`
- **Buttons**: `#2ecc71`
- **Footer**: `#005f5f`

---

## Design Decisions
The Viridian theme was crafted with deliberate design choices aimed at clarity, trust, and usability for the Baizonn Learning Center's target audience of primarily parents seeking educational support for their children.

### Colour Psychology
- The theme uses light green hues (`#c8ffea`, `#9ad99e`) to resemble the growth, trust, and approachability of an education environment.
- Buttons use vibrant green tones like `#2ecc71` to promote action without being aggressive.
- The footer's dark teal (`#005f5f`) anchors the site and creates visual closure.

### Layout Structure
- Heavy use of white space and centered content blocks enhance readability. Specifically targeting parents who are after information and not distracting interactive elements.
- Flexbox-based layouts and block-based row/column systems ensure responsiveness.
- Full-width content panels and soft gradients (`viridian-baizonn-linear-gradient`) separate content from header and header from navigation.

### Block Styling Automation
- WordPress core blocks are automatically styled through PHP mapping, allowing editors to focus on content without manually assigning classes.
- Layout styles like `viridian-row` and `viridian-stack` are applied dynamically based on block orientation. Again, this removes the need to manually edit class assignments for small alterations.

### Accessibility & Visual Hierarchy
- Headings are styled with serif fonts for contrast, while body text uses sans-serif for legibility.
- Button hover effects and interactive feedback improve responsiveness and aid overall user guidance.
- Content like testimonials and course features are visually highlighted using modular design patterns (`.feature-bubble`, `.viridian-course-section`).

### Custom Components
- Section-specific callouts like `.viridian-promo-box`, `.feature-testimony`, and `.partnership-column` present information in repeatable, theme-coherent blocks that still allow for custom CSS that is too unique to wrap into the base theme.
- The team structured `style.css` into the logical sections shown previously to isolate custom CSS.

---

## Folder & File Highlights
- `style.css`: Contains all base, theme, and member styles.
>1. **Global Styles** — Base layout and presets.
>2. **Viridian Theme Styles** — Core custom theme styles.
>3. **Member Sections** — Custom CSS separated by contributor (Casey, Sam, Lance, Alex).

- `functions.php`: Core logic for block styling and theme setup.
- HTML content is created using the default WordPress block editor.

For more context on where these file fit in the workflow, visit the [Deployment Guide](deployment.md).
   
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

## Dynamically Assigning Custom CSS and Viridian Theme
To showcase how the theme dynamically handles custom CSS, and to prove why a feature that turns off the Viridian theme when custom CSS is detected is useful, see the below example.

### Academic Partner – Page
This page shows how custom CSS can be used alongside the theme with no conflicts between classes. Below is a sample of *some* of the custom classes used on this page.

### Custom Classes

| **Class Name**          | **Description**                                                                                          |
|-------------------------|----------------------------------------------------------------------------------------------------------|
| `.feature-description`  | Sets a max width and overflow for the drop-down description.                                             |
| `.feature-heading`      | Increases font size, colour, and weight.                                                                 |
| `.partnership-column`   | Sets an inner light green layer to a column.                                                             |

---

### Block with custom CSS vs Viridian Theme

| **Custom CSS Block** | **Viridian Theme Block** |
|:--------------------:|:--------------------------:|
| ![Custom CSS block](https://github.com/user-attachments/assets/67a3cc4a-47ed-4dad-b8a9-ccbee9c8cd19) <br> | ![Viridian Theme Block](https://github.com/user-attachments/assets/8ae781ba-5d21-4d9f-b314-f44b8b152e6f) <br> |
| ![Comparison Image 1](https://github.com/user-attachments/assets/8f689c9b-753c-4248-8ba9-b575f4ed5927) | ![Comparison Image 2](https://github.com/user-attachments/assets/40da0980-7cf5-42a6-9aae-0342138754a1) |
