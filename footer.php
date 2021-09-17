<?php
/**
 * Template für den Fußbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-fachtag
 */


defined( 'ABSPATH' ) or exit;


?>
            <footer class="footer-wrapper">
                <div class="footer-wrapper__inner-container">

                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'secondary',
                        'container'      => 'nav',
                        'container_id'   => 'secondary',
                        'link_before'    => '<span class="a-tag__inner-html">',
                        'link_after'     => '</span>',
                    ) );
                    ?>

                </div>
            </footer>

        </main>

        <?php wp_footer(); ?>

    </body>

</html>
