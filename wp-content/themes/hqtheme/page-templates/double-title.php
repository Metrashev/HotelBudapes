<?php
/*
  Template Name: Doublee Title
  Description: A Page Template for Page.
 */
?>

<?php get_header(); ?>

<?php /* The loop */ ?>
<?php while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
			<?php HQTheme_FeaturedContent::$instance->featured_images(); ?>
            <?php $disableTitle = get_field('disable_page_title'); ?>
            <?php if (!$disableTitle) :
                ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php endif; ?>

        </header><!-- .entry-header -->

        <div class="entry-content">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php the_content(); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        </div><!-- .entry-content -->
        <footer class="entry-meta">
            <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
        </footer><!-- .entry-meta -->
    </article><!-- #post -->

    <?php comments_template(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>