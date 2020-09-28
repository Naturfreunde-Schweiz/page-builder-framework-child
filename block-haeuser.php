<?php
// exit if accessed directly
if (!defined('ABSPATH')) exit;

$hauser_uberschrift = get_field('hauser_uberschrift');
$hauser_visual = get_field('hauser_visual');
$shortcodes = get_field('shortcodes');
$beschreibung = get_field('beschreibung');
$haeuser_button_bezeichnung = get_field('haeuser_button_bezeichnung');
$haeuser_link = get_field('haeuser_link');
$featured_haeuser = get_field('featured_haeuser');
$haus_galerie = get_field('haus_galerie');
$haus_target = $haeuser_link['target'] ? $haeuser_link['target'] : '_self';
?>

<?php if ($hauser_uberschrift && $hauser_visual): ?>
    <div class="wp-block-cover has-parallax alignfull front-page-divider" style="background-image:url(<?php echo $hauser_visual['url'] ?>)">
        <p class="wp-block-cover-text"><?php echo $hauser_uberschrift ?></p>
    </div>

    <section class="front-haeuser">
        <div class="wp-block-columns has-2-columns">
            <div class="wp-block-column">
                <?php if ($shortcodes): ?>
                    <?php
                    echo do_shortcode($shortcodes['shortcode_karte']);
                    echo do_shortcode($shortcodes['shortcode_template']);
                    ?>
                <?php elseif ($haus_galerie): ?>
                    <div class="front-haeuser-slider">
                        <?php foreach ($haus_galerie as $image): ?>
                            <div>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="wp-block-column front-haeuser-content">
                <?php echo $beschreibung ?>
                <a class="wpbf-button" href="<?php echo $haeuser_link['url'] ?>" target="<?php echo esc_attr($haus_target); ?>"><?php echo $haeuser_button_bezeichnung ?></a>
            </div>
        </div>
    </section>
<?php endif; ?>