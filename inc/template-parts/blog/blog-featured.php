<?php
/**
 * Featured image.
 *
 * Renders featured image on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Hauspreis und Status einlesen
$preis = get_field('haus-preis-mitglied');
switch (get_queried_object()->name) {
    case 'aktivitaeten':
        $status = get_field_object('aktivitaet-status');
        break;
    case 'naturkurse':
        $status = get_field_object('naturkurs-status');
        break;
    case 'aus_weiterbildungen':
        $status = get_field_object('kurs-status');
        break;
    case 'schulung':
        $status = get_field_object('schulung-status');
        break;
}

?>

<div class="wpbf-post-image-wrapper">
    <!-- Preis der Häuser anzeigen (nur wenn etwas im Preisfeld steht) -->
    <?php if (!empty($preis['haus-preis-mitglied-erwachsen'])) {
        echo '<div class="haeuser-preis-wrapper"> '. __('Ab CHF', 'page-builder-framework-child') . ' ' . $preis['haus-preis-mitglied-erwachsen'] . '</div>';
    }
    ?>
    <!-- Status anzeigen (nur wenn etwas im Status ist und das "Abgesagt ist") -->
    <?php if ($status['value']['value'] == 'abgesagt') {
        echo '<div class="aktivitaet-status-wrapper"> '. $status['value']['label'] . '</div>';
    }
    ?>
    
    <?php if(has_post_thumbnail()) { ?>
        <a class="wpbf-post-image-link" href="<?php echo esc_url( get_permalink() ); ?>">
            <?php the_post_thumbnail( apply_filters( 'beside', 'beside' ), array( 'class' => 'wpbf-post-image', 'itemprop' => 'image' ) ); ?>
        </a>
    <?php } else { ?>
        <a class="wpbf-post-image-link" href="<?php echo esc_url(get_permalink()); ?>">
            <img width="480" height="270" src="https://naturfreunde.ch/wp-content/uploads/nf-placeholder-1.jpg" class="wpbf-post-image wp-image-5710 wp-post-image" alt="" itemprop="image">
        </a>
    <?php } ?>
</div>
