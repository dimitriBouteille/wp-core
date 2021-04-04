<?php

namespace Dbout\WpCore\View\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class WoocommerceExtension
 * @package Dbout\WpCore\View\Twig\Extensions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class WoocommerceExtension extends AbstractExtension
{

    /**
     * Register a list of Woocommerce filters inside Twig templates
     *
     * @return array|TwigFunction[]
     */
    public function getFilters(): array
    {
        $config = ['is_safe' => ['html']];

        return [

            /**
             * https://woocommerce.wp-a2z.org/oik_api/wc_price/
             */
            new TwigFilter('wc_price', 'wc_price', $config),
        ];
    }
}
