<?php

namespace Dbout\WpCore\Table;

use function Sodium\add;

/**
 * Class TaxonomyListTable
 * @package Dbout\WpCore\Table
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class TaxonomyListTable
{

    /**
     * @var null|string
     */
    protected $taxonomyType = null;

    /**
     * @var null|mixed
     */
    protected $currentLoadedObject = null;

    /**
     * TaxonomyListTable constructor.
     */
    public function __construct()
    {
        if(!$this->taxonomyType) {
            return;
        }

        add_action('current_screen', [$this, 'setupTable']);
        add_action('check_ajax_referer', [$this, 'setupTable']);
    }

    /**
     * Register filters and actions
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
     * @return void
     */
    protected function runHooks(): void
    {
        add_filter('manage_edit-'.$this->taxonomyType.'_columns', [$this, 'defineColumns']);
        add_filter('manage_'.$this->taxonomyType.'_custom_column', [$this, 'renderColumn'], 10, 3);
        add_filter('manage_edit-'. $this->taxonomyType.'_sortable_columns', [$this, 'defineSortableColumns']);
        add_filter('bulk_actions-edit-'. $this->taxonomyType, [$this, 'defineBulkActions']);
    }

    /**
     * Define which columns to show on this screen.
     *
     * @param array $columns
     * @return array
     */
    public function defineColumns(array $columns): array
    {
        return $columns;
    }

    /**
     * @param string $out
     * @param string $columnName
     * @param int $termId
     */
    public function renderColumn(string $out, string $columnName, int $termId): void
    {
        if(!$this->loadRowData($termId)) {
            return;
        }

        $fncName = 'column';
        $fncName .= str_replace(' ', '', ucwords(str_replace('_', ' ', $columnName)));
        if(is_callable([$this, $fncName])) {
            $this->{$fncName}($this->currentLoadedObject, $termId);
        }
    }

    /**
     * @param array $columns
     * @return array
     */
    public function defineSortableColumns(array $columns): array
    {
        return $columns;
    }

    /**
     * @param array $actions
     * @return array
     */
    public function defineBulkActions(array $actions): array
    {
        return $actions;
    }

    /**
     * @param int $termId
     * @return bool Returns true if data was loaded
     */
    protected abstract function loadRowData(int $termId): bool;

    /**
     * @return bool
     */
    protected function isThis(): bool
    {
        global $typenow;
        return $this->taxonomyType === $typenow;
    }

    /**
     * @return string
     */
    protected function getEditScreenId(): string
    {
        return 'edit-'.$this->taxonomyType;
    }
}