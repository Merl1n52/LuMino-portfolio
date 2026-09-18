<?php
/**
 * Front Page template for Lumino Design Studio (Dark Edition)
 * Replicating the shy-walrus-733223.framer.app aesthetic
 *
 * @package Lumino
 */

get_header();

$studio_name = get_theme_mod('lumino_studio_name', 'LUMINO DESIGN STUDIO');
$hero_bio    = get_theme_mod('lumino_hero_bio', "Hi, I'm a visual and UI/UX designer with 20+ completed projects in digital products, websites, and brand identities. Armed with Illustrator, Photoshop, and CorelDRAW, I help brands stand out through clean, user-focused design.");
$studio_city = get_theme_mod('lumino_studio_city', 'Chisinau, Moldova');
$stat1_num   = get_theme_mod('lumino_stat1_num', '23');
$stat1_label = get_theme_mod('lumino_stat1_label', '+Projects');
$stat2_num   = get_theme_mod('lumino_stat2_num', '02');
$stat2_label = get_theme_mod('lumino_stat2_label', '+Years');
$stat3_num   = get_theme_mod('lumino_stat3_num', '25');
$stat3_label = get_theme_mod('lumino_stat3_label', '+Clients');
?>

<main id="primary" class="site-main">

    <!-- HERO SECTION (DARK WITH INTERACTIVE CANVAS DOT MATRIX) -->
    <section class="lumino-dark-hero">
        <div class="lumino-container">
            <!-- Giant Bold Headline (Single Line) -->
            <h1 class="lumino-giant-title"><?php echo esc_html($studio_name); ?></h1>

            <!-- Interactive Dot Matrix / Halftone Grid Canvas -->
            <div class="lumino-canvas-wrapper" aria-hidden="true">
                <canvas id="lumino-interactive-canvas"></canvas>
            </div>

            <!-- Meta Row: Location / Bio / Social -->
            <div class="lumino-hero-meta-row">
                <div class="lumino-hero-meta__location">
                    <span><?php echo esc_html($studio_city); ?></span>
                </div>

                <div class="lumino-hero-meta__bio">
                    <p><?php echo esc_html($hero_bio); ?></p>
                </div>

                <div class="lumino-hero-meta__social">
                    <a href="https://dribbble.com/Lu_mino" target="_blank" rel="noopener noreferrer" class="lumino-social-icon" aria-label="Dribbble">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"></path>
                            <path d="M21.75 12.84c-6.62-1.41-12.14 1-14.9 7.42"></path>
                            <path d="M8.53 2.74c3.48 4.7 5.25 9.77 5.72 18.52"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- RECENT WORKS SECTION (3-COLUMN ADAPTIVE GRID) -->
    <section id="works" class="lumino-dark-works">
        <div class="lumino-container">
            <div class="lumino-section-header-row">
                <div class="lumino-section-heading-block">
                    <h2 class="lumino-section-huge-title"><?php esc_html_e('Recent Works', 'lumino'); ?></h2>
                    <div>
                        <a href="<?php echo esc_url(get_post_type_archive_link('portfolio') ?: '#works'); ?>" class="lumino-badge-red">
                            <span><?php esc_html_e('View All Works', 'lumino'); ?> &nearr;</span>
                        </a>
                    </div>
                </div>

                <!-- Stats Counters on Right -->
                <div class="lumino-stats-group">
                    <div class="lumino-stat-box">
                        <span class="lumino-stat-box__num"><?php echo esc_html($stat1_num); ?></span>
                        <span class="lumino-stat-box__label"><?php echo esc_html($stat1_label); ?></span>
                    </div>
                    <div class="lumino-stat-box">
                        <span class="lumino-stat-box__num"><?php echo esc_html($stat2_num); ?></span>
                        <span class="lumino-stat-box__label"><?php echo esc_html($stat2_label); ?></span>
                    </div>
                    <div class="lumino-stat-box">
                        <span class="lumino-stat-box__num"><?php echo esc_html($stat3_num); ?></span>
                        <span class="lumino-stat-box__label"><?php echo esc_html($stat3_label); ?></span>
                    </div>
                </div>
            </div>

            <!-- 3-Column Adaptive Grid -->
            <div class="lumino-dark-grid-3">
                <?php
                $portfolio_query = new WP_Query(array(
                    'post_type'      => 'portfolio',
                    'posts_per_page' => 6,
                    'orderby'        => 'menu_order date',
                    'order'          => 'DESC',
                ));

                if ($portfolio_query->have_posts()) :
                    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        $year      = get_post_meta(get_the_ID(), '_lumino_project_year', true);
                        $services  = get_post_meta(get_the_ID(), '_lumino_project_services', true);
                        $card_mode = get_post_meta(get_the_ID(), '_lumino_card_mode', true) ?: 'adaptive';
                        $frame_cls = ($card_mode === 'adaptive') ? 'lumino-dark-card__frame lumino-dark-card__frame--adaptive' : 'lumino-dark-card__frame';
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('lumino-dark-card'); ?> data-adaptive="true">
                            <a href="<?php the_permalink(); ?>">
                                <div class="lumino-dark-card__header">
                                    <h3 class="lumino-dark-card__title"><?php the_title(); ?></h3>
                                    <span class="lumino-dark-card__tag">
                                        <?php if ($year) : echo esc_html($year); endif; ?>
                                        <?php if ($services) : echo ' &bull; ' . esc_html($services); endif; ?>
                                    </span>
                                </div>
                                <div class="<?php echo esc_attr($frame_cls); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('lumino-card-adaptive', array(
                                            'class' => 'lumino-dark-card__img',
                                            'loading' => 'lazy',
                                            'alt' => the_title_attribute(array('echo' => false)),
                                        )); ?>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Default showcase projects using user's adaptive assets
                    $default_projects = array(
                        array(
                            'title'    => 'Rhythm Sportswear',
                            'year'     => '2026',
                            'service'  => 'Branding',
                            'img'      => get_template_directory_uri() . '/assets/images/projects/rhythm_green_card.png',
                        ),
                        array(
                            'title'    => 'Aqua Vital',
                            'year'     => '2026',
                            'service'  => 'Branding',
                            'img'      => get_template_directory_uri() . '/assets/images/projects/aqua_vital_card.png',
                        ),
                        array(
                            'title'    => 'Ciel & Coffee',
                            'year'     => '2026',
                            'service'  => 'Branding',
                            'img'      => get_template_directory_uri() . '/assets/images/projects/ciel_coffee_card.png',
                        ),
                        array(
                            'title'    => 'No Rules',
                            'year'     => '2026',
                            'service'  => 'Branding',
                            'img'      => get_template_directory_uri() . '/assets/images/projects/no_rules_card.png',
                        ),
                        array(
                            'title'    => 'Casa Mare Restaurant',
                            'year'     => '2026',
                            'service'  => 'Branding',
                            'img'      => get_template_directory_uri() . '/assets/images/projects/casa_mare_card.png',
                        ),
                        array(
                            'title'    => 'Fava Restaurant',
                            'year'     => '2026',
                            'service'  => 'Branding',
                            'img'      => get_template_directory_uri() . '/assets/images/fava.png',
                        ),
                    );

                    foreach ($default_projects as $proj) :
                        ?>
                        <article class="lumino-dark-card" data-adaptive="true">
                            <a href="#works">
                                <div class="lumino-dark-card__header">
                                    <h3 class="lumino-dark-card__title"><?php echo esc_html($proj['title']); ?></h3>
                                    <span class="lumino-dark-card__tag">
                                        <?php echo esc_html($proj['year']); ?> &bull; <?php echo esc_html($proj['service']); ?>
                                    </span>
                                </div>
                                <div class="lumino-dark-card__frame lumino-dark-card__frame--adaptive">
                                    <img src="<?php echo esc_url($proj['img']); ?>" alt="<?php echo esc_attr($proj['title']); ?>" class="lumino-dark-card__img" loading="lazy">
                                </div>
                            </a>
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION (DARK WITH RED BADGE) -->
    <section id="services" class="lumino-dark-services">
        <div class="lumino-container">
            <div class="lumino-services-wrapper">
                <div class="lumino-section-heading-block">
                    <h2 class="lumino-section-huge-title"><?php esc_html_e('Services', 'lumino'); ?></h2>
                    <div>
                        <span class="lumino-badge-red"><?php esc_html_e('What I Do', 'lumino'); ?> &nearr;</span>
                    </div>
                </div>

                <div class="lumino-services-grid">
                    <!-- Service 01 -->
                    <div class="lumino-service-card">
                        <span class="lumino-service-card__num">[ 01 ]</span>
                        <h3 class="lumino-service-card__title"><?php esc_html_e('Framer Development', 'lumino'); ?></h3>
                        <p class="lumino-service-card__text">
                            <?php esc_html_e('I build responsive, interactive websites in Framer and WordPress, focusing on performance, smooth animations, and modern design.', 'lumino'); ?>
                        </p>
                    </div>

                    <!-- Service 02 -->
                    <div class="lumino-service-card">
                        <span class="lumino-service-card__num">[ 02 ]</span>
                        <h3 class="lumino-service-card__title"><?php esc_html_e('Branding', 'lumino'); ?></h3>
                        <p class="lumino-service-card__text">
                            <?php esc_html_e('I create cohesive brand identities that resonate with your audience, blending strategy with impactful visuals.', 'lumino'); ?>
                        </p>
                    </div>

                    <!-- Service 03 -->
                    <div class="lumino-service-card">
                        <span class="lumino-service-card__num">[ 03 ]</span>
                        <h3 class="lumino-service-card__title"><?php esc_html_e('UI/UX Design', 'lumino'); ?></h3>
                        <p class="lumino-service-card__text">
                            <?php esc_html_e('I design intuitive and engaging user experiences, focusing on user-centric solutions.', 'lumino'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
