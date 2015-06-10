<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 */
?>
<?php get_header(); ?>
<header class="archive-header">
    <h1 class="archive-title"><?php
        if (is_day()) :
            printf(__('Daily Archives: %s', HQTheme::THEME_SLUG), get_the_date());
        elseif (is_month()) :
            printf(__('Monthly Archives: %s', HQTheme::THEME_SLUG), get_the_date(_x('F Y', 'monthly archives date format', HQTheme::THEME_SLUG)));
        elseif (is_year()) :
            printf(__('Yearly Archives: %s', HQTheme::THEME_SLUG), get_the_date(_x('Y', 'yearly archives date format', HQTheme::THEME_SLUG)));
        else :
            _e('Archives', HQTheme::THEME_SLUG);
        endif;
        ?></h1>
</header><!-- .archive-header -->
<?php get_template_part('blog/listing', 'loop'); ?>

<?php get_footer(); ?>