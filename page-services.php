<?php
/**
 * Template Name: Services
 */

get_header();

the_post();
?>

<main id="primary" class="services-page">
  <section class="services-hero">
    <div class="services-hero__inner">
      <p class="services-hero__eyebrow">What we do</p>
      <h1 class="services-hero__title">Services</h1>
      <p class="services-hero__lede">We guide residential projects from the first sketch through move-in. Our team leads strategy, documentation, construction, and ongoing support so every detail of your home is cared for.</p>
    </div>
  </section>

  <?php
  $services = array(
    array(
      'slug'        => 'design',
      'title'       => 'Design',
      'tagline'     => 'Feasibility, schematic options, 3D visualization',
      'description' => 'Early collaboration starts with feasibility analysis to understand the potential of your lot, budget, and timeline. We translate those insights into schematic options and clear massing studies, producing immersive 3D visualization that helps you evaluate the design long before construction begins.',
      'highlights'  => array(
        'Feasibility reviews &amp; code checks',
        'Schematic options and early concepts',
        '3D visualization and walkthroughs',
      ),
    ),
    array(
      'slug'        => 'approvals',
      'title'       => 'Approvals',
      'tagline'     => 'Planning strategy, CoA applications, zoning and site plan',
      'description' => 'We lead the planning strategy, preparing comprehensive Committee of Adjustment applications that speak to local zoning review requirements. Our team coordinates the site plan process and works closely with municipal staff so approvals move forward with clarity and minimal surprises.',
      'highlights'  => array(
        'Planning strategy &amp; stakeholder preparation',
        'Committee of Adjustment submissions',
        'Zoning analysis &amp; site plan coordination',
      ),
    ),
    array(
      'slug'        => 'documentation',
      'title'       => 'Documentation',
      'tagline'     => 'DD/permit sets &amp; coordination with structural, M/E',
      'description' => 'Design development flows into detailed permit drawing sets with coordinated specifications. Structural, mechanical, and electrical consultants are integrated into our workflow, ensuring documentation is buildable, compliant, and ready for pricing.',
      'highlights'  => array(
        'Design development &amp; permit drawing sets',
        'Specification packages ready for pricing',
        'Coordination with structural, mechanical &amp; electrical teams',
      ),
    ),
    array(
      'slug'        => 'build',
      'title'       => 'Build',
      'tagline'     => 'Estimating, tendering, construction management, QA',
      'description' => 'We manage estimating and tendering, support contractor selection, and remain present during construction management. Regular site reviews and rigorous quality assurance keep the build aligned with intent, cost, and schedule.',
      'highlights'  => array(
        'Estimating and tendering support',
        'Contractor selection &amp; procurement',
        'Construction management &amp; quality assurance',
      ),
    ),
    array(
      'slug'        => 'aftercare',
      'title'       => 'Aftercare',
      'tagline'     => 'Closeout, warranties, and ongoing support',
      'description' => 'Closeout is handled with the same care as the first sketch. We compile as-built and closeout documents, coordinate warranties, and provide ongoing support so your home continues to perform beautifully long after move-in.',
      'highlights'  => array(
        'Project closeout &amp; as-built documentation',
        'Warranty coordination &amp; follow-ups',
        'Ongoing client support',
      ),
    ),
  );
  ?>

  <section class="services-stack" aria-label="Nano Design Build service offerings">
    <div class="services-stack__intro">
      <p>Every commission receives a full-service pathway—strategy, approvals, documentation, delivery, and care after move-in. The cards below mirror our project archive’s alternating rhythm so you can scan the studio’s capabilities at a glance.</p>
    </div>

    <div class="services-stack__list">
      <?php foreach ( $services as $index => $service ) :
        $position = $index + 1;
        $count    = str_pad( (string) $position, 2, '0', STR_PAD_LEFT );
        $is_even  = 0 === $index % 2;
        ?>
        <article id="service-<?php echo esc_attr( $service['slug'] ); ?>" class="services-stack__item <?php echo $is_even ? 'services-stack__item--even' : 'services-stack__item--odd'; ?>">
          <div class="services-stack__lede">
            <span class="services-stack__number" aria-hidden="true"><?php echo esc_html( $count ); ?></span>
            <div>
              <p class="services-stack__tag"><?php echo esc_html( $service['tagline'] ); ?></p>
              <h2><?php echo esc_html( $service['title'] ); ?></h2>
            </div>
          </div>

          <div class="services-stack__body">
            <p><?php echo esc_html( $service['description'] ); ?></p>
            <?php if ( ! empty( $service['highlights'] ) ) : ?>
              <ul class="services-stack__highlights">
                <?php foreach ( $service['highlights'] as $highlight ) : ?>
                  <li><?php echo wp_kses_post( $highlight ); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="services-cta" aria-label="Next steps">
    <div class="services-cta__inner">
      <h2>Ready to discuss your project?</h2>
      <p>Let’s talk about timelines, scope, and the vision for your home. Our team will outline the pathway from design through aftercare.</p>
      <a class="services-cta__link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Start a conversation</a>
    </div>
  </section>
</main>

<style>
.services-page{
  background:#fff;
  color:#111;
}

.services-hero{
  padding: clamp(72px, 18vw, 140px) 24px clamp(48px, 8vw, 96px);
  background: radial-gradient(circle at top left, rgba(255,255,255,0.08), rgba(255,255,255,0)) , linear-gradient(135deg, rgba(13,13,13,0.94), rgba(13,13,13,0.65));
  color:#f7f7f5;
}

