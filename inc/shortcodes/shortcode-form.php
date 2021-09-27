<?php
/**
 * Shortcode [form]
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtagung
 */


defined( 'ABSPATH' ) or exit;



/**
 * Shortcode zum Erzeugen eines Formulars, mit denen sich Personen als Teilnehmer eintragen können
 *
 * @since   1.0.0
 *
 * @param   array   $atts   die Attribute (Parameter) des Shorcodes
 * @return  string          die vom Shortcode erzeugte Ausgabe
 */

function mdb_shortcode_form( $atts, $content = null )
{
    $code = 0;
    $user = array();

    /* Formular bearbeiten, wenn bereits abgesendet */

    if( isset( $_POST['action'] ) ) :

        if( true === isset( $_POST['field_lastname'] ) ) :
            $user['lastname'] = $_POST['field_lastname'];
        endif;

        if( true === isset( $_POST['field_forename'] ) ) :
            $user['forename'] = $_POST['field_forename'];
        endif;

        if( true === isset( $_POST['field_email'] ) ) :
            $user['email'] = $_POST['field_email'];
        endif;

        if( true === isset( $_POST['field_location'] ) ) :
            $user['location'] = $_POST['field_location'];
        endif;

        if( true === isset( $_POST['field_institution'] ) ) :
            $user['institution'] = $_POST['field_institution'];
        endif;

        if( true === isset( $_POST['field_function'] ) ) :
            $user['function'] = $_POST['field_function'];
        endif;

        if( true === isset( $_POST['field_dob'] ) ) :
            $user['dob'] = $_POST['field_dob'];
        endif;

        if( true === isset( $_POST['field_vormittag'] ) ) :
            $user['vormittag'] = $_POST['field_vormittag'];
        endif;

        if( true === isset( $_POST['field_nachmittag'] ) ) :
            $user['nachmittag'] = $_POST['field_nachmittag'];
        endif;

        $code = mdb_add_user( $user );

        if( STATUS_USER_ADDED === $code ) :
            $user = array();
        endif;

    endif;


    /* Ausgabe des Shortcodes */

    ob_start();

    if( 0 !== $code ) :
        mdb_display_notice( $code );
    endif;

?>
<form id="form_teilnehmer" method="post" action="">

    <h3 class="has-heath-color has-text-color">Ihre/Eure Daten</h3>

    <div class="frm_fields">

        <div class="frm_field frm_field_half">
            <label>Vorname</label>
            <div class="control">
                <input id="vorname" name="field_forename" type="text" value="<?php echo $user['forename']; ?>">
            </div>
        </div>

        <div class="frm_field frm_field_half">
            <label>Nachname</label>
            <div class="control">
                <input id="nachnahme" name="field_lastname" type="text" value="<?php echo $user['lastname']; ?>">
            </div>
        </div>

        <div class="frm_field">
            <label>E-Mail</label>
            <div class="control">
                <input id="mail" name="field_email" type="email" value="<?php echo $user['email']; ?>">
            </div>
        </div>

        <div class="frm_field frm_field_two_third">
            <label>Ort</label>
            <div class="control">
                <input id="ort" name="field_location" type="text" value="<?php echo $user['location']; ?>">
            </div>
        </div>

        <div class="frm_field">
            <label>Institution/Organisation</label>
            <div class="control">
                <input id="orga" name="field_institution" type="text" value="<?php echo $user['institution']; ?>">
            </div>
        </div>

        <div class="frm_field">
            <label>Funktion</label>
            <div class="control">
                <input id="funktion" name="field_function" type="text" value="<?php echo $user['function']; ?>">
            </div>
        </div>

        <div class="frm_field frm_field_half">
            <label>Geburtsdatum</label>
            <div class="control">
                <input id="geburtsdatum" name="field_dob" type="text" value="<?php echo $user['dob']; ?>">
            </div>
        </div>

    </div>

    <h3 class="has-heath-color has-text-color frm-more-space">Ihre/Eure Wahl der Workshops</h3>

    <div class="frm_fields">
    <?php

    $workshops = get_posts( array(
        'post_type'      => 'workshop',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'order'          => 'asc',
        'orderby'        => 'publish_date',
    ) );

    if( $workshops ) :
    ?>
        <div class="frm_field frm_field_row frm_label">
            <span>Thema</span>
            <span><span class="kurz">Vorm.</span><span class="lang">Vormittag</span></span>
            <span><span class="kurz">Nachm.</span><span class="lang">Nachmittag</span></span>
        </div>

    <?php

        foreach( $workshops as $workshop ) :
            $ws_id              = get_field( 'id', $workshop->ID );
            $ws_titel           = get_field( 'titel', $workshop->ID );
            $ws_freie_plaetze_1 = get_field( 'freie_plaetze_am_vormittag', $workshop->ID );
            $ws_freie_plaetze_2 = get_field( 'freie_plaetze_am_nachmittag', $workshop->ID );

            echo '<div class="frm_field frm_field_row">';

            echo sprintf(
                '<span>%1$s</span>',
                $ws_titel
            );

            for( $loopcount = 0; $loopcount != 2; $loopcount++ ) :

                $disabled   = '';
                $checked    = '';
                $free       = (0 == $loopcount)? $ws_freie_plaetze_1 : $ws_freie_plaetze_2;
                $posted_id  = (0 == $loopcount)? $user['vormittag'] : $user['nachmittag'];
                $name       = (0 == $loopcount)? 'field_vormittag' : 'field_nachmittag';

                if( $posted_id === $ws_id ) :
                    $checked = 'checked="checked"';
                endif;

                if( 0 === $free ) :
                    $disabled = 'disabled="disabled"';
                    $checked  = '';
                endif;

                echo sprintf(
                    '<span><input type="radio" name="%4$s" value="%1$s" %2$s %3$s></span>',
                    $ws_id,
                    $disabled,
                    $checked,
                    $name,
                );
            endfor;

            echo '</div>';

        endforeach;
    endif;

    ?>
    </div>

    <h3 class="has-heath-color has-text-color frm-more-space">Teilnahmebedingungen</h3>

    <div class="frm_fields">
        <div class="frm_field" style="padding-top: 0">
            <p>Hiermit melde ich mich verbindlich zum Fachtag Beteiligung an; sollte ich doch verhindert sein, werde ich mich frühzeitig abmelden und meinen Platz einer anderen Person zur Verfügung stellen. Mit der Speicherung und Verarbeitung meiner Daten gemäß der Datenschutzerklärung erkläre ich mich einverstanden. Ich bin damit einverstanden, dass bei der Veranstaltung Foto-, Video- und Audioaufnahmen (u.a. durch die Veranstalter und Presse) angefertigt und diese veröffentlicht werden.</p>
            <p><strong>Hygienekonzept:</strong> Für die Veranstaltung wird es ein an die aktuellen Bestimmungen angepasstes Hygienekonzept geben. Wir bitten die Überprüfung des Impfstatus vor Ort möglich zu machen.</p>
        </div>
    </div>

    <div class="frm_fields">
        <div class="frm_field">
            <div class="control">
                <input type="checkbox" id="field_check" name="field_check">
                <label for="field_check">Ich erkläre mich mit den Teilnahmebedingungen einverstanden.</span>
            </div>
        </div>
    </div>

    <div class="frm_fields">
        <div class="frm_field frm_field_submit">
            <div class="control">
                <button id="submit" type="submit" name="action" value="add" disabled="disabled">Verbindlich anmelden</button>
            </div>
        </div>
    </div>

</form>
<?php
    wp_enqueue_script( 'fachtagung-frm-script', get_template_directory_uri() . '/assets/js/form.js', array( 'jquery' ), false, true );

    $output_buffer .= ob_get_contents();
    ob_end_clean();
    return $output_buffer;
}

add_shortcode( 'form', 'mdb_shortcode_form' );
