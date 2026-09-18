<?php
/**
 * Template for displaying a Single Portfolio Project (Dark Edition)
 *
 * @package Lumino
 */

get_header();

while (have_posts()) : the_post();
    $year        = get_post_meta(get_the_ID(), '_lumino_project_year', true) ?: '2024';
    $services    = get_post_meta(get_the_ID(), '_lumino_project_services', true) ?: 'Brand Design / Logo';
    $client      = get_post_meta(get_the_ID(), '_lumino_project_client', true) ?: 'Studio Partner';
    $project_url = get_post_meta(get_the_ID(), '_lumino_project_url', true);
    $next_post   = get_next_post(true, '', 'portfolio_category') ?: get_next_post();
?>

<main id="primary" class="site-main">

    <!-- PROJECT HEADER / INFO BAR -->
    <section class="lumino-dark-hero" style="padding-bottom: 40px;">
        <div class="lumino-container">
            <span class="lumino-badge-red" style="margin-bottom: 20px;"><?php esc_html_e('Case Study', 'lumino'); ?></span>
            <h1 class="lumino-section-huge-title" style="font-size: clamp(3rem, 7vw, 6.5rem); margin-top: 14px; margin-bottom: 40px;">
                <?php the_title(); ?>
            </h1>

            <div class="lumino-project-info-grid" style="padding-top: 30px; border-top: 1px solid var(--border-color);">
                <div class="lumino-info-block">
                    <p class="lumino-info-block__label" style="color: var(--text-secondary);"><?php esc_html_e('Year', 'lumino'); ?></p>
                    <p class="lumino-info-block__val" style="color: var(--text-primary); font-weight: 600;"><?php echo esc_html($year); ?></p>
                </div>
                <div class="lumino-info-block">
                    <p class="lumino-info-block__label" style="color: var(--text-secondary);"><?php esc_html_e('Services', 'lumino'); ?></p>
                    <p class="lumino-info-block__val" style="color: var(--text-primary); font-weight: 600;"><?php echo esc_html($services); ?></p>
                </div>
                <div class="lumino-info-block">
                    <p class="lumino-info-block__label" style="color: var(--text-secondary);"><?php esc_html_e('Client', 'lumino'); ?></p>
                    <p class="lumino-info-block__val" style="color: var(--text-primary); font-weight: 600;"><?php echo esc_html($client); ?></p>
                </div>
                <div class="lumino-info-block">
                    <p class="lumino-info-block__label" style="color: var(--text-secondary);"><?php esc_html_e('Role', 'lumino'); ?></p>
                    <p class="lumino-info-block__val" style="color: var(--text-primary); font-weight: 600;"><?php esc_html_e('Lead Designer', 'lumino'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- PROJECT CONTENT & MEDIA SHOWCASE -->
    <section class="lumino-project-content" style="padding-top: 40px;">
        <div class="lumino-container">
            <?php if (has_excerpt()) : ?>
                <div class="lumino-project-lead" style="color: var(--text-primary); font-size: 22px; line-height: 1.5; margin-bottom: 30px;">
                    <p><?php echo get_the_excerpt(); ?></p>
                </div>
            <?php endif; ?>

            <div class="lumino-project-body" style="color: var(--text-secondary); font-size: 16px; line-height: 1.8; margin-bottom: 60px;">
                <?php the_content(); ?>
            </div>

            <!-- Showcase Gallery (Supports long visual scrolls) -->
            <div class="lumino-project-gallery">
                <?php
                $full_img = get_post_meta(get_the_ID(), '_lumino_project_full_img', true);
                if (!$full_img) {
                    $slug  = get_post_field('post_name', get_the_ID());
                    $title = strtolower(get_the_title());
                    $map   = array(
                        'rhythm'     => 'projects/rhythm_full.png',
                        'aqua'       => 'projects/aqua_vital_full.png',
                        'vital'      => 'projects/aqua_vital_full.png',
                        'ciel'       => 'projects/ciel_coffee_full.png',
                        'coffee'     => 'projects/ciel_coffee_full.png',
                        'rule'       => 'projects/no_rules_full.png',
                        'casa'       => 'projects/casa_mare_full.png',
                        'mare'       => 'projects/casa_mare_full.png',
                        'brutar'     => 'BRUTAR.png',
                        'fava'       => 'fava.png',
                        'mira'       => 'MIRA1.png',
                        'sora'       => 'sora1.png',
                    );
                    foreach ($map as $k => $file) {
                        if (strpos($slug, $k) !== false || strpos($title, $k) !== false) {
                            $full_img = get_template_directory_uri() . '/assets/images/' . $file;
                            break;
                        }
                    }
                }

                if ($full_img) :
                ?>
                    <div class="lumino-gallery-item" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; margin-bottom: 40px;">
                        <img src="<?php echo esc_url($full_img); ?>" alt="<?php the_title_attribute(); ?> Presentation" loading="eager" style="width: 100%; height: auto; display: block;">
                    </div>
                <?php elseif (has_post_thumbnail()) : ?>
                    <div class="lumino-gallery-item" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; margin-bottom: 40px;">
                        <?php the_post_thumbnail('lumino-full-showcase', array('loading' => 'eager', 'style' => 'width: 100%; height: auto; display: block;')); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Navigation to Next Project -->
            <div style="margin-top: 80px; padding-top: 40px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <a href="<?php echo esc_url(home_url('/#works')); ?>" class="lumino-section-link" style="color: var(--text-secondary);">
                    &larr; <?php esc_html_e('All Projects', 'lumino'); ?>
                </a>

                <?php if ($next_post) : ?>
                    <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="lumino-section-link" style="color: var(--text-primary);">
                        <span><?php esc_html_e('Next Project', 'lumino'); ?>: <?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; margin-left: 6px;">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<?php
endwhile;

get_footer();
