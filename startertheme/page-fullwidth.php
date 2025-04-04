<?php
/*
* Template Name: Full Width - By Sam
* This removes the side bar and enables full-width content
*/

get_header();
?>

<div class="viridian-full-width-panel">

    <?php while ( have_posts() ) : the_post(); ?>

            <div class="viridian-entry-content">
                <?php get_template_part( 'template-parts/content', 'page' ); ?>   
            </div>
        
    <?php endwhile; ?>

</div>

<?php get_footer(); ?>