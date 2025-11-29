<?php
/**
 * Template Name: Contact
 */
get_header();

// --- Config (editable via Customizer) ---
$company   = get_theme_mod('ndb_contact_company',  'Nano Design Build');
$address   = get_theme_mod('ndb_contact_address',  '1670 Bayview Avenue, Suite 302, Toronto, ON, M4G 3C2');
$phone_raw = get_theme_mod('ndb_contact_phone',    '416-488-3350');
$email_raw = get_theme_mod('ndb_contact_recipient', 'info@nanodesignbuild.com');

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
        <address class="studio-address"><?php echo esc_html($address); ?></address>
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
