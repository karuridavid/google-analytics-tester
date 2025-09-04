<?php
/**
 * Plugin Name: Google Analytics Tester
 * Description: Checks if a given website URL has Google Analytics (GA4/UA) installed. Modern frontend UI with AJAX via shortcode [ga_tester_form].
 * Version: 1.2.1
 * Author: Qodewire
 * Author URI: https://qodewire.com
 * License: GPL2+
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Enqueue assets only when the shortcode is present on the page.
 */
function gatester_enqueue_assets() {
    if ( is_admin() ) { return; }

    global $post;
    $has_sc = false;
    if ( $post && ( has_shortcode( $post->post_content, 'ga_tester_form' ) || has_block( 'shortcode', $post ) ) ) {
        $has_sc = true;
    }

    // As a fallback (e.g. page builders rendering content differently), also allow a query flag.
    if ( isset( $_GET['ga_tester'] ) ) { $has_sc = true; }

    if ( ! $has_sc ) { return; }

    $ver = filemtime( plugin_dir_path( __FILE__ ) . 'assets/style.css' );
    wp_register_style(
        'gatester-style',
        plugins_url( 'assets/style.css', __FILE__ ),
        array(),
        $ver
    );
    wp_enqueue_style( 'gatester-style' );

    wp_register_script(
        'gatester-frontend',
        plugins_url( 'assets/frontend.js', __FILE__ ),
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'assets/frontend.js' ),
        true
    );

    wp_localize_script( 'gatester-frontend', 'GATester', array(
        'ajax'  => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'gatester_nonce' ),
    ) );

    wp_enqueue_script( 'gatester-frontend' );
}
add_action( 'wp_enqueue_scripts', 'gatester_enqueue_assets' );

/**
 * Shortcode renderer
 * Usage: [ga_tester_form]
 */
function gatester_shortcode() {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'templates/form.php';
    return ob_get_clean();
}
add_shortcode( 'ga_tester_form', 'gatester_shortcode' );

/**
 * AJAX handler that checks a remote URL for GA code.
 */
function gatester_ajax_handler() {
    check_ajax_referer( 'gatester_nonce', 'nonce' );

    $url_raw = isset($_POST['url']) ? wp_unslash($_POST['url']) : '';
    $url = esc_url_raw( $url_raw );
    if ( empty( $url ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid URL.' ), 400 );
    }

    // Force a scheme if missing
    if ( ! preg_match( '#^https?://#i', $url ) ) {
        $url = 'https://' . ltrim( $url, '/' );
    }

    $args = array(
        'timeout' => 15,
        'user-agent' => 'Mozilla/5.0 (WordPress; Google Analytics Tester)',
        'redirection' => 5,
    );
    $response = wp_remote_get( $url, $args );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( array( 'message' => $response->get_error_message() ), 500 );
    }

    $code = wp_remote_retrieve_body( $response );
    if ( ! is_string( $code ) || $code === '' ) {
        wp_send_json_error( array( 'message' => 'Empty response from the site.' ), 500 );
    }

    // Patterns for GA detection
    $is_ga4 = false;
    $is_ua  = false;

    // GA4 common signals
    $ga4_patterns = array(
        '#gtag\\(\\s*[\'"]config[\'"]\\s*,\\s*[\'"]G-[A-Z0-9]+[\'"]\\s*\\)#i',
        '#googletagmanager\\.com/gtag/js\\?id=G-[A-Z0-9]+#i',
        '#dataLayer\\s*=\\s*\\[\\s*\\]\\s*;#i', // often present with GA4
    );

    // Universal Analytics (deprecated) signals
    $ua_patterns = array(
        '#UA-\\d{4,}-\\d+#i',
        '#ga\\(\\s*[\'"]create[\'"]#i',
        '#www\\.google-analytics\\.com/analytics\\.js#i',
    );

    foreach ( $ga4_patterns as $p ) {
        if ( preg_match( $p, $code ) ) { $is_ga4 = true; break; }
    }
    foreach ( $ua_patterns as $p ) {
        if ( preg_match( $p, $code ) ) { $is_ua = true; break; }
    }

    $result_type = $is_ga4 ? 'Google Analytics 4' : ( $is_ua ? 'Universal Analytics' : 'None' );
    $found = $is_ga4 || $is_ua;

    wp_send_json_success( array(
        'url'     => esc_url_raw( $url ),
        'found'   => $found,
        'type'    => $result_type,
        'message' => $found ? "Google Analytics tracking code found! Detected type: {$result_type}" : 'Google Analytics tracking code was not found on this website.',
    ) );
}
add_action( 'wp_ajax_gatester_check', 'gatester_ajax_handler' );
add_action( 'wp_ajax_nopriv_gatester_check', 'gatester_ajax_handler' );

// Action links
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links) {
    $custom_link = '<a href="https://qodewire.com" target="_blank" style="font-weight:700;color:#00c651">Hire Me </a>';
	$more = '<a href="https://github.com/karuridavid/google-analytics-tester" target="_blank">Details </a>';
    array_unshift( $links, $custom_link, $more );
    return $links;
});