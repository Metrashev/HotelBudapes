<?php

if (!class_exists('Customize_Settings')) {

    /**
     * Contains settings for customizing the theme customization screen.
     * 
     * @link http://codex.wordpress.org/Theme_Customization_API
     * @since HQTheme 1.0
     */
    class Customize_Settings {

        protected static $_instance;
        public $remove_sections;
        public $add_sections;
        public $transport_settings;
        public $add_setting_controls;

        public static function getInstance() {
            if (empty(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * HQTheme options definitions
         * 
         * @since HQTheme 1.0 
         */
        public function __construct() {
            $HQCustomize = HQTheme_Customize::getInstance();
            //remove_sections array
            $remove_sections = array(
                'background_image',
                'static_front_page',
            ); //end of remove_sections array
            $this->remove_sections = apply_filters('hq_remove_sections_map', $remove_sections);

            // Sections array
            $add_sections = array(
                'title_tagline' => array(
                    'title' => __('Site Title & Tagline', HQTheme::THEME_SLUG),
                ),
                'hq_skins_settings' => array(
                    'title' => __('Sets', HQTheme::THEME_SLUG),
                ),
                'hq_branding_colors_settings' => array(
                    'title' => __('Branding', HQTheme::THEME_SLUG),
                ),
                'hq_layout_settings' => array(
                    'title' => __('Layout', HQTheme::THEME_SLUG),
                ),
                'hq_typography_settings' => array(
                    'title' => __('Typography', HQTheme::THEME_SLUG),
                ),
                'hq_header_settings' => array(
                    'title' => __('Header', HQTheme::THEME_SLUG),
                ),
                'hq_footer_settings' => array(
                    'title' => __('Footer', HQTheme::THEME_SLUG),
                ),
                'nav' => array(
                    'title' => __('Navigation', HQTheme::THEME_SLUG),
                ),
                'hq_blog_settings' => array(
                    'title' => __('Blog', HQTheme::THEME_SLUG),
                ),
                'hq_csportfolio_settings' => array(// No setting controllers defined. They will be added by HQTheme Portfolio Plugin
                    'title' => __('Portfolio', HQTheme::THEME_SLUG),
                ),
                'hq_woocommerce_settings' => array(
                    'title' => __('WooCommerce', HQTheme::THEME_SLUG),
                ),
                'hq_social_links_settings' => array(
                    'title' => __('Social - links', HQTheme::THEME_SLUG),
                ),
                'hq_social_shares_settings' => array(
                    'title' => __('Social - shares', HQTheme::THEME_SLUG),
                ),
                'hq_custom_css' => array(
                    'title' => __('Custom CSS', HQTheme::THEME_SLUG),
                ),
            ); //end of add_sections array
            $this->add_sections = apply_filters('hq_add_sections_map', $add_sections);

            //specifies the transport for some options
            $transport_settings = array(
                'blogname',
                'blogdescription'
            ); //end of $transport_settings array
            $this->transport_settings = apply_filters('hq_transport_settings_map', $transport_settings);

            // skin_options
            $skin_options_map = array(
                'skin_description' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_skins_settings',
                    'type' => 'description',
                    'label' => __('Here you can choose skin best fits your site.', HQTheme::THEME_SLUG),
                ),
                //skin select
                'hq_skin' => array(
                    'default' => 'base',
                    'label' => __('Select', HQTheme::THEME_SLUG),
                    'section' => 'hq_skins_settings',
                    'type' => 'select',
                    'update_type' => 'refresh',
                    'choices' => array(
                        'base' => 'hq-base',
                        'business' => 'hq-business',
                        'art' => 'art',
                        'clean' => 'hq-clean',
                    ),
                ),
                'skin_defaults_description' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_skins_settings',
                    'type' => 'warning',
                    'label' => __('Set Skin Defaults will reset all theme options. Your custom options will be lost!', HQTheme::THEME_SLUG),
                ),
                'skin_advanced_options_description' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_skins_settings',
                    'type' => 'description',
                    'label' => __('Show all options. This is recommended only for advanced users!', HQTheme::THEME_SLUG),
                ),
                'skin_advanced_options' => array(
                    'default' => 0,
                    'label' => __('Advanced options', HQTheme::THEME_SLUG),
                    'section' => 'hq_skins_settings',
                    'type' => 'checkbox',
                ),
            ); //end of skin_options
            $skin_options_map = apply_filters('hq_skin_options_map', $skin_options_map);

            // branding_options
            $branding_options_map = array(
                'branding_description' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'description',
                    'label' => __('Changing branding colors and fonts will change settings bellow.', HQTheme::THEME_SLUG),
                ),
                'branding_colors_title' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'sub-title',
                    'label' => __('Colors', HQTheme::THEME_SLUG),
                ),
                'hq_branding_colors_main_primary' => array(
                    'default' => '#44749d',
                    'label' => __('Main Primary Color', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'hqcolor',
                    'control' => 'HQTheme_Controls'
                ),
                'hq_branding_colors_main_secondary' => array(
                    'default' => '#c6d4e1',
                    'label' => __('Main Secondary Color', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'hqcolor',
                    'control' => 'HQTheme_Controls'
                ),
                'hq_branding_colors_sup_primary' => array(
                    'default' => '#bdb8ad',
                    'label' => __('Sup Primary Color', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'hqcolor',
                    'control' => 'HQTheme_Controls'
                ),
                'hq_branding_colors_sup_secondary' => array(
                    'default' => '#ebe7e0',
                    'label' => __('Sup Secondary Color', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'hqcolor',
                    'control' => 'HQTheme_Controls'
                ),
                'hq_branding_colors_neutral_primary' => array(
                    'default' => '#898989',
                    'label' => __('Neutral Primary Color', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'hqcolor',
                    'control' => 'HQTheme_Controls'
                ),
                'hq_branding_colors_neutral_secondary' => array(
                    'default' => '#f3f3f3',
                    'label' => __('Neutral Secondary Color', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'hqcolor',
                    'control' => 'HQTheme_Controls'
                ),
                'branding_fonts_title' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'sub-title',
                    'label' => __('Fonts', HQTheme::THEME_SLUG),
                ),
                'hq_branding_fonts_main' => array(
                    'default' => 'Droid Serif',
                    'label' => __('Main Font', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'select',
                    'choices' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                ),
                'hq_branding_fonts_secondary' => array(
                    'default' => 'Montserrat',
                    'label' => __('Secondary Font', HQTheme::THEME_SLUG),
                    'section' => 'hq_branding_colors_settings',
                    'type' => 'select',
                    'choices' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                ),
            ); //end of branding_options
            $branding_options_map = apply_filters('hq_branding_options_map', $branding_options_map);


            // layout_options
            $layout_options_map = array(
                'layout_description_title' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_layout_settings',
                    'type' => 'description',
                    'label' => __('Layout settings.', HQTheme::THEME_SLUG),
                ),
                'hq_layout_site_layout' => array(
                    'default' => 'boxed',
                    'label' => __('Site Layout', HQTheme::THEME_SLUG),
                    'section' => 'hq_layout_settings',
                    'type' => 'select',
                    'choices' => array(
                        'boxed' => 'Boxed',
                        'full-width' => 'Full width',
                    ),
                ),
                'hq_layout_site_max_width' => array(
                    'default' => 1200,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Site Max Width (px)', HQTheme::THEME_SLUG),
                    'section' => 'hq_layout_settings',
                    'type' => 'text',
                ),
                'hq_layout_site_width' => array(
                    'default' => 90,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Site Width (%)', HQTheme::THEME_SLUG),
                    'section' => 'hq_layout_settings',
                    'type' => 'text',
                ),
                'hq_layout_sidebar_link' => array(
                    'setting_type' => null,
                    'label' => __('Edit Sidebars', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_layout_settings',
                    'type' => 'link',
                    'custom_options' => array(
                        'link' => get_admin_url(null, '/themes.php?page=multiple_sidebars'),
                    ),
                ),
                'hq_layout_sidebar_left' => array(
                    'default' => 0,
                    'label' => __('Main Layout Sidebar Left', HQTheme::THEME_SLUG),
                    'section' => 'hq_layout_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_layout_sidebar_right' => array(
                    'default' => 0,
                    'label' => __('Main Layout Sidebar Right', HQTheme::THEME_SLUG),
                    'section' => 'hq_layout_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                // Background
                'layout_background_title' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_layout_settings',
                    'type' => 'sub-title',
                    'label' => __('Background', HQTheme::THEME_SLUG),
                ),
                'hq_layout_background' => array(
                    'default' => '',
                    'label' => __('Header Background Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_layout_settings',
                    'type' => 'backgroundoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'background-color' => 1,
                        'background-repeat' => $HQCustomize->background_repeat,
                        'background-size' => $HQCustomize->background_size,
                        'background-attachment' => $HQCustomize->background_attachment,
                        'background-position' => $HQCustomize->background_position,
                    )
                ),
                'hq_layout_background_image' => array(
                    'control' => 'WP_Customize_Image_Control',
                    'label' => __('Background Upload', HQTheme::THEME_SLUG),
                    'section' => 'hq_layout_settings',
                    'sanitize_callback' => array($this, 'sanitize_uploads'),
                ),
            ); //end of layout_options
            $layout_options_map = apply_filters('hq_layout_options_map', $layout_options_map);

            // typography_options
            $typography_options_map = array(
                'typography_description' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_typography_settings',
                    'type' => 'description',
                    'label' => __('We provide you with full control over your site\'s typography. Remember to check the box for "Enable Custom Fonts" to set your own individual fonts.', HQTheme::THEME_SLUG),
                ),
                'typography_warning' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_typography_settings',
                    'type' => 'warning',
                    'label' => __('Some fonts do not support all font weights styles and subsets! More info at <a href="https://www.google.com/fonts">Google Fonts</a>', HQTheme::THEME_SLUG),
                ),
                // Main
                'hq_typography_custom_fonts' => array(
                    'default' => 0,
                    'label' => __('Enable Custom Fonts', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'checkbox',
                ),
                'hq_typography_custom_font_subsets' => array(
                    'default' => 0,
                    'label' => __('Enable Subsets', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'checkbox',
                ),
                'hq_typography_custom_font_subset_cyrillic' => array(
                    'default' => 0,
                    'label' => __('Enable Cyrillic', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'checkbox',
                ),
                'hq_typography_custom_font_subset_greek' => array(
                    'default' => 0,
                    'label' => __('Enable Greek', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'checkbox',
                ),
                'hq_typography_custom_font_subset_vietnamese' => array(
                    'default' => 0,
                    'label' => __('Enable Vietnamese', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'checkbox',
                ),
                // Logo
                'hq_typography_logo' => array(
                    'default' => '',
                    'label' => __('Site Logo', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                // Heading
                'hq_typography_headings' => array(
                    'default' => '',
                    'label' => __('Headings', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        //'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                // Navigation
                'hq_typography_navigation' => array(
                    'default' => '',
                    'label' => __('Main Navigation', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                'hq_typography_navigation_active' => array(
                    'default' => '',
                    'label' => __('Main Navigation Active / Hover', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'color' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                    )
                ),
                //Body
                'hq_typography_body' => array(
                    'default' => '',
                    'label' => __('Body', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                // Links
                'hq_typography_links' => array(
                    'default' => '',
                    'label' => __('Text Links', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                'hq_typography_links_hover' => array(
                    'default' => '',
                    'label' => __('Text Links Hover', HQTheme::THEME_SLUG),
                    'section' => 'hq_typography_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'color' => 1,
                        'text-decoration' => $HQCustomize->text_decoration,
                    )
                ),
            ); //end of typography_options
            $typography_options_map = apply_filters('hq_typography_options_map', $typography_options_map);

            // navigation_options
            $navigation_options_map = array(
                'menu_link' => array(
                    'setting_type' => null,
                    'label' => __('Manage menus', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'nav',
                    'type' => 'link',
                    'custom_options' => array(
                        'link' => admin_url('nav-menus.php'),
                    ),
                ),
            ); //end of navigation_options
            $navigation_options_map = apply_filters('hq_navigations_option_map', $navigation_options_map);

            // header_options
            $header_options_map = array(
                // Header
                'hq_header_position' => array(
                    'default' => 'static-top',
                    'label' => __('Header position', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'select',
                    'choices' => array(
                        'hidden' => 'No header',
                        'static-top' => 'Static top',
                        'fixed-top' => 'Fixed top',
                        'fixed-left' => 'Fixed left',
                        'fixed-right' => 'Fixed right',
                    )
                ),
                'hq_header_logo_position' => array(
                    'default' => 'left',
                    'label' => __('Logo position', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'select',
                    'choices' => array(
                        'hidden' => 'No logo',
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                        'left-above' => 'Left Above navigation',
                        'center-above' => 'Center Above navigation',
                        'right-above' => 'Right Above navigation',
                        'left-below' => 'Left Below navigation',
                        'center-below' => 'Center Below navigation',
                        'right-below' => 'Right Below navigation',
                    )
                ),
                'hq_header_navigation_position' => array(
                    'default' => 'right',
                    'label' => __('Navigation position', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'select',
                    'choices' => array(
                        'hidden' => 'No main navigation',
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    )
                ),
                'hq_header_main_height' => array(
                    'default' => 90,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Main Header Height (px)', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                'hq_header_side_width' => array(
                    'default' => 200,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Header Side Width (px)', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                'hq_header_breadcrumb' => array(
                    'default' => 1,
                    'label' => __('Enable Breadcrumbs', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'checkbox',
                ),
                // Background
                'hq_header_background' => array(
                    'default' => '',
                    'label' => __('Header Background Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'backgroundoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'background-color' => 1,
                        'background-repeat' => $HQCustomize->background_repeat,
                        'background-size' => $HQCustomize->background_size,
                        'background-attachment' => $HQCustomize->background_attachment,
                        'background-position' => $HQCustomize->background_position,
                    )
                ),
                'hq_header_background_image' => array(
                    'control' => 'WP_Customize_Image_Control',
                    'label' => __('Header Background Image', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'sanitize_callback' => array($this, 'sanitize_uploads'),
                ),
                //Topline
                'header_topline_title' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_header_settings',
                    'type' => 'sub-title',
                    'label' => __('Top Line', HQTheme::THEME_SLUG),
                ),
                'hq_header_topline_display' => array(
                    'default' => 1,
                    'label' => __('Display Header Topline', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'checkbox',
                ),
                'hq_header_topline_height' => array(
                    'default' => 30,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Header Topline Height (px)', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                'hq_header_topline_box' => array(
                    'default' => '',
                    'label' => __('Box Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'boxoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'margin' => 1,
                        'padding' => 1,
                        'borders' => array('style', 'color', 'width'),
                    )
                ),
                // Topline Background
                'header_topline_background' => array(
                    'default' => '',
                    'label' => __('Header Background Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'backgroundoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'background-color' => 1,
                        'background-repeat' => $HQCustomize->background_repeat,
                        'background-size' => $HQCustomize->background_size,
                        'background-attachment' => $HQCustomize->background_attachment,
                        'background-position' => $HQCustomize->background_position,
                    )
                ),
                'header_topline_background_image' => array(
                    'control' => 'WP_Customize_Image_Control',
                    'label' => __('TopLine Header Background Image', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'sanitize_callback' => array($this, 'sanitize_uploads'),
                ),
                'header_topline_text' => array(
                    'default' => '',
                    'label' => __('Text settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                'header_topline_links' => array(
                    'default' => '',
                    'label' => __('Text Links', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                'header_topline_links_hover' => array(
                    'default' => '',
                    'label' => __('Text Links Hover', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'color' => 1,
                        'text-decoration' => $HQCustomize->text_decoration,
                    )
                ),
                'hq_header_topline_left' => array(
                    'default' => 'none',
                    'label' => __('Header Topline Left', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'select',
                    'choices' => array(
                        'none' => 'Nothing',
                        'text' => 'Text',
                        'socials' => 'Socials',
                        'search' => 'Search',
                        'socials-search' => 'Socials + Search',
                        'menu' => 'Header Left Menu',
                        'woo-cart' => 'Shoping Cart',
                        'widgets' => 'Header Left Widgets',
                    )
                ),
                'hq_header_topline_left_text' => array(
                    'default' => '',
                    'label' => __('Header Topline Left Text', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                'hq_header_topline_center' => array(
                    'default' => 'none',
                    'label' => __('Header Topline Center', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'select',
                    'choices' => array(
                        'none' => 'Nothing',
                        'text' => 'Text',
                        'socials' => 'Socials',
                        'search' => 'Search',
                        'socials-search' => 'Socials + Search',
                        'menu' => 'Header Center Menu',
                        'woo-cart' => 'Shoping Cart',
                        'widgets' => 'Header Center Widgets',
                    )
                ),
                'hq_header_topline_center_text' => array(
                    'default' => '',
                    'label' => __('Header Topline Center Text', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                'hq_header_topline_right' => array(
                    'default' => 'none',
                    'label' => __('Header Topline Right', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'select',
                    'choices' => array(
                        'none' => 'Nothing',
                        'text' => 'Text',
                        'socials' => 'Socials',
                        'search' => 'Search',
                        'socials-search' => 'Socials + Search',
                        'menu' => 'Header Right Menu',
                        'woo-cart' => 'Shoping Cart',
                        'widgets' => 'Header Right Widgets',
                    )
                ),
                'hq_header_topline_right_text' => array(
                    'default' => '',
                    'label' => __('Header Topline Right Text', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                // Logo
                'heade_logo_title' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_header_settings',
                    'type' => 'sub-title',
                    'label' => __('Logo & Favicon', HQTheme::THEME_SLUG),
                ),
                'hq_header_logo_upload' => array(
                    'control' => 'WP_Customize_Image_Control',
                    'label' => __('Logo Upload (supported formats : .jpg, .png, .gif)', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'sanitize_callback' => array($this, 'sanitize_uploads'),
                ),
                'hq_header_logo_resize' => array(
                    'default' => 1,
                    'label' => __('Force logo dimensions', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'checkbox',
                ),
                'hq_header_logo_resize_width' => array(
                    'default' => 250,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Logo Width (px)', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                'hq_header_logo_resize_height' => array(
                    'default' => '',
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Logo Height (px)', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'text',
                ),
                'hq_header_logo_box' => array(
                    'default' => '',
                    'label' => __('Logo Box Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'type' => 'boxoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'margin' => 1,
                        'padding' => 1,
                        'borders' => array('style', 'color', 'width'),
                    )
                ),
                //favicon
                'hq_header_logo_fav_upload' => array(
                    'control' => 'WP_Customize_Image_Control',
                    'label' => __('Favicon Upload (supported formats : .ico, .png, .gif)', HQTheme::THEME_SLUG),
                    'section' => 'hq_header_settings',
                    'sanitize_callback' => array($this, 'sanitize_uploads'),
                )
            ); //end of header_options
            $header_options_map = apply_filters('hq_header_options_map', $header_options_map);

            // footer_options
            $footer_options_map = array(
                'footer_widgets' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_footer_settings',
                    'type' => 'sub-title',
                    'label' => __('Footer Widgets', HQTheme::THEME_SLUG),
                ),
                'footer_description' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_footer_settings',
                    'type' => 'description',
                    'label' => __('Here you can set footer widget areas. You can use 1, 2, 3, 4 or 0. For each can setup sidebar from <a href="' . get_admin_url(null, '/themes.php?page=multiple_sidebars') . '" target="_blank">"Appearance">"Sidebars"</a> and then add widgets from <a href="' . get_admin_url(null, '/widgets.php') . '" target="_blank">"Appearance">"Widgets"</a>', HQTheme::THEME_SLUG),
                ),
                'hq_blog_sidebar_link' => array(
                    'setting_type' => null,
                    'label' => __('Edit Sidebars', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_footer_settings',
                    'type' => 'link',
                    'custom_options' => array(
                        'link' => get_admin_url(null, '/themes.php?page=multiple_sidebars'),
                    ),
                ),
                'hq_footer_widgets_first' => array(
                    'default' => 0,
                    'label' => __('Footer First Widget Area', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_footer_widgets_second' => array(
                    'default' => 0,
                    'label' => __('Footer Second Widget Area', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_footer_widgets_third' => array(
                    'default' => 0,
                    'label' => __('Footer Third Widget Area', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_footer_widgets_fourth' => array(
                    'default' => 0,
                    'label' => __('Footer Fourth Widget Area', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_footer_widgets_box' => array(
                    'default' => '',
                    'label' => __('Box Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'boxoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'margin' => 1,
                        'padding' => 1,
                        'borders' => array('style', 'color', 'width'),
                    )
                ),
                // Widgets Background
                'hq_footer_widgets_background' => array(
                    'default' => '',
                    'label' => __('Background Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'backgroundoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'background-color' => 1,
                        'background-repeat' => $HQCustomize->background_repeat,
                        'background-size' => $HQCustomize->background_size,
                        'background-attachment' => $HQCustomize->background_attachment,
                        'background-position' => $HQCustomize->background_position,
                    )
                ),
                'hq_footer_widgets_background_image' => array(
                    'control' => 'WP_Customize_Image_Control',
                    'label' => __('Background Image', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'sanitize_callback' => array($this, 'sanitize_uploads'),
                ),
                // Body text
                'hq_footer_widgets_text' => array(
                    'default' => '',
                    'label' => __('Text settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                // Headings
                'hq_footer_widgets_headings' => array(
                    'default' => '',
                    'label' => __('Headings', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        //'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                // Links
                'hq_footer_widgets_links' => array(
                    'default' => '',
                    'label' => __('Text Links', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                'hq_footer_widgets_links_hover' => array(
                    'default' => '',
                    'label' => __('Text Links Hover', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'color' => 1,
                        'text-decoration' => $HQCustomize->text_decoration,
                    )
                ),
                'footer_bottom_line' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_footer_settings',
                    'type' => 'sub-title',
                    'label' => __('Bottom Line', HQTheme::THEME_SLUG),
                ),
                'hq_footer_bottom_display' => array(
                    'default' => 1,
                    'label' => __('Display Bottom Footer', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'checkbox',
                ),
                'hq_footer_bottom_height' => array(
                    'default' => 30,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Bottom Footer Height (px)', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'text',
                ),
                'hq_footer_bottom_box' => array(
                    'default' => '',
                    'label' => __('Box Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'boxoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'margin' => 1,
                        'padding' => 1,
                        'borders' => array('style', 'color', 'width'),
                    )
                ),
                // Bottom Line Background
                'hq_footer_bottom_background' => array(
                    'default' => '',
                    'label' => __('Background Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'backgroundoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'background-color' => 1,
                        'background-repeat' => $HQCustomize->background_repeat,
                        'background-size' => $HQCustomize->background_size,
                        'background-attachment' => $HQCustomize->background_attachment,
                        'background-position' => $HQCustomize->background_position,
                    )
                ),
                'hq_footer_bottom_background_image' => array(
                    'control' => 'WP_Customize_Image_Control',
                    'label' => __('Background Image', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'sanitize_callback' => array($this, 'sanitize_uploads'),
                ),
                // Body text
                'hq_footer_bottom_text' => array(
                    'default' => '',
                    'label' => __('Text Settings', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                // Links
                'hq_footer_bottom_links' => array(
                    'default' => '',
                    'label' => __('Text Links', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'font-family' => array_merge($HQCustomize->standart_fonts, $HQCustomize->google_fonts),
                        'color' => 1,
                        'font-size' => 1,
                        'letter-spacing' => 1,
                        'font-weight' => $HQCustomize->font_weight,
                        'text-decoration' => $HQCustomize->text_decoration,
                        'font-style' => $HQCustomize->font_style,
                        'text-transform' => $HQCustomize->text_transform,
                    )
                ),
                'hq_footer_bottom_links_hover' => array(
                    'default' => '',
                    'label' => __('Text Links Hover', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'textoptions',
                    'control' => 'HQTheme_Controls',
                    'additionalOptions' => array(
                        'color' => 1,
                        'text-decoration' => $HQCustomize->text_decoration,
                    )
                ),
                'hq_footer_bottom_left' => array(
                    'default' => 'none',
                    'label' => __('Footer Bottom Left', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'select',
                    'choices' => array(
                        'none' => 'Nothing',
                        'text' => 'Text',
                        'socials' => 'Socials',
                        'search' => 'Search',
                        'socials-search' => 'Socials + Search',
                        'logo' => 'Logo',
                        'menu' => 'Footer Left Menu',
                        'widgets' => 'Footer Left Widgets',
                    )
                ),
                'hq_footer_bottom_left_text' => array(
                    'default' => '',
                    'label' => __('Footer Bottom Left Text', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'text',
                ),
                'hq_footer_bottom_center' => array(
                    'default' => 'none',
                    'label' => __('Footer Bottom Center', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'select',
                    'choices' => array(
                        'none' => 'Nothing',
                        'text' => 'Text',
                        'socials' => 'Socials',
                        'search' => 'Search',
                        'socials-search' => 'Socials + Search',
                        'logo' => 'Logo',
                        'menu' => 'Footer Center Menu',
                        'widgets' => 'Footer Center Widgets',
                    )
                ),
                'hq_footer_bottom_center_text' => array(
                    'default' => '',
                    'label' => __('Footer Bottom Center Text', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'text',
                ),
                'hq_footer_bottom_right' => array(
                    'default' => 'none',
                    'label' => __('Footer Bottom Right', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'select',
                    'choices' => array(
                        'none' => 'Nothing',
                        'text' => 'Text',
                        'socials' => 'Socials',
                        'search' => 'Search',
                        'socials-search' => 'Socials + Search',
                        'logo' => 'Logo',
                        'menu' => 'Footer Right Menu',
                        'widgets' => 'Footer Right Widgets',
                    )
                ),
                'hq_footer_bottom_right_text' => array(
                    'default' => '',
                    'label' => __('Footer Bottom Right Text', HQTheme::THEME_SLUG),
                    'section' => 'hq_footer_settings',
                    'type' => 'text',
                ),
            ); //end of footer_options
            $footer_options_map = apply_filters('hq_footer_options_map', $footer_options_map);


            // blog_options
            $blog_options_map = array(
                'hq_blog_title' => array(
                    'default' => 'Blog',
                    'label' => __('Blog Title', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'text',
                ),
                'hq_blog_subtitle' => array(
                    'default' => '',
                    'label' => __('Blog Subtitle', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'text',
                ),
                'hq_blog_layout' => array(
                    'default' => 'normal',
                    'label' => __('Blog Layout', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'select',
                    'choices' => array(
                        'normal' => 'Normal',
                        'masonry' => 'Masonry Grid',
                    )
                ),
                'hq_blog_layout_columns' => array(
                    'default' => 3,
                    'label' => __('Blog Columns', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'select',
                    'choices' => array(2 => 2, 3 => 3, 4 => 4, 5 => 5)
                ),
                'hq_blog_sidebar_link' => array(
                    'setting_type' => null,
                    'label' => __('Edit Sidebars', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_blog_settings',
                    'type' => 'link',
                    'custom_options' => array(
                        'link' => get_admin_url(null, '/themes.php?page=multiple_sidebars'),
                    ),
                ),
                'hq_blog_sidebar_left' => array(
                    'default' => 0,
                    'label' => __('Blog Sidebar Left', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_blog_sidebar_right' => array(
                    'default' => 0,
                    'label' => __('Blog Sidebar Right', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_blog_pagination_infinite' => array(
                    'default' => 0,
                    'label' => __('Blog Infinite scroll', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_meta_date_format' => array(
                    'default' => 'F jS, Y',
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Date Format', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'text',
                ),
                'hq_blog_excerpt_off' => array(
                    'default' => 0,
                    'label' => __('Full Post Content on Listing', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                    'choices' => array(
                        'excerpt' => 'Pagination',
                        'full' => 'Full Content',
                    )
                ),
                'hq_blog_excerpt_length' => array(
                    'default' => 55,
                    'sanitize_callback' => array($this, 'sanitize_number'),
                    'label' => __('Excerpt Length', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'text',
                ),
                // Listing Post Meta
                'blog_listing_page' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_blog_settings',
                    'type' => 'sub-title',
                    'label' => __('Listing Post Meta', HQTheme::THEME_SLUG),
                ),
                'hq_blog_list_meta' => array(
                    'default' => 1,
                    'label' => __('Post Meta in Listing', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_list_meta_author' => array(
                    'default' => 1,
                    'label' => __('Post Meta Author', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_list_meta_date' => array(
                    'default' => 1,
                    'label' => __('Post Meta Date', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'blog_list_meta_date' => array(
                    'setting_type' => null,
                    'label' => __('Formatting Date and Time', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_blog_settings',
                    'type' => 'link',
                    'custom_options' => array(
                        'link' => 'http://codex.wordpress.org/Formatting_Date_and_Time',
                    ),
                ),
                'hq_blog_list_meta_categories' => array(
                    'default' => 1,
                    'label' => __('Post Meta Categories', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_list_meta_comments' => array(
                    'default' => 1,
                    'label' => __('Post Meta Comments', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_list_meta_tags' => array(
                    'default' => 1,
                    'label' => __('Post Meta Tags', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_list_meta_read_more' => array(
                    'default' => 1,
                    'label' => __('Post Meta Read More Link', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                // Single Post Options
                'blog_single_page' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_blog_settings',
                    'type' => 'sub-title',
                    'label' => __('Single Post Options', HQTheme::THEME_SLUG),
                ),
                'hq_blog_single_featured_image' => array(
                    'default' => 1,
                    'label' => __('Featured Image on Post Page', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_single_title' => array(
                    'default' => 1,
                    'label' => __('Post Title', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_single_social' => array(
                    'default' => 1,
                    'label' => __('Post Social Shares', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_single_prev_next' => array(
                    'default' => 1,
                    'label' => __('Previous/Next Pagination', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'blog_single_meta' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_blog_settings',
                    'type' => 'sub-title',
                    'label' => __('Single Post Meta', HQTheme::THEME_SLUG),
                ),
                'hq_blog_single_meta' => array(
                    'default' => 1,
                    'label' => __('Post Meta', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_single_meta_author' => array(
                    'default' => 1,
                    'label' => __('Post Meta Author', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_single_meta_date' => array(
                    'default' => 1,
                    'label' => __('Post Meta Date', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'blog_single_meta_date' => array(
                    'setting_type' => null,
                    'label' => __('Formatting Date and Time', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_blog_settings',
                    'type' => 'link',
                    'custom_options' => array(
                        'link' => 'http://codex.wordpress.org/Formatting_Date_and_Time',
                    ),
                ),
                'hq_blog_single_meta_categories' => array(
                    'default' => 1,
                    'label' => __('Post Meta Categories', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_single_meta_comments' => array(
                    'default' => 1,
                    'label' => __('Post Meta Comments', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
                'hq_blog_single_meta_tags' => array(
                    'default' => 1,
                    'label' => __('Post Meta Tags', HQTheme::THEME_SLUG),
                    'section' => 'hq_blog_settings',
                    'type' => 'checkbox',
                ),
            ); //end of blog_options
            $blog_options_map = apply_filters('hq_blog_options_map', $blog_options_map);


            // woocommerce_options
            $woocommerce_options_map = array(
                'hq_woocommerce_catalog_mode' => array(
                    'default' => 0,
                    'label' => __('Catalog Mode', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'hq_woocommerce_hide_price' => array(
                    'default' => 1,
                    'label' => __('Hide Price', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'hq_woocommerce_layout' => array(
                    'default' => 'normal',
                    'label' => __('Shop Layout', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'select',
                    'choices' => array(
                        'normal' => 'Normal',
                        'grid' => 'Grid',
                    )
                ),
                'hq_woocommerce_sidebar_link' => array(
                    'setting_type' => null,
                    'label' => __('Edit Sidebars', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'link',
                    'custom_options' => array(
                        'link' => get_admin_url(null, '/themes.php?page=multiple_sidebars'),
                    ),
                ),
                'hq_woocommerce_sidebar_left' => array(
                    'default' => 0,
                    'label' => __('Shop Sidebar Left', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_woocommerce_sidebar_right' => array(
                    'default' => 0,
                    'label' => __('Shop Sidebar Right', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'select',
                    'choices' => $HQCustomize->getAvailableSidebars()
                ),
                'hq_woocommerce_pagination' => array(
                    'default' => 0,
                    'label' => __('Shop Infinite scroll', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'woocommerce_single_page' => array(
                    'setting_type' => null,
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'sub-title',
                    'label' => __('Product Page Options', HQTheme::THEME_SLUG),
                ),
                'hq_woocommerce_single_title' => array(
                    'default' => 1,
                    'label' => __('Product Title', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'hq_woocommerce_single_related_products' => array(
                    'default' => 1,
                    'label' => __('Related Products', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'hq_woocommerce_single_upsells' => array(
                    'default' => 1,
                    'label' => __('Up-sells', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'hq_woocommerce_single_ratings' => array(
                    'default' => 1,
                    'label' => __('Product Ratings', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'hq_woocommerce_single_social' => array(
                    'default' => 1,
                    'label' => __('Product Social Shares', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
                'hq_woocommerce_single_prev_next' => array(
                    'default' => 1,
                    'label' => __('Previous / Next Links', HQTheme::THEME_SLUG),
                    'section' => 'hq_woocommerce_settings',
                    'type' => 'checkbox',
                ),
            ); //end of woocommerce_options
            $woocommerce_options_map = apply_filters('hq_woocommerce_options_map', $woocommerce_options_map);

            // social_links_options
            $social_links_options_map = apply_filters('hq_social_links_options_map', $HQCustomize->generates_socials_links());
            $social_shares_options_map = apply_filters('hq_social_shares_options_map', $HQCustomize->generates_socials_shares());
            // end social_links_options
            // custom_blocks_options
            $custom_blocks_options_map = array(
                'hq_custom_css' => array(
                    'sanitize_callback' => array($this, 'sanitize_textarea'),
                    'label' => __('Custom css', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_custom_css',
                    'type' => 'textarea',
                    'notice' => __('', HQTheme::THEME_SLUG)
                ),
                'hq_custom_css_mobile' => array(
                    'sanitize_callback' => array($this, 'sanitize_textarea'),
                    'label' => __('Custom css (Only for mobile)', HQTheme::THEME_SLUG),
                    'control' => 'HQTheme_Controls',
                    'section' => 'hq_custom_css',
                    'type' => 'textarea',
                    'notice' => __('', HQTheme::THEME_SLUG),
                ),
            ); //end of custom_blocks_options
            $custom_blocks_options_map = apply_filters('hq_custom_blocks_options_map', $custom_blocks_options_map);

            // ADDING CONTROLS
            $add_setting_controls = array_merge(
                    $skin_options_map, $branding_options_map, $layout_options_map, $typography_options_map, $navigation_options_map, $header_options_map, $footer_options_map, $blog_options_map, $woocommerce_options_map, $social_links_options_map, $social_shares_options_map, $custom_blocks_options_map, apply_filters('_hq_custom_setting_controls', array())
            );
            $this->add_setting_controls = apply_filters('hq_add_setting_controls_map', $add_setting_controls);

            return $this;
        }

    }

}