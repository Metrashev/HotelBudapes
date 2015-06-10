<?php if (have_posts()) : ?>
    <div id="articles" class="promotions-wrapper">
        <?php /* The loop */ ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('blog/content', get_post_format()); ?>
        <?php endwhile; ?>
    </div>
    <?php hqtheme_paging_nav(); ?>
<?php else : ?>
    <?php get_template_part('blog/content', 'none'); ?>
<?php endif; ?>