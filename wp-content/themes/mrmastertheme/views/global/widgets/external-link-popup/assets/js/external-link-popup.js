(function () {
    // Paused: set to true to re-enable the external link popup
    var EXTERNAL_LINK_POPUP_ENABLED = true;
    if (!EXTERNAL_LINK_POPUP_ENABLED) return;

    initializeExternalLinkPopup();
})();

function initializeExternalLinkPopup() {
    // Build the popup HTML and inject it once into the DOM
    var overlay = document.createElement('div');
    overlay.id = 'external-link-popup';
    overlay.setAttribute('aria-hidden', 'true');
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.setAttribute('aria-label', 'External link warning');

    overlay.innerHTML =
        '<div class="external-link-popup__content">' +
        '<p class="external-link-popup__title">' + (location.hostname.indexOf('www.') === 0 ? '' : 'www.') + location.hostname + ' says</p>' +
        '<p class="external-link-popup__body">' +
        'You are now leaving MidSouth Community Federal Credit Union\u2019s website. ' +
        'MidSouth Community FCU does not provide, and is not responsible for, the product, ' +
        'service, overall website content, security, or privacy policies on any external ' +
        'third-party sites. MidSouth Community FCU\u2019s privacy policy does not apply to ' +
        'the linked site. Please consult the site\u2019s policies for further information.' +
        '</p>' +
        '<div class="external-link-popup__actions">' +
        '<button type="button" class="external-link-popup__ok">OK</button>' +
        '</div>' +
        '</div>';

    document.body.appendChild(overlay);

    // Cache references
    var popup = document.getElementById('external-link-popup');
    var okButton = popup.querySelector('.external-link-popup__ok');
    var pendingUrl = null;

    // Determine if a URL is external
    function isExternalLink(anchor) {
        // Must have an href and be a real link
        if (!anchor.href || anchor.href === '#' || anchor.href.indexOf('mailto:') === 0 || anchor.href.indexOf('tel:') === 0) {
            return false;
        }

        // Skip links that open popups (magnific, etc.)
        if (anchor.classList.contains('popup-video')) {
            return false;
        }

        // Skip excluded external URLs (e.g. online banking, Growth by Design)
        if (anchor.href.indexOf('onlinebanking.midsouthfcu.org/Authentication') !== -1 ||
            anchor.href.indexOf('growthbydesign.org') !== -1 ||
            anchor.href.indexOf('join.midsouthfcu.org') !== -1) {
            return false;
        }

        // Compare hostnames
        try {
            var linkHost = new URL(anchor.href).hostname;
            return linkHost !== '' && linkHost !== location.hostname;
        } catch (e) {
            return false;
        }
    }

    function openPopup(url) {
        pendingUrl = url;
        popup.setAttribute('aria-hidden', 'false');
        document.body.classList.add('external-link-popup-open');
        okButton.focus();
    }

    function closePopup() {
        popup.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('external-link-popup-open');

        if (pendingUrl) {
            window.open(pendingUrl, '_blank', 'noopener,noreferrer');
            pendingUrl = null;
        }
    }

    // Intercept clicks on external links (delegation on document)
    document.addEventListener('click', function (e) {
        // Walk up from the click target to find the nearest <a>
        var anchor = e.target.closest('a');
        if (!anchor) return;
        if (!isExternalLink(anchor)) return;

        e.preventDefault();
        openPopup(anchor.href);
    });

    // OK button closes the popup and opens the link
    okButton.addEventListener('click', function () {
        closePopup();
    });

    // Click on overlay background closes without navigating
    popup.addEventListener('click', function (e) {
        if (e.target === popup) {
            pendingUrl = null;
            popup.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('external-link-popup-open');
        }
    });

    // ESC key closes without navigating
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && popup.getAttribute('aria-hidden') === 'false') {
            pendingUrl = null;
            popup.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('external-link-popup-open');
        }
    });
}
