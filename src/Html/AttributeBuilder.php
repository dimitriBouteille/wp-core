<?php

namespace Dbout\WpCore\Html;

/**
 * Class AttributeBuilder
 * @package Dbout\WpCore\Html
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class AttributeBuilder
{

    /**
     * Build a list HTML attributes from an array
     *
     * @param array $attributes
     * @return string|null
     */
    public static function attributes(array $attributes): ?string
    {
        $html = [];

        foreach ($attributes as $name => $value) {
            $attribute = self::attribute($name, $value);
            if($attribute) {
                $html[] = $attribute;
            }
        }

        return implode(' ', $html);
    }

    /**
     * Build attribute
     *
     * @param string $key
     * @param $value
     * @return string|null
     */
    public static function attribute(string $key, $value): ?string
    {
        if(is_numeric($key)) {
            return $value;
        }

        if(is_bool($value) && $key !== 'value') {
            return $value ? $key : '';
        }

        if(is_null($value)) {
            return null;
        }

        return sprintf('%s="%s"', $key, $value);
    }

}