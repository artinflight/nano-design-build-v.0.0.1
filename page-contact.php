<?php
/**
 * Template Name: Contact
 */
get_header();

// --- Config (editable via Customizer) ---
$company   = get_theme_mod('ndb_contact_company',  'Nano Design Build');
$address   = get_theme_mod('ndb_contact_address',  "1670 Bayview Ave., Suite 302\nToronto, ON  M4G 3C2");
$phone_raw = get_theme_mod('ndb_contact_phone',    '416-488-3350');
$email_raw = get_theme_mod('ndb_contact_recipient', get_option('admin_email') ?: 'admin@nanodesignbuild.com');

$phone_href = preg_replace('/[^0-9+]/', '', $phone_raw);
$email_disp = antispambot($email_raw);
$email_href = antispambot($email_raw);

// form setup
$nonce  = wp_create_nonce('ndb_contact_nonce');
$action = 'ndb_contact';
?>
<main class="site-main-standard page-contact" id="main">
  <header class="entry-header-standard contact-hero">
    <h1 class="entry-title-standard">Contact</h1>
    <p class="lede">Tell us about your site, timeline, and goals — we’ll reply within two business days.</p>
  </header>

  <?php if ( isset($_GET['ndb_sent']) && $_GET['ndb_sent']==='1' ) : ?>
    <div class="contact-alert contact-success" role="status">Thanks — your message was sent.</div>
  <?php elseif ( isset($_GET['ndb_error']) && $_GET['ndb_error']==='1' ) : ?>
    <div class="contact-alert contact-error" role="alert">Sorry — something went wrong. Please try again.</div>
  <?php endif; ?>

  <!-- Form: single, centered column -->
  <section class="contact-section">
    <form id="ndb-contact-form" class="contact-form" method="post" action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>">
      <input type="hidden" name="action" value="<?php echo esc_attr($action); ?>">
      <input type="hidden" name="_ndb_nonce" value="<?php echo esc_attr($nonce); ?>">
      <input type="hidden" name="_ndb_recipient" value="<?php echo esc_attr($email_raw); ?>">

      <!-- Honeypot -->
      <label class="hp" aria-hidden="true">Leave this field empty
        <input type="text" name="website" tabindex="-1" autocomplete="off">
      </label>

      <div class="field">
        <label for="cf-name">Name</label>
        <input id="cf-name" name="name" type="text" required autocomplete="name" />
      </div>

      <div class="field">
        <label for="cf-email">Email</label>
        <input id="cf-email" name="email" type="email" required autocomplete="email" />
      </div>

      <div class="field">
        <label for="cf-phone">Phone <span class="opt">(optional)</span></label>
        <input id="cf-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" />
      </div>

      <div class="field">
        <label for="cf-message">Message</label>
        <textarea id="cf-message" name="message" rows="6" required></textarea>
      </div>

      <button class="btn" type="submit">Send Message</button>
      <p class="small note">We’ll never share your information.</p>
      <div class="submit-state" aria-live="polite" aria-atomic="true"></div>
    </form>
  </section>

  <!-- Studio panel: magazine-style card below the form -->
<section class="studio-panel" aria-labelledby="studio-info-title">
  <div class="studio-card">
    <h2 id="studio-info-title" class="studio-eyebrow">Reach us</h2>

    <div class="studio-layout">
      <div class="studio-col studio-col--about">
        <div class="studio-name"><?php echo esc_html($company); ?></div>
        <address class="studio-address"><?php echo nl2br( esc_html($address) ); ?></address>
      </div>

      <div class="studio-col studio-col--contact">
        <a class="studio-line" href="tel:<?php echo esc_attr($phone_href); ?>">
          <span class="studio-label">Phone</span>
          <span class="studio-value"><?php echo esc_html($phone_raw); ?></span>
        </a>
        <a class="studio-line" href="mailto:<?php echo esc_attr($email_href); ?>">
          <span class="studio-label">Email</span>
          <span class="studio-value"><?php echo esc_html($email_disp); ?></span>
        </a>
      </div>
    </div>
  </div>
</section>

</main>

