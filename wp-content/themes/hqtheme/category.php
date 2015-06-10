<?php
/**
 * The template for displaying Category pages
 *
 */
?>
<?php get_header(); ?>
<header class="archive-header">
    <h1 class="archive-title"><?php printf(__('Category Archives: %s', HQTheme::THEME_SLUG), single_cat_title('', false)); ?></h1>

    <?php if (category_description()) : // Show an optional category description ?>
        <div class="archive-meta"><?php echo category_description(); ?></div>
    <?php endif; ?>
</header><!-- .archive-header -->

<?php get_template_part('blog/listing', 'loop'); ?>

<?php get_footer(); ?>