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
            'has_archive'           => 'projects',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
            'rewrite'               => array(
                'slug'       => 'projects',                          // ← singles at /projects/<project>
                'with_front' => false
            ),           
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

/**
 * Recognitions (timeline) – custom post type
 * Slug: /recognitions/
 */
add_action('init', function () {

  // Labels
  $labels = [
    'name'               => _x('Recognitions', 'Post type general name', 'nanodesignbuild'),
    'singular_name'      => _x('Entry', 'Post type singular name', 'nanodesignbuild'),
    'menu_name'          => _x('Recognitions', 'Admin Menu text', 'nanodesignbuild'),
    'name_admin_bar'     => _x('Recognitions Entry', 'Add New on Toolbar', 'nanodesignbuild'),
    'add_new'            => __('Add New', 'nanodesignbuild'),
    'add_new_item'       => __('Add New Entry', 'nanodesignbuild'),
    'edit_item'          => __('Edit Entry', 'nanodesignbuild'),
    'new_item'           => __('New Entry', 'nanodesignbuild'),
    'view_item'          => __('View Entry', 'nanodesignbuild'),
    'all_items'          => __('All Entries', 'nanodesignbuild'),
    'search_items'       => __('Search Recognitions', 'nanodesignbuild'),
    'not_found'          => __('No entries found.', 'nanodesignbuild'),
  ];

  // CPT
  register_post_type('journal', [
    'labels'             => $labels,
    'public'             => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'menu_icon'          => 'dashicons-welcome-write-blog',
    'supports'           => ['title','editor','thumbnail','excerpt','revisions'],
    'has_archive'        => true,
    'rewrite'            => ['slug' => 'recognitions', 'with_front' => true],
    'show_in_rest'       => true,
  ]);

  // Optional taxonomy for grouping (Process, Press, Awards, Milestones…)
  register_taxonomy('journal_topic', ['journal'], [
    'label'        => __('Topics', 'nanodesignbuild'),
    'public'       => true,
    'hierarchical' => false,
    'rewrite'      => ['slug' => 'recognitions-topic'],
    'show_in_rest' => true,
  ]);

  // Image size for timeline thumbnails (keeps rhythm)
  add_image_size('recognitions-thumb', 1200, 750, true); // 16:10 crop
});


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
    wp_enqueue_style( 'nanodesignbuild-style', get_stylesheet_uri(), [], '1.0.1'  );

    // Only load special homepage scripts on the front page
    if ( is_front_page() ) {
        // Enqueue the new script to fix hero height
        wp_enqueue_script( 'nanodesignbuild-hero-height', get_template_directory_uri() . '/js/hero-height.js', array(), '1.0.0', true );
        
        // Enqueue the script for horizontal scrolling
        wp_enqueue_script( 'nanodesignbuild-horizontal-scroll', get_template_directory_uri() . '/js/horizontal-scroll.js', array(), '1.0.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'nanodesignbuild_scripts' );

// Menu + logo support (safe if called multiple times)
add_action( 'after_setup_theme', function () {
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 120,
		'flex-width'  => true,
		'flex-height' => true,
	) );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nano-design-build' ),
	) );
} );

// Rewrite legacy nano-design-build-v1.test upload URLs to this site's base URL at render time.
add_filter('the_content', function ($content) {
    $home = home_url();
    // Only touch links under /wp-content/uploads/ to avoid unintended changes.
    $content = preg_replace(
        '#https?://nano-design-build-v1\.test(/wp-content/uploads/[^"\'\s<>]+)#i',
        $home . '$1',
        $content
    );
    return $content;
}, 20);

// Disable the admin bar on the front-end for all logged-in users.
add_filter( 'show_admin_bar', '__return_false' );

/**
 * NDB Contact Form handler (AJAX + non-AJAX)
 */
add_action('wp_ajax_ndb_contact', 'ndb_handle_contact');
add_action('wp_ajax_nopriv_ndb_contact', 'ndb_handle_contact');

