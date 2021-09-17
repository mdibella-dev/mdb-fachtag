<?php
/**
 * Template für Seiten/Beträge aller Art (Fallback)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */


defined( 'ABSPATH' ) or exit;


get_header();
?>

        <main id="main">

            <?php
            if( have_posts() ) :
                while( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>

<?php
get_footer();
