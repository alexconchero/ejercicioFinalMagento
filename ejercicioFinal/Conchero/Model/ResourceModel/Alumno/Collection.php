<?php


namespace Hiberus\Conchero\Model\ResourceModel\Alumno;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Hiberus\Conchero\Model;

/**
 * Class Collection
 * @package Hiberus\Conchero\Model\ResourceModel\Alumno
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model\Alumno::class, Model\ResourceModel\Alumno::class);
    }
}
