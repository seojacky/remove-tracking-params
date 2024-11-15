<?php

// Регистрация страницы настроек
function rtp_add_admin_menu() {
    add_options_page(
        'Remove Tracking Parameters Settings',
        'Remove Tracking Parameters',
        'manage_options',
        'remove-tracking-params',
        'rtp_settings_page'
    );
}
add_action('admin_menu', 'rtp_add_admin_menu');

// Отображение страницы настроек
function rtp_settings_page() {
    ?>
    <div class="wrap">
        <h1>Remove Tracking Parameters Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('rtp_settings_group');
            do_settings_sections('remove-tracking-params');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Регистрация настроек
function rtp_settings_init() {
    register_setting('rtp_settings_group', 'remove_tracking_params_list');
    
    add_settings_section(
        'rtp_settings_section',
        'Configure Tracking Parameters',
        'rtp_settings_section_callback',
        'remove-tracking-params'
    );
    
    add_settings_field(
        'remove_tracking_params_list',
        'Parameters to Remove',
        'rtp_settings_field_callback',
        'remove-tracking-params',
        'rtp_settings_section'
    );
}
add_action('admin_init', 'rtp_settings_init');

// Описание секции настроек
function rtp_settings_section_callback() {
    echo '<p>Enter the tracking parameters you want to remove from URLs, separated by commas (e.g., utm_source,ysclid,fbclid).</p>';
	echo "<p>Don't forget <b>to clear your cache</b> after activating the plugin or adding a new parameter!</p>";
}

// Поле ввода параметров
function rtp_settings_field_callback() {
    $value = get_option('remove_tracking_params_list', '');
    echo '<textarea name="remove_tracking_params_list" rows="3" cols="50">' . esc_attr($value) . '</textarea>';
}
