<?php
/*
  Template Name: Coming Soon / Maintenance
  Description: A Page Template for Coming Soon / maintenance Page.
 */
?>
<?php get_template_part('header', 'system'); ?>

<div id="coming-soon">
    <?php
    $logo = get_field('logo');
    $title = get_field('title');
    $subtitle = get_field('subtitle');
    $start_date = get_field('start_date');
    $show_socials = get_field('show_socials');
    if ($logo) {
        echo '<img src="' . $logo['url'] . '" alt="' . $logo['alt'] . '">';
    }
    if ($title) {
        echo '<h1>' . $title . '</h1>';
    }
    if ($subtitle) {
        echo '<h2>' . $subtitle . '</h2>';
    }
    ?>
    <?php /* The loop */ ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
            </div><!-- .entry-content -->
        </article><!-- #post -->

        <?php comments_template(); ?>
    <?php endwhile; ?>

</div><!-- #main-wrapper -->

<?php get_template_part('footer', 'system'); ?>