<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(get_field('body_css_class')); ?>>
    <header class="entry-header">
        <h2 class="entry-title header-global">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
        <div class="entry-meta">
            <?php hqtheme_entry_meta(); ?>
        </div><!-- .entry-meta -->
        <?php if (has_post_thumbnail() && !post_password_required() && !is_attachment() && (!is_single() || get_theme_mod('hq_blog_single_featured_image'))) : ?>
            <div class="entry-thumbnail">
                <?php the_post_thumbnail('cropped-fullwidth'); ?>
            </div>
        <?php endif; ?>

    </header><!-- .entry-header -->

    <?php if (!is_single() && !get_theme_mod('hq_blog_excerpt_off')) : ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', HQTheme::THEME_SLUG)); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php echo hqtheme_entry_meta_bottom(); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post -->
