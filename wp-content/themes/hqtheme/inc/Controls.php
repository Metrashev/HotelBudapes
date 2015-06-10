<?php
if (!class_exists('HQTheme_Controls')) {

    /**
     * Contains controls for customizing the theme.
     * 
     * @link http://codex.wordpress.org/Theme_Customization_API
     * @since HQTheme 1.0
     */
    class HQTheme_Controls extends WP_Customize_Control {

        public $type;
        public $link;
        public $title;
        public $step;
        public $min;
        public $additionalOptions;

        public function render_content() {
            switch ($this->type) {
                case 'hr':
                    echo '<hr class="customize-separator" />';
                    break;

                case 'sub-title' :
                    if (isset($this->label)) {
                        ?>
                        <h4 class="customize-sub-title"><?php echo esc_html($this->label); ?></h4>
                        <?php
                    }
                    break;

                case 'link':
                    echo '<a class="customize-link" href="' . $this->link . '" target="_blank">' . esc_html($this->label) . '</a>';
                    break;

                case 'button':
                    echo '<a class="customize-button" >' . esc_html($this->label) . '</a>';
                    break;

                case 'description':
                    ?>
                    <p class="customize-description"><span>Info:</span> <?php echo $this->label; ?></p>
                    <?php
                    break;

                case 'warning':
                    ?>
                    <p class="customize-warning"><span>Warning:</span> <?php echo esc_html($this->label); ?></p>
                    <?php
                    break;

                case 'hqcolor':
                    ?>
                    <label>
                        <span class="hq-custom-title"><?php echo esc_html($this->label); ?></span>
                        <input type="text" <?php $this->link(); ?> value="<?php echo esc_html($this->value()); ?>" class="colorPicker" />
                    </label>
                    <?php
                    break;

                case 'number':
                    ?>
                    <label>
                        <span class="hq-custom-title"><?php echo esc_html($this->label); ?></span>
                        <input type="number" <?php $this->link(); ?> value="<?php echo intval($this->value()); ?>" />
                    </label>
                    <?php
                    break;

                case 'textarea':
                    ?>
                    <label>
                        <span class="hq-custom-title"><?php echo esc_html($this->label); ?></span>
                        <textarea <?php $this->link(); ?> rows="10" style="width: 98%;"><?php echo esc_textarea($this->value()); ?></textarea>
                    </label>
                    <?php
                    break;


                case 'url':
                    ?>
                    <label>
                        <span class="hq-custom-title"><?php echo esc_html($this->label); ?></span>
                        <input type="text" value="<?php echo esc_url($this->value()); ?>"  <?php $this->link(); ?> />
                    </label>
                    <?php
                    break;

                case 'multiple-select':
                    ?>
                    <label>
                        <span class="hq-custom-title"><?php echo esc_html($this->label); ?></span>
                        <select <?php $this->link(); ?> multiple="multiple" style="height: 156px;">
                            <?php
                            foreach ($this->choices as $value => $label) {
                                $selected = ( in_array($value, $this->value()) ) ? selected(1, 1, false) : '';
                                echo '<option value="' . esc_attr($value) . '"' . $selected . '>' . $label . '</option>';
                            }
                            ?>
                        </select>
                    </label>
                    <?php
                    break;

                case 'textoptions':
                    ?>
                    <label>
                        <h5 class="hq-custom-title"><?php echo esc_html($this->label); ?></h5>
                        <span class="hq-custom-options hq-custom-options-group hidden">
                            <?php
                            $this->_select('font-family', 'Font');
                            $this->_color('color', 'Color');
                            $this->_number('font-size', 'Font Size');
                            $this->_number('letter-spacing', 'Letter Spacing');
                            $this->_select('font-weight', 'Font Weight');
                            $this->_select('text-decoration', 'Text Decoration');
                            $this->_select('font-style', 'Font Style');
                            $this->_select('text-transform', 'Text Transform');
                            ?>
                            <input class="value" type="hidden" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
                        </span>
                    </label>
                    <?php
                    break;

                case 'boxoptions':
                    ?>
                    <label>
                        <h5 class="hq-custom-title"><?php echo esc_html($this->label); ?></h5>
                        <span class="hq-custom-options hq-custom-options-group hidden">
                            <?php
                            $this->_offsets('margin', 'Margin (px)');
                            $this->_offsets('padding', 'Padding (px)');
                            $this->_borders('borders', 'Borders');
                            ?>
                            <input class="value" type="hidden" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
                        </span>
                    </label>
                    <?php
                    break;

                case 'backgroundoptions':
                    ?>
                    <label>
                        <h5 class="hq-custom-title"><?php echo esc_html($this->label); ?></h5>
                        <span class="hq-custom-options hq-custom-options-group hidden">
                            <?php
                            $this->_color('background-color', 'Color');
                            $this->_select('background-repeat', 'Repeat');
                            $this->_select('background-size', 'Size');
                            $this->_select('background-attachment', 'Attachment');
                            $this->_select('background-position', 'position');
                            ?>
                            <input class="value" type="hidden" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
                        </span>
                    </label>
                    <?php
                    break;

                default:
                    '';
                    break;
            }
        }

        public function content_template() {
            
        }

        protected function _select($link, $name = '') {
            if (isset($this->additionalOptions[$link])) {
                echo $name;
                ?>
                <select class="option" data-hq-link="<?php echo $link; ?>">
                    <?php
                    foreach ($this->additionalOptions[$link] as $value => $label)
                        echo '<option value="' . esc_attr($value) . '">' . $label . '</option>';
                    ?>
                </select>
                <?php
            }
        }

        protected function _number($link, $name = '') {
            if (isset($this->additionalOptions[$link])) {
                echo $name . ' <input class="option" type="number" data-hq-link="' . $link . '">';
            }
        }

        protected function _color($link, $name = '') {
            if (isset($this->additionalOptions[$link])) {
                echo $name, ' <input type="text" data-hq-link="' . $link . '" class="option colorPicker">';
            }
        }

        protected function _offsets($link, $name = '') {
            if (isset($this->additionalOptions[$link])) {
                echo $name . ' <input class="option border-top" type="number" data-hq-link="' . $link . '-top">'
                . ' <input class="option border-right" type="number" data-hq-link="' . $link . '-right">'
                . ' <input class="option border-bottom" type="number" data-hq-link="' . $link . '-bottom">'
                . ' <input class="option border-left" type="number" data-hq-link="' . $link . '-left">';
            }
        }

        protected function _borders($link, $name = '') {
            if (isset($this->additionalOptions[$link])) {
                echo $name;
                $this->_border('top', $this->additionalOptions[$link]);
                $this->_border('right', $this->additionalOptions[$link]);
                $this->_border('bottom', $this->additionalOptions[$link]);
                $this->_border('left', $this->additionalOptions[$link]);
            }
        }

        protected function _border($pos, $options) {
            if (in_array('style', $options)) {
                ?>
                <select class="option border-<?php echo $pos; ?>" data-hq-link="border-<?php echo $pos; ?>-style">
                    <option value="initial">default value.</option>
                    <option value="none">no border</option>
                    <option value="dotted">dotted border</option>
                    <option value="dashed">dashed border</option>
                    <option value="solid">solid border</option>
                    <option value="double">double border</option>
                </select>
                <?php
            }
            if (in_array('width', $options)) {
                echo '<input class="option border-' . $pos . '" type="number" data-hq-link="border-' . $pos . '-width">';
            }
            if (in_array('color', $options)) {
                echo '<input type="text" class="option border-' . $pos . ' colorPicker" data-hq-link="border-' . $pos . '-color">';
            }
        }

    }

}