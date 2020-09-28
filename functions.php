<?php
add_theme_support( 'post-thumbnails' );

// Child Theme Setup
function wpbf_child_theme_setup() {
    load_child_theme_textdomain('page-builder-framework-child', WPBF_CHILD_THEME_DIR . '/languages');
}
add_action('after_setup_theme', 'wpbf_child_theme_setup');

function wpse_43672_wp_head() { ?>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<?php }
add_action('wp_head', 'wpse_43672_wp_head');


// enqueue css for global color accent
function theme_enqueue_styles() {
    wp_enqueue_style('theme-styles', get_stylesheet_uri());
    $custom_css = theme_get_customizer_css();
    wp_add_inline_style('theme-styles', $custom_css);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Anmelden von Footer Menüs
function wpbf_theme_setup2() {
    register_nav_menus(
        array(
            'footer_menu'           => __( 'Footer Left', 'page-builder-framework' ),
        )
    );
}
add_action( 'after_setup_theme', 'wpbf_theme_setup2' );

// Enqueue Child Theme Scripts and Styles
function wpbf_child_scripts() {
    wp_enqueue_style('wpbf-style-child', WPBF_CHILD_THEME_URI . '/style.css', false, WPBF_CHILD_VERSION);
    // Scripts (uncomment if needed!)
    wp_enqueue_script('wpbf-site-child', WPBF_CHILD_THEME_URI . '/js/site-child.js', false, WPBF_CHILD_VERSION, true);
    wp_enqueue_script('sorttable', WPBF_CHILD_THEME_URI . '/js/sorttable.js', false, WPBF_CHILD_VERSION, true);
    wp_register_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', null, null, true);
    wp_enqueue_script('slick');
}
add_action('wp_enqueue_scripts', 'wpbf_child_scripts', 13);

// Load Editor Styles
function legit_block_editor_styles() {
    wp_enqueue_style('legit-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), false, '1.0', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'legit_block_editor_styles' );

// setting excerpt length
add_filter('excerpt_length', function ($length) {
    return 26;
});


// Get Customizer Styles
require_once('styles.php');


// Bildgrössen festlegen
add_image_size('front-slider', 1920, 600, true);
add_image_size('keyvisual', 1920, 300, true);
add_image_size('archive', 440, 352, true);
add_image_size('teaser', 380, 215, true);
add_image_size('teaser-big', 570, 215, true);
add_image_size('single', 1920, 600, true);
add_image_size('aktivitaeten-nav', 300, 300, true);
add_image_size('beside', 480, 270, true);



 // on backend area
 // add_action( 'admin_head', 'override_admin_bar_css' );

 // on frontend area
 // add_action( 'wp_head', 'override_admin_bar_css' );


// sorting and ordering for archive pages
add_action('pre_get_posts', function ($query) {
    if ($query->is_main_query() && !is_admin()) :
        if (is_archive()) :
            if (is_post_type_archive('haeuser')) :
                $query->set('order', 'ASC');
                $query->set('orderby', 'haus-nfs_haeusernummer');
            elseif (is_post_type_archive('aktivitaeten')) :
                $query->set('order', 'ASC');
                $query->set('meta_query', array(
                    array(
                        'key' => 'aktivitaet-datum_aktivitaet-datum-start',
                        'compare' => '>=',
                        'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d')." -1 seconds")),
                        'type' => 'DATETIME'
                    )
                ));
                $query->set('orderby', 'meta_value');
                $query->set('meta_key', 'aktivitaet-datum_aktivitaet-datum-start');
                $query->set('meta_type', 'DATETIME');
            elseif (is_post_type_archive('aus_weiterbildungen')) :
                $query->set('order', 'ASC');
                $query->set('meta_query', array(
                    array(
                        'key' => 'kurs-datum_kurs-datum-start',
                        'compare' => '>=',
                        'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d')." -1 seconds")),
                        'type' => 'DATETIME'
                    )
                ));
                $query->set('orderby', 'meta_value');
                $query->set('meta_key', 'kurs-datum_kurs-datum-start');
                $query->set('meta_type', 'DATETIME');
            elseif (is_post_type_archive('naturkurse')) :
                $query->set('order', 'ASC');
                $query->set('meta_query', array(
                    array(
                        'key' => 'naturkurs-datum_naturkurs-datum-start',
                        'compare' => '>=',
                        'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d')." -1 seconds")),
                        'type' => 'DATETIME'
                    )
                ));
                $query->set('orderby', 'meta_value');
                $query->set('meta_key', 'naturkurs-datum_naturkurs-datum-start');
                $query->set('meta_type', 'DATETIME');
            elseif (is_post_type_archive('schulungen')) :
                $query->set('order', 'ASC');
                $query->set('meta_query', array(
                    array(
                        'key' => 'schulung-datum_schulung-datum-start',
                        'compare' => '>=',
                        'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d')." -1 seconds")),
                        'type' => 'DATETIME'
                    )
                ));
                $query->set('orderby', 'meta_value');
                $query->set('meta_key', 'schulung-datum_schulung-datum-start');
                $query->set('meta_type', 'DATETIME');
            elseif (is_category()) :
            // Sort by default
            else :
            // $query->set('orderby', 'title');
            endif;
        endif;
    endif;
});


