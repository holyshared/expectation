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
use expectation\matcher\EqualMatcher;
use expectation\matcher\Formatter;

describe('EqualMatcher', function() {

    before_each(function() {
        $this->matcher = new EqualMatcher(new Formatter());
    });

    describe('match', function() {
        context('when same value', function() {
            it('should return true', function() {
                $result = $this->matcher->expected(true)->match(true);
                Assertion::true($result);
            });
        });
        context('when not same value', function() {
            it('should return false', function() {
                $result = $this->matcher->expected(false)->match(true);
                Assertion::false($result);
            });
        });
    });

    describe('matchTrue', function() {
//        before(function() {
        //          $this->matcher = new EqualMatcher();
        //});
        it('should return true', function() {
            Assertion::true($this->matcher->matchTrue(true));
        });
    });

    describe('matchFalse', function() {
//        before(function() {
        //          $this->matcher = new EqualMatcher();
        //})//;
        it('should return true', function() {
            Assertion::true($this->matcher->matchFalse(false));
        });
    });

    describe('matchNull', function() {
//        before(function() {
        //          $this->matcher = new EqualMatcher();
        //})//;
        it('should return true', function() {
            Assertion::true($this->matcher->matchNull(null));
        });
    });

    describe('getFailureMessage', function() {
        it('should return the message on failure', function() {
            Assertion::false($this->matcher->expected('foo')->match('bar'));
            Assertion::same($this->matcher->getFailureMessage(), "Expected 'bar' to be 'foo'");
        });
    });

    describe('getNegatedFailureMessage', function() {
        it('should return the message on failure', function() {
            Assertion::false($this->matcher->expected('foo')->match('bar'));
            Assertion::same($this->matcher->getNegatedFailureMessage(), "Expected 'bar' not to be 'foo'");
        });
    });

});
