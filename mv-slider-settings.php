<?php

if (!class_exists('MV_Slider_Settings')) {

    class MV_Slider_Settings
    {
        public static $options;

        public function __construct()
        {
            self::$options = get_option('mv_slider_options');
            add_action('admin_init', [$this, 'add_sections_fields']);
        }

        public function add_sections_fields()
        {

            register_setting('mv-slider-group', 'mv_slider_options', [$this, 'sanitize_settings_values']);
            /*      SECTIONS        */
            add_settings_section(
                'mv-slider-settings_shortcode',
                'How does work',
                null,
                'mv_slider_settings_page_1'
            );

            add_settings_section(
                'mv-slider-settings_options',
                'Settings',
                null,
                'mv_slider_settings_page_2'
            );
            /*        FIELDS          */
            add_settings_field(
                'mv-slider-shortcode',
                'Shortcode',
                [$this, 'shortcode_template'],
                'mv_slider_settings_page_1',
                'mv-slider-settings_shortcode'
            );

            add_settings_field(
                'mv_slider_title',
                'Slider Title',
                [$this, 'options_template_title_input'],
                'mv_slider_settings_page_2',
                'mv-slider-settings_options',
                [
                    'label_for' => 'mv_slider_title'
                ]
            );

            add_settings_field(
                'mv_slider_bullets',
                'Display Control Bullets',
                [$this, 'options_template_bullet_input'],
                'mv_slider_settings_page_2',
                'mv-slider-settings_options',
                [
                    'label_for' => 'mv_slider_bullets'
                ]
            );

            add_settings_field(
                'mv_slider_style',
                'Slider Style',
                [$this, 'options_template_style_input'],
                'mv_slider_settings_page_2',
                'mv-slider-settings_options',
                [
                    'label_for' => 'mv_slider_style'
                ]
            );

        }

        public function sanitize_settings_values($values)
        {
            $new_values = [];
            if (count($values)) {
                foreach ($values as $key => $value) {
                    $new_values[$key] = sanitize_text_field($value);
                }
            }
            return $new_values;
        }

        public function shortcode_template()
        {
            require_once(MV_SLIDER_PATH . 'views/mv-slider-admin-shortcode.php');
        }

        public function options_template_title_input()
        {
            ?>
            <input class="regular-text code"
                   name="mv_slider_options[mv_slider_title]"
                   type="text"
                   id="mv_slider_title"
                   value="<?php echo MV_Slider_Settings::$options['mv_slider_title'] ?? '' ?>"
            />
            <?php
        }

        public function options_template_bullet_input()
        {
            ?>
            <input class="regular-text code"
                   name="mv_slider_options[mv_slider_bullets]"
                   type="checkbox"
                   id="mv_slider_bullets"
                   value="1"
                <?php checked('1', MV_Slider_Settings::$options['mv_slider_bullets'] ?? '', true) ?>
            />
            <?php
        }

        public function options_template_style_input()
        {
            ?>
            <select name="mv_slider_options[mv_slider_style]" id="mv_slider_style"
                    value="<?php echo MV_Slider_Settings::$options['mv_slider_style'] ?? '' ?>">
                <option <?php selected('dark', MV_Slider_Settings::$options['mv_slider_style'] ?? '', true) ?>
                        value="dark"><?php echo esc_html__('Dark') ?></option>
                <option <?php echo selected('light', MV_Slider_Settings::$options['mv_slider_style'] ?? '', true) ?>
                        value="light"><?php echo esc_html__('Light') ?></option>
            </select>
            <?php
        }


    }
}
