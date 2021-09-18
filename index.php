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
            <div class="container">

                <?php
                if( have_posts() ) :
                    while( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
                
            </div>
        </main>

<?php
get_footer();
