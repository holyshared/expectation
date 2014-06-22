<?php

/**
 * This file is part of expectation package.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Preview\DSL\BDD;

use Assert\Assertion;
use ReflectionMethod;
use expectation\matcher\annotation\Lookup;

describe('Lookup', function() {

    before(function() {
        $this->method = new ReflectionMethod('\\expectation\\spec\\fixture\\FixtureMatcher', 'match');
        $this->annotation = new Lookup([
            'name' => 'toEqual'
        ]);
    });

    describe('getLookupName', function() {
        it('should return register name', function() {
            $name = $this->annotation->getLookupName();
            Assertion::same($name, "toEqual");
        });
    });

    describe('getMatcherMethodFactory', function() {
        it('should return expectation\MatcherMethodFactoryInterface', function() {
            $factory = $this->annotation->getMatcherMethodFactory($this->method);
            Assertion::isInstanceOf($factory, "expectation\MatcherMethodFactoryInterface");
        });
    });

});
