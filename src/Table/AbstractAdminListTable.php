<?php

namespace Dbout\WpCore\Table;

/**
 * Class AbstractAdminListTable
 * @package Dbout\WpCore\Table
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractAdminListTable
{

    /**
     * Post type
     *
     * @var null|string
     */
    protected $listTableType = null;

    /**
     * @var null|mixed
     */
    protected $currentObject = null;

    /**
     * AbstractAdminListTable constructor.
     */
    public function __construct()
    {
        if(!$this->listTableType) {
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
     * @return void
     */
    protected function runHooks(): void
    {
        add_filter('list_table_primary_column', [$this, 'tablePrimaryColumn'], 10, 2 );
        add_action('manage_edit-'. $this->listTableType.'_sortable_columns', [$this, 'defineSortableColumns']);
        add_filter('manage_' . $this->listTableType . '_posts_columns', [$this, 'defineColumns']);
        add_filter('bulk_actions-edit-' . $this->listTableType, [$this, 'defineBulkActions']);
        add_action('manage_' . $this->listTableType . '_posts_custom_column',[$this, 'renderColumns'], 10, 2);
        add_filter('default_hidden_columns',[$this, 'defaultHiddenColumns'], 10, 2);
        add_filter('post_row_actions', [$this, 'rowActions'], 100, 2);
        add_action( 'restrict_manage_posts', [$this, 'restrictManagePosts']);
        add_filter( 'request', [$this, 'requestQuery']);
    }

    /**
     * @return string
     */
    protected abstract function getPrimaryColumnSlug(): string;

    /**
     * @param $postId
     * @return bool Returns true if data was loaded
     */
    protected abstract function loadRowData($postId): bool;

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
     * Define hidden columns.
     *
     * @return array
     */
    protected function defineDefaultHiddenColumns(): array
    {
        return [];
    }

    /**
     * Get row actions to show in the list table.
     *
     * @param array $actions
     * @param \WP_Post $post
     * @return array
     */
    protected function defineRowActions(array $actions, \WP_Post $post): array
    {
        return $actions;
    }

    /**
     * Handle any custom filters
     *
     * @param array $queryVars
     * @return array
     */
    protected function applyFilters(array $queryVars): array
    {
        return $queryVars;
    }

    /**
     * Handle any filters.
     *
     * @param array $queryVars
     * @return array
     */
    public function requestQuery(array $queryVars): array
    {
        if($this->isThis()) {
            return $this->applyFilters($queryVars);
        }

        return $queryVars;
    }

    /**
     * Render any custom filters and search inputs for the list table
     * @return void
     */
    protected abstract function renderFilters(): void;

    /**
     * @return void
     */
    public function restrictManagePosts()
    {
        if($this->isThis()) {
            $this->renderFilters();
        }
    }

    /**
     * Define which columns to show on this screen.
     *
     * @param array $columns
     * @return array
     */
    public function defineColumns(array $columns)
    {
        return $columns;
    }

    /**
     * Adjust which columns are displayed by default.
     *
     * @param array $hidden
     * @param \WP_Screen|null $screen
     * @return array
     */
    public function defaultHiddenColumns(array $hidden,?\WP_Screen $screen )
    {
        if($screen->id && $this->getEditScreenId() === $screen->id) {
            $hidden = array_merge($hidden, $this->defineDefaultHiddenColumns());
        }

        return $hidden;
    }

    /**
     * Define bulk actions.
     *
     * @param array $actions
     * @return array
     */
    public function defineBulkActions(array $actions): array
    {
        return $actions;
    }

    /**
     * @param $column
     * @param $postId
     */
    public function renderColumns($column, $postId)
    {
        if($this->loadRowData($postId)) {
            $function = 'column_' . $column;
            if (is_callable([$this, $function])) {
                $this->{$function}($this->currentObject, $postId);
            }
        }
    }

    /**
     * Set row actions.
     *
     * @param array $actions
     * @param \WP_Post $post
     * @return array
     */
    public function rowActions(array $actions, \WP_Post $post)
    {
        if($this->listTableType !== $post->post_type) {
            return $actions;
        }

        return $this->defineRowActions($actions, $post);
    }

    /**
     * @param $default
     * @param $screenId
     * @return string
     */
    public function tablePrimaryColumn($default, $screenId)
    {
        if ($this->getEditScreenId() === $screenId && $this->getPrimaryColumnSlug() ) {
            return $this->getPrimaryColumnSlug();
        }

        return $default;
    }

    /**
     * @return string
     */
    protected function getEditScreenId(): string
    {
        return 'edit-'.$this->listTableType;
    }

    /**
     * @return bool
     */
    protected function isThis(): bool
    {
        global $typenow;
        return $this->listTableType === $typenow;
    }

}