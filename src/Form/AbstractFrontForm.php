<?php

namespace Dbout\WpCore\Form;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractFrontForm
 * @package Dbout\WpCore\Form
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractFrontForm extends AbstractForm
{

    /**
     * @param array $errors
     * @return JsonResponse
     */
    protected function formErrors(array $errors): JsonResponse
    {
        return new JsonResponse([ 'errors' => $errors], 400);
    }
}