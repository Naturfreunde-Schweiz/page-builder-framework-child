<?php
/**
 * Archive
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if (!defined('ABSPATH')) exit;

$grid_gap = get_theme_mod('sidebar_gap', 'medium');

get_header(); ?>

<div id="content">

    <?php do_action('wpbf_content_open'); ?>

    <?php wpbf_inner_content(); ?>

    <?php do_action('wpbf_inner_content_open'); ?>

    <div class="wpbf-grid wpbf-main-grid wpbf-grid-<?php echo esc_attr($grid_gap); ?>">

        <?php do_action('wpbf_sidebar_left'); ?>

        <main id="main" class="wpbf-main wpbf-medium-2-3<?php echo wpbf_archive_class(); // WPCS: XSS ok.?>">

            <?php
            // FacetWP is only installed on the main site. If it is not installed, it breaks the page.
            // Some Sektionswebseiten use the aktivitaeten archive-page but don't have FacetWP.
            ?>

            <?php if (is_main_site()) : ?>

        <?php wpbf_archive_header(); ?>
            
            <p><?php _e('Nebst den vom Landesverband organisierten Naturkursen, bieten auch die Sektionen und Kantonalverbände verschiedene interessante Veranstaltungen an.', 'page-builder-framework-child'); ?></p>

            <div class="wpbf-grid">
                <div class="wpbf-small-1-3">
                    <h4><?php _e('Suche', 'page-builder-framework-child'); ?></h4>
                    <?php if (ICL_LANGUAGE_CODE == "fr") { 
                        echo facetwp_display('facet', 'suche_fr');
                    } else {
                        echo facetwp_display('facet', 'suche_de');
                    }; ?>
                </div>
                <div class="wpbf-small-1-3">
                    <h4><?php _e('Kanton', 'page-builder-framework-child'); ?></h4>
                    <?php if (ICL_LANGUAGE_CODE == "fr") { 
                        echo facetwp_display('facet', 'naturkurs_kanton_fr');
                    } else {
                        echo facetwp_display('facet', 'naturkurs_kanton');
                    }; ?>
                </div>
                <div  class="wpbf-small-1-3">
                    <div class="button-wrapper" style="margin-bottom:30px;"><a id="#sektionsveranstaltungen" class="wpbf-button" href="https://naturfreunde.ch/aktivitaeten/?_aktivitaet_kategorie=veranstaltungen"><?php _e('Sektionsveranstaltungen', 'page-builder-framework-child'); ?></a></div>
                </div>
            </div>

            <div class="facetwp-template">

                <?php endif; //is_main_site ?>

                <?php
                if (have_posts()) :
                    if (!is_main_site()) wpbf_archive_header();
                    do_action('wpbf_before_loop');
                    while (have_posts()) : the_post();
                        get_template_part('inc/template-parts/article');
                    endwhile;
                    do_action('wpbf_after_loop');
                else :
                    get_template_part('inc/template-parts/article-none');
                endif;
                ?>

                <?php if (is_main_site()) : ?>
            </div>

        <?php echo facetwp_display('pager'); ?>

        <?php endif; //is_main_site ?>

            <?php if (!is_main_site()) :
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('&larr; Previous', 'page-builder-framework'),
                    'next_text' => __('Next &rarr;', 'page-builder-framework'),
                ));
            endif; //!is_main_site ?>

        </main>

        <?php do_action('wpbf_sidebar_right'); ?>

    </div>

    <?php do_action('wpbf_inner_content_close'); ?>

    <?php wpbf_inner_content_close(); ?>

    <?php do_action('wpbf_content_close'); ?>

</div>

<?php get_footer(); ?>
