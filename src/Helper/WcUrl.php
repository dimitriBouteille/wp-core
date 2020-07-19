<?php

namespace Dbout\WpCore\Helper;

/**
 * Class WcUrl
 * @package Dbout\WpCore\Helper
 *
 * https://wpcrumbs.com/how-to-get-woocommerce-page-urls-in-woocommerce-3-x/
 * @method string account();
 * @method string cart();
 * @method string shop();
 * @method string checkout();
 * @method string accountOrders();
 * @method string accountDownloads();
 * @method string accountEdit();
 * @method string accountAddress();
 * @method string accountPaymentMethods();
 * @method string accountLostPassword();
 * @method string accountLogout();
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WcUrl
{

    /**
     * @var string[]
     */
    protected $urls = [];

    /**
     * WcUrl constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Init class
     */
    protected function init(): void
    {
        $this->urls = [
            'account' => $this->getUrl('myaccount'),
            'cart' => $this->getUrl('cart'),
            'shop' => $this->getUrl('shop'),
            'checkout' => $this->getUrl('checkout'),
            'accountOrders' => $this->getAccountEndpoint('orders'),
            'accountDownloads' => $this->getAccountEndpoint('downloads'),
            'accountEdit' => $this->getAccountEndpoint('edit-account'),
            'accountAddress' => $this->getAccountEndpoint('edit-address'),
            'accountPaymentMethods' => $this->getAccountEndpoint('payment-methods'),
            'accountLostPassword' => $this->getAccountEndpoint('lost-password'),
            'accountLogout' => $this->getAccountEndpoint('customer-logout'),
        ];
    }

    /**
     * @param string $endpoint
     * @return string|null
     */
    public function getAccountEndpoint(string $endpoint): ?string
    {
        if($this->wooIsActivated()) {
            return wc_get_account_endpoint_url($endpoint);
        }

        return null;
    }

    /**
     * @param string $name
     * @return string|null
     */
    protected function getUrl(string $name): ?string
    {
        if($this->wooIsActivated()) {
            return wc_get_page_permalink($name);
        }

        return null;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if(key_exists($name, $this->urls)) {
            return $this->urls[$name];
        }

        throw new \Exception(sprintf("The url %s not found", $name));
    }

    /**
     * @return bool
     */
    private function wooIsActivated(): bool
    {
        return class_exists('woocommerce');
    }
}
