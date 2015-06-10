<?php
/*
  Template Name: Contact
  Description: A Page Template for Contact Page.
 */
?>

<?php get_header(); ?>

<?php the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php $disableTitle = get_field('disable_page_title'); ?>
        <?php if (!$disableTitle) :
            ?>
            <h1 class="entry-title header-global"><?php the_title(); ?></h1>
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        the_content();
        $gmap = get_field('google_map');
        if ($gmap) {
            echo do_shortcode('[gmap width="600" height="400" responsive="yes" address="' . $gmap['address'] . '"]');
        }
        $contact_form = get_field('contact_form');
        if ($contact_form) {
            echo do_shortcode($contact_form);
        }
        $contact_info = get_field('contact_info');
        if ($contact_info) {
            echo do_shortcode($contact_info);
        }
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
<?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post -->

<?php comments_template(); ?>

<?php get_footer(); ?>