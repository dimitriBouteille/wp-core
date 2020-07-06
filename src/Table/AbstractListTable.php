<?php

namespace Dbout\WpCore\Table;

/**
 * Class AbstractListTable
 * @package Dbout\WpCore\Table
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractListTable
{

    /**
     * @var null|mixed
     */
    protected $currentLoadedObject = null;

    /**
     * @var bool
     */
    protected $disableWpSeoColumns = false;

    /**
     * AbstractListTable constructor.
     */
    public function __construct()
    {
        if(!$this->objectSlug()) {
            return;
        }

        add_action('current_screen', [$this, 'setupTable']);
        add_action('check_ajax_referer', [$this, 'setupTable']);
    }

    /**
     * Register filters and actions
     *
     * @return void
     */
    public function setupTable(): void
    {
        if(function_exists('get_current_screen')) {
            $screenId = \get_current_screen()->id;
            if ($screenId === $this->getEditScreenId()) {
                $this->runHooks();
            }
        }

        // Ensure the table handler is only loaded once. Prevents multiple loads if a plugin calls check_ajax_referer many times.
        remove_action( 'current_screen', [$this, 'setupTable']);
        remove_action( 'check_ajax_referer', [$this, 'setupTable']);
    }

    /**
     * Define which columns to show on this screen.
     *
     * @param array $columns
     * @return array
     */
    public function setupColumns(array $columns): array
    {
        if($this->disableWpSeoColumns) {
            unset($columns['wpseo-score']);
            unset($columns['wpseo-score-readability']);
            unset($columns['wpseo-title']);
            unset($columns['wpseo-metadesc']);
            unset($columns['wpseo-focuskw']);
        }

        return $this->defineColumns($columns);
    }

    /**
     * Define which columns are sortable
     *
     * @param array $columns
     * @return array
     */
    public function defineSortableColumns(array $columns)
    {
        return $columns;
    }

    /**
     * @param string $out
     * @param string $columnName
     * @param int $termId
     */
    protected function _renderColumn(string $columnName, int $objectId): void
    {
        if(!$this->loadRowData($objectId)) {
            return;
        }

        $fncName = 'column';
        $fncName .= str_replace(' ', '', ucwords(str_replace('_', ' ', $columnName)));
        if(is_callable([$this, $fncName])) {
            $this->{$fncName}($this->currentLoadedObject, $objectId);
        }
    }

    /**
     * @return string
     */
    protected function getEditScreenId(): string
    {
        return 'edit-'.$this->objectSlug();
    }

    /**
     * @return bool
     */
    protected function isThis(): bool
    {
        global $typenow;
        return $this->objectSlug() === $typenow;
    }

    /**
     * @return void
     */
    protected abstract function runHooks(): void;

    /**
     * @param int $termId
     * @return bool Returns true if data was loaded
     */
    protected abstract function loadRowData(int $termId): bool;

    /**
     * @param array $columns
     * @return array
     */
    protected abstract function defineColumns(array $columns): array;

    /**
     * @return string
     */
    protected abstract function objectSlug(): string;
}