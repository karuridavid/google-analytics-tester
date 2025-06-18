<form method="post">
	<input type="url" name="ga_test_url" id="ga_test_url" placeholder="Enter Website URL" required style="width: 100%;max-width:400px" /><br><br>
	<button type="submit">Check for Google Analytics</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ga_test_url'])) {
	include plugin_dir_path(__FILE__) . 'report.php';
}
?>