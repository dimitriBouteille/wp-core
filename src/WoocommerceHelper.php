<?php

namespace Dbout\WpCore;

/**
 * Class WoocommerceHelper
 * @package Dbout\WpCore
 *
 * https://developer.wordpress.org/reference/functions/wp_upload_dir/
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WoocommerceHelper
{

    /**
     * @var array
     */
    protected static $urls = [];

    /**
     * @return string|null
     */
    public static function getCartUrl(): ?string
    {
        return self::getUrl('cart');
    }

    /**
     * @return string|null
     */
    public static function getAccountUrl(): ?string
    {
        return self::getUrl('myaccount');
    }

    /**
     * @return string|null
     */
    public static function getShopUrl(): ?string
    {
        return self::getUrl('shop');
    }

    /**
     * @return string|null
     */
    public static function getCheckoutUrl(): ?string
    {
        return self::getUrl('checkout');
    }

    /**
     * @return string|null
     */
    public static function getAccountOrdersUrl(): ?string
    {
        return self::getAccountEndpoint('orders');
    }

    /**
     * @return string|null
     */
    public static function getAccountDownloadsUrl(): ?string
    {
        return self::getAccountEndpoint('downloads');
    }

    /**
     * @return string|null
     */
    public static function getAccountEditUrl(): ?string
    {
        return self::getAccountEndpoint('edit-account');
    }

    /**
     * @return string|null
     */
    public static function getAccountLogoutUrl(): ?string
    {
        return self::getAccountEndpoint('customer-logout');
    }

    /**
     * @return string|null
     */
    public static function getAccountLostPassword(): ?string
    {
        return self::getAccountEndpoint('lost-password');
    }

    /**
     * @param string $key
     * @return string|null
     */
    public static function getUrl(string $key): ?string
    {
        if (!self::isActivated()) {
            return null;
        }

        if (!key_exists($key, self::$urls)) {
            self::$urls[$key] = wc_get_page_permalink($key);
        }

        return self::$urls[$key];
    }

    /**
     * @param string $key
     * @return string|null
     */
    public static function getAccountEndpoint(string $key): ?string
    {
        if (!self::isActivated()) {
            return null;
        }

        if (!key_exists($key, self::$urls)) {
            self::$urls[$key] = wc_get_account_endpoint_url($key);
        }

        return self::$urls[$key];
    }

    /**
     * Check if Woocommerce plugin is activated
     *
     * @return bool
     */
    public static function isActivated(): bool
    {
        $pluginList = get_option('active_plugins');
        return in_array('woocommerce/woocommerce.php', $pluginList);
    }

    /**
     * Get Woocommerce plugin version
     *
     * @return string|null
     */
    public static function getVersion(): ?string
    {
        if (self::isActivated()) {
            global $woocommerce;
            return $woocommerce->version;
        }

        return null;
    }
}
