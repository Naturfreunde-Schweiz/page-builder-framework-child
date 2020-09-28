<?php
/**
 * Title.
 *
 * Renders post title on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$blog_id = get_current_blog_id();

?>

<h3 class="entry-title" itemprop="headline">
    <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h3>


<!-- infos häuser -->
<?php if (is_post_type_archive('haeuser') || (is_search() && (get_post_type() == 'haeuser'))) : ?>

    <?php $ort = get_field('haus-ort');
    $kanton = get_field('haus-kanton');
    $hausnr = get_field('haus-nfs_haeusernummer');
    $schlafplaetze = get_field('haus-schlafplaetze'); ?>

    <p class="archive-meta">
        <?php if ($hausnr) : ?>
            <span><i class="fas fa-home"></i> <?php echo $hausnr; ?></span>
        <?php endif; ?>

        <?php if ($ort) : ?>
            <span><i class="fas fa-map-marker-alt"></i> <?php echo $ort; ?>,<?php endif; ?> <?php if ($kanton) : ?> <?php echo $kanton['label']; ?></span>
        <?php endif; ?>

        <?php if ($schlafplaetze) : ?>
            <span><i class="fas fa-bed"></i> <?php echo $schlafplaetze; ?></span>
        <?php endif; ?>
    </p>
<?php endif; ?>


<!-- infos aktivitaeten -->
<?php if (is_post_type_archive('aktivitaeten') || (is_search() && (get_post_type() == 'aktivitaeten')) || is_tax('veranstaltungstyp')) : ?>

    <?php $aktivitaet_d = get_field('aktivitaet-datum');
    $aktivitaet_d_diff = strtotime($aktivitaet_d['aktivitaet-datum-ende']) - strtotime($aktivitaet_d['aktivitaet-datum-start']);
    $aktDatumStartMonat = date_i18n("m", strtotime($aktivitaet_d['aktivitaet-datum-start']));
    $aktDatumEndeMonat = date_i18n("m", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
    $aktDatumStartJahr = date_i18n("Y", strtotime($aktivitaet_d['aktivitaet-datum-start']));
    $aktDatumEndeJahr = date_i18n("Y", strtotime($aktivitaet_d['aktivitaet-datum-ende']));
    $aktivitaet_ort = get_field('aktivitaet-ort');
    $kategorien = wp_get_post_terms($post->ID, 'veranstaltungstyp');
    $aktivitaet_sektion = get_field_object('aktivitaet-sektion');

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
    } ?>

    <p class="archive-meta">
        <?php if ($aktivitaet_datum) : ?>
            <span><i class="fas fa-calendar-alt"></i> <?php echo $aktivitaet_datum; ?></span>
        <?php endif; ?>
        
        <?php if ($aktivitaet_ort) : ?>
            <span><i class="fas fa-map-marker-alt"></i> <?php echo $aktivitaet_ort; ?></span>
        <?php endif; ?>

        <?php if ($categories && $blog_id == 6) : ?>
            <?php foreach ($categories as $category) : ?>
                <span><i class="fas fa-users"></i> <?php echo $category->name; ?></span>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if ($kategorien) : ?>
            <?php foreach ($kategorien as $kat) : ?>
                <span class="aktivitaet-kategorie">
                <?php switch ($kat->name){
                    case 'Klettern':
                    case 'Escalade': ?>
                        <i class="fas fa-mountains"></i>
                        <?php break;
                    case 'Schneeschuh':
                    case 'Raquette à neige': ?>
                        <i class="fas fa-boot"></i>
                        <?php break;
                    case 'Ski/Snowboard': ?>
                        <i class="fas fa-skiing"></i>
                        <?php break;
                    case 'Velo/Bike':
                    case 'Vélo/VTT': ?>
                        <i class="fas fa-biking"></i>
                        <?php break;
                    case 'Sektionsanlass':
                    case 'Événement de la section': ?>
                        <i class="fas fa-glass-cheers"></i>
                        <?php break;
                    case 'Reise':
                    case 'Voyage': ?>
                        <i class="fas fa-train"></i>
                        <?php break;
                    case 'Jugend (froxx)':
                    case 'Jeune (froxx)': ?>
                        <i class="fas fa-child"></i>
                        <?php break;
                    case 'Arbeitstag':
                    case 'Journée de travail':?>
                        <i class="fas fa-hammer"></i>
                        <?php break;
                    default: ?>
                        <i class="fas fa-hiking"></i>
                        <?php break;
                } ?>
                <?php echo $kat->name; ?></span>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($aktivitaet_sektion) : ?>
            <?php 
            if (array_key_exists("label", $aktivitaet_sektion['value'])) {
                $lbl = $aktivitaet_sektion['value']['label'];
            } else {
                $lbl = implode(', ', array_map(function ($entry) {
                    return $entry['label'];
                }, $aktivitaet_sektion['value'])); 
            }
            ?>
            <span class="aktivitaet-sektion"><i class="fas fa-handshake"></i> <?php echo $lbl; ?></span>
        <?php endif; ?>
    </p>
<?php endif; ?>


<!-- infos ausbildungen -->
<?php if (is_post_type_archive('aus_weiterbildungen') || (is_search() && (get_post_type() == 'aus_weiterbildungen'))) : ?>

    <?php $kurs_d = get_field('kurs-datum');
    $kurs_d_diff = strtotime($kurs_d['kurs-datum-ende']) - strtotime($kurs_d['kurs-datum-start']);
    $kurs_ort = get_field('kurs-ort');
    $zielgruppen = wp_get_post_terms($post->ID, 'zielgruppe');

    if (!$kurs_d['kurs-datum-ende'] || $kurs_d_diff < 86400) {
        $kurs_datum = date_i18n("D, d.m.Y", strtotime($kurs_d['kurs-datum-start']));
    } else {
        $kursDatumStartMonat = date_i18n("m", strtotime($kurs_d['kurs-datum-start']));
        $kursDatumEndeMonat = date_i18n("m", strtotime($kurs_d['kurs-datum-ende']));
        if ($kursDatumStartMonat == $kursDatumEndeMonat) {
            $kurs_datum = date_i18n("D, d.", strtotime($kurs_d['kurs-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($kurs_d['kurs-datum-ende']));
        } else {
            $kurs_datum = date_i18n("D, d.m.", strtotime($kurs_d['kurs-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($kurs_d['kurs-datum-ende']));
        }
    } ?>

    <p class="archive-meta">
        <?php if ($kurs_datum) : ?>
            <span><i class="fas fa-calendar-alt"></i> <?php echo $kurs_datum; ?></span>
        <?php endif; ?>

        <?php if ($kurs_ort) : ?>
            <span><i class="fas fa-map-marker-alt"></i> <?php echo $kurs_ort; ?></span>
        <?php endif; ?>

        <?php if ($zielgruppen) : ?>
            <span><i class="fas fa-user-friends"></i> <?php echo $zielgruppen[0]->name; ?></span>
        <?php endif; ?>
    </p>
<?php endif; ?>


<!-- infos naturkurse -->
<?php if (is_post_type_archive('naturkurse') || (is_search() && (get_post_type() == 'naturkurse'))) : ?>

    <?php $naturkurs_d = get_field('naturkurs-datum');
    $naturkurs_ort = get_field('naturkurs-ort');

    if (!$naturkurs_d['naturkurs-datum-ende'] || $naturkurs_d_diff < 86400) {
        $naturkurs_datum = date_i18n("D, d.m.Y", strtotime($naturkurs_d['naturkurs-datum-start']));
    } else {
        $naturkursDatumStartMonat = date_i18n("m", strtotime($naturkurs_d['naturkurs-datum-start']));
        $naturkursDatumEndeMonat = date_i18n("m", strtotime($naturkurs_d['naturkurs-datum-ende']));
        if ($naturkursDatumStartMonat == $naturkursDatumEndeMonat) {
            $naturkurs_datum = date_i18n("D, d.", strtotime($naturkurs_d['naturkurs-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($naturkurs_d['naturkurs-datum-ende']));
        } else {
            $naturkurs_datum = date_i18n("D, d.m.", strtotime($naturkurs_d['naturkurs-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($naturkurs_d['naturkurs-datum-ende']));
        }
    } ?>

    <p class="archive-meta">
        <?php if ($naturkurs_datum) : ?>
            <span><i class="fas fa-calendar-alt"></i> <?php echo $naturkurs_datum; ?></span>
        <?php endif; ?>

        <?php if ($naturkurs_ort) : ?>
            <span><i class="fas fa-map-marker-alt"></i> <?php echo $naturkurs_ort; ?></span>
        <?php endif; ?>
    </p>
<?php endif; ?>


<!-- infos schulungen -->
<?php if (is_post_type_archive('schulungen') || (is_search() && (get_post_type() == 'schulungen'))) : ?>

    <?php $schulung_d = get_field('schulung-datum');
    $schulung_ort = get_field('schulung-ort');

    if (!$schulung_d['schulung-datum-ende'] || $schulung_d_diff < 86400) {
        $schulung_datum = date_i18n("D, d.m.Y", strtotime($schulung_d['schulung-datum-start']));
    } else {
        $schulungDatumStartMonat = date_i18n("m", strtotime($schulung_d['schulung-datum-start']));
        $schulungDatumEndeMonat = date_i18n("m", strtotime($schulung_d['schulung-datum-ende']));
        if ($schulungDatumStartMonat == $schulungDatumEndeMonat) {
            $schulung_datum = date_i18n("D, d.", strtotime($schulung_d['schulung-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($schulung_d['schulung-datum-ende']));
        } else {
            $schulung_datum = date_i18n("D, d.m.", strtotime($schulung_d['schulung-datum-start'])) . " - " . date_i18n("D, d.m.Y", strtotime($schulung_d['schulung-datum-ende']));
        }
    } ?>

    <p class="archive-meta">
        <?php if ($schulung_datum) : ?>
            <span><i class="fas fa-calendar-alt"></i> <?php echo $schulung_datum; ?></span>
        <?php endif; ?>

        <?php if ($schulung_ort) : ?>
            <span><i class="fas fa-map-marker-alt"></i> <?php echo $schulung_ort; ?></span>
        <?php endif; ?>
    </p>
<?php endif; ?>