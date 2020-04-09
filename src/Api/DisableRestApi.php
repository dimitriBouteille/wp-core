<?php

namespace Dbout\WpCore\Api;

/**
 * Class DisableRestApi
 * @package Dbout\WpCore\Api
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class DisableRestApi
{

    /**
     * @return void
     */
    public static function disable(): void
    {
        add_filter('rest_authentication_errors', function($result) {

            if ( ! empty( $result ) ) {
                return $result;
            }
            if ( ! is_user_logged_in() ) {
                return new \WP_Error( 'invalid_access', 'Oops, impossible d\'accéder à cette page :(' );
            }
        });
    }

}