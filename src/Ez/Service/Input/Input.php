<?php

namespace Ez\Service\Input;

/**
 * Interface InputInterface
 *
 * @package Ez\Service\Input
 * @author Derek Li
 */
class Input implements InputInterface
{
    /**
     * Arguments passed through (which will eventually
     * be passed to the service function).
     *
     * @var array
     */
    protected $args = array();

    /**
     * Add an argument.
     *
     * @param mixed $arg
     * @return $this
     */
    public function addArg($arg)
    {
        $this->args[] = $arg;
        return $this;
    }

    /**
     * @param array $args
     * @return $this
     */
    public function setArgs(array $args)
    {
        $this->args = $args;
        return $this;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }
}