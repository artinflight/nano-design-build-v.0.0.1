<?php
/**
 * Nano Design Build functions and definitions
 *
 * @package NanoDesignBuild
 */

if ( ! function_exists( 'nanodesignbuild_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function nanodesignbuild_setup() {

        // THIS IS THE LINE WE ADDED IN THE CORRECT PLACE
        add_theme_support( 'post-thumbnails' );

        // 1. --- REGISTER CUSTOM POST TYPE: PROJECTS ---
        $project_labels = array(
            'name'                  => _x( 'Projects', 'Post Type General Name', 'nanodesignbuild' ),
            'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'nanodesignbuild' ),
            'menu_name'             => __( 'Projects', 'nanodesignbuild' ),
            'name_admin_bar'        => __( 'Project', 'nanodesignbuild' ),
            'archives'              => __( 'Project Archives', 'nanodesignbuild' ),
            'attributes'            => __( 'Project Attributes', 'nanodesignbuild' ),
            'parent_item_colon'     => __( 'Parent Project:', 'nanodesignbuild' ),
            'all_items'             => __( 'All Projects', 'nanodesignbuild' ),
            'add_new_item'          => __( 'Add New Project', 'nanodesignbuild' ),
            'add_new'               => __( 'Add New', 'nanodesignbuild' ),
            'new_item'              => __( 'New Project', 'nanodesignbuild' ),
            'edit_item'             => __( 'Edit Project', 'nanodesignbuild' ),
            'update_item'           => __( 'Update Project', 'nanodesignbuild' ),
            'view_item'             => __( 'View Project', 'nanodesignbuild' ),
            'view_items'            => __( 'View Projects', 'nanodesignbuild' ),
            'search_items'          => __( 'Search Project', 'nanodesignbuild' ),
            'not_found'             => __( 'Not found', 'nanodesignbuild' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'nanodesignbuild' ),
            'featured_image'        => __( 'Featured Image', 'nanodesignbuild' ),
            'set_featured_image'    => __( 'Set featured image', 'nanodesignbuild' ),
            'remove_featured_image' => __( 'Remove featured image', 'nanodesignbuild' ),
            'use_featured_image'    => __( 'Use as featured image', 'nanodesignbuild' ),
            'insert_into_item'      => __( 'Insert into project', 'nanodesignbuild' ),
            'uploaded_to_this_item' => __( 'Uploaded to this project', 'nanodesignbuild' ),
            'items_list'            => __( 'Projects list', 'nanodesignbuild' ),
            'items_list_navigation' => __( 'Projects list navigation', 'nanodesignbuild' ),
            'filter_items_list'     => __( 'Filter projects list', 'nanodesignbuild' ),
        );
        $project_args = array(
            'label'                 => __( 'Project', 'nanodesignbuild' ),
            'description'           => __( 'Portfolio of custom built homes.', 'nanodesignbuild' ),
            'labels'                => $project_labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-building',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( 'project', $project_args );


        // 2. --- REGISTER TAXONOMY: LOCATIONS ---
        $location_labels = array(
            'name'              => _x( 'Locations', 'taxonomy general name', 'nanodesignbuild' ),
            'singular_name'     => _x( 'Location', 'taxonomy singular name', 'nanodesignbuild' ),
            'search_items'      => __( 'Search Locations', 'nanodesignbuild' ),
            'all_items'         => __( 'All Locations', 'nanodesignbuild' ),
            'parent_item'       => __( 'Parent Location', 'nanodesignbuild' ),
            'parent_item_colon' => __( 'Parent Location:', 'nanodesignbuild' ),
            'edit_item'         => __( 'Edit Location', 'nanodesignbuild' ),
            'update_item'       => __( 'Update Location', 'nanodesignbuild' ),
            'add_new_item'      => __( 'Add New Location', 'nanodesignbuild' ),
            'new_item_name'     => __( 'New Location Name', 'nanodesignbuild' ),
            'menu_name'         => __( 'Locations', 'nanodesignbuild' ),
        );
        $location_args = array(
            'hierarchical'      => true,
            'labels'            => $location_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'location' ),
            'show_in_rest'      => true,
        );
        register_taxonomy( 'location', array( 'project' ), $location_args );


        // 3. --- REGISTER TAXONOMY: ARCHITECTURAL STYLES ---
        $style_labels = array(
            'name'                       => _x( 'Architectural Styles', 'taxonomy general name', 'nanodesignbuild' ),
            'singular_name'              => _x( 'Architectural Style', 'taxonomy singular name', 'nanodesignbuild' ),
            'search_items'               => __( 'Search Styles', 'nanodesignbuild' ),
            'popular_items'              => __( 'Popular Styles', 'nanodesignbuild' ),
            'all_items'                  => __( 'All Styles', 'nanodesignbuild' ),
            'edit_item'                  => __( 'Edit Style', 'nanodesignbuild' ),
            'update_item'                => __( 'Update Style', 'nanodesignbuild' ),
            'add_new_item'               => __( 'Add New Style', 'nanodesignbuild' ),
            'new_item_name'              => __( 'New Style Name', 'nanodesignbuild' ),
            'separate_items_with_commas' => __( 'Separate styles with commas', 'nanodesignbuild' ),
            'add_or_remove_items'        => __( 'Add or remove styles', 'nanodesignbuild' ),
            'choose_from_most_used'      => __( 'Choose from the most used styles', 'nanodesignbuild' ),
            'not_found'                  => __( 'No styles found.', 'nanodesignbuild' ),
            'menu_name'                  => __( 'Architectural Styles', 'nanodesignbuild' ),
        );
        $style_args = array(
            'hierarchical'          => false,
            'labels'                => $style_labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'style' ),
            'show_in_rest'          => true,
        );
        register_taxonomy( 'style', 'project', $style_args );
    }
endif;
add_action( 'init', 'nanodesignbuild_setup' );

function nanodesignbuild_register_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu', 'nanodesignbuild' ),
        )
    );
}
add_action( 'init', 'nanodesignbuild_register_menus' );

/**
 * Flush rewrite rules on theme activation.
 */
function nanodesignbuild_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'nanodesignbuild_rewrite_flush' );

/**
 * Enqueue scripts and styles.
 */

/**
 * Enqueue scripts and styles.
 */
function nanodesignbuild_scripts() {
    // Enqueue Stylesheet
    wp_enqueue_style( 'nanodesignbuild-style', get_stylesheet_uri() );

    // Enqueue Navigation Script
    wp_enqueue_script( 'nanodesignbuild-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true );

    // Only load special homepage scripts on the front page
    if ( is_front_page() ) {
        // Enqueue the new script to fix hero height
        wp_enqueue_script( 'nanodesignbuild-hero-height', get_template_directory_uri() . '/js/hero-height.js', array(), '1.0.0', true );
        
        // Enqueue the script for horizontal scrolling
        wp_enqueue_script( 'nanodesignbuild-horizontal-scroll', get_template_directory_uri() . '/js/horizontal-scroll.js', array(), '1.0.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'nanodesignbuild_scripts' );

// Add body class for front page
function nanodesignbuild_body_classes( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'is-front-page';
    }
    return $classes;
}
add_filter( 'body_class', 'nanodesignbuild_body_classes' );