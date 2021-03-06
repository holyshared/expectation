<?php

/**
 * This file is part of expectation package.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Assert\Assertion;
use expectation\matcher\EqualMatcher;
use expectation\matcher\Formatter;
use expectation\spec\helper\MatcherHelper;


describe('EqualMatcher', function() {
    beforeEach(function() {
        $this->matcher = new EqualMatcher(new Formatter());
        $this->matcherHelper = new MatcherHelper($this->matcher);
    });

    describe('#match', function() {
        describe('annotations', function() {
            beforeEach(function() {
                $this->annotations = $this->matcherHelper->getAnnotations('match');
            });
            it('have toEqual', function() {
                Assertion::keyExists($this->annotations, 'toEqual');
            });
            it('have toBe', function() {
                Assertion::keyExists($this->annotations, 'toBe');
            });
        });
        context('when same value', function() {
            it('return true', function() {
                $result = $this->matcher->setExpectValue(true)->match(true);
                Assertion::true($result);
            });
        });
        context('when not same value', function() {
            it('return false', function() {
                $result = $this->matcher->setExpectValue(false)->match(true);
                Assertion::false($result);
            });
        });
    });

    describe('#matchTrue', function() {
        describe('annotations', function() {
            beforeEach(function() {
                $this->annotations = $this->matcherHelper->getAnnotations('matchTrue');
            });
            it('have toBeTrue', function() {
                Assertion::keyExists($this->annotations, 'toBeTrue');
            });
        });
        it('return true', function() {
            Assertion::true($this->matcher->matchTrue(true));
        });
    });

    describe('#matchFalse', function() {
        describe('annotations', function() {
            beforeEach(function() {
                $this->annotations = $this->matcherHelper->getAnnotations('matchFalse');
            });
            it('have toBeFalse', function() {
                Assertion::keyExists($this->annotations, 'toBeFalse');
            });
        });
        it('return true', function() {
            Assertion::true($this->matcher->matchFalse(false));
        });
    });

    describe('#matchNull', function() {
        describe('annotations', function() {
            beforeEach(function() {
                $this->annotations = $this->matcherHelper->getAnnotations('matchNull');
            });
            it('have toBeNull', function() {
                Assertion::keyExists($this->annotations, 'toBeNull');
            });
        });
        it('return true', function() {
            Assertion::true($this->matcher->matchNull(null));
        });
    });

    describe('#getFailureMessage', function() {
        it('return the message on failure', function() {
            Assertion::false($this->matcher->setExpectValue('foo')->match('bar'));
            Assertion::same($this->matcher->getFailureMessage(), "Expected 'bar' to be 'foo'");
        });
    });

    describe('#getNegatedFailureMessage', function() {
        it('return the message on failure', function() {
            Assertion::true($this->matcher->setExpectValue('foo')->match('foo'));
            Assertion::same($this->matcher->getNegatedFailureMessage(), "Expected 'foo' not to be 'foo'");
        });
    });

});
