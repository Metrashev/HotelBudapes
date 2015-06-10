<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 */
?>
<?php get_header(); ?>

<?php

if (get_theme_mod('hq_blog_title')) {
    echo '<h1>' . get_theme_mod('hq_blog_title') . '</h1>';
}
if (get_theme_mod('hq_blog_subtitle')) {
    echo '<h2>' . get_theme_mod('hq_blog_subtitle') . '</h2>';
}
?>
<?php get_template_part('blog/listing', 'loop'); ?>

<?php get_footer(); ?>