<?php


namespace Hiberus\Conchero\Api;

use Hiberus\Conchero\Api\Data\AlumnoInterface;
use Hiberus\Conchero\Api\Data\AlumnoSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Interface AlumnoRepositoryInterface
 * @package Hiberus\Conchero\Api
 */
interface AlumnoRepositoryInterface
{
    /**
     * Save a Alumno
     *
     * @param AlumnoInterface $alumno
     * @return AlumnoInterface
     */
    public function save(Data\AlumnoInterface $alumno);

    /**
     * Get Alumno by an Id
     *
     * @param int $alumnoId
     * @return AlumnoInterface
     */
    public function getById($alumnoId);

    /**
     * Retrieve alumnos matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return Hiberus\Conchero\Api\Data\AlumnoSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete a Alumno
     *
     * @param AlumnoInterface $alumno
     * @return bool
     */
    public function delete(Data\AlumnoInterface $alumno);

    /**
     * Delete a Alumno by an Id
     *
     * @param int $alumnoId
     * @return bool
     */
    public function deleteById($alumnoId);
}
