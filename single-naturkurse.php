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
    $status = get_field_object('naturkurs-status');
    $datum = get_field_object('naturkurs-datum');
    $teilnehmer = get_field_object('naturkurs-teilnehmer');
    $ort = get_field_object('naturkurs-ort');
    $kanton = get_field_object('naturkurs-kanton');
    $kursnummer = get_field_object('naturkurs-nummer');
    $anmeldeschluss = get_field_object('naturkurs-anmeldeschluss');
    $verantwortlich = get_field_object('naturkurs-verantwortlich');
    $pdf = get_field_object('naturkurs-pdf');
    $voraussetzungen = get_field_object('naturkurs-voraussetzungen');
    $mitbringen = get_field_object('naturkurs-mitbringen');
    $versicherung = get_field_object('naturkurs-versicherung');
    $kosten = get_field_object('naturkurs-kosten');
    $kosten_beteiligung = get_field_object('naturkurs-kostenbeteiligung');
    $ninjaform = get_field('anmeldeformular_shortcode');
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
                                    <?php
                                    $rand = array_rand($keyvisuals);
                                    if ($keyvisuals) : ?>
                                        <img class="wpbf-post-image wp-post-image" src="<?php echo $keyvisuals[$rand]['url']; ?>"></img>
                                    <?php endif; ?>                                    
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
                                    <div class="wpbf-small-1-3 status-wrapper">
                                        <div class="wpbf-post-style-boxed <?php echo $status['value']['value']; ?>">
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
                                
                                <?php if (have_rows('naturkurs-teilnehmer')): ?>
                                    <div class="wpbf-small-1-3 teilnehmer-wrapper">
                                        <div class="wpbf-post-style-boxed">
                                            <h2><?php echo $teilnehmer['label']; ?></h2>
                                            <?php while (have_rows('naturkurs-teilnehmer')): the_row(); ?>
                                                <?php
                                                $begrenzung = get_sub_field('naturkurs-teilnehmer-begrenzung');
                                                $min = get_sub_field_object('naturkurs-teilnehmer-minimum');
                                                $max = get_sub_field_object('naturkurs-teilnehmer-maximum');
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
                                
                                <?php if ($status['value']['value'] != 'abgesagt' && $ninjaform) : ?>
                                    <div class="wpbf-1-1 button-wrapper">
                                        <a class="wpbf-button" href="#anmeldung"><?php _e('Anmeldung', 'page-builder-framework-child'); ?></a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="wpbf-small-1-2">
                                    <table class="wpbf-table">
                                        <?php if ($ort['value']): ?>
                                            <tr>
                                                <th><?php echo $ort['label']; ?></th>
                                                <td><?php echo $ort['value']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($kanton['value']): ?>
                                            <tr>
                                                <th><?php echo $kanton['label']; ?></th>
                                                <td><?php echo $kanton['value']['label']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                                
                                <div class="wpbf-small-1-2">
                                    <table class="wpbf-table">
                                        <?php if ($kursnummer['value']): ?>
                                            <tr>
                                                <th><?php echo $kursnummer['label']; ?></th>
                                                <td><?php echo $kursnummer['value']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($anmeldeschluss['value']): ?>
                                            <tr>
                                                <th><?php echo $anmeldeschluss['label']; ?></th>
                                                <td><?php echo $anmeldeschluss['value']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($verantwortlich['value']): ?>
                                            <tr>
                                                <th><?php echo $verantwortlich['label']; ?></th>
                                                <td><?php echo $verantwortlich['value']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($pdf['value']) : ?>
                                            <tr>
                                                <th><?php echo $pdf['label']; ?></th>
                                                <td>
                                                    <div class="wp-block-file">
                                                        <a href="<?php echo $pdf['value']['url']; ?>" target="_blank"
                                                            <?php echo ($pdf['value']['subtype'] != 'pdf' ? 'download' : ''); ?>>
                                                            <?php echo $pdf['value']['title']; ?></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>

                                <div class="wpbf-1-1 weitere-informationen-wrapper">
                                    <h2><?php _e('Weitere Informationen', 'page-builder-framework-child'); ?></h2>
                                    <div class="wpbf-grid">
                                        <?php if ($voraussetzungen['value']): ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $voraussetzungen['label']; ?></h3>
                                                <p><?php echo $voraussetzungen['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($mitbringen['value']): ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $mitbringen['label']; ?></h3>
                                                <p><?php echo $mitbringen['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($versicherung['value']): ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $versicherung['label']; ?></h3>
                                                <p><?php echo $versicherung['value']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($kosten['value']): ?>
                                            <div class="wpbf-small-1-2">
                                                <h3><?php echo $kosten['label']; ?></h3>
                                                <p><?php echo $kosten['value']; ?> <?php echo $kosten['prepend']; ?>, 
                                                <strong id=kostenbeteiligungcss><?php echo __('NF-Mitglieder erhalten eine Kostenbeteiligung von', 'page-builder-framework-child') ?>
                                                    <?php echo $kosten_beteiligung['value']; ?>
                                                    <?php echo $kosten_beteiligung['prepend']; ?></strong></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if ($status['value']['value'] == 'wirdDurchgefuehrt' && $ninjaform) : ?>
                                    <div class="wpbf-1-1" id="anmeldung">
                                        <h2><?php _e('Anmeldung', 'page-builder-framework-child'); ?></h2>
                                    </div>

                                    <div id="nfs-ninja_form">
                                        <?php echo do_shortcode($ninjaform); ?>
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
