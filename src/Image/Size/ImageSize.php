<?php

namespace Dbout\WpCore\Image\Size;

/**
 * Class ImageSize
 * @package Dbout\WpCore\Image\Size
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class ImageSize
{

    /**
     * @var int|null
     */
    protected $width = 0;

    /**
     * @var int|null
     */
    protected $height = 0;

    /**
     * @var bool|array
     */
    protected $crop = false;

    /**
     * Size name
     * ie : my-custom-size
     *
     * @var string
     */
    protected $name;

    /**
     * Size label
     * ie : My custom size
     *
     * @var string|null
     */
    protected $label;

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     * @return ImageSize
     */
    public function setWidth(?int $width): ImageSize
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     * @return ImageSize
     */
    public function setHeight(?int $height): ImageSize
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return array|bool
     */
    public function getCrop()
    {
        return $this->crop;
    }

    /**
     * @param array|bool $crop
     * @return ImageSize
     */
    public function setCrop($crop)
    {
        $this->crop = $crop;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return ImageSize
     */
    public function setName(?string $name): ImageSize
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return ImageSize
     */
    public function setLabel(?string $label): ImageSize
    {
        $this->label = $label;
        return $this;
    }
}
