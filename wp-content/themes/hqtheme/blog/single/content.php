<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(get_field('body_css_class')); ?>>
    <header class="entry-header">
        <?php
        if (get_theme_mod('hq_blog_single_title')) {
            ?>
            <h1 class="entry-title header-global"><?php the_title(); ?></h1>
            <?php
        }
        if (get_theme_mod('hq_blog_single_social')) {
            echo hqtheme_entry_social();
        }
        ?>
        <div class="entry-meta">
            <?php hqtheme_entry_meta();
            ?>
            <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link"><i class="fa fa-pencil-square-o"></i> ', '</span>'); ?>
        </div><!-- .entry-meta -->
        <?php if (has_post_thumbnail() && !post_password_required() && !is_attachment() && (!is_single() || get_theme_mod('hq_blog_single_featured_image'))) : ?>
            <div class="entry-thumbnail">
                <?php the_post_thumbnail('cropped-fullwidth'); ?>
            </div>
        <?php endif; ?>

    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', HQTheme::THEME_SLUG)); ?>
        <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php echo hqtheme_entry_meta_bottom();
        ?>

        <?php if (get_the_author_meta('description') && is_multi_author()) : ?>
            <?php get_template_part('views/content/author-bio'); ?>
        <?php endif; ?>
    </footer><!-- .entry-meta -->
</article><!-- #post -->
