<?php

/**
  Plugin Name: Cool Simple Promos
  Plugin URI: http://
  Description: Cool Simple Promos with a lot of options
  Version: 1.0
  Author:
  Author URI: http://
  License: GPLv2 or later
 */
class CoolSimpleItem {

    public $isHQTheme = false;
    protected $_name;
    protected $_slug;
    protected $_custom_meta_fields;
    public $version = '1.0.0';

    public function __construct($name, $slug) {
        $this->_name = $name;
        $this->_slug = $slug;
        global $isHQTheme;
        $this->isHQTheme = $isHQTheme;

        load_plugin_textdomain($this->_slug, false, dirname(plugin_basename(__FILE__)) . '/languages/');

        add_action('init', array($this, 'register'));
        //add_action('add_meta_boxes', array($this, 'add_custom_meta_box'));
        // Field Array
        $this->_custom_meta_fields = array(
            /*
              array(
              'label' => __('URL', $this->_slug),
              'desc' => __('Enter URL of your clients site e.g. www.google.com (optional)', $this->_slug),
              'id' => $prefix . $this->_slug . '-url',
              'type' => 'text'
              ),
              array(
              'label' => __('Testimonial', $this->_slug),
              'desc' => __('Enter a testimonial from your client to be displayed on the single ' . strtolower($this->_name) . ' page (optional)', $this->_slug),
              'id' => $prefix . $this->_slug . '-quote',
              'type' => 'textarea'
              ),
             */
            array(
                'label' => __($this->_name . ' Images', $this->_slug),
                'desc' => __('Upload an image or enter an URL to your portfolio image (optional)', $this->_slug),
                'id' => $this->_slug . '-repeatable-image',
                'type' => 'repeatable'
            )
        );

        // Only load the scripts and css on the a specific custom post type in the admin
        add_action('admin_init', array($this, 'load_my_script'));

        // Add Help message to items pages in admin
        add_action('admin_notices', array($this, 'admin_notice'));

        // Save the Data - Metaboxes
        add_action('save_post', array($this, 'save_custom_meta'));

        /* SETTINGS page  */
        add_action('admin_menu', array($this, 'settings_page'));


        /* Define images */
        add_image_size($this->_slug . '-medium', get_option($this->_slug . '_thumb_size_w', '300'), get_option($this->_slug . '_thumb_size_h', '250'), true);
        add_image_size($this->_slug . '-large', get_option($this->_slug . '_img_size_w', '700'), get_option($this->_slug . '_img_size_h', '400'), true);

        /* SHORTCODE */
        add_shortcode($this->_slug, array($this, 'shortcode_listing'));
        add_shortcode($this->_slug . '_slider', array($this, 'shortcode_slider'));

        /* Frontend STYLES and SCRIPTS */
        add_action('wp_enqueue_scripts', array($this, 'main_style'));
        add_filter('template_include', array($this, 'template_loader'));
        add_filter('hq_add_sections_map', array($this, 'hq_add_sections_map'));
        add_filter('hq_add_setting_controls_map', array($this, 'hq_add_setting_controls_map'));
    }

