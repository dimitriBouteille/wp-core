<?php

namespace Dbout\WpCore\Facade;

use Dbout\WpCore\Notice\NoticeManager;

/**
 * Class Notice
 * @package Dbout\WpCore\Facade
 *
 * @method static void success(string $message, bool $dismissible = true)
 * @method static void error(string $message, bool $dismissible = true)
 * @method static void info(string $message, bool $dismissible = true)
 * @method static void warning(string $message, bool $dismissible = true)
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class Notice extends AbstractFacade
{

    /**
     * @return NoticeManager|mixed
     */
    protected static function getInstance()
    {
        return NoticeManager::getInstance();
    }

}