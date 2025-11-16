<?php get_header(); ?>

<main id="main" class="site-main">

    <header class="page-header">
        <h1 class="page-title">Featured Projects</h1>
        <div class="page-subtitle">A curated selection of our finest architectural projects—brick, stucco, wood, and glass composed into warm, practical plans. Each project pairs modern lines with durable materials, scaled to the street and tuned for light.</div>
    </header>

    <?php if ( have_posts() ) : ?>

        <div class="project-archive-list">
            <?php while ( have_posts() ) : the_post(); ?>
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
                                    // Display the first location associated with the project
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
        </div>

    <?php else : ?>
        <p><?php _e( 'No projects found.', 'nanodesignbuild' ); ?></p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>