/*
*** FacetWP
*** 3
*/

// FacetWP marker icon (https://developers.google.com/maps/documentation/javascript/reference/marker#Symbol), path is svg of fontawesome house
add_filter('facetwp_map_marker_args', function ($args, $post_id) {
    $haustyp = wp_get_post_terms($post_id, 'haustyp');
    if ($haustyp[0]->name == 'Partnerhaus' || $haustyp[0]->name == 'Hotel' || $haustyp[0]->name == 'Campingplatz') {
        $args['icon'] = array(
            'path' => 'M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z',
            'fillColor' => '#f18a48',
            'fillOpacity' => 1,
            'strokeColor' => 'white',
            'strokeWeight' => 0.5,
            'strokeOpacity' => 1,
            'scale' => 0.05,
            'anchor' => array(
                'x' => 320,
                'y' => 500
            )
        );
    } else {
        $args['icon'] = array(
            'path' => 'M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z',
            'fillColor' => '#e30613',
            'fillOpacity' => 1,
            'strokeColor' => 'white',
            'strokeWeight' => 0.5,
            'strokeOpacity' => 1,
            'scale' => 0.05,
            'anchor' => array(
                'x' => 320,
                'y' => 500
            )
        );
    }
    return $args;
}, 10, 2);

// limit map filter search of FacetWP only to the country of Switzerland (ch)
add_filter('facetwp_proximity_autocomplete_options', function ($options) {
    $options['componentRestrictions'] = array(
        'country' => 'ch',
    );
    return $options;
});

// Anpassen der FacetWP Pagination an die vom Theme (Buttons etc.)
add_filter('facetwp_pager_html', function ($output, $params) {
    $inner_size = 3;

    $output = '';
    $page = $params['page'];
    $total_pages = $params['total_pages'];
    $inner_first = max( $page - $inner_size, 1 );
    $inner_last = min( $page + $inner_size, $total_pages );

    if (1 < $total_pages) {
        // First page
        if ($inner_first > 1) {
            $output .= '<a class="facetwp-page first-page" data-page="1">' . __('Erste', 'page-builder-framework-child') . '</a>';
        }

        // Prev button
        if ( 1 < $page ) {
            $output .= '<a class="facetwp-page" data-page="' . ($page - 1) . '">' . __('←Zurück', 'page-builder-framework-child') . '</a>';
        }

        for ( $i = $inner_first; $i <= $inner_last; $i++ ) {
            if ($i == $page) {
                $output .= '<a class="facetwp-page active" data-page="' . $i . '">' . $i . '</a>';
            } else {
                $output .= '<a class="facetwp-page" data-page="' . $i . '">' . $i . '</a>';
            }
        }

        // Next button
        if ( $page < $total_pages ) {
            $output .= '<a class="facetwp-page" data-page="' . ($page + 1) . '">' . __('Weiter→', 'page-builder-framework-child') . '</a>';
        }

        // Last page
        if ($inner_last < $total_pages) {
            $output .= '<a class="facetwp-page last-page" data-page="' . $total_pages . '">' . __('Letzte', 'page-builder-framework-child') . '</a>';
        }
    }
    return $output;
}, 10, 2);


/*
*** ACF
*** 3
*/
// google map setup for advanced custom fields
add_filter('acf/fields/google_map/api', function ($api) {
    $api['key'] = GOOGLE_MAP_API_KEY;
    return $api;
});


