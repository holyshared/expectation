<?php

/**
 * This file is part of expectation package.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace expectation;

/**
 * Class Configuration
 * @package expectation
 */
class Configuration
{

    use Populatable;


    /**
     * @var \expectation\matcher\method\MethodResolverInterface
     */
    private $methodResolver;


    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->populate($values);
    }

    /**
     * @return \expectation\matcher\method\MethodResolverInterface
     */
    public function getMethodResolver()
    {
        return $this->methodResolver;
    }

}
