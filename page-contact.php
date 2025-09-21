<?php
/**
 * Template Name: Contact
 */
get_header();

// form config
$recipient = get_theme_mod('ndb_contact_recipient', get_option('admin_email'));
$nonce     = wp_create_nonce('ndb_contact_nonce');
$action    = 'ndb_contact';
?>
<main class="site-main-standard page-contact" id="main">
  <header class="entry-header-standard">
    <h1 class="entry-title-standard">Contact</h1>
    <p class="lede">Tell us about your site, timeline, and goals — we’ll reply within two business days.</p>
  </header>

  <?php if ( isset($_GET['ndb_sent']) && $_GET['ndb_sent']==='1' ) : ?>
    <div class="contact-alert contact-success" role="status">Thanks — your message was sent.</div>
  <?php elseif ( isset($_GET['ndb_error']) && $_GET['ndb_error']==='1' ) : ?>
    <div class="contact-alert contact-error" role="alert">Sorry — something went wrong. Please try again.</div>
  <?php endif; ?>

  <section class="contact-grid" aria-labelledby="contact-form-title">
    <div>
      <h2 id="contact-form-title" class="visually-hidden">Send a message</h2>

      <form id="ndb-contact-form" class="contact-form" method="post" action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>">
        <input type="hidden" name="action" value="<?php echo esc_attr($action); ?>">
        <input type="hidden" name="_ndb_nonce" value="<?php echo esc_attr($nonce); ?>">
        <input type="hidden" name="_ndb_recipient" value="<?php echo esc_attr( $recipient ); ?>">

        <!-- Honeypot field (spam trap) -->
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
    </div>

    <aside class="contact-aside">
      <div class="card">
        <h3>Reach us</h3>
        <p><strong>Email</strong><br><a href="mailto:<?php echo antispambot($recipient); ?>"><?php echo antispambot($recipient); ?></a></p>
        <?php if ( get_theme_mod('ndb_contact_phone') ) : ?>
          <p><strong>Phone</strong><br><a href="tel:<?php echo preg_replace('/[^0-9+]/','', get_theme_mod('ndb_contact_phone')); ?>"><?php echo esc_html( get_theme_mod('ndb_contact_phone') ); ?></a></p>
        <?php endif; ?>
        <?php if ( get_theme_mod('ndb_contact_address') ) : ?>
          <p><strong>Address</strong><br><?php echo nl2br( esc_html( get_theme_mod('ndb_contact_address') ) ); ?></p>
        <?php endif; ?>
      </div>
    </aside>
  </section>
</main>

<style>
/* Scoped to .page-contact to avoid touching the rest of the site */
.page-contact .lede{color:#555;margin:.5rem 0 0}
.page-contact .contact-grid{display:grid;grid-template-columns:2fr 1fr;gap:32px}
@media (max-width: 900px){.page-contact .contact-grid{grid-template-columns:1fr}}
.page-contact .contact-form{display:grid;gap:16px}
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
.page-contact .contact-aside .card{border:1px solid rgba(0,0,0,.06);border-radius:12px;padding:16px 18px;background:#fff;box-shadow:0 8px 24px rgba(0,0,0,.04)}
.page-contact .contact-alert{border-radius:8px;padding:10px 12px;margin:0 0 16px}
.page-contact .contact-success{background:#f0fff4;border:1px solid #b6f0c3;color:#135d2d}
.page-contact .contact-error{background:#fff5f5;border:1px solid #ffc9c9;color:#7a1c1c}
.visually-hidden{position:absolute!important;width:1px;height:1px;margin:-1px;overflow:hidden;clip:rect(0 0 0 0);clip-path:inset(50%);white-space:nowrap;border:0;padding:0}
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
