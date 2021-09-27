<?php
/**
 * Teilnehmerübersicht
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */


defined( 'ABSPATH' ) or exit;



/**
 * Erzeugt einen Menüpunkt für die Teilnehmerübersicht im Backend
 *
 * @since   1.0.0
 */

function mdb_add_userpage_to_admin_menu()
{
    add_menu_page(
        'Teilnehmer',
        'Teilnehmer',
        'manage_options',
        'mdb_userpage',
        'mdb_show_userpage',
		'dashicons-groups',
		20,
    );
}

add_action( 'admin_menu', 'mdb_add_userpage_to_admin_menu' );



/**
 * Anzeige der Teilnehmerübersicht
 *
 * @since   1.0.0
 */

function mdb_show_userpage()
{
?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo 'Teilnehmer'; ?></h1>
        <br><br>
        <?php
            // Tabelle anzeigen
            $user_table = new MDB_User_List_Table();
            $user_table->prepare_items();
            $user_table->display();


            // Möglichkeit zum Download der Exportdatei anzeigen
            $file_info = mdb_create_user_export_file();

            if( false !== $file_info ) :
        ?>
        <br><br><a class="button button-primary" href="<?php echo $file_info['url']; ?>" download><?php echo 'Daten als CSV exportieren'; ?></a>
        <?php
            endif;
        ?>
    </div>
<?php
}
