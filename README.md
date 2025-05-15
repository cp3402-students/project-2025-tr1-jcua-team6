# README

## Viridian — Custom WordPress Theme
Developed by Casey Summers, Samuel Barrett, and Alex Johnstone as members of JCU Group 6 for the subject CP3402

## Overview
This repository contains the custom WordPress theme **Viridian**, developed from the [Underscores](https://underscores.me/) starter theme as part of the CP3402 project to create a simple website for the company [Baizonn](https://baizonnlearningctr.com/) using some provided raw content. The theme focuses on several shades and hues of gentle greens to showcase a clean and modern aesthetic tailored to an inviting learning environment. The clarity, structure, and content of the theme target parents of students:
- Primary School 1-6 students
- Secondary School 1-4 students
- Junior College 1-2 students

Thus, the theme purposefully incorporates extra spacing, center-aligned elements, and subtle highlights to draw attention to areas of interest. Additionally, few interactive elements have been included to prevent parents from becoming distracted or confused by site elements not related to the **main goal of registering new students**. 

For more information on how the theme works, please visit the [Theme Developer Guide](theme.md).

---

## Members (A-Z):
Alex Johnstone | [LinkedIn Profile](https://www.linkedin.com/in/alexander-johnstone-b93793117/) | [GitHub Profile](https://github.com/alexjohnstone29) <br>
Casey Summers | [LinkedIn Profile](https://www.linkedin.com/in/casey-summers-b2ba3a30a/) | [GitHub Profile](https://github.com/Casey-Summers) <br>
Samuel Barrett | [LinkedIn Profile](https://www.linkedin.com/in/sam-barrett-388526356/) | [GitHub Profile](https://github.com/SamBarrett1) <br>

## Live Links
- **Production site**: [Baizonn Website](http://09042025.xyz) | [WP Admin](http://09042025.xyz/wp-admin/) (password not provided)
- **Staging site**: [Baizonn Website](http://209.38.89.77) | [WP Admin](http://209.38.89.77/wp-admin/) (password not provided)

## Documentation
- [Deployment Guide](deployment.md)
- [Theme Developer Guide](theme.md)
- [Site Management Guide](site.md)

---

## Features
- Automatic mapping between core block and Viridian styles based on block types (headings, paragraphs, groups, columns, etc)
  - Uses PHP code to retrieve classes assigned to core blocks and injects custom theme alongside core theme
  - > Viridian Class Name Format:
    > `.viridian`-`blocktype`-`specifer` (specifer optional)
- Dynamic layout styling for row/stack blocks which do not have naive core WordPress elements
  - Uses PHP code to detect class change between `is-horizonal` and `is-vertical` to apply respective styles automatically
- Dynamic custom CSS and theme style resolution
  - Custom CSS will automatically overwrite theme styles, which allows for further customisation 
- Responsive design with accessible colour contrasts
  - Uses automated GitHub Actions to push changes made to the staging environment (via pull requests) to the staging website 
- Modular and logically segmented CSS with dedicated team member sections. See below:

> ``` CSS
> /* ============================================
>  Group Member / Custom Styles (Casey's Section)
>   ============================================ */
>
> /* uses custom PHP handling for rows and stacks since they are not native 'core' elements. 
> This allows the viridian theme to center both elements with spacing automatically*/
> .viridian-row {
>	justify-content: center;
>    gap: 2em;
>}
>
>.viridian-stack {
>   align-content: center;
>   gap: 5px;
>   max-width: 50%;
>   margin: 0 auto;
> }
> ```

# Viridian Showcase (by Casey)
Note: This is NOT the group presentation, simply an additional showcase video that displays how the `Viridian` theme was successfully imported onto a fresh WordPress site. It also shows the design features of the theme, and how they can be used without conflicting with custom CSS.

[![Watch the video](https://img.youtube.com/vi/Wax6U_wEa3I/0.jpg)](https://youtu.be/Wax6U_wEa3I)

