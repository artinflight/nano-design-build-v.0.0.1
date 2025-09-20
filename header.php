<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="site-header-inner">
        <div class="site-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php echo get_template_directory_uri(); ?>/images/nano.svg" alt="<?php bloginfo( 'name' ); ?>">
            </a>
        </div>

        <nav class="primary-nav" aria-label="Primary">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
            ) );
            ?>
        </nav>

        <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
</header>

<main class="site-main">