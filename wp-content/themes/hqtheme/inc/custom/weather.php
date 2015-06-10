<?php

// Creating the widget 
class weather_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
// Base ID of your widget
                'weather_widget',
// Widget name will appear in UI
                __('Weather Widget', 'weather_widget'),
// Widget description
                array('description' => __('', 'weather_widget'),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $instance) {
        try {
            if (isset($_SESSION['weather'])) {
                $weather = $_SESSION['weather'];
            } else {
                $url = 'http://weather.yahooapis.com/forecastrss?w=839722&u=c';
                $ctx = stream_context_create(array('http' =>
                    array(
                        'timeout' => 10, // 1 200 Seconds = 20 Minutes
                    )
                ));
                $weather = file_get_contents($url, false, $ctx);
                $weather = substr($weather, strpos($weather, 'yweather:condition') + 20);
                $weather = substr($weather, 0, strpos($weather, '/>'));

                $weatherCode = substr($weather, strpos($weather, 'code="') + 6);
                $weatherCode = substr($weatherCode, 0, strpos($weatherCode, '"'));
                $weatherImg = 'http://l.yimg.com/a/i/us/nws/weather/gr/' . $weatherCode . 's.png';

                $weatherTemp = substr($weather, strpos($weather, 'temp="') + 6);
                $weatherTemp = substr($weatherTemp, 0, strpos($weatherTemp, '"'));

                $weather = new stdClass();
                $weather->img = $weatherImg;
                $weather->temp = $weatherTemp;
                $_SESSION['weather'] = $weather;
            }
            ?>
            <div id="weather">
                <?php echo $instance['title'] . '<img src="' . $weather->img . '" />' . $weather->temp; ?>&deg;C&nbsp;
            </div>
            <?php
        } catch (Exception $exc) {
            
        }
    }

// Widget Backend 
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'wpb_widget_domain');
        }
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

// Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function weather_widget_load_widget() {
    register_widget('weather_widget');
}

add_action('widgets_init', 'weather_widget_load_widget');
