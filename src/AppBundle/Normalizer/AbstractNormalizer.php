<?php
/**
 * Created by PhpStorm.
 * User: fkhiary
 * Date: 11/02/2019
 * Time: 09:56
 */

namespace AppBundle\Normalizer;


abstract class AbstractNormalizer implements NormalizerInterface
{
    protected $exceptionTypes;

    /**
     * AbstractNormalizer constructor.
     * @param $exceptionTypes
     */
    public function __construct(array $exceptionTypes)
    {
        $this->exceptionTypes = $exceptionTypes;
    }

    public function supports(\Exception $exception)
    {
        return in_array(get_class($exception), $this->exceptionTypes);
    }

}
