<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<?php
	// Add body class helper to detect front page for transparent header style
	$body_classes = implode( ' ', get_body_class( is_front_page() ? 'is-front' : '' ) );
?>
<body class="<?php echo esc_attr( $body_classes ); ?>">

<header class="site-header" role="banner">
<div class="nav-inner">
	<span class="brand">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
				// Explicit logo files from uploads (domain-agnostic)
				$logo_light = content_url( '/uploads/2025/11/nano-logo-1.svg' );      // on white
				$logo_dark  = content_url( '/uploads/2025/11/nano-logo-white.svg' );  // on black
			?>
			<img
				src="<?php echo esc_url( $logo_light ); ?>"
				alt="Nano Design Build"
				class="brand-logo brand-logo--light"
			/>
			<img
				src="<?php echo esc_url( $logo_dark ); ?>"
				alt="Nano Design Build"
				class="brand-logo brand-logo--dark"
			/>
		</a>
	</span>
    <!-- nav / toggle / etc continues exactly as before -->




		<button class="nav-toggle" aria-controls="primary-menu" aria-expanded="false">
			<span class="nav-toggle-bar"></span>
			<span class="nav-toggle-bar"></span>
			<span class="nav-toggle-bar"></span>
			<span class="screen-reader-text">Menu</span>
		</button>

		<nav id="primary-menu" class="nav-primary site-nav-minimal" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'nano-design-build' ); ?>">
			<?php
			// Prefer a WP menu named/assigned to 'primary'; otherwise fall back to hardcoded items.
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'fallback_cb'    => false,
					'depth'          => 1,
				) );
			} else {
				// Minimal fallback keeps your CPT archive link for Work.
                                $work_url = get_post_type_archive_link( 'project' );
                                ?>
                                <ul class="menu">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                                        <li><a href="<?php echo esc_url( $work_url ); ?>">Projects</a></li>
                                        <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a></li>
                                        <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
                                        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
                                </ul>
				<?php
			}
			?>
		</nav>
	</div>
</header>
