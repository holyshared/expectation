<?php

/**
 * This file is part of expectation package.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace expectation\matcher\method;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use expectation\matcher\annotation\Lookup;
use PhpCollection\Sequence;
use expectation\matcher\NamespaceReflection;
use Zend\Loader\StandardAutoloader;


/**
 * Class MethodLoader
 * @package expectation\matcher\method
 */
class MethodLoader
{

    /**
     * @var \PhpCollection\Sequence
     */
    private $classes;

    /**
     * @var \PhpCollection\Sequence
     */
    private $namespaces;

    /**
     * @var \expectation\matcher\method\FactoryLoader
     */
    private $factoryLoader;

    /**
     * @var StandardAutoloader
     */
    private $autoLoader;


    /**
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        $this->classes = new Sequence();
        $this->namespaces = new Sequence();
        $this->autoLoader = new StandardAutoloader();
        $this->factoryLoader = new FactoryLoader($annotationReader);
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return $this
     */
    public function registerClass(ReflectionClass $reflectionClass)
    {
        $this->autoLoader->autoload($reflectionClass->getFileName());
        $this->classes->add($reflectionClass);
        return $this;
    }

    /**
     * @param string $namespace
     * @param string $directory
     * @return $this
     */
    public function registerNamespace($namespace, $directory)
    {
        $this->autoLoader->registerNamespace($namespace, $directory);

        $namespaceReflection = new NamespaceReflection($namespace, $directory);
        $this->namespaces->add($namespaceReflection);

        return $this;
    }

    /**
     * @return MethodContainer
     */
    public function load()
    {
        $this->autoLoader->register();

        $registry = new FactoryRegistry();

        $factories = $this->factoryLoader->loadFromNamespaces($this->namespaces);
        $registry->registerAll($factories);

        $factories = $this->factoryLoader->loadFromClasses($this->classes);
        $registry->registerAll($factories);

        return new MethodContainer($registry);
    }

}
