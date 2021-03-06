<?php

/**
 * This file is part of expectation package.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace expectation\matcher;

use expectation\AbstractMatcher;
use expectation\matcher\annotation\Lookup;
use expectation\matcher\strategy\ArrayInclusionStrategy;
use expectation\matcher\strategy\StringInclusionStrategy;
use InvalidArgumentException;


/**
 * @package expectation\matcher
 * @property mixed $actualValue
 * @property mixed $expectValue
 * @author Noritaka Horio <holy.shared.design@gmail.com>
 */
class InclusionMatcher extends AbstractMatcher
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var \expectation\matcher\strategy\InclusionResult
     */
    private $matchResult;


    /**
     * @Lookup(name="toContain")
     * @param mixed $actual
     * @return boolean
     */
    public function match($actual)
    {

        if ($this->validate($actual) === false) {
            throw new InvalidArgumentException('Argument must be an array or string');
        }

        $this->setActualValue($actual);

        $actualValue = $this->getActualValue();
        $expectValue = $this->getExpectValue();

        $expectValues = (is_array($expectValue))
            ? $expectValue : [ $expectValue ];

        $strategy = $this->createStrategyFromActual($actualValue);
        $this->matchResult = $strategy->match($expectValues);

        return $this->matchResult->isMatched();
    }

    /**
     * @return string
     */
    public function getFailureMessage()
    {
        $unmatchResults = $this->matchResult->getUnmatchResults();
        $missing = implode(', ', $unmatchResults);
        return "Expected {$this->type} to contain {$missing}";
    }

    /**
     * @return string
     */
    public function getNegatedFailureMessage()
    {
        $matchResults = $this->matchResult->getMatchResults();
        $found = implode(', ', $matchResults);
        return "Expected {$this->type} not to contain {$found}";
    }

    /**
     * @param $actual
     * @return boolean
     */
    private function validate($actual)
    {
        return (is_array($actual) || is_string($actual));
    }

    private function createStrategyFromActual($actual)
    {
        $strategy = null;
        $actualValue = $this->getActualValue();

        if (is_string($actualValue)) {
            $this->type = 'string';
            $strategy = new StringInclusionStrategy($actual);
        } else if (is_array($actualValue)) {
            $this->type = 'array';
            $strategy = new ArrayInclusionStrategy($actual);
        }

        return $strategy;
    }

}
