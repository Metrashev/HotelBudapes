<?php
/**
 * The template for displaying Post Format pages
 *
 * Used to display archive-type pages for posts with a post format.
 * If you'd like to further customize these Post Format views, you may create a
 * new template file for each specific one.
 */
?>
<?php get_header(); ?>

<header class="archive-header">
    <h1 class="archive-title"><?php printf(__('%s Archives', HQTheme::THEME_SLUG), '<span>' . get_post_format_string(get_post_format()) . '</span>'); ?></h1>
</header><!-- .archive-header -->

<?php get_template_part('blog/listing', 'loop'); ?>

<?php get_footer(); ?>