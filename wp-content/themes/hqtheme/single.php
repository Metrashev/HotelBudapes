<?php

/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
<?php get_header(); ?>

<?php /* The loop */ ?>
<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('blog/single/content', get_post_format()); ?>
    <?php hqtheme_post_nav(); ?>
    <?php comments_template(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>