<?php
/**
 * 404.
 *
 * Construct the theme 404 page.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div id="content-notfoundpage">

	<?php do_action( 'wpbf_content_open' ); ?>

	<?php wpbf_inner_content(); ?>

		<?php do_action( 'wpbf_inner_content_open' ); ?>

		<main id="main" class="wpbf-main<?php echo wpbf_singular_class(); ?>">

		<div id="notfound" class="wpbf-text-center">
			
            <?php echo '<h1 class="entry-title" itemprop="headline">' . apply_filters('wpbf_404_headline', __("Oh nein... Anscheinend haben Sie sich verlaufen. Sieht so aus, als ob diese Seite entfernt wurde oder nicht existiert.", 'page-builder-framework')) . '</h1>';
			?>

			<div id="notfound-text" class="wpbf-container-center wpbf-medium-1-2" itemprop="text">

				<?php
				$kontakt_link = get_field('kontakt_link', 'option');
				$news_link = get_field('news_link', 'option');
				?>

				<?php if ($kontakt_link) : ?>
				<?php echo '<p style="color: black">' . apply_filters('wpbf_404_text', __('Bei Fragen können Sie uns kontaktieren. Sie finden alle Informationen dazu unter ', 'page-builder-framework')) . '<a href="' . $kontakt_link .'">Kontakt</a>.' .'</p>'; // WPCS: XSS ok. 
				?><?php endif; ?>

				<?php if ($news_link) : ?>
				<?php echo '<p style="color: black">' . apply_filters('wpbf_404_text', __('Aktuelle Neuigkeiten finden sie unter ', 'page-builder-framework')) . '<a href=' . $news_link . '>News</a>' . '</p>'; // WPCS: XSS ok. 
				?><?php endif; ?>

				<?php echo '<p style="color: black">' . apply_filters('wpbf_404_text', __('Ansonsten können Sie die Suche unten versuchen.', 'page-builder-framework')) . '</p>'; // WPCS: XSS ok. 
				?>

				<?php get_search_form(); ?>

			</div>

		</div>

	</main>

	<?php do_action('wpbf_inner_content_close'); ?>

	<?php wpbf_inner_content_close(); ?>

	<?php do_action('wpbf_content_close'); ?>

</div>
