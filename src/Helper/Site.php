<?php

namespace Dbout\WpCore\Helper;

use http\Encoding\Stream;

/**
 * Class Site
 * @package Dbout\WpCore\Helper
 *
 * @method string name();
 * @method string description();
 * @method string url();
 * @method string siteUrl();
 * @method string language();
 * @method string charset();
 * @method string adminEmail();
 * @method string pingbackUrl();
 * @method string atomUrl();
 * @method string rdfUrl();
 * @method string rssUrl();
 * @method string wpVersion();
 * @method Theme theme();
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class Site
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $siteUrl;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $charset;

    /**
     * @var string|null
     */
    public $adminEmail;

    /**
     * @var string|null
     */
    public $pingbackUrl;

    /**
     * @var string
     */
    public $atomUrl;

    /**
     * @var string
     */
    public $rdfUrl;

    /**
     * @var string
     */
    public $rssUrl;

    /**
     * @var string
     */
    public $rss2Url;

    /**
     * @var string
     */
    public $wpVersion;

    /**
     * @var Theme
     */
    public $theme;

    /**
     * Site constructor.
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
        $this->name = $this->getInfo('name');
        $this->description = $this->getInfo('description');
        $this->url = $this->getInfo('url');
        $this->siteUrl = site_url();
        $this->language = $this->getInfo('language');
        $this->charset = $this->getInfo('charset');
        $this->adminEmail = $this->getInfo('admin_email');
        $this->wpVersion = $this->getInfo('version');
        $this->pingbackUrl = $this->getInfo('pingback_url');
        $this->atomUrl = $this->getInfo('atom_url');
        $this->rdfUrl = $this->getInfo('rdf_url');
        $this->rssUrl = $this->getInfo('rss_url');
        $this->rss2Url = $this->getInfo('rss2_url');

        $this->theme = Theme::getInstance();
    }

    /**
     * @param string $key
     * @return string|void
     */
    protected function getInfo(string $key)
    {
        return get_bloginfo($key);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if(property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new \Exception(sprintf("Property %s not found", $name));
    }
}
