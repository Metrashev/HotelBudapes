<?php

class HQ_Admin_Views {

    function __construct() {
        
    }

    public static function about($field, $config) {
        ob_start();
        ?>
        <div id="hq-about-screen">
            <h1><?php _e('Welcome to Shortcodes Ultimate', 'su'); ?> <small><?php _e('A real swiss army knife for WordPress', 'su'); ?></small></h1>
            <div class="sunrise-inline-menu">
                <a href="http://gndev.info/shortcodes-ultimate/" target="_blank"><strong><?php _e('Project homepage', 'su'); ?></strong></a>
                <a href="http://gndev.info/kb/" target="_blank"><?php _e('Documentation', 'su'); ?></a>
                <a href="http://wordpress.org/support/plugin/shortcodes-ultimate/" target="_blank"><?php _e('Support forum', 'su'); ?></a>
                <a href="http://wordpress.org/extend/plugins/shortcodes-ultimate/changelog/" target="_blank"><?php _e('Changelog', 'su'); ?></a>
                <a href="https://github.com/gndev/shortcodes-ultimate" target="_blank"><?php _e('Fork on GitHub', 'su'); ?></a>
            </div>
            <div class="hq-clearfix">
                <div class="hq-about-column">
                    <h3><?php _e('Plugin features', 'su'); ?></h3>
                    <ul>
                        <li><?php _e('40+ amazing shortcodes', 'su'); ?></li>
                        <li><?php _e('Power of CSS3 transitions', 'su'); ?></li>
                        <li><?php _e('Handy shortcodes generator', 'su') ?></li>
                        <li><?php _e('International', 'su'); ?></li>
                        <li><?php _e('Documented API', 'su'); ?></li>
                    </ul>
                </div>
                <div class="hq-about-column">
                    <h3><?php _e('What is a shortcode?', 'su'); ?></h3>
                    <p><?php _e('<strong>Shortcode</strong> is a WordPress-specific code that lets you do nifty things with very little effort.', 'su'); ?></p>
                    <p><?php _e('Shortcodes can embed files or create objects that would normally require lots of complicated, ugly code in just one line. Shortcode = shortcut.', 'su'); ?></p>
                </div>
            </div>
            <div class="hq-clearfix">
                <div class="hq-about-column">
                    <h3><?php _e('How does it works', 'su'); ?></h3>
                    <a href="http://www.youtube.com/watch?v=DR2c266yWEA?autoplay=1&amp;showinfo=0&amp;rel=0&amp;theme=light#" target="_blank" class="hq-demo-video"><img src="<?php echo shortcodes_ultimate_url('assets/images/banners/how-it-works.jpg', SU_PLUGIN_FILE); ?>" alt=""></a>
                </div>
                <div class="hq-about-column">
                    <h3><?php _e('More videos', 'su'); ?></h3>
                    <ul>
                        <li><a href="http://www.youtube.com/watch?v=IjmaXz-b55I" target="_blank"><?php _e('Shortcodes Ultimate Tutorial', 'su'); ?></a></li>
                        <li><a href="http://www.youtube.com/watch?v=YU3Zu6C5ZfA" target="_blank"><?php _e('How to use special widget', 'su'); ?></a></li>
                        <li><a href="http://www.screenr.com/BK0H" target="_blank"><?php _e('How to create Carousel', 'su'); ?></a></li>
                        <li><a href="http://www.youtube.com/watch?v=kCWyO2F7jTw" target="_blank"><?php _e('How to create image gallery', 'su'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        hq_query_asset('css', array('magnific-popup', 'hq-options-page'));
        hq_query_asset('js', array('jquery', 'magnific-popup', 'hq-options-page'));
        return $output;
    }

    public static function custom_css($field, $config) {
        ob_start();
        ?>
        <div id="hq-custom-css-screen">
            <div class="hq-custom-css-originals">
                <p><strong><?php _e('You can overview the original styles to override it', $config['textdomain']); ?></strong></p>
                <div class="sunrise-inline-menu">
                    <a href="<?php echo hq_skin_url('content-shortcodes.css'); ?>">content-shortcodes.css</a>
                    <a href="<?php echo hq_skin_url('box-shortcodes.css'); ?>">box-shortcodes.css</a>
                    <a href="<?php echo hq_skin_url('media-shortcodes.css'); ?>">media-shortcodes.css</a>
                    <a href="<?php echo hq_skin_url('galleries-shortcodes.css'); ?>">galleries-shortcodes.css</a>
                    <a href="<?php echo hq_skin_url('players-shortcodes.css'); ?>">players-shortcodes.css</a>
                    <a href="<?php echo hq_skin_url('other-shortcodes.css'); ?>">other-shortcodes.css</a>
                </div>
                <?php do_action('su/admin/css/originals/after'); ?>
            </div>
            <div class="hq-custom-css-vars">
                <p><strong><?php _e('You can use next variables in your custom CSS', $config['textdomain']); ?></strong></p>
                <code>%home_url%</code> - <?php _e('home url', $config['textdomain']); ?><br/>
                <code>%theme_url%</code> - <?php _e('theme url', $config['textdomain']); ?><br/>
                <code>%plugin_url%</code> - <?php _e('plugin url', $config['textdomain']); ?>
            </div>
            <div id="hq-custom-css-editor">
                <div id="sunrise-field-<?php echo $field['id']; ?>-editor"></div>
                <textarea name="sunrise[<?php echo $field['id']; ?>]" id="sunrise-field-<?php echo $field['id']; ?>" class="regular-text" rows="10"><?php echo stripslashes(get_option($config['prefix'] . $field['id'])); ?></textarea>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        hq_query_asset('css', array('magnific-popup', 'hq-options-page'));
        hq_query_asset('js', array('jquery', 'magnific-popup', 'ace', 'hq-options-page'));
        return $output;
    }

    public static function examples($field, $config) {
        return;
        $output = array();
        $examples = HQ_Data::examples();
        $preview = '<div style="display:none"><div id="hq-examples-window"><div id="hq-examples-preview"></div></div></div>';
        $open = ( isset($_GET['example']) ) ? sanitize_text_field($_GET['example']) : '';
        $open = '<input id="hq_open_example" type="hidden" name="hq_open_example" value="' . $open . '" />';
        foreach ($examples as $group) {
            $items = array();
            if (isset($group['items']))
                foreach ($group['items'] as $item) {
                    $code = ( isset($item['code']) ) ? $item['code'] : shortcodes_ultimate_url('inc/examples/' . $item['id'] . '.example', SU_PLUGIN_FILE);
                    $id = ( isset($item['id']) ) ? $item['id'] : '';
                    $items[] = '<div class="hq-examples-item" data-code="' . $code . '" data-id="' . $id . '" data-mfp-src="#hq-examples-window" style="visibility:hidden"><i class="fa fa-' . $item['icon'] . '"></i> ' . $item['name'] . '</div>';
                }
            $output[] = '<div class="hq-examples-group hq-clearfix"><h2 class="hq-examples-group-title" style="visibility:hidden">' . $group['title'] . '</h2>' . implode('', $items) . '</div>';
        }
        hq_query_asset('css', array('magnific-popup', 'animate', 'font-awesome', 'hq-options-page'));
        hq_query_asset('js', array('jquery', 'magnific-popup', 'hq-options-page'));
        return '<div id="hq-examples-screen">' . implode('', $output) . '</div>' . $preview . $open;
    }

    public static function cheatsheet($field, $config) {
        // Prepare print button
        $print = '<div><a href="javascript:;" id="hq-cheatsheet-print" class="hq-cheatsheet-switch button button-primary button-large">' . __('Printable version', 'su') . '</a><div id="hq-cheatsheet-print-head"><h1>' . __('Shortcodes Ultimate', 'su') . ': ' . __('Cheatsheet', 'su') . '</h1><a href="javascript:;" class="hq-cheatsheet-switch">&larr; ' . __('Back to Dashboard', 'su') . '</a></div></div>';
        // Prepare table array
        $table = array();
        // Table start
        $table[] = '<table><tr><th style="width:20%;">' . __('Shortcode', 'su') . '</th><th style="width:50%">' . __('Attributes', 'su') . '</th><th style="width:30%">' . __('Example code', 'su') . '</th></tr>';
        // Loop through shortcodes
        foreach ((array) HQ_Data::shortcodes() as $name => $shortcode) {
            // Prepare vars
            $icon = ( isset($shortcode['icon']) ) ? $shortcode['icon'] : 'puzzle-piece';
            $shortcode['name'] = ( isset($shortcode['name']) ) ? $shortcode['name'] : $name;
            $attributes = array();
            $example = array();
            $icons = 'icon: music, icon: envelope &hellip; <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">' . __('full list', 'su') . '</a>';
            // Loop through attributes
            if (is_array($shortcode['atts']))
                foreach ($shortcode['atts'] as $id => $data) {
                    // Prepare default value
                    $default = ( isset($data['default']) && $data['default'] !== '' ) ? '<p><em>' . __('Default value', 'su') . ':</em> ' . $data['default'] . '</p>' : '';
                    // Switch attribute types
                    switch ($data['type']) {
                        // Select
                        case 'select':
                            $value = implode(', ', array_keys($data['values']));
                            break;
                        // Slider and number
                        case 'slider':
                        case 'number':
                            $value = $data['min'] . '&hellip;' . $data['max'];
                            break;
                        // Bool
                        case 'bool':
                            $value = 'yes | no';
                            break;
                        // Icon
                        case 'icon':
                            $value = $icons;
                            break;
                        // Color
                        case 'color':
                            $value = __('#RGB and rgba() colors');
                            break;
                        // Default value
                        default:
                            $value = $data['default'];
                            break;
                    }
                    // Check empty value
                    if ($value === '')
                        $value = __('Any text value', 'su');
                    // Extra CSS class
                    if ($id === 'class')
                        $value = __('Any custom CSS classes', 'su');
                    // Add attribute
                    $attributes[] = '<div class="hq-shortcode-attribute"><strong>' . $data['name'] . ' <em>&ndash; ' . $id . '</em></strong><p><em>' . __('Possible values', 'su') . ':</em> ' . $value . '</p>' . $default . '</div>';
                    // Add attribute to the example code
                    $example[] = $id . '="' . $data['default'] . '"';
                }
            // Prepare example code
            $example = '[%prefix_' . $name . ' ' . implode(' ', $example) . ']';
            // Add wrapping code
            if ($shortcode['type'] === 'wrap')
                $example .= esc_textarea($shortcode['content']) . '[/%prefix_' . $name . ']';
            // Change compatibility prefix
            $example = str_replace('%prefix_', hq_cmpt(), $example);
            // Shortcode
            $table[] = '<td>' . '<span class="hq-shortcode-icon">' . HQ_Tools::icon($icon) . '</span>' . $shortcode['name'] . '<br/><em class="hq-shortcode-desc">' . $shortcode['desc'] . '</em></td>';
            // Attributes
            $table[] = '<td>' . implode('', $attributes) . '</td>';
            // Example code
            $table[] = '<td><code contenteditable="true">' . $example . '</code></td></tr>';
        }
        // Table end
        $table[] = '</table>';
        // Query assets
        hq_query_asset('css', array('font-awesome', 'hq-cheatsheet'));
        hq_query_asset('js', array('jquery', 'hq-options-page'));
        // Return output
        return '<div id="hq-cheatsheet-screen">' . $print . implode('', $table) . '</div>';
    }

    public static function addons($field, $config) {
        $output = array();
        $addons = array(
            array(
                'name' => __('New Shortcodes', 'su'),
                'desc' => __('Parallax sections, responsive content slider, pricing tables, vector icons, testimonials, progress bars and even more', 'su'),
                'url' => 'http://gndev.info/shortcodes-ultimate/extra/',
                'image' => shortcodes_ultimate_url('assets/images/banners/extra.png', SU_PLUGIN_FILE)
            ),
            array(
                'name' => __('Maker', 'su'),
                'desc' => __('This add-on allows you to create custom shortcodes. You can easily create any shortcode with different parameters or even override default shortcodes', 'su'),
                'url' => 'http://gndev.info/shortcodes-ultimate/maker/',
                'image' => shortcodes_ultimate_url('assets/images/banners/maker.png', SU_PLUGIN_FILE)
            ),
            array(
                'name' => __('Skins', 'su'),
                'desc' => __('Set of additional skins for Shortcodes Ultimate. It includes skins for accordeons/spoilers, tabs and some other shortcodes', 'su'),
                'url' => 'http://gndev.info/shortcodes-ultimate/skins/',
                'image' => shortcodes_ultimate_url('assets/images/banners/skins.png', SU_PLUGIN_FILE)
            ),
            array(
                'name' => __('Add-ons bundle', 'su'),
                'desc' => __('Get all three add-ons with huge discount!', 'su'),
                'url' => 'http://gndev.info/shortcodes-ultimate/add-ons-bundle/',
                'image' => shortcodes_ultimate_url('assets/images/banners/bundle.png', SU_PLUGIN_FILE)
            ),
        );
        $plugins = array();
        $output[] = '<h2>' . __('Shortcodes Ultimate Add-ons', 'su') . '</h2>';
        $output[] = '<div class="hq-addons-loop hq-clearfix">';
        foreach ($addons as $addon) {
            $output[] = '<div class="hq-addons-item" style="visibility:hidden" data-url="' . $addon['url'] . '"><img src="' . $addon['image'] . '" alt="' . $addon['image'] . '" /><div class="hq-addons-item-content"><h4>' . $addon['name'] . '</h4><p>' . $addon['desc'] . '</p><div class="hq-addons-item-button"><a href="' . $addon['url'] . '" class="button button-primary" target="_blank">' . __('Learn more', 'su') . '</a></div></div></div>';
        }
        $output[] = '</div>';
        if (count($plugins)) {
            $output[] = '<h2>' . __('Other WordPress Plugins', 'su') . '</h2>';
            $output[] = '<div class="hq-addons-loop hq-clearfix">';
            foreach ($plugins as $plugin) {
                $output[] = '<div class="hq-addons-item" style="visibility:hidden" data-url="' . $plugin['url'] . '"><img src="' . $plugin['image'] . '" alt="' . $plugin['image'] . '" /><div class="hq-addons-item-content"><h4>' . $plugin['name'] . '</h4><p>' . $plugin['desc'] . '</p>' . HQ_Shortcodes::button(array('url' => $plugin['url'], 'target' => 'blank', 'style' => 'flat', 'background' => '#FF7654', 'wide' => 'yes', 'radius' => '0'), __('Learn more', 'su')) . '</div></div>';
            }
            $output[] = '</div>';
        }
        hq_query_asset('css', array('animate', 'hq-options-page'));
        hq_query_asset('js', array('jquery', 'hq-options-page'));
        return '<div id="hq-addons-screen">' . implode('', $output) . '</div>';
    }

}
