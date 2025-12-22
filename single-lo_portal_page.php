<?php
/**
 * Template for LO Portal Pages
 *
 * Uses Blocksy's native header/footer structure with portal sidebar overlay
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add body class for portal styling
add_filter('body_class', function($classes) {
    $classes[] = 'has-portal-sidebar';
    return $classes;
});

get_header();

if (have_posts()) {
    the_post();
    the_content();
}

get_footer();
