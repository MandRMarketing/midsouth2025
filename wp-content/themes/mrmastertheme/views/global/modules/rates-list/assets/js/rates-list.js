(function () {
    'use strict';

    var modules = document.querySelectorAll('.rates-list .rates-container');

    function animateValue(el, start, end, duration) {
        var startTime = null;

        function step(timestamp) {
            if (startTime === null) startTime = timestamp;
            var elapsed = timestamp - startTime;
            var progress = Math.min(elapsed / duration, 1);
            var easeOut = 1 - Math.pow(1 - progress, 2);
            var current = start + (end - start) * easeOut;
            el.textContent = current.toFixed(2) + '%';
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.textContent = end.toFixed(2) + '%';
            }
        }

        window.requestAnimationFrame(step);
    }

    function runAnimation(container) {
        var numbers = container.querySelectorAll('.rate-number[data-rate-value]');
        var duration = 1200;
        var stagger = 80;
        numbers.forEach(function (el, i) {
            var target = parseFloat(el.getAttribute('data-rate-value'), 10);
            if (isNaN(target)) return;
            el.textContent = '0.00%';
            setTimeout(function () {
                animateValue(el, 0, target, duration);
            }, i * stagger);
        });
    }

    function initModule(container) {
        if (container.hasAttribute('data-rates-animated')) return;

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    var box = entry.target;
                    if (box.hasAttribute('data-rates-animated')) return;
                    box.setAttribute('data-rates-animated', 'true');
                    runAnimation(box);
                });
            },
            { rootMargin: '0px 0px -50px 0px', threshold: 0 }
        );

        observer.observe(container);
    }

    modules.forEach(initModule);
})();
