<?php
/**
 * Main Template Fallback for Lumino Design Studio
 *
 * @package Lumino
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="lumino-container" style="padding-top: 80px; padding-bottom: 80px;">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 60px;">
                    <h1 class="lumino-project-title" style="margin-bottom: 24px;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h1>
                    <div class="lumino-project-body">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;

            the_posts_pagination();
        else :
            ?>
            <p><?php esc_html_e('No content found.', 'lumino'); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
