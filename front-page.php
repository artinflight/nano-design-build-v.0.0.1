<?php
/**
 * The template for displaying the custom homepage (Original Baseline).
 */

get_header(); ?>

<section class="hero-video-section">
    <?php
    $video_rel = '/wp-content/uploads/2025/07/250705-NanoGreenDot-NanoBackgroundVideo.mp4';
    $video_url = esc_url( home_url( $video_rel ) );
    ?>
    <video class="hero-video-bg" playsinline autoplay muted loop>
        <source src="<?php echo $video_url; ?>" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Designing & Building The Future</h1>
        <p class="hero-subtitle">We craft bespoke homes that merge timeless design with modern living.</p>
    </div>
</section>

<!-- ===== Home — Studio Overview (inserted between hero and Recent Work) ===== -->
<section class="home-overview" aria-label="About Nano Design Build">
  <div class="home-overview__wrap">

    <!-- Short intro -->
    <section class="home-overview__intro">
      <h2 class="eyebrow">About</h2>
      <p class="lede">
        Nano Design Build is a Toronto design–build studio focused on modern single-family homes.
        We handle everything from schematic design and approvals to construction management,
        delivering refined, light-filled spaces with lasting detail and craft.
      </p>
    </section>

    <!-- Press / timeline -->
    <section class="home-overview__press" aria-labelledby="press-title">
      <h2 id="press-title" class="eyebrow">Notes & Press</h2>
      <ul class="press-list">
        <li><strong>2013 — The Globe and Mail</strong>: Two projects profiled; “Home of the Week.”</li>
        <li><strong>2009 — Canada Green Building Council</strong>: Membership.</li>
        <li><strong>2006 — Tarion</strong>: Licensed new-home builder.</li>
        <li><strong>2005 — Founded</strong>: Studio established in Toronto.</li>
      </ul>
    </section>

    <!-- Services -->
    <section class="home-overview__services" aria-labelledby="services-title">
      <h2 id="services-title" class="eyebrow">Services</h2>
      <ul class="service-list">
        <li><strong>Design</strong> – Feasibility, schematic options, 3D visualization.</li>
        <li><strong>Approvals</strong> – Planning strategy, CoA applications, zoning and site plan.</li>
        <li><strong>Documentation</strong> – DD/permit sets, coordination with structural, M/E.</li>
        <li><strong>Build</strong> – Estimating, tendering, construction management, QA.</li>
        <li><strong>Aftercare</strong> – Closeout, warranties, and support.</li>
      </ul>
    </section>

    <!-- Credentials / logo roll -->
    <section class="home-overview__credentials" aria-labelledby="credentials-title">
      <h2 id="credentials-title" class="eyebrow">Credentials</h2>
      <p class="credentials-copy">
        Licensed by <strong>Tarion</strong> (New Home Warranty) since 2006.
        Member, <strong>Canada Green Building Council</strong>.
        Projects featured in <strong>The Globe and Mail</strong>.
      </p>

      <ul class="logo-roll" aria-label="Affiliations and features">
        <li>
          <figure>
            <img src="<?php echo esc_url( get_theme_file_uri('assets/logos/tarion.svg') ); ?>" alt="Tarion" loading="lazy" decoding="async">
            <figcaption class="sr-only">Tarion</figcaption>
          </figure>
        </li>
        <li>
          <figure>
            <img src="<?php echo esc_url( get_theme_file_uri('assets/logos/cagbc.svg') ); ?>" alt="Canada Green Building Council" loading="lazy" decoding="async">
            <figcaption class="sr-only">Canada Green Building Council</figcaption>
          </figure>
        </li>
        <li>
          <figure>
            <img src="<?php echo esc_url( get_theme_file_uri('assets/logos/globe-and-mail.svg') ); ?>" alt="The Globe and Mail" loading="lazy" decoding="async">
            <figcaption class="sr-only">The Globe and Mail</figcaption>
          </figure>
        </li>
      </ul>
    </section>

  </div>
</section>
<!-- ===== /Home — Studio Overview ===== -->


<div class="homepage-projects">
    <?php
    $args = array(
        'post_type'      => 'project',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $recent_projects = new WP_Query( $args );
    ?>

    <?php if ( $recent_projects->have_posts() ) : ?>
        <h2 class="section-title">Recent Work</h2>
        <div class="project-archive-list">
            <?php while ( $recent_projects->have_posts() ) : $recent_projects->the_post(); ?>
                
                <?php // We reuse the same structure from archive-project.php ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('project-archive-item'); ?>>
                    <a href="<?php the_permalink(); ?>" class="project-archive-link">
                        <div class="project-archive-image">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'large' ); ?>
                            <?php endif; ?>
                        </div>
                        <div class="project-archive-details">
                            <h2 class="project-title"><?php the_title(); ?></h2>
                            <div class="project-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="project-location-tag">
                                <?php
                                    $locations = get_the_terms( get_the_ID(), 'location' );
                                    if ( ! empty( $locations ) ) {
                                        echo esc_html( $locations[0]->name );
                                    }
                                ?>
                            </div>
                        </div>
                    </a>
                </article>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <div class="section-link">
			<img src="<?php echo get_template_directory_uri(); ?>/images/nano.svg" alt="Nano Design Build Logo" class="final-card-logo">
            <a href="<?php echo get_post_type_archive_link('project'); ?>">View All Projects</a>
        </div>
    <?php endif; ?>
</div>

<style>
/* ===== Scoped: Home Overview block ===== */
.home-overview { padding: clamp(28px, 6vw, 56px) 0; background: #fff; }
.home-overview__wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
.eyebrow { font-size: 12px; letter-spacing: .14em; text-transform: uppercase; opacity: .65; margin: 0 0 10px; }
.lede { font-size: clamp(18px, 2.2vw, 22px); line-height: 1.6; color: #333; max-width: 70ch; }

.home-overview__intro { margin-bottom: clamp(18px, 4vw, 34px); }
.home-overview__press, .home-overview__services { margin-bottom: clamp(18px, 4vw, 34px); }

.press-list, .service-list { margin: 0; padding-left: 1em; display: grid; gap: 8px; color: #333; }
.service-list strong, .press-list strong { color: #111; }

.home-overview__credentials .credentials-copy { margin: 0 0 12px; color: #333; }

/* Logo roll */
.logo-roll { display: grid; grid-template-columns: repeat(3, minmax(120px, 1fr)); gap: 16px; align-items: center; margin: 0; padding: 0; list-style: none; }
.logo-roll li { display: flex; align-items: center; justify-content: center; }
.logo-roll img { max-width: 160px; max-height: 44px; width: auto; height: auto; filter: grayscale(1) contrast(1.1); opacity: .9; }
.logo-roll img:hover { filter: none; opacity: 1; }

/* Layout at larger sizes: put intro + services side-by-side for a magazine feel */
@media (min-width: 980px) {
  .home-overview__wrap { display: grid; grid-template-columns: 1.6fr 1fr; gap: clamp(20px, 5vw, 48px); }
  .home-overview__intro { grid-column: 1; }
  .home-overview__services { grid-column: 2; align-self: start; }
  .home-overview__press { grid-column: 1 / -1; }
  .home-overview__credentials { grid-column: 1 / -1; }
}

/* Accessibility helpers */
.sr-only { position:absolute!important; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }
</style>


<?php get_footer(); ?>