<style>
/* Scoped styles for the Contact template */
.page-contact .contact-hero { text-align:center; margin-bottom: 1.25rem; }
.page-contact .lede{color:#555;margin:.5rem 0 0}

/* Single-column, centered form */
.page-contact .contact-section { display:flex; justify-content:center; }
.page-contact .contact-form{
  width: min(720px, 100%);
  display:grid; gap:16px;
  padding: 0 16px;
}
.page-contact .field label{display:block;font-size:14px;letter-spacing:.02em;margin:0 0 .35rem;color:#333}
.page-contact .field input,.page-contact .field textarea{
  width:100%;border:1px solid #ddd;border-radius:10px;padding:12px 14px;font:inherit;outline:0;
  transition:border-color .15s ease, box-shadow .15s ease; background:#fff;
}
.page-contact .field input:focus,.page-contact .field textarea:focus{
  border-color:#888; box-shadow:0 0 0 3px rgba(0,0,0,.06)
}
.page-contact .btn{
  appearance:none;border:1px solid #111;background:#111;color:#fff;border-radius:999px;
  padding:10px 18px;font-size:14px;letter-spacing:.08em;text-transform:uppercase;cursor:pointer
}
.page-contact .btn:hover{background:#000}
.page-contact .opt{opacity:.6;font-weight:400}
.page-contact .small{font-size:12px;color:#777}
.page-contact .note{margin:.25rem 0 0}
.page-contact .submit-state{min-height:1.25em;font-size:14px;color:#555}
.page-contact .hp{position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden}

/* Magazine-style studio panel */
.page-contact .studio-panel{margin:48px auto 32px; padding:0 16px;}
.page-contact .studio-card{
  max-width: 960px; margin: 0 auto;
  background:#fff; border:1px solid rgba(0,0,0,.06); border-radius:16px;
  box-shadow: 0 12px 28px rgba(0,0,0,.06);
  padding: clamp(18px, 3.5vw, 28px);
}

.page-contact .studio-eyebrow{
  font-size:12px; letter-spacing:.14em; text-transform:uppercase; opacity:.6; margin:0 0 12px;
}

.page-contact .studio-layout{
  display:grid; gap: clamp(16px, 3vw, 28px);
  grid-template-columns: 2fr 1fr;
}
@media (max-width: 900px){
  .page-contact .studio-layout{ grid-template-columns: 1fr; }
}

.page-contact .studio-col--about{min-width:0;}
.page-contact .studio-name{
  font-size: clamp(18px, 2.2vw, 22px);
  font-weight: 700; letter-spacing:.01em; margin: 0 0 6px;
  hyphens:none; word-break: normal;
}
.page-contact .studio-address{
  margin:0; font-style: normal; color:#333; line-height:1.6;
  white-space: pre-line; /* respect newlines but don’t split words */
}

.page-contact .studio-col--contact{display:grid; gap:10px; align-content:start;}
.page-contact .studio-line{
  display:flex; align-items:baseline; justify-content:space-between;
  gap: 16px; padding:10px 12px;
  border:1px solid rgba(0,0,0,.06); border-radius:12px; background:#fff;
  text-decoration:none; color:inherit;
}
.page-contact .studio-line:hover{box-shadow:0 6px 18px rgba(0,0,0,.06)}
.page-contact .studio-label{
  font-size:12px; letter-spacing:.12em; text-transform:uppercase; opacity:.65;
}
.page-contact .studio-value{
  font-weight:600; white-space:nowrap; /* no phone/email wrapping */
  border-bottom: 1px solid rgba(0,0,0,.12);
}


/* Alerts */
.page-contact .contact-alert{border-radius:8px;padding:10px 12px;margin:0 auto 16px; width:min(720px,100%)}
.page-contact .contact-success{background:#f0fff4;border:1px solid #b6f0c3;color:#135d2d}
.page-contact .contact-error{background:#fff5f5;border:1px solid #ffc9c9;color:#7a1c1c}
</style>

<script>
// Progressive enhancement: AJAX submit with fetch; falls back to normal POST if blocked
(function(){
  const form = document.getElementById('ndb-contact-form');
  if(!form || !window.fetch) return;

  form.addEventListener('submit', async function(e){
    e.preventDefault();
    const state = form.querySelector('.submit-state');
    state.textContent = 'Sending…';

    const data = new FormData(form);
    try{
      const res = await fetch(form.action, { method:'POST', body:data, credentials:'same-origin' });
      const json = await res.json();
      if(json && json.success){
        state.textContent = 'Thanks — your message was sent.';
        form.reset();
      }else{
        state.textContent = (json && json.message) ? json.message : 'Sorry — please try again.';
      }
    }catch(err){
      state.textContent = 'Network error — please try again.';
    }
  });
})();
</script>

<?php get_footer();
