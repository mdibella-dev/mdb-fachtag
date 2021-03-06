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
        <meta name="geo.region" content="DE-NI" >
        <meta name="geo.placename" content="Bentheim">
        <meta name="geo.position" content="52.30111;7.157736">
        <meta name="ICBM" content="52.30111, 7.157736">

        <?php wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>

        <header id="header">
            <div id="header-wrapper">

                <div id="header-navigation" class="container">

                    <a href="/">
                        <div id="header-logo"></div>
                    </a>

                    <div class="header-items-right">
                    	<button class="hamburger hamburger--slider">
                	        <span class="hamburger-box">
                			    <span class="hamburger-inner"></span>
                			</span>
                        </button>

                        <?php
                        if( has_nav_menu( 'primary' ) ) :
                            wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'container'      => 'nav',
                                'container_id'   => 'primary',
                            ) );
                        endif;
                        ?>
                    </div>

                </div>

                <div id="header-stripes">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

            </div>
            <?php
            if( has_nav_menu( 'primary' ) ) :
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => 'nav',
                    'container_id'   => 'primary-aux',
                ) );
            endif;
            ?>
	    </header>
