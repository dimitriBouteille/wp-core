<?php

namespace Dbout\WpCore\View\Twig\Extensions;

use Dbout\WpCore\FileHelper;
use Dbout\WpCore\Site;
use Dbout\WpCore\Theme;
use Dbout\WpCore\UrlHelper;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class WordpressExtension
 * @package Dbout\WpCore\View\Twig\Extensions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WordpressExtension extends AbstractExtension implements GlobalsInterface
{

    /**
     * Register global variable in Twig templates
     * The global variable _ can be used to call any PHP and Wordpress functions
     *
     * @return array
     */
    public function getGlobals(): array
    {
        return [
            '_' => $this,
            'wp_ajax_url' => _wp_ajax_url(),
            'theme' => Theme::getInstance(),
            'site' => new Site(),
        ];
    }

    /**
     * Allows to call PHP and Wordpress core functions inside twig templates
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array($name, $arguments);
    }

    /**
     * Register a list of Wordpress functions inside Twig templates
     *
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        $config = ['is_safe' => ['html']];

        return [

            /**
             * https://developer.wordpress.org/reference/functions/get_the_post_thumbnail_url/
             */
            new TwigFunction('get_the_post_thumbnail_url', 'get_the_post_thumbnail_url', $config),

            /**
             * https://developer.wordpress.org/reference/functions/wp_get_attachment_url/
             */
            new TwigFunction('wp_get_attachment_url', 'wp_get_attachment_url', $config),

            /**
             * https://developer.wordpress.org/reference/functions/get_permalink/
             */
            new TwigFunction('get_permalink', 'get_permalink', $config),

            /**
             * https://developer.wordpress.org/reference/functions/get_the_date/
             */
            new TwigFunction('get_the_date', 'get_the_date', $config),

            /**
             * https://developer.wordpress.org/reference/functions/__/
             */
            new TwigFunction('__', '__', $config),

            /**
             * https://developer.wordpress.org/reference/functions/admin_url/
             */
            new TwigFunction('admin_url', 'admin_url', $config),

            /**
             * https://developer.wordpress.org/reference/functions/get_option/
             */
            new TwigFunction('get_option', 'get_option', $config),

            /**
             * https://developer.wordpress.org/reference/functions/esc_html_e/
             */
            new TwigFunction('esc_html_e', 'esc_html_e', $config),

            /**
             * https://developer.wordpress.org/reference/functions/do_action/
             */
            new TwigFunction('do_action', function(string $actionName, ...$args) {
                return do_action($actionName, $args);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/the_widget/
             */
            new TwigFunction('the_widget', 'the_widget', $config),

            /**
             * https://developer.wordpress.org/reference/functions/date_i18n/
             */
            new TwigFunction('date_i18n', 'date_i18n', $config),

            /**
             * https://developer.wordpress.org/reference/functions/do_shortcode/
             */
            new TwigFunction('do_shortcode', 'do_shortcode', $config),

            /**
             * https://developer.wordpress.org/reference/functions/bloginfo/
             */
            new TwigFunction('bloginfo', 'bloginfo', $config),

            /**
             * https://developer.wordpress.org/reference/functions/_e/
             */
            new TwigFunction('_e', '_e', $config),

            /**
             * https://developer.wordpress.org/reference/functions/_n/
             */
            new TwigFunction('_n', '_n', $config),

            /**
             * https://developer.wordpress.org/reference/functions/_x/
             */
            new TwigFunction('_x', '_x', $config),

            /**
             * Create url from theme root
             */
            new TwigFunction('theme_url', function ($url) {
                return _theme_url($url);
            }, $config),

            /**
             * Create url from root
             */
            new TwigFunction('url', function ($url, ?string $schema = null, ?int $blogId = null) {
                return _url($url, $schema, $blogId);
            }),
        ];
    }

    /**
     * Register a list of Wordpress filters inside Twig templates
     *
     * @return array|TwigFilter[]
     */
    public function getFilters(): array
    {
        $config = ['is_safe' => ['html']];

        return [

            /**
             * https://developer.wordpress.org/reference/functions/wpautop/
             */
            new TwigFilter('wpautop', 'wpautop', $config),

            /**
             * Check if file is an Video
             */
            new TwigFilter('isVideo', function($file) {
                return FileHelper::isVideo($file);
            }, $config),

            /**
             * Check if file is an SVG
             */
            new TwigFilter('isSvg', function ($file) {
                return FileHelper::isSvg($file);
            }, $config),

            /**
             * Check if file is an Image
             */
            new TwigFilter('isImage', function ($file) {
                return FileHelper::isImage($file);
            }, $config),

            /**
             * Check if url is an URL
             */
            new TwigFilter('isUrl', function ($url) {
                return UrlHelper::isUrl($url);
            }, $config),
        ];
    }
}
