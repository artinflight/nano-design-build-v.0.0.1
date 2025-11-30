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

           <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
			<span class="brand">
				<?php the_custom_logo(); ?>
			</span>
		<?php else : ?>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="brand-text"><?php bloginfo( 'name' ); ?></span>
			</a>
		<?php endif; ?>

            <main id="main" class="site-main">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>">
                        <header class="entry-header">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </header>

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

                                $caption   = wp_get_attachment_caption( $image_id );
                                $full_url  = wp_get_attachment_image_url( $image_id, 'full' );

                                $gallery_items[] = [
                                    'image'    => $image_html,
                                    'caption'  => $caption,
                                    'full_url' => $full_url,
                                ];
                            }
                        ?>

                        <?php if ( ! empty( $gallery_items ) ) : ?>
                            <div class="project-gallery" aria-label="Project gallery">
                                <?php foreach ( $gallery_items as $item ) : ?>
                                    <figure class="project-gallery-item">
                                        <?php if ( ! empty( $item['full_url'] ) ) : ?>
                                            <a href="<?php echo esc_url( $item['full_url'] ); ?>" class="project-gallery-link" data-lightbox="project">
                                                <?php echo $item['image']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo $item['image']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $item['caption'] ) ) : ?>
                                            <figcaption><?php echo esc_html( $item['caption'] ); ?></figcaption>
                                        <?php endif; ?>
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p class="project-gallery-empty">Add a Gallery block to this project to populate imagery.</p>
                        <?php endif; ?>

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

                        <?php $project_archive_link = get_post_type_archive_link( 'project' ); ?>
                        <?php if ( $project_archive_link ) : ?>
                            <div class="project-archive-cta">
                                <a class="project-archive-cta__link" href="<?php echo esc_url( $project_archive_link ); ?>">
                                    <span aria-hidden="true">&larr;</span>
                                    <span class="project-archive-cta__label">Back to Featured Projects</span>
                                </a>
                            </div>
                        <?php endif; ?>

                    </article>
                <?php endwhile; ?>
            </main>

            <footer class="site-footer-condensed">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>
            </footer>
        </div>

    </div>

    <div class="project-lightbox" id="project-lightbox" aria-hidden="true">
        <button type="button" class="project-lightbox__close" aria-label="Close gallery">&times;</button>
        <img src="" alt="" loading="lazy" />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lightbox = document.getElementById('project-lightbox');
            if (!lightbox) {
                return;
            }

            var lightboxImage = lightbox.querySelector('img');
            var closeButton = lightbox.querySelector('.project-lightbox__close');
            var body = document.body;

            var closeLightbox = function () {
                lightbox.classList.remove('is-active');
                body.classList.remove('lightbox-open');
                if (lightboxImage) {
                    lightboxImage.src = '';
                    lightboxImage.alt = '';
                }
            };

            document.querySelectorAll('.project-gallery-link').forEach(function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    if (!lightboxImage) {
                        return;
                    }

                    lightboxImage.src = link.getAttribute('href');
                    var nestedImg = link.querySelector('img');
                    lightboxImage.alt = nestedImg ? nestedImg.getAttribute('alt') || '' : '';

                    lightbox.classList.add('is-active');
                    body.classList.add('lightbox-open');
                });
            });

            if (closeButton) {
                closeButton.addEventListener('click', closeLightbox);
            }
            lightbox.addEventListener('click', function (event) {
                if (event.target === lightbox) {
                    closeLightbox();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && lightbox.classList.contains('is-active')) {
                    closeLightbox();
                }
            });
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>