    function register() {
        $labels = array(
            'name' => __('Cool Simple ' . $this->_name, $this->_slug),
            'singular_name' => __($this->_name . ' Item', $this->_slug),
            'add_new' => __('Add New', $this->_slug),
            'add_new_item' => __('Add New Item', $this->_slug),
            'edit_item' => __('Edit Item', $this->_slug),
            'new_item' => __('New Item', $this->_slug),
            'view_item' => __('View Item', $this->_slug),
            'search_items' => __('Search Items', $this->_slug),
            'not_found' => __('No items found', $this->_slug),
            'not_found_in_trash' => __('No items found in Trash', $this->_slug),
            'parent_item_colon' => __('Parent Item:', $this->_slug),
            'menu_name' => __('Cool Simple ' . $this->_name, $this->_slug)
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'description' => __('Custom Post Type - ' . $this->_name . ' Pages', $this->_slug),
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'taxonomies' => array($this->_slug . '-category', $this->_slug . '-tag'),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => array(
                'slug' => get_option($this->_slug . '_item_slug', 'item'),
                'with_front' => false
            ),
            'capability_type' => 'post'
        );

        register_post_type($this->_slug, $args);
        /*
          // "Categories" Custom Taxonomy
          $labels = array(
          'name' => __($this->_name . ' Categories', $this->_slug),
          'singular_name' => __($this->_name . ' Category', $this->_slug),
          'search_items' => __('Search ' . $this->_name . ' Categories', $this->_slug),
          'all_items' => __('All ' . $this->_name . ' Categories', $this->_slug),
          'parent_item' => __('Parent ' . $this->_name . ' Category', $this->_slug),
          'parent_item_colon' => __('Parent ' . $this->_name . ' Category:', $this->_slug),
          'edit_item' => __('Edit ' . $this->_name . ' Category', $this->_slug),
          'update_item' => __('Update ' . $this->_name . ' Category', $this->_slug),
          'add_new_item' => __('Add New ' . $this->_name . ' Category', $this->_slug),
          'new_item_name' => __('New ' . $this->_name . ' Category Name', $this->_slug),
          'menu_name' => __($this->_name . ' Categories', $this->_slug)
          );

          $args = array(
          'hierarchical' => true,
          'labels' => $labels,
          'show_ui' => true,
          'query_var' => true,
          'rewrite' => array(
          'slug' => get_option($this->_slug . '_item_category_slug', 'item-category'),
          'with_front' => false
          )
          );

          register_taxonomy($this->_slug . '-category', array($this->_slug), $args);

          // "Tags" Custom Taxonomy
          $labels = array(
          'name' => __($this->_name . ' Tags', $this->_slug),
          'singular_name' => __($this->_name . ' Tag', $this->_slug),
          'search_items' => __('Search ' . $this->_name . ' Tags', $this->_slug),
          'all_items' => __('All ' . $this->_name . ' Tags', $this->_slug),
          'parent_item' => __('Parent ' . $this->_name . ' Tag', $this->_slug),
          'parent_item_colon' => __('Parent ' . $this->_name . ' Tags:', $this->_slug),
          'edit_item' => __('Edit ' . $this->_name . ' Tag', $this->_slug),
          'update_item' => __('Update ' . $this->_name . ' Tag', $this->_slug),
          'add_new_item' => __('Add New ' . $this->_name . ' Tag', $this->_slug),
          'new_item_name' => __('New ' . $this->_name . ' Tag Name', $this->_slug),
          'menu_name' => __($this->_name . ' Tags', $this->_slug)
          );

          $args = array(
          'hierarchical' => true,
          'labels' => $labels,
          'show_ui' => true,
          'query_var' => true,
          'rewrite' => array(
          'slug' => get_option($this->_slug . '_item_tag_slug', 'item-tag'),
          'with_front' => false
          )
          );

          register_taxonomy($this->_slug . '-tag', array($this->_slug), $args);
         */
    }

    function add_custom_meta_box() {
        add_meta_box(
                $this->_slug . '_meta_box', // $id
                __($this->_name . ' Settings', $this->_slug), // $title
                array($this, 'show_custom_meta_box'), // $callback
                $this->_slug, // $page
                'normal', // $context
                'high'); // $priority
    }

    function load_my_script() {
        global $pagenow, $typenow;
        if (empty($typenow) && !empty($_GET['post'])) {
            $post = get_post($_GET['post']);
            $typenow = $post->post_type;
        }
        if (is_admin() && $typenow == $this->_slug) {
            if ($pagenow == 'post-new.php' OR $pagenow == 'post.php') {
                wp_enqueue_script($this->_slug, plugins_url('js/admin.js', __FILE__));
                wp_enqueue_style('jquery-ui-custom', plugins_url('css/jquery-ui-custom.css', __FILE__));
            }
        }
    }

    function admin_notice() {
        global $pagenow, $typenow;
        if (empty($typenow) && !empty($_GET['post'])) {
            $post = get_post($_GET['post']);
            $typenow = $post->post_type;
        }
        if (is_admin() && $typenow == $this->_slug) {
            ?>
            <div class="updated">

            </div>
            <?php
        }
    }

