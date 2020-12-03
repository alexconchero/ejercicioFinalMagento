<?php

namespace Hiberus\Conchero\Setup\Patch\Data;

use Hiberus\Conchero\Api\Data\AlumnoInterface;
use Hiberus\Conchero\Api\Data\AlumnoInterfaceFactory;
use Hiberus\Conchero\Api\AlumnoRepositoryInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;

/**
 * Class PopulateDataModel
 * @package Hiberus\Conchero\Setup\Patch\Data
 */
class PopulateDataModel implements DataPatchInterface
{
    const   RANDOM_PERSON_DATA_API_ENDPOINT =   'https://api.namefake.com/{{locale}}/{{gender}}/';
    const   NUMBER_OF_ALUMNOS  =   10;
   

    /**
     * @var AlumnoRepositoryInterface
     */
    private $alumnoRepository;

    /**
     * @var AlumnpInterfaceFactory
     */
    private $alumnoFactory;

    /**
     * @var CurlFactory
     */
    private $curlFactory;

    /**
     * PopulateDataModel constructor.
     * @param AlumnoRepositoryInterface $alumnoRepository
     * @param AlumnoInterfaceFactory $alumnoFactory
     * @param CurlFactory $curlFactory
     */
    public function __construct(
        AlumnoRepositoryInterface $alumnoRepository,
        AlumnoInterfaceFactory $alumnoFactory,
        CurlFactory $curlFactory
    ) {
        $this->alumnoRepository = $alumnoRepository;
        $this->alumnoFactory = $alumnoFactory;
        $this->curlFactory = $curlFactory;
    }

    /**
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        $this->populateData();
    }

    /**
     * Populate Data Model
     */
    private function populateData()
    {
        $this->populateAlumnos();
    }

    

    /**
     * Populate Alumnos Data
     */
    private function populateAlumnos()
    {
        for ($i = 0; $i < self::NUMBER_OF_ALUMNOS; $i++) {
            $alumnoData = $this->getRandomPersonData();

            /** @var AlumnoInterface $alumno */
            $alumno = $this->alumnoFactory->create();

            $alumno->setId($i)
                ->setFirstName('Nombre')
                ->setLastName('Apellido'.$i)
                ->setMark(rand ( 0 , 10))
            ;

            $this->alumnoRepository->save(
                $alumno
            );
        }
    }

    /**
     * @param string $locale
     * @param string $gender
     * @return array
     */
    private function getRandomPersonData($locale = 'spanish-spain', $gender = 'random')
    {
        /** @var Curl $curl */
        $curl = $this->curlFactory->create();
        $curl->setTimeout(5);

        $apiEndpoint = self::RANDOM_PERSON_DATA_API_ENDPOINT;
        $uri = str_replace('{{locale}}', $locale, $apiEndpoint);
        $uri = str_replace('{{gender}}', $gender, $uri);

        $curl->get($uri);

        return json_decode($curl->getBody(), true);
    }

    /**
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }
}
