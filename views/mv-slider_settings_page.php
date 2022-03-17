<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php
        settings_fields( 'mv-slider-group' );
        do_settings_sections( 'mv_slider_settings_page_1' );
        do_settings_sections( 'mv_slider_settings_page_2' );
        submit_button('Save Settings');
        ?>
    </form>
</div>