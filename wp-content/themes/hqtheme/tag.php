<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */
?>
<?php get_header(); ?>

<header class="archive-header">
    <h1 class="archive-title"><?php printf(__('Tag Archives: %s', HQTheme::THEME_SLUG), single_tag_title('', false)); ?></h1>

    <?php if (tag_description()) : // Show an optional tag description ?>
        <div class="archive-meta"><?php echo tag_description(); ?></div>
    <?php endif; ?>
</header><!-- .archive-header -->

<?php get_template_part('blog/listing', 'loop'); ?>

<?php get_footer(); ?>