<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const header = document.querySelector('.site-header');
        if (header) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    header.classList.add('is-scrolled');
                } else {
                    header.classList.remove('is-scrolled');
                }
            });
        }
    });
</script>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="site-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo get_template_directory_uri(); ?>/images/nano.svg" alt="<?php bloginfo( 'name' ); ?>">
        </a>
    </div>

    <nav class="site-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'nanodesignbuild' ); ?>">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary-menu',
                'menu_class'     => 'primary-menu',
                'container'      => false,
            )
        );
        ?>
    </nav>

    <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
        <span class="sr-only">Menu</span>
    </button>
</header>