// Add ACF Options Page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}


// ACF Sort Sektionen by sektion_name
add_filter('acf/load_value/name=sektion', function ($value, $post_id, $field) {
    $order = array();
    if (empty($value)) {
        return $value;
    }
    foreach ($value as $i => $row) {
        $order[$i] = $row['field_5cc2f960f4fd1']; //sektion_name field
    }
    array_multisort($order, SORT_ASC, $value);
    return $value;
}, 10, 3);


/*
*** Woocommerce
*** 2
*/

// remove woocommerce tabs
function bbloomer_wc_output_long_description() { ?>
    <div class="woocommerce-tabs">
        <?php the_content(); ?>
    </div>
<?php }
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('woocommerce_after_single_product_summary', 'bbloomer_wc_output_long_description', 10);


// Zahlungsarten für Sektionsprodukte entfernen
function bbloomer_unset_gateway_by_category($available_gateways)
{
    if (is_admin()) return $available_gateways;
    if (!is_checkout()) return $available_gateways;
    $unset = false;
    $category_ids = array(155);
    foreach (WC()->cart->get_cart_contents() as $key => $values) {
        $terms = get_the_terms($values['product_id'], 'product_cat');
        foreach ($terms as $term) {
            if (in_array($term->term_id, $category_ids)) {
                $unset = true;
                break;
            }
        }
    }
    if ($unset == true) unset($available_gateways['bacs']);
    if ($unset == true) unset($available_gateways['postfinance']);
    if ($unset == true) unset($available_gateways['pf_creditcard']);
    if ($unset == true) unset($available_gateways['pf_twint']);
    return $available_gateways;
}
add_filter('woocommerce_available_payment_gateways', 'bbloomer_unset_gateway_by_category');


/*
*** Broadcast
*** 1
*/

// Broadcast Plugin: Remove access for all users (except Super Admin) to all blogs besids Blog 1 (Naturfreunde Schweiz)
function my_threewp_broadcast_get_user_writable_blogs($action) {
    if ($action->user_id = 1) {
        return;
    }
    $blog_count = get_blog_count();
    for ($i = 2; $i <= $blog_count; $i++) {
        $action->blogs->forget($i);
    }
}
add_action('threewp_broadcast_get_user_writable_blogs', 'my_threewp_broadcast_get_user_writable_blogs', 200);

//manchmal werden beim übertragen von bildern im broadcast die falschen Bilder verwendet
//dies geschieht weil die Wordpress die EXIF Datein einliest und der eindeutige Attachment slug aus diesen generiert wird
//werden also z.B. auf 2 Webseiten 2 Fotos gemacht mit derselben Kamera, könnte es sein, das zwei unterschiedliche Bilder dieselben slugs haben
//und somit falsch gebroadcastet werden
//der Entwickler vom Plugin hat uns ein Filter eingebaut um weitere checks machen zu können, momentan benutze ich den Filename, aber die File grösse oder Bild grösse würde sich eig. besser eignen.
function my_threewp_broadcast_attachment_matches($attachment_matches) {
    $old = $attachment_matches->original_attachment_data->filename_base;
    $new = end(explode('/',$attachment_matches->attachment_post->guid));

    error_log("---!---");
    error_log(print_r($old, true));
    error_log(print_r($new, true));
    error_log("---!---");
    $attachment_matches->matches = ($old == $new);
    error_log("---!---");
}
add_action('threewp_broadcast_attachment_matches', 'my_threewp_broadcast_attachment_matches', 4, 10);


// scoll on loaded only if pager is the change in facet
add_action('wp_head', function () { ?>
    <script>
        (function($) {
            $(document).on('facetwp-refresh', function() {
                if (FWP.soft_refresh == true) {
                    FWP.enable_scroll = true;
                } else {
                    FWP.enable_scroll = false;
                }
            });
            $(document).on('facetwp-loaded', function() {
                if (FWP.enable_scroll == true) {
                    var position = $(".wpbf-small-1-3").offset().top;
                    /*
                    var position_facetbutton =  $(".page-numbers").offset().top;
                    if (window.console) console.log('Position: ' + position_facetbutton);
                     */
                    if (position > 0) {
                        $('html, body').animate({
                            scrollTop: position
                        }, 500);
                    }
                }
            });
        })(jQuery);
    </script>
<?php });




