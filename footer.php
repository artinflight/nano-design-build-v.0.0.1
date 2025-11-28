<footer class="site-footer">
    <div class="footer-inner">
        <!-- Brand / Logo -->
        <div class="footer-column footer-column--brand">
            <?php
            $logo_id  = get_theme_mod( 'custom_logo' );
            $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
            if ( $logo_url ) : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link">
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="footer-logo">
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-fallback">
                    <?php bloginfo( 'name' ); ?>
                </a>
            <?php endif; ?>

            <p class="footer-tagline">
                Modern residential design and build in the GTA.
            </p>
        </div>

        <!-- Contact info -->
        <div class="footer-column footer-column--contact">
            <h4 class="footer-heading">Contact</h4>
            <ul class="footer-contact">
                <li class="footer-contact__line">1670 Bayview Avenue, Suite 302, Toronto, ON, M4G 3C2</li>
                <li class="footer-contact__line">
                    <a href="tel:4164883350">T: 416-488-3350</a>
                </li>
                <li class="footer-contact__line">
                    <a href="mailto:info@nanodesignbuild.com">info@nanodesignbuild.com</a>
                </li>
            </ul>

            <div class="footer-social" aria-label="Social media">
                <!-- TODO: Replace placeholder links with live profiles -->
                <a class="footer-social__link" href="#" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4Zm0 2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7Zm5 2.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 0 1 12 7.5Zm0 2a2.5 2.5 0 1 0 2.5 2.5A2.5 2.5 0 0 0 12 9.5Zm5.25-2.75a.75.75 0 1 1-.75.75.75.75 0 0 1 .75-.75Z"/></svg>
                </a>
                <a class="footer-social__link" href="#" aria-label="LinkedIn">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.94 9.75V18H4.13V9.75h2.81ZM5.53 6a1.62 1.62 0 1 1 0 3.24 1.62 1.62 0 0 1 0-3.24ZM19.88 18h-2.8v-4.39c0-1.2-.43-1.98-1.52-1.98-.83 0-1.32.56-1.54 1.1-.08.2-.1.47-.1.74V18h-2.8s.04-7.53 0-8.25h2.8v1.17c.37-.57 1.03-1.38 2.51-1.38 1.83 0 3.23 1.2 3.23 3.77V18Z"/></svg>
                </a>
                <a class="footer-social__link" href="#" aria-label="Houzz">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 3v18l7-3.5V13l7 3.5V3L12 6.5V11L5 7.5V3Z"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>


<?php wp_footer(); ?>

<!-- Primary nav toggle (mobile) -->
<script>
(function () {
  // Mobile nav toggle + a11y
  var btn  = document.querySelector('.nav-toggle');
  var menu = document.querySelector('#primary-menu');
  if (btn && menu) {
    function setOpen(open) {
      menu.classList.toggle('is-open', !!open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    btn.addEventListener('click', function () { setOpen(!menu.classList.contains('is-open')); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
    document.addEventListener('click', function (e) {
      if (!menu.classList.contains('is-open')) return;
      if (!(menu.contains(e.target) || btn.contains(e.target))) setOpen(false);
    }, { passive: true });
  }

  // Hero-aware header: front/home only (supports your is-front helper)
  var isFront = document.body.classList.contains('is-front') || document.body.classList.contains('home');
  if (!isFront) return;

  var hero = document.querySelector('.hero-video-section');
  if (!hero) return;

  function updateState() {
    var rect = hero.getBoundingClientRect();
    var onHero = rect.bottom > 80;
    document.body.classList.toggle('home-hero', onHero);
    document.body.classList.toggle('home-below-hero', !onHero);
  }

  updateState();
  window.addEventListener('scroll', updateState, { passive: true });

  try {
    var obs = new IntersectionObserver(function () { updateState(); }, {
      root: null, rootMargin: '-80px 0px 0px 0px', threshold: [0, 1]
    });
    obs.observe(hero);
  } catch (e) { /* scroll fallback already active */ }
})();
</script>

</body>
</html>
