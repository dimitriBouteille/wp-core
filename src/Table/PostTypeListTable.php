<?php

namespace Dbout\WpCore\Table;

/**
 * Class PostTypeListTable
 * @package Dbout\WpCore\Table
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class PostTypeListTable extends AbstractListTable
{

    /**
     * @return void
     */
    protected function runHooks(): void
    {
        add_filter('list_table_primary_column', [$this, 'tablePrimaryColumn'], 10, 2 );
        add_action('manage_edit-'. $this->objectSlug().'_sortable_columns', [$this, 'defineSortableColumns']);
        add_filter('manage_' . $this->objectSlug() . '_posts_columns', [$this, 'setupColumns']);
        add_filter('bulk_actions-edit-' . $this->objectSlug(), [$this, 'defineBulkActions']);
        add_action('manage_' . $this->objectSlug() . '_posts_custom_column',[$this, 'renderColumns'], 10, 2);
        add_filter('default_hidden_columns',[$this, 'defineDefaultHiddenColumns'], 10, 2);
        add_filter('post_row_actions', [$this, 'rowActions'], 100, 2);
        add_action( 'restrict_manage_posts', [$this, 'restrictManagePosts']);
        add_filter( 'request', [$this, 'requestQuery']);
    }

    /**
     * @param string $column
     * @param int $postId
     * @return void
     */
    public function renderColumns($column, $postId): void
    {
        $this->_renderColumn($column, $postId);
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
        if($this->objectSlug() !== $post->post_type) {
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
     * @return void
     */
    public function restrictManagePosts()
    {
        if($this->isThis()) {
            $this->renderFilters();
        }
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
     * Define hidden columns
     *
     * @return array
     */
    public function defineDefaultHiddenColumns(): array
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
     * Render any custom filters and search inputs for the list table
     * @return void
     */
    protected function renderFilters(): void
    {
    }

    /**
     * @return string
     */
    protected abstract function getPrimaryColumnSlug(): string;
}