/*
*** Custom Columns
***
*/

// Adjust column-width of image-col for post-type "naturkurse" and "aus_weiterbildungen"
add_action('admin_head', 'mytheme_admin_head');
function mytheme_admin_head() {
    global $post_type;
    if ( 'naturkurse' || 'aus_weiterbildungen' == $post_type ) {
        ?><style type="text/css"> .column-image {width: 80px;}</style><?php
    }
}


/*
    ----------------------  Custom Columns Aus- & Weiterbildungen ----------------------
*/


// Define which columns we want to show and in which order (#aus_weiterbildungen)
function aus_weiterbildungen_filter_posts_columns( $columns ) {

    $columns = array(
        'cb' => $columns['cb'],
        'image' => __( 'Image' ),
        'title' => __( 'Title' ),
        'kurs-nummer' => __( 'Kurs-Nr.', 'page-builder-framework-child' ),
        'kurs-datum' => __( 'Start-Datum'),
        'date'=> __('Date')
      );
  return $columns;
}

// Populate Columns (#aus_weiterbildungen)
function smashing_aus_weiterbildungen_column( $column, $post_id ) {

  switch ($column) {
    case 'image':
      echo get_the_post_thumbnail( $post_id, array(80, 80) );
      break;

    case 'kurs-nummer':
      $kursnummer = get_post_meta( $post_id, 'kurs-nummer', true );
      if ( ! $kursnummer ) {
        _e( 'n/a' );
      } else {
        echo $kursnummer;
      }
      break;

    case 'kurs-datum':
      $kursdatum = date('d.m.Y', strtotime(get_post_meta($post_id, 'kurs-datum_kurs-datum-start', true)));
      if ( ! $kursdatum ) {
        _e( 'schaube schad' );
      } else {
        echo $kursdatum;
      }
      break;
  }
}

// Make Custom Columns sortable (#aus_weiterbildungen)
function smashing_aus_weiterbildungen_sortable_columns( $columns ) {
  $columns['kurs-nummer'] = 'kurs-nummer';
  return $columns;
}

// Set what it should be sort after (#aus_weiterbildungen)
function aus_weiterbildungen_posts_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( 'kurs-nummer' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value meta_value_num' );
    $query->set( 'meta_key', 'kurs-nummer' );
  }
}

add_filter( 'manage_aus_weiterbildungen_posts_columns', 'aus_weiterbildungen_filter_posts_columns' );
add_action( 'manage_aus_weiterbildungen_posts_custom_column', 'smashing_aus_weiterbildungen_column', 10, 2);
add_filter( 'manage_edit-aus_weiterbildungen_sortable_columns', 'smashing_aus_weiterbildungen_sortable_columns');
add_action( 'pre_get_posts', 'aus_weiterbildungen_posts_orderby' );

/*
    ----------------------  Custom Columns Naturkurse ----------------------
*/


// Define which columns we want to show and in which order (#naturkurse)
function smashing_filter_posts_columns( $columns ) {
    $columns = array(
        'cb' => $columns['cb'],
        'image' => __( 'Image' ),
        'title' => __( 'Title' ),
        'naturkurs-nummer' => __( 'Kurs-Nr.', 'page-builder-framework-child' ),
        'naturkurs-datum' => __( 'Start-Datum'),
      );
  return $columns;
}


// Populate Columns (#naturkurse)
function smashing_naturkurse_column( $column, $post_id ) {

  switch ($column) {
    case 'image':
      echo get_the_post_thumbnail( $post_id, array(80, 80) );
      break;

    case 'naturkurs-nummer':
      $kursnummer = get_post_meta( $post_id, 'naturkurs-nummer', true );
      if ( ! $kursnummer ) {
        _e( 'n/a' );
      } else {
        echo $kursnummer;
      }
      break;

    case 'naturkurs-datum':
      $naturkursdatum = date('d.m.Y', strtotime(get_post_meta($post_id, 'naturkurs-datum_naturkurs-datum-start', true)));
      if ( ! $naturkursdatum ) {
        _e( 'schaube schad' );
      } else {
        echo $naturkursdatum;
      }
      break;
  }
}

