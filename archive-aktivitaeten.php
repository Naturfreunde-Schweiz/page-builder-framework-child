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

        <main id="main" class="wpbf-main<?php echo wpbf_archive_class(); ?>">

            <?php
            // FacetWP is only installed on a few sites. If it is not installed, it breaks the page.
            // Some Sektionswebseiten use the aktivitaeten archive-page but don't have FacetWP.
            ?>
            
            <?php 
            $blog_id = get_current_blog_id(); 
            wpbf_archive_header(); 
            $usedFacet = false;
            ?>

            <div class="wpbf-grid">

                <?php if ($blog_id == 1) : 
                    $usedFacet = true; ?>

                    <div class="wpbf-small-1-3">
                        <h4><?php _e('Kanton', 'page-builder-framework-child'); ?></h4>
                        <?php if (ICL_LANGUAGE_CODE == "fr") { 
                            echo facetwp_display('facet', 'aktivitaet_kanton_fr');
                        } else {
                            echo facetwp_display('facet', 'aktivitaet_kanton');
                        }; ?>
                    </div>

                <?php endif; ?>
                
                <?php if ($blog_id == 1 or $blog_id == 6 or $blog_id == 7 or $blog_id == 16 or $blog_id == 18 or $blog_id == 22) : 
                    $usedFacet = true; ?>

                    <div class="wpbf-small-1-3">
                        <h4><?php _e('Kategorie', 'page-builder-framework-child'); ?></h4>
                        <?php echo facetwp_display('facet', 'aktivitaet_veranstaltungstyp'); ?>
                    </div>

                <?php endif; ?>

                <?php if ($blog_id == 1 or $blog_id == 22) :
                    $usedFacet = true; ?>

                    <div class="wpbf-small-1-3">
                        <h4><?php _e('Sektion', 'page-builder-framework-child'); ?></h4>
                        <?php if (ICL_LANGUAGE_CODE == "fr") { 
                            echo facetwp_display('facet', 'aktivitaet_sektion_fr');
                        } else {
                            echo facetwp_display('facet', 'aktivitaet_sektion');
                        }; ?>
                    </div>
        
                <?php endif; ?>
				
                <?php if ($blog_id == 7) : 
                    $usedFacet = true; ?>

                    <div class="wpbf-small-1-3">
                        <h4><?php _e('Suche', 'page-builder-framework-child'); ?></h4>
                        <?php echo facetwp_display('facet', 'suche_de'); ?>
                    </div>

                <?php endif; ?>
                

            </div>

            <div class="facetwp-template">
                <?php if($usedFacet) : ?>
                    <?php echo facetwp_display('pager'); ?>
                <?php else : ?>
                    <?php the_posts_pagination(array(
                        'mid_size' => 4,
                        'prev_text' => __('&larr; Previous', 'page-builder-framework'),
                        'next_text' => __('Next &rarr;', 'page-builder-framework'),
                    )); ?>
                <?php endif; ?>
                <br />

                <?php if (have_posts()) :
                    do_action('wpbf_before_loop');
                    while (have_posts()) : the_post();
                        get_template_part('inc/template-parts/article');
                    endwhile;
                    do_action('wpbf_after_loop');
                else :
                    get_template_part('inc/template-parts/article-none');
                endif; ?>

                <?php if($usedFacet) : ?>
                    <?php echo facetwp_display('pager'); ?>
                <?php else : ?>
                    <?php the_posts_pagination(array(
                        'mid_size' => 4,
                        'prev_text' => __('&larr; Previous', 'page-builder-framework'),
                        'next_text' => __('Next &rarr;', 'page-builder-framework'),
                    )); ?>
                <?php endif; ?>
            </div>
        </main>

        <?php do_action('wpbf_inner_content_close'); ?>

    <?php wpbf_inner_content_close(); ?>

    <?php do_action('wpbf_content_close'); ?>

</div>

<?php get_footer(); ?>
