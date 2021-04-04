<?php

namespace Dbout\WpCore\Form;

/**
 * Class AbstractAdminForm
 * @package Dbout\WpCore\Form
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractAdminForm extends AbstractForm
{
    /**
     * @var bool
     */
    protected bool $noLoggedUser = false;
}