.services-hero__inner{
  max-width: 960px;
  margin: 0 auto;
}

.services-hero__eyebrow{
  margin:0 0 12px;
  font-size:13px;
  letter-spacing:.18em;
  text-transform:uppercase;
  opacity:.65;
}

.services-hero__title{
  margin:0 0 18px;
  font-size: clamp(40px, 6vw, 68px);
  font-weight:500;
}

.services-hero__lede{
  margin:0;
  font-size: clamp(18px, 2.2vw, 22px);
  line-height:1.65;
  max-width: 60ch;
  color: rgba(247,247,245,0.85);
}

.services-stack{
  padding: clamp(48px, 10vw, 112px) clamp(18px, 5vw, 40px) clamp(64px, 14vw, 140px);
}

.services-stack__intro{
  max-width: 860px;
  margin: 0 auto clamp(48px, 7vw, 72px);
  font-size: clamp(18px, 2vw, 20px);
  line-height:1.7;
  text-align:center;
  color:#333;
}

.services-stack__list{
  max-width: 1200px;
  margin: 0 auto;
  border-top:1px solid rgba(0,0,0,0.08);
}

.services-stack__item{
  display:grid;
  grid-template-columns: repeat(12, minmax(0,1fr));
  gap: clamp(18px, 5vw, 40px);
  padding: clamp(32px, 5vw, 60px) 0;
  border-bottom:1px solid rgba(0,0,0,0.08);
  position:relative;
}

.services-stack__lede{
  grid-column: 1 / span 4;
  display:flex;
  gap:18px;
  align-items:flex-start;
}

.services-stack__number{
  font-size: clamp(34px, 5vw, 64px);
  font-weight:200;
  letter-spacing:.1em;
  color: rgba(0,0,0,0.25);
  line-height:1;
}

.services-stack__tag{
  margin:0 0 12px;
  font-size:13px;
  letter-spacing:.15em;
  text-transform:uppercase;
  color:#777;
}

.services-stack__lede h2{
  margin:0;
  font-size: clamp(32px, 4vw, 46px);
  letter-spacing:-0.01em;
}

.services-stack__body{
  grid-column: span 8;
  background:#fff;
  border-radius: 22px;
  padding: clamp(28px, 5vw, 48px);
  box-shadow: 0 25px 55px rgba(15,15,15,0.08);
  border:1px solid rgba(0,0,0,0.05);
}

.services-stack__body p{
  margin:0 0 20px;
  font-size: clamp(17px, 2vw, 20px);
  line-height:1.7;
  color:#2f2f2f;
}

.services-stack__highlights{
  margin:0;
  padding:0;
  list-style:none;
  display:flex;
  flex-wrap:wrap;
  gap:12px;
}

.services-stack__highlights li{
  font-size:13px;
  letter-spacing:.08em;
  text-transform:uppercase;
  background:#fafafa;
  border-radius:999px;
  padding:9px 18px;
  border:1px solid rgba(0,0,0,0.08);
}

.services-stack__item--even .services-stack__lede{
  grid-column: 9 / -1;
  justify-content:flex-end;
  text-align:right;
}

.services-stack__item--even .services-stack__body{
  grid-column: 1 / span 8;
}

.services-stack__item--odd .services-stack__body{
  grid-column: span 8 / -1;
}

.services-cta{
  padding: clamp(60px, 12vw, 120px) 24px clamp(80px, 14vw, 140px);
  background:#0f0f0f;
  color:#f5f5f5;
  text-align:center;
}

.services-cta__inner{
  max-width: 720px;
  margin:0 auto;
}

.services-cta h2{
  margin:0 0 16px;
  font-size: clamp(30px, 4vw, 44px);
}

.services-cta p{
  margin:0 0 28px;
  font-size: clamp(17px, 2vw, 20px);
  color: rgba(245,245,245,0.82);
}

.services-cta__link{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding: 14px 28px;
  border-radius: 999px;
  background:#f5f5f5;
  color:#111;
  font-size:16px;
  letter-spacing:.05em;
  text-transform:uppercase;
  font-weight:500;
  transition: transform .2s ease, box-shadow .2s ease;
}

.services-cta__link:hover{
  transform: translateY(-2px);
  box-shadow:0 12px 26px rgba(0,0,0,0.12);
}

@media (max-width: 1100px){
  .services-stack__lede{ grid-column: 1 / span 5; }
  .services-stack__body{ grid-column: span 7; }
  .services-stack__item--even .services-stack__lede{ grid-column: 8 / -1; }
  .services-stack__item--even .services-stack__body{ grid-column: 1 / span 7; }
}

@media (max-width: 900px){
  .services-stack{ padding-left: 18px; padding-right: 18px; }
  .services-stack__item{ grid-template-columns: 1fr; }
  .services-stack__lede,
  .services-stack__body,
  .services-stack__item--even .services-stack__lede,
  .services-stack__item--even .services-stack__body{
    grid-column:auto;
    text-align:left;
    justify-content:flex-start;
  }
  .services-stack__lede{ margin-bottom:16px; }
}

@media (max-width: 600px){
  .services-hero{
    padding: clamp(56px, 24vw, 96px) 18px clamp(36px, 12vw, 72px);
  }

  .services-cta{
    padding: clamp(48px, 24vw, 96px) 18px clamp(64px, 26vw, 110px);
  }
}
</style>

<?php get_footer(); ?>
