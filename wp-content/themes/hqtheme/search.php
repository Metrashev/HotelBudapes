<?php
/**
 * The template for displaying Search Results pages
 *
 */
?>
<?php get_header(); ?>

<header class="page-header">
    <h1 class="page-title header-global"><?php printf(__('Search Results for: %s', HQTheme::THEME_SLUG), get_search_query()); ?></h1>
</header>

<?php get_template_part('blog/listing', 'loop'); ?>

<?php get_footer(); ?>