<?php

namespace Dbout\WpCore\Helper;

/**
 * Class WcUrl
 * @package Dbout\WpCore\Helper
 *
 * https://wpcrumbs.com/how-to-get-woocommerce-page-urls-in-woocommerce-3-x/
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WcUrl
{

    /**
     * Get account url
     *
     * @return string|null
     */
    public static function myAccount(): ?string
    {
        return static::getUrl('myaccount');
    }

    /**
     * Get account endpoint url
     *
     * @param string $endpoint
     * @return string|null
     */
    public static function accountEndpoint(string $endpoint): ?string
    {
        return wc_get_account_endpoint_url($endpoint);
    }

    /***
     * Get shop url
     *
     * @return string|null
     */
    public static function shop(): ?string
    {
        return static::getUrl('shop');
    }

    /**
     * Get cart url
     *
     * @return string|null
     */
    public static function cart(): ?string
    {
       return static::getUrl('cart');
    }

    /**
     * Get checkout url
     *
     * @return string|null
     */
    public static function checkout(): ?string
    {
        return static::getUrl('checkout');
    }

    /**
     * @param string $name
     * @return string|null
     */
    protected static function getUrl(string $name): ?string
    {
        return wc_get_page_permalink($name);
    }

}