    // The Callback Meta Boxes
    function show_custom_meta_box() {
        global $post;
        // Use nonce for verification
        echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

        // Begin the field table and loop
        echo '<table class="form-table">';
        foreach ($this->_custom_meta_fields as $field) {
            // get value of this field if it exists for this post
            $meta = get_post_meta($post->ID, $field['id'], true);
            // begin a table row with
            echo '<tr>
				<th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
				<td>';
            switch ($field['type']) {
                // text
                case 'text':
                    echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />
								<br /><span class="description">' . $field['desc'] . '</span>';
                    break;
                // textarea
                case 'textarea':
                    echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" cols="60" rows="4">' . $meta . '</textarea>
								<br /><span class="description">' . $field['desc'] . '</span>';
                    break;

                // repeatable image
                case 'repeatable':
                    echo '<span class="description">' . $field['desc'] . '</span><ul id="' . $field['id'] . '-repeatable" class="custom_repeatable">';
                    $i = 0;
                    if ($meta) {
                        foreach ($meta as $row) {
                            $image = wp_get_attachment_image_src($row, 'thumbnail');
                            $image = $image[0];
                            echo '<li><span class="sort hndle" title="' . __('Order', $this->_slug) . '">|||</span>
                        <input name="' . $field['id'] . '[' . $i . ']" id="' . $field['id'] . '" type="hidden" class="custom_upload_image" value="' . $row . '" />
						<img name="' . $field['id'] . '[' . $i . ']" id="' . $field['id'] . '" src="' . $image . '" class="custom_preview_image" alt="" style="width:30px;height:30px;" />
						<input name="' . $field['id'] . '[' . $i . ']" class="custom_upload_image_button button" type="button" value="' . __('Choose Image', $this->_slug) . '" />
						<a class="repeatable-remove button" href="#">' . __('Remove', $this->_slug) . '</a></li>';
                            $i++;
                        }
                    } else {
                        $row = '';
                        $image = wp_get_attachment_image_src($row, 'thumbnail');
                        $image = $image[0];
                        echo '<li><span class="sort hndle">|||</span>
						<input name="' . $field['id'] . '[' . $i . ']" id="' . $field['id'] . '" type="hidden" class="custom_upload_image" value="' . $row . '" />
						<img name="' . $field['id'] . '[' . $i . ']" id="' . $field['id'] . '" src="' . $image . '" class="custom_preview_image" alt="" style="width:30px;height:30px;" />
						<input name="' . $field['id'] . '[' . $i . ']" class="custom_upload_image_button button" type="button" value="' . __('Choose Image', $this->_slug) . '" />
						<a class="repeatable-remove button" href="#">' . __('Remove', $this->_slug) . '</a></li>';
                    }
                    echo '</ul><a class="repeatable-add button" href="#" style="margin-left:250px;">' . __('Add New Image', $this->_slug) . '</a>';
                    break;
            } //end switch
            echo '</td></tr>';
        } // end foreach
        echo '</table>'; // end table
    }

    function save_custom_meta($post_id) {

        // verify nonce
        // if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))

        if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
            return $post_id;
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // loop through fields and save the data
        foreach ($this->_custom_meta_fields as $field) {
            if ($field['type'] == 'tax_select')
                continue;
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        } // enf foreach
    }

    function settings_page() {
        if (!$this->isHQTheme) {
            add_submenu_page('edit.php?post_type=' . $this->_slug, __('Settings', $this->_slug), __($this->_name . ' Settings', $this->_slug), 'edit_posts', basename(__FILE__), array($this, 'settings'));
            add_action('admin_init', array($this, 'service_settings_store'));
        }
    }

    function service_settings_store() {
        register_setting('service_settings', $this->_slug . '_thumb_size_w');
        register_setting('service_settings', $this->_slug . '_thumb_size_h');
        register_setting('service_settings', $this->_slug . '_img_size_w');
        register_setting('service_settings', $this->_slug . '_img_size_h');
        register_setting('service_settings', $this->_slug . '_item_slug');
        register_setting('service_settings', $this->_slug . '_item_category_slug');
        register_setting('service_settings', $this->_slug . '_item_tag_slug');
    }

