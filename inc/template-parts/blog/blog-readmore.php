<?php
/**
 * Read more.
 *
 * Renders read more link on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Falls ein Webseite-Button vorhanden ist soll der "Weiterlesen" Button ausgegraut werden
if (is_post_type_archive('haeuser') || (is_search() && (get_post_type() == 'haeuser'))) {
    $read_more_text = apply_filters( 'wpbf_read_more_text', __( 'Kurzinformationen', 'page-builder-framework-child' ) );
    $webseite = get_field('haus-webseite');
    if ($webseite) {
        $read_more_class = 'text' === get_theme_mod( 'blog_read_more_link' ) ? ' wpbf-inline-block' : ' wpbf-button button-grey';
    } else {
        $read_more_class = 'text' === get_theme_mod( 'blog_read_more_link' ) ? ' wpbf-inline-block' : ' wpbf-button';
    }
} else {
    $read_more_text = apply_filters( 'wpbf_read_more_text', __( 'Read more', 'page-builder-framework' ) );
    $read_more_class = 'text' === get_theme_mod( 'blog_read_more_link' ) ? ' wpbf-inline-block' : ' wpbf-button';
}

if ( 'primary' === get_theme_mod( 'blog_read_more_link' ) ) {
	$read_more_class .= ' wpbf-button-primary';
}

echo sprintf( '<a href="%1$s" class="%2$s">%3$s%4$s</a>',
	esc_url( get_permalink() ),
	'wpbf-read-more' . $read_more_class,
	esc_html( $read_more_text ),
	'<span class="screen-reader-text">' . get_the_title() . '</span>'
);

// Button direkt zur Webseite bei Häusereinträgen
if ($webseite) {
    echo sprintf('<a href="%1$s" class="wpbf-button haus-website-button" target="_blank">%2$s%1$s</span></a>',
        esc_url($webseite),
        __('Zur Webseite', 'page-builder-framework-child') . '<span class="screen-reader-text">' . __('Link zu ', 'page-builder-framework-child')
    );
}