// Make Custom Columns sortable (#naturkurse)
function smashing_naturkurse_sortable_columns( $columns ) {
  $columns['naturkurs-nummer'] = 'naturkurs-nummer';
  return $columns;
}

add_filter( 'manage_naturkurse_posts_columns', 'smashing_filter_posts_columns' );
add_action( 'manage_naturkurse_posts_custom_column', 'smashing_naturkurse_column', 10, 2);
add_filter( 'manage_edit-naturkurse_sortable_columns', 'smashing_naturkurse_sortable_columns');


// Naturkurse custom column end



// Add the custom columns to the book post type
function my_manage_aktivitaeten_columns($columns) {
    $columns['start_datum'] = __('Start-Datum');
    return $columns;
}

// Make custom columns sortable
function my_set_sortable_columns($columns) {
    $columns['start_datum'] = 'start_datum';
    return $columns;
}

// Add the data to the custom columns for the post type aktivitaeten
function my_populate_custom_columns($column, $post_id) {
    switch ($column) {
        case 'start_datum':
            $datum_start = date('d.m.Y', strtotime(get_post_meta($post_id, 'aktivitaet-datum_aktivitaet-datum-start', true)));
            echo $datum_start;
            break;
    }
}

// Sorting-Query for the custom columns
function my_sort_custom_column_query($query) {
    $orderby = $query->get('orderby');
    if ('start_datum' == $orderby) {
        $meta_query = array(
            'relation' => 'OR',
            array(
                'key' => 'aktivitaet-datum_aktivitaet-datum-start',
                'compare' => 'NOT EXISTS',
                'type' => 'DATE',
            ),
            array(
                'key' => 'aktivitaet-datum_aktivitaet-datum-start',
                'type' => 'DATE',
            ),
        );
        $query->set('meta_query', $meta_query);
        $query->set('orderby', 'meta_value');
    }
}

if (is_admin() && 'aktivitaeten' == $_GET['post_type']) {
    add_filter('manage_aktivitaeten_posts_columns', 'my_manage_aktivitaeten_columns');
    add_filter('manage_edit-aktivitaeten_sortable_columns', 'my_set_sortable_columns');
    add_action('manage_aktivitaeten_posts_custom_column', 'my_populate_custom_columns', 10, 2);
    add_action('pre_get_posts', 'my_sort_custom_column_query');
}


/*
*** Display Posts
*** 2
*/

// Add Aktivitäts-Datum to Display Posts
function be_dps_include_event_date($output, $original_atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class, $author, $category_display_text) {
    if (empty($original_atts['include_event_date']) || false === filter_var($original_atts['include_event_date'], FILTER_VALIDATE_BOOLEAN))
        return $output;
    $post_type = get_post_type();
    switch ($post_type) {
        case 'aktivitaeten':
            $key = 'aktivitaet-datum_aktivitaet-datum-start';
            break;
        case 'aus_weiterbildungen':
            $key = 'kurs-datum_kurs-datum-start';
            break;
    }
    $event_date = get_post_meta(get_the_ID(), $key, true);
    if (empty($event_date))
        return $output;

    $event_date = date_i18n('D, d.m.Y', strtotime($event_date));
    $event_date = '<span class="date">' . $event_date . '</span>';
    $output = '<' . $inner_wrapper . ' class="' . implode(' ', $class) . '">' . $image . $title . $event_date . $date . $author . $category_display_text . $excerpt . $content . '</' . $inner_wrapper . '>';
    return $output;
}
add_filter('display_posts_shortcode_output', 'be_dps_include_event_date', 10, 11);

//Display Posts - List upcoming events, see https://displayposts.com/2019/01/04/display-upcoming-events-from-the-events-calendar
function be_dps_future_events($args, $atts) {

    if ($args['post_type'][0] != 'aktivitaeten' && $args['post_type'][0] != 'aus_weiterbildungen'){
        return $args;
    }

    $args['order'] = 'ASC';
    $args['orderby'] = 'meta_value';
    $args['meta_type'] = 'DATETIME';
    $args['post_status'] = 'publish';

    switch ($args['post_type'][0]){
        case 'aktivitaeten' :
            $args['meta_key'] = 'aktivitaet-datum_aktivitaet-datum-start';
            $args['meta_query'] = array(
                array(
                    'key' => 'aktivitaet-datum_aktivitaet-datum-start',
                    'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d')." -1 seconds")),
                    'compare' => '>'
                )
            );
            break;
        case 'aus_weiterbildungen' :
            $args['meta_key'] = 'kurs-datum_kurs-datum-start';
            $args['meta_query'] = array(
                array(
                    'key' => 'kurs-datum_kurs-datum-start',
                    'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d')." -1 seconds")),
                    'compare' => '>'
                )
            );
            break;
    }

    return $args;

}
add_filter('display_posts_shortcode_args', 'be_dps_future_events', 10, 2);

