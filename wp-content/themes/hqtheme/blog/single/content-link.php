<?php
/**
 * The template for displaying posts in the Link post format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(get_field('body_css_class')); ?>>
    <header class="entry-header">
        <?php
        if (get_theme_mod('hq_blog_single_title')) {
            ?>

            <h1 class="entry-title header-global">
                <a href="<?php echo esc_url(hqtheme_get_link_url()); ?>"><?php the_title(); ?></a>
            </h1>
            <?php
        }
        ?>

        <div class="entry-meta">
            <?php hqtheme_entry_date(); ?>
            <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', HQTheme::THEME_SLUG)); ?>
        <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
    </div><!-- .entry-content -->

    <?php if (is_single()) : ?>
        <footer class="entry-meta">
            <?php hqtheme_entry_meta(); ?>
            <?php if (get_the_author_meta('description') && is_multi_author()) : ?>
                <?php get_template_part('views/content/author-bio'); ?>
            <?php endif; ?>
        </footer><!-- .entry-meta -->
    <?php endif; // is_single() ?>
</article><!-- #post -->
