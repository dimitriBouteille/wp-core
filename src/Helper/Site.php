<?php

namespace Dbout\WpCore\Helper;

/**
 * Class Site
 * @package Dbout\WpCore\Helper
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class Site
{

    /**
     * Get site name
     *
     * @return string
     */
    public static function name(): string
    {
        return self::get('name');
    }

    /**
     * Get site description
     *
     * @return string
     */
    public static function description(): string
    {
        return self::get('description');
    }

    /**
     * Get site url
     *
     * @return string
     */
    public static function url(): string
    {
        return self::get('url');
    }

    /**
     * Get current language code
     *
     * @return string|null
     */
    public static function language(): ?string
    {
        return self::get('language');
    }

    /**
     * Get encoding
     *
     * @return string|null
     */
    public static function charset(): ?string
    {
        return self::get('charset');
    }

    /**
     * Get admin email
     *
     * @return string|null
     */
    public static function adminEmail(): ?string
    {
        return self::get('admin_email');
    }

    /**
     * Get current Wordpress version
     *
     * @return string|null
     */
    public static function currentWpVersion()
    {
        return self::get('version');
    }

    /**
     * Get pingback XML-RPC file URL
     *
     * @return string|null
     */
    public static function pingBackUrl()
    {
        return self::get('pingback_url');
    }

    /**
     * Get Atom feed url
     *
     * @return string|null
     */
    public static function atomUrl()
    {
        return self::get('atom_url');
    }

    /**
     * Get RDF/RSS 1.0 feed URL
     *
     * @return string|null
     */
    public static function rdfUrl()
    {
        return self::get('rdf_url');
    }

    /**
     * Get RSS 0.92 feed URL
     *
     * @return string|null
     */
    public static function rssUrl()
    {
        return self::get('rss_url');
    }

    /**
     * Get RSS 2.0 feed URL
     *
     * @return string|null
     */
    public static function rss2Url()
    {
        return self::get('rss2_url');
    }

    /**
     * Get comments Atom feed URL
     *
     * @return string|null
     */
    public static function commentsAtomUrl()
    {
        return self::get('comments_atom_url');
    }

    /**
     * Get comments RSS 2.0 feed URL
     *
     * @return string|null
     */
    public static function commentsRss2Url()
    {
        return self::get('comments_rss2_url');
    }

    /**
     * @param string $optionName
     * @return string|null
     */
    protected static function get(string $optionName): ?string
    {
        return get_bloginfo($optionName);
    }

}