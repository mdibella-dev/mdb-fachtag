<?php
/**
 * Hauptfunktion zum Einrichten der von diesem Thema unterstützten Optionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */


defined( 'ABSPATH' ) or exit;



if( ! function_exists( 'mdb_theme_setup' ) ) :

    /**
     * Führt grundlegende Einstellungen für das Thema durch.
     *
     * @since   1.0.0
     */

     function mdb_theme_setup()
     {
        /* Internationalisierung ermöglichen */

        load_theme_textdomain( 'mdb', get_template_directory() . '/lang' );


        /* HTML5-Konformität für bestimmte WordPress-Core-Elementen erreichen */

        add_theme_support( 'html5', array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'script',
            'style',
        ) );


        /* Responsives Einbetten von Embeds ermöglichen */

        add_theme_support( 'responsive-embeds' );


        /* Post Thumbnails */

        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 178, 9999, false );


        /* Block-Editor (Gutenberg) */

        add_theme_support( 'align-wide' );
        add_theme_support( 'editor-styles' );
        add_editor_style( 'assets/css/editor-styles.min.css' );

        $palette = array();
        $colors  = array(
            'Weiß, white, #fff',
            'Text, textgray, #4b6676',
            'Schwarz, black, #000',
            'Natur, nature, #00892c',
            'Wasser, water, #0095d8',
            'Heide, heath, #970e7e',
            'Sandstein, sandstone, #ac9d89',
        );

        foreach( $colors as $color ) :
            $part      = explode( ',', $color );
            $palette[] = array(
                'name'  => __( trim( $part[0] ), 'mdb' ),
                'slug'  => trim( $part[1] ),
                'color' => trim( $part[2] )
            );
        endforeach;
        add_theme_support( 'editor-color-palette', $palette );


        /* Einstellen der Mediengrößen */

        if( 178 !== get_option( 'thumbnail_size_w' ) ) :
            update_option( 'thumbnail_size_w', 178 );
            update_option( 'thumbnail_size_h', 9999 );
            update_option( 'thumbnail_crop', 0 );
        endif;

        if( 640 !== get_option( 'medium_size_w' ) ) :
            update_option( 'medium_size_w', 640 );
            update_option( 'medium_size_h', 9999 );
        endif;

        if( 960 !== get_option( 'large_size_w' ) ) :
            update_option( 'large_size_w', 960 );
            update_option( 'large_size_h', 9999 );
        endif;

        add_image_size( 'small', 300, 9999 );
        add_image_size( 'huge', 1200, 9999 );


        /* Registrieren der Navigationsmenüs */

        register_nav_menu( 'primary', __( 'Hauptnavigation', 'mdb' ) );
        register_nav_menu( 'secondary', __( 'Navigation in der Fußzeile', 'mdb' ) );


        /* Einrichten der Tabellen */

        global $wpdb;

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $table_charset_collate = $wpdb->get_charset_collate();
        $table_name            = $wpdb->prefix . TABLE_USER;

        if( $table_name != $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) ) :

            $sql = "CREATE TABLE $table_name (
                user_id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
                user_forename       VARCHAR(255) DEFAULT '' NOT NULL,
                user_lastname       VARCHAR(255) DEFAULT '' NOT NULL,
                user_email          VARCHAR(255) DEFAULT '' NOT NULL,
                user_location       VARCHAR(255) DEFAULT '' NOT NULL,
                user_institution    VARCHAR(255) DEFAULT '' NOT NULL,
                user_function       VARCHAR(255) DEFAULT '' NOT NULL,
                user_dob            VARCHAR(10) DEFAULT '' NOT NULL,
                user_vormittag      VARCHAR(1) DEFAULT '' NOT NULL,
                user_nachmittag     VARCHAR(1) DEFAULT '' NOT NULL,
                user_registered     DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (user_id)
                )
                $table_charset_collate;";

            dbDelta( $sql );
        endif;


        /* Pfad für Export-Dateien anlegen */

        $upload_dir = wp_upload_dir();
        wp_mkdir_p( $upload_dir['basedir'] . '/' . EXPORT_FOLDER );
    }

    add_action( 'after_setup_theme', 'mdb_theme_setup' );

endif;



/**
 * (Ent-)Lädt eine Reihe von notwendigen JS-Scripts und Stylesheets.
 *
 * @since   1.0.0
 */

function mdb_enqueue_scripts()
{
    /*
     * Laden von Font Awesome 5 Pro
     * @source  https://fontawesome.com/
     */

    // wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/vendors/fa5/css/fontawesome-all.min.css' );


    /*
     * Registrieren und Laden der Standard-Styles and -Scripts von mdb-theme
     *
     * style.css im Hauptverzeichnis dient nur zur Theme-Identifikation und -Versionierung
     * Die (komprimierten) Stilangaben befinden sich tatsächlich in frontend(.min).css
     */

    wp_enqueue_style( 'mdb-theme-css', get_template_directory_uri() . '/assets/css/frontend.min.css', array(), '20210825' );
    wp_enqueue_script( 'mdb-theme-js', get_template_directory_uri() . '/assets/js/frontend.js', array( 'jquery' ), false, true );


    /* AJAX-Funktionen */

    //wp_enqueue_script( 'ajax', get_template_directory_uri() . '/assets/js/ajax-loadmore.js' );
    //wp_localize_script( 'ajax', 'mdb_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}

add_action( 'wp_enqueue_scripts', 'mdb_enqueue_scripts', 9999 );



/**
 * Lädt Scripts für den Admin-Bereich.
 *
 * @since   1.0.0
 *
 * @param   string  $hook   die aktuelle Seite im Backend
 */

function mdb_admin_enqueue_scripts( $hook )
{
    if( 'edit.php' !== $hook ) :
        return;
    endif;

    wp_enqueue_style( 'mdb-theme-backend-style', get_template_directory_uri() . '/assets/css/backend.min.css' );
}

add_action( 'admin_enqueue_scripts', 'mdb_admin_enqueue_scripts' );
