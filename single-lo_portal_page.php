<?php
/**
 * Template for LO Portal Pages
 *
 * All pages with custom post type 'lo_portal_page' (URLs like /lo/*)
 * will use this template with the portal sidebar and frame layout.
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

// Don't show default header/footer - we have custom portal frame
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div data-wp-interactive="frsPortal">
<?php
// Include the portal sidebar frame
include get_stylesheet_directory() . '/portal-sidebar-frame.php';

// Output the page content
if (have_posts()) {
    the_post();
    ?>
    <div id="main-container" data-wp-router-region="portal-content">
        <?php the_content(); ?>
    </div>
    <?php
}
?>
</div>

<?php
wp_footer();
?>

</body>
</html>
