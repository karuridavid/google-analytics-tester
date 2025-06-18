<?php
$url = esc_url($_POST['ga_test_url']);
$response = wp_remote_get($url);

if (is_wp_error($response)) {
    echo "<p>Error fetching the URL. Please try again.</p>";
    return;
}

$html = wp_remote_retrieve_body($response);

$has_ga = false;

$ga_patterns = array(
    "/www\.google-analytics\.com\/analytics\.js/",
    "/gtag\(\s*['\"]config['\"]\s*,/",
    "/GoogleAnalyticsObject/",
    "/www\.googletagmanager\.com\/gtag\/js/"
);

foreach ($ga_patterns as $pattern) {
    if (preg_match($pattern, $html)) {
        $has_ga = true;
        break;
    }
}

echo "<h5>Google Analytics Test Result for: $url</h5>";
if ($has_ga) {
    echo "<p style='color: green;'><strong>✅ Google Analytics tracking code found.</strong></p>";
} else {
    echo "<p style='color: red;'><strong>❌ Google Analytics tracking code NOT found.</strong></p>";
}
?>
