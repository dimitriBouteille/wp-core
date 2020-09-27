<?php

namespace Dbout\WpCore;

/**
 * Class WpUploadDirHelper
 * @package Dbout\WpCore
 *
 * https://developer.wordpress.org/reference/functions/wp_upload_dir/
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WpUploadDirHelper
{

    /**
     * @return string
     */
    public static function path(): string
    {
        return self::getProperty('path');
    }

    /**
     * @return string
     */
    public static function url(): string
    {
        return self::getProperty('url');
    }

    /**
     * @return string
     */
    public static function subDir(): string
    {
        return self::getProperty('subdir');
    }

    /**
     * @return string
     */
    public static function baseDir(): string
    {
        return self::getProperty('basedir');
    }

    /**
     * @return string
     */
    public static function baseUrl(): string
    {
        return self::getProperty('baseurl');
    }

    /**
     * @param string $name
     * @return string|null
     */
    private static function getProperty(string $name): ?string
    {
        $data = wp_upload_dir();
        if(key_exists($name, $data)) {
            return $data[$name];
        }

        return null;
    }
}