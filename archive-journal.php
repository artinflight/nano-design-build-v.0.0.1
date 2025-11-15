<?php
/**
 * Archive template for Journal (CPT).
 * Markup only — all layout/styling lives in style.css.
 */
get_header(); ?>

<section class="journal-archive" aria-label="Journal timeline">
  <div class="journal-wrap">
    <h1 class="eyebrow">Recognitions</h1>
    <h2 class="journal-title">Studio timeline &amp; dispatches</h2>
    <p class="journal-lede">Milestones, press, memberships, and in-progress notes from the studio.</p>

    <ol class="timeline">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php
          $date_iso   = get_the_date( 'c' );          // 2013-11-08T00:00:00+00:00
          $date_label = get_the_date( 'M j, Y' );     // Nov 8, 2013
          $topics     = get_the_terms( get_the_ID(), 'journal_topic' );
        ?>
        <li class="timeline-item">
          <!-- the rail/dot/date are positioned by CSS -->
          <span class="dot" aria-hidden="true"></span>
          <time class="time" datetime="<?php echo esc_attr( $date_iso ); ?>">
            <?php echo esc_html( $date_label ); ?>
          </time>

          <article <?php post_class('card'); ?>>
      <?php if ( has_post_thumbnail() ) : ?>
        <div class="media">
          <?php the_post_thumbnail('journal-thumb'); ?>
        </div>
      <?php endif; ?>

      <div class="body">
        <?php if ( $topics && ! is_wp_error($topics) ) : ?>
          <div class="kicker">
            <?php echo esc_html( implode(' • ', wp_list_pluck($topics,'name')) ); ?>
          </div>
        <?php endif; ?>

        <h3 class="entry-title"><?php the_title(); ?></h3>

        <div class="entry-excerpt">
          <?php
            // Full content with normal WP formatting + shortcodes
            the_content();
          ?>
        </div>
      </div>
    </article>
        </li>
      <?php endwhile; endif; ?>
    </ol>

    <?php the_posts_pagination(); ?>
  </div>
</section>

<?php get_footer(); ?>
