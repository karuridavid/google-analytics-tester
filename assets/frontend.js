(function(){
  function $(sel, ctx){ return (ctx||document).querySelector(sel); }

  document.addEventListener('DOMContentLoaded', function(){
    var form = $('#gatester-form');
    if(!form) return;

    var urlInput = $('#gatester-url');
    var loading  = $('#gatester-loading');
    var result   = $('#gatester-result');
    var btn      = $('#gatester-submit');

    function setLoading(on){
      loading.setAttribute('aria-hidden', on ? 'false' : 'true');
      loading.style.display = on ? 'flex' : 'none';
      btn.disabled = on;
    }

    form.addEventListener('submit', function(e){
      e.preventDefault();
      result.innerHTML = '';
      result.className = 'ga-result';
      var url = (urlInput.value || '').trim();
      if(!url){ urlInput.focus(); return; }

      setLoading(true);

      var data = new FormData();
      data.append('action', 'gatester_check');
      data.append('nonce', (window.GATester && GATester.nonce) ? GATester.nonce : '');
      data.append('url', url);

      fetch( (window.GATester && GATester.ajax) ? GATester.ajax : '/wp-admin/admin-ajax.php', {
        method: 'POST',
        credentials: 'same-origin',
        body: data
      })
      .then(function(r){ return r.json(); })
      .then(function(json){
        setLoading(false);
        if(json && json.success && json.data){
          var d = json.data;
          if(d.found){
            result.classList.add('ga-result-success');
            result.innerHTML = '<div class="ga-result-title"><span class="ga-result-icon">✅</span> Google Analytics Found</div>' +
                               '<div class="ga-result-meta">Tested URL: ' + d.url + '</div>' +
                               '<p class="ga-result-message">' + d.message + '</p>';
          } else {
            result.classList.add('ga-result-error');
            result.innerHTML = '<div class="ga-result-title"><span class="ga-result-icon">🔍</span> Not Detected</div>' +
                               '<div class="ga-result-meta">Tested URL: ' + d.url + '</div>' +
                               '<p class="ga-result-message">' + d.message + '</p>';
          }
        } else {
          result.classList.add('ga-result-error');
          result.innerHTML = '<div class="ga-result-title"><span class="ga-result-icon">⚠️</span> Error</div>' +
                             '<p class="ga-result-message">Something went wrong. Please try again.</p>';
        }
      })
      .catch(function(err){
        setLoading(false);
        result.classList.add('ga-result-error');
        result.innerHTML = '<div class="ga-result-title"><span class="ga-result-icon">⚠️</span> Error</div>' +
                           '<p class="ga-result-message">' + (err && err.message ? err.message : 'Network error') + '</p>';
      });
    });
  });
})();