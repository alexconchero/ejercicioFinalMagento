<?php

namespace Hiberus\Conchero\Block;


class BloqueExamen extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'Hiberus_Conchero::examenbloque.phtml';
    protected $_alumnoRepository;
    protected $_searchCriteriaBuilder;
    protected $_sortOrderBuilder;

    public function __construct(
        \Hiberus\Conchero\Api\AlumnoRepositoryInterface $alumnoRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Magento\Framework\View\Element\Template\Context $context, 
        array $data = [])
    {
        $this->_alumnoRepository=$alumnoRepository;
        $this->_searchCriteriaBuilder=$searchCriteriaBuilder;
        $this->_sortOrderBuilder=$sortOrderBuilder;
        parent::__construct($context, $data);
    }
    public function getListExam(){
        return $this->_alumnoRepository->getList(
            $this->_searchCriteriaBuilder
            ->addSortOrder($this->_sortOrderBuilder->setField('mark')->setDirection('DESC')->create())
            ->setPageSize(10)
            ->create()
        
        )->getItems();


    }
}