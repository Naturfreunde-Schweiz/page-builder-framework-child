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

<script src="https://maps.googleapis.com/maps/api/js?key={GOOGLE_MAP_API_KEY}"></script>
<script type="text/javascript">
    (function($) {
        /*
         *  new_map
         *
         *  This function will render a Google Map onto the selected jQuery element
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	$el (jQuery element)
         *  @return	n/a
         */
        function new_map($el) {
            // var
            var $markers = $el.find('.marker');

            // vars
            var args = {
                zoom: 16,
                center: new google.maps.LatLng(0, 0),
                mapTypeId: google.maps.MapTypeId.HYBRID,
                streetViewControl: false,
                fullscreenControl: false
            };

            // create map
            var map = new google.maps.Map($el[0], args);

            // add a markers reference
            map.markers = [];

            // add markers
            $markers.each(function() {
                add_marker($(this), map);
            });

            // center map
            center_map(map);

            // return
            return map;
        }

        /*
         *  add_marker
         *
         *  This function will add a marker to the selected Google Map
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	$marker (jQuery element)
         *  @param	map (Google Map object)
         *  @return	n/a
         */
        function add_marker($marker, map) {
            // var
            var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));

            // create marker
            var marker = new google.maps.Marker({
                position: latlng,
                map: map
            });

            // add to array
            map.markers.push(marker);

            // if marker contains HTML, add it to an infoWindow
            if ($marker.html()) {
                // create info window
                var infowindow = new google.maps.InfoWindow({
                    content: $marker.html()
                });

                // show info window when marker is clicked
                google.maps.event.addListener(marker, 'click', function() {

                    infowindow.open(map, marker);

                });
            }
        }

        /*
         *  center_map
         *
         *  This function will center the map, showing all markers attached to this map
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	map (Google Map object)
         *  @return	n/a
         */
        function center_map(map) {
            // vars
            var bounds = new google.maps.LatLngBounds();

            // loop through all markers and create bounds
            $.each(map.markers, function(i, marker) {
                var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                bounds.extend(latlng);
            });

            // only 1 marker?
            if (map.markers.length == 1) {
                // set center of map
                map.setCenter(bounds.getCenter());
                map.setZoom(16);
            } else {
                // fit to bounds
                map.fitBounds(bounds);
            }
        }

        /*
         *  document ready
         *
         *  This function will render each map when the document is ready (page has loaded)
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	5.0.0
         *
         *  @param	n/a
         *  @return	n/a
         */
        // global var
        var map = null;

        $(document).ready(function() {
            $('.acf-map').each(function() {
                // create map
                map = new_map($(this));
            });
        });
    })(jQuery);
