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
            <p>
                <!-- TODO: Replace with real contact details -->
                <a href="mailto:info@nanodesignbuild.com">info@nanodesignbuild.com</a><br>
                <span>Greater Toronto Area</span><br>
                <span>By appointment only</span>
            </p>
        </div>

        <!-- Featured Projects -->
        <div class="footer-column footer-column--projects">
            <h4 class="footer-heading">Featured Projects</h4>
            <ul class="footer-list">
                <?php
                $footer_projects = new WP_Query( [
                    'post_type'      => 'project',
                    'posts_per_page' => 2,
                    'post_status'    => 'publish',
                    'no_found_rows'  => true,
                ] );

                if ( $footer_projects->have_posts() ) :
                    while ( $footer_projects->have_posts() ) :
                        $footer_projects->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <li class="footer-list-empty">Coming soon.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Recognitions -->
        <div class="footer-column footer-column--recognitions">
            <h4 class="footer-heading">Recognitions</h4>
            <ul class="footer-list">
                <?php
                $footer_recognitions = new WP_Query( [
                    'post_type'      => 'journal', // front-facing label is "Recognitions"
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'no_found_rows'  => true,
                ] );

                if ( $footer_recognitions->have_posts() ) :
                    while ( $footer_recognitions->have_posts() ) :
                        $footer_recognitions->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <li class="footer-list-empty">Coming soon.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Footer nav -->
        <div class="footer-column footer-column--nav">
            <h4 class="footer-heading">Navigate</h4>
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'footer-menu',
                'fallback_cb'    => false,
            ] );
            ?>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
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
