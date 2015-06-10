<?php

// Creating the widget 
class hq_tripadvisor_widget extends WP_Widget {

    protected $_slug;

    function __construct() {
        global $HQ_Tripadvisor;
        $this->_slug = $HQ_Tripadvisor->getSlug();
        parent::__construct(
// Base ID of your widget
                'hq_tripadvisor_widget',
// Widget name will appear in UI
                __('Tripadvisor Widget', $this->_slug),
// Widget description
                array('description' => __('', $this->_slug),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $instance) {
        global $wpdb;

        $args = array(
            'post_type' => $this->_slug,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        echo '<div class="wrapper-tripadvisor-widget"><h3>' . __('Travellers\' Choice', $this->_slug) . '</h3>';
        printf('<div class="tripadvisor-bkg"><div class="tripadvisor-bkg-img"></div></div>
					<div class="wrapper-number">
						<span class="big-number">№%1$s</span>
						<p>of 
							<span>%2$s</span> hotels </br>in 
							<span>Sofia</span>
						</p>
					</div>', get_option($this->_slug . '_possition', ''), get_option($this->_slug . '_total', ''));

        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
            echo '<ul class="tripadvisor-articles">';
            while ($my_query->have_posts()) : $my_query->the_post();
                ?>
                <li>
                    <h4><?php the_title(); ?></h4>
                    <?php the_content(); ?>
                </li>
                <?php
            endwhile;
            echo '<ul>';
        }
        wp_reset_query();  // Restore global post data stomped by the_post().
        
        $write_review = get_option($this->_slug . '_write_review', '');
        $view_all_reviews = get_option($this->_slug . '_view_all_reviews', '');
        
        if ($view_all_reviews) {
            echo '<a class="tripadvisor-read-more" href="'.$view_all_reviews.'">'.__('read more', $this->_slug).'<span class="fa fa-caret-right"></span></a>';
        }
        if ($write_review) {
            echo '<a class="tripadvisor-write-review" href="'.$write_review.'">'.__('write review', $this->_slug).'<span class="fa fa-caret-right"></span></a>';
        }
		
		echo '</div>';
    }

// Widget Backend 
    public function form($instance) {
        
    }

// Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        
    }

}

// Class wpb_widget ends here
// Register and load the widget
function hq_tripadvisor_widget() {
    register_widget('hq_tripadvisor_widget');
}

add_action('widgets_init', 'hq_tripadvisor_widget');
