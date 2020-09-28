<?php
/**
 * Theme Header.
 *
 * See also inc/template-parts/header.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
    
    <?php if ( is_front_page() ) { 
        echo '<meta property="og:type" content="website" />';
        echo '<meta property="og:url" content="' . get_bloginfo( 'url' ) . '" />';
        echo '<meta property="og:title" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />';
        echo '<meta property="og:image" content="' . $kb_site_logo . '" />';
        echo '<meta property="og:description" content="' . esc_attr( get_bloginfo( 'description' ) ) . '" />';
    } elseif ( is_singular() ) {
        echo '<meta property="og:type" content="article" />';
        echo '<meta property="og:url" content="' . get_permalink() . '" />';
        echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />';
        $kb_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
        echo '<meta property="og:image" content="' . esc_attr( $kb_thumbnail[0] ) . '" />';
        echo '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />';
    } ?>
    
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/all.min.css">
    <link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" />
    <?php wp_head(); ?>

    <!-- Google Analytics/AdWords/weitere Dienste Einbindung -->
    <?php $blog_id = get_current_blog_id(); 
    if ($blog_id == 3 || is_main_site()) : ?>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
        </script>
    <?php endif; ?>

    <?php switch ($blog_id) {
        case 3: ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-166782577-1"></script>
            <script>gtag('config', 'UA-166782577-1');</script>
            
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-N8PCSVX');</script>
            <!-- End Google Tag Manager -->

            <?php break;
        case 1: ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137165900-2"></script>
            <script>
                gtag('config', 'UA-137165900-2');
                gtag('config', 'AW-939943452');
            </script>
            <?php break;
    } ?>

</head>

<?php
function theme_get_customizer_css()
{ }
?>

<body <?php body_class(); ?> <?php wpbf_body_schema_markup(); ?>>

	<a class="screen-reader-text skip-link" href="#content" title="<?php echo esc_attr__( 'Skip to content', 'page-builder-framework' ); ?>"><?php _e( 'Skip to content', 'page-builder-framework' ); ?></a>

	<?php do_action( 'wp_body_open' ); ?>

	<?php do_action( 'wpbf_body_open' ); ?>

	<div id="container" class="hfeed wpbf-page">

		<?php do_action( 'wpbf_before_header' ); ?>

		<?php do_action( 'wpbf_header' ); ?>

		<?php do_action( 'wpbf_after_header' ); ?>
