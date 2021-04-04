<?php

namespace Dbout\WpCore\Template;

/**
 * Class TemplateRegister
 * @package Dbout\WpCore\Template
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class TemplateRegister
{

    const DEFAULT_SCREENS = 'page';

    /**
     * @var array
     */
    protected array $templates = [];

    /**
     * Add new template
     *
     * @param string $templateSlug  Template slug (ie : my-template)
     * @param string $templateName  Template name (ie : My custom Template)
     * @param array $screens        Template screens (ie: [page, custom-post-type]
     * @return $this
     */
    public function addTemplate(string $templateSlug, string $templateName, array $screens = []): self
    {
        if(count($screens) === 0) {
            $screens[] = self::DEFAULT_SCREENS;
        }

        foreach ($screens as $screen) {
            $this->templates[$screen][$templateSlug] = $templateName;
        }

        return $this;
    }

    /**
     * Add multiples templates
     *
     * @param array $templates
     * @return $this
     * @throws \Exception
     */
    public function addTemplates(array $templates): self
    {
        foreach ($templates as $templateSlug => $templateConfig) {

            $templateName = null;
            $templateScreens = [];

            if(!is_string($templateSlug)) {
                throw new \Exception(sprintf('The template slug \'%s\' is invalid.', $templateSlug));
            }

            if(is_string($templateConfig)) {
                $templateName = $templateConfig;
            }

            else if(is_array($templateConfig)) {

                if(key_exists('name', $templateConfig)) {
                    $templateName = $templateConfig['name'];
                }

                if(key_exists('screens', $templateConfig)) {
                    if(is_array($templateConfig['screens'])) {
                        $templateScreens = $templateConfig['screens'];
                    } else {
                        throw new \Exception(sprintf('The screens key must be array for template \'%s\'.', $templateSlug));
                    }
                } else {
                    $templateScreens = [self::DEFAULT_SCREENS];
                }
            }

            if(!empty($templateName)) {
                $this->addTemplate($templateSlug, $templateName, $templateScreens);
            } else {
                throw new \Exception(sprintf('The template name must be valid \'%s\'.', $templateSlug));
            }
        }

        return $this;
    }

    /**
     * Register template in Wordpress
     *
     * @return void
     */
    public function register(): void
    {
        foreach ($this->templates as $screen => $templates)
        {
            if(count($templates) < 1) {
                continue;
            }

            add_filter('theme_'.$screen.'_templates', function ($registeredTemplates) use ($templates) {
                return array_merge($registeredTemplates, $templates);
            });
        }

    }
}