//--- Start Custom Wordpress Gutenberg Blocks für Aktivitäten---

//Kategorie registrieren
function loadNaturfreundeBlockCategory( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'naturfreunde-block',
                'title' => __( 'Naturfreunde', 'naturfreunde-block' ),
                'icon'  => 'palmtree',
            ),
        )
    );
}
add_filter( 'block_categories', 'loadNaturfreundeBlockCategory', 10, 2 );

//blocks.js registrieren (für Blockeditor)
function loadNaturfreundeBlocks() {
    wp_enqueue_script(
        'NaturfreundeBlocks',
        get_theme_root_uri() . '/' . get_stylesheet() . '/blocks.js',
        array('wp-blocks','wp-editor'),
        true
    );
}
add_action('enqueue_block_editor_assets', 'loadNaturfreundeBlocks');

//shortcode handlen
function handleNaturfreundeShortCode($atts) {
    $args = shortcode_atts(array(
        'type' => 'aktivitaeten'
    ), $atts );

    ob_start();
    if ($args['type'] == 'aktivitaeten') {
        include('block-aktivitaeten.php');
    } elseif ($args['type'] == 'aktuelles') {
        include('block-aktuelles.php');
    } elseif ($args['type'] == 'haeuser') {
        include('block-haeuser.php');
    }
    $rendered=ob_get_contents();
    ob_end_clean();

    return $rendered;
}
add_shortcode('naturfreunde', 'handleNaturfreundeShortCode');

//--- Ende Custom Wordpress Gutenberg Blocks für Aktivitäten---

//custom Shortcode damit Ninja Forms über ihren Namen aufgerufen werden können, statt über ihre ID
function handleNinjaFormsShortCode($atts) {
    include_once(WP_PLUGIN_DIR . '/ninja-forms/ninja-forms.php');

    $args = shortcode_atts(array(
        'name' => ''
    ), $atts );

    $found_id = -1;

    if ( get_option( 'ninja_forms_load_deprecated', false ) ) {
        $forms_ids = Ninja_Forms()->forms()->get_all();
        foreach ( $forms_ids as $form_id ) {
            if ($args['name'] == Ninja_Forms()->form( $form_id )->get_setting( 'form_title' )) {
                $found_id = $form_id;
                break;
            }
        }
    } else {
        $forms_ids = Ninja_Forms()->form()->get_forms();
        foreach ( $forms_ids as $index => $form ) {
            if ($args['name'] == $form->get_setting( 'title' )) {
                $found_id = $form->get_id();
                break;
            }
        }
    }

    $rendered = '';

    if ($found_id != -1) {
        $rendered = do_shortcode('[ninja_form id=' . $found_id . ']');
    }

    return $rendered;
}
add_shortcode('ninja_form_with_name', 'handleNinjaFormsShortCode');

//Regelmässiges neu Indexieren von FacetWP
//Achtung, die Action muss von Hand in den Scheduler übers Webinterface eingetragen werden
/*function custom_reindex_FacetWP() {
    error_log("start FacetWP Indexer");
    FWP()->indexer->index();
    error_log("finished FacetWP Indexer");
}
add_action('nfs_reindex_facetwp', 'custom_reindex_FacetWP');*/

