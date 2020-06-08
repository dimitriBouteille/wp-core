<?php


namespace Dbout\WpCore\MuPlugins;

/**
 * Class DisableUpdate
 * @package Dbout\WpCore\MuPlugins
 *
 * https://github.com/Little-sumo-labs/mu-plugins-for-wordpress/blob/master/wp-disable-update.php
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class DisableUpdate
{

    /**
     * @return void
     */
    public static function disable()
    {
        add_action('init', function () {
            if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();

                if ($current_user->roles[0] !== "administrator") {
                    // Disable Update WordPress nag
                    add_action('after_setup_theme','wpc_remove_core_updates');

                    // Disable Plugin Update Notifications
                    remove_action('load-update-core.php','wp_update_plugins');
                    add_filter('pre_site_transient_update_plugins','__return_null');

                    // Disable all the Nags & Notifications
                    function wpc_remove_core_updates(){
                        global $wp_version;

                        return(object) array(
                            'last_checked'=> time(),
                            'version_checked'=> $wp_version
                        );
                    }

                    add_filter('pre_site_transient_update_core','wpc_remove_core_updates');
                    add_filter('pre_site_transient_update_plugins','wpc_remove_core_updates');
                    add_filter('pre_site_transient_update_themes','wpc_remove_core_updates');

                    add_action('admin_menu', 'wpc_wphidenag'); // Hide WordPress Update Alert
                    function wpc_wphidenag() {
                        remove_action('admin_notices', 'update_nag', 3);
                    }
                }
            }
        });
    }
}
