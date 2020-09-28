<?php
/**
 * Archive
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

        <main id="main" class="wpbf-main<?php echo wpbf_archive_class(); // WPCS: XSS ok.?>">

            <?php
            // FacetWP is only installed on the main site. If it is not installed, it breaks the page.
            // Some Sektionswebseiten use the aktivitaeten archive-page but don't have FacetWP.
            ?>

            <?php if (is_main_site()) : ?>

        <?php wpbf_archive_header(); ?>

            <div class="wpbf-grid">
                <div class="wpbf-small-1-1">
                    <?php echo facetwp_display('facet', 'haus_karte'); ?>
                </div>
                <div class="wpbf-small-2-3">
                    <h4><?php _e('Suche', 'page-builder-framework-child'); ?></h4>
                    <?php if (ICL_LANGUAGE_CODE == "fr") { 
                        echo facetwp_display('facet', 'suche_fr');
                    } else {
                        echo facetwp_display('facet', 'suche_de');
                    }; ?>
                </div>
                <div class="wpbf-small-1-3">
                    <h4><?php _e('Schlafplätze', 'page-builder-framework-child'); ?></h4>
                    <?php echo facetwp_display('facet', 'haus_schlafplaetze'); ?>
                </div>
                <div class="wpbf-small-1-3">
                    <h4><?php _e('Tourismusregion', 'page-builder-framework-child'); ?></h4>
                    <?php if (ICL_LANGUAGE_CODE == "fr") { 
                        echo facetwp_display('facet', 'haus_tourismusregion_fr');
                    } else {
                        echo facetwp_display('facet', 'haus_tourismusregion');
                    }; ?>
                </div>
                <!-- here be aktivitäten -->
                <div class="wpbf-small-1-3">
                    <h4><?php _e('Haustyp', 'page-builder-framework-child'); ?></h4>
                    <?php echo facetwp_display('facet', 'haus_kategorie'); ?>
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

    <?php do_action('wpbf_inner_content_close'); ?>

    <?php wpbf_inner_content_close(); ?>

    <?php do_action('wpbf_content_close'); ?>

</div>

<?php get_footer(); ?>
