<?php
/**
 * Archive template for Selected Works (Dark Edition)
 *
 * @package Lumino
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="lumino-dark-hero" style="padding-bottom: 20px;">
        <div class="lumino-container">
            <div class="lumino-section-heading-block" style="margin-bottom: 30px;">
                <span class="lumino-badge-red" style="align-self: flex-start;"><?php esc_html_e('Portfolio', 'lumino'); ?></span>
                <h1 class="lumino-section-huge-title" style="font-size: clamp(3rem, 7vw, 6rem);">
                    <?php esc_html_e('Selected Works', 'lumino'); ?>
                </h1>
            </div>
            <p style="font-size: 16px; color: var(--text-secondary); max-width: 700px; line-height: 1.6;">
                <?php esc_html_e('A curated archive of digital products, visual identities, and interactive platforms engineered for forward-thinking clients.', 'lumino'); ?>
            </p>
        </div>
    </section>

    <section class="lumino-dark-works" style="padding-top: 30px;">
        <div class="lumino-container">
            <div class="lumino-dark-grid-3">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
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
                                        <?php the_post_thumbnail('lumino-card-adaptive', array('class' => 'lumino-dark-card__img', 'loading' => 'lazy')); ?>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php
                    endwhile;
                else :
                    $demo = array(
                        array('title' => 'Rhythm Sportswear', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/projects/rhythm_green_card.png'),
                        array('title' => 'Aqua Vital', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/projects/aqua_vital_card.png'),
                        array('title' => 'Ciel & Coffee', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/projects/ciel_coffee_card.png'),
                        array('title' => 'No Rules', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/projects/no_rules_card.png'),
                        array('title' => 'Casa Mare Restaurant', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/projects/casa_mare_card.png'),
                        array('title' => 'Fava Restaurant', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/fava.png'),
                        array('title' => 'Brutar', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/BRUT.png'),
                        array('title' => 'Mira cosmetics', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/MIRA1.png'),
                        array('title' => 'Sora Coffe shop', 'year' => '2026', 'service' => 'Branding', 'img' => get_template_directory_uri() . '/assets/images/sora1.png'),
                    );
                    foreach ($demo as $d) :
                        ?>
                        <article class="lumino-dark-card" data-adaptive="true">
                            <a href="#">
                                <div class="lumino-dark-card__header">
                                    <h3 class="lumino-dark-card__title"><?php echo esc_html($d['title']); ?></h3>
                                    <span class="lumino-dark-card__tag">
                                        <?php echo esc_html($d['year']); ?> &bull; <?php echo esc_html($d['service']); ?>
                                    </span>
                                </div>
                                <div class="lumino-dark-card__frame lumino-dark-card__frame--adaptive">
                                    <img src="<?php echo esc_url($d['img']); ?>" alt="<?php echo esc_attr($d['title']); ?>" class="lumino-dark-card__img" loading="lazy">
                                </div>
                            </a>
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 60px; text-align: center;">
                <?php the_posts_pagination(array(
                    'prev_text' => __('&larr; Previous', 'lumino'),
                    'next_text' => __('Next &rarr;', 'lumino'),
                )); ?>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
