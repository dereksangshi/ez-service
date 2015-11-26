<?php

namespace Ez\Service\Module;

use Ez\Service\Input\Input;
use Ez\DataStructure\IndexedDeepMergeArray;

/**
 * Class ModuleAbstract
 *
 * @package Ez\Service\Module
 * @author Derek Li
 */
abstract class ModuleAbstract implements ModuleInterface
{
    /**
     * @var IndexedDeepMergeArray
     */
    protected $config = null;

    /**
     * ModuleAbstract constructor.
     *
     * @param IndexedDeepMergeArray|null $config
     */
    public function __construct(IndexedDeepMergeArray $config = null)
    {
        if (isset($config)) {
            $this->config = $config;
        }
    }

    /**
     * @param IndexedDeepMergeArray $config
     * @return $this
     */
    public function setConfig(IndexedDeepMergeArray $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return IndexedDeepMergeArray
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Magic function to get the module.
     *
     * @param string $method The method called
     * @param array $args Arguments passed
     * @return $this
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (preg_match('/^_([a-zA-Z1-9]+)_$/', $method, $matches)) {
            $input = new Input();
            $input->setArgs($args);
            return $this->call($matches[1], $input);
        }
    }

}