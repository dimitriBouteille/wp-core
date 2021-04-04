<?php

namespace Dbout\WpCore;

/**
 * Class Theme
 * @package Dbout\WpCore
 *
 * https://developer.wordpress.org/reference/functions/wp_get_theme/
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class Theme
{

    /**
     * @var \WP_Theme
     */
    private $config = [];

    /**
     * @var self
     */
    private static self $instance;

    /**
     * Theme constructor.
     * @param \WP_Theme $themeConfig
     */
    private function __construct(\WP_Theme $themeConfig)
    {
        $this->config = $themeConfig;
    }

    /**
     * Get theme name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->get('Name');
    }

    /**
     * Get theme uri
     *
     * @return string|null
     */
    public function uri(): ?string
    {
        return $this->get('ThemeURI');
    }

    /**
     * Get theme description
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->get('description');
    }

    /**
     * Get theme author name
     *
     * @return string
     */
    public function author(): string
    {
        return $this->get('Author');
    }

    /**
     * Get theme author URI
     *
     * @return string|null
     */
    public function authorUri(): ?string
    {
        return $this->get('AuthorURI');
    }

    /**
     * Get theme version
     *
     * @return string
     */
    public function version(): string
    {
        return $this->get('Version');
    }

    /**
     * Get theme text domain
     *
     * @return string
     */
    public function textDomain(): string
    {
        return $this->get('TextDomain');
    }

    /**
     * Get theme tags
     *
     * @param bool $array
     * @return array|false|string
     */
    public function tags(bool $array = true)
    {
        $tags = $this->get('Tags');
        if(!$array) {
            return $tags;
        }

        return explode(',', $tags);
    }

    /**
     * Get theme template
     *
     * @return string|null
     */
    public function template(): ?string
    {
        return $this->get('Template');
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if(!self::$instance) {
            self::$instance = new self(wp_get_theme());
        }

        return self::$instance;
    }

    /**
     * Get theme parameter
     *
     * @param string $paramName
     * @return false|string
     */
    public function get(string $paramName)
    {
        return $this->config->get($paramName);
    }

    /**
     * @return \WP_Theme
     */
    public function getConfig(): \WP_Theme
    {
        return $this->config;
    }
}
