<?php
/**
 * The template for displaying a "No posts found" messagetwentythirteen_
 */
?>

<header class="page-header">
    <h2 class="page-title header-global"><?php _e('Nothing Found', HQTheme::THEME_SLUG); ?></h2>
</header>

<div class="page-content">
    <?php if (is_home() && current_user_can('publish_posts')) : ?>

        <p><?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', HQTheme::THEME_SLUG), admin_url('post-new.php')); ?></p>

    <?php elseif (is_search()) : ?>

        <p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', HQTheme::THEME_SLUG); ?></p>
        <?php get_search_form(); ?>

    <?php else : ?>

        <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', HQTheme::THEME_SLUG); ?></p>
        <?php get_search_form(); ?>

    <?php endif; ?>
</div><!-- .page-content -->
