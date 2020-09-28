<?php
/**
 * Theme Footer.
 *
 * See also inc/template-parts/footer.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

		do_action( 'wpbf_before_footer' );

?>

<div class="custom-footer">
    <div class="wpbf-container wpbf-container-center">
        <div class="wpbf-grid">
            <?php
            $footer_anschrift = get_field('footer_anschrift', 'option');
            $footer_strasse = get_field('footer_strasse', 'option');
            $footer_plz_ort = get_field('footer_plz_ort', 'option');
            $footer_telefon = get_field_object('footer_telefon', 'option');
            $footer_telefon_alternativ = get_field('footer_telefon_alternativ', 'option');
            $footer_fax = get_field_object('footer_fax', 'option');
            $footer_email = get_field_object('footer_e-mail', 'option');
            $footer_email_alternativ = get_field('footer_e-mail_alternativ', 'option');
            $footer_weitere_informationen_bezeichnung = get_field('footer_weitere_informationen_bezeichnung', 'option');
            $footer_weitere_informationen = get_field('footer_weitere_informationen', 'option');
            $footer_postanschrift = get_field_object('footer_postanschrift', 'option');
            $footer_postfach = get_field('footer_postfach', 'option');
            $footer_post_plz_ort = get_field('footer_post_plz_ort', 'option');
            ?>

            <div class="footer-adresse <?php if ($footer_weitere_informationen_bezeichnung || $footer_postanschrift['value']) : ?>wpbf-small-1-3<?php else : ?>wpbf-small-1-2<?php endif; ?>">

                <p>
                    <?php if ($footer_anschrift) : ?>
                        <strong><?php echo $footer_anschrift; ?></strong>
                    <?php endif; ?>
                    <?php if ($footer_strasse) : ?>
                        <br>
                        <?php echo $footer_strasse; ?>
                    <?php endif; ?>
                    <?php if ($footer_plz_ort) : ?>
                        <br>
                        <?php echo $footer_plz_ort; ?>
                    <?php endif; ?>
                </p>
                <?php if ($footer_telefon['value']) : ?>
                    <p>
                        <strong><?php echo $footer_telefon['label']; ?>: </strong>
                        <a href="tel:<?php echo $footer_telefon['value']; ?>"><?php echo $footer_telefon['value']; ?> </a>
                        <?php if ($footer_telefon_alternativ) : ?>
                            |
                            <a href="tel:<?php echo $footer_telefon_alternativ; ?>"><?php echo $footer_telefon_alternativ; ?></a>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                <?php if ($footer_fax['value']) : ?>
                    <p>
                        <strong><?php echo $footer_fax['label']; ?>: </strong>
                        <a href="fax:<?php echo $footer_fax['value']; ?>"><?php echo $footer_fax['value']; ?></a>
                    </p>
                <?php endif; ?>
                <?php if ($footer_email['value']) : ?>
                    <p>
                        <strong><?php echo $footer_email['label']; ?>: </strong>
                        <a href="mailto:<?php echo $footer_email['value']; ?>"><?php echo $footer_email['value']; ?> </a>
                        <?php if ($footer_email_alternativ) : ?>
                            |
                            <a href="mailto:<?php echo $footer_email_alternativ; ?>"><?php echo $footer_email_alternativ; ?></a>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                <div class="social-media">
                    <?php if (have_rows('footer_social_media', 'option')): ?>
                        <?php while (have_rows('footer_social_media', 'option')): the_row(); ?>
                            <?php
                            $social_channel = get_sub_field('social_channel');
                            $social_url = get_sub_field('social_url');
                            ?>

                            <a class="social-link" href="<?php echo $social_url; ?>" target="_blank">
                                <i class="fab fa-<?php echo $social_channel ?>"></i>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <?php if (!is_main_site()) : ?>
                    <div class="footer-link_main-site">
                        <a href="https://www.naturfreunde.ch" target="_blank">
                            <img src="https://naturfreunde.ch/wp-content/uploads/2019/03/NF_logo_2-sprachig_rgb_300dpi_transp.png" alt="Logo Naturfreunde Schweiz" />
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($footer_weitere_informationen_bezeichnung || $footer_postanschrift['value']) : ?>
                <div class="wpbf-small-1-3 weitere-informationen">
                    <?php if ($footer_weitere_informationen_bezeichnung) : ?>
                        <p><strong><?php echo $footer_weitere_informationen_bezeichnung; ?></strong></p>
                    <?php endif; ?>
                    <?php if ($footer_weitere_informationen) : ?>
                        <p><?php echo $footer_weitere_informationen; ?></p>
                    <?php endif; ?>
                    <?php if ($footer_postanschrift['value']) : ?>
                        <p><strong><?php echo $footer_postanschrift['label']; ?></strong></p>
                        <?php echo $footer_postanschrift['value']; ?>
                    <?php endif; ?>
                    <?php if ($footer_postfach) : ?>
                        <br>
                        <?php echo $footer_postfach; ?>
                    <?php endif; ?>
                    <?php if ($footer_post_plz_ort) : ?>
                        <br>
                        <?php echo $footer_post_plz_ort; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="<?php if ($footer_weitere_informationen_bezeichnung || $footer_postanschrift['value']) : ?>wpbf-small-1-3<?php else : ?>wpbf-small-1-2<?php endif; ?>">
                <div class="bottomMenu">
                    <?php wp_nav_menu(array('theme_location' => 'footer_menu')); ?>
                </div>
            </div>
            <?php
            $footer_copyright = get_field('copyright_footer', 'option');
            if (strlen(trim($footer_copyright))>0) {
                $footer_copyright = "| " . $footer_copyright;
            }
            ?>
            <div class="copyright">
                <p style="text-align: center">
                    © <?php echo date("Y") ?> - <?php echo get_bloginfo("name") ?>
                    | <?php _e('Alle Rechte vorbehalten', 'page-builder-framework-child'); ?>
                    <?php echo $footer_copyright; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php if (get_field('footer_newsletter', 'option')) : ?>
    <div class="footer-newsletter">
        <div class="wpbf-container wpbf-container-center">
            <h3>Newsletter</h3>
            <p><?php echo get_field('newsletter', 'option'); ?></p>
            <!-- Begin Mailchimp Signup Form -->
            <!-- <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css"> -->
            <style type="text/css">
                #mc_embed_signup {
                    background: #fff;
                    clear: left;
                    font: 14px Helvetica, Arial, sans-serif;
                    width: 100%;
                }

                /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
                   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
            </style>
            <div id="mc_embed_signup">
                <form action="https://naturfreunde.us17.list-manage.com/subscribe/post?u=26bd4cc2ea01bb22c8cf34ef1&amp;id=efbabf1f91"
                      method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
                      class="validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                        <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL"
                               placeholder="<?php _e('E-Mail Adresse', 'page-builder-framework-child'); ?>" required>
                        <input type="hidden" value="<?php _e('Deutsch', 'page-builder-framework-child'); ?>" name="LANGUAGE">
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true">
                            <input type="text"
                                   name="b_26bd4cc2ea01bb22c8cf34ef1_efbabf1f91"
                                   tabindex="-1"
                                   value="">
                        </div>
                        <input type="submit" value="<?php _e('Abonnieren', 'page-builder-framework-child'); ?>" name="subscribe" id="mc-embedded-subscribe"
                               class="button newsletter-button wpbf-button">
                    </div>
                </form>
            </div>

            <!--End mc_embed_signup-->
        </div>
    </div>
<?php endif; ?>

<?php do_action( 'wpbf_after_footer' ); ?>

	</div>

<?php do_action( 'wpbf_body_close' ); ?>

<?php wp_footer(); ?>

</body>

</html>
