<?php
/**
 * @author: alex conchero
 */

namespace Hiberus\Conchero\Console\Command;

use Hiberus\Conchero\Api\Data\AlumnoInterface;
use Hiberus\Conchero\Api\AlumnoRepositoryInterface;
use Hiberus\Conchero\Console\Command\Input\ShowAlumnos\ListInputValidator;
use Hiberus\Conchero\Console\Command\Options\ShowAlumnos\ListOptions;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Class ShowAlumnosCommand
 * @package Hiberus\Conchero\Console\Command
 */
class ShowAlumnosCommand extends Command
{
    const   DETAIL_TAG  =   'detail';

    /**
     * @var ListInputValidator
     */
    protected $validator;

    /**
     * @var ListOptions
     */
    protected $listOptions;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var AlumnoRepositoryInterface
     */
    private $AlumnoRepository;

    /**
     * ShowAlumnosCommand constructor.
     * @param ListInputValidator $validator
     * @param ListOptions $listOptions
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param AlumnoRepositoryInterface $alumnoRepository
     * @param string|null $name
     */
    public function __construct(
        ListInputValidator $validator,
        ListOptions $listOptions,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        AlumnoRepositoryInterface $alumnoRepository,
        string $name = null
    ) {
        $this->validator = $validator;
        $this->listOptions = $listOptions;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->alumnoRepository = $alumnoRepository;

        parent::__construct($name);
    }

    /**
     * Configure
     */
    protected function configure()
    {
        $this->setName('hiberus:conchero')
            ->setDescription('Show Alumnos List')
            ->setDefinition($this->listOptions->getOptionsList());

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $time = microtime(true);

        $this->initFormatter($output);

        $this->process($input, $output);

        $output->writeln('Execution time: ' . (microtime(true) - $time));

        return Cli::RETURN_SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function process(InputInterface $input, OutputInterface $output)
    {
        $this->validator->validate($input);

        /** @var AlumnoInterface $alumno */
        foreach ($this->getAlumnoList() as $alumno) {
            $output->writeln(
                sprintf(
                    "<%s> >> Name: %s - Last Name: %s - Mark: %s <%s>",
                    self::DETAIL_TAG,
                    $alumno->getFirstName(),
                    $alumno->getLastName(),
                    $alumno->getMark(),
                    self::DETAIL_TAG
                )
            );
        }

    }

    /**
     * @return AlumnoInterface[]
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getAlumnoList()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $alumnoResults = $this->alumnoRepository->getList($searchCriteria)->getItems();

        if (empty($alumnoResults)) {
            throw new NoSuchEntityException(
                __('No alumno found.')
            );
        }

        return $alumnoResults;
    }

    /**
     * @param OutputInterface $output
     */
    private function initFormatter(OutputInterface $output)
    {
        /** @var OutputFormatterInterface $outputFormatter */
        $outputFormatter = $output->getFormatter();
        $outputFormatter->setStyle(self::DETAIL_TAG, new OutputFormatterStyle('yellow'));
    }
}
