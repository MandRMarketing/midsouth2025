(function () {
    'use strict';

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
