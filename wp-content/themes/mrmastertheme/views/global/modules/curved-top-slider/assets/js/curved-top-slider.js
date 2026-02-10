(function () {
    'use strict';

    var sliders = document.querySelectorAll('[data-curved-top-slider]');
    var AUTOPLAY_INTERVAL_MS = 5000;

    function switchToSlide(container, index) {
        index = parseInt(index, 10);
        var panes = container.querySelectorAll('.curved-top-slider__pane');
        var titles = container.querySelectorAll('.curved-top-slider__title');
        var segments = container.querySelectorAll('.curved-top-slider__progress-segment');
        var mobileTitle = container.querySelector('.curved-top-slider__mobile-title');
        var count = panes.length;

        if (index < 0 || index >= count) return;

        container.setAttribute('data-current-index', index);

        panes.forEach(function (pane, i) {
            var isActive = i === index;
            pane.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            if (pane.hidden !== !isActive) pane.hidden = !isActive;
        });

        titles.forEach(function (title, i) {
            var isActive = i === index;
            title.classList.toggle('is-active', isActive);
            title.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        if (segments) {
            segments.forEach(function (seg, i) {
                seg.classList.toggle('is-active', i === index);
            });
        }

        // Update mobile title text
        if (mobileTitle && titles.length > index) {
            mobileTitle.textContent = titles[index].textContent.trim();
        }
    }

    function setPanesHeight(container) {
        var panesWrapper = container.querySelector('.curved-top-slider__panes');
        var panes = container.querySelectorAll('.curved-top-slider__pane');
        if (!panesWrapper || !panes.length) return;
        var max = 0;
        panes.forEach(function (pane) {
            pane.hidden = false;
            var h = pane.offsetHeight;
            if (h > max) max = h;
            pane.hidden = true;
        });
        var currentIndex = parseInt(container.getAttribute('data-current-index') || '0', 10);
        panes.forEach(function (pane, i) {
            pane.hidden = i !== currentIndex;
        });
        panesWrapper.style.height = max + 'px';
    }

    function initSlider(container) {
        container.setAttribute('data-current-index', '0');
        setPanesHeight(container);

        var titles = container.querySelectorAll('.curved-top-slider__title');
        var panes = container.querySelectorAll('.curved-top-slider__pane');
        var count = panes.length;
        var autoplayTimer = null;

        function startAutoplay() {
            stopAutoplay();
            if (count <= 1) return;
            autoplayTimer = setInterval(function () {
                var current = parseInt(container.getAttribute('data-current-index') || '0', 10);
                var next = (current + 1) % count;
                switchToSlide(container, next);
            }, AUTOPLAY_INTERVAL_MS);
        }

        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }

        function onUserChange() {
            stopAutoplay();
            startAutoplay();
        }

        // Title button clicks
        titles.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var index = this.getAttribute('data-index');
                switchToSlide(container, index);
                onUserChange();
            });
        });

        // Arrow clicks
        var arrows = container.querySelectorAll('.curved-top-slider__arrow');
        arrows.forEach(function (arrow) {
            arrow.addEventListener('click', function () {
                var current = parseInt(container.getAttribute('data-current-index') || '0', 10);
                var dir = this.getAttribute('data-dir');
                var next;

                if (dir === 'next') {
                    next = (current + 1) % count;
                } else {
                    next = (current - 1 + count) % count;
                }

                switchToSlide(container, next);
                onUserChange();
            });
        });

        startAutoplay();

        window.addEventListener('resize', function () {
            setPanesHeight(container);
        });
    }

    sliders.forEach(initSlider);
})();
