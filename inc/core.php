<?php
/**
 * Core-Funktionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */


defined( 'ABSPATH' ) or exit;


/**
 * Fügt einen Benutzer hinzu
 *
 * @since   1.0.0
 *
 * @param   array  $user    die Teilnehmerdaten
 * @return  int    ein Statuscode
 */

function mdb_add_user( $user, $unique_id ) {
    // Sind noch Plätze frei?
    if( ( false == mdb_check_empty( $user['vormittag'], true ) ) or
        ( false == mdb_check_empty( $user['nachmittag'], false ) ) ) :
        return STATUS_WORKSHOPS_NOT_EMPTY;
    endif;


    // Zweimal die gleichen Workshops ausgewählt
    if(  $user['vormittag'] == $user['nachmittag'] ) :
        return STATUS_SAME_WORKSHOPS;
    endif;


    // Leere Felder übergeben?
    if( empty( $user['forename'] ) or
        empty( $user['lastname'] ) or
        empty( $user['email'] ) ) :
        return STATUS_USER_REQUIRED_FIELDS_EMPTY;
    endif;


    // Ist das Format der E-Mail gültig?
    if( !filter_var( $user['email'], FILTER_VALIDATE_EMAIL ) ) :
        return STATUS_USER_EMAIL_MALFORMED;
    endif;


    // Plätze reduzieren
    mdb_reduce_empty( $user['vormittag'], true );
    mdb_reduce_empty( $user['nachmittag'], false );

    // User eintragen
    global  $wpdb;
            $table_name = $wpdb->prefix . TABLE_USER;
            $table_data = array(
                'user_lastname'    => $user['lastname'],
                'user_forename'    => $user['forename'],
                'user_email'       => $user['email'],
                'user_location'    => $user['location'],
                'user_institution' => $user['institution'],
                'user_function'    => $user['function'],
                'user_dob'         => $user['dob'],
                'user_vormittag'   => $user['vormittag'],
                'user_nachmittag'  => $user['nachmittag'],
                'unique_id'        => $unique_id,
            );


    // War die Eintragung des Users erfolgreich?
    if( 0 === $wpdb->insert( $table_name, $table_data ) ) :
        return STATUS_CANT_STORE_USER;
    endif;

    return STATUS_USER_ADDED;
}



/**
 * Prüft ob beim angegebenen Workshop noch ein Platz frei ist
 *
 * @since   1.0.0
 *
 * @param   int  $ws_id         workshop-ID
 * @param   bool $vormittag
 * @return  bool false = nicht frei, true = frei
 */

function mdb_check_empty( $ws_id, $vormittag )
{
    $workshops = get_posts( array(
        'post_type'      => 'workshop',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_key'       => 'id',
        'meta_value'     => $ws_id,
    ) );

    if( $workshops ) :

        foreach( $workshops as $workshop ) :

            $field_id    = ( true === $vormittag )? 'freie_plaetze_am_vormittag' : 'freie_plaetze_am_nachmittag';
            $field_value = (int) get_field( $field_id, $workshop->ID );

            if( 0 != $field_value ) :
                return true;
            endif;

        endforeach;

    endif;

    return false;
}



/**
 * Reduziert die Anzahl an Plätzen im Workshop
 *
 * @since   1.0.0
 *
 * @param   int  $ws_id         workshop-ID
 * @param   bool $vormittag
 */

function mdb_reduce_empty( $ws_id, $vormittag )
{
    $workshops = get_posts( array(
        'post_type'      => 'workshop',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_key'       => 'id',
        'meta_value'     => $ws_id,
    ) );

    if( $workshops ) :

        foreach( $workshops as $workshop ) :

            $field_id    = ( true === $vormittag )? 'freie_plaetze_am_vormittag' : 'freie_plaetze_am_nachmittag';
            $field_value = get_field( $field_id, $workshop->ID );

            $field_value--;
            update_field( $field_id, $field_value, $workshop->ID );
            return true;

        endforeach;

    endif;

    return false;
}



