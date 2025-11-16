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

  <section class="services-body" aria-label="Nano Design Build service offerings">
    <div class="services-body__wrap">
      <article class="service-item" id="service-design">
        <div class="service-item__header">
          <span class="service-item__number">01</span>
          <h2>Design</h2>
        </div>
        <div class="service-item__content">
          <p>Early collaboration starts with feasibility analysis to understand the potential of your lot, budget, and timeline. We translate those insights into schematic options and clear massing studies, producing immersive 3D visualization that helps you evaluate the design long before construction begins.</p>
          <ul class="service-item__highlights">
            <li>Feasibility reviews &amp; code checks</li>
            <li>Schematic options and early concepts</li>
            <li>3D visualization and walkthroughs</li>
          </ul>
        </div>
      </article>

      <article class="service-item" id="service-approvals">
        <div class="service-item__header">
          <span class="service-item__number">02</span>
          <h2>Approvals</h2>
        </div>
        <div class="service-item__content">
          <p>We lead the planning strategy, preparing comprehensive Committee of Adjustment applications that speak to local zoning review requirements. Our team coordinates the site plan process and works closely with municipal staff so approvals move forward with clarity and minimal surprises.</p>
          <ul class="service-item__highlights">
            <li>Planning strategy &amp; stakeholder preparation</li>
            <li>Committee of Adjustment submissions</li>
            <li>Zoning analysis &amp; site plan coordination</li>
          </ul>
        </div>
      </article>

      <article class="service-item" id="service-documentation">
        <div class="service-item__header">
          <span class="service-item__number">03</span>
          <h2>Documentation</h2>
        </div>
        <div class="service-item__content">
          <p>Design development flows into detailed permit drawing sets with coordinated specifications. Structural, mechanical, and electrical consultants are integrated into our workflow, ensuring documentation is buildable, compliant, and ready for pricing.</p>
          <ul class="service-item__highlights">
            <li>Design development &amp; permit drawing sets</li>
            <li>Specification packages ready for pricing</li>
            <li>Coordination with structural, mechanical &amp; electrical teams</li>
          </ul>
        </div>
      </article>

      <article class="service-item" id="service-build">
        <div class="service-item__header">
          <span class="service-item__number">04</span>
          <h2>Build</h2>
        </div>
        <div class="service-item__content">
          <p>We manage estimating and tendering, support contractor selection, and remain present during construction management. Regular site reviews and rigorous quality assurance keep the build aligned with intent, cost, and schedule.</p>
          <ul class="service-item__highlights">
            <li>Estimating and tendering support</li>
            <li>Contractor selection &amp; procurement</li>
            <li>Construction management &amp; quality assurance</li>
          </ul>
        </div>
      </article>

      <article class="service-item" id="service-aftercare">
        <div class="service-item__header">
          <span class="service-item__number">05</span>
          <h2>Aftercare</h2>
        </div>
        <div class="service-item__content">
          <p>Closeout is handled with the same care as the first sketch. We compile as-built and closeout documents, coordinate warranties, and provide ongoing support so your home continues to perform beautifully long after move-in.</p>
          <ul class="service-item__highlights">
            <li>Project closeout &amp; as-built documentation</li>
            <li>Warranty coordination &amp; follow-ups</li>
            <li>Ongoing client support</li>
          </ul>
        </div>
      </article>
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

.services-body{
  padding: 48px 24px clamp(56px, 10vw, 108px);
}

.services-body__wrap{
  max-width: 1200px;
  margin: 0 auto;
  border-top:1px solid rgba(0,0,0,0.08);
}

.service-item{
  display:grid;
  grid-template-columns: repeat(12, minmax(0, 1fr));
  gap: clamp(16px, 4vw, 32px);
  align-items:center;
  padding: clamp(32px, 5vw, 56px) 0;
  border-bottom:1px solid rgba(0,0,0,0.08);
}

.service-item__header{
  grid-column: 1 / span 4;
  display:flex;
  align-items:center;
  gap: 18px;
}

.service-item__number{
  font-size: clamp(36px, 6vw, 72px);
  font-weight:200;
  letter-spacing:.06em;
  color: rgba(0,0,0,0.2);
  line-height:1;
}

.service-item__header h2{
  margin:0;
  font-size: clamp(28px, 4vw, 42px);
  letter-spacing:-0.01em;
}

.service-item__content{
  grid-column: span 8;
  background: linear-gradient(120deg, rgba(245,245,245,0.9), rgba(255,255,255,0.9));
  border-radius: 24px;
  padding: clamp(28px, 5vw, 46px);
  box-shadow: 0 18px 40px rgba(15,15,15,0.08);
}

.service-item__content p{
  margin:0 0 22px;
  font-size: clamp(17px, 2vw, 20px);
  line-height:1.7;
  color:#2c2c2c;
}

.service-item__highlights{
  margin:0;
  padding:0;
  list-style:none;
  display:flex;
  flex-wrap:wrap;
  gap:12px;
}

.service-item__highlights li{
  font-size:14px;
  letter-spacing:.08em;
  text-transform:uppercase;
  background:#fff;
  border-radius:999px;
  padding:10px 18px;
  border:1px solid rgba(0,0,0,0.08);
}

.service-item:nth-child(even) .service-item__header{
  grid-column: 9 / -1;
  justify-content:flex-end;
  text-align:right;
}

.service-item:nth-child(even) .service-item__content{
  grid-column: 1 / span 8;
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
  .service-item__header{
    grid-column: 1 / span 5;
  }
  .service-item__content{
    grid-column: span 7;
  }
  .service-item:nth-child(even) .service-item__header{
    grid-column: 8 / -1;
  }
}

@media (max-width: 900px){
  .services-body{
    padding: 36px 18px clamp(48px, 12vw, 90px);
  }

  .service-item{
    grid-template-columns: 1fr;
  }

  .service-item__header,
  .service-item__content,
  .service-item:nth-child(even) .service-item__header,
  .service-item:nth-child(even) .service-item__content{
    grid-column: auto;
    text-align:left;
    justify-content:flex-start;
  }

  .service-item__header{
    margin-bottom:12px;
  }
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
