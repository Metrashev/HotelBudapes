<?php
/**
 * The template for displaying posts in the Audio post format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(get_field('body_css_class')); ?>>
    <header class="entry-header">
        <h2 class="entry-title header-global">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <div class="audio-content">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', HQTheme::THEME_SLUG)); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        </div><!-- .audio-content -->
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php hqtheme_entry_meta(); ?>
        <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post -->
