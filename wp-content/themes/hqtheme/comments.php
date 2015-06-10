<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 */
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required())
    return;
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            printf(_nx('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', HQTheme::THEME_SLUG), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'walker' => new HQ_Walker_Comment(),
                'style' => 'div',
                'short_ping' => true,
                'avatar_size' => 74,
            ));
            ?>
        </ol><!-- .comment-list -->

        <?php
        // Are there comments to navigate through?
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h1 class="screen-reader-text section-heading"><?php _e('Comment navigation', HQTheme::THEME_SLUG); ?></h1>
                <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', HQTheme::THEME_SLUG)); ?></div>
                <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', HQTheme::THEME_SLUG)); ?></div>
            </nav><!-- .comment-navigation -->
        <?php endif; // Check for comment navigation  ?>

        <?php if (!comments_open() && get_comments_number()) : ?>
            <p class="no-comments"><?php _e('Comments are closed.', HQTheme::THEME_SLUG); ?></p>
        <?php endif; ?>

    <?php endif; // have_comments() ?>

    <?php

    function modify_comment_form_fields($fields) {
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');

        $fields['author'] = '<div id="row"><input type="text" name="author" id="author" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . __('Name (required)', HQTheme::THEME_SLUG) . '" size="22" tabindex="1" aria-required="true" class="input-name" />';

        $fields['email'] = '<input type="text" name="email" id="email" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . __("Email" . ( $req ? ' (required)' : '' ), HQTheme::THEME_SLUG) . '" size="22" tabindex="2"' . ( $req ? 'aria-required="true"' : '' ) . ' class="input-email"  />';

        $fields['url'] = '<input type="text" name="url" id="url" value="' . esc_attr($commenter['comment_author_url']) . '" placeholder="' . __('Website', HQTheme::THEME_SLUG) . '" size="22" tabindex="3" class="input-website" /></div>';

        return $fields;
    }

    add_filter('comment_form_default_fields', 'modify_comment_form_fields');
    $comments_args = array(
        'comment_field' => '<p class="comment-form-comment"><label for="comment"></label> <textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . _x('Comment', 'noun') . '" aria-required="true"></textarea></p>',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
    );

    comment_form($comments_args);
    ?>

</div><!-- #comments -->