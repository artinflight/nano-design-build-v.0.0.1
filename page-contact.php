<?php
/**
 * Template Name: Contact Page
 *
 * @package Nano
 * @since 1.0
 */

get_header(); ?>

<main id="main" class="site-main-standard">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header-standard">
                <?php the_title( '<h1 class="entry-title-standard">', '</h1>' ); ?>
            </header>

            <div class="entry-content-standard">
                <?php the_content(); ?>

                <div class="static-contact-info">
                    <h3>Contact Us</h3>
                    <p><strong>Email:</strong> info@nanodesignbuild.com</p>
                    <p><strong>Phone:</strong> (555) 123-4567</p>
                    <p><strong>Address:</strong> 123 Innovation Drive, Suite 100, Tech City, USA</p>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
