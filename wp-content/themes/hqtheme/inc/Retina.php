<?php

if (!class_exists('HQTheme_Retina_Support')) {

    /**
     * Add retina support
     * 
     * @link http://code.tutsplus.com/tutorials/ensuring-your-theme-has-retina-support--wp-33430
     * @since HQTheme 1.0
     */
    class HQTheme_Retina_Support {

        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'retina_support_enqueue_scripts'));
            add_filter('wp_generate_attachment_metadata', array($this, 'retina_support_attachment_meta'), 10, 2);
        }

        /**
         * Enqueueing retina.js
         *
         * This function is attached to the 'wp_enqueue_scripts' action hook.
         */
        function retina_support_enqueue_scripts() {
            wp_enqueue_script('retina-js', get_template_directory_uri() . '/js/retina.js', '', HQTheme::VERSION, true);
        }

        /**
         * Retina images
         *
         * This function is attached to the 'wp_generate_attachment_metadata' filter hook.
         */
        function retina_support_attachment_meta($metadata, $attachment_id) {
            foreach ($metadata as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $image => $attr) {
                        if (is_array($attr))
                            $this->_retina_support_create_images(get_attached_file($attachment_id), $attr['width'], $attr['height'], true);
                    }
                }
            }

            return $metadata;
        }

        /**
         * Create retina-ready images
         *
         * Referenced via retina_support_attachment_meta().
         */
        protected function _retina_support_create_images($file, $width, $height, $crop = false) {
            if ($width || $height) {
                $resized_file = wp_get_image_editor($file);
                if (!is_wp_error($resized_file)) {
                    $filename = $resized_file->generate_filename($width . 'x' . $height . '@2x');

                    $resized_file->resize($width * 2, $height * 2, $crop);
                    $resized_file->save($filename);

                    $info = $resized_file->get_size();

                    return array(
                        'file' => wp_basename($filename),
                        'width' => $info['width'],
                        'height' => $info['height'],
                    );
                }
            }
            return false;
        }

    }

}

new HQTheme_Retina_Support();
