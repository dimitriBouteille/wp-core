<?php

namespace Dbout\WpCore;

/**
 * Class Site
 * @package Dbout\WpCore
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
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class Site
{

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var string|null
     */
    public ?string $url;

    /**
     * @var string|null
     */
    public ?string $siteUrl;

    /**
     * @var string|null
     */
    public ?string $language;

    /**
     * @var string|null
     */
    public ?string $charset;

    /**
     * @var string|null
     */
    public ?string $adminEmail;

    /**
     * @var string|null
     */
    public ?string $pingbackUrl;

    /**
     * @var string|null
     */
    public ?string $atomUrl;

    /**
     * @var string|null
     */
    public ?string $rdfUrl;

    /**
     * @var string|null
     */
    public ?string $rssUrl;

    /**
     * @var string|null
     */
    public ?string $rss2Url;

    /**
     * @var string|null
     */
    public ?string $wpVersion;

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
    }

    /**
     * @param string $key
     * @return string|null
     */
    protected function getInfo(string $key): ?string
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
