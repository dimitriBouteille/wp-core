<?php

namespace Dbout\WpCore\Ui;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class MetaBox
 * @package Dbout\WpCore\Ui
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class MetaBox
{

    /**
     * Custom meta box classes
     * @var array
     */
    protected array $classes = ['app-meta-box', 'app-meta-box--without-handle'];

    /**
     * @var null|string
     */
    protected ?string $boxId = null;

    /**
     * @var null|string
     */
    protected ?string $postType = null;

    /**
     * @var string
     */
    protected string $boxTitle = ' ';

    /**
     * @var string[]
     */
    protected array $boxConfig = [
        'context' => 'normal',
        'priority' => 'default',
        'screen' => '',
    ];

    /**
     * MetaBox constructor.
     */
    public function __construct()
    {
        $this->boxConfig['screen'] = $this->postType;
    }

    /**
     * @return void
     */
    public function register(): void
    {
        add_action('add_meta_boxes', [$this, 'display']);
        add_action('admin_enqueue_scripts', [$this, 'registerJsVars']);
        add_action('postbox_classes_'.$this->postType.'_'. $this->boxId, [$this, 'addClasses']);
        add_action('save_post_'. $this->postType, [$this, 'save'], 10, 2);
    }

    /**
     * Display meta box
     * @return void
     */
    public function display(): void
    {
        add_meta_box(
            $this->boxId,
            $this->boxTitle,
            [$this, 'output'],
            $this->boxConfig['screen'],
            $this->boxConfig['context'],
            $this->boxConfig['priority']
        );
    }

    /**
     * @param \WP_Post $post
     * @return mixed
     */
    abstract public function output(\WP_Post $post): void;

    /**
     * @param array $classes
     * @return array
     */
    public function addClasses(array $classes = []): array
    {
        foreach ($this->classes as $class) {
            $classes[] = sanitize_html_class($class);
        }

        return $classes;
    }

    /**
     * @return void
     */
    public function registerJsVars(): void
    {
        if ($this->isThis()) {
            $this->_registerJsVars();
        }
    }

    /**
     * @return void
     */
    protected function _registerJsVars(): void
    {

    }

    /**
     * @return bool
     */
    protected function isThis(): bool
    {
        global $current_screen;
        if (!$current_screen || $current_screen->post_type !== $this->postType) {
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    protected function typeAside(): void
    {
        $this->boxConfig['context'] = 'aside';
    }

    /**
     * @param $postId
     * @param $post
     */
    public function save($postId, $post): void
    {
        if ($this->isThis()) {
            $this->_save($post, Request::createFromGlobals());
        }
    }

    /**
     * @param \WP_Post $post
     * @param Request $request
     */
    protected function _save(\WP_Post $post, Request $request): void
    {
    }
}
