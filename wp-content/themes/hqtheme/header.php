<?php get_template_part('header', 'system'); ?>
<?php do_action('__before_main_wrapper'); ?>

<div id="main-wrapper">
    <?php do_action('__before_main_container'); ?>
    <div id="primary" class="row">
        <?php do_action('__before_article_container'); ##hook of left sidebar?>
        <div id="content" class="<?php echo apply_filters('hq_site_content_class', 'site-content') ?>">
            <?php if (get_theme_mod('hq_header_breadcrumb') && function_exists('bcn_display')) {
               echo '<div class="wrapper-breadcrumb">'; 
				bcn_display();
				echo '</div>';
            }
            ?>