<?php

namespace Dbout\WpCore\Form;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractForm
 * @package Dbout\WpCore\Form
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractForm
{

    /**
     * @var self[]
     */
    protected static $instances = [];

    /**
     * Form action
     * ie : my-contact-form
     *
     * @var string
     */
    protected $action;

    /**
     * Form nonce name
     *
     * @var string
     */
    protected $nonceName;

    /**
     * If true, Fires ajax actions for logged-out users.
     *
     * @var bool
     */
    protected $noLoggedUser = true;

    /**
     * Form nonce field name
     *
     * @var string
     */
    protected $nonceFieldName = '_token';

    /**
     * @return string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @return string|null
     */
    public function getNonceName(): ?string
    {
        return $this->nonceName;
    }

    /**
     * @return string|null
     */
    public function getNonceFieldName(): ?string
    {
        return $this->nonceFieldName;
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected abstract function execute(Request $request): Response;

    /**
     * @return void
     */
    public function submit(): void
    {
        $request = new Request($_REQUEST, [], [], $_COOKIE, $_FILES, $_SERVER);
        if(wp_verify_nonce($request->get($this->nonceFieldName), $this->nonceName, false) === false) {
            $response = $this->invalidNonce();
        } else {
            $response = $this->execute($request);
        }

        $this->sendResponse($response);
    }

    /**
     * @return Response
     */
    protected function invalidNonce(): Response
    {
       return new JsonResponse([
           'error' => 'Le formulaire n\'est pas valide . Veuillez rafraichir la page pour tenter de corriger le problème . Si le problème persiste, veuillez réessayer dans quelques instants.',
       ], 400);
    }

    /**
     * Call wp_create_nonce function
     *
     * @return string
     */
    public function getNonce(): string
    {
        return wp_create_nonce($this->getNonceName());
    }

    /**
     * Send response with wp_send_json
     *
     * @param Response $response
     */
    protected function sendResponse(Response $response): void
    {
        $response->send();
        die;
    }

    /**
     * Register form in Wordpress
     */
    public static function register(): void
    {
        $instance = static::getInstance();
        $callBack = [$instance, 'submit'];
        add_action('wp_ajax_'. $instance->getAction(), $callBack);
        if($instance->noLoggedUser) {
            add_action('wp_ajax_nopriv_'. $instance->getAction(), $callBack);
        }
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        $class = get_called_class();
        if(!key_exists($class, self::$instances)) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

}