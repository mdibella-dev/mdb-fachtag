<?php
/**
 * Kern des Themas
 * Initialisiert das Thema und stellt eine Reihe von Zusatzfunktionen bereit
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */


defined( 'ABSPATH' ) or exit;


/* Notices ausschalten */

error_reporting( E_ALL ^ E_NOTICE );


/* Funktionsbibliothek einbinden */

//require_once( get_template_directory() . '/inc/performance.php' );
//require_once( get_template_directory() . '/inc/block-editor.php' );
//require_once( get_template_directory() . '/inc/hooks.php' );
require_once( get_template_directory() . '/inc/setup.php' );

//require_once( get_template_directory() . '/inc/post-types/post-type-workshop.php' );

//require_once( get_template_directory() . '/inc/shortcodes/shortcode-workshops.php' );
