/**
 * File: navigation.js
 *
 * Handles the mobile menu toggle, focus trapping, and ESC key closing.
 */
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const siteNav = document.querySelector('.site-navigation');

    if (!menuToggle || !siteNav) {
        return;
    }

    menuToggle.addEventListener('click', function () {
        siteNav.classList.toggle('is-open');
        menuToggle.classList.toggle('is-active');
        menuToggle.setAttribute('aria-expanded', siteNav.classList.contains('is-open'));

        if (siteNav.classList.contains('is-open')) {
            trapFocus(siteNav);
        }
    });

    // Close menu on ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && siteNav.classList.contains('is-open')) {
            siteNav.classList.remove('is-open');
            menuToggle.classList.remove('is-active');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.focus();
        }
    });

    function trapFocus(element) {
        const focusableEls = element.querySelectorAll('a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])');
        const firstFocusableEl = focusableEls[0];
        const lastFocusableEl = focusableEls[focusableEls.length - 1];
        const KEYCODE_TAB = 9;

        element.addEventListener('keydown', function (e) {
            const isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

            if (!isTabPressed) {
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
    }
});
