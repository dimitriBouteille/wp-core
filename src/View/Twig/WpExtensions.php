<?php

namespace Dbout\WpCore\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

/**
 * Class WpExtensions
 * @package Dbout\WpCore\View\Twig
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WpExtensions extends AbstractExtension implements GlobalsInterface
{

    /**
     * Register global variable in Twig templates
     * The global variable _ can be used to call any PHP and Wordpress functions
     *
     * @return array
     */
    public function getGlobals()
    {
        return [
            '_' => $this,
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
    public function getFunctions()
    {
        $config = ['is_safe' => ['html']];

        return [

            /**
             * https://developer.wordpress.org/reference/functions/get_the_post_thumbnail_url/
             */
            new TwigFunction('get_the_post_thumbnail_url', function($post, $size = null) {
                return get_the_post_thumbnail_url($post, $size);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/wp_get_attachment_url/
             */
            new TwigFunction('wp_get_attachment_url', function ($attachmentId) {
                return wp_get_attachment_url($attachmentId);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/get_permalink/
             */
            new TwigFunction('get_permalink', function ($post,bool $leaveName = false) {
                return get_permalink($post, $leaveName);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/get_the_date/
             */
            new TwigFunction('get_the_date', function (string $format = '', $post = null) {
                return get_the_date($format, $post);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/__/
             */
            new TwigFunction('__', function(string $text, string $domain = 'default') {
                return __($text, $domain);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/admin_url/
             */
            new TwigFunction('admin_url', function(string $path, string $schema = 'admin') {
                return admin_url($path, $schema);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/get_option/
             */
            new TwigFunction('get_option', function(string $option, $default = false) {
                return get_option($option, $default);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/esc_html_e/
             */
            new TwigFunction('esc_html_e', function(string $text, string $domain = 'default') {
                return esc_html_e($text, $domain);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/do_action/
             */
            new TwigFunction('do_action', function(string $actionName, ...$args) {
                return do_action($actionName, $args);
            }, $config),

            /**
             * https://developer.wordpress.org/reference/functions/the_widget/
             */
            new TwigFunction('the_widget', function(string $widget, array $widgetArguments = [], array $args = []) {
                return the_widget($widget, $widgetArguments, $args);
            }, $config),

        ];
    }

}