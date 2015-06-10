<?php
/*
  Template Name: FAQ
  Description: A Page Template for FAQ Page.
 */
?>
<?php get_header(); ?>

<?php /* The loop */ ?>
<?php while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php if (has_post_thumbnail() && !post_password_required()) : ?>
                <div class="entry-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>

            <h1 class="entry-title header-global"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', HQTheme::THEME_SLUG) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        </div><!-- .entry-content -->
        
        <footer class="entry-meta">
            <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
        </footer><!-- .entry-meta -->
    </article><!-- #post -->

    <?php comments_template(); ?>
<?php endwhile; ?>

<?php
$sections = get_field('section');
$tableOfContents = get_field('enable_table_of_contents');

$faqs = '';
$table = '<ul>';

foreach ($sections as $section) {
    $table .= '<li>';
    if ($section["section_name"]) {
        $table .= '<h3><a href="#faqs-' . str_replace('"', '', $section["section_name"]) . '">' . $section["section_name"] . '</a></h3>';
        $faqs .= '<h3 id="faqs-' . str_replace('"', '', $section["section_name"]) . '">' . $section["section_name"] . '</h3>';
    }
    $table .= '<ul>';
    foreach ($section['questions'] as $question) {
        $table .= '<li>';
        $table .= '<h4><a href="#faqq-' . str_replace('"', '', $question['question']) . '">' . $question['question'] . '</a></h4>';
        $faqs .= '<p id="faqq-' . str_replace('"', '', $question['question']) . '">' . $question['answer'] . '</p>';
        $table .= '</li>';
    }
    $table .= '</ul>';
    $table .= '</li>';
}
$table .= '</ul>';
if ($tableOfContents) {
    echo $table;
}
echo $faqs;
?>


<?php get_footer(); ?>