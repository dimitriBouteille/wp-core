<?php

namespace Dbout\WpCore\Comment;

/**
 * Class DisableComment
 * @package Dbout\WpCore\Comment
 *
 * https://gist.github.com/mattclements/eab5ef656b2f946c4bfb
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class DisableComment
{

    public static function disable(): void
    {
        add_action('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });

        add_action('init', function() {
            if(is_admin_bar_showing()) {
                remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
            }
        });

        add_filter('comments_open', function ($open, $postId) {
            return false;
        }, 20, 2);

        add_filter('pings_open', function () {
            return false;
        }, 20, 2);

        add_filter('comments_array', function() {
            return [];
        }, 10, 2);

    }

}