</script>

    <div id="content">

    <?php do_action('wpbf_content_open'); ?>

        <?php if (!is_singular(array('elementor_library', 'et_pb_layout', 'wpbf_hooks'))) : ?>

            <?php wpbf_inner_content(); ?>

            <?php do_action('wpbf_inner_content_open'); ?>

            <div class="wpbf-grid wpbf-main-grid wpbf-grid-<?php echo esc_attr($grid_gap); ?>">

                <?php do_action('wpbf_sidebar_left'); ?>

                <main id="main" class="wpbf-main wpbf-medium-2-3<?php echo wpbf_singular_class(); ?>">

                    <?php do_action( 'wpbf_main_content_open' ); ?>

                    <?php do_action('wpbf_before_article'); ?>

                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope"
                                 itemtype="https://schema.org/CreativeWork">

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

                            <div class="intro">
                                <?php wpbf_title(); ?>
                                <?php the_content(); ?>
                            </div>

                            <section class="entry-content article-content" itemprop="text">

                                <?php do_action( 'wpbf_entry_content_open' ); ?>

                                <?php
                                $reservierbar = get_field('haus-reservierbar');
                                $preiseMitglieder = get_field_object('haus-preis-mitglied');
                                $preiseNichtMitglieder = get_field_object('haus-preis-nicht_mitglied');
                                $preiseAnmerkung = get_field_object('haus-preis-anmerkung');
                                $schlafplaetze = get_field_object('haus-schlafplaetze');
                                $kanton = get_field_object('haus-kanton');
                                $hoehenlage = get_field_object('haus-hoehenlage');
                                $chKoordinaten = get_field_object('haus-ch_koordinaten');
                                $gpsKoordinaten = get_field_object('haus-gps_koordinaten');
                                $reservationsadresse = get_field_object('haus-reservationsadresse');
                                $haeuserverantwortungsadresse = get_field_object('haus-haeuserverantwortungsadresse');
                                $haeusernummer = get_field_object('haus-nfs_haeusernummer');
                                $haustyp = wp_get_post_terms($post->ID, 'haustyp');
                                $sektion = get_field_object('haus-sektion');
                                $besitzer = get_field_object('haus-besitzer');
                                $strasse = get_field_object('haus-strasse');
                                $plz = get_field_object('haus-plz');
                                $ort = get_field_object('haus-ort');
                                $webseite = get_field_object('haus-webseite');
                                $verpflegung = get_field_object('haus-verpflegung');
                                $aktivitaeten = get_field_object('haus-aktivitaeten');
                                $sehenswuerdigkeiten = get_field_object('haus-sehenswuerdigkeiten');
                                $weitere_informationen = get_field_object('haus-weitere_informationen');
                                $bewartungsMonate = get_field_object('haus-bewartungsmonate');
                                $bewartungsTage = get_field_object('haus-bewartungstage');
                                $images = get_field('haus-galerie');
                                $location = get_field('haus-google_maps');
                                ?>

                                <div class="wpbf-grid">
                                    <?php if (!empty(array_filter($preiseMitglieder['value'])) && !empty(array_filter($preiseNichtMitglieder['value']))) : ?>
                                        <div class="wpbf-small-1-3">
                                            <div class="preis-wrapper">
                                                <h2><?php _e('Preise', 'page-builder-framework-child'); ?></h2>

                                                <?php if ($preiseMitglieder['value']) : ?>
                                                    <div class="wpbf-small-1-1">
                                                        <h3><?php echo $preiseMitglieder['label']; ?></h3>
                                                        <ul>
                                                            <?php if ($preiseMitglieder['value']['haus-preis-mitglied-erwachsen']) : ?>
                                                                <li><?php echo $preiseMitglieder['sub_fields'][0]['label']; ?>: <?php echo $preiseMitglieder['value']['haus-preis-mitglied-erwachsen']; ?> CHF</li>
                                                            <?php endif; ?>
                                                            <?php if ($preiseMitglieder['value']['haus-preis-mitglied-jugendlich']) : ?>
                                                                <li><?php echo $preiseMitglieder['sub_fields'][1]['label']; ?>: <?php echo $preiseMitglieder['value']['haus-preis-mitglied-jugendlich']; ?> CHF</li>
                                                            <?php endif; ?>
                                                            <?php if ($preiseMitglieder['value']['haus-preis-mitglied-kind']) : ?>
                                                                <li><?php echo $preiseMitglieder['sub_fields'][2]['label']; ?>: <?php echo $preiseMitglieder['value']['haus-preis-mitglied-kind']; ?> CHF</li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($preiseNichtMitglieder['value']) : ?>
                                                    <div class="wpbf-small-1-1">
                                                        <h3><?php echo $preiseNichtMitglieder['label']; ?></h3>
                                                        <ul>
                                                            <?php if ($preiseNichtMitglieder['value']['haus-preis-nicht_mitglied-erwachsen']) : ?>
                                                                <li><?php echo $preiseNichtMitglieder['sub_fields'][0]['label']; ?>: <?php echo $preiseNichtMitglieder['value']['haus-preis-nicht_mitglied-erwachsen']; ?> CHF</li>
                                                            <?php endif; ?>
                                                            <?php if ($preiseNichtMitglieder['value']['haus-preis-nicht_mitglied-jugendlich']) : ?>
                                                                <li><?php echo $preiseNichtMitglieder['sub_fields'][1]['label']; ?>: <?php echo $preiseNichtMitglieder['value']['haus-preis-nicht_mitglied-jugendlich']; ?> CHF</li>
                                                            <?php endif; ?>
                                                            <?php if ($preiseNichtMitglieder['value']['haus-preis-nicht_mitglied-kind']) : ?>
                                                                <li><?php echo $preiseNichtMitglieder['sub_fields'][2]['label']; ?>: <?php echo $preiseNichtMitglieder['value']['haus-preis-nicht_mitglied-kind']; ?> CHF</li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($preiseAnmerkung['value']) : ?>
                                                    <div class="wpbf-small-1-1">
                                                        <i><?php echo $preiseAnmerkung['value']; ?></i>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($schlafplaetze['value']) : ?>
                                                    <div class="wpbf-small-1-1 schlafplaetze-wrapper">
                                                        <h3><?php echo $schlafplaetze['label']; ?></h3>
                                                        <span class="schlafplaetze"><?php echo $schlafplaetze['value']; ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($reservationsadresse['value']['haus-reservation-email'] && $reservierbar) : ?>
                                                    <a class="wpbf-button" href="#anmeldung"><?php _e('Reservationsanfrage', 'page-builder-framework-child'); ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="wpbf-small-1-6"></div>
                                    <?php endif; ?>

                                    <?php if ($images) : ?>
                                        <?php if (!empty(array_filter($preiseMitglieder['value'])) && !empty(array_filter($preiseNichtMitglieder['value']))) : ?>
                                            <div class="wpbf-small-2-3 haeuser-galerie">
                                            <?php else : ?>
                                                <div class="wpbf-small-4-6 haeuser-galerie">
                                                <?php endif; ?>
                                                <div class="haeuser-slider">
                                                    <?php foreach ($images as $image) : ?>
                                                        <div class="haeuser-img">
                                                            <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <div class="slider-nav">
                                                    <?php foreach ($images as $image) : ?>
                                                        <div class="haeuser-nav">
                                                            <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($bewartungsMonate['value'] || $bewartungsTage['value']) : ?>
                                                <div class="wpbf-small-1-2">
                                                    <h2><?php _e('Öffnungszeiten', 'page-builder-framework-child'); ?></h2>
                                                    <?php if ($bewartungsMonate['value']) : ?>
                                                        <div class="bewartungsmonate-wrapper">
                                                            <h3><?php echo $bewartungsMonate['label'] ?></h3>
                                                            <ul class="bewartungsmonate">
                                                                <?php foreach ($bewartungsMonate['value'] as $monat) : ?>
                                                                    <li><?php echo $monat['label'] ?></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($bewartungsTage['value']) : ?>
                                                        <div class="bewartungstage-wrapper">
                                                            <h3><?php echo $bewartungsTage['label'] ?></h3>
                                                            <ul class="bewartungstage">
                                                                <?php foreach ($bewartungsTage['value'] as $tag) : ?>
                                                                    <li><?php echo $tag['label'] ?></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="wpbf-small-1-2">
                                                <h2><?php _e('Hausinfos', 'page-builder-framework-child'); ?></h2>
                                                <table class="wpbf-table">
                                                    <?php if ($haeusernummer['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $haeusernummer['label']; ?></th>
                                                            <td><?php echo $haeusernummer['value']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <th><?php echo _e('Haustyp', 'page-builder-framework-child'); ?></th>
                                                        <td><?php echo $haustyp[0]->name; ?></td>
                                                    </tr>
                                                    <?php if ($sektion['value'] && ($haustyp[0]->name == 'Naturfreundehaus' || $haustyp[0]->name == 'Maison des Amis de la Nature')) : ?>
                                                        <tr>
                                                            <th><?php echo $sektion['label']; ?></th>
                                                            <td><?php foreach ($sektion['value'] as $s) {
                                                                                    echo $s;
                                                                                    if (next($sektion['value'])) {
                                                                                        echo ', '; // Add comma for all elements instead of last
                                                                                    }
                                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    <?php if ($besitzer['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $besitzer['label']; ?></th>
                                                            <td><?php echo $besitzer['value']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($strasse['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $strasse['label']; ?></th>
                                                            <td><?php echo $strasse['value']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($plz['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $plz['label']; ?></th>
                                                            <td><?php echo $plz['value']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($ort['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $ort['label']; ?></th>
                                                            <td><?php echo $ort['value']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($webseite['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $webseite['label']; ?></th>
                                                            <td><a href="<?php echo $webseite['value']; ?>" target="_blank"><?php echo $webseite['value']; ?></a></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>

                                            <?php if (!empty($verpflegung['value']) or !empty($aktivitaeten['value']) or !empty($sehenswuerdigkeiten['value']) or !empty($weitere_informationen['value'])) : ?>
                                                <div class="wpbf-small-1-1">
                                                    <div class="wpbf-post-style-boxed">
                                                        <h2><?php _e('Angebot & Weiteres', 'page-builder-framework-child'); ?></h2>
                                                        <?php if ($verpflegung['value']) : ?>
                                                            <h3><?php echo $verpflegung['label']; ?></h3>
                                                            <p><?php echo $verpflegung['value']; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($aktivitaeten['value']) : ?>
                                                            <h3><?php echo $aktivitaeten['label']; ?></h3>
                                                            <p><?php echo $aktivitaeten['value']; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($sehenswuerdigkeiten['value']) : ?>
                                                            <h3><?php echo $sehenswuerdigkeiten['label']; ?></h3>
                                                            <p><?php echo $sehenswuerdigkeiten['value']; ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($weitere_informationen['value']) : ?>
                                                            <h3><?php echo $weitere_informationen['label']; ?></h3>
                                                            <p><?php echo $weitere_informationen['value']; ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($location) : ?>
                                                <div class="wpbf-small-1-1">
                                                    <div class="acf-map">
                                                        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="wpbf-small-1-2">
                                                <h2><?php _e('Lage', 'page-builder-framework-child'); ?></h2>
                                                <table class="wpbf-table">
                                                    <?php if ($kanton['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $kanton['label']; ?></th>
                                                            <td><?php echo $kanton['value']['label']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($hoehenlage['value']) : ?>
                                                        <tr>
                                                            <th><?php echo $hoehenlage['label']; ?></th>
                                                            <td><?php echo $hoehenlage['value']; ?> <?php echo $hoehenlage['append']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($chKoordinaten['value']['haus-ch_koordinaten-y'] && $chKoordinaten['value']['haus-ch_koordinaten-x']) : ?>
                                                        <tr>
                                                            <th><?php echo $chKoordinaten['label']; ?></th>
                                                            <td><?php echo $chKoordinaten['value']['haus-ch_koordinaten-x'] . "/" . $chKoordinaten['value']['haus-ch_koordinaten-y']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($gpsKoordinaten['value']['haus-gps_koordinaten-breitengrad'] && $gpsKoordinaten['value']['haus-gps_koordinaten-laengengrad']) : ?>
                                                        <tr>
                                                            <th><?php echo $gpsKoordinaten['label']; ?></th>
                                                            <td><?php echo $gpsKoordinaten['value']['haus-gps_koordinaten-breitengrad'] . "," . $gpsKoordinaten['value']['haus-gps_koordinaten-laengengrad']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>

                                                <?php if (!empty(array_filter($reservationsadresse['value'])) or !empty(array_filter($haeuserverantwortungsadresse['value']))) : ?>
                                                    <h2 id="kontakt"><?php _e('Kontakt', 'page-builder-framework-child'); ?></h2>
                                                    <?php if ($reservationsadresse['value']) : ?>
                                                        <div class="wpbf-small-1-2">
                                                            <h3><?php _e('Reservation', 'page-builder-framework-child'); ?></h3>
                                                            <ul>
                                                                <?php if ($reservationsadresse['value']['haus-reservation-name']) : ?>
                                                                    <li>
                                                                        <?php echo $reservationsadresse['sub_fields'][0]['label']; ?>: <?php echo $reservationsadresse['value']['haus-reservation-name']; ?>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if ($reservationsadresse['value']['haus-reservation-email']) : ?>
                                                                    <li>
                                                                        <?php echo $reservationsadresse['sub_fields'][1]['label']; ?>: <a href="mailto:<?php echo $reservationsadresse['value']['haus-reservation-email'] ?>"><?php echo $reservationsadresse['value']['haus-reservation-email'] ?></a>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if ($reservationsadresse['value']['haus-reservation-telefon']) : ?>
                                                                    <li>
                                                                        <?php echo $reservationsadresse['sub_fields'][2]['label']; ?>: <a href="tel:<?php echo $reservationsadresse['value']['haus-reservation-telefon'] ?>"><?php echo $reservationsadresse['value']['haus-reservation-telefon'] ?></a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="wpbf-small-1-2"></div>
                                                    <?php endif; ?>
                                                    <?php if ($haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-andere_adresse']) : ?>
                                                        <div class="wpbf-small-1-2">
                                                            <h3><?php _e('Hausverantwortung', 'page-builder-framework-child'); ?></h3>
                                                            <ul>
                                                                <?php if ($haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-name']) : ?>
                                                                    <li>
                                                                        <?php echo $haeuserverantwortungsadresse['sub_fields'][1]['label']; ?>: <?php echo $haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-name']; ?>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if ($haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-email']) : ?>
                                                                    <li>
                                                                        <?php echo $haeuserverantwortungsadresse['sub_fields'][2]['label']; ?>: <a href="mailto:<?php echo $haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-email'] ?>"><?php echo $haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-email'] ?></a>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if ($haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-telefon']) : ?>
                                                                    <li>
                                                                        <?php echo $haeuserverantwortungsadresse['sub_fields'][3]['label']; ?>: <a href="tel:<?php echo $haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-telefon'] ?>"><?php echo $haeuserverantwortungsadresse['value']['haus-haeuserverantwortung-telefon'] ?></a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php
                                                    $oev = get_field_object('haus-anreise_oev');
                                                    $privat = get_field_object('haus-anreise_privat');
                                                    ?>

                                        <?php if (!empty($oev['value']) or !empty($privat['value'])) : ?>
                                            <div class="wpbf-small-1-2">
                                                <h2><?php _e('Anreise', 'page-builder-framework-child'); ?></h2>
                                                <?php if ($oev['value']) : ?>
                                                    <h3><?php echo $oev['label']; ?></h3>
                                                    <p><?php echo $oev['value']; ?></p>
                                                <?php endif; ?>

                                                <?php if ($privat['value']) : ?>
                                                    <h3><?php echo $privat['label']; ?></h3>
                                                    <p><?php echo $privat['value']; ?></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($reservierbar && !empty($reservationsadresse['value']['haus-reservation-email'])) : ?>

                                            <div id="anmeldung">
                                                <h2><?php _e('Reservationsanfrage', 'page-builder-framework-child'); ?></h2>
                                            </div>

                                            <div id="nfs-ninja_form">
												<?php
												$rendered = "";

												if (ICL_LANGUAGE_CODE == 'fr') {
													$rendered = do_shortcode('[ninja_form_with_name name="Hausreservation FR"]');
												} else {
													$rendered = do_shortcode('[ninja_form_with_name name="Hausreservation DE"]');
												}

												echo $rendered;
												?>
                                            </div>
                                        <?php endif; ?>

                                        <?php
                                    wp_link_pages(array(
                                        'before' => '<div class="page-links">' . __('Pages:', 'page-builder-framework'),
                                        'after' => '</div>',
                                    ));
                                    ?>

                                    <?php do_action( 'wpbf_entry_content_close' ); ?>

                                </section>

                                <footer class="article-footer">

                                    <?php

                                    if (!empty($template_parts_footer) && is_array($template_parts_footer)) {
                                        foreach ($template_parts_footer as $part) {
                                            get_template_part('inc/template-parts/single/single-' . $part);
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

                                        <?php do_action('wpbf_after_post_links'); ?>

                                    <?php endif; ?>

                                </footer>

                                <?php do_action( 'wpbf_article_close' ); ?>

                            </div>

                            <?php comments_template(); ?>

                        </article>

                    <?php endwhile; endif; ?>

                    <?php do_action('wpbf_after_article'); ?>

                    <?php do_action( 'wpbf_main_content_close' ); ?>

                </main>

                <?php do_action('wpbf_sidebar_right'); ?>

            </div>

            <?php do_action('wpbf_inner_content_close'); ?>

            <?php wpbf_inner_content_close(); ?>

        <?php else : ?>

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php the_content(); ?>

            <?php endwhile; endif; ?>

        <?php endif; ?>

        <?php do_action('wpbf_content_close'); ?>

    </div>

<?php get_footer(); ?>
