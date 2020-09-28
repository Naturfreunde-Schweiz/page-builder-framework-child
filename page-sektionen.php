<?php
/**
 * Page template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

get_header();

?>

<div id="content" class="<?php echo (has_post_thumbnail()) ? 'has-thumbnail' : '' ?>">

    <?php if (!has_post_thumbnail()): ?>
        <div class="wpbf-post-image-wrapper alignfull">
            <?php
            $keyvisuals = get_field('options_keyvisuals', 'option');
            $rand = array_rand($keyvisuals);
            if ($keyvisuals) : ?>
                <div class="wpbf-post-image"
                     style="background-image:url(<?php echo $keyvisuals[$rand]['sizes']['keyvisual']; ?>), url('https://naturfreunde.ch/wp-content/uploads/nf-placeholder-keyvisual.jpg')"></div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="wpbf-post-image"
             style="background-image:url(<?php echo the_post_thumbnail_url('single'); ?>), url('https://naturfreunde.ch/wp-content/uploads/nf-placeholder-keyvisual.jpg')"></div>
    <?php endif; ?>

    <?php do_action('wpbf_content_open'); ?>

    <?php wpbf_inner_content(); ?>

        <?php do_action('wpbf_inner_content_open'); ?>
    
        <main id="main" class="wpbf-main<?php echo wpbf_singular_class(); ?>">

            <?php do_action( 'wpbf_main_content_open' ); ?>

            <?php wpbf_title(); ?>

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div class="entry-content" itemprop="text">

                <?php do_action( 'wpbf_entry_content_open' ); ?>

                <?php the_content(); ?>

                <?php $sektionen = get_field_object('sektion'); ?>

                <?php if (get_field('sektion')): ?>
                    <div class="sektionen-wrapper">
                        <table class="wpbf_table wpbf-table-large wpbf-table-striped sortable">
                            <thead>
                            <tr>
                                <?php foreach ($sektionen['sub_fields'] as $sektion) : ?>
                                    <th><?php echo $sektion['label']; ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while (the_repeater_field('sektion')) : ?>
                                <tr>
                                    <td><?php the_sub_field('name'); ?></td>
                                    <td><?php the_sub_field('kanton'); ?></td>
                                    <td><?php the_sub_field('praesident'); ?></td>
                                    <td>
                                        <a href="mailto:<?php the_sub_field('email'); ?>"><?php the_sub_field('email'); ?></a>
                                    </td>
                                    <td>
                                        <a href="<?php the_sub_field('webseite'); ?>" target="_blank"><?php the_sub_field('webseite'); ?></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('Pages:', 'page-builder-framework'),
                    'after' => '</div>',
                ));
                ?>

                <?php do_action( 'wpbf_entry_content_close' ); ?>

            </div>

            <?php endwhile; endif; ?>

            <?php do_action( 'wpbf_main_content_close' ); ?>

        </main>

        <?php do_action('wpbf_inner_content_close'); ?>

    <?php wpbf_inner_content_close(); ?>

    <?php do_action('wpbf_content_close'); ?>

</div>

<?php get_footer(); ?>
