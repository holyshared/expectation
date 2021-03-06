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

interface MatcherInterface
{

    /**
     * @param mixed $actual
     * @return boolean
     */
    public function match($actual);

    /**
     * @param mixed $expected
     * @return $this
     */
    public function setExpectValue($expected);

    /**
     * @return string
     */
    public function getFailureMessage();

    /**
     * @return string
     */
    public function getNegatedFailureMessage();

}
