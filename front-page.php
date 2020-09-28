<?php
/**
 * Home
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if (!defined('ABSPATH')) exit;

get_header(); ?>

<div id="content">

    <?php do_action('wpbf_content_open'); ?>

    <?php wpbf_inner_content(); ?>

    <?php do_action('wpbf_inner_content_open'); ?>

    <main id="main" class="wpbf-main<?php echo wpbf_singular_class(); // WPCS: XSS ok. ?>">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div class="entry-content" itemprop="text">

                <!-- Slider -->
                <?php if (have_rows('slider')): ?>

                    <div class="front-slider wpbf-no-sidebar alignfull">
                        <?php while (have_rows('slider')) : the_row(); ?>

                            <?php
                            // vars
                            $bild = get_sub_field('bild');
                            $titel = get_sub_field('titel');
                            $link = get_sub_field('link');
                            ?>

                            <div class="slide slick-slide" style="background-image:url(<?php echo $bild['sizes']['front-slider']; ?>)">
                                <div class="slide-content">
                                    <h2 class="slider-titel"><?php echo $titel; ?></h2>
                                    <?php if ($link): ?>
                                        <?php
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a class="wpbf-button" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                                            <?php echo esc_html($link_title); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endwhile; ?>

                    </div>

                <?php endif; ?>

                <section class="content"><?php the_content(); ?></section>

                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('Pages:', 'page-builder-framework'),
                    'after' => '</div>',
                ));
                ?>

            </div>

        <?php endwhile; endif; ?>

        <?php do_action('wpbf_before_comments'); ?>

        <?php comments_template(); ?>

        <?php do_action('wpbf_after_comments'); ?>

    </main>

    <?php do_action('wpbf_inner_content_close'); ?>

    <?php wpbf_inner_content_close(); ?>

    <?php do_action('wpbf_content_close'); ?>

</div>

<?php get_footer(); ?>
