<?php
/**
 * The template for displaying Author archive pages
 */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>

    <?php
    /*
     * Queue the first post, that way we know what author
     * we're dealing with (if that is the case).
     *
     * We reset this later so we can run the loop
     * properly with a call to rewind_posts().
     */
    the_post();
    ?>

    <header class="archive-header">
        <h1 class="archive-title"><?php printf(__('All posts by %s', HQTheme::THEME_SLUG), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>'); ?></h1>
    </header><!-- .archive-header -->

    <?php
    /*
     * Since we called the_post() above, we need to
     * rewind the loop back to the beginning that way
     * we can run the loop properly, in full.
     */
    rewind_posts();
    ?>

    <?php if (get_the_author_meta('description')) : ?>
        <?php get_template_part('views/content/author-bio'); ?>
    <?php endif; ?>
<?php endif; ?>

<?php get_template_part('blog/listing', 'loop'); ?>

<?php get_footer(); ?>