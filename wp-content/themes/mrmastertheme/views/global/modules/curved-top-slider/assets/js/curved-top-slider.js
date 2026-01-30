(function () {
    'use strict';

    var sliders = document.querySelectorAll('[data-curved-top-slider]');

    function switchToSlide(container, index) {
        index = parseInt(index, 10);
        var panes = container.querySelectorAll('.curved-top-slider__pane');
        var titles = container.querySelectorAll('.curved-top-slider__title');
        var segments = container.querySelectorAll('.curved-top-slider__progress-segment');
        var count = panes.length;

        if (index < 0 || index >= count) return;

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
        panes.forEach(function (pane, i) {
            pane.hidden = i !== 0;
        });
        panesWrapper.style.height = max + 'px';
    }

    function initSlider(container) {
        setPanesHeight(container);
        var titles = container.querySelectorAll('.curved-top-slider__title');
        titles.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var index = this.getAttribute('data-index');
                switchToSlide(container, index);
            });
        });
        window.addEventListener('resize', function () {
            setPanesHeight(container);
        });
    }

    sliders.forEach(initSlider);
})();
