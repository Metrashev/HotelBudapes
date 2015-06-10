<?php
/**
 * The template for displaying 404 pages (Not Found)
 */
?>
<?php get_header(); ?>

<header class="page-header">
    <h1 class="page-title header-global"><?php _e('Not Found', HQTheme::THEME_SLUG); ?></h1>
</header>

<div class="page-wrapper">
    <div class="page-content">
        <h2><?php _e('This is somewhat embarrassing, isn&rsquo;t it?', HQTheme::THEME_SLUG); ?></h2>
        <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', HQTheme::THEME_SLUG); ?></p>

        <?php get_search_form(); ?>
    </div><!-- .page-content -->
</div><!-- .page-wrapper -->

<?php get_footer(); ?>