<?php
/**
 * @author: daniDLL
 * Date: 18/11/20
 * Time: 20:35
 */

namespace Hiberus\Conchero\Model;

use Hiberus\Conchero\Api\Data\AlumnoInterfaceFactory;
use Hiberus\Conchero\Api\Data\AlumnoSearchResultsInterface;
use Hiberus\Conchero\Model\ResourceModel\Alumno\Collection;
use Hiberus\Conchero\Model\ResourceModel\Alumno\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Hiberus\Conchero\Api\Data;
use Hiberus\Conchero\Api\AlumnoRepositoryInterface;
use Hiberus\Conchero\Model\ResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Class AlumnoRepository
 * @package Hiberus\Conchero\Model
 */
class AlumnoRepository implements AlumnoRepositoryInterface
{
    /**
     * @var \Hiberus\Conchero\Model\ResourceModel\Alumno
     */
    private $resourceAlumno;

    /**
     * @var AlumnoInterfaceFactory
     */
    private $alumnoFactory;

    /**
     * @var CollectionFactory
     */
    private $alumnoCollectionFactory;

    /**
     * @var Data\AlumnoSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param \Hiberus\Conchero\Model\ResourceModel\Alumno $resourceAlumno
     * @param AlumnoInterfaceFactory $alumnoFactory
     * @param CollectionFactory $alumnoCollectionFactory
     * @param Data\AlumnoSearchResultsInterfaceFactory $alumnoResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    function __construct(
        ResourceModel\Alumno $resourceAlumno,
        AlumnoInterfaceFactory $alumnoFactory,
        CollectionFactory $alumnoCollectionFactory,
        Data\AlumnoSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resourceAlumno = $resourceAlumno;
        $this->alumnoFactory = $alumnoFactory;
        $this->alumnoCollectionFactory = $alumnoCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param Data\AlumnoInterface|AbstractModel $alumno
     * @return Data\AlumnoInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\AlumnoInterface $alumno)
    {
        try {
            $this->resourceAlumno->save($alumno);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $alumno;
    }

    /**
     * @param int $alumnoId
     * @return Data\AlumnoInterface
     * @throws NoSuchEntityException
     */
    public function getById($alumnoId)
    {
        /** @var Data\AlumnoInterface|AbstractModel $alumno */
        $alumno = $this->alumnoFactory->create();
        $this->resourceAlumno->load($alumno, $alumnoId);
        if (!$alumno->getId()) {
            throw new NoSuchEntityException(__('Alumno with id "%1" does not exist', $alumnoId));
        }
        return $alumno;
    }

    /**
     * @param Data\AlumnoInterface|AbstractModel $alumno
     * @return bool|Data\AlumnoInterface
     * @throws CouldNotSaveException
     */
    public function delete(Data\AlumnoInterface $alumno)
    {
        try {
            $this->resourceAlumno->delete($alumno);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $alumno;
    }

    /**
     * @param int $alumnoId
     * @return bool|Data\AlumnoInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function deleteById($alumnoId)
    {
        return $this->delete($this->getById($alumnoId));
    }

    /**
     * Retrieve alumnos matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AlumnoSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->alumnoCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\AlumnoSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
