/**
 * File: mobile-menu.js
 *
 * Description: Handles the mobile navigation menu, including toggling visibility,
 * trapping focus within the menu, and closing it with the Escape key.
 */
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const primaryNav = document.querySelector('.primary-nav');

    if (!menuToggle || !primaryNav) {
        return;
    }

    // Toggle menu visibility
    menuToggle.addEventListener('click', function () {
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !isExpanded);
        primaryNav.classList.toggle('is-open');
        document.body.classList.toggle('no-scroll');
        
        if (!isExpanded) {
            trapFocus(primaryNav);
        }
    });

    // Focus trap logic
    function trapFocus(element) {
        const focusableEls = element.querySelectorAll('a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])');
        const firstFocusableEl = focusableEls[0];
        const lastFocusableEl = focusableEls[focusableEls.length - 1];
        const KEYCODE_TAB = 9;

        element.addEventListener('keydown', function (e) {
            if (e.key !== 'Tab' && e.keyCode !== KEYCODE_TAB) {
                return;
            }

            if (e.shiftKey) /* shift + tab */ {
                if (document.activeElement === firstFocusableEl) {
                    lastFocusableEl.focus();
                    e.preventDefault();
                }
            } else /* tab */ {
                if (document.activeElement === lastFocusableEl) {
                    firstFocusableEl.focus();
                    e.preventDefault();
                }
            }
        });
        
        firstFocusableEl.focus();
    }

    // Close menu on ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && primaryNav.classList.contains('is-open')) {
            menuToggle.click();
            menuToggle.focus();
        }
    });
});
