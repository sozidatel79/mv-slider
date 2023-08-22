<?php /** @noinspection PhpIncludeInspection */

/**
 * Plugin Name: MV Slider
 * Description: My plugin's description
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Anton Rotshtein
 * License: GPL v2 or later
 * Text Domain: mv-slider
 * Domain Path: /languages
 */


if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('MV_Slider')) {
    class MV_Slider
    {
        function __construct()
        {
            $this->define_constants();
            add_action('admin_menu', [ $this, 'mv_slider_admin_menu' ]);
            require_once(MV_SLIDER_PATH . 'post-types/class.mv-slider-cpt.php');
            require_once(MV_SLIDER_PATH . 'mv-slider-settings.php');
            $mv_slider_post_type = new MV_Slider_Post_Type();
            $mv_slider_settings = new MV_Slider_Settings();
        }

        public function mv_slider_admin_menu(){
            add_menu_page(
                'MV Slider Options',
                'MV Slider',
                'manage_options',
                'mv_slider_settings',
                [ $this, 'mv_slider_settings_page' ],
                'dashicons-images-alt2',
                10
            );

            add_submenu_page(
                'mv_slider_settings',
                'Manage Slides',
                'Manage Slides',
                'manage_options',
                'edit.php?post_type=mv-slider',
                null
            );

            add_submenu_page(
                'mv_slider_settings',
                'Add New Slide',
                'Add New Slide',
                'manage_options',
                'post-new.php?post_type=mv-slider',
                null
            );
        }

        public function mv_slider_settings_page() {
            require_once(MV_SLIDER_PATH . 'views/mv-slider_settings_page.php');
        }



        public function define_constants()
        {
            define('MV_SLIDER_PATH', plugin_dir_path(__FILE__));
            define('MV_SLIDER_URL', plugin_dir_url(__FILE__));
            define('MV_SLIDER_VERSION', '1.0.0');
        }

        public static function activate()
        {
            update_option('rewrite_rules', '');
        }

        public static function deactivate()
        {
            flush_rewrite_rules();
            unregister_post_type('mv-slider');
        }

        public static function uninstall()
        {

        }

    }
}

if (class_exists('MV_Slider')) {
    register_activation_hook(__FILE__, array('MV_Slider', 'activate'));
    register_deactivation_hook(__FILE__, array('MV_Slider', 'deactivate'));
    register_uninstall_hook(__FILE__, array('MV_Slider', 'uninstall'));

    $mv_slider = new MV_Slider();
} 
