<?php

namespace Dbout\WpCore\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class ValidatorField
 * @package Dbout\WpCore\Validator
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class ValidatorField
{

    /**
     * @var Constraint[]
     */
    protected $constraints = [];

    /**
     * @var bool
     */
    protected $mapped = true;

    /**
     * Name of the property that is mapped
     * @var string|null
     */
    protected $property;

    /**
     * Field constructor.
     * @param array $constraints
     * @param bool $mapped
     * @param string|null $property
     */
    public function __construct(array $constraints, $mapped = true, ?string $property = null)
    {
        $this->constraints = $constraints;
        $this->mapped = $mapped;
        $this->property = $property;
    }

    /**
     * @return Constraint[]
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }

    /**
     * @param Constraint[] $constraints
     * @return ValidatorField
     */
    public function setConstraints(array $constraints): ValidatorField
    {
        $this->constraints = $constraints;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMapped(): bool
    {
        return $this->mapped;
    }

    /**
     * @param bool $mapped
     * @return ValidatorField
     */
    public function setMapped(bool $mapped): ValidatorField
    {
        $this->mapped = $mapped;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProperty(): ?string
    {
        return $this->property;
    }

    /**
     * @param string|null $property
     * @return ValidatorField
     */
    public function setProperty(?string $property): ValidatorField
    {
        $this->property = $property;
        return $this;
    }

}