//Regelmässiges löschen von alten Posts
//Achtung, die Action muss von Hand in den Scheduler übers Webinterface eingetragen werden
function custom_post_deleter() {
    error_log("start custom_post_deleter");
    global $post;
    $trash_before = strtotime(date('Y-m-d H:i:s', strtotime(date('Y-m-d')." -1 seconds")));

    $checkPosts = function($posts, $trashdate) {
        foreach ($posts as $post) {
            setup_postdata($post);

            $aktivitaet = get_field('aktivitaet-datum', $post->ID);
            $kurs = get_field('kurs-datum', $post->ID);
            $naturkurs = get_field('naturkurs-datum', $post->ID);

            if ($aktivitaet) {
                $start = strtotime($aktivitaet['aktivitaet-datum-start']);
                $ende = strtotime($aktivitaet['aktivitaet-datum-ende']);
            } elseif ($kurs) {
                $start = strtotime($kurs['kurs-datum-start']);
                $ende = strtotime($kurs['kurs-datum-ende']);
            } elseif ($naturkurs) {
                $start = strtotime($naturkurs['naturkurs-datum-start']);
                $ende = strtotime($naturkurs['naturkurs-datum-ende']);
            }

            if ($start && $ende) {
                if ($start < $trashdate && $ende < $trashdate) {
                    wp_trash_post($post->ID);
                }
            } elseif ($start) {
                if ($start < $trashdate) {
                    wp_trash_post($post->ID);
                }
            } elseif ($ende) {
                if ($ende < $trashdate) {
                    wp_trash_post($post->ID);
                }
            }
        }
    };

    $blogs=get_sites();
    foreach ($blogs as $blog){
        switch_to_blog($blog->blog_id);

        $posts = get_posts([
          'post_type' => 'aktivitaeten',
          'post_status' => 'publish',
          'numberposts' => -1
        ]);
        $checkPosts($posts, $trash_before);
        $posts = get_posts([
          'post_type' => 'aus_weiterbildungen',
          'post_status' => 'publish',
          'numberposts' => -1
        ]);
        $checkPosts($posts, $trash_before);
        $posts = get_posts([
          'post_type' => 'naturkurse',
          'post_status' => 'publish',
          'numberposts' => -1
        ]);
        $checkPosts($posts, $trash_before);
/*
        if (in_array("facetwp/index.php", get_option('active_plugins'))) {
            custom_reindex_FacetWP();
        }
*/
        restore_current_blog();
    }
    FWP()->indexer->index();
    error_log("finished custom_post_deleter");
}
add_action('nfs_prune_old_posts', 'custom_post_deleter');

//Regelmässiges löschen vom Cache
//Achtung, musste löschvorgang nachbauen da nicht für andere blogs gelöscht werden kann
function custom_cache_clearer() {
    error_log("start custom_cache_clearer");

    if(class_exists("autoptimizeCache")) {
        autoptimizeCache::clearall(); //einmalig ausführen damit alle konstanten wie AUTOPTIMIZE_CACHEFILE_PREFIX gesetzt sind
    }

    $blogs=get_sites();
    foreach ($blogs as $blog) {
        switch_to_blog($blog->blog_id);

        if(class_exists("autoptimizeCache")) {
            $path = autoptimizeCache::get_pathname();

            $contents = array();
            foreach ( array( '', 'js', 'css' ) as $dir ) {
                $contents[ $dir ] = scandir( $path . $dir );
            }

            foreach ( $contents as $name => $files ) {
                $dir = rtrim( $path . $name, '/' ) . '/';
                foreach ( $files as $file ) {
                    if ( custom_is_valid_cache_file( $dir, $file ) ) {
                        @unlink( $dir . $file );
                    }
                }
            }
            @unlink( $path . '/.htaccess' );
        }

        autoptimizeCache::clearall(); //nochmaliges ausführen weil da noch anderer Stuff gemacht wird als der oben

        restore_current_blog();
    }

    error_log("finished custom_cache_clearer");
}
function custom_is_valid_cache_file( $dir, $file ) //kopiert von autooptimize
{
    if ( '.' !== $file && '..' !== $file &&
        false !== strpos( $file, AUTOPTIMIZE_CACHEFILE_PREFIX ) &&
        is_file( $dir . $file ) ) {

        return true;
    }

    return false;
}
add_action('nfs_cache_clearer', 'custom_cache_clearer');



