<?php
// exit if accessed directly
if (!defined('ABSPATH')) exit;

$aktuelles_titel = get_field('aktuelles_titel');
$aktuelles = get_field('aktuelles');
$aktuelles_button_bezeichnung = get_field('aktuelles_button_bezeichnung');
$aktuelles_archiv = get_field('archiv_seite_aktuelles');
$aktuelles_kategorie = get_field('aktuelles_kategorie');
?>

<?php if ($aktuelles): ?>
    <section class="aktuelles">
        <h2><?php echo ($aktuelles_titel) ? $aktuelles_titel : _e('Aktuelles', 'page-builder-framework-child'); ?></h2>
        <div class="wp-block-columns has-3-columns news-wrapper">
            <?php 
            global $post; 
            if (count($aktuelles) < 3) {
                $thumbnail_size = 'teaser-big';
            } else {
                $thumbnail_size = 'teaser';
            }
            ?>
            <?php foreach ($aktuelles as $post): // variable must be called $post (IMPORTANT) ?>
                <?php
                setup_postdata($post);
                $categories = get_the_category();
                ?>
                <div class="wp-block-column">
                    <div class="news">
                        <a href="<?php the_permalink(); ?>">
                            <div class="wp-block-cover news-img"
                                 style="background-image:url(<?php the_post_thumbnail_url($thumbnail_size); ?>), url('https://naturfreunde.ch/wp-content/uploads/nf-placeholder-1.jpg')">
                                <p class="archive-meta">
                                    <span class="news-datum"><i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
                                    <?php foreach ($categories as $category): ?>
                                        <?php if ($category->parent != 0 ) : ?>
                                            <span><i class="fas fa-list-alt"></i> <?php echo $category->name; ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                        </a>
                        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

                        <div class="page-font-color"><?php the_excerpt(); ?></div>
                        <a class="wpbf-button" href="<?php the_permalink(); ?>"><?php _e('Weiterlesen', 'page-builder-framework-child'); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($aktuelles_button_bezeichnung) : ?>
        <div class="button-wrapper">
            <a id="#alle-news" class="wpbf-button" href="<?php echo $aktuelles_archiv ?>"><?php echo ($aktuelles_button_bezeichnung) ? $aktuelles_button_bezeichnung : 'Alle News'; ?></a>
        </div>
        <?php endif; ?>
    </section>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php else: ?>
    <section class="aktuelles">
        <h2><?php echo ($aktuelles_titel) ? $aktuelles_titel : _e('Aktuelles', 'page-builder-framework-child'); ?></h2>
        <div class="wp-block-columns has-3-columns news-wrapper">
            <?php
            if (empty($aktuelles_kategorie) && $aktuelles_kategorie!==0) {
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                );
            } else {
                $slugs = array();
                foreach ($aktuelles_kategorie as $key => $value) {
                    array_push($slugs, $value->slug);
                }
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => $slugs,
                        ),
                    ),
                );
            }
            $post_query = new WP_Query($args);
            if ($post_query->found_posts < 3) {
                $thumbnail_size = 'teaser-big';
            } else {
                $thumbnail_size = 'teaser';
            }
            if ($post_query->have_posts()) :
                while ($post_query->have_posts()) :
                    $post_query->the_post();
                    $categories = get_the_category();
                    ?>
                    <div class="wp-block-column">
                        <div class="news">
                            <a href="<?php the_permalink(); ?>">
                                <div class="wp-block-cover news-img"
                                     style="background-image:url(<?php the_post_thumbnail_url($thumbnail_size); ?>), url('https://naturfreunde.ch/wp-content/uploads/nf-placeholder-1.jpg')">
                                    <p class="archive-meta">
                                        <span class="news-datum"><i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
                                        <?php foreach ($categories as $category): ?>
                                            <?php if ($category->parent != 0 ) : ?>
                                                <span><i class="fas fa-list-alt"></i> <?php echo $category->name; ?></span>
                                            <?php endif; ?>
                                            <!--<span class="news-category"><i class="fas fa-list-alt"></i> <?php echo $category->name; ?></span>-->
                                        <?php endforeach; ?>
                                    </p>
                                </div>
                            </a>
                            <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                            <div class="page-font-color"><?php the_excerpt(); ?></div>
                            <a class="wpbf-button" href="<?php the_permalink(); ?>"><?php _e('Weiterlesen', 'page-builder-framework-child'); ?></a>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
            endif;
            ?>
        </div>
        <div class="button-wrapper">
            <a id="#alle-news" class="wpbf-button" href="<?php echo $aktuelles_archiv ?>"><?php echo ($aktuelles_button_bezeichnung) ? $aktuelles_button_bezeichnung : _e('Alle News', 'page-builder-framework-child'); ?></a>
        </div>
    </section>
<?php endif; ?>