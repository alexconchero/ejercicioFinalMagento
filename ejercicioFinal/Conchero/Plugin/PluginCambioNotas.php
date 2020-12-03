<?php

namespace Hiberus\Conchero\Plugin;

use Hiberus\Conchero\Api\Data\AlumnoInterface;
use Hiberus\Conchero\Api\Data\AlumnoSearchResultsInterface;
use Hiberus\Conchero\Api\AlumnoRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class PluginCambioNotas
 * @package Hiberus\Conchero\Plugin
 */
class PluginCambioNotas
{
    /**
     * @param AlumnoRepositoryInterface $subject
     * @param SearchCriteriaInterface $searchCriteria
     * @return array
     */
    public function beforeGetList(
        AlumnoRepositoryInterface $subject,
        SearchCriteriaInterface $searchCriteria
    ) {
        return [$searchCriteria];
    }

    /**
     * @param AlumnoRepositoryInterface $subject
     * @param callable $proceed
     * @param SearchCriteriaInterface $searchCriteria
     * @return AlumnoSearchResultsInterface
     * @throws LocalizedException
     */
    public function aroundGetList(
        AlumnoRepositoryInterface $subject,
        callable $proceed,
        SearchCriteriaInterface $searchCriteria
    ) {
            return $proceed($searchCriteria); // Original function call
        

        }

    /**
     * @param AlumnoRepositoryInterface $subject
     * @param AlumnoSearchResultsInterface $result
     * @return AlumnoSearchResultsInterface
     */
    public function afterGetList(
        AlumnoRepositoryInterface $subject,
        $result
    ) {
        /** @var AlumnoInterface $first */
        $first = ($result->getItems());
        foreach($first as $a){
            if($a->getMark()<5.00){
                $a->setMark(4.90);
            }
        }
        return $result;
    }
}