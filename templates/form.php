<?php
/**
 * Frontend template for the Google Analytics Tester form.
 */
?>

<div class="ga-tester-container" id="gatester-root">
  <form class="ga-tester-form" id="gatester-form" novalidate>
    <div class="ga-form-group">
      <label class="ga-form-label" for="gatester-url">Please Enter your Website URL</label>
      <input class="ga-url-input" type="url" id="gatester-url" name="gatester-url" placeholder="https://example.com" required>
    </div>
    <button class="ga-submit-btn" id="gatester-submit" type="submit">Check for Google Analytics</button>
  </form>

  <div class="ga-loading" id="gatester-loading" aria-hidden="true">
    <div class="ga-spinner"></div>
    <span>Analyzing website...</span>
  </div>

  <div class="ga-result" id="gatester-result" aria-live="polite"></div>

</div>
