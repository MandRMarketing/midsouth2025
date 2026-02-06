document.addEventListener('DOMContentLoaded', function () {
    const toggleSections = document.querySelectorAll('.toggles');
    if (!toggleSections || toggleSections.length === 0) return;

    toggleSections.forEach((section) => {
        // Check if this module has tabbed sections
        const sectionPanels = section.querySelectorAll('.toggles__section');
        if (sectionPanels.length > 1) {
            initTabbedSections(section, sectionPanels);
        }

        if (section.classList.contains('numbered-list')) {
            initNumberedListSection(section);
        } else {
            initStandardSection(section);
        }
    });

    // --- Tabbed sections ---
    function initTabbedSections(module, panels) {
        // Build tab bar from section titles
        var tabBar = document.createElement('div');
        tabBar.className = 'toggles__tabs container';

        var tabList = document.createElement('ul');
        tabList.className = 'toggles__tab-list';
        tabList.setAttribute('role', 'tablist');

        panels.forEach(function (panel, index) {
            var heading = panel.querySelector('.intro-content-row h2');
            var title = heading ? heading.textContent.trim() : 'Section ' + (index + 1);

            // Create tab button
            var li = document.createElement('li');
            li.className = 'toggles__tab';
            li.setAttribute('role', 'presentation');

            var btn = document.createElement('button');
            btn.className = 'toggles__tab-button';
            btn.setAttribute('type', 'button');
            btn.setAttribute('role', 'tab');
            btn.setAttribute('aria-selected', index === 0 ? 'true' : 'false');
            btn.textContent = title;

            li.appendChild(btn);
            tabList.appendChild(li);

            // Set panel role and visibility
            panel.setAttribute('role', 'tabpanel');
            if (index === 0) {
                panel.classList.add('toggles__section--active');
                panel.style.display = '';
            } else {
                panel.classList.remove('toggles__section--active');
                panel.style.display = 'none';
            }
        });

        tabBar.appendChild(tabList);

        // Insert tab bar before the first section
        var firstSection = panels[0];
        firstSection.parentNode.insertBefore(tabBar, firstSection);

        // Also add container-settings span for width
        var existingContainerSettings = module.querySelector('.toggles__section .container-settings');
        if (existingContainerSettings) {
            var containerWidth = existingContainerSettings.getAttribute('data-container-width');
            var settingsSpan = document.createElement('span');
            settingsSpan.className = 'container-settings';
            settingsSpan.setAttribute('data-container-width', containerWidth || 'standard');
            settingsSpan.innerHTML = '<span class="validator-text" data-nosnippet>settings</span>';
            tabBar.appendChild(settingsSpan);
        }

        // Tab click handler
        var tabButtons = tabList.querySelectorAll('.toggles__tab-button');
        tabButtons.forEach(function (btn, btnIndex) {
            btn.addEventListener('click', function () {
                // Deactivate all
                tabButtons.forEach(function (b) {
                    b.setAttribute('aria-selected', 'false');
                    b.classList.remove('toggles__tab-button--active');
                });
                panels.forEach(function (p) {
                    p.classList.remove('toggles__section--active');
                    p.style.display = 'none';
                });

                // Activate clicked
                btn.setAttribute('aria-selected', 'true');
                btn.classList.add('toggles__tab-button--active');
                panels[btnIndex].classList.add('toggles__section--active');
                panels[btnIndex].style.display = '';
            });
        });

        // Mark first tab active
        if (tabButtons.length > 0) {
            tabButtons[0].classList.add('toggles__tab-button--active');
        }
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
