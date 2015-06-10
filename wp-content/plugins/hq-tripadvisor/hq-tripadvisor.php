<?php

/**
  Plugin Name: HQ Tripadvisor
  Plugin URI: http://
  Description: Tripadvisor score & latest reviews
  Version: 1.0
  Author:
  Author URI: http://
  License: GPLv2 or later
 */
class HQ_Tripadvisor {

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
        add_action('add_meta_boxes', array($this, 'add_custom_meta_box'));


        // Only load the scripts and css on the a specific custom post type in the admin
        add_action('admin_init', array($this, 'load_my_script'));

        /* SETTINGS page  */
        add_action('admin_menu', array($this, 'settings_page'));
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

    function settings_page() {
        if (!$this->isHQTheme) {
            add_submenu_page('edit.php?post_type=' . $this->_slug, __('Settings', $this->_slug), __($this->_name . ' Settings', $this->_slug), 'edit_posts', basename(__FILE__), array($this, 'settings'));
            add_action('admin_init', array($this, 'service_settings_store'));
        }
    }

    function service_settings_store() {
        register_setting('service_settings', $this->_slug . '_possition');
        register_setting('service_settings', $this->_slug . '_total');
		register_setting('service_settings', $this->_slug . '_write_review');
        register_setting('service_settings', $this->_slug . '_view_all_reviews');
    }

    function settings() {
        ?>
        <div class="wrap">
            <h2><?php _e($this->_name . ' Settings', $this->_slug); ?></h2>
            <form method="post" action="options.php">
                <?php settings_fields('service_settings'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Possition', $this->_slug); ?> </th>
                        <td>
                            <label for="<?php echo $this->_slug ?>_possition"><?php _e('Possition in Tripadvisor', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_possition" value="<?php echo get_option($this->_slug . '_possition', ''); ?>" /> <?php _e('(default is "")', $this->_slug); ?><br />
                            <label for="<?php echo $this->_slug ?>_total"><?php _e('Total hotels in Sofia', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_total" value="<?php echo get_option($this->_slug . '_total', ''); ?>" /> <?php _e('(default is "")', $this->_slug); ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('URLs', $this->_slug); ?> </th>
                        <td>
                            <label for="<?php echo $this->_slug ?>_write_review"><?php _e('Write review URL', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_write_review" value="<?php echo get_option($this->_slug . '_write_review', ''); ?>" /> <?php _e('(default is "")', $this->_slug); ?><br />
                            <label for="<?php echo $this->_slug ?>_view_all_reviews"><?php _e('View all reviews URL', $this->_slug); ?></label> <input type="text" name="<?php echo $this->_slug ?>_view_all_reviews" value="<?php echo get_option($this->_slug . '_view_all_reviews', ''); ?>" /> <?php _e('(default is "")', $this->_slug); ?>
                        </td>
                    </tr>
                </table>
                <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes', $this->_slug); ?>" /></p>
            </form>
        </div>
        <?php
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

    public function get_option($option_name, $default_value) {
        if ($this->isHQTheme) {
            get_theme_mod($this->_slug . '_' . $option_name, $default_value);
        } else {
            get_option($this->_slug . '_' . $option_name, $default_value);
        }
    }

}

$HQ_Tripadvisor = new HQ_Tripadvisor('Tripadvisor', 'hqcs_tripadvisor');
require dirname(__FILE__) . '/widget.php';
?>