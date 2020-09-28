<?php
// exit if accessed directly
if (!defined('ABSPATH')) exit;

$aktivitaeten_titel = get_field('aktivitaeten_titel');
$aktivitaeten = get_field('aktivitaeten');
$aktivitaeten_button_bezeichnung = get_field('aktivitaeten_button_bezeichnung');
$aktivitaeten_archiv = get_field('archiv_seite_aktivitaeten');
$aktivitaeten_kategorie = get_field('aktivitaten_kategorie');
?>

<section class="aktivitaeten">
    <h2><?php echo ($aktivitaeten_titel) ? $aktivitaeten_titel : _e('Aktivitäten', 'page-builder-framework-child'); ?></h2>
    <div class="wp-block-columns has-3-columns news-wrapper">
        <?php if ($aktivitaeten): ?>
            <?php 
            global $post; 
            if (count($aktivitaeten) < 3) {
                $thumbnail_size = 'teaser-big';
            } else {
                $thumbnail_size = 'teaser';
            } ?>
            <?php foreach ($aktivitaeten as $post): // variable must be called $post (IMPORTANT) ?>
                <?php setup_postdata($post); ?>
        
                <?php
                $aktivitaet_d = get_field('aktivitaet-datum');
                $aktivitaet_status = get_field_object('aktivitaet-status');
        
                $aktivitaet_d_diff = strtotime($aktivitaet_d['aktivitaet-datum-ende']) - strtotime($aktivitaet_d['aktivitaet-datum-start']);
                $aktDatumStartMonat = date_i18n("m", strtotime($aktivitaet_d['aktivitaet-datum-start']));
                $aktDatumEndeMonat = date_i18n("m", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                $aktDatumStartJahr = date_i18n("Y", strtotime($aktivitaet_d['aktivitaet-datum-start']));
                $aktDatumEndeJahr = date_i18n("Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
        
                if (!$aktivitaet_d['aktivitaet-datum-ende'] || $aktivitaet_d_diff < 86400) {
                    $aktivitaet_datum = date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-start']));
                } else {
                    if ($aktDatumStartMonat == $aktDatumEndeMonat) {
                        $aktivitaet_datum = date_i18n("D, d.", strtotime($aktivitaet_d['aktivitaet-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                    } elseif ($aktDatumStartJahr != $aktDatumEndeJahr ) {
                        $aktivitaet_datum = date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                    } else {
                        $aktivitaet_datum = date_i18n("D, d.m.", strtotime($aktivitaet_d['aktivitaet-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                    }
                }
                ?>
                
                <div class="wp-block-column">
                    <div class="news">
                        <a href="<?php the_permalink(); ?>">
                            <div class="wp-block-cover news-img" style="background-image:url(<?php the_post_thumbnail_url($thumbnail_size); ?>), url('https://naturfreunde.ch/wp-content/uploads/nf-placeholder-1.jpg')">
                                <?php if ($aktivitaet_status['value']['value'] == 'abgesagt') {
                                    echo '<div class="aktivitaet-status-wrapper"> '. $aktivitaet_status['value']['label'] . '</div>';
                                } ?>
                                <p class="archive-meta">
                                    <?php if ($aktivitaet_datum) : ?>
                                        <span><i class="fas fa-calendar-alt"></i> <?php echo $aktivitaet_datum; ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </a>
                        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

                        <div class="page-font-color"><?php the_excerpt(); ?></div>
                        <a class="wpbf-button" href="<?php the_permalink(); ?>"><?php _e('Weiterlesen', 'page-builder-framework-child'); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
    
        <?php else: ?>
        
            <?php
            $counter = 0;
            if (empty($aktivitaeten_kategorie) && $aktivitaeten_kategorie!==0) {
                $inner_args = array(
                    'post_type' => 'aktivitaeten',
                    'post_status' => [
                        'publish'
                    ],
                    'posts_per_page' => '9',
                    'meta_query' => [
                        [
                            'key' => 'aktivitaet-datum_aktivitaet-datum-start',
                            'compare' => '>=',
                            'value' => date('Y-m-d H:i:s'),
                            'type' => 'DATETIME'
                        ]
                    ],
                    'orderby' => 'meta_value',
                    'meta_key' => 'aktivitaet-datum_aktivitaet-datum-start',
                    'meta_type' => 'DATETIME',
                    'order' => 'ASC'
                );
            } else {
                $slugs = array();
                foreach ($aktivitaeten_kategorie as $key => $value) {
                    array_push($slugs, $value->slug);
                }
                $inner_args = array(
                    'post_type' => 'aktivitaeten',
                    'post_status' => [
                        'publish'
                    ],
                    'posts_per_page' => '9',
                    'meta_query' => [
                        [
                        'key' => 'aktivitaet-datum_aktivitaet-datum-start',
                        'compare' => '>=',
                        'value' => date('Y-m-d H:i:s'),
                        'type' => 'DATETIME'
                        ]
                    ],
                    'orderby' => 'meta_value',
                    'meta_key' => 'aktivitaet-datum_aktivitaet-datum-start',
                    'meta_type' => 'DATETIME',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'veranstaltungstyp',
                            'field' => 'slug',
                            'terms' => $slugs,
                        ),
                    ),
                );
            }
            $inner_query = new WP_Query($inner_args); 
            if ($inner_query->found_posts < 3) {
                $thumbnail_size = 'teaser-big';
            } else {
                $thumbnail_size = 'teaser';
            }
            ?>
            <?php while ( $inner_query->have_posts()) : $inner_query->the_post(); ?>
                <?php $counter++; ?>
                
                <?php
                $aktivitaet_d = get_field('aktivitaet-datum');
                $aktivitaet_status = get_field_object('aktivitaet-status');
        
                $aktivitaet_d_diff = strtotime($aktivitaet_d['aktivitaet-datum-ende']) - strtotime($aktivitaet_d['aktivitaet-datum-start']);
                $aktDatumStartMonat = date_i18n("m", strtotime($aktivitaet_d['aktivitaet-datum-start']));
                $aktDatumEndeMonat = date_i18n("m", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                $aktDatumStartJahr = date_i18n("Y", strtotime($aktivitaet_d['aktivitaet-datum-start']));
                $aktDatumEndeJahr = date_i18n("Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
        
                if (!$aktivitaet_d['aktivitaet-datum-ende'] || $aktivitaet_d_diff < 86400) {
                    $aktivitaet_datum = date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-start']));
                } else {
                    if ($aktDatumStartMonat == $aktDatumEndeMonat) {
                        $aktivitaet_datum = date_i18n("D, d.", strtotime($aktivitaet_d['aktivitaet-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                    } elseif ($aktDatumStartJahr != $aktDatumEndeJahr ) {
                        $aktivitaet_datum = date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                    } else {
                        $aktivitaet_datum = date_i18n("D, d.m.", strtotime($aktivitaet_d['aktivitaet-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
                    }
                }
                ?>
        
                <?php if ($counter < 4) : ?>
                <div class="wp-block-column">
                    <div class="news">
                        <a href="<?php the_permalink(); ?>">
                            <div class="wp-block-cover news-img" style="background-image:url(<?php the_post_thumbnail_url($thumbnail_size); ?>), url('https://naturfreunde.ch/wp-content/uploads/nf-placeholder-1.jpg')">
                                <?php if ($aktivitaet_status['value']['value'] == 'abgesagt') {
                                    echo '<div class="aktivitaet-status-wrapper"> '. $aktivitaet_status['value']['label'] . '</div>';
                                } ?>
                                <p class="archive-meta">
                                    <?php if ($aktivitaet_datum) : ?>
                                        <span><i class="fas fa-calendar-alt"></i> <?php echo $aktivitaet_datum; ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </a>
                        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

                        <div class="page-font-color"><?php the_excerpt(); ?></div>
                        <a class="wpbf-button" href="<?php the_permalink(); ?>"><?php _e('Weiterlesen', 'page-builder-framework-child'); ?></a>
                    </div>
                </div>
                <?php endif; ?>
            <?php endwhile; ?>

        <?php endif; ?>
        
    </div>
    <div class="button-wrapper">
        <a class="wpbf-button" href="<?php echo $aktivitaeten_archiv ?>"><?php echo ($aktivitaeten_button_bezeichnung) ? $aktivitaeten_button_bezeichnung : _e('Alle Aktivitäten', 'page-builder-framework-child'); ?></a>
    </div>
</section>
<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
