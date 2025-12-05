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
/* Portal Header Bar - Spans Full Width */
.portal-header-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    width: 100%;
    height: 60px;
    background: #dce2eb;
    border-bottom: 1px solid #a8b4c8;
    box-shadow: 0 2px 4px rgba(168, 180, 200, 0.15);
    z-index: 1000;
}

.portal-header-bar::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(to bottom, rgba(168, 180, 200, 0.2), transparent);
}

.portal-header-content {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 0 2rem;
    margin-left: 320px;
}

.portal-page-title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #0b102c;
}

/* Portal Sidebar Frame */
.portal-sidebar-frame {
    position: fixed;
    top: 0;
    left: 0;
    width: 320px;
    height: 100vh;
    background: #0b102c;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    border-right: 1px solid #a8b4c8;
    box-shadow: 2px 0 4px rgba(168, 180, 200, 0.1);
    z-index: 1001;
}

.portal-sidebar-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    background: #0b102c;
}

#lrh-portal-sidebar-root {
    background: #0b102c;
    min-height: 100%;
}

/* Hide default header on portal pages */
body.has-portal-sidebar .ct-header,
body.has-portal-sidebar header[data-id] {
    display: none !important;
}

body.has-portal-sidebar #main-container {
    margin-top: 60px !important;
    padding: 2rem !important;
    margin-left: 320px !important;
    min-height: calc(100vh - 60px);
}


@media (max-width: 768px) {
    .portal-header-bar {
        height: 56px;
    }

    .portal-header-logo {
        width: 200px;
    }

    .portal-sidebar-frame {
        display: none;
    }

    body.has-portal-sidebar #main-container {
        display: block;
        height: auto;
        overflow: visible;
    }
}
</style>
