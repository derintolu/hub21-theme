<?php
/**
 * Portal Sidebar Frame
 *
 * Persistent 320px sidebar frame that stays fixed on all portal pages
 *
 * @package Blocksy_Child_FRS
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<!-- Portal Header Bar - Spans Full Width -->
<div class="portal-header-bar">
    <!-- Content Header (Stretches Right) -->
    <div class="portal-header-content">
        <h1 class="portal-page-title"><?php echo esc_html(get_the_title()); ?></h1>
    </div>
</div>

<!-- Portal Sidebar Frame - 320px Left Side -->
<div class="portal-sidebar-frame">
    <?php include get_stylesheet_directory() . '/portal-sidebar-content.php'; ?>
</div><style>
/* Portal Sidebar - Using theme.json custom properties */
:root {
    --portal-sidebar-width: var(--wp--custom--sidebar--width, 320px);
    --portal-sidebar-width-collapsed: var(--wp--custom--sidebar--width-collapsed, 64px);
    --portal-sidebar-bg: var(--wp--custom--sidebar--background, var(--wp--preset--color--portal-dark, #0B102C));
    --portal-header-height: var(--wp--custom--sidebar--header-height, 80px);
    --portal-bar-height: var(--wp--custom--sidebar--portal-header-height, 60px);
    --portal-header-bg: var(--wp--preset--color--portal-header, #dce2eb);
    --portal-border-color: var(--wp--preset--color--portal-border, #a8b4c8);
    --portal-z-index: var(--wp--custom--sidebar--z-index, 100);
    --portal-transition: var(--wp--custom--sidebar--transition, all 0.3s ease);
    --portal-glass-bg: var(--wp--custom--glass--background, rgba(255, 255, 255, 0.1));
    --portal-glass-blur: var(--wp--custom--glass--backdrop-filter, blur(2px));
}

/* Portal Sidebar Frame */
.portal-sidebar-frame {
    position: fixed;
    top: var(--portal-header-height);
    left: 0;
    width: var(--portal-sidebar-width);
    height: calc(100vh - var(--portal-header-height));
    background: var(--portal-sidebar-bg);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    border-right: 1px solid var(--portal-border-color);
    box-shadow: 2px 0 4px rgba(168, 180, 200, 0.1);
    z-index: var(--portal-z-index);
    transition: var(--portal-transition);
}

/* Portal Header Bar */
.portal-header-bar {
    position: fixed;
    top: var(--portal-header-height);
    left: var(--portal-sidebar-width);
    right: 0;
    display: flex;
    height: var(--portal-bar-height);
    background: var(--portal-header-bg);
    border-bottom: 1px solid var(--portal-border-color);
    box-shadow: 0 2px 4px rgba(168, 180, 200, 0.15);
    z-index: calc(var(--portal-z-index) - 1);
    transition: var(--portal-transition);
}

/* Admin bar adjustments */
body.admin-bar .portal-sidebar-frame {
    top: calc(var(--portal-header-height) + 32px);
    height: calc(100vh - var(--portal-header-height) - 32px);
}

body.admin-bar .portal-header-bar {
    top: calc(var(--portal-header-height) + 32px);
}

.portal-header-content {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 0 var(--wp--preset--spacing--60, 2rem);
}

.portal-page-title {
    margin: 0;
    font-size: var(--wp--preset--font-size--lg, 20px);
    font-weight: 600;
    color: var(--wp--preset--color--portal-dark, #0b102c);
}

.portal-sidebar-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    background: var(--portal-sidebar-bg);
}

#lrh-portal-sidebar-root,
#portal-sidebar-root {
    background: var(--portal-sidebar-bg);
    min-height: 100%;
}

body.has-portal-sidebar .site-main {
    margin-left: var(--portal-sidebar-width);
    margin-top: 0;
    padding: var(--wp--preset--spacing--60, 2rem);
    padding-top: calc(var(--portal-bar-height) + var(--wp--preset--spacing--40, 1rem));
    min-height: calc(100vh - var(--portal-header-height) - var(--portal-bar-height));
    transition: var(--portal-transition);
}

/* Collapsed sidebar state */
body.has-portal-sidebar.sidebar-collapsed .portal-sidebar-frame {
    width: var(--portal-sidebar-width-collapsed);
}

body.has-portal-sidebar.sidebar-collapsed .portal-header-bar {
    left: var(--portal-sidebar-width-collapsed);
}

body.has-portal-sidebar.sidebar-collapsed .site-main {
    margin-left: var(--portal-sidebar-width-collapsed);
}

/* Mobile admin bar is taller (46px) below 783px */
@media (max-width: 782px) {
    body.admin-bar .portal-sidebar-frame {
        top: calc(var(--portal-header-height) + 46px);
        height: calc(100vh - var(--portal-header-height) - 46px);
    }

    body.admin-bar .portal-header-bar {
        top: calc(var(--portal-header-height) + 46px);
    }
}

@media (max-width: 768px) {
    .portal-sidebar-frame {
        transform: translateX(-100%);
        width: var(--portal-sidebar-width);
    }

    .portal-sidebar-frame.mobile-open {
        transform: translateX(0);
    }

    .portal-header-bar {
        left: 0;
    }

    body.has-portal-sidebar .site-main {
        margin-left: 0;
        padding: 0;
        padding-top: var(--portal-bar-height);
    }
}
</style>
