<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 */
?>
</div><!-- #content -->
<?php do_action('__after_article_container'); ##hook of left sidebar ?>
</div><!-- #primary -->
<?php do_action('__after_main_container'); ?>
</div><!-- #main-wrapper -->
<?php do_action('__after_main_wrapper'); ?>
<?php get_template_part('footer', 'system'); ?>