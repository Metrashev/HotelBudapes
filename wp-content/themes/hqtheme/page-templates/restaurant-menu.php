<?php
/*
  Template Name: Restaurant Menu
  Description: A Page Template for Restaurant Menu.
 */
  ?>

  <?php get_header(); ?>

  <?php /* The loop */ ?>
  <?php while (have_posts()) : the_post(); ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php HQTheme_FeaturedContent::$instance->featured_images(); ?>

        <?php $disableTitle = get_field('disable_page_title'); ?>
        <?php if (!$disableTitle) :
        ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php endif; ?>

</header><!-- .entry-header -->

<div class="entry-content">
    <?php the_content(); ?>
    <?php
    $sections = get_field('sections');
    $enable_dish_image = get_field('enable_dish_image');
    echo '<div class="wrapper-restourant-menu">';
    foreach ($sections as $section) {
        $css_class = $section['css_class'];

        if ($section['section_name']) {
            echo "<h3 class=\"$css_class\">{$section['section_name']}</h3>";
        }
        if (count($section['dishes'])) {
            echo "<table id=\"hui\" class=\"$css_class\">";
            foreach ($section['dishes'] as $dish) {
                echo "<tr><td>{$dish['name']}</td><td>{$dish['weight']}</td><td>{$dish['price']}</td>";
                if ($enable_dish_image) {
                    echo '<td>';
                    if ($dish['image']) {
                        echo '<img src="' . $dish['image']["sizes"]['medium'] . '" alt="' . $dish['image']['title'] . '">';
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    echo '</div>';
    ?>
</div><!-- .entry-content -->
<footer class="entry-meta">
    <?php edit_post_link(__('Edit', HQTheme::THEME_SLUG), '<span class="edit-link">', '</span>'); ?>
</footer><!-- .entry-meta -->
</article><!-- #post -->

<?php comments_template(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>