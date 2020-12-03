<?php

namespace Hiberus\Conchero\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface AlumnoSearchResultsInterface
 * @package Hiberus\Conchero\Api\Data
 */
interface AlumnoSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get alumno list.
     *
     * @return Hiberus\Conchero\Api\Data\AlumnoInterface[]
     */
    public function getItems();

    /**
     * Set alumno list.
     *
     * @param Hiberus\Conchero\Api\Data\AlumnoInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