/**
 * Gibt einen Hinweis passend zum jeweiligen Statuscode aus
 *
 * @since   1.0.0
 *
 * @param   int     $code    der Statuscode
 */

function mdb_display_notice( $code )
{
    $status = array(
        STATUS_USER_ADDED => array(
            'notice' => 'Ihre Anmeldung war erfolgreich!',
            'style'  => 'notice-sucess',
        ),
        STATUS_WORKSHOPS_NOT_EMPTY => array(
            'notice' => 'Bei einem oder bei beiden ausgewählten Workshops ist kein freier Platz mehr verfügbar!<br>Bitte versuchen Sie es erneut.',
            'style'  => 'notice-info',
        ),
        STATUS_SAME_WORKSHOPS => array(
            'notice' => 'Es wurden zweimal die gleichen Workshops gewählt!<br>Bitte Auswahl korrigieren.',
            'style'  => 'notice-info',
        ),
        STATUS_USER_REQUIRED_FIELDS_EMPTY => array(
            'notice' => 'Ein oder mehrere zwingend benötigte Felder sind nicht ausgefüllt.',
            'style'  => 'notice-warning',
        ),
        STATUS_USER_EMAIL_MALFORMED => array(
            'notice' => 'Bitte geben Sie eine korrekte E-Mail-Adresse ein.',
            'style'  => 'notice-warning',
        ),
        STATUS_USER_EMAIL_IN_USE => array(
            'notice' => 'Ihre E-Mail-Adresse wurde bereits verwendet. Sie kann nicht ein weiteres mal verwendet werden.',
            'style'  => 'notice-warning',
        ),
        STATUS_CANT_STORE_USER => array(
            'notice' => 'Ein technischer Fehler ist aufgetreten.',
            'style'  => 'notice-error',
        ),
    );

    if( array_key_exists( $code, $status ) ) :
?>
<div class="notice <?php echo $status[ $code ]['style']; ?>">
    <p><?php echo $status[ $code ]['notice']; ?></p>
</div>
<?php
    endif;

}



/**
 * Exportiert die Teilnehmerliste als CSV
 *
 * @since   1.0.0
 * @todo    - Anwendung von $event-id innerhalb der SQL-Abfrage
 *
 * @return  bool    FALSE im Fehlerfall
 * @return  array   Informationen zur Export-Datei im Erfolgsfall
 */

function mdb_create_user_export_file()
{
    $uploads   = wp_upload_dir();
    $file_name = 'fachtagung-export-' . date( "Y-m-d" ) . '.csv';
    $file_info = array(
        'name' => $file_name,
        'path' => $uploads['basedir'] . '/' . EXPORT_FOLDER . '/' . $file_name,
        'url'  => $uploads['baseurl'] . '/' . EXPORT_FOLDER . '/' . $file_name,
    );

    // Datei öffnen
    $file = fopen( $file_info['path'], 'w' );

    if( false === $file) :
        return null;
    endif;

    // Kopfzeile in Datei schreiben
    $row = array( 'Nachname', 'Vorname', 'E-Mail', 'Ort', 'Geburtsdatum', 'Funktion', 'Institution', 'Vormittag', 'Nachmittag', 'Anmeldezeitpunkt' );
    fputcsv( $file, $row, ';' );

    // Daten abrufen und in Datei schreiben
    global $wpdb;

    $table_name = $wpdb->prefix . TABLE_USER;
    $sql        = "SELECT user_lastname, user_forename, user_email, user_location, user_dob, user_function, user_institution, user_vormittag, user_nachmittag, user_registered FROM $table_name";
    $table_data = $wpdb->get_results( $sql, 'ARRAY_A' );

    foreach( $table_data as $row ) :
        fputcsv( $file, $row, ';' );
    endforeach;

    // Datei schließen
    fclose( $file );

    return $file_info;
}
