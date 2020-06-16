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
     * Returns form errors
     *
     * @param array $errors
     * @return JsonResponse
     */
    protected function formErrors(array $errors): JsonResponse
    {
        return new JsonResponse([ 'errors' => $errors], 400);
    }

    /**
     * Returns error message
     *
     * @param string $errors
     * @return JsonResponse
     */
    protected function error(string $error): JsonResponse
    {
        return new JsonResponse(['error' => $error], 400);
    }

    /**
     * Returns custom message
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function message(string $message, int $code = 200)
    {
        return new JsonResponse(['message' => $message, 'code' => $code,], $code);
    }

    /**
     * Returns html content
     *
     * @param string $html
     * @param int $code
     * @return JsonResponse
     */
    protected function html(string $html, int $code = 200)
    {
        return new JsonResponse(['html' => $message, 'code' => $code,], $code);
    }
}