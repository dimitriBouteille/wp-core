<?php

namespace Dbout\WpCore\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractValidator
 * @package Dbout\WpCore\Validator
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractValidator
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var mixed
     */
    protected $object;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var ConstraintViolationList[]
     */
    protected $errors = [];

    /**
     * @var string[]
     */
    protected $validateData = [];

    /**
     * AbstractValidator constructor.
     * @param null $object
     */
    public function __construct(&$object = null)
    {
        $this->object = $object;
        $this->validator = Validation::createValidator();
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function handleRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return ValidatorField[]
     */
    protected abstract function getConstraints(): array;

    /**
     * Check if validator is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        foreach ($this->getConstraints() as $fieldName => $field) {

            if(count($field->getConstraints()) <= 0) {
                continue;
            }

            $value = $this->getData($fieldName);
            $violations = $this->validator->validate($value, $field->getConstraints());
            if(count($violations) > 0) {
                $this->errors[$fieldName] = $violations;
            } else {
                $this->validateData[$fieldName] = $value;
            }

        }

        if(count($this->errors) > 0) {
            return false;
        }

        $this->hydrateObject();
        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->errors as $fieldName => $violations) {

            // Get only first errors
            $errors[$fieldName] = $violations->get(0)->getMessage();
        }

        return $errors;
    }

    /**
     * @return void
     */
    protected function hydrateObject(): void
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($this->getConstraints() as $fieldName => $field) {

            if(!$field->isMapped()) {
                continue;
            }

            $value = $this->getData($fieldName);
            if($field->getProperty()) {
                $fieldName = $field->getProperty();
            }

            try {
                $accessor->setValue($this->object, $fieldName, $value);
            } catch (\Exception $exception) {}
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    protected function getData(string $key)
    {
        return $this->request->get($key);
    }
}
