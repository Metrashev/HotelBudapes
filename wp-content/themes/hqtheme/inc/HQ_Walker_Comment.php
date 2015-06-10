<?php
if (!class_exists('HQ_Walker_Comment')) {

    /**
     * HTML comment list class.
     *
     * @uses Walker_Comment
     * @since 1.0.0
     */
    class HQ_Walker_Comment extends Walker_Comment {

        /**
         * Output a comment in the HTML5 format.
         *
         * @access protected
         * @since 1.0.0
         *
         * @see wp_list_comments()
         *
         * @param object $comment Comment to display.
         * @param int    $depth   Depth of comment.
         * @param array  $args    An array of arguments.
         */
        protected function html5_comment($comment, $depth, $args) {
            $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
            ?>
            <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent' : '' ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="comment-info">
                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                    <div>
                        <?php printf(sprintf('<b class="fn">%s</b>', get_comment_author_link())); ?>
                        <a class="time" href="<?php echo esc_url(get_comment_link($comment->comment_ID, $args)); ?>">
                            <time datetime="<?php comment_time('c'); ?>">
                                <?php printf(_x('%1$s <br>at %2$s', '1: date, 2: time'), get_comment_date(), get_comment_time()); ?>
                            </time>
                        </a>
                        <?php comment_reply_link(array_merge($args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                        <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></p>
                        <?php endif; ?>
                    </div><!-- .comment-metadata -->
                </div><!-- .comment-author -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

            </article><!-- .comment-body -->
            <?php
        }

    }

}