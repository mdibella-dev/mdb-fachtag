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



/* Konstanten */

define( 'STATUS_USER_ADDED',                 100 );
define( 'STATUS_WORKSHOPS_NOT_EMPTY',        200 );
define( 'STATUS_USER_REQUIRED_FIELDS_EMPTY', 201 );
define( 'STATUS_USER_EMAIL_MALFORMED',       202 );
define( 'STATUS_USER_EMAIL_IN_USE',          203 );
define( 'STATUS_CANT_STORE_USER',            204 );
define( 'STATUS_SAME_WORKSHOPS',             205 );

define( 'TABLE_USER', 'fachtagung_teilnehmer' );
define( 'EXPORT_FOLDER', 'fachtagung' );

define( 'OPTION_MAIL_SUBJECT',  'fachtagung_mail_subject' );
define( 'OPTION_MAIL_MESSAGE',  'fachtagung_mail_message' );



/* Funktionsbibliothek einbinden */

require_once( get_template_directory() . '/inc/classes/class-modified-list-table.php' );
require_once( get_template_directory() . '/inc/classes/class-user-list-table.php' );

require_once( get_template_directory() . '/inc/block-editor.php' );
require_once( get_template_directory() . '/inc/core.php' );
require_once( get_template_directory() . '/inc/setup.php' );
require_once( get_template_directory() . '/inc/users.php' );

require_once( get_template_directory() . '/inc/shortcodes/shortcode-workshops.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-form.php' );
