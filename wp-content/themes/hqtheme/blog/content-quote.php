<?php
/**
 * The template for displaying posts in the Quote post format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(get_field('body_css_class')); ?>>
    <div class="entry-content">
        <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', HQTheme::THEME_SLUG)); ?>
        <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
    </div><!-- .entry-content -->

    <?php if (comments_open()) : ?>
        <span class="comments-link">
            <?php comments_popup_link('<span class="leave-reply">' . __('Leave a comment', HQTheme::THEME_SLUG) . '</span>', __('One comment so far', HQTheme::THEME_SLUG), __('View all % comments', HQTheme::THEME_SLUG)); ?>
        </span><!-- .comments-link -->
    <?php endif; // comments_open() ?>
    <footer class="entry-meta">
        <?php hqtheme_entry_meta(); ?>
        <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post -->
