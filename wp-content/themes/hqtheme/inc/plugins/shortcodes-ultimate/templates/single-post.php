<div class="hq-posts hq-posts-single-post">
    <?php
    // Prepare marker to show only one post
    $first = true;
    // Posts are found
    if ($posts->have_posts()) {
        while ($posts->have_posts()) :
            $posts->the_post();
            global $post;

            // Show oly first post
            if ($first) {
                $first = false;
                ?>
                <div id="hq-post-<?php the_ID(); ?>" class="hq-post">
                    <h1 class="hq-post-title"><?php the_title(); ?></h1>
                    <div class="hq-post-meta"><?php _e('Posted', 'su'); ?>: <?php the_time(get_option('date_format')); ?> | <a href="<?php comments_link(); ?>" class="hq-post-comments-link"><?php comments_number(__('0 comments', 'su'), __('1 comment', 'su'), __('%n comments', 'su')); ?></a></div>
                    <div class="hq-post-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
            }
        endwhile;
    }
    // Posts not found
    else {
        echo '<h4>' . __('Posts not found', 'su') . '</h4>';
    }
    ?>
</div>