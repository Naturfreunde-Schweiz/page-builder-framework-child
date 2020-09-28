<?php
/**
 * Dynamic CSS
 *
 * Holds Customizer CSS styles
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if (!defined('ABSPATH')) exit;

function wpbf_do_custom_customizer_css() {
    $breakpoint_mobile_int = function_exists('wpbf_breakpoint_mobile') ? wpbf_breakpoint_mobile() : 480;
    $breakpoint_medium_int = function_exists('wpbf_breakpoint_medium') ? wpbf_breakpoint_medium() : 768;
    $breakpoint_mobile = $breakpoint_mobile_int . 'px';
    $breakpoint_medium = $breakpoint_medium_int . 'px';

    // Accent Border
    $page_accent_color = get_theme_mod('page_accent_color');
    $page_accent_color_alt = get_theme_mod('page_accent_color_alt');

    if ($page_accent_color) {
        echo '.wpbf-navigation, .news-wrapper .wp-block-column, .aktivitaeten-wrapper .wp-block-column, .content h2:after, .intro h1:after {';
        echo sprintf('border-bottom-color: %s;', esc_attr($page_accent_color));
        echo '}';
        echo '.content, .intro, .front-haeuser, .custom-footer {';
        echo sprintf('border-top-color: %s;', esc_attr($page_accent_color));
        echo '}';
        echo '.news-wrapper h3, .aktivitaeten-wrapper h3 {';
        echo sprintf('color: %s;', esc_attr($page_accent_color));
        echo '}';
    }

    if ($page_accent_color_alt) {
        echo '.news-wrapper .wp-block-column:hover, .aktivitaeten-wrapper .wp-block-column:hover {';
        echo sprintf('border-bottom-color: %s;', esc_attr($page_accent_color_alt));
        echo '}';
    }

    // Page Font
    $page_font_color = get_theme_mod('page_font_color');
    if ($page_font_color) {
        echo '.page-font-color, .page-font-color p {';
        echo sprintf('color: %s;', esc_attr($page_font_color));
        echo '}';
    }

    // Theme Buttons
    $button_border_width = get_theme_mod('button_border_width');
    $button_border_color = get_theme_mod('button_border_color');
    $button_border_color_alt = get_theme_mod('button_border_color_alt');
    $button_primary_border_color = get_theme_mod('button_primary_border_color');
    $button_primary_border_color_alt = get_theme_mod('button_primary_border_color_alt');
    $button_bg_color = get_theme_mod('button_bg_color');
    $button_text_color = get_theme_mod('button_text_color');
    $button_border_radius = get_theme_mod('button_border_radius');
    $button_bg_color_alt = get_theme_mod('button_bg_color_alt');
    $button_text_color_alt = get_theme_mod('button_text_color_alt');
    $button_primary_bg_color = get_theme_mod('button_primary_bg_color');
    $button_primary_text_color = get_theme_mod('button_primary_text_color');
    $button_primary_bg_color_alt = get_theme_mod('button_primary_bg_color_alt');
    $button_primary_text_color_alt = get_theme_mod('button_primary_text_color_alt');

    if ($button_border_width) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu li, .wp-block-button__link, .nf-form-content input[type=button] , .wp-block-file__button, .wpbf-product-archive .button {';
        echo sprintf('border-width: %s;', esc_attr($button_border_width) . 'px');
        echo 'border-style: solid;';

        if ($button_border_color) {
            echo sprintf('border-color: %s;', esc_attr($button_border_color));
        }

        echo '}';

        if ($button_border_color_alt) {
            echo '.wpbf-inner-pre-header-left .wpbf-menu li:hover, .wp-block-button__link:hover, .nf-form-content input[type=button]:hover , .wp-block-file__button:hover, .wpbf-product-archive .button:hover {';
            echo sprintf('border-color: %s;', esc_attr($button_border_color_alt));
            echo '}';
        }

        if ($button_primary_border_color) {
            echo '.wpbf-inner-pre-header-left .wpbf-menu li, .wp-block-button__link, .nf-form-content input[type=button] , .wp-block-file__button, .wpbf-product-archive .button {';
            echo sprintf('border-color: %s;', esc_attr($button_primary_border_color));
            echo '}';
        }

        if ($button_primary_border_color_alt) {
            echo '.wpbf-inner-pre-header-left .wpbf-menu li:hover, .wp-block-button__link:hover, .nf-form-content input[type=button]:hover , .wp-block-file__button:hover , .wpbf-product-archive .button:hover {';
            echo sprintf('border-color: %s;', esc_attr($button_primary_border_color_alt));
            echo '}';
        }
    }

    if ($button_bg_color || $button_border_radius) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu li, .wp-block-button__link, .nf-form-content input[type=button] , .wp-block-file__button, .wpbf-product-archive .button {';

        if ($button_border_radius) {
            echo sprintf('border-radius: %s;', esc_attr($button_border_radius) . 'px');
        }

        if ($button_bg_color) {
            echo sprintf('background: %s !important;', esc_attr($button_bg_color));
        }

        echo '}';
    }

    if ($button_text_color) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu a {';
        echo sprintf('color: %s;', esc_attr($button_text_color));
        echo '}';
    }

    if ($button_bg_color_alt) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu li:hover, .wp-block-button__link:hover, .nf-form-content input[type=button]:hover , .wp-block-file__button:hover , .wpbf-product-archive .button:hover {';

        if ($button_bg_color_alt) {
            echo sprintf('background: %s !IMPORTANT;', esc_attr($button_bg_color_alt));
        }

        echo '}';
    }

    if ($button_text_color_alt) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu a {';
        echo sprintf('color: %s;', esc_attr($button_text_color_alt));
        echo '}';
    }

    if ($button_primary_bg_color) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu li, .wp-block-button__link:hover, .nf-form-content input[type=button] , .wp-block-file__button, .wpbf-product-archive .button {';

        if ($button_primary_bg_color) {
            echo sprintf('background: %s !IMPORTANT;', esc_attr($button_primary_bg_color));
        }

        echo '}';
    }

    if ($button_primary_text_color) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu a {';
        echo sprintf('color: %s;', esc_attr($button_primary_text_color));
        echo '}';
    }

    if ($button_primary_bg_color_alt) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu li, .wp-block-button__link:hover, .nf-form-content input[type=button]:hover , .wp-block-file__button:hover, .wpbf-product-archive .button:hover {';

        if ($button_primary_bg_color_alt) {
            echo sprintf('background: %s !IMPORTANT;', esc_attr($button_primary_bg_color_alt));
        }

        echo '}';
    }

    if ($button_primary_text_color_alt) {
        echo '.wpbf-inner-pre-header-left .wpbf-menu li, .wp-block-button__link, .nf-form-content input[type=button] , .wp-block-file__button, .wpbf-product-archive .button {';
        echo sprintf('color: %s;', esc_attr($button_primary_text_color_alt));
        echo '}';
    }
}

add_action('wpbf_after_customizer_css', 'wpbf_do_custom_customizer_css', 10);