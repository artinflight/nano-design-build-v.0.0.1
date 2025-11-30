<?php
/**
 * Archive template for Journal (CPT).
 * Markup only — all layout/styling lives in style.css.
 */
get_header(); ?>

<section class="recognitions-archive" aria-label="Recognitions">
  <div class="recognitions-wrap">
    <h1 class="eyebrow">Recognitions</h1>
    <h2 class="journal-title">Studio highlights &amp; press</h2>
    <p class="journal-lede">Milestones, memberships, and coverage that reflect the work of Nano Design Build.</p>

    <?php if ( have_posts() ) : ?>
      <div class="recognitions-grid">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php $topics = get_the_terms( get_the_ID(), 'journal_topic' ); ?>
          <article <?php post_class('recognition-card'); ?>>
            <?php if ( has_post_thumbnail() ) : ?>
              <figure class="recognition-card__media">
                <?php the_post_thumbnail('recognitions-thumb'); ?>
              </figure>
            <?php endif; ?>

            <div class="recognition-card__body">
              <?php if ( $topics && ! is_wp_error( $topics ) ) : ?>
                <div class="kicker">
                  <?php echo esc_html( implode( ' • ', wp_list_pluck( $topics, 'name' ) ) ); ?>
                </div>
              <?php endif; ?>

              <h3 class="entry-title"><?php the_title(); ?></h3>

              <div class="entry-excerpt">
                <?php the_content(); ?>
              </div>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <?php the_posts_pagination(); ?>
    <?php else : ?>
      <p class="journal-lede">Recognitions are coming soon.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
