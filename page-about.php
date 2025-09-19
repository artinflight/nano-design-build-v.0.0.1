<?php
/**
 * Template Name: About (Magazine)
 */
get_header();

/**
 * Image handles (swap these to your real uploads URLs).
 * Use ~1920×1080 for $hero, ~1200×800 for others.
 */
$hero    = '/wp-content/uploads/2025/07/210802-Nano-LinearHouse.jpg';
$iA      = '/wp-content/uploads/2025/07/63LangleyAve-web-1.jpg';
$iB      = '/wp-content/uploads/2025/07/210916-NANOGREENDOT-252GledhillAve-NW10-M2P-021-HDR-Edit-web-004.jpg';
$iC      = '/wp-content/uploads/2025/07/210802-Nano-LinearHouse-1024x576.jpg';

// Optional: pull the page content (your text) from the editor.
the_post();
?>

<main id="primary" class="about-page">
  <!-- Hero -->
  <section class="about-hero">
    <figure class="about-hero-media">
      <img src="<?php echo esc_url( $hero ); ?>" alt="Studio work by Nano Design Build" loading="eager" fetchpriority="high">
    </figure>
    <div class="about-hero-copy">
      <h1>About Nano Design Build Inc.</h1>
      <p class="kicker">Founded in 2005 • Toronto, Canada</p>
      <p class="lede">We create tailored, light-driven homes with a rigorous, end-to-end approach—design and build, unified.</p>
    </div>
  </section>

  <!-- Intro (your existing text) -->
  <section class="about-body prose">
    <?php
      // Your text from the message goes into the page editor. If you prefer fixed copy, replace the_content() with your HTML.
      the_content();
    ?>
  </section>

  <!-- Process (alternating rows) -->
  <section class="about-process">
    <article class="ap-row">
      <div class="ap-text">
        <h2>Schematic Design</h2>
        <p>Concept exploration, clear constraints, digital 3D studies, and early feasibility. We iterate quickly and visually.</p>
      </div>
      <figure class="ap-media"><img src="<?php echo esc_url( $iA ); ?>" alt=""></figure>
    </article>

    <article class="ap-row reverse">
      <div class="ap-text">
        <h2>Design Development</h2>
        <p>Materials, details, and coordination with structural, mechanical, and electrical consultants—so construction is decisive, not improvised.</p>
      </div>
      <figure class="ap-media"><img src="<?php echo esc_url( $iB ); ?>" alt=""></figure>
    </article>

    <article class="ap-row">
      <div class="ap-text">
        <h2>Approvals & Delivery</h2>
        <p>Municipal approvals, cost clarity, scheduling, contractor selection, and daily construction management with a quality standard that lasts.</p>
      </div>
      <figure class="ap-media"><img src="<?php echo esc_url( $iC ); ?>" alt=""></figure>
    </article>
  </section>

  <!-- Quiet stats band -->
  <section class="about-stats">
    <ul class="stats">
      <li><span class="n">2005</span><span class="l">Founded</span></li>
      <li><span class="n">100+ </span><span class="l">Projects</span></li>
      <li><span class="n">Canada</span><span class="l">National Practice</span></li>
    </ul>
  </section>

  <!-- Partners -->
  <section class="about-partners">
    <h2 class="sec-title">Our Partners</h2>

    <div class="partners-grid">
      <!-- Partner: Titka -->
      <article class="partner">
        <figure class="partner-photo">
          <img src="/wp-content/uploads/2025/07/placeholder-headshot-portrait.jpg" alt="Portrait of Titka Safarzadeh" />
        </figure>
        <div class="partner-body">
          <h3 class="partner-name">Titka Safarzadeh</h3>
          <p class="partner-cred">M.Arch, MRAIC, LEED GA</p>
          <p>A dedicated partner since 1998, Titka holds a Master's Degree in Architecture and has been an active member of the Royal Architectural Institute of Canada since 2006. With over 13 years of experience in Canada and abroad, she has developed an extensive expertise in <strong>design development</strong>, <strong>detailing</strong>, and <strong>construction documentation</strong>. Titka is known for her high standards of architectural design and her ability to deliver projects on time and within budget. She builds strong, lasting relationships with clients by consistently putting their needs first.</p>
          <p class="partner-contact">Email: <a href="mailto:titka@nanodesignbuild.com">titka@nanodesignbuild.com</a></p>
        </div>
      </article>

      <!-- Partner: Saied -->
      <article class="partner">
        <figure class="partner-photo">
          <img src="/wp-content/uploads/2025/07/placeholder-headshot-portrait.jpg" alt="Portrait of Saied Mahboubi" />
        </figure>
        <div class="partner-body">
          <h3 class="partner-name">Saied Mahboubi</h3>
          <p class="partner-cred">M.Arch, MRAIC</p>
          <p>Saied graduated with a Master's Degree in Architecture in 1994 and has been an active member of the Royal Architectural Institute of Canada since 2006. With over 17 years of experience in design and construction both in Canada and overseas, he has worked on a diverse range of large-scale projects, including <strong>industrial</strong>, <strong>commercial</strong>, and <strong>residential</strong> designs. Inspired by his passion for art and meticulous attention to detail, Saied balances form and function. His expertise in <strong>project management</strong> ensures budget control, scheduling, and seamless coordination among trades, clients, and consultants.</p>
          <p class="partner-contact">Email: <a href="mailto:saied@nanodesignbuild.com">saied@nanodesignbuild.com</a></p>
        </div>
      </article>
    </div>
  </section>


  <!-- Image collage -->
  <section class="about-collage">
    <figure><img src="<?php echo esc_url( $iA ); ?>" alt=""></figure>
    <figure><img src="<?php echo esc_url( $iB ); ?>" alt=""></figure>
    <figure><img src="<?php echo esc_url( $iC ); ?>" alt=""></figure>
  </section>
</main>

<?php get_footer(); ?>
