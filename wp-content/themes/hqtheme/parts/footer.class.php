<?php
if (!class_exists('HQTheme_Footer')) {

    class HQTheme_Footer {

        /**
         *
         * @var HQTheme_Footer 
         */
        static $instance;

        function __construct() {
            self::$instance = & $this;

            add_action('__after_main_container', array($this, 'footer_display'), 9900);
        }

        public function footer_display() {
            ?>
            <footer>
                <?php
                $this->footer_widgets_display();

                $display = get_theme_mod('hq_footer_bottom_display');
                if ($display) {
                    HQTheme_Elements::getInstance()->headerFooterLine('footer_bottom');
                }
                ?>
            </footer>
            <?php
        }

        public function footer_widgets_display() {
            $first = get_theme_mod('hq_footer_widgets_first');
            $second = get_theme_mod('hq_footer_widgets_second');
            $third = get_theme_mod('hq_footer_widgets_third');
            $fourth = get_theme_mod('hq_footer_widgets_fourth');

            if ($first || $second || $third || $fourth) {
                $count = 0;
                if ($first)
                    ++$count;
                if ($second)
                    ++$count;
                if ($third)
                    ++$count;
                if ($fourth)
                    ++$count;
                echo '<div class="row fooret-widgets"><div class="content-wrapper">';
                $width = 12 / $count;
                $width = (12 / $count < 6 ? 'col-sm-6 col-md-' . 12 / $count : 'col-sm-6');
                if ($first)
                    generated_dynamic_sidebar($first, $width);
                if ($second)
                    generated_dynamic_sidebar($second, $width);
                if ($third)
                    generated_dynamic_sidebar($third, $width);
                if ($fourth)
                    generated_dynamic_sidebar($fourth, $width);
                echo '</div></div>';
            }
        }

    }

}