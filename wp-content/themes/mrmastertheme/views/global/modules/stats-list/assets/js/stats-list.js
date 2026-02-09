(function () {
    'use strict';

    var containers = document.querySelectorAll('.stats-list .stats-container');
    if (!containers.length) return;

    function animateValue(el, end, duration, pretextEl) {
        // Determine formatting from the data attribute value
        var isDecimal = String(end) !== String(Math.floor(end));
        var decimalPlaces = 0;

        if (isDecimal) {
            var parts = String(end).split('.');
            decimalPlaces = parts[1] ? parts[1].length : 0;
        }

        var startTime = null;

        function formatNumber(value) {
            var formatted = isDecimal ? value.toFixed(decimalPlaces) : Math.round(value).toString();

            // Add commas for thousands
            var numParts = formatted.split('.');
            numParts[0] = numParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            formatted = numParts.join('.');

            return formatted;
        }

        function step(timestamp) {
            if (startTime === null) startTime = timestamp;
            var elapsed = timestamp - startTime;
            var progress = Math.min(elapsed / duration, 1);
            // Ease out quad
            var easeOut = 1 - Math.pow(1 - progress, 2);
            var current = end * easeOut;

            // Only update the text node, preserve any child elements (like .stat-pretext)
            setNumberText(el, formatNumber(current), pretextEl);

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                setNumberText(el, formatNumber(end), pretextEl);
            }
        }

        window.requestAnimationFrame(step);
    }

    // Set only the number text while preserving child elements
    function setNumberText(el, text, pretextEl) {
        // Clear element
        el.textContent = '';
        // Re-add pretext if it exists
        if (pretextEl) {
            el.appendChild(pretextEl);
        }
        // Add number text node
        el.appendChild(document.createTextNode(text));
    }

    function runAnimation(container) {
        var numbers = container.querySelectorAll('.stat-number[data-stat-value]');
        var duration = 1500;
        var stagger = 100;

        numbers.forEach(function (el, i) {
            var target = parseFloat(el.getAttribute('data-stat-value'));
            if (isNaN(target)) return;

            // Preserve the pretext child element before clearing
            var pretextEl = el.querySelector('.stat-pretext');
            if (pretextEl) {
                pretextEl = pretextEl.cloneNode(true);
            }

            // Start at 0
            setNumberText(el, '0', pretextEl);

            setTimeout(function () {
                animateValue(el, target, duration, pretextEl);
            }, i * stagger);
        });
    }

    function initModule(container) {
        if (container.hasAttribute('data-stats-animated')) return;

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    if (entry.target.hasAttribute('data-stats-animated')) return;
                    entry.target.setAttribute('data-stats-animated', 'true');
                    runAnimation(entry.target);
                });
            },
            { rootMargin: '0px 0px -50px 0px', threshold: 0 }
        );

        observer.observe(container);
    }

    containers.forEach(initModule);
})();
