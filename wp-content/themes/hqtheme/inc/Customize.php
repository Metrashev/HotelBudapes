<?php

if (!class_exists('HQTheme_Customize')) {

    /**
     * Contains methods for customizing the theme customization screen.
     * 
     * @link http://codex.wordpress.org/Theme_Customization_API
     * @since HQTheme 1.0
     */
    class HQTheme_Customize {

        /**
         * 
         * @var HQTheme_Customize
         */
        protected static $_instance;
        protected $_settings;

        public static function getInstance() {
            if (empty(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Init Customizer
         * 
         * @since HQTheme 1.0 
         */
        public function __construct() {
            self::$_instance = & $this;

            // Setup the Theme Customizer settings and controls...
            add_action('customize_register', array('HQTheme_Customize', 'register'));

            add_action('customize_controls_print_styles', array($this, 'customize_controls_print_styles'));
            add_action('customize_controls_print_footer_scripts', array($this, 'enqueue_customizer_app_scripts'));

            // Enqueue live preview javascript in Theme Customizer admin screen
            add_action('customize_preview_init', array('HQTheme_Customize', 'live_preview'));
            // LESS Compiler
            //add_action('customize_preview_init', array($this, 'parseLess'));
            // Register "New" admin menu bar menu TODO
            // add_action('admin_bar_menu', array($this, 'admin_bar'), 999);


            require get_template_directory() . '/inc/Customize_Settings.php';

            //$this->exportConfig(1); die;
        }

        function parseLess() { // HQTODO
            require get_template_directory() . '/inc/less.php/Less.php';
            $options = array(
                'compress' => true,
            );
            $parser = new Less_Parser($options);

            $parser->parseFile(get_template_directory() . '/../bootstrap/less/hq-base.less', 'http://hqtheme/wp-content/themes/hqtheme/css/');
            $parser->ModifyVars(array('hq_layout_background_color' => get_theme_mod('hq_layout_background_color')));
            $css = $parser->getCss();
            file_put_contents(get_template_directory() . '/css/hq-base.css', $css);
        }

        function exportConfig($default = false) {
            /** Get all options and defaults */
            $count = 0;
            foreach ($this->_add_setting_controls as $key => $val) {
                if (isset($val['type']) && !in_array($val['type'], array('description', 'sub-title', 'warning', 'link'))) {
                    if ($default) {
                        echo $key . ': {value: \'' . (isset($val['default']) ? $val['default'] : '') . '\'},' . "\n";
                    } else {
                        echo $key . ': {value: \'' . get_theme_mod($key) . '\'},' . "\n";
                    }
                    $count++;
                }
            }
            echo "\n\n Exported params count: $count";
            die;
        }

        /**
         * This hooks into 'customize_register' (available as of WP 3.4) and allows
         * you to add new sections and controls to the Theme Customize screen.
         * 
         * Note: To enable instant preview, we have to actually write a bit of custom
         * javascript. See live_preview() for more.
         *  
         * @see add_action('customize_register',$func)
         * @param \WP_Customize_Manager $wp_customize
         * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
         * @since HQTheme 1.0
         */
        public static function register($wp_customize) {

            require_once dirname(__FILE__) . '/Controls.php';

            foreach (Customize_Settings::getInstance()->remove_sections as $section) {
                $wp_customize->remove_section($section);
            }

            $priority = 0;
            foreach (Customize_Settings::getInstance()->add_sections as $sectionKey => $section) {
                // Define a new section (if desired) to the Theme Customizer
                $sectionOptions = array(
                    'title' => $section['title'], // Visible title of section
                    'capability' => 'edit_theme_options', //Capability needed to tweak
                );

                $sectionOptions['priority'] = $priority++; //Determines what order this appears in

                if (isset($section['description'])) {
                    $sectionOptions['description'] = $section['description']; //Descriptive tooltip
                }
                $wp_customize->add_section($sectionKey, $sectionOptions);
            }

            $priority = 0;
            foreach (Customize_Settings::getInstance()->add_setting_controls as $controlKey => $control) {
                // Register new settings to the WP database...
                $wp_customize->add_setting($controlKey, //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
                        array(
                    'default' => isset($control['default']) ? $control['default'] : '', //Default setting/value to save
                    'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                    'capability' => isset($control['capability']) ? $control['capability'] : 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                    'transport' => isset($control['update_type']) ? $control['update_type'] : 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                        )
                );

                // Finally, we define the control itself (which links a setting to a section and renders the HTML controls)..
                $options = array(
                    'label' => isset($control['label']) ? $control['label'] : '', //Admin-visible name of the control
                    'section' => $control['section'], //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                    'settings' => $controlKey, //Which setting to load and manipulate (serialized is okay)
                    'priority' => isset($control['priority']) ? $control['priority'] : $priority++, //Determines the order this control appears in for the specified section defaut 100
                    'choices' => isset($control['choices']) ? $control['choices'] : array(),
                    'additionalOptions' => isset($control['additionalOptions']) ? $control['additionalOptions'] : array(),
                );
                if (isset($control['type'])) {
                    $options['type'] = $control['type']; // Element Type
                }

                if (isset($control['custom_options'])) {
                    $options = array_merge($options, $control['custom_options']); // Add custom controller options
                }

                if (!isset($control['control'])) {
                    $wp_customize->add_control($controlKey, $options);
                } else {
                    $wp_customize->add_control(new $control['control']($wp_customize, $controlKey, $options));
                }
            }

            foreach (Customize_Settings::getInstance()->transport_settings as $transportSetting) {
                // We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
                $wp_customize->get_setting($transportSetting)->transport = 'postMessage';
            }
        }

        /**
         * Get defaults for switch_theme in functions.php
         * @return array
         */
        public function getDefaults() {
            $defaults = array();
            foreach ($this->_add_setting_controls as $key => $control) {
                if (isset($control['default'])) {
                    $defaults[$key] = $control['default'];
                }
            }
            return $defaults;
        }

        /**
         * This outputs the javascript needed to automate the live settings preview.
         * Also keep in mind that this function isn't necessary unless your settings 
         * are using 'transport'=>'postMessage' instead of the default 'transport'
         * => 'refresh'
         * 
         * Used by hook: 'customize_preview_init'
         * 
         * @see add_action('customize_preview_init',$func)
         * @since HQTheme 1.0
         */
        public static function live_preview() {
            wp_enqueue_script(
                    HQTheme::THEME_SLUG . '-themecustomizer', // Give the script a unique ID
                    get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
                    array('jquery', 'customize-preview'), // Define dependencies
                    HQTheme::VERSION, // Define a version (optional) 
                    true // Specify whether to put in footer (leave this true)
            );
        }

        /**
         * Load styles for customizer bar
         */
        public static function customize_controls_print_styles() {
            // Main customizer
            wp_register_style(HQTheme::THEME_SLUG . '-customizer', get_template_directory_uri() . '/css/admin/customizer.css', NULL, NULL, 'all');
            wp_enqueue_style(HQTheme::THEME_SLUG . '-customizer');
            // Color picker
            wp_register_style(HQTheme::THEME_SLUG . '-spectrum', get_template_directory_uri() . '/css/admin/spectrum.css', NULL, NULL, 'all');
            wp_enqueue_style(HQTheme::THEME_SLUG . '-spectrum');
        }

        /**
         * Load scripts for customizer bar
         */
        public static function enqueue_customizer_app_scripts() {
            // Main customizer
            wp_register_script(HQTheme::THEME_SLUG . '-customizer-js', get_template_directory_uri() . '/js/admin/customizer.js', array('jquery'), NULL, true);
            wp_enqueue_script(HQTheme::THEME_SLUG . '-customizer-js');
            // Color picker
            wp_register_script(HQTheme::THEME_SLUG . '-spectrum-js', get_template_directory_uri() . '/js/admin/spectrum.js', array('jquery'), NULL, true);
            wp_enqueue_script(HQTheme::THEME_SLUG . '-spectrum-js');
        }

        /**
         * adds sanitization callback funtion : textarea
         */
        function sanitize_textarea($value) {
            $value = esc_html($value);
            return $value;
        }

        /**
         * adds sanitization callback funtion : number
         */
        function sanitize_number($value) {
            $value = esc_attr($value); // clean input
            $value = (int) $value; // Force the value into integer type.
            return ( 0 < $value ) ? $value : null;
        }

        /**
         * adds sanitization callback funtion : colors
         */
        function sanitize_hex_color($color) {
            if ($unhashed = sanitize_hex_color_no_hash($color))
                return '#' . $unhashed;

            return $color;
        }

        /**
         * Change upload's path to relative instead of absolute
         */
        function sanitize_uploads($url) {
            $upload_dir = wp_upload_dir();
            return str_replace($upload_dir['baseurl'], '', $url);
        }

        /**
         * Generate Social Links Settigs
         * @return array
         */
        function generates_socials_links() {
            $socials = $this->get_social_links();
            $socials_setting_control = array();

            foreach ($socials as $key => $data) {
                $socials_setting_control['hq_social_links_' . $key] = array(
                    'default' => ( isset($data['default']) && !is_null($data['default']) ) ? $data['default'] : null,
                    'sanitize_callback' => 'esc_url',
                    'control' => 'HQTheme_Controls',
                    'label' => ( isset($data['option_label']) ) ? call_user_func('__', $data['option_label'], HQTheme::THEME_SLUG) : $key,
                    'section' => 'hq_social_links_settings',
                    'type' => 'url',
                );
            }

            return $socials_setting_control;
        }

        function get_social_links() {
            //Default social networks
            $socials = array(
                'rss' => array(
                    'link_title' => __('Subscribe to my rss feed', HQTheme::THEME_SLUG),
                    'option_label' => __('RSS feed (default is the wordpress feed)', HQTheme::THEME_SLUG),
                    'default' => get_bloginfo('rss_url'),
                ),
                'twitter' => array(
                    'link_title' => __('Follow me on Twitter', HQTheme::THEME_SLUG),
                    'option_label' => __('Twitter profile url', HQTheme::THEME_SLUG),
                    'icon' => 'fa-twitter',
                    'default' => null,
                ),
                'facebook' => array(
                    'link_title' => __('Follow me on Facebook', HQTheme::THEME_SLUG),
                    'option_label' => __('Facebook profile url', HQTheme::THEME_SLUG),
                    'icon' => 'fa-facebook',
                    'default' => null,
                ),
                'google' => array(
                    'link_title' => __('Follow me on Google+', HQTheme::THEME_SLUG),
                    'option_label' => __('Google+ profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-google-plus',
                ),
                'instagram' => array(
                    'link_title' => __('Follow me on Instagram', HQTheme::THEME_SLUG),
                    'option_label' => __('Instagram profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-instagram',
                ),
                'wordpress' => array(
                    'link_title' => __('Follow me on WordPress', HQTheme::THEME_SLUG),
                    'option_label' => __('WordPress profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-wordpress',
                ),
                'youtube' => array(
                    'link_title' => __('Follow me on Youtube', HQTheme::THEME_SLUG),
                    'option_label' => __('Youtube profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-youtube',
                ),
                'pinterest' => array(
                    'link_title' => __('Pin me on Pinterest', HQTheme::THEME_SLUG),
                    'option_label' => __('Pinterest profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-pinterest',
                ),
                'github' => array(
                    'link_title' => __('Follow me on Github', HQTheme::THEME_SLUG),
                    'option_label' => __('Github profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-github',
                ),
                'dribbble' => array(
                    'link_title' => __('Follow me on Dribbble', HQTheme::THEME_SLUG),
                    'option_label' => __('Dribbble profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-dribbble',
                ),
                'linkedin' => array(
                    'link_title' => __('Follow me on LinkedIn', HQTheme::THEME_SLUG),
                    'option_label' => __('LinkedIn profile url', HQTheme::THEME_SLUG),
                    'default' => null,
                    'icon' => 'fa-linkedin',
                )
            ); //end of social array

            return apply_filters('hq_default_social_links', $socials);
        }

        /**
         * Generate Social Shares Settigs
         * @return array
         */
        function generates_socials_shares() {
            //Default social networks
            $socials = array(
                'twitter' => array(
                    'link_title' => __('Twitter Share', HQTheme::THEME_SLUG),
                    'option_label' => __('Twitter', HQTheme::THEME_SLUG),
                    'default' => null
                ),
                'facebook' => array(
                    'link_title' => __('Facebook Share', HQTheme::THEME_SLUG),
                    'option_label' => __('Facebook', HQTheme::THEME_SLUG),
                    'default' => null
                ),
                'google' => array(
                    'link_title' => __('Google+ Share', HQTheme::THEME_SLUG),
                    'option_label' => __('Google+', HQTheme::THEME_SLUG),
                    'default' => null
                ),
                'pinterest' => array(
                    'link_title' => __('Pinterest Share', HQTheme::THEME_SLUG),
                    'option_label' => __('Pinterest', HQTheme::THEME_SLUG),
                    'default' => null
                ),
                'linkedin' => array(
                    'link_title' => __('LinkedIn Share', HQTheme::THEME_SLUG),
                    'option_label' => __('LinkedIn', HQTheme::THEME_SLUG),
                    'default' => null
                ),
                'reddit' => array(
                    'link_title' => __('Reddit Share', HQTheme::THEME_SLUG),
                    'option_label' => __('Reddit', HQTheme::THEME_SLUG),
                    'default' => null
                ),
                'email' => array(
                    'link_title' => __('E-mail Share', HQTheme::THEME_SLUG),
                    'option_label' => __('E-mail', HQTheme::THEME_SLUG),
                    'default' => null
                ),
            ); //end of social array

            $socials = apply_filters('hq_default_social_shares', $socials);

            $socials_setting_control = array();

            foreach ($socials as $key => $data) {
                $socials_setting_control['hq_social_share_' . $key] = array(
                    'default' => ( isset($data['default']) && !is_null($data['default']) ) ? $data['default'] : null,
                    'sanitize_callback' => 'esc_url',
                    'label' => ( isset($data['option_label']) ) ? call_user_func('__', $data['option_label'], HQTheme::THEME_SLUG) : $key,
                    'section' => 'hq_social_shares_settings',
                    'type' => 'checkbox',
                );
            }

            return $socials_setting_control;
        }

        public function getAvailableSidebars() {
            global $wp_registered_sidebars;
            $sidebar_options = array(0 => 'none');

            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebar_options[$sidebar['id']] = $sidebar['name'];
            }
            return $sidebar_options;
        }

        /**
         * Google fonts array
         * @var array
         */
        public $google_fonts = array(
            "ABeeZee" => "ABeeZee",
            "Abel" => "Abel",
            "Abril Fatface" => "Abril Fatface",
            "Aclonica" => "Aclonica",
            "Acme" => "Acme",
            "Actor" => "Actor",
            "Adamina" => "Adamina",
            "Advent Pro" => "Advent Pro",
            "Aguafina Script" => "Aguafina Script",
            "Akronim" => "Akronim",
            "Aladin" => "Aladin",
            "Aldrich" => "Aldrich",
            "Alef" => "Alef",
            "Alegreya" => "Alegreya",
            "Alegreya SC" => "Alegreya SC",
            "Alegreya Sans" => "Alegreya Sans",
            "Alegreya Sans SC" => "Alegreya Sans SC",
            "Alex Brush" => "Alex Brush",
            "Alfa Slab One" => "Alfa Slab One",
            "Alice" => "Alice",
            "Alike" => "Alike",
            "Alike Angular" => "Alike Angular",
            "Allan" => "Allan",
            "Allerta" => "Allerta",
            "Allerta Stencil" => "Allerta Stencil",
            "Allura" => "Allura",
            "Almendra" => "Almendra",
            "Almendra Display" => "Almendra Display",
            "Almendra SC" => "Almendra SC",
            "Amarante" => "Amarante",
            "Amaranth" => "Amaranth",
            "Amatic SC" => "Amatic SC",
            "Amethysta" => "Amethysta",
            "Anaheim" => "Anaheim",
            "Andada" => "Andada",
            "Andika" => "Andika",
            "Angkor" => "Angkor",
            "Annie Use Your Telescope" => "Annie Use Your Telescope",
            "Anonymous Pro" => "Anonymous Pro",
            "Antic" => "Antic",
            "Antic Didone" => "Antic Didone",
            "Antic Slab" => "Antic Slab",
            "Anton" => "Anton",
            "Arapey" => "Arapey",
            "Arbutus" => "Arbutus",
            "Arbutus Slab" => "Arbutus Slab",
            "Architects Daughter" => "Architects Daughter",
            "Archivo Black" => "Archivo Black",
            "Archivo Narrow" => "Archivo Narrow",
            "Arimo" => "Arimo",
            "Arizonia" => "Arizonia",
            "Armata" => "Armata",
            "Artifika" => "Artifika",
            "Arvo" => "Arvo",
            "Asap" => "Asap",
            "Asset" => "Asset",
            "Astloch" => "Astloch",
            "Asul" => "Asul",
            "Atomic Age" => "Atomic Age",
            "Aubrey" => "Aubrey",
            "Audiowide" => "Audiowide",
            "Autour One" => "Autour One",
            "Average" => "Average",
            "Average Sans" => "Average Sans",
            "Averia Gruesa Libre" => "Averia Gruesa Libre",
            "Averia Libre" => "Averia Libre",
            "Averia Sans Libre" => "Averia Sans Libre",
            "Averia Serif Libre" => "Averia Serif Libre",
            "Bad Script" => "Bad Script",
            "Balthazar" => "Balthazar",
            "Bangers" => "Bangers",
            "Basic" => "Basic",
            "Battambang" => "Battambang",
            "Baumans" => "Baumans",
            "Bayon" => "Bayon",
            "Belgrano" => "Belgrano",
            "Belleza" => "Belleza",
            "BenchNine" => "BenchNine",
            "Bentham" => "Bentham",
            "Berkshire Swash" => "Berkshire Swash",
            "Bevan" => "Bevan",
            "Bigelow Rules" => "Bigelow Rules",
            "Bigshot One" => "Bigshot One",
            "Bilbo" => "Bilbo",
            "Bilbo Swash Caps" => "Bilbo Swash Caps",
            "Bitter" => "Bitter",
            "Black Ops One" => "Black Ops One",
            "Bokor" => "Bokor",
            "Bonbon" => "Bonbon",
            "Boogaloo" => "Boogaloo",
            "Bowlby One" => "Bowlby One",
            "Bowlby One SC" => "Bowlby One SC",
            "Brawler" => "Brawler",
            "Bree Serif" => "Bree Serif",
            "Bubblegum Sans" => "Bubblegum Sans",
            "Bubbler One" => "Bubbler One",
            "Buda" => "Buda",
            "Buenard" => "Buenard",
            "Butcherman" => "Butcherman",
            "Butterfly Kids" => "Butterfly Kids",
            "Cabin" => "Cabin",
            "Cabin Condensed" => "Cabin Condensed",
            "Cabin Sketch" => "Cabin Sketch",
            "Caesar Dressing" => "Caesar Dressing",
            "Cagliostro" => "Cagliostro",
            "Calligraffitti" => "Calligraffitti",
            "Cambo" => "Cambo",
            "Candal" => "Candal",
            "Cantarell" => "Cantarell",
            "Cantata One" => "Cantata One",
            "Cantora One" => "Cantora One",
            "Capriola" => "Capriola",
            "Cardo" => "Cardo",
            "Carme" => "Carme",
            "Carrois Gothic" => "Carrois Gothic",
            "Carrois Gothic SC" => "Carrois Gothic SC",
            "Carter One" => "Carter One",
            "Caudex" => "Caudex",
            "Cedarville Cursive" => "Cedarville Cursive",
            "Ceviche One" => "Ceviche One",
            "Changa One" => "Changa One",
            "Chango" => "Chango",
            "Chau Philomene One" => "Chau Philomene One",
            "Chela One" => "Chela One",
            "Chelsea Market" => "Chelsea Market",
            "Chenla" => "Chenla",
            "Cherry Cream Soda" => "Cherry Cream Soda",
            "Cherry Swash" => "Cherry Swash",
            "Chewy" => "Chewy",
            "Chicle" => "Chicle",
            "Chivo" => "Chivo",
            "Cinzel" => "Cinzel",
            "Cinzel Decorative" => "Cinzel Decorative",
            "Clicker Script" => "Clicker Script",
            "Coda" => "Coda",
            "Coda Caption" => "Coda Caption",
            "Codystar" => "Codystar",
            "Combo" => "Combo",
            "Comfortaa" => "Comfortaa",
            "Coming Soon" => "Coming Soon",
            "Concert One" => "Concert One",
            "Condiment" => "Condiment",
            "Content" => "Content",
            "Contrail One" => "Contrail One",
            "Convergence" => "Convergence",
            "Cookie" => "Cookie",
            "Copse" => "Copse",
            "Corben" => "Corben",
            "Courgette" => "Courgette",
            "Cousine" => "Cousine",
            "Coustard" => "Coustard",
            "Covered By Your Grace" => "Covered By Your Grace",
            "Crafty Girls" => "Crafty Girls",
            "Creepster" => "Creepster",
            "Crete Round" => "Crete Round",
            "Crimson Text" => "Crimson Text",
            "Croissant One" => "Croissant One",
            "Crushed" => "Crushed",
            "Cuprum" => "Cuprum",
            "Cutive" => "Cutive",
            "Cutive Mono" => "Cutive Mono",
            "Damion" => "Damion",
            "Dancing Script" => "Dancing Script",
            "Dangrek" => "Dangrek",
            "Dawning of a New Day" => "Dawning of a New Day",
            "Days One" => "Days One",
            "Delius" => "Delius",
            "Delius Swash Caps" => "Delius Swash Caps",
            "Delius Unicase" => "Delius Unicase",
            "Della Respira" => "Della Respira",
            "Denk One" => "Denk One",
            "Devonshire" => "Devonshire",
            "Didact Gothic" => "Didact Gothic",
            "Diplomata" => "Diplomata",
            "Diplomata SC" => "Diplomata SC",
            "Domine" => "Domine",
            "Donegal One" => "Donegal One",
            "Doppio One" => "Doppio One",
            "Dorsa" => "Dorsa",
            "Dosis" => "Dosis",
            "Dr Sugiyama" => "Dr Sugiyama",
            "Droid Sans" => "Droid Sans",
            "Droid Sans Mono" => "Droid Sans Mono",
            "Droid Serif" => "Droid Serif",
            "Duru Sans" => "Duru Sans",
            "Dynalight" => "Dynalight",
            "EB Garamond" => "EB Garamond",
            "Eagle Lake" => "Eagle Lake",
            "Eater" => "Eater",
            "Economica" => "Economica",
            "Electrolize" => "Electrolize",
            "Elsie" => "Elsie",
            "Elsie Swash Caps" => "Elsie Swash Caps",
            "Emblema One" => "Emblema One",
            "Emilys Candy" => "Emilys Candy",
            "Engagement" => "Engagement",
            "Englebert" => "Englebert",
            "Enriqueta" => "Enriqueta",
            "Erica One" => "Erica One",
            "Esteban" => "Esteban",
            "Euphoria Script" => "Euphoria Script",
            "Ewert" => "Ewert",
            "Exo" => "Exo",
            "Exo 2" => "Exo 2",
            "Expletus Sans" => "Expletus Sans",
            "Fanwood Text" => "Fanwood Text",
            "Fascinate" => "Fascinate",
            "Fascinate Inline" => "Fascinate Inline",
            "Faster One" => "Faster One",
            "Fasthand" => "Fasthand",
            "Fauna One" => "Fauna One",
            "Federant" => "Federant",
            "Federo" => "Federo",
            "Felipa" => "Felipa",
            "Fenix" => "Fenix",
            "Finger Paint" => "Finger Paint",
            "Fjalla One" => "Fjalla One",
            "Fjord One" => "Fjord One",
            "Flamenco" => "Flamenco",
            "Flavors" => "Flavors",
            "Fondamento" => "Fondamento",
            "Fontdiner Swanky" => "Fontdiner Swanky",
            "Forum" => "Forum",
            "Francois One" => "Francois One",
            "Freckle Face" => "Freckle Face",
            "Fredericka the Great" => "Fredericka the Great",
            "Fredoka One" => "Fredoka One",
            "Freehand" => "Freehand",
            "Fresca" => "Fresca",
            "Frijole" => "Frijole",
            "Fruktur" => "Fruktur",
            "Fugaz One" => "Fugaz One",
            "GFS Didot" => "GFS Didot",
            "GFS Neohellenic" => "GFS Neohellenic",
            "Gabriela" => "Gabriela",
            "Gafata" => "Gafata",
            "Galdeano" => "Galdeano",
            "Galindo" => "Galindo",
            "Gentium Basic" => "Gentium Basic",
            "Gentium Book Basic" => "Gentium Book Basic",
            "Geo" => "Geo",
            "Geostar" => "Geostar",
            "Geostar Fill" => "Geostar Fill",
            "Germania One" => "Germania One",
            "Gilda Display" => "Gilda Display",
            "Give You Glory" => "Give You Glory",
            "Glass Antiqua" => "Glass Antiqua",
            "Glegoo" => "Glegoo",
            "Gloria Hallelujah" => "Gloria Hallelujah",
            "Goblin One" => "Goblin One",
            "Gochi Hand" => "Gochi Hand",
            "Gorditas" => "Gorditas",
            "Goudy Bookletter 1911" => "Goudy Bookletter 1911",
            "Graduate" => "Graduate",
            "Grand Hotel" => "Grand Hotel",
            "Gravitas One" => "Gravitas One",
            "Great Vibes" => "Great Vibes",
            "Griffy" => "Griffy",
            "Gruppo" => "Gruppo",
            "Gudea" => "Gudea",
            "Habibi" => "Habibi",
            "Hammersmith One" => "Hammersmith One",
            "Hanalei" => "Hanalei",
            "Hanalei Fill" => "Hanalei Fill",
            "Handlee" => "Handlee",
            "Hanuman" => "Hanuman",
            "Happy Monkey" => "Happy Monkey",
            "Headland One" => "Headland One",
            "Henny Penny" => "Henny Penny",
            "Herr Von Muellerhoff" => "Herr Von Muellerhoff",
            "Holtwood One SC" => "Holtwood One SC",
            "Homemade Apple" => "Homemade Apple",
            "Homenaje" => "Homenaje",
            "IM Fell DW Pica" => "IM Fell DW Pica",
            "IM Fell DW Pica SC" => "IM Fell DW Pica SC",
            "IM Fell Double Pica" => "IM Fell Double Pica",
            "IM Fell Double Pica SC" => "IM Fell Double Pica SC",
            "IM Fell English" => "IM Fell English",
            "IM Fell English SC" => "IM Fell English SC",
            "IM Fell French Canon" => "IM Fell French Canon",
            "IM Fell French Canon SC" => "IM Fell French Canon SC",
            "IM Fell Great Primer" => "IM Fell Great Primer",
            "IM Fell Great Primer SC" => "IM Fell Great Primer SC",
            "Iceberg" => "Iceberg",
            "Iceland" => "Iceland",
            "Imprima" => "Imprima",
            "Inconsolata" => "Inconsolata",
            "Inder" => "Inder",
            "Indie Flower" => "Indie Flower",
            "Inika" => "Inika",
            "Irish Grover" => "Irish Grover",
            "Istok Web" => "Istok Web",
            "Italiana" => "Italiana",
            "Italianno" => "Italianno",
            "Jacques Francois" => "Jacques Francois",
            "Jacques Francois Shadow" => "Jacques Francois Shadow",
            "Jim Nightshade" => "Jim Nightshade",
            "Jockey One" => "Jockey One",
            "Jolly Lodger" => "Jolly Lodger",
            "Josefin Sans" => "Josefin Sans",
            "Josefin Slab" => "Josefin Slab",
            "Joti One" => "Joti One",
            "Judson" => "Judson",
            "Julee" => "Julee",
            "Julius Sans One" => "Julius Sans One",
            "Junge" => "Junge",
            "Jura" => "Jura",
            "Just Another Hand" => "Just Another Hand",
            "Just Me Again Down Here" => "Just Me Again Down Here",
            "Kameron" => "Kameron",
            "Kantumruy" => "Kantumruy",
            "Karla" => "Karla",
            "Kaushan Script" => "Kaushan Script",
            "Kavoon" => "Kavoon",
            "Kdam Thmor" => "Kdam Thmor",
            "Keania One" => "Keania One",
            "Kelly Slab" => "Kelly Slab",
            "Kenia" => "Kenia",
            "Khmer" => "Khmer",
            "Kite One" => "Kite One",
            "Knewave" => "Knewave",
            "Kotta One" => "Kotta One",
            "Koulen" => "Koulen",
            "Kranky" => "Kranky",
            "Kreon" => "Kreon",
            "Kristi" => "Kristi",
            "Krona One" => "Krona One",
            "La Belle Aurore" => "La Belle Aurore",
            "Lancelot" => "Lancelot",
            "Lato" => "Lato",
            "League Script" => "League Script",
            "Leckerli One" => "Leckerli One",
            "Ledger" => "Ledger",
            "Lekton" => "Lekton",
            "Lemon" => "Lemon",
            "Libre Baskerville" => "Libre Baskerville",
            "Life Savers" => "Life Savers",
            "Lilita One" => "Lilita One",
            "Lily Script One" => "Lily Script One",
            "Limelight" => "Limelight",
            "Linden Hill" => "Linden Hill",
            "Lobster" => "Lobster",
            "Lobster Two" => "Lobster Two",
            "Londrina Outline" => "Londrina Outline",
            "Londrina Shadow" => "Londrina Shadow",
            "Londrina Sketch" => "Londrina Sketch",
            "Londrina Solid" => "Londrina Solid",
            "Lora" => "Lora",
            "Love Ya Like A Sister" => "Love Ya Like A Sister",
            "Loved by the King" => "Loved by the King",
            "Lovers Quarrel" => "Lovers Quarrel",
            "Luckiest Guy" => "Luckiest Guy",
            "Lusitana" => "Lusitana",
            "Lustria" => "Lustria",
            "Macondo" => "Macondo",
            "Macondo Swash Caps" => "Macondo Swash Caps",
            "Magra" => "Magra",
            "Maiden Orange" => "Maiden Orange",
            "Mako" => "Mako",
            "Marcellus" => "Marcellus",
            "Marcellus SC" => "Marcellus SC",
            "Marck Script" => "Marck Script",
            "Margarine" => "Margarine",
            "Marko One" => "Marko One",
            "Marmelad" => "Marmelad",
            "Marvel" => "Marvel",
            "Mate" => "Mate",
            "Mate SC" => "Mate SC",
            "Maven Pro" => "Maven Pro",
            "McLaren" => "McLaren",
            "Meddon" => "Meddon",
            "MedievalSharp" => "MedievalSharp",
            "Medula One" => "Medula One",
            "Megrim" => "Megrim",
            "Meie Script" => "Meie Script",
            "Merienda" => "Merienda",
            "Merienda One" => "Merienda One",
            "Merriweather" => "Merriweather",
            "Merriweather Sans" => "Merriweather Sans",
            "Metal" => "Metal",
            "Metal Mania" => "Metal Mania",
            "Metamorphous" => "Metamorphous",
            "Metrophobic" => "Metrophobic",
            "Michroma" => "Michroma",
            "Milonga" => "Milonga",
            "Miltonian" => "Miltonian",
            "Miltonian Tattoo" => "Miltonian Tattoo",
            "Miniver" => "Miniver",
            "Miss Fajardose" => "Miss Fajardose",
            "Modern Antiqua" => "Modern Antiqua",
            "Molengo" => "Molengo",
            "Molle" => "Molle",
            "Monda" => "Monda",
            "Monofett" => "Monofett",
            "Monoton" => "Monoton",
            "Monsieur La Doulaise" => "Monsieur La Doulaise",
            "Montaga" => "Montaga",
            "Montez" => "Montez",
            "Montserrat" => "Montserrat",
            "Montserrat Alternates" => "Montserrat Alternates",
            "Montserrat Subrayada" => "Montserrat Subrayada",
            "Moul" => "Moul",
            "Moulpali" => "Moulpali",
            "Mountains of Christmas" => "Mountains of Christmas",
            "Mouse Memoirs" => "Mouse Memoirs",
            "Mr Bedfort" => "Mr Bedfort",
            "Mr Dafoe" => "Mr Dafoe",
            "Mr De Haviland" => "Mr De Haviland",
            "Mrs Saint Delafield" => "Mrs Saint Delafield",
            "Mrs Sheppards" => "Mrs Sheppards",
            "Muli" => "Muli",
            "Mystery Quest" => "Mystery Quest",
            "Neucha" => "Neucha",
            "Neuton" => "Neuton",
            "New Rocker" => "New Rocker",
            "News Cycle" => "News Cycle",
            "Niconne" => "Niconne",
            "Nixie One" => "Nixie One",
            "Nobile" => "Nobile",
            "Nokora" => "Nokora",
            "Norican" => "Norican",
            "Nosifer" => "Nosifer",
            "Nothing You Could Do" => "Nothing You Could Do",
            "Noticia Text" => "Noticia Text",
            "Noto Sans" => "Noto Sans",
            "Noto Serif" => "Noto Serif",
            "Nova Cut" => "Nova Cut",
            "Nova Flat" => "Nova Flat",
            "Nova Mono" => "Nova Mono",
            "Nova Oval" => "Nova Oval",
            "Nova Round" => "Nova Round",
            "Nova Script" => "Nova Script",
            "Nova Slim" => "Nova Slim",
            "Nova Square" => "Nova Square",
            "Numans" => "Numans",
            "Nunito" => "Nunito",
            "Odor Mean Chey" => "Odor Mean Chey",
            "Offside" => "Offside",
            "Old Standard TT" => "Old Standard TT",
            "Oldenburg" => "Oldenburg",
            "Oleo Script" => "Oleo Script",
            "Oleo Script Swash Caps" => "Oleo Script Swash Caps",
            "Open Sans" => "Open Sans",
            "Open Sans Condensed" => "Open Sans Condensed",
            "Oranienbaum" => "Oranienbaum",
            "Orbitron" => "Orbitron",
            "Oregano" => "Oregano",
            "Orienta" => "Orienta",
            "Original Surfer" => "Original Surfer",
            "Oswald" => "Oswald",
            "Over the Rainbow" => "Over the Rainbow",
            "Overlock" => "Overlock",
            "Overlock SC" => "Overlock SC",
            "Ovo" => "Ovo",
            "Oxygen" => "Oxygen",
            "Oxygen Mono" => "Oxygen Mono",
            "PT Mono" => "PT Mono",
            "PT Sans" => "PT Sans",
            "PT Sans Caption" => "PT Sans Caption",
            "PT Sans Narrow" => "PT Sans Narrow",
            "PT Serif" => "PT Serif",
            "PT Serif Caption" => "PT Serif Caption",
            "Pacifico" => "Pacifico",
            "Paprika" => "Paprika",
            "Parisienne" => "Parisienne",
            "Passero One" => "Passero One",
            "Passion One" => "Passion One",
            "Pathway Gothic One" => "Pathway Gothic One",
            "Patrick Hand" => "Patrick Hand",
            "Patrick Hand SC" => "Patrick Hand SC",
            "Patua One" => "Patua One",
            "Paytone One" => "Paytone One",
            "Peralta" => "Peralta",
            "Permanent Marker" => "Permanent Marker",
            "Petit Formal Script" => "Petit Formal Script",
            "Petrona" => "Petrona",
            "Philosopher" => "Philosopher",
            "Piedra" => "Piedra",
            "Pinyon Script" => "Pinyon Script",
            "Pirata One" => "Pirata One",
            "Plaster" => "Plaster",
            "Play" => "Play",
            "Playball" => "Playball",
            "Playfair Display" => "Playfair Display",
            "Playfair Display SC" => "Playfair Display SC",
            "Podkova" => "Podkova",
            "Poiret One" => "Poiret One",
            "Poller One" => "Poller One",
            "Poly" => "Poly",
            "Pompiere" => "Pompiere",
            "Pontano Sans" => "Pontano Sans",
            "Port Lligat Sans" => "Port Lligat Sans",
            "Port Lligat Slab" => "Port Lligat Slab",
            "Prata" => "Prata",
            "Preahvihear" => "Preahvihear",
            "Press Start 2P" => "Press Start 2P",
            "Princess Sofia" => "Princess Sofia",
            "Prociono" => "Prociono",
            "Prosto One" => "Prosto One",
            "Puritan" => "Puritan",
            "Purple Purse" => "Purple Purse",
            "Quando" => "Quando",
            "Quantico" => "Quantico",
            "Quattrocento" => "Quattrocento",
            "Quattrocento Sans" => "Quattrocento Sans",
            "Questrial" => "Questrial",
            "Quicksand" => "Quicksand",
            "Quintessential" => "Quintessential",
            "Qwigley" => "Qwigley",
            "Racing Sans One" => "Racing Sans One",
            "Radley" => "Radley",
            "Raleway" => "Raleway",
            "Raleway Dots" => "Raleway Dots",
            "Rambla" => "Rambla",
            "Rammetto One" => "Rammetto One",
            "Ranchers" => "Ranchers",
            "Rancho" => "Rancho",
            "Rationale" => "Rationale",
            "Redressed" => "Redressed",
            "Reenie Beanie" => "Reenie Beanie",
            "Revalia" => "Revalia",
            "Ribeye" => "Ribeye",
            "Ribeye Marrow" => "Ribeye Marrow",
            "Righteous" => "Righteous",
            "Risque" => "Risque",
            "Roboto" => "Roboto",
            "Roboto Condensed" => "Roboto Condensed",
            "Roboto Slab" => "Roboto Slab",
            "Rochester" => "Rochester",
            "Rock Salt" => "Rock Salt",
            "Rokkitt" => "Rokkitt",
            "Romanesco" => "Romanesco",
            "Ropa Sans" => "Ropa Sans",
            "Rosario" => "Rosario",
            "Rosarivo" => "Rosarivo",
            "Rouge Script" => "Rouge Script",
            "Ruda" => "Ruda",
            "Rufina" => "Rufina",
            "Ruge Boogie" => "Ruge Boogie",
            "Ruluko" => "Ruluko",
            "Rum Raisin" => "Rum Raisin",
            "Ruslan Display" => "Ruslan Display",
            "Russo One" => "Russo One",
            "Ruthie" => "Ruthie",
            "Rye" => "Rye",
            "Sacramento" => "Sacramento",
            "Sail" => "Sail",
            "Salsa" => "Salsa",
            "Sanchez" => "Sanchez",
            "Sancreek" => "Sancreek",
            "Sansita One" => "Sansita One",
            "Sarina" => "Sarina",
            "Satisfy" => "Satisfy",
            "Scada" => "Scada",
            "Schoolbell" => "Schoolbell",
            "Seaweed Script" => "Seaweed Script",
            "Sevillana" => "Sevillana",
            "Seymour One" => "Seymour One",
            "Shadows Into Light" => "Shadows Into Light",
            "Shadows Into Light Two" => "Shadows Into Light Two",
            "Shanti" => "Shanti",
            "Share" => "Share",
            "Share Tech" => "Share Tech",
            "Share Tech Mono" => "Share Tech Mono",
            "Shojumaru" => "Shojumaru",
            "Short Stack" => "Short Stack",
            "Siemreap" => "Siemreap",
            "Sigmar One" => "Sigmar One",
            "Signika" => "Signika",
            "Signika Negative" => "Signika Negative",
            "Simonetta" => "Simonetta",
            "Sintony" => "Sintony",
            "Sirin Stencil" => "Sirin Stencil",
            "Six Caps" => "Six Caps",
            "Skranji" => "Skranji",
            "Slackey" => "Slackey",
            "Smokum" => "Smokum",
            "Smythe" => "Smythe",
            "Sniglet" => "Sniglet",
            "Snippet" => "Snippet",
            "Snowburst One" => "Snowburst One",
            "Sofadi One" => "Sofadi One",
            "Sofia" => "Sofia",
            "Sonsie One" => "Sonsie One",
            "Sorts Mill Goudy" => "Sorts Mill Goudy",
            "Source Code Pro" => "Source Code Pro",
            "Source Sans Pro" => "Source Sans Pro",
            "Special Elite" => "Special Elite",
            "Spicy Rice" => "Spicy Rice",
            "Spinnaker" => "Spinnaker",
            "Spirax" => "Spirax",
            "Squada One" => "Squada One",
            "Stalemate" => "Stalemate",
            "Stalinist One" => "Stalinist One",
            "Stardos Stencil" => "Stardos Stencil",
            "Stint Ultra Condensed" => "Stint Ultra Condensed",
            "Stint Ultra Expanded" => "Stint Ultra Expanded",
            "Stoke" => "Stoke",
            "Strait" => "Strait",
            "Sue Ellen Francisco" => "Sue Ellen Francisco",
            "Sunshiney" => "Sunshiney",
            "Supermercado One" => "Supermercado One",
            "Suwannaphum" => "Suwannaphum",
            "Swanky and Moo Moo" => "Swanky and Moo Moo",
            "Syncopate" => "Syncopate",
            "Tangerine" => "Tangerine",
            "Taprom" => "Taprom",
            "Tauri" => "Tauri",
            "Telex" => "Telex",
            "Tenor Sans" => "Tenor Sans",
            "Text Me One" => "Text Me One",
            "The Girl Next Door" => "The Girl Next Door",
            "Tienne" => "Tienne",
            "Tinos" => "Tinos",
            "Titan One" => "Titan One",
            "Titillium Web" => "Titillium Web",
            "Trade Winds" => "Trade Winds",
            "Trocchi" => "Trocchi",
            "Trochut" => "Trochut",
            "Trykker" => "Trykker",
            "Tulpen One" => "Tulpen One",
            "Ubuntu" => "Ubuntu",
            "Ubuntu Condensed" => "Ubuntu Condensed",
            "Ubuntu Mono" => "Ubuntu Mono",
            "Ultra" => "Ultra",
            "Uncial Antiqua" => "Uncial Antiqua",
            "Underdog" => "Underdog",
            "Unica One" => "Unica One",
            "UnifrakturCook" => "UnifrakturCook",
            "UnifrakturMaguntia" => "UnifrakturMaguntia",
            "Unkempt" => "Unkempt",
            "Unlock" => "Unlock",
            "Unna" => "Unna",
            "VT323" => "VT323",
            "Vampiro One" => "Vampiro One",
            "Varela" => "Varela",
            "Varela Round" => "Varela Round",
            "Vast Shadow" => "Vast Shadow",
            "Vibur" => "Vibur",
            "Vidaloka" => "Vidaloka",
            "Viga" => "Viga",
            "Voces" => "Voces",
            "Volkhov" => "Volkhov",
            "Vollkorn" => "Vollkorn",
            "Voltaire" => "Voltaire",
            "Waiting for the Sunrise" => "Waiting for the Sunrise",
            "Wallpoet" => "Wallpoet",
            "Walter Turncoat" => "Walter Turncoat",
            "Warnes" => "Warnes",
            "Wellfleet" => "Wellfleet",
            "Wendy One" => "Wendy One",
            "Wire One" => "Wire One",
            "Yanone Kaffeesatz" => "Yanone Kaffeesatz",
            "Yellowtail" => "Yellowtail",
            "Yeseva One" => "Yeseva One",
            "Yesteryear" => "Yesteryear",
            "Zeyada" => "Zeyada",
        );

        /**
         * Standart fonts array
         * @var array
         */
        public $standart_fonts = array(
            'inherit' => 'Default',
            'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
            "'Arial Black', Gadget, sans-serif" => "Arial Black, Gadget, sans-serif",
            "'Bookman Old Style', serif" => "Bookman Old Style, serif",
            "'Comic Sans MS', cursive" => "Comic Sans MS, cursive",
            "Courier, monospace" => "Courier, monospace",
            "Garamond, serif" => "Garamond, serif",
            "Georgia, serif" => "Georgia, serif",
            "Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
            "'Lucida Console', Monaco, monospace" => "Lucida Console, Monaco, monospace",
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "Lucida Sans Unicode, Lucida Grande, sans-serif",
            "'MS Sans Serif', Geneva, sans-serif" => "MS Sans Serif, Geneva, sans-serif",
            "'MS Serif', 'New York', sans-serif" => "MS Serif, New York, sans-serif",
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "Palatino Linotype, 'Book Antiqua', Palatino, serif",
            "Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
            "'Times New Roman', Times, serif" => "Times New Roman, Times, serif",
            "'Trebuchet MS', Helvetica, sans-serif" => "Trebuchet MS, Helvetica, sans-serif",
            "Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif"
        );

        /**
         * CSS Options
         */
        public $font_weight = array(
            'inherit' => 'Default',
            '200' => 'Extra-Light 200',
            '300' => 'Light 300',
            '400' => 'Normal 400',
            '700' => 'Bold 700',
            '900' => 'Extra-Bold 900',
        );
        public $font_style = array(
            'inherit' => 'Default',
            'normal' => 'Normal font style',
            'italic' => 'Italic font style',
            'oblique' => 'Oblique font style',
        );
        public $text_decoration = array(
            'inherit' => 'Default',
            'none' => 'Normal text',
            'underline' => 'Line below the text',
            'overline' => 'Line above the text',
            'line-through' => 'Line through the text',
            'overline' => 'Overline',
        );
        public $text_transform = array(
            'inherit' => 'Default',
            'none' => 'No transforms. The text renders as it is.',
            'capitalize' => 'Transforms the first character of each word to uppercase.',
            'uppercase' => 'Transforms all characters to uppercase.',
            'lowercase' => 'Transforms all characters to lowercase.',
        );
        public $background_repeat = array(
            'no-repeat' => 'No repeat',
            'repeat' => 'Repeat',
            'repeat-x' => 'Repeat only horizontally',
            'repeat-y' => 'Repeat only vertically',
        );
        public $background_size = array(
            'auto' => 'Auto',
            '100% 100%' => 'Resize 100% 100%',
            'cover' => 'Cover - Scale the background image to be as large as possible so that the background area is completely covered by the background image',
            'contain' => 'Contain - Scale the image to the largest size such that both its width and its height can fit inside the content area',
        );
        public $background_attachment = array(
            'scroll' => 'Scroll - The background scrolls along with the element',
            'fixed' => 'Fixed - The background is fixed with regard to the viewport',
        );
        public $background_position = array(
            'left top' => 'Left, Top',
            'left center' => 'Left, Center',
            'left bottom' => 'Left, Bottom',
            'right top' => 'Right, Top',
            'right center' => 'Right, Center',
            'right bottom' => 'Right, Bottom',
            'center top' => 'Center, Top',
            'center center' => 'Center, Center',
            'center bottom' => 'Center, Bottom',
        );

        /**
         * 
         * @param type $wp_admin_bar
         */
        function admin_bar($wp_admin_bar) { // TODO HQTHEME
            return;
            $wp_admin_bar->add_node(array(
                'parent' => null,
                'id' => 'customize-hq-theme',
                'title' => 'Customize Theme',
                'href' => admin_url('customize.php?url=' . get_site_url())
            ));
        }

    }

}