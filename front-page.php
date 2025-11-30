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

<!-- ===== Home — Studio Overview (magazine layout) ===== -->
<section class="home-overview" aria-label="About Nano Design Build">
  <div class="home-ov__wrap">

    <!-- About -->
    <section class="home-ov__about">
      <p class="lede">
        Nano Design Build is a Toronto design–build studio focused on modern single-family homes.
        We handle everything from schematic design and approvals to construction management,
        delivering refined, light-filled spaces with lasting detail and craft.
      </p>
    </section>

    <!-- Notes & Press -->
    <section class="home-ov__press" aria-labelledby="press-title">
      <ul class="press-list">
        <li><strong>The Globe and Mail</strong>: Two projects profiled; “Home of the Week.”</li>
        <li><strong>Canada Green Building Council</strong>: Membership.</li>
        <li><strong>Tarion</strong>: Licensed new-home builder.</li>
        <li><strong>Founded</strong>: Studio established in Toronto.</li>
      </ul>
    </section>

    <!-- Credentials / logo roll -->
    <section class="home-ov__credentials" aria-labelledby="credentials-title">

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
        'posts_per_page' => 2,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $recent_projects = new WP_Query( $args );
    ?>

    <?php if ( $recent_projects->have_posts() ) : ?>
        <h2 class="section-title">Featured Projects</h2>
        <div class="project-archive-list">
            <?php while ( $recent_projects->have_posts() ) : $recent_projects->the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('project-archive-item'); ?>>
                    <a href="<?php the_permalink(); ?>" class="project-archive-link">
                        <div class="project-archive-image">
                            <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); endif; ?>
                        </div>
                        <div class="project-archive-details">
                            <h2 class="project-title"><?php the_title(); ?></h2>
                            <!--<div class="project-excerpt"><?php the_excerpt(); ?></div>-->
                            <div class="project-location-tag">
                                <?php
                                  $locations = get_the_terms( get_the_ID(), 'location' );
                                  if ( ! empty( $locations ) ) echo esc_html( $locations[0]->name );
                                ?>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <div class="section-link">
            <a href="<?php echo get_post_type_archive_link('project'); ?>">View Featured Projects</a>
        </div>
    <?php endif; ?>
</div>

<style>
/* ===== Home Overview (clean) ===== */

/* Shell */
.home-overview{ padding: clamp(28px,6vw,56px) 0; background:#fff; }
.home-ov__wrap{
  --g: 24px;
  max-width: 1200px; margin: 0 auto; padding: 0 24px;
  display: grid; grid-template-columns: repeat(12, minmax(0,1fr)); gap: var(--g);
}

/* Type */
.home-overview .eyebrow{
  font-size:12px; letter-spacing:.14em; text-transform:uppercase;
  opacity:.65; margin:0 0 8px;
}
.home-overview .lede{
  font-size: clamp(18px,2.2vw,22px); line-height:1.65; color:#333;
}

/* Columns */
.home-ov__about{ grid-column: 1 / -1; }
.home-ov__about .lede{
  max-width:none;
  width:100%;
  display:block;
  box-sizing:border-box;
  padding: clamp(18px,3vw,32px);
  border-radius: 18px;
  border: 1px solid #ebebeb;
  background: linear-gradient(135deg, rgba(0,0,0,0.04), rgba(0,0,0,0.02));
  box-shadow: 0 15px 40px rgba(0,0,0,.05);
}

/* Notes & Press */
.home-ov__press{ grid-column: 1 / -1; padding-top: clamp(12px,2vw,18px); margin-top: clamp(22px,3.5vw,40px); }
.home-ov__press .press-list{
  list-style:none; margin:0; padding:0;
  column-count:2; column-gap: calc(var(--g) * 1.25);
}
.home-ov__press .press-list li{
  break-inside:avoid; margin:0 0 10px 0; padding-left:18px; position:relative; color:#333; line-height:1.55;
}
.home-ov__press .press-list li::before{
  content:""; width:6px; height:6px; border-radius:50%;
  background:#111; position:absolute; left:0; top:.65em;
}
.home-ov__press .press-list strong{ color:#111; }

/* Credentials — logo roll */
.home-ov__credentials{ grid-column: 1 / -1; margin-top: clamp(16px,2.5vw,28px); }
.logo-roll{
  display:grid; grid-template-columns: repeat(3, minmax(120px,1fr));
  gap:24px; align-items:center; margin:0; padding:0; list-style:none;
}
.logo-roll li{ display:flex; align-items:center; justify-content:center; }
.logo-roll figure{
  display:flex; align-items:center; justify-content:center;
  min-height:32px;
  overflow:hidden;
}
.logo-roll img{
  height:32px;
  width:auto;
  display:block;
  filter: grayscale(100%);
  opacity:.75;
  transform: scale(1);
  transition: transform .25s ease, filter .25s ease, opacity .25s ease;
}
.logo-roll img:hover,
.logo-roll img:focus-visible{
  filter: none;
  opacity:1;
  transform: scale(1.06);
}

/* Per-logo tuning */
.logo-roll img[src*="cagbc.svg"]{
  /* CAGBC art is very light; invert+darken to match */
  filter: invert(1) grayscale(1) contrast(1.2) brightness(0.30);
  opacity:1;
}

.logo-roll img[src*="globe-and-mail.svg"]{
  /* Keep Globe & Mail original */
  filter:none; opacity:1;
}

/* Responsive stack */
@media (max-width: 1000px){
  .home-ov__about{ grid-column: 1 / -1; }
}
@media (max-width: 640px){
  .logo-roll{
    grid-template-columns: 1fr;
    gap: 18px;
  }
  .logo-roll li,
  .logo-roll figure{
    justify-content: center;
  }
  .logo-roll li{ padding: 10px 0; }
  .logo-roll figure{ min-height:26px; }
  .logo-roll img{ height:26px; }
}

/* A11y helper */
.sr-only{
  position:absolute!important; width:1px; height:1px; padding:0; margin:-1px;
  overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
}

/* More breathing room between Notes & Press and Credentials */
.home-ov__press{
  margin-bottom: clamp(18px, 3.5vw, 42px);
}
.home-ov__credentials{
  margin-top: clamp(26px, 4vw, 56px);   /* was smaller */
}

</style>



<?php get_footer(); ?>
