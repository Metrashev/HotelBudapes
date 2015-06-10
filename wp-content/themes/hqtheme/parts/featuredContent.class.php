<?php
if (!class_exists('HQTheme_FeaturedContent')) {

    /**
     * Add featured content
     * 
     * @since HQTheme 1.0
     */
    class HQTheme_FeaturedContent {

        /**
         *
         * @var HQTheme_FeaturedContent 
         */
        static $instance;

        function __construct() {
            self::$instance = & $this;
        }

        // Output featured images in an <a> tag on index pages and a <div> for single posts and pages.
        function featured_images($cropped = false) {

            if (post_password_required()) {
                return;
            }

            $images = array();
            if (has_post_thumbnail()) {
                $images[] = get_post_thumbnail_id();
            }
            if (class_exists('Dynamic_Featured_Image')) {
                global $dynamic_featured_image;
                $featured_images = $dynamic_featured_image->get_featured_images();

                if (count($featured_images)) {
                    foreach ($featured_images as $image) {
                        $images[] = $image['attachment_id'];
                    }
                }
            }

            if (count($images)) {
                $html = do_shortcode('[slider source="media: ' . implode(',', $images) . '"  limit="20" link="none" target="self" width="600" height="300" responsive="yes" title="no" centered="yes" arrows="no" pages="yes" mousewheel="yes" autoplay="5000" speed="600"]');
                if (is_singular()) {
                    echo '<div class="entry-thumb">' . $html . '</div>';
                } else {
                    echo '<a href="' . esc_url(get_permalink()) . '" class="entry-thumb" title="' . esc_attr(sprintf(__('Permalink to: "%s"', '___'), the_title_attribute('echo=0'))) . '">' . $html . '</a>';
                }
            }
        }

        // Featured Audio
        function featured_audio() {

            $mp3 = get_field('mp3_file_url');
            $ogg = get_field('oga_file_url');
            $embed = get_field('embedded_audio_code');
            ?>

            <?php if ($embed != '') { ?>

                <div class="x-responsive-audio-embed">
                    <?php echo stripslashes(htmlspecialchars_decode($embed)); ?>
                </div>

            <?php } else { ?>

                <script>
                    jQuery(document).ready(function($){
                    if ($().jPlayer) {
                    $('#jplayer_<?php echo get_the_ID(); ?>').jPlayer({
                    ready: function () {
                    $(this).jPlayer('setMedia', {
                <?php if ($mp3 != '') : ?>
                        mp3: '<?php echo $mp3; ?>',
                <?php endif; ?>
                <?php if ($ogg != '') : ?>
                        oga: '<?php echo $ogg; ?>',
                <?php endif; ?>
                    end: ''
                    });
                    },
                            size: {
                            width: '100%',
                                    height: '0'
                            },
                            swfPath: '<?php echo get_template_directory_uri(); ?>/framework/js/vendor/jplayer',
                            cssSelectorAncestor: '#jp_interface_<?php echo get_the_ID(); ?>',
                            supplied: '<?php if ($mp3 != "") : ?>mp3, <?php endif; ?><?php if ($ogg != "") : ?>oga,<?php endif; ?> all'
                    });
                    }
                    });</script>

                <div id="jplayer_<?php echo get_the_ID(); ?>" class="jp-jplayer jp-jplayer-audio"></div>
                <div class="jp-controls-container jp-controls-container-audio">
                    <div id="jp_interface_<?php echo get_the_ID(); ?>" class="jp-interface">
                        <ul class="jp-controls">
                            <li><a href="#" class="jp-play" tabindex="1"><span>Play</span></a></li>
                            <li><a href="#" class="jp-pause" tabindex="1"><span>Pause</span></a></li>
                        </ul>
                        <div class="jp-progress-container">
                            <div class="jp-progress">
                                <div class="jp-seek-bar">
                                    <div class="jp-play-bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php
        }

        // Featured Video
        function featured_video($post_type = 'video') {

            $stack = get_stack();

            $aspect_ratio = get_post_meta(get_the_ID(), '_' . $post_type . '_aspect_ratio', true);
            $m4v = get_post_meta(get_the_ID(), '_' . $post_type . '_m4v', true);
            $ogv = get_post_meta(get_the_ID(), '_' . $post_type . '_ogv', true);
            $embed = get_post_meta(get_the_ID(), '_' . $post_type . '_embed', true);
            $poster = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'entry-full-' . $stack, false);

            switch ($aspect_ratio) {
                case '16:9' :
                    $aspect_ratio_class = '';
                    break;
                case '5:3' :
                    $aspect_ratio_class = 'five-by-three';
                    break;
                case '5:4' :
                    $aspect_ratio_class = 'five-by-four';
                    break;
                case '4:3' :
                    $aspect_ratio_class = 'four-by-three';
                    break;
                case '3:2' :
                    $aspect_ratio_class = 'three-by-two';
                    break;
            }

            if ($embed != '') {
                ?>

                <div class="x-responsive-video man">
                    <div class="x-responsive-video-inner <?php echo $aspect_ratio_class; ?>">
                        <?php echo stripslashes(htmlspecialchars_decode($embed)); ?>
                    </div>
                </div>

            <?php } else { ?>

                <script>
                            jQuery(document).ready(function($){
                    if ($().jPlayer) {
                    $('#jplayer_<?php echo get_the_ID(); ?>').jPlayer({
                    ready: function () {
                    $(this).jPlayer('setMedia', {
                <?php if ($m4v != '') : ?>
                        m4v: '<?php echo $m4v; ?>',
                <?php endif; ?>
                <?php if ($ogv != '') : ?>
                        ogv: '<?php echo $ogv; ?>',
                <?php endif; ?>
                <?php if ($poster != '') : ?>
                        poster: '<?php echo $poster[0]; ?>'
                <?php endif; ?>
                    });
                    },
                            size: {
                            width: '100%',
                                    height: '100%'
                            },
                            swfPath: '<?php echo get_template_directory_uri(); ?>/framework/js/vendor/jplayer',
                            cssSelectorAncestor: '#jp_interface_<?php echo get_the_ID(); ?>',
                            supplied: '<?php if ($m4v != "") : ?>m4v, <?php endif; ?><?php if ($ogv != "") : ?>ogv<?php endif; ?>'
                                });
                                        $('#jplayer_<?php echo get_the_ID(); ?>').bind($.jPlayer.event.playing, function(event) {
                                $(this).add('#jp_interface_<?php echo get_the_ID(); ?>').hover(function() {
                                $('#jp_interface_<?php echo get_the_ID(); ?>').stop().animate({ opacity: 1 }, 400);
                                }, function() {
                                $('#jp_interface_<?php echo get_the_ID(); ?>').stop().animate({ opacity: 0 }, 400);
                                });
                                });
                                        $('#jplayer_<?php echo get_the_ID(); ?>').bind($.jPlayer.event.pause, function(event) {
                                $('#jplayer_<?php echo get_the_ID(); ?>').add('#jp_interface_<?php echo get_the_ID(); ?>').unbind('hover');
                                        $('#jp_interface_<?php echo get_the_ID(); ?>').stop().animate({ opacity: 1 }, 400);
                                });
                                }
                                });</script>

                <div class="x-responsive-video man">
                    <div class="x-responsive-video-inner <?php echo $aspect_ratio_class; ?>">
                        <div id="jplayer_<?php echo get_the_ID(); ?>" class="jp-jplayer jp-jplayer-video"></div>
                        <div class="jp-controls-container jp-controls-container-video">
                            <div id="jp_interface_<?php echo get_the_ID(); ?>" class="jp-interface">
                                <ul class="jp-controls">
                                    <li><a href="#" class="jp-play" tabindex="1"><span>Play</span></a></li>
                                    <li><a href="#" class="jp-pause" tabindex="1"><span>Pause</span></a></li>
                                </ul>
                                <div class="jp-progress-container">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        }

        // Featured Portfolio
        function featured_portfolio($cropped = '') {

            $media = get_post_meta(get_the_ID(), '_portfolio_media', true);
            $indemedia = get_post_meta(get_the_ID(), '_portfolio_indemedia', true);

            if (is_singular()) {
                switch ($media) {
                    case 'Image' :
                        featured_image();
                        break;
                    case 'Gallery' :
                        featured_gallery();
                        break;
                    case 'Video' :
                        featured_video('portfolio');
                        break;
                }
            } else {
                if ($indemedia == 'Media') {
                    switch ($media) {
                        case 'Image' :
                            ( $cropped == 'cropped' ) ? featured_image('cropped') : featured_image();
                            break;
                        case 'Gallery' :
                            featured_gallery();
                            break;
                        case 'Video' :
                            featured_video('portfolio');
                            break;
                    }
                } else {
                    ( $cropped == 'cropped' ) ? featured_image('cropped') : featured_image();
                }
            }
        }

        // Featured Background
        function featured_background() {

            static $featured_background_counter = 1;

            $background_images = get_field('background_images');
            $background_animation = get_field('background_animation');
            $background_animation_duration = get_field('background_animation_duration');
            $background_images_duration = get_field('background_images_duration');

            if ($background_images) {
                wp_enqueue_script('jquery.superslides');
                echo '<div id="slides' . $featured_background_counter . '" class="background-superslides"><div class="slides-container">';
                foreach ($background_images as $image) {
                    //echo wp_get_attachment_image($image['ID'], 'fullwidth');
                    echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
                }
                echo '</div>';
                echo '</div>';
                ?>
                <script>
                            jQuery(function() {
                            jQuery('#slides<?php echo $featured_background_counter; ?>').superslides({
                            hashchange: false,
                                    slide_speed: <?php echo $background_animation_duration ?>,
                                    animation: '<?php echo $background_animation ?>',
                                    pagination: false,
                <?php
                if (count($background_images) > 1) {
                    echo 'play: ' . $background_images_duration;
                }
                ?>
                            });
                            });
                </script>
                <?php
            }
        }

    }

}

new HQTheme_FeaturedContent();