    function settings() {
        ?>
        <div class="wrap">
            <h2><?php _e($this->_name . ' Settings', $this->_slug); ?></h2>
            <form method="post" action="options.php">
                <?php settings_fields('service_settings'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e($this->_name . ' Thumnbail Size (Archive)', $this->_slug); ?> </th>
                        <td>
                            <label for="<?php echo $this->_slug ?>_thumb_size_w"><?php _e('Width (in px)', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_thumb_size_w" value="<?php echo get_option($this->_slug . '_thumb_size_w', '300'); ?>" /> <?php _e('(default is 303)', $this->_slug); ?><br />
                            <label for="<?php echo $this->_slug ?>_thumb_size_h"><?php _e('Height (in px)', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_thumb_size_h" value="<?php echo get_option($this->_slug . '_thumb_size_h', '250'); ?>" /> <?php _e('(default is 210)', $this->_slug); ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e($this->_name . ' Image Size (Single)', $this->_slug); ?> </th>
                        <td>
                            <label for="<?php echo $this->_slug ?>_img_size_w"><?php _e('Width (in px)', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_img_size_w" value="<?php echo get_option($this->_slug . '_img_size_w', '700'); ?>" /> <?php _e('(default is 700)', $this->_slug); ?><br />
                            <label for="<?php echo $this->_slug ?>_img_size_h"><?php _e('Height (in px)', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_img_size_h" value="<?php echo get_option($this->_slug . '_img_size_h', '400'); ?>" /> <?php _e('(default is 400)', $this->_slug); ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e($this->_name . ' Slugs', $this->_slug); ?> </th>
                        <td>
                            <label for="<?php echo $this->_slug ?>_item_slug"><?php _e('Item Slug', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_item_slug" value="<?php echo get_option($this->_slug . '_item_slug', 'item'); ?>" /> <?php _e('(default is "item")', $this->_slug); ?><br />
                            <label for="<?php echo $this->_slug ?>_item_category_slug"><?php _e('Category Slug', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_item_category_slug" value="<?php echo get_option($this->_slug . '_item_category_slug', 'item-category'); ?>" /> <?php _e('(default is "item-category")', $this->_slug); ?><br />
                            <label for="<?php echo $this->_slug ?>_item_tag_slug"><?php _e('Tag Slug', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_item_tag_slug" value="<?php echo get_option($this->_slug . '_item_tag_slug', 'item-tag'); ?>" /> <?php _e('(default is "item-tag")', $this->_slug); ?>
                        </td>
                    </tr>
                </table>
                <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes', $this->_slug); ?>" /></p>
            </form>
        </div>
        <?php
    }

    function hq_add_sections_map($add_sections) {
        $add_sections['hq_' . $this->_slug . '_settings'] = array(
            'title' => __($this->_name, $this->_slug),
        );
        return $add_sections;
    }

    function hq_add_setting_controls_map($add_setting_controls) {
        $section = 'hq_' . $this->_slug . '_settings';
        $setting_controls = array(
            'hq_' . $this->_slug . '_layout' => array(
                'default' => 'normal',
                'label' => __($this->_name . ' Layout', HQTheme::THEME_SLUG),
                'section' => $section,
                'type' => 'select',
                'choices' => array(
                    'normal' => 'Normal',
                    'grid' => 'Grid',
                )
            ),
            'hq_' . $this->_slug . '_sidebar_left' => array(
                'default' => 0,
                'label' => __($this->_name . ' Sidebar Left', HQTheme::THEME_SLUG),
                'section' => $section,
                'type' => 'select',
                'choices' => HQTheme_Customize::getInstance()->getAvailableSidebars()
            ),
            'hq_' . $this->_slug . '_sidebar_right' => array(
                'default' => 0,
                'label' => __($this->_name . ' Sidebar Right', HQTheme::THEME_SLUG),
                'section' => $section,
                'type' => 'select',
                'choices' => HQTheme_Customize::getInstance()->getAvailableSidebars()
            ),
            'hq_' . $this->_slug . '_pagination' => array(
                'default' => 0,
                'label' => __($this->_name . ' Infinite scroll', HQTheme::THEME_SLUG),
                'section' => $section,
                'type' => 'checkbox',
            ),
                /*
                  'woocommerce_single_page' => array(
                  'setting_type' => null,
                  'control' => 'HQTheme_Controls',
                  'section' => $section,
                  'type' => 'sub-title',
                  'label' => __('Product Page Options', HQTheme::THEME_SLUG),
                  ),
                  'hq_' . $this->_slug . '_single_title' => array(
                  'default' => 1,
                  'label' => __('Product Title', HQTheme::THEME_SLUG),
                  'section' => $section,
                  'type' => 'checkbox',
                  ),
                  'hq_' . $this->_slug . '_single_ratings' => array(
                  'default' => 1,
                  'label' => __('Product Ratings', HQTheme::THEME_SLUG),
                  'section' => $section,
                  'type' => 'checkbox',
                  ),
                  'hq_' . $this->_slug . '_single_social' => array(
                  'default' => 1,
                  'label' => __('Product Social Shares', HQTheme::THEME_SLUG),
                  'section' => $section,
                  'type' => 'checkbox',
                  ),
                  'hq_' . $this->_slug . '_single_prev_next' => array(
                  'default' => 1,
                  'label' => __('Previous / Next Links', HQTheme::THEME_SLUG),
                  'section' => $section,
                  'type' => 'checkbox',
                  ),
                 */
        ); //end of layout_options
        return array_merge(
                $add_setting_controls, $setting_controls
        );
    }

    function shortcode_listing($atts) {
        global $wpdb;

        $args = array(
            'post_type' => $this->_slug,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
            echo '<ul class="promotions">';
            while ($my_query->have_posts()) : $my_query->the_post();
                ?>
                <li class="promo-list">
                    <h3><?php the_title(); ?></h3>
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                        <?php _e('view more', 'hq_csp'); ?>
                    <span class="fa fa-caret-right"></span></a>
                </li>
                <?php
            endwhile;
            echo '</ul>';
        }
        wp_reset_query();  // Restore global post data stomped by the_post().
    }

    function shortcode_slider($atts) {
        global $wpdb;

        $args = array(
            'post_type' => $this->_slug,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $my_query = null;
        $my_query = new WP_Query($args);
        $promos = array();
        if ($my_query->have_posts()) {
            while ($my_query->have_posts()) : $my_query->the_post();
                ?>
        				<ul class="wrapper-home-promotions">
        					<li class="promo-list">
        						<h3><?php the_title(); ?></h3>
        						<?php the_excerpt(); ?>
        						<?php
        						if (has_post_thumbnail()) {
        							the_post_thumbnail();
        						}
        						?>
        						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
        							<?php _e('view more', 'hq_csp'); ?>
        						<span class="fa fa-caret-right"></span></a>
        					</li>
        				</ul>
                <?php
            endwhile;
        }
        wp_reset_query();  // Restore global post data stomped by the_post().
    }

    function shortcode_tags($atts) {
        global $wpdb;

        $terms = get_terms($this->_slug . '-tag');
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<ul>';
            foreach ($terms as $term) {
                echo '<li><a href="' . get_term_link($term, $this->_slug . '-tag') . '">' . $term->name . '</li>';
            }
            echo '</ul>';
        }
        wp_reset_query();  // Restore global post data stomped by the_post().
    }

    function main_style() { // FIX + VERSION
        wp_register_style($this->_slug, plugins_url('/otw-portfolio-light/css/otw-portfolio.css'), array(), $this->version, 'all');
        wp_enqueue_style($this->_slug);
    }

    function scripts_styles() {
        wp_register_script('flexslider-customjs', plugins_url('/css/flexslider-custom/flexslider-customjs.js', __FILE__), array(), false, $this->version);
        wp_enqueue_script('flexslider-customjs');

        /* Custom Theme JS */
        wp_register_script($this->_slug, plugins_url('/js/' . $this->_slug . '.js', __FILE__), array(), false, $this->version);
        wp_enqueue_script($this->_slug);
    }

    /* ----------------------------------------------------------------------------------- */
    /* Pagination */
    /* ----------------------------------------------------------------------------------- */

    function pagination() { // used from templates
        wp_link_pages(array('before' => '<div class="page-links">' . __('Pages:', $this->_slug), 'after' => '</div>'));
    }

    function getSlug() { // used from templates
        return $this->_slug;
    }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url() {
        return untrailingslashit(plugins_url('/', __FILE__));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit(plugin_dir_path(__FILE__));
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path() {
        return $this->_slug . '/';
    }

    public function template_loader($template) {
        $template_path = $this->template_path();

        $find = array('cool-simple-portfolio.php');
        $file = '';
        //var_dump( get_post_type(), is_single(), is_tax());

        if (is_single() && get_post_type() == $this->_slug) {
            $file = 'single.php';
            $find[] = $file;
            $find[] = $template_path . $file;
        } elseif (is_tax()) {
            $term = get_queried_object();
            if (is_tax($this->_slug . '_cat') || is_tax($this->_slug . '_tag')) {
                $file = 'taxonomy-' . $term->taxonomy . '.php';
            } else {
                $file = 'archive.php';
            }

            $find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
            $find[] = $template_path . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
            $find[] = 'taxonomy-' . $term->taxonomy . '.php';
            $find[] = $template_path . 'taxonomy-' . $term->taxonomy . '.php';
            $find[] = $file;
            $find[] = $template_path . $file;
        } elseif (is_post_type_archive($this->_slug)) {
            $file = 'archive.php';
            $find[] = $file;
            $find[] = $template_path . $file;
        }
        //var_dump($file, $find);

        if ($file) {
            if (file_exists($this->plugin_path() . "/templates/{$file}")) {
                $template = $this->plugin_path() . "/templates/{$file}";
            } else {
                $template = locate_template(array_unique($find));
            }
        }

        return $template;
    }

    public function get_option($option_name, $default_value) {
        if ($this->isHQTheme) {
            get_theme_mod($this->_slug . '_' . $option_name, $default_value);
        } else {
            get_option($this->_slug . '_' . $option_name, $default_value);
        }
    }

}

$CoolSimplePromo = new CoolSimpleItem('Promos', 'hqcs_promos');
?>