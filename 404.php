<?php
/**
 * 404 Error page template (matching Operator /404)
 *
 * @package Lumino
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="lumino-container">
        <section class="lumino-404">
            <h1 class="lumino-404__num">404</h1>
            <p class="lumino-404__msg"><?php esc_html_e("This page doesn't exist", 'lumino'); ?></p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="lumino-btn-contact">
                <?php esc_html_e('Back to Home', 'lumino'); ?>
            </a>
        </section>
    </div>
</main>

<?php
get_footer();
