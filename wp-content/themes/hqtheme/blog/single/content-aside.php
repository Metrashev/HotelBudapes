<?php
/**
 * The template for displaying posts in the Aside post format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(get_field('body_css_class')); ?>>
    <div class="entry-content">
        <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', HQTheme::THEME_SLUG)); ?>
        <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php hqtheme_entry_meta(); ?>
        <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>

        <?php if (get_the_author_meta('description') && is_multi_author()) : ?>
            <?php get_template_part('views/content/author-bio'); ?>
        <?php endif; ?>
    </footer><!-- .entry-meta -->
</article><!-- #post -->
