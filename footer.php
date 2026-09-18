<?php
/**
 * Footer template for Lumino Design Studio (Dark Edition)
 *
 * @package Lumino
 */

$studio_city = get_theme_mod('lumino_studio_city', 'Chisinau, Moldova');
$studio_tz   = get_theme_mod('lumino_studio_timezone', 'Europe/Chisinau');
$status_text = get_theme_mod('lumino_status_text', 'Available for work');
?>

<!-- FLOATING BOTTOM DOCK NAVIGATION (shy-walrus donor style) -->
<nav class="lumino-dock-wrapper" aria-label="<?php esc_attr_e('Floating Navigation Dock', 'lumino'); ?>">
    <div class="lumino-dock">
        <!-- Status Pill -->
        <div class="lumino-dock__status">
            <span class="lumino-dock__dot"></span>
            <span><?php echo esc_html($status_text); ?></span>
        </div>

        <div class="lumino-dock__divider"></div>

        <!-- Navigation Links -->
        <ul class="lumino-dock__menu">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>"><?php esc_html_e('Home', 'lumino'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/#works')); ?>"><?php esc_html_e('Works', 'lumino'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('About', 'lumino'); ?></a></li>
        </ul>

        <div class="lumino-dock__divider"></div>

        <!-- Live Clock & Dribbble -->
        <div class="lumino-dock__meta">
            <span id="lumino-live-clock" class="lumino-dock__time" data-timezone="<?php echo esc_attr($studio_tz); ?>">7:00 AM</span>
            <span><?php echo esc_html($studio_city); ?></span>
            <a href="https://dribbble.com/Lu_mino" target="_blank" rel="noopener noreferrer" class="lumino-dock__dribbble" aria-label="Dribbble">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"></path>
                    <path d="M21.75 12.84c-6.62-1.41-12.14 1-14.9 7.42"></path>
                    <path d="M8.53 2.74c3.48 4.7 5.25 9.77 5.72 18.52"></path>
                </svg>
            </a>
        </div>
    </div>
</nav>

<?php wp_footer(); ?>
</body>
</html>
