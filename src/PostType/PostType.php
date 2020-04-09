<?php

namespace Dbout\WpCore\PostType;

/**
 * Class PostType
 * @package Dbout\WpCore\PostType
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class PostType
{

    /**
     * Post type slug
     *
     * @var string
     */
    private $slug;

    /**
     * Arguments for register_post_type function
     * https://codex.wordpress.org/Function_Reference/register_post_type
     *
     * @var array
     */
    protected $arguments = [
        'labels' => [],
        'public' => true,
        'show_in_rest' => false,
    ];

    /**
     * WP_Post_Type after register
     *
     * @var \WP_Post_Type|\WP_Error
     */
    protected $instance;

    /**
     * PostType constructor.
     * @param string $slug
     * @param string $singular
     * @param string $plural
     */
    public function __construct(string $slug, string $singular, string $plural)
    {
        $this->slug = $slug;
        $this->addLabels([
            'singular_name' =>  $singular,
            'name' =>           $plural,
        ]);
    }

    /**
     * @param array $labels
     * @return $this
     */
    public function setLabels(array $labels): self
    {
        $this->arguments['labels'] = $labels;
        return $this;
    }

    /**
     * @param array $labels
     * @return $this
     */
    public function addLabels(array $labels): self
    {
        $this->arguments['labels'] = array_merge($this->arguments['labels'], $labels);
        return $this;
    }

    /**
     * @param array $args
     * @return $this
     */
    public function addArguments(array $args): self
    {
        $this->arguments = array_merge($this->arguments, $args);
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function addArgument(string $name, $value): self
    {
        $this->arguments = array_merge($this->arguments, [$name => $value]);
        return $this;
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function setMenuIcon(string $icon): self
    {
        return $this->addArgument('menu_icon', $icon);
    }

    /**
     * @param string $show
     * @return $this
     */
    public function setShowInMenu(string $show): self
    {
        return $this->addArgument('show_in_menu', $show);
    }

    /**
     * @param bool $show
     * @return $this
     */
    public function setShowInRest(bool $show): self
    {
        return $this->addArgument('show_in_rest', $show);
    }

    /**
     * @param bool $public
     * @return $this
     */
    public function setPublic(bool $public): self
    {
        return $this->addArgument('public', $public);
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return \WP_Error|\WP_Post_Type
     */
    public function getWpPostType()
    {
        return $this->instance;
    }

    /**
     * Returns post type slug
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->slug;
    }

    /**
     * Save the new post type in Wordpress
     */
    public function register()
    {
        register_post_type($this->slug, $this->arguments);
    }

    /**
     * Create new instance of PostType
     *
     * @param string $slug
     * @param string $singularName
     * @param string $pluralName
     * @return static
     */
    public static function make(string $slug, string $singularName, string $pluralName): self
    {
        return new PostType($slug, $singularName, $pluralName);
    }

}