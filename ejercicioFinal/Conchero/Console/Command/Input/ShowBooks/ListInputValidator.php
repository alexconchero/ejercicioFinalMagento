<?php
/**
 * @author: alex conchero
 */

namespace Hiberus\Conchero\Console\Command\Input\ShowAlumnos;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Class ListInputValidator
 * @package Hiberus\Conchero\Console\Command\Input\ShowAlumnos
 */
class ListInputValidator
{
    /**
     * Validate input options
     *
     * @param InputInterface $input
     * @return InputInterface
     */
    public function validate(InputInterface $input)
    {
        return $input;
    }
}
