<?php
/*
Plugin Name: Remove Tracking Parameters
Description: Removes specified tracking parameters from URL and redirects.
Version: 1.1
Author: seojacky
Author URI: https://t.me/big_jacky
Plugin URI: https://github.com/seojacky/remove-tracking-params
GitHub Plugin URI: https://github.com/seojacky/remove-tracking-params
*/

// Подключаем файл настроек
include(plugin_dir_path(__FILE__) . 'admin-settings.php');

// Функция удаления параметров из URL
function rtp_remove_tracking_params() {
    // Получаем список параметров для удаления из настроек
    $params = get_option('remove_tracking_params_list');

    // Проверяем, если параметры не заданы, выходим
    if (!$params) return;

    // Преобразуем строку с параметрами в массив
    $params_array = explode(',', $params);
    $params_array = array_map('trim', $params_array); // Убираем пробелы вокруг каждого параметра

    // Проверяем наличие хотя бы одного параметра из списка в URL
    foreach ($params_array as $param) {
        if (isset($_GET[$param])) {
            // Параметр найден, создаём URL без указанных параметров
            $url = $_SERVER['REQUEST_URI'];
            foreach ($params_array as $param_to_remove) {
                $url = preg_replace('/([?&])' . preg_quote($param_to_remove, '/') . '=[^&]*(&|$)/', '$1', $url);
            }
            $url = rtrim($url, '?&'); // Убираем лишний символ, если нужно
            
            // Выполняем 301 редирект на URL без указанных параметров
            wp_redirect($url, 302);
            exit;
        }
    }
}
add_action('template_redirect', 'rtp_remove_tracking_params');