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

use expectation\matcher\method\MethodContainerInterface;

/**
 * @package expectation
 */
class Evaluator implements EvaluatorInterface
{

    /**
     * @var mixed
     */
    private $actual;

    /**
     * @var boolean
     */
    private $negated = false;

    /**
     * @var \expectation\MatcherMethodContainerInterface
     */
    private $container;

    /**
     * @param MethodContainerInterface $container
     */
    public function __construct(MethodContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * @param mixed $actual
     * @return $this
     */
    public function that($actual)
    {
        $this->actual = $actual;
        return $this;
    }

    /**
     * @return $this
     */
    public function not()
    {
        $this->negated = true;
        return $this;
    }

    public function __call($name, array $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        $matcher = $this->container->find($name, $arguments);

        if ($this->negated) {
            $matcher->negativeMatch($this->actual);
        } else {
            $matcher->positiveMatch($this->actual);
        }
    }

}