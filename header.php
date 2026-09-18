<?php
/**
 * Header template for Lumino Design Studio (Dark Edition)
 *
 * @package Lumino
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$studio_name   = get_theme_mod('lumino_studio_name', 'LUMINO DESIGN STUDIO');
$contact_email = get_theme_mod('lumino_contact_email', 'vadimcioclu5@gmail.com');
?>

<!-- Minimal Dark Top Bar -->
<header class="lumino-top-bar">
    <div class="lumino-container">
        <div class="lumino-top-bar__inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="lumino-logo-pill">
                <?php esc_html_e('Lumino', 'lumino'); ?>
            </a>

            <!-- 3-Line Hamburger Toggle (Donor Style) -->
            <button id="lumino-top-toggle" class="lumino-top-nav-toggle" aria-label="<?php esc_attr_e('Open Menu', 'lumino'); ?>">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<!-- Split-Screen / Side Drawer Menu (Donor Style) -->
<div id="lumino-menu-backdrop" class="lumino-menu-backdrop" aria-hidden="true"></div>

<aside id="lumino-drawer-menu" class="lumino-drawer" aria-label="<?php esc_attr_e('Main Navigation', 'lumino'); ?>" aria-hidden="true">
    <!-- Left Black Column with Brand Letters & Matrix -->
    <div class="lumino-drawer__side">
        <div class="lumino-drawer__brand">
            <span>L</span>
            <span>U</span>
            <span>M</span>
            <span>I</span>
            <span>N</span>
            <span>O</span>
        </div>
        <div class="lumino-drawer__matrix" aria-hidden="true">
            <div class="lumino-matrix-grid">
                <?php for ($i = 0; $i < 40; $i++): ?>
                    <span class="lumino-matrix-dot"></span>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Right Light Column with Navigation & Contact -->
    <div class="lumino-drawer__main">
        <!-- Close Button (X) -->
        <div class="lumino-drawer__header">
            <button id="lumino-drawer-close" class="lumino-drawer-close" aria-label="<?php esc_attr_e('Close Menu', 'lumino'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Navigation Links 01..04 -->
        <nav class="lumino-drawer__nav">
            <ul class="lumino-drawer__list">
                <li class="lumino-drawer__item">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="lumino-drawer__link">
                        <span class="lumino-drawer__num">01</span>
                        <span class="lumino-drawer__text"><?php esc_html_e('HOME', 'lumino'); ?></span>
                    </a>
                </li>
                <li class="lumino-drawer__item">
                    <a href="<?php echo esc_url(home_url('/#works')); ?>" class="lumino-drawer__link">
                        <span class="lumino-drawer__num">02</span>
                        <span class="lumino-drawer__text"><?php esc_html_e('WORKS', 'lumino'); ?></span>
                    </a>
                </li>
                <li class="lumino-drawer__item">
                    <a href="<?php echo esc_url(home_url('/about/')); ?>" class="lumino-drawer__link">
                        <span class="lumino-drawer__num">03</span>
                        <span class="lumino-drawer__text"><?php esc_html_e('ABOUT', 'lumino'); ?></span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Footer / Contact Stack -->
        <div class="lumino-drawer__footer">
            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="lumino-drawer-email-btn" id="lumino-copy-email" data-email="<?php echo esc_attr($contact_email); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
                <span class="lumino-email-text"><?php echo esc_html($contact_email); ?></span>
            </a>

            <div class="lumino-drawer-socials">
                <a href="https://dribbble.com/Lu_mino" target="_blank" rel="noopener noreferrer" aria-label="Dribbble">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"></path>
                        <path d="M21.75 12.84c-6.62-1.41-12.14 1-14.9 7.42"></path>
                        <path d="M8.53 2.74c3.48 4.7 5.25 9.77 5.72 18.52"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</aside>
