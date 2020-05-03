<?php

namespace Dbout\WpCore\Image\Size;

/**
 * Class ImageSizeRegister
 * @package Dbout\WpCore\Image\Size
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class ImageSizeRegister
{

    /**
     * The user defined image sizes
     *
     * @var ImageSize[]
     */
    protected $sizes = [];

    /**
     * ImageSizeRegister constructor.
     * @param array $sizes
     * @throws \Exception
     */
    public function __construct(array $sizes = [])
    {
        $this->parse($sizes);
    }

    /**
     * Add new image size
     * https://developer.wordpress.org/reference/functions/add_image_size/
     *
     * @param string|ImageSize $size      Image size name (ie: my-custom-size) or ImageSize object
     * @param int|null $width
     * @param int|null $height
     * @param bool $crop
     * @return $this
     * @throws \Exception
     */
    public function addSize($size, ?int $width = null, ?int $height = null, $crop = false): self
    {
        if($size instanceof ImageSize) {
            if(!$this->throwExist($size->getName())) {
                $this->sizes[$size->getName()] = $size;
            }

            return $this;
        }

        if(!$this->throwExist($size)) {

            $this->sizes[$size] = (new ImageSize())
                ->setName($size)
                ->setWidth($width)
                ->setHeight($height)
                ->setCrop($crop);
        }

        return $this;
    }

    /**
     * Adds several image sizes
     *
     * @param string[]|ImageSize[] $sizes
     * @return $this
     * @throws \Exception
     */
    public function addSizes(array $sizes): self
    {
        $this->parse($sizes);
        return $this;
    }

    /**
     * Save new sizes to Wordpress
     */
    public function register(): void
    {
        if(function_exists('add_image_size')) {
            foreach ($this->sizes as $sizeSlug => $sizeConfig) {
                add_image_size($sizeSlug, $sizeConfig->getWidth(), $sizeConfig->getHeight(), $sizeConfig->getCrop());
            }
        }

    }

    /**
     * @param string $name
     * @return bool
     * @throws \Exception
     */
    protected function throwExist(string $name): bool
    {
        if(key_exists($name, $this->sizes)) {
            throw new \Exception(sprintf('Image format %s already exists', $name));
        }

        return false;
    }

    /**
     * @param string[]|ImageSize[] $sizes
     * @throws \Exception
     */
    protected function parse(array $sizes): void
    {
        foreach ($sizes as $name => $sizeConfig) {

            if($sizeConfig instanceof ImageSize) {
                $this->addSize($sizeConfig);
            } else {

                $width = $sizeConfig['width'] ?? 0;
                $height = $sizeConfig['height'] ?? 0;
                $crop = $sizeConfig['crop'] ?? false;

                $this->addSize($name, $width, $height, $crop);
            }
        }
    }

}