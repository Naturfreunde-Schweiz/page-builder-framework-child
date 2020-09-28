<?php
/**
 * Single.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$grid_gap				= get_theme_mod( 'sidebar_gap', 'medium' );
$template_parts_header	= get_theme_mod( 'single_sortable_header', array( 'title', 'meta', 'featured' ) );
$template_parts_footer	= get_theme_mod( 'single_sortable_footer', array( 'categories' ) );
$post_style             = get_theme_mod( 'single_post_style', 'plain' );
$post_style            .= get_theme_mod( 'single_boxed_image_stretched', false ) ? ' stretched' : '';
$post_classes           = array( 'wpbf-post-style-' . $post_style );

get_header();

?>

<?php
    $kontakt_name = get_field_object('aktivitaet-kontaktdaten-name');
    $kontakt_email = get_field_object('aktivitaet-kontaktdaten-email');
    $kontakt_telefon = get_field_object('aktivitaet-kontaktdaten-telefon');
    $kontakt_telefon_alt = get_field_object('aktivitaet-kontaktdaten-telefon_alternativ');
    $status = get_field_object('aktivitaet-status');
    $datum = get_field_object('aktivitaet-datum');
    $teilnehmer = get_field_object('aktivitaet-teilnehmer');
    $show_ninjaform = get_field('aktivitaet-anmeldeformular');
    $ninjaform = get_field('anmeldeformular_shortcode');
    $aktivitaet_galerie = get_field_object('aktivitaet-galerie');
    $anmeldeschluss = get_field_object('aktivitaet-anmeldeschluss');
    $leitung = get_field_object('aktivitaet-leitung');
    $sektion = get_field_object('aktivitaet-sektion');
    $webseite = get_field_object('aktivitaet-webseite');
    $pdf = get_field_object('aktivitaet-pdf');
    $anforderung = get_field_object('aktivitaet-anforderung');
    $ausruestung = get_field_object('aktivitaet-ausruestung');
    $verpflegung = get_field_object('aktivitaet-verpflegung');
    $kosten = get_field_object('aktivitaet-kosten');
    $bemerkung = get_field_object('aktivitaet-bemerkungen');
    $programm = get_field_object('aktivitaet_programm');
    $treffpunkt = get_field_object('aktivitaet-treffpunkt');
    $ort = get_field_object('aktivitaet-ort');
    $kanton = get_field_object('aktivitaet-kanton');
    $kategorien = wp_get_post_terms($post->ID, 'veranstaltungstyp');
    $keyvisuals = get_field('options_keyvisuals', 'option');
?>

<div id="content">

	<?php do_action( 'wpbf_content_open' ); ?>

	<?php if ( ! is_singular( array( 'elementor_library', 'et_pb_layout', 'wpbf_hooks' ) ) ) : ?>

	<?php wpbf_inner_content(); ?>

		<?php do_action( 'wpbf_inner_content_open' ); ?>

		<div class="wpbf-grid wpbf-main-grid wpbf-grid-<?php echo esc_attr( $grid_gap ); ?>">

			<?php do_action( 'wpbf_sidebar_left' ); ?>

			<main id="main" class="wpbf-main wpbf-medium-2-3<?php echo wpbf_singular_class(); ?>">

				<?php do_action( 'wpbf_main_content_open' ); ?>

				<?php do_action( 'wpbf_before_article' ); ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork">

					<div class="wpbf-article-wrapper">

						<?php do_action( 'wpbf_article_open' ); ?>

                        <header class="article-header alignfull">

                            <?php

                            if (!empty($template_parts_header) && is_array($template_parts_header)) {
                                foreach ($template_parts_header as $part) {
                                    get_template_part('inc/template-parts/single/single-' . $part);
                                }
                            }
                            ?>

                            <?php if (!has_post_thumbnail()): ?>
                                <div class="wpbf-post-image-wrapper">
                                    <img src="https://naturfreunde.ch/wp-content/uploads/nf-placeholder-1.jpg" class="wpbf-post-image wp-post-image" alt="" itemprop="image">
                                                                     
                                </div>
                            <?php endif; ?>

                        </header>

                        <section class="entry-content article-content" itemprop="text">
                            
                            <?php do_action( 'wpbf_entry_content_open' ); ?>
                            
                            <div class="intro">
                                <?php wpbf_title(); ?>
                                <?php the_content(); ?>
                            </div>
                                
                            <div class="wpbf-grid">
                                <?php if ($status['value']) : ?>
                                    <div class="wpbf-small-1-3">
                                        <div class="wpbf-post-style-boxed status-wrapper <?php echo $status['value']['value']; ?>">
                                            <h2><?php echo $status['label']; ?></h2>
                                            <p><?php echo $status['value']['label']; ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($datum['value']) : ?>
                                    <div class="wpbf-small-1-3 datum-wrapper">
                                        <div class="wpbf-post-style-boxed">
                                            <h2><?php echo $datum['label']; ?></h2>
                                            <p>
                                                <?php $dates = array_combine(array_keys($datum['value']), $datum['sub_fields']); ?>
                                                <?php foreach ($dates as $name => $date) : ?>
                                                    <?php if ($datum['value'][$name]) : ?>
                                                        <?php $originalDate = $datum['value'][$name];
                                                         $d = date_i18n("D, d.m.Y, H:i", strtotime($originalDate));
                                                         if (strpos($d, '00:00')) {
                                                            $d = date_i18n("D, d.m.Y", strtotime($originalDate));
                                                         }
                                                         ?>
                                                        <strong><?php echo $date['label']; ?>:</strong> <?php echo $d; ?>
                                                        <?php if (next($dates)) : ?>
                                                            <br>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (have_rows('aktivitaet-teilnehmer')) : ?>
                                    <div class="wpbf-small-1-3 teilnehmer-wrapper">
                                        <div class="wpbf-post-style-boxed">
                                            <h2><?php echo $teilnehmer['label']; ?></h2>
                                            <?php while (have_rows('aktivitaet-teilnehmer')) : the_row(); ?>
                                                <?php
                                                $begrenzung = get_sub_field('aktivitaet-teilnehmer-begrenzung');
                                                $min = get_sub_field_object('aktivitaet-teilnehmer-minimum');
                                                $max = get_sub_field_object('aktivitaet-teilnehmer-maximum');
                                                ?>
                                                <p>
                                                    <?php if ($begrenzung) : ?>
                                                        <?php if ($min['value']) : ?>
                                                            <strong><?php echo $min['label']; ?>: </strong><?php echo $min['value']; ?>
                                                        <?php endif; ?>
                                                        <?php if ($max['value']) : ?>
                                                            <br><strong><?php echo $max['label']; ?>: </strong><?php echo $max['value']; ?>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <?php _e('Keine Begrenzung', 'page-builder-framework-child'); ?>
                                                    <?php endif; ?>
                                                </p>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($status['value']['value'] != 'abgesagt' && $kontakt_name['value']) : ?>
                                    <div class="wpbf-1-1 button-wrapper">
                                        <a class="wpbf-button" href="#anmeldung"><?php _e('Anmeldung', 'page-builder-framework-child'); ?></a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($programm['value']) : ?>
                                    <div class="wpbf-small-1-2 programm-wrapper">
                                        <div class="wpbf-post-style-boxed">
                                            <h2><?php echo $programm['label']; ?></h2>
                                            <?php echo $programm['value']; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($aktivitaet_galerie['value']) : ?>
                                    <div class="<?php echo ($programm['value'] ? 'wpbf-small-1-2' : 'wpbf-1-1'); ?>">
                                        <div class="wpbf-grid">
                                            <h2><?php echo $aktivitaet_galerie['label']; ?></h2>
                                            <div class="aktivitaet-slider-nav wpbf-small-1-5">
                                                <?php foreach ($aktivitaet_galerie['value'] as $image) : ?>
                                                    <div class="aktivitaet-nav">
                                                        <img src="<?php echo $image['sizes']['aktivitaeten-nav']; ?>" alt="<?php echo $image['alt']; ?>" />
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="aktivitaet-slider wpbf-small-4-5">
                                                <?php foreach ($aktivitaet_galerie['value'] as $image) : ?>
                                                    <div class="slide slick-slide" style="background-image:url(<?php echo $image['sizes']['large']; ?>)"></div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="wpbf-small-1-2">
                                    <table class="wpbf-table">
                                        <?php if ($treffpunkt['value']) : ?>
                                            <tr>
                                                <th><?php echo $treffpunkt['label']; ?></th>
                                                <td><?php echo $treffpunkt['value']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($kanton['value']) : ?>
                                            <tr>
                                                <th><?php echo $kanton['label']; ?></th>
                                                <td><?php echo $kanton['value']['label']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($kategorien) : ?>
                                            <tr>
                                                <th><?php echo _e('Veranstaltungstyp', 'page-builder-framework-child'); ?></th>
                                                <td>
                                                    <?php $output = array();
                                                    foreach ($kategorien as $kat) :
                                                        $output[] = $kat->name;
                                                    endforeach;
                                                    echo join(', ', $output); ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>

                                <div class="wpbf-small-1-2">
                                    <table class="wpbf-table">
                                        <?php if ($anmeldeschluss['value']) : ?>
                                            <tr>
                                                <th><?php echo $anmeldeschluss['label']; ?></th>
                                                <td><?php echo $anmeldeschluss['value']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($leitung['value']) : ?>
                                            <tr>
                                                <th><?php echo $leitung['label']; ?></th>
                                                <td><?php echo $leitung['value']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($sektion['value']) : ?>
                                        <?php
                                            if (array_key_exists("label", $sektion['value'])) {
                                                $lbl = $sektion['value']['label'];
                                            } else {
                                                $lbl = implode(', ', array_map(function ($entry) {
                                                    return $entry['label'];
                                                }, $sektion['value'])); 
                                            }
                                        ?>
                                            <tr>
                                                <th><?php echo $sektion['label']; ?></th>
                                                <td><?php echo $lbl; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($webseite['value']) : ?>
                                            <tr>
                                                <th><?php echo $webseite['label']; ?></th>
                                                <td>
                                                    <a href="<?php echo $webseite['value']; ?>" target="_blank"><?php echo $webseite['value']; ?></a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($pdf['value']) : ?>
                                            <tr>
                                                <th><?php echo $pdf['label']; ?></th>
                                                <td>
                                                    <div class="wp-block-file">
                                                        <a href="<?php echo $pdf['value']['url']; ?>" target="_blank" <?php echo ($pdf['value']['subtype'] != 'pdf' ? 'download' : ''); ?>>
                                                            <?php echo $pdf['value']['title']; ?></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>

                                <div class="wpbf-1-1 weitere-informationen-wrapper">
                                    <?php if ($anforderung['value'] ||  $ausruestung['value'] || $verpflegung['value'] || $kosten['value'] || $bemerkung['value']) : ?>
                                        <h2><?php _e('Weitere Informationen', 'page-builder-framework-child'); ?></h2>
                                    <?php endif; ?>
                                    <div class="wpbf-grid">
                                        <?php if ($anforderung['value']) : ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $anforderung['label']; ?></h3>
                                                <p><?php echo $anforderung['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($ausruestung['value']) : ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $ausruestung['label']; ?></h3>
                                                <p><?php echo $ausruestung['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($verpflegung['value']) : ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $verpflegung['label']; ?></h3>
                                                <p><?php echo $verpflegung['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($kosten['value']) : ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $kosten['label']; ?></h3>
                                                <p><?php echo $kosten['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($bemerkung['value']) : ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $bemerkung['label']; ?></h3>
                                                <p><?php echo $bemerkung['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($kontakt_name['value'] || $kontakt_email['value']) : ?>
                                            <div class="wpbf-small-1-2" id="anmeldung">
                                                <h3><?php _e('Kontaktdaten', 'page-builder-framework-child'); ?></h3>
                                                <ul>
                                                <?php if ($kontakt_name['value']) : ?>
                                                    <li><?php echo $kontakt_name['value']; ?></li>
                                                <?php endif; ?>
                                                <?php if ($kontakt_email['value']) : ?>
                                                    <li>
                                                        <?php echo $kontakt_email['label']; ?>:
                                                        <a href="mailto:<?php echo $kontakt_email['value']; ?>"><?php echo $kontakt_email['value']; ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if ($kontakt_telefon['value'] || $kontakt_telefon_alt['value']) : ?>
                                                    <li>
                                                        <?php echo $kontakt_telefon['label']; ?>:
                                                        <?php if ($kontakt_telefon['value']) : ?>
                                                            <a href="tel:<?php echo $kontakt_telefon['value']; ?>"><?php echo $kontakt_telefon['value']; ?></a>
                                                        <?php endif; ?>
                                                        <?php if ($kontakt_telefon['value'] && $kontakt_telefon_alt['value']) : ?>
                                                            |
                                                        <?php endif; ?>
                                                        <?php if ($kontakt_telefon_alt['value']) : ?>
                                                            <a href="tel:<?php echo $kontakt_telefon_alt['value']; ?>"><?php echo $kontakt_telefon_alt['value']; ?></a>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endif; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if ($show_ninjaform && $kontakt_email['value'] && $status['value']['value'] != 'abgesagt') : ?>
                                    <div id="nfs-ninja_form">
                                        <h2><?php _e('Anmeldung', 'page-builder-framework-child'); ?></h2>

										<?php 
										$rendered = "";
										
										if (ICL_LANGUAGE_CODE == 'fr') {
											$rendered = do_shortcode('[ninja_form_with_name name="Sektionsaktivitäten FR"]');
										} else {
											$rendered = do_shortcode('[ninja_form_with_name name="Sektionsaktivitäten DE"]');
										}
										
										if ($rendered == "") {
											$rendered = do_shortcode('[ninja_form_with_name name="Aktivitätsanmeldung"]');
										}
                                        if ($rendered == "") {
                                            $rendered = do_shortcode('[ninja_form_with_name name="Aktivitaetsanmeldung"]');
                                        }
										
										echo $rendered;
										?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . __( 'Pages:', 'page-builder-framework' ),
                            'after'  => '</div>',
                        ) );
                        ?>

                        <?php do_action( 'wpbf_entry_content_close' ); ?>

                    </section>

                    <footer class="article-footer">

                        <?php
                        if ( ! empty( $template_parts_footer ) && is_array( $template_parts_footer ) ) {
                            foreach ( $template_parts_footer as $part ) {
                                get_template_part( 'inc/template-parts/single/single-' . $part );
                            }
                        }
                        ?>
                            
                        <?//Dieser Part ist im original ausserhalb des footers ?>
                        <?php if (get_theme_mod('single_post_nav') !== 'hide') : ?>

                            <?php do_action('wpbf_before_post_links'); ?>

                            <nav class="post-links wpbf-clearfix"
                                 aria-label="<?php _e('Post Navigation', 'page-builder-framework'); ?>">

                                <span class="screen-reader-text"><?php _e('Post Navigation', 'page-builder-framework') ?></span>

                                <?php
                                previous_post_link('<span class="previous-post-link">%link</span>', apply_filters('wpbf_previous_post_link', __('&larr; Previous Post', 'page-builder-framework')));
                                next_post_link('<span class="next-post-link">%link</span>', apply_filters('wpbf_next_post_link', __('Next Post &rarr;', 'page-builder-framework')));
                                ?>

                            </nav>

                        <?php endif; ?>

                        </footer>

                        <?php do_action( 'wpbf_article_close' ); ?>

					</div>

					<?php do_action( 'wpbf_post_links' ); ?>

					<?php comments_template(); ?>

				</article>
				
				<?php endwhile; endif; ?>

				<?php do_action( 'wpbf_after_article' ); ?>

				<?php do_action( 'wpbf_main_content_close' ); ?>

			</main>

			<?php do_action( 'wpbf_sidebar_right' ); ?>

		</div>

		<?php do_action( 'wpbf_inner_content_close' ); ?>

	<?php wpbf_inner_content_close(); ?>

	<?php else : ?>

		<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

		<?php endwhile; endif; ?>

	<?php endif; ?>

	<?php do_action( 'wpbf_content_close' ); ?>

</div>

<?php get_footer(); ?>
