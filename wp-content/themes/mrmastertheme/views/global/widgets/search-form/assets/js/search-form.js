(function () {
    'use strict';

    var wrappers = document.querySelectorAll('.search-toggle-wrapper');
    if (!wrappers.length) return;

    wrappers.forEach(function (wrapper) {
        var toggle = wrapper.querySelector('.search-toggle');
        var input = wrapper.querySelector('.search-string input');
        if (!toggle) return;

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            var isOpen = wrapper.classList.contains('search-open');

            if (isOpen) {
                wrapper.classList.remove('search-open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Open search');
            } else {
                wrapper.classList.add('search-open');
                toggle.setAttribute('aria-expanded', 'true');
                toggle.setAttribute('aria-label', 'Close search');
                if (input) {
                    input.focus();
                }
            }
        });

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target) && wrapper.classList.contains('search-open')) {
                wrapper.classList.remove('search-open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Open search');
            }
        });
    });
})();
