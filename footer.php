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
