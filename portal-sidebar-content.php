<?php
/**
 * Portal Sidebar Content
 * PHP + vanilla JS version with all React design elements preserved
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();

// DEBUG: Log user info (remove after testing)
error_log("Portal Sidebar - User ID: {$current_user->ID}, Display Name: {$current_user->display_name}");

// Try to get profile data from frs-users API first
$profile_data = null;
if ($current_user->ID > 0) {
    $api_url = rest_url("frs-users/v1/profiles/user/{$current_user->ID}");
    $response = wp_remote_get($api_url, array('timeout' => 5));

    // DEBUG: Log API response
    error_log("Portal Sidebar - API URL: {$api_url}");
    error_log("Portal Sidebar - API Response Code: " . wp_remote_retrieve_response_code($response));

    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['success']) && $body['success'] && isset($body['data'])) {
            $profile_data = $body['data'];
            error_log("Portal Sidebar - Got profile data from API");
        }
    }
}

// Set user data - prefer API data, fallback to WordPress data
if ($profile_data) {
    $user_avatar = $profile_data['profile_photo'] ?? get_avatar_url($current_user->ID, ['size' => 200]);
    $user_name = trim(($profile_data['first_name'] ?? '') . ' ' . ($profile_data['last_name'] ?? '')) ?: $current_user->display_name;
    $user_job_title = $profile_data['job_title'] ?? 'Loan Officer';
    error_log("Portal Sidebar - Using API data - Name: {$user_name}, Title: {$user_job_title}");
} else {
    $user_avatar = get_avatar_url($current_user->ID, ['size' => 200]);
    $user_name = $current_user->display_name;
    $user_job_title = get_user_meta($current_user->ID, 'job_title', true) ?: 'Loan Officer';
    error_log("Portal Sidebar - Using fallback data - Name: {$user_name}, Title: {$user_job_title}");
}

// Get gradient video URL from plugin constant
$gradient_url = '';
if (defined('LRH_URL')) {
    $gradient_url = LRH_URL . 'assets/images/Blue-Dark-Blue-Gradient-Color-and-Style-Video-Background-1.mp4';
}

// Calculate profile completion percentage
$profile_completion = 0;
$total_fields = 0;
$completed_fields = 0;

// Define required profile fields to check
$profile_fields = array(
    'first_name' => $current_user->user_firstname,
    'last_name' => $current_user->user_lastname,
    'user_email' => $current_user->user_email,
    'description' => get_user_meta($current_user->ID, 'description', true), // Bio
    'job_title' => get_user_meta($current_user->ID, 'job_title', true),
    'phone' => get_user_meta($current_user->ID, 'phone', true),
    'company' => get_user_meta($current_user->ID, 'company', true),
    'nmls_id' => get_user_meta($current_user->ID, 'nmls_id', true),
    'facebook' => get_user_meta($current_user->ID, 'facebook', true),
    'twitter' => get_user_meta($current_user->ID, 'twitter', true),
    'linkedin' => get_user_meta($current_user->ID, 'linkedin', true),
);

// Count total and completed fields
foreach ($profile_fields as $field_value) {
    $total_fields++;
    if (!empty($field_value)) {
        $completed_fields++;
    }
}

// Calculate percentage
if ($total_fields > 0) {
    $profile_completion = round(($completed_fields / $total_fields) * 100);
}

$profile_slug = $current_user->user_nicename;

// Get user role
$user_roles = $current_user->roles;
$role = '';
if (in_array('loan_officer', $user_roles)) {
    $role = 'loan_officer';
} elseif (in_array('realtor_partner', $user_roles)) {
    $role = 'realtor';
} elseif (in_array('administrator', $user_roles)) {
    $role = 'admin';
}
?>

<div id="portal-sidebar-root" class="overflow-hidden scrollbar-hide flex flex-col" style="height: calc(100dvh - 60px); background-color: #0B102C;">

    <!-- Gradient Header with Avatar (Horizontal Layout) -->
    <div class="relative overflow-hidden" style="background-color: #0B102C; width: 320px; height: 100px;">
        <!-- Animated Video Background -->
        <?php if ($gradient_url): ?>
        <video autoplay muted loop playsinline class="absolute inset-0 object-cover" style="z-index: 0; width: 320px; height: 100px;">
            <source src="<?php echo esc_url($gradient_url); ?>" type="video/mp4">
        </video>
        <!-- Glassy overlay -->
        <div class="absolute inset-0" style="z-index: 1; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);"></div>
        <?php endif; ?>

        <!-- Avatar and Name - Horizontal Layout -->
        <div class="relative w-full h-full px-4 flex items-center justify-center gap-3" style="z-index: 10;">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="w-[42px] h-[42px] rounded-full overflow-hidden shadow-lg border-2 border-white/20">
                    <img src="<?php echo esc_url($user_avatar); ?>" alt="<?php echo esc_attr($user_name); ?>" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Name and Title -->
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-white text-base mb-0.5 truncate"><?php echo esc_html($user_name); ?></h3>
                <p class="font-normal text-white text-sm truncate"><?php echo esc_html($user_job_title); ?></p>
            </div>
        </div>
    </div>

    <!-- Sidebar content - split into scrollable menu and fixed bottom widgets -->
    <div class="flex-1 overflow-y-auto scrollbar-hide flex flex-col">

        <!-- Menu items - take available space -->
        <nav class="flex flex-col flex-1 pt-4" id="portal-nav">
            <?php
            // Display WordPress menu if available, otherwise show fallback
            if (has_nav_menu('lrh_lo_portal_menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'lrh_lo_portal_menu',
                    'container' => false,
                    'menu_class' => '',
                    'items_wrap' => '%3$s',
                    'walker' => new Portal_Nav_Walker(),
                ));
            } else {
                // Fallback to hardcoded menu if WordPress menu not configured
                echo '<div class="px-4 py-3 text-xs text-white/50">No menu configured. Go to Appearance → Menus and assign a menu to "LO Portal Sidebar Menu"</div>';
            }
            ?>
        </nav>

        <!-- Bottom widgets - stick to bottom -->
        <div class="mt-auto">
            <!-- Profile Completion Widget -->
            <div class="relative overflow-hidden" style="min-height: 80px; background: <?php echo $gradient_url ? 'transparent' : 'linear-gradient(135deg, #2563eb 0%, #2dd4da 100%)'; ?>;">
                <?php if ($gradient_url): ?>
                <!-- Video Background -->
                <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover" style="z-index: 0;">
                    <source src="<?php echo esc_url($gradient_url); ?>" type="video/mp4">
                </video>
                <!-- Glassy overlay -->
                <div class="absolute inset-0" style="z-index: 1; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);"></div>
                <?php endif; ?>

                <div class="relative px-4 py-3" style="z-index: 10;">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-semibold text-white uppercase tracking-wider drop-shadow-md">Profile Completion</div>
                        <div class="text-sm font-semibold text-white drop-shadow-md"><?php echo esc_html($profile_completion); ?>%</div>
                    </div>
                    <div class="w-full bg-white/30 rounded-full h-2">
                        <div class="h-2 rounded-full bg-white" style="width: <?php echo esc_attr($profile_completion); ?>%;"></div>
                    </div>
                </div>
            </div>

            <!-- Profile Link Widget -->
            <div class="px-4 py-3" style="background-color: #0B102C;">
                <div class="text-xs font-semibold text-white uppercase tracking-wider mb-2">Profile Link</div>
                <div class="text-sm text-white mb-2 p-2 bg-white/10 rounded border border-[#0B102C] truncate">
                    <?php echo esc_html($profile_slug); ?>
                </div>
                <div class="flex gap-2">
                    <button onclick="copyProfileLink()" class="flex-1 px-3 py-2 text-sm font-medium text-white bg-slate-500 hover:bg-slate-400 rounded-md transition-colors flex items-center justify-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                        Copy
                    </button>
                    <button onclick="openProfileLink()" class="flex-1 px-3 py-2 text-sm font-medium text-white bg-slate-500 hover:bg-slate-400 rounded-md transition-colors flex items-center justify-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                        Open
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Profile data from PHP
const profileSlug = <?php echo json_encode($profile_slug); ?>;
const profileUrl = window.location.origin + '/directory/' + profileSlug;

// Toggle menu function
function toggleMenu(menuId, event) {
    const menu = document.getElementById('menu-' + menuId);
    if (!menu) return;

    const button = event ? event.currentTarget : document.querySelector(`button[onclick*="toggleMenu('${menuId}')"]`);
    const chevron = button ? button.querySelector('.frs-chevron') : null;

    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        if (chevron) chevron.style.transform = 'rotate(90deg)';
    } else {
        menu.style.display = 'none';
        if (chevron) chevron.style.transform = 'rotate(0deg)';
    }
}

// Copy profile link
function copyProfileLink() {
    navigator.clipboard.writeText(profileUrl).then(() => {
        showToast('Profile link copied!');
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}

// Open profile link
function openProfileLink() {
    window.open(profileUrl, '_blank', 'noopener,noreferrer');
}

// Show toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-20 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Set active link based on current URL and auto-expand parent menus
function setActiveLink() {
    const currentPath = window.location.pathname;
    const links = document.querySelectorAll('.frs-nav-link');

    links.forEach(link => {
        const href = link.getAttribute('href');
        if (currentPath === href || currentPath.startsWith(href + '/')) {
            link.classList.add('active');

            // If this is a child link, auto-expand its parent menu
            const submenu = link.closest('.frs-submenu');
            if (submenu) {
                submenu.style.display = 'block';
                // Rotate the parent's chevron
                const menuId = submenu.id.replace('menu-', '');
                const parentButton = document.querySelector(`button[onclick*="${menuId}"]`);
                if (parentButton) {
                    const chevron = parentButton.querySelector('.frs-chevron');
                    if (chevron) {
                        chevron.style.transform = 'rotate(90deg)';
                    }
                }
            }
        } else {
            link.classList.remove('active');
        }
    });
}

// Initialize on load
setActiveLink();

// Update active link on navigation
window.addEventListener('popstate', setActiveLink);
</script>

<style>
/* Active link styling with darker shading */
.frs-nav-link.active {
    background: rgba(255, 255, 255, 0.15) !important;
    color: white !important;
    border-right: 3px solid rgba(255, 255, 255, 0.5);
}

/* Hover state - lighter shading */
.frs-nav-link:hover:not(.active) {
    background: rgba(255, 255, 255, 0.05) !important;
}

/* Smooth transitions */
.frs-nav-link, .frs-nav-button {
    transition: all 0.2s ease-in-out;
}

.frs-chevron {
    transition: transform 0.2s ease-in-out;
}

/* CSS View Transitions */
@supports (view-transition-name: none) {
    ::view-transition-old(root),
    ::view-transition-new(root) {
        animation-duration: 0.3s;
    }

    ::view-transition-old(root) {
        animation-name: fade-out;
    }

    ::view-transition-new(root) {
        animation-name: fade-in;
    }

    @keyframes fade-out {
        to {
            opacity: 0;
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
        }
    }
}
</style>
