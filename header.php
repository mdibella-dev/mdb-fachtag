<?php
/**
 * Template für den Kopfbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */


defined( 'ABSPATH' ) or exit;


?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

    <head>

        <title><?php echo wp_get_document_title(); ?></title>

        <meta charset="<?php bloginfo( 'charset' ); ?>"/>
        <meta name="author" content="<?php echo get_the_author_meta( 'display_name', $post->post_author ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="geo.region" content="DE-NW" />
        <meta name="geo.placename" content="K&ouml;ln" />
        <meta name="geo.position" content="50.95787009610846;7.017417527507723"/>
        <meta name="ICBM" content="50.95787009610846, 7.017417527507723" />

        <?php wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>

<!--
        <div id="slideout-content-wrapper">

            <div>

                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => 'nav',
                    'container_id'   => 'primary',
                ) );
                ?>

            </div>

        </div>


        <nav id="navbar">

            <div class="navbar-button">

                <button id="logo" type="button">

                    <svg viewBox="0 0 162.5 108.5">
                        <path d="M0 2.9h14v16.7C20.7 6.3 35.7 0 47.8 0 59 0 69.6 3.5 77.1 12c2.8 2.7 6.4 9.8 7 11 1.6-2.9 3.8-7.1 7.8-11.2C98.9 4.5 109.4 0 121.4 0c11 0 21.5 3.1 28.9 10.6 9.4 9.2 12.2 20.6 12.2 39.2v58.6h-14.8v-58c0-11.2-1.8-21.2-8-28-4.4-5.5-11.2-8.8-21.3-8.8-9.4 0-18.5 3.7-23.5 11-5.4 7.5-6.4 13.3-6.4 25.3v58.6H73.8V49.8c.4-11.8-1.4-18.6-5.6-25.1-5-6.9-12.6-11-23.5-11.2-10-.4-18.3 4.5-22.7 10.8-4.6 6.1-7.2 14.1-7.2 25.3v58.8H0V2.9z"/>
                    </svg>

                </button>

            </div>

            <div class="navbar-spacer"></div>

        </nav>
    -->
