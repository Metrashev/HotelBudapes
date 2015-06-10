<?php
/*
  Template Name: Partners
  Description: A Page Template for Partners Page.
 */
?>
<?php get_header(); ?>

<?php /* The loop */ ?>
<?php while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php if (has_post_thumbnail() && !post_password_required()) : ?>
                <div class="entry-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>

            <h1 class="entry-title header-global"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        </div><!-- .entry-content -->

        <footer class="entry-meta">
            <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
        </footer><!-- .entry-meta -->
    </article><!-- #post -->

    <?php comments_template(); ?>
<?php endwhile; ?>

<?php
$partners = get_field('partners');
foreach ($partners as $partner) {
    echo '<h2>' . $partner['title'] . '</h2>';
    if ($partner['subtitle']) {
        echo '<h3>' . $partner['subtitle'] . '</h3>';
    }
    if ($partner['body']) {
        echo '<p>' . $partner['body'] . '</p>';
    }
    if ($partner['logo']) {
        echo '<img src="' . $partner['logo']['url'] . '" alt="' . $partner['logo']['alt'] . '">';
    }
} // end foreach
?>


<?php get_footer(); ?>