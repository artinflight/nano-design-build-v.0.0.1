/**
 * Sets the hero section height to the exact window inner height to fix viewport unit issues.
 */
function setHeroHeight() {
    const heroSection = document.querySelector('.homepage-hero');
    if (heroSection) {
        heroSection.style.height = window.innerHeight + 'px';
    }
}

// Run on initial load and on window resize
window.addEventListener('load', setHeroHeight);
window.addEventListener('resize', setHeroHeight);