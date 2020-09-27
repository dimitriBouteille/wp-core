<?php

namespace Dbout\WpCore;

use Symfony\Component\Mime\MimeTypes;

/**
 * Class FileHelper
 * @package Dbout\WpCore
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class FileHelper
{

    /**
     * Check if file is an SVG
     *
     * @param string|null $file
     * @return bool
     */
    public static function isSvg(?string $file): bool
    {
        $mimeType = self::getMimeType($file);
        if (!$mimeType) {
            return false;
        }

        return in_array($mimeType, [
            'image/svg+xml',
            'text/html',
            'text/plain',
            'image/svg',
        ]);
    }

    /**
     * Check if file is an Video
     *
     * @param string|null $file
     * @return bool
     */
    public static function isVideo(?string $file): bool
    {
        $mimeType = self::getMimeType($file);
        if (!$mimeType) {
            return false;
        }

        return strpos($mimeType, 'video') === 0;
    }

    /**
     * Check if file is an Image
     *
     * @param string|null $file
     * @return bool
     */
    public static function isImage(?string $file): bool
    {
        $mimeType = self::getMimeType($file);
        if (!$mimeType) {
            return false;
        }

        return strpos($mimeType, 'image') === 0;
    }

    /**
     * Check if file exist
     *
     * @param string|null $file
     * @return bool
     */
    private static function exist(?string $file): bool
    {
        return empty($file) || !file_exists($file);
    }

    /**
     * Get file mimetype
     *
     * @param string|null $file
     * @return string|null
     */
    public static function getMimeType(?string $file): ?string
    {
        if(self::exist($file)) {
            return null;
        }

        $mimeType = null;
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if ($extension) {
            $mimeType = (new MimeTypes())->guessMimeType($extension);
        }

        return $mimeType;
    }
}