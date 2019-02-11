<?php
/**
 * Created by PhpStorm.
 * User: fkhiary
 * Date: 11/02/2019
 * Time: 09:53
 */

namespace AppBundle\Normalizer;


interface NormalizerInterface
{
    public function normalize(\Exception $exception);

    public function supports(\Exception $exception);
}
