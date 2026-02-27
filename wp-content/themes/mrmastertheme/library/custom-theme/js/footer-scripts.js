(function () {
    'use strict';

    // Open external links in new tab
    function initExternalLinksNewTab() {
        var hostname = location.hostname;
        var links = document.querySelectorAll('a[href]');

        links.forEach(function (anchor) {
            var href = anchor.getAttribute('href');
            if (!href || href === '#' || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return;
            if (anchor.hasAttribute('target')) return; // Respect existing target

            try {
                var url = new URL(anchor.href);
                var linkHost = url.hostname;
                var isExternal = linkHost && linkHost !== hostname;
                var isPdf = /\.pdf$/i.test(url.pathname);
                if (isExternal || isPdf) {
                    anchor.setAttribute('target', '_blank');
                    anchor.setAttribute('rel', 'noopener noreferrer');
                }
            } catch (e) { /* invalid URL, skip */ }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initExternalLinksNewTab);
    } else {
        initExternalLinksNewTab();
    }

    // Same defaults as [loanpay-button] shortcode
    var LOANPAY_CLIENT_ID = '577ee0e3-c11b-405c-b046-ce8e9118f51b';
    var LOANPAY_URL = 'https://web.baconpay.com';

    document.addEventListener('click', function (e) {
        var link = e.target.closest('a[href="#loanpay"]');
        if (!link) return;

        e.preventDefault();

        if (typeof createBaconWebClient === 'function') {
            createBaconWebClient(LOANPAY_CLIENT_ID, LOANPAY_URL);
        }
    });
})();
