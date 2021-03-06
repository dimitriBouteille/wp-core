<?php

namespace Dbout\WpCore;

/**
 * Class UrlHelper
 * @package Dbout\WpCore
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class UrlHelper
{

    /**
     * @return string
     */
    public static function getCurrentUrl()
    {
        $pageURL = self::getScheme()."://";
        if ( isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] && $_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
            $pageURL .= self::getHost().":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= self::getHost().$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    /**
     * Check if url is an URL
     *
     * @param string|null $url
     * @return bool
     */
    public static function isUrl(?string $url): bool
    {
        if (!is_string($url)) {
            return false;
        }

        return filter_var($url, FILTER_VALIDATE_URL) === FALSE;
    }

    /**
     * @return string
     */
    public static function getScheme(): string
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    }

    /**
     * @return string|null
     */
    public static function getHost(): ?string
    {
        if ( isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] ) {
            return $_SERVER['HTTP_HOST'];
        }
        if ( isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] ) {
            return $_SERVER['SERVER_NAME'];
        }

        return null;
    }

    /**
     * @param string|null $url
     * @return bool
     */
    public static function isLocal(?string $url): bool
    {
        if (!$url) {
            return false;
        }

        return strstr($url, self::getHost());
    }
}