function custom_haeuser_style() {
    if (get_field('hauserfarben_aktivieren')) {
        echo "<style>

        body { color: #000000; }
        a { color: #f18a48; }
        .bypostauthor { border-color: #f18a48; }
        .wpbf-button-primary { background: #f18a48; }
        a:hover { color: #fdc652; }
        .wpbf-button-primary:hover { background: #fdc652; }
        .wpbf-menu > .current-menu-item > a { color: #fdc652 !important; }
        .wpbf-button,
        input[type=\"submit\"] { background: #f18a48; color: #ffffff; }
        .wpbf-button:hover,
        input[type=\"submit\"]:hover { background: #fdc652; color: #ffffff; }
        .wpbf-button-primary { background: #f18a48; color: #ffffff; }
        .wpbf-button-primary:hover { background: #94c24a; color: #ffffff; }
        .wpbf-navigation { background-color: #ffffff; }
        .wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li { border-bottom: 1px solid #f5f5f7; }
        .wpbf-mobile-menu-toggle { background: #f18a48; color: #ffffff !important; }
        .wpbf-pre-header { background-color: #f5f5f7; }
        .wpbf-navigation,
        .news-wrapper .wp-block-column,
        .aktivitaeten-wrapper .wp-block-column,
        .content h2:after,
        .intro h1:after { border-bottom-color: #f18a48; }
        .content,
        .intro,
        .front-haeuser,
        .custom-footer { border-top-color: #f18a48; }
        .news-wrapper h3,
        .aktivitaeten-wrapper h3 { color: #f18a48; }
        .news-wrapper .wp-block-column:hover,
        .aktivitaeten-wrapper .wp-block-column:hover { border-bottom-color: #fdc652; }
        .page-font-color,
        .page-font-color p { color: #000000; }
        #menu-header-buttons a,
        #menu-header-buttons-franzoesisch a { color: #ffffff; }
        #menu-header-buttons a,
        #menu-header-buttons-franzoesisch a { color: #ffffff; }
        #menu-header-buttons a,
        #menu-header-buttons-franzoesisch a { color: #ffffff; }
        #menu-header-buttons li,
        .wp-block-button__link,
        .nf-form-content input[type=button],
        .wp-block-file__button,
        .wpbf-product-archive .button,
        #menu-header-buttons-franzoesisch li,
        #menu-header-buttons-englisch li { background: #f18a48 !important; }
        #menu-header-buttons a,
        #menu-header-buttons-franzoesisch a,
        #menu-header-buttons-englisch a { color: #ffffff; }
        #menu-header-buttons li:hover,
        .wp-block-button__link:hover,
        .nf-form-content input[type=button]:hover,
        .wp-block-file__button:hover,
        .wpbf-product-archive .button:hover,
        #menu-header-buttons-franzoesisch li:hover,
        #menu-header-buttons-englisch li:hover { background: #fdc652 !IMPORTANT; }
        #menu-header-buttons a,
        #menu-header-buttons-franzoesisch a,
        #menu-header-buttons-englisch a { color: #ffffff; }

        </style>";
    }
}
add_action('wp_head', 'custom_haeuser_style', 1000);

// Fullscreen Editor standardmässig deaktivieren
function jba_disable_editor_fullscreen_by_default() {
	$script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
	wp_add_inline_script( 'wp-blocks', $script );
}
add_action( 'enqueue_block_editor_assets', 'jba_disable_editor_fullscreen_by_default' );
// Ende Fullscreen editor


add_action( 'woocommerce_thankyou', 'bbloomer_conversion_tracking_thank_you_page' );

function bbloomer_conversion_tracking_thank_you_page() {
?>
   <!-- Event snippet for Kauf conversion page -->
    <script>
      gtag('event', 'conversion', {
          'send_to': 'AW-939943452/5eVlCJz94c0BEJzMmcAD',
          'value': 5.0,
          'currency': 'CHF',
          'transaction_id': ''
      });
    </script>

<?php
}

/**
 * Enable unfiltered_html capability for Editors.
 *
 * @param array $caps The user's capabilities.
 * @param string $cap Capability name.
 * @param int $user_id The user ID.
 * @return array $caps The user's capabilities, with 'unfiltered_html' potentially added.
 */
function km_add_unfiltered_html_capability_to_editors( $caps, $cap, $user_id ) {

 if ( 'unfiltered_html' === $cap && user_can( $user_id, 'administrator' ) ) {

 $caps = array( 'unfiltered_html' );

 }

 return $caps;
}
add_filter( 'map_meta_cap', 'km_add_unfiltered_html_capability_to_editors', 1, 3 );
