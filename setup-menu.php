<?php
/**
 * Programmatically create the primary navigation menu
 * and assign pages to it.
 */
function nanodesignbuild_setup_menu() {
    // Check if the menu exists
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    // If it doesn't exist, let's create it
    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        // Set up default menu items
        $menu_items = array(
            'Home'    => home_url( '/' ),
            'Work'    => get_post_type_archive_link( 'project' ),
            'About'   => get_permalink( get_page_by_path( 'about' ) ),
            'Contact' => get_permalink( get_page_by_path( 'contact' ) ),
        );

        // Add items to the menu
        foreach ( $menu_items as $title => $url ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'  => $title,
                'menu-item-url'    => $url,
                'menu-item-status' => 'publish',
            ) );
        }

        // Assign the menu to the 'primary' location
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'after_setup_theme', 'nanodesignbuild_setup_menu' );
