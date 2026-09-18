<?php
/**
 * Lumino Design Studio Theme Functions
 *
 * @package Lumino
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('LUMINO_VERSION', '1.0.0');

/**
 * Theme Setup
 */
function lumino_setup() {
    // Make theme available for translation
    load_theme_textdomain('lumino', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Custom image sizes tailored to Lumino / Operator layout
    add_image_size('lumino-card-standard', 552, 690, true);   // Standard 552x690 ratio crop
    add_image_size('lumino-card-adaptive', 1104, 0, false);   // High-res unconstrained for adaptive cards
    add_image_size('lumino-archive-thumb', 400, 400, true);   // Square archive thumbs
    add_image_size('lumino-full-showcase', 1920, 0, false);   // Full width presentation images

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'lumino'),
        'footer'  => esc_html__('Footer Social Menu', 'lumino'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Support responsive embedded content
    add_theme_support('responsive-embeds');

    // Support Custom Logo
    add_theme_support('custom-logo', array(
        'height'      => 40,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'lumino_setup');

/**
 * Enqueue Styles and Scripts
 */
function lumino_scripts() {
    // Google Fonts (Big Shoulders Display, Inter Tight, Inter)
    wp_enqueue_style(
        'lumino-google-fonts',
        'https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;900&family=Inter+Tight:ital,wght@0,400;0,500;0,600;0,700;1,500;1,700&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );

    // Main CSS
    wp_enqueue_style(
        'lumino-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array('lumino-google-fonts'),
        LUMINO_VERSION
    );

    // Theme style.css
    wp_enqueue_style('lumino-style', get_stylesheet_uri(), array('lumino-main-style'), LUMINO_VERSION);

    // Main JS
    wp_enqueue_script(
        'lumino-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        LUMINO_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'lumino_scripts');

/**
 * Register Custom Post Type: Portfolio (Works)
 */
function lumino_register_portfolio_cpt() {
    $labels = array(
        'name'                  => _x('Works', 'Post type general name', 'lumino'),
        'singular_name'         => _x('Work', 'Post type singular name', 'lumino'),
        'menu_name'             => _x('Portfolio', 'Admin Menu text', 'lumino'),
        'name_admin_bar'        => _x('Work', 'Add New on Toolbar', 'lumino'),
        'add_new'               => __('Add New Project', 'lumino'),
        'add_new_item'          => __('Add New Project', 'lumino'),
        'new_item'              => __('New Project', 'lumino'),
        'edit_item'             => __('Edit Project', 'lumino'),
        'view_item'             => __('View Project', 'lumino'),
        'all_items'             => __('All Projects', 'lumino'),
        'search_items'          => __('Search Projects', 'lumino'),
        'parent_item_colon'     => __('Parent Projects:', 'lumino'),
        'not_found'             => __('No projects found.', 'lumino'),
        'not_found_in_trash'    => __('No projects found in Trash.', 'lumino'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'works'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('portfolio', $args);

    // Register Category Taxonomy for Portfolio
    $tax_labels = array(
        'name'              => _x('Categories', 'taxonomy general name', 'lumino'),
        'singular_name'     => _x('Category', 'taxonomy singular name', 'lumino'),
        'search_items'      => __('Search Categories', 'lumino'),
        'all_items'         => __('All Categories', 'lumino'),
        'edit_item'         => __('Edit Category', 'lumino'),
        'update_item'       => __('Update Category', 'lumino'),
        'add_new_item'      => __('Add New Category', 'lumino'),
        'new_item_name'     => __('New Category Name', 'lumino'),
        'menu_name'         => __('Categories', 'lumino'),
    );

    register_taxonomy('portfolio_category', array('portfolio'), array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'work-category'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'lumino_register_portfolio_cpt');

/**
 * Meta Boxes for Portfolio Items
 */
function lumino_add_portfolio_metaboxes() {
    add_meta_box(
        'lumino_project_meta',
        __('Project Details (Operator Style)', 'lumino'),
        'lumino_render_portfolio_metabox',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'lumino_add_portfolio_metaboxes');

function lumino_render_portfolio_metabox($post) {
    wp_nonce_field('lumino_save_project_meta', 'lumino_project_nonce');

    $year       = get_post_meta($post->ID, '_lumino_project_year', true);
    $services   = get_post_meta($post->ID, '_lumino_project_services', true);
    $client     = get_post_meta($post->ID, '_lumino_project_client', true);
    $card_mode  = get_post_meta($post->ID, '_lumino_card_mode', true) ?: 'standard';
    $external   = get_post_meta($post->ID, '_lumino_project_url', true);
    ?>
    <table class="form-table" style="width: 100%;">
        <tr>
            <th style="width: 20%;"><label for="lumino_project_year"><?php esc_html_e('Year', 'lumino'); ?></label></th>
            <td>
                <input type="text" id="lumino_project_year" name="lumino_project_year" value="<?php echo esc_attr($year); ?>" placeholder="2024" style="width: 200px;" />
                <p class="description"><?php esc_html_e('e.g. 2024, 2023', 'lumino'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="lumino_project_services"><?php esc_html_e('Service / Discipline', 'lumino'); ?></label></th>
            <td>
                <input type="text" id="lumino_project_services" name="lumino_project_services" value="<?php echo esc_attr($services); ?>" placeholder="Brand Design / Identity" style="width: 100%; max-width: 450px;" />
                <p class="description"><?php esc_html_e('Displayed beside the title and in project info (e.g. Product Design, Branding, Editorial)', 'lumino'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="lumino_project_client"><?php esc_html_e('Client', 'lumino'); ?></label></th>
            <td>
                <input type="text" id="lumino_project_client" name="lumino_project_client" value="<?php echo esc_attr($client); ?>" placeholder="Company.co / Fictional" style="width: 100%; max-width: 450px;" />
            </td>
        </tr>
        <tr>
            <th><label for="lumino_card_mode"><?php esc_html_e('Card Sizing Mode', 'lumino'); ?></label></th>
            <td>
                <select id="lumino_card_mode" name="lumino_card_mode" style="width: 300px;">
                    <option value="standard" <?php selected($card_mode, 'standard'); ?>><?php esc_html_e('Standard 552 x 690 (Uniform aspect ratio)', 'lumino'); ?></option>
                    <option value="adaptive" <?php selected($card_mode, 'adaptive'); ?>><?php esc_html_e('Adaptive (Seamlessly adapts to natural image size)', 'lumino'); ?></option>
                </select>
                <p class="description"><?php esc_html_e('Choose Adaptive if you upload custom-sized images that should preserve their exact dimensions without cropping.', 'lumino'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="lumino_project_url"><?php esc_html_e('External Project URL (Optional)', 'lumino'); ?></label></th>
            <td>
                <input type="url" id="lumino_project_url" name="lumino_project_url" value="<?php echo esc_url($external); ?>" placeholder="https://..." style="width: 100%; max-width: 450px;" />
            </td>
        </tr>
        <tr>
            <th><label for="lumino_project_full_img"><?php esc_html_e('Full Presentation Scroll Image URL (Optional)', 'lumino'); ?></label></th>
            <td>
                <?php $full_img = get_post_meta($post->ID, '_lumino_project_full_img', true); ?>
                <input type="text" id="lumino_project_full_img" name="lumino_project_full_img" value="<?php echo esc_attr($full_img); ?>" placeholder="https://... or /assets/images/projects/..." style="width: 100%; max-width: 450px;" />
                <p class="description"><?php esc_html_e('URL to the full vertical presentation scroll shown when visitor opens the work page.', 'lumino'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function lumino_save_portfolio_metabox($post_id) {
    if (!isset($_POST['lumino_project_nonce']) || !wp_verify_nonce($_POST['lumino_project_nonce'], 'lumino_save_project_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['lumino_project_year'])) {
        update_post_meta($post_id, '_lumino_project_year', sanitize_text_field($_POST['lumino_project_year']));
    }
    if (isset($_POST['lumino_project_services'])) {
        update_post_meta($post_id, '_lumino_project_services', sanitize_text_field($_POST['lumino_project_services']));
    }
    if (isset($_POST['lumino_project_client'])) {
        update_post_meta($post_id, '_lumino_project_client', sanitize_text_field($_POST['lumino_project_client']));
    }
    if (isset($_POST['lumino_card_mode'])) {
        update_post_meta($post_id, '_lumino_card_mode', sanitize_text_field($_POST['lumino_card_mode']));
    }
    if (isset($_POST['lumino_project_url'])) {
        update_post_meta($post_id, '_lumino_project_url', esc_url_raw($_POST['lumino_project_url']));
    }
    if (isset($_POST['lumino_project_full_img'])) {
        update_post_meta($post_id, '_lumino_project_full_img', sanitize_text_field($_POST['lumino_project_full_img']));
    }
}
add_action('save_post_portfolio', 'lumino_save_portfolio_metabox');

/**
 * Customizer Controls
 */
function lumino_customize_register($wp_customize) {
    // Section: Lumino Studio Settings
    $wp_customize->add_section('lumino_settings', array(
        'title'    => __('Lumino Studio Options', 'lumino'),
        'priority' => 30,
    ));

    // Studio Name
    $wp_customize->add_setting('lumino_studio_name', array(
        'default'           => 'LUMINO DESIGN STUDIO',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('lumino_studio_name', array(
        'label'    => __('Studio Name (Header)', 'lumino'),
        'section'  => 'lumino_settings',
        'type'     => 'text',
    ));

    // Availability Badge Text
    $wp_customize->add_setting('lumino_status_text', array(
        'default'           => 'Available for work',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('lumino_status_text', array(
        'label'    => __('Status Badge Text', 'lumino'),
        'section'  => 'lumino_settings',
        'type'     => 'text',
    ));

    // Studio Location / City for Live Clock
    $wp_customize->add_setting('lumino_studio_city', array(
        'default'           => 'Chisinau, Moldova',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('lumino_studio_city', array(
        'label'    => __('Studio Location (Clock label)', 'lumino'),
        'section'  => 'lumino_settings',
        'type'     => 'text',
    ));

    // Timezone string (e.g. Europe/Chisinau)
    $wp_customize->add_setting('lumino_studio_timezone', array(
        'default'           => 'Europe/Chisinau',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('lumino_studio_timezone', array(
        'label'       => __('Timezone (e.g. Europe/Chisinau, leave blank for local)', 'lumino'),
        'section'     => 'lumino_settings',
        'type'        => 'text',
    ));

    // Hero Bio
    $wp_customize->add_setting('lumino_hero_bio', array(
        'default'           => "Hi, I'm a visual and UI/UX designer with 20+ completed projects in digital products, websites, and brand identities. Armed with Illustrator, Photoshop, and CorelDRAW, I help brands stand out through clean, user-focused design.",
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('lumino_hero_bio', array(
        'label'    => __('Hero Bio Statement', 'lumino'),
        'section'  => 'lumino_settings',
        'type'     => 'textarea',
    ));

    // Hero Stat 1 (Projects)
    $wp_customize->add_setting('lumino_stat1_num', array('default' => '23', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('lumino_stat1_num', array('label' => __('Stat 1 Number', 'lumino'), 'section' => 'lumino_settings', 'type' => 'text'));
    $wp_customize->add_setting('lumino_stat1_label', array('default' => '+Projects', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('lumino_stat1_label', array('label' => __('Stat 1 Label', 'lumino'), 'section' => 'lumino_settings', 'type' => 'text'));

    // Hero Stat 2 (Years)
    $wp_customize->add_setting('lumino_stat2_num', array('default' => '02', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('lumino_stat2_num', array('label' => __('Stat 2 Number', 'lumino'), 'section' => 'lumino_settings', 'type' => 'text'));
    $wp_customize->add_setting('lumino_stat2_label', array('default' => '+Years', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('lumino_stat2_label', array('label' => __('Stat 2 Label', 'lumino'), 'section' => 'lumino_settings', 'type' => 'text'));

    // Hero Stat 3 (Clients)
    $wp_customize->add_setting('lumino_stat3_num', array('default' => '25', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('lumino_stat3_num', array('label' => __('Stat 3 Number', 'lumino'), 'section' => 'lumino_settings', 'type' => 'text'));
    $wp_customize->add_setting('lumino_stat3_label', array('default' => '+Clients', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('lumino_stat3_label', array('label' => __('Stat 3 Label', 'lumino'), 'section' => 'lumino_settings', 'type' => 'text'));

    // Contact Email
    $wp_customize->add_setting('lumino_contact_email', array(
        'default'           => 'vadimcioclu5@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('lumino_contact_email', array(
        'label'    => __('Contact Email Address', 'lumino'),
        'section'  => 'lumino_settings',
        'type'     => 'email',
    ));
}
add_action('customize_register', 'lumino_customize_register');
