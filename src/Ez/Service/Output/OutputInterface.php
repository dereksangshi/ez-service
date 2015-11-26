<?php

namespace Ez\Service\Output;

/**
 * Interface OutputInterface
 *
 * @package Ez\Service\Output
 * @author Derek Li
 */
interface OutputInterface
{

    /**
     * The state of the output.
     *
     * @param mixed $state
     * @return $this
     */
    public function setState($state);

    /**
     * Get the state of the output.
     *
     * @return mixed
     */
    public function getState();

    /**
     * @param mixed $error
     * @return $this
     */
    public function addError($error);

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return mixed
     */
    public function getLastError();

    /**
     * If there is an error occurred when running the command.
     *
     * @return bool
     */
    public function hasError();

    /**
     * Set the return value.
     *
     * @param $return
     * @return $this
     */
    public function setReturn($return);

    /**
     * Get the return value from the command.
     *
     * @return mixed
     */
    public function getReturn();
}