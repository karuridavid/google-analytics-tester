<?php
/**
 * Plugin Name: Google Analytics Tester
 * Description: Checks if a given website URL has Google Analytics tracking code installed correctly.
 * Version: 1.1
 * Author: David Karuri
 * Author URI: https://qodewire.com/
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit;
}

function ga_tester_enqueue_styles() {
    wp_enqueue_style('ga-tester-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'ga_tester_enqueue_styles');

// Action links
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links) {
    $donate_link = '<a href="https://www.paypal.com/donate/?hosted_button_id=FFPK8672SJUKN" target="_blank" style="font-weight:700;color:#00c651">Donate</a>';
    array_unshift($links, $donate_link);
    return $links;
});

function ga_tester_shortcode() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/form.php';
    return ob_get_clean();
}
add_shortcode('ga_tester_form', 'ga_tester_shortcode');
?>