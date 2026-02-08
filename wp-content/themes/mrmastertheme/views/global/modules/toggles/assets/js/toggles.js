document.addEventListener('DOMContentLoaded', function () {
    var toggleSections = document.querySelectorAll('.toggles');
    if (!toggleSections || toggleSections.length === 0) return;

    toggleSections.forEach(function (section) {
        // Tab switching (tabs are rendered in PHP)
        initTabSwitching(section);

        // Toggle accordion behavior
        if (section.classList.contains('numbered-list')) {
            initNumberedListSection(section);
        } else {
            initStandardSection(section);
        }
    });

    // --- Tab switching (PHP-rendered tabs) ---
    function initTabSwitching(module) {
        var tabButtons = module.querySelectorAll('.toggles__tab-button');
        var panels = module.querySelectorAll('.toggles__section');
        if (tabButtons.length < 2 || panels.length < 2) return;

        tabButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var targetIndex = btn.getAttribute('data-tab-index');

                // Deactivate all tabs
                tabButtons.forEach(function (b) {
                    b.setAttribute('aria-selected', 'false');
                    b.classList.remove('toggles__tab-button--active');
                });

                // Deactivate all panels
                panels.forEach(function (p) {
                    p.classList.remove('toggles__section--active');
                });

                // Activate clicked tab and matching panel
                btn.setAttribute('aria-selected', 'true');
                btn.classList.add('toggles__tab-button--active');

                var targetPanel = module.querySelector('.toggles__section[data-section-index="' + targetIndex + '"]');
                if (targetPanel) {
                    targetPanel.classList.add('toggles__section--active');
                }
            });
        });
    }

    // --- Utility ---
    function setToggleState(trigger, toggleBox, toggleElement, isOpen) {
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        toggleBox.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        toggleBox.style.display = isOpen ? 'block' : 'none';
        if (toggleElement) {
            toggleElement.classList.toggle('active', isOpen);
        }
    }

    // --- Standard toggles (accordion) ---
    function initStandardSection(section) {
        var toggles = section.querySelectorAll('.toggle');
        if (!toggles || toggles.length === 0) return;

        function toggleBehavior(e) {
            e.preventDefault();
            var trigger = e.target.closest('.toggle__trigger');
            if (!trigger || !section.contains(trigger)) return;

            var toggleElement = trigger.closest('.toggle');
            var toggleBox = trigger.nextElementSibling;
            if (!toggleBox) return;

            var isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            setToggleState(trigger, toggleBox, toggleElement, !isExpanded);
        }

        toggles.forEach(function (toggle) {
            var trigger = toggle.querySelector('.toggle__trigger');
            var toggleBox = toggle.querySelector('.toggle__box');
            if (!trigger || !toggleBox) return;

            if (toggleBox.getAttribute('aria-hidden') !== 'false') {
                toggleBox.style.display = 'none';
            }

            trigger.addEventListener('click', toggleBehavior);
        });
    }

    // --- Numbered list section ---
    function initNumberedListSection(section) {
        var mq = window.matchMedia('(max-width: 769px)');

        function applyLayout() {
            var toggles = section.querySelectorAll('.toggle');
            if (!toggles || toggles.length === 0) return;

            if (mq.matches) {
                toggles.forEach(function (toggle) {
                    var trigger = toggle.querySelector('.toggle__trigger');
                    var toggleBox = toggle.querySelector('.toggle__box');
                    if (!trigger || !toggleBox) return;

                    trigger.removeAttribute('aria-disabled');

                    var shouldBeOpen =
                        trigger.getAttribute('aria-expanded') === 'true' ||
                        toggleBox.getAttribute('aria-hidden') === 'false';

                    setToggleState(trigger, toggleBox, toggle, shouldBeOpen);
                });
            } else {
                toggles.forEach(function (toggle) {
                    var trigger = toggle.querySelector('.toggle__trigger');
                    var toggleBox = toggle.querySelector('.toggle__box');
                    if (!trigger || !toggleBox) return;

                    trigger.setAttribute('aria-disabled', 'true');
                    setToggleState(trigger, toggleBox, toggle, true);
                });
            }
        }

        function onClick(e) {
            if (!mq.matches) return;

            e.preventDefault();
            var trigger = e.target.closest('.toggle__trigger');
            if (!trigger || !section.contains(trigger)) return;

            var toggleElement = trigger.closest('.toggle');
            var toggleBox = trigger.nextElementSibling;
            if (!toggleBox) return;

            var isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            setToggleState(trigger, toggleBox, toggleElement, !isExpanded);
        }

        section.addEventListener('click', onClick);
        applyLayout();

        if (typeof mq.addEventListener === 'function') {
            mq.addEventListener('change', applyLayout);
        } else {
            mq.addListener(applyLayout);
        }
    }
});
