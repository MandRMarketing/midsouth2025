<?php
    //Google Tag Manager Container ID is pulled from the 'Options' Tab
    //Hybrid Preconnect/Lazy Load Implementation
?>
<!-- Google Tag Manager (Lazy Load with Intersection Observer) -->
<script id="gtm-loader" data-gtm-id="<?= get_field('tag_manager_container_id','options') ?>">
(function(w,d,s,l,i){
  // GTM initialization function
  var loadGTM = function() {
    if (w[l] && w[l].length) return; // Already loaded
    w[l] = w[l] || [];
    w[l].push({'gtm.start': new Date().getTime(), event:'gtm.js'});
    var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
  };

  // Intersection Observer for lazy loading
  if ('IntersectionObserver' in w) {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          loadGTM();
          observer.disconnect();
        }
      });
    }, { rootMargin: '50px' });
    
    var trigger = d.createElement('div');
    trigger.id = 'gtm-trigger';
    trigger.style.cssText = 'display:none;pointer-events:none;';
    d.body.appendChild(trigger);
    observer.observe(trigger);
  } else {
    // Fallback: Load immediately if IntersectionObserver not supported
    loadGTM();
  }
  
  // Ensure GTM loads within 3 seconds even if user hasn't scrolled
  setTimeout(function() {
    if (!w[l] || !w[l].some(function(e) { return e.event === 'gtm.js'; })) {
      loadGTM();
    }
  }, 3000);
})(window,document,'script','dataLayer','<?= get_field('tag_manager_container_id','options') ?>');
</script>
<!-- End Google Tag Manager -->