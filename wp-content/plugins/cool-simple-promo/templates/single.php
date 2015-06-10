<?php
/**
 * The template for displaying single item
 *
 */
?>

<?php get_header(); ?>

<?php /* The loop */ ?>
<?php while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if (get_post_meta($post->ID, 'otw_head_title_setting_pfl', true) != 1) { ?>
            <div class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </div>
        <?php } ?>

        <div class="categories"><?php the_taxonomies(); ?> <?php edit_post_link(__('Edit Post', 'hq_csp'), '<span class="edit-link">', '</span><br /><br />'); ?></div><br />

        <div class="entry-content">
            <?php the_content(); ?>
            <!-- Portfolio Meta Content -->
            <?php if (get_post_meta($post->ID, 'custom_cool-simple-portfolio-url', true)) { ?>
                <div class="visit-site"><a href="http://<?php echo get_post_meta($post->ID, 'custom_cool-simple-portfolio-url', true); ?>"><?php _e('Visit site', 'hq_csp'); ?></a></div>
            <?php } ?>

            <?php if (get_post_meta($post->ID, 'custom_cool-simple-portfolio-quote', true)) { ?>
                <blockquote class="otw-sc-quote bordered">
                    <p><?php echo get_post_meta($post->ID, 'custom_cool-simple-portfolio-quote', true); ?></p>
                </blockquote>
            <?php } ?>
            <!-- END Portfolio Meta Content -->
        </div>

        <nav class="nav-single">
            <h3 class="assistive-text"><?php _e('Post navigation', 'hq_csp'); ?></h3>
            <span class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'hq_csp') . '</span> %title'); ?></span>
            <span class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'hq_csp') . '</span>'); ?></span>
        </nav><!-- .nav-single -->

        <?php // comments_template( '', true );  ?>
    </article><!-- #post -->

    <?php comments_template(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>