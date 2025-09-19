<?php
/**
 * The template for displaying a single project.
 * This template has a special full-page, two-column layout.
 */

// We need the featured image URL to use as a CSS background.
$featured_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <div class="full-page-project-grid">

        <div class="project-content-scroll">
        
            <header class="site-header-condensed">
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            </header>

            <main id="main" class="site-main">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>">
                        <header class="entry-header">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </header>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>

                        <div class="project-meta">
                            <?php
                                the_terms( get_the_ID(), 'location', '<div class="meta-item"><span class="meta-label">Location</span><span class="meta-value">', ', ', '</span></div>' );
                                the_terms( get_the_ID(), 'style', '<div class="meta-item"><span class="meta-label">Style</span><span class="meta-value">', ', ', '</span></div>' );
                            ?>
                        </div>

                        <nav class="project-navigation">
                            <div class="nav-previous"><?php previous_post_link( '%link', '← %title' ); ?></div>
                            <div class="nav-next"><?php next_post_link( '%link', '%title →' ); ?></div>
                        </nav>

                    </article>
                <?php endwhile; ?>
            </main>

            <footer class="site-footer-condensed">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>
            </footer>
        </div>

        <div class="project-image-column" style="background-image: url('<?php echo esc_url( $featured_image_url ); ?>');">
            <?php // This div is intentionally empty. The image is its background. ?>
        </div>

    </div>

    <?php wp_footer(); ?>
</body>
</html>