<?php
/**
 * The template for displaying a single project.
 * This template has a special full-page, two-column layout.
 */

// Hero image for the sticky column.
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

        <div class="project-image-column" style="background-image: url('<?php echo esc_url( $featured_image_url ); ?>');">
            <?php // The hero column relies on its background image. ?>
        </div>

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

                        <div class="project-meta">
                            <?php
                                the_terms( get_the_ID(), 'location', '<div class="meta-item"><span class="meta-label">Location</span><span class="meta-value">', ', ', '</span></div>' );
                                the_terms( get_the_ID(), 'style', '<div class="meta-item"><span class="meta-label">Style</span><span class="meta-value">', ', ', '</span></div>' );
                            ?>
                        </div>

                        <?php
                            $gallery_items = [];
                            $galleries     = get_post_galleries( get_the_ID(), false );

                            if ( ! empty( $galleries ) && ! empty( $galleries[0]['ids'] ) ) {
                                $ids = array_map( 'intval', explode( ',', $galleries[0]['ids'] ) );
                            } else {
                                $ids = [];
                                $attachments = get_attached_media( 'image', get_the_ID() );

                                foreach ( $attachments as $attachment ) {
                                    $ids[] = $attachment->ID;
                                }
                            }

                            foreach ( $ids as $image_id ) {
                                $image_html = wp_get_attachment_image( $image_id, 'large', false, [
                                    'class'   => 'project-gallery-image',
                                    'loading' => 'lazy',
                                ] );

                                if ( ! $image_html ) {
                                    continue;
                                }

                                $caption = wp_get_attachment_caption( $image_id );

                                $gallery_items[] = [
                                    'image'   => $image_html,
                                    'caption' => $caption,
                                ];
                            }
                        ?>

                        <?php if ( ! empty( $gallery_items ) ) : ?>
                            <div class="project-gallery" aria-label="Project gallery">
                                <?php foreach ( $gallery_items as $item ) : ?>
                                    <figure class="project-gallery-item">
                                        <?php echo $item['image']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        <?php if ( ! empty( $item['caption'] ) ) : ?>
                                            <figcaption><?php echo esc_html( $item['caption'] ); ?></figcaption>
                                        <?php endif; ?>
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p class="project-gallery-empty">Add a Gallery block to this project to populate imagery.</p>
                        <?php endif; ?>

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

    </div>

    <?php wp_footer(); ?>
</body>
</html>