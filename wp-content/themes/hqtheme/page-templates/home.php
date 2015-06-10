<?php
/*
  Template Name: Home page
  Description: A Page Template for Home page.
 */
?>
<?php get_header(); ?>

<?php /* The loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php HQTheme_FeaturedContent::$instance->featured_images(); ?>
            <?php $disableTitle = get_field( 'disable_page_title' ); ?>
            <?php if ( !$disableTitle ) :
                ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php endif; ?>

        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            $args = array(
                'sort_order' => 'ASC',
                'sort_column' => 'post_date',
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'meta_key' => '',
                'meta_value' => '',
                'authors' => '',
                'child_of' => 0,
                'parent' => 59,
                'exclude_tree' => '',
                'number' => '',
                'offset' => 0,
                'post_type' => 'page',
                'post_status' => 'publish'
            );
            $pages = get_pages( $args );
            ?>
            <div id="hq_slider_home-promo" class="hq-slider hq-slider-centered hq-slider-pages-yes hq-slider-responsive-yes" style="width:100%" data-autoplay="5000" data-speed="600" data-mousewheel="true">
                <div class="hq-slider-slides">
                    <?php
                    foreach ( $pages as $page ) {
                        echo '<div class="hq-slider-slide">';
                        echo '<h4>' . $page->post_title . '</h4>';
                        echo '<div class="promo-content">' . $page->post_excerpt . ''
                        . '<a href="' . get_permalink( $page->ID ) . '">&raquo;</a></div>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="hq-slider-nav"><div class="hq-slider-pagination"></div></div></div>

        </div><!-- .entry-content -->
        <?php generated_dynamic_sidebar( 'custom-sidebar-homebottom', 'home-bottom'); ?>
        <div id="shares">
            <div class="tripadvisor-share"><img src="<?php echo get_template_directory_uri(); ?>/images/trip_advisor_rate.png"></div>
            <div class="facebook-share" fb-iframe-plugin-query="app_id=548107685216460&amp;color_scheme=dark&amp;container_width=0&amp;font=arial&amp;href=https%3A%2F%2Fwww.facebook.com%2FHotelBudaPestSofia&amp;locale=en_GB&amp;sdk=joey&amp;send=false&amp;show_faces=false&amp;width=450" fb-xfbml-state="rendered" class="fb-like fb_iframe_widget" data-href="https://www.facebook.com/HotelBudaPestSofia" data-send="false" data-width="450" data-show-faces="false" data-colorscheme="dark" data-font="arial"><span style="vertical-align: bottom; width: 450px; height: 20px;"><iframe class="" src="http://www.facebook.com/plugins/like.php?app_id=548107685216460&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2F6Dg4oLkBbYq.js%3Fversion%3D41%23cb%3Df3371936acf15%26domain%3Dwww.hotelbudapest.bg%26origin%3Dhttp%253A%252F%252Fwww.hotelbudapest.bg%252Ff38e572a996a04%26relation%3Dparent.parent&amp;color_scheme=dark&amp;container_width=0&amp;font=arial&amp;href=https%3A%2F%2Fwww.facebook.com%2FHotelBudaPestSofia&amp;locale=en_GB&amp;sdk=joey&amp;send=false&amp;show_faces=false&amp;width=450" style="border: medium none; visibility: visible; width: 450px; height: 20px;" title="fb:like Facebook Social Plugin" scrolling="no" allowtransparency="true" name="fb70d918b4d17a" frameborder="0" height="1000px" width="450px"></iframe></span></div>
        </div>
        <footer class="entry-meta">
            <?php edit_post_link( __( 'Edit', HQTheme::THEME_SLUG ), '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-meta -->
    </article><!-- #post -->

    <?php comments_template(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>