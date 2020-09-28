<?php
/**
 * Article none.
 *
 * Is displayed if no post has been found.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

    if (is_post_type_archive('naturkurse')) {
        echo '<h1 class="entry-title" itemprop="headline">' . apply_filters( 'wpbf_no_post_headline', __( "Die Naturkurse sind anscheinend im Winterschlaf...", 'page-builder-framework-child' ) ) . '</h1>'; 
        ?>

        <div class="entry-content" itemprop="text">
            <?php echo '<p>' . apply_filters( 'wpbf_no_post_content', __( "Momentan sind keine Naturkurse ausgeschrieben. Bitte schauen Sie in Kürze wieder vorbei!", 'page-builder-framework-child' ) ) . '</p>'; ?>
        </div>
    
    <?php } else {

        echo '<h1 class="entry-title" itemprop="headline">' . apply_filters( 'wpbf_no_post_headline', __( "Oops, this article couldn't be found!", 'page-builder-framework' ) ) . '</h1>';
        ?>

        <div class="entry-content" itemprop="text">
            <?php echo '<p>' . apply_filters( 'wpbf_no_post_content', __( "Something went wrong.", 'page-builder-framework' ) ) . '</p>'; ?>
        </div>

<?php } ?>
