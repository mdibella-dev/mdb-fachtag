<?php
/**
 * Block Editor (aka Gutenberg)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */



defined( 'ABSPATH' ) or exit;



/**
 * Script- und Stil-Modifikationen für den Block Editor
 *
 * @source  https://die-netzialisten.de/wordpress/gutenberg-breite-des-editors-anpassen/
 * @source  https://www.billerickson.net/block-styles-in-gutenberg/
 * @since   1.0.0
 */

function mdb_enqueue_block_editor_assets() {
    // Parent
    wp_enqueue_script(
        'block-editor',
        get_template_directory_uri() . '/assets/js/block-editor.js',
        array( 'wp-blocks', 'wp-dom' ),
        0,
        true
    );
}

add_action( 'enqueue_block_editor_assets', 'mdb_enqueue_block_editor_assets' );
