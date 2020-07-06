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
abstract class TaxonomyListTable extends AbstractListTable
{

    /**
     * @return void
     */
    protected function runHooks(): void
    {
        add_filter('manage_edit-'.$this->objectSlug().'_columns', [$this, 'setupColumns']);
        add_filter('manage_'.$this->objectSlug().'_custom_column', [$this, 'renderColumn'], 10, 3);
        add_filter('manage_edit-'. $this->objectSlug().'_sortable_columns', [$this, 'defineSortableColumns']);
        add_filter('bulk_actions-edit-'. $this->objectSlug(), [$this, 'defineBulkActions']);
    }

    /**
     * @param string $out
     * @param string $columnName
     * @param int $termId
     */
    public function renderColumn(string $out, string $columnName, int $termId): void
    {
        $this->_renderColumn($columnName, $termId);
    }

    /**
     * @param array $actions
     * @return array
     */
    public function defineBulkActions(array $actions): array
    {
        return $actions;
    }
}
