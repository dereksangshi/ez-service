<?php

namespace Ez\Service\Input;

/**
 * Interface InputInterface
 *
 * @package Ez\Service\Input
 * @author Derek Li
 */
interface InputInterface
{
    /**
     * @param mixed $arg
     * @return $this
     */
    public function addArg($arg);

    /**
     * @param array $args
     * @return $this
     */
    public function setArgs(array $args);

    /**
     * @return array
     */
    public function getArgs();
}