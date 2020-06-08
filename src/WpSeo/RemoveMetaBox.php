<?php

namespace Dbout\WpCore\WpSeo;

/**
 * Class RemoveMetaBox
 * @package Dbout\WpCore\WpSeo
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class RemoveMetaBox
{

    /**
     * https://gist.github.com/atomtigerzoo/7b32bd26668e9f471e503c85e345e942
     * @param string|array $screens
     */
    public static function remove($screens): void
    {
        if(is_string($screens)) {
            $screens = [$screens];
        }

        add_action('add_meta_boxes', function() use($screens) {
            remove_meta_box('wpseo_meta', $screens, 'normal');
        }, 100);
    }
}
