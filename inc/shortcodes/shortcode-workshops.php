<?php
/**
 * Shortcode [workshops]
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtagung
 */


defined( 'ABSPATH' ) or exit;



/**
 * Der eigentliche Shortcode
 * Zeigt eine Liste mit Workshops an
 *
 * @since   1.0.0
 *
 * @param   array   $atts
 * @param   string  $content
 * @return  string  die Ausgabe
 */

function mdb_shortcode_workshops( $atts, $content = '' ) {
    // Variablen setzen
    global $post;
           $output = '';


    // Workshops holen
    $workshops = get_posts( array(
        'post_type'      => 'workshop',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'order'          => 'asc',
        'orderby'        => 'publish_date',
    ) );


    if( $workshops ) :

        $output .= '<div class="workshops">';

        foreach( $workshops as $workshop ) :

            $ws_titel           = get_field( 'titel', $workshop->ID );
            $ws_moderation      = get_field( 'moderation', $workshop->ID );
            $ws_freie_plaetze_1 = get_field( 'freie_plaetze_am_vormittag', $workshop->ID );
            $ws_freie_plaetze_2 = get_field( 'freie_plaetze_am_nachmittag', $workshop->ID );

            $output .= '<div class="workshop">';
            $output .= '<p class="workshop-titel">' . $ws_titel . '</p>';
            $output .= '<p class="workshop-moderation">' . $ws_moderation . '</p>';
            $output .= sprintf(
                '<p class="workshop-freie-plaetze">Freie Plätze: %1$s (Vormittag) / %2$s (Nachmittag)</p>',
                $ws_freie_plaetze_1,
                $ws_freie_plaetze_2,
            );
            $output .= '</div>';
        endforeach;

        $output .= '</div>';

    endif;

    wp_reset_postdata();



    return $output;
}

add_shortcode( 'workshops', 'mdb_shortcode_workshops' );
