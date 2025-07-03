<?php
/**
 * The template for displaying the custom homepage (Original Baseline).
 */

get_header(); ?>

<section class="hero-video-section">
    <video playsinline autoplay muted loop poster="YOUR_POSTER_IMAGE_URL.jpg" class="hero-video-bg">
        <source src="http://localhost:10004/wp-content/uploads/2025/07/200717-NGD-Align63.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Designing & Building The Future</h1>
        <p class="hero-subtitle">We craft bespoke homes that merge timeless design with modern living.</p>
    </div>
</section>

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
            <a href="<?php echo get_post_type_archive_link('project'); ?>">View All Projects</a>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>