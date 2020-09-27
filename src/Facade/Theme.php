<?php

namespace Dbout\WpCore\Facade;

/**
 * Class Theme
 * @package Dbout\WpCore\Facade
 *
 * @method static mixed name()
 * @method static mixed uri()
 * @method static mixed description()
 * @method static mixed author()
 * @method static mixed authorUri()
 * @method static mixed version()
 * @method static mixed textDomain()
 * @method static mixed template()
 * @method static string|array tags(bool $array = true)
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class Theme extends AbstractFacade
{

    /**
     * @return \Dbout\WpCore\Helpers\Theme|mixed
     */
    protected static function getInstance()
    {
        return \Dbout\WpCore\Helpers\Theme::getInstance();
    }

}