function ndb_handle_contact(){
  // Nonce
  $nonce = isset($_POST['_ndb_nonce']) ? sanitize_text_field($_POST['_ndb_nonce']) : '';
  if (! wp_verify_nonce($nonce, 'ndb_contact_nonce')) {
    return ndb_contact_fail('Invalid security token. Please refresh and try again.');
  }

  // Honeypot
  if (!empty($_POST['website'])) {
    return ndb_contact_fail('Spam detected.');
  }

  // Fields
  $name    = isset($_POST['name'])    ? trim(wp_strip_all_tags($_POST['name'])) : '';
  $email   = isset($_POST['email'])   ? sanitize_email($_POST['email']) : '';
  $phone   = isset($_POST['phone'])   ? trim(wp_strip_all_tags($_POST['phone'])) : '';
  $message = isset($_POST['message']) ? trim(wp_kses_post($_POST['message'])) : '';
  $to      = isset($_POST['_ndb_recipient']) ? sanitize_email($_POST['_ndb_recipient']) : get_option('admin_email');

  if ($name==='' || $email==='' || $message==='') {
    return ndb_contact_fail('Please complete all required fields.');
  }
  if (!is_email($email)) {
    return ndb_contact_fail('Please enter a valid email address.');
  }

  // Compose
  $subject = sprintf('[NDB Site] Message from %s', $name);
  $body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message\n";
  $headers = array('Reply-To: '.$name.' <'.$email.'>');

  // Send
  $sent = wp_mail($to, $subject, $body, $headers);

  // AJAX vs non-AJAX
  if (defined('DOING_AJAX') && DOING_AJAX) {
    if ($sent) {
      wp_send_json_success(array('message' => 'Message sent.'));
    } else {
      ndb_contact_fail('Could not send email. Please try again later.');
    }
  } else {
    // fallback: redirect back to contact page with query param
    $url = add_query_arg( $sent ? 'ndb_sent=1' : 'ndb_error=1', wp_get_referer() ?: home_url('/contact/') );
    wp_safe_redirect($url);
    exit;
  }
}

function ndb_contact_fail($msg){
  if (defined('DOING_AJAX') && DOING_AJAX) {
    wp_send_json_error(array('message' => $msg), 400);
  } else {
    $url = add_query_arg('ndb_error=1', wp_get_referer() ?: home_url('/contact/') );
    wp_safe_redirect($url);
    exit;
  }
}

/**
 * Optional: Customizer settings to manage recipient/phone/address without code
 */
add_action('customize_register', function($wp_customize){
  $wp_customize->add_section('ndb_contact', array(
    'title' => __('Contact Details','nanodesignbuild'), 'priority'=>30
  ));
  $wp_customize->add_setting('ndb_contact_recipient', array('default'=>get_option('admin_email'), 'sanitize_callback'=>'sanitize_email'));
  $wp_customize->add_control('ndb_contact_recipient', array('label'=>__('Form recipient email','nanodesignbuild'), 'section'=>'ndb_contact', 'type'=>'email'));
  $wp_customize->add_setting('ndb_contact_phone', array('sanitize_callback'=>'sanitize_text_field'));
  $wp_customize->add_control('ndb_contact_phone', array('label'=>__('Public phone','nanodesignbuild'), 'section'=>'ndb_contact', 'type'=>'text'));
  $wp_customize->add_setting('ndb_contact_address', array('sanitize_callback'=>'wp_kses_post'));
  $wp_customize->add_control('ndb_contact_address', array('label'=>__('Address (multiline OK)','nanodesignbuild'), 'section'=>'ndb_contact', 'type'=>'textarea'));
});

// In functions.php
add_filter('the_content_more_link', function($link){
  if ( is_post_type_archive('recognitions') ) {
    // strip the anchor & turn into plain text
    return '';
  }
  return $link;
});

// functions.php
add_filter('upload_mimes', function($mimes){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});
