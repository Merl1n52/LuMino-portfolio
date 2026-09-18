<?php
/**
 * Template Name: About Page
 * Template for displaying About Studio information (Dark Edition)
 *
 * @package Lumino
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="lumino-dark-hero">
        <div class="lumino-container">
            <div class="lumino-about-grid">
                <!-- Left Column: Bio & Philosophy -->
                <div>
                    <span class="lumino-badge-red" style="margin-bottom: 24px;"><?php esc_html_e('About Studio', 'lumino'); ?></span>
                    <h1 class="lumino-section-huge-title" style="font-size: clamp(2.5rem, 5.5vw, 4.5rem); margin-top: 16px; margin-bottom: 32px; line-height: 1.05;">
                        <?php esc_html_e('Interfaces designer & creative director crafting digital experiences and visual systems.', 'lumino'); ?>
                    </h1>
                    <p style="font-size: 16px; line-height: 1.7; color: var(--text-secondary); max-width: 620px; margin-bottom: 24px;">
                        <?php esc_html_e('Operating at the intersection of typography, minimalist interfaces, and engineering. Focused on building high-impact brand identities, custom digital tools, and scalable design systems.', 'lumino'); ?>
                    </p>
                    <p style="font-size: 16px; line-height: 1.7; color: var(--text-secondary); max-width: 620px;">
                        <?php esc_html_e("Co-founder of 1988, a hardware art focused studio. Available for select client partnerships, art direction, and digital consulting worldwide.", 'lumino'); ?>
                    </p>
                </div>

                <!-- Right Column: Profile Photo -->
                <div class="lumino-about-photo" style="border: 1px solid var(--border-color);">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/me.jpg'); ?>" alt="Lumino Studio Profile" loading="eager">
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
