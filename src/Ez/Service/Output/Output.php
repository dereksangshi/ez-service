<?php

namespace Ez\Service\Output;

/**
 * Interface OutputInterface
 *
 * @package Ez\Service\Output
 * @author Derek Li
 */
class Output implements OutputInterface
{
    /**
     * State of the output.
     *
     * @var mixed
     */
    protected $state = null;

    /**
     * Errors from the command.
     *
     * @var array
     */
    protected $errors = array();

    /**
     * The return value by the command.
     *
     * @var null
     */
    protected $return = null;

    /**
     * Set the state of the output.
     *
     * @param mixed $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get the state of the output.
     *
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add an error.
     *
     * @param mixed $error
     * @return $this
     */
    public function addError($error)
    {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * Get all the errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get the last error.
     *
     * @return mixed
     */
    public function getLastError()
    {
        return $this->errors[count($this->errors) - 1];
    }

    /**
     * If there is an error occurred when running the command.
     *
     * @return bool
     */
    public function hasError()
    {
        return count($this->errors) > 0;
    }

    /**
     * Set the return value.
     *
     * @param $return
     * @return $this
     */
    public function setReturn($return)
    {
        $this->return = $return;
        return $this;
    }

    /**
     * Get the return value from the command.
     *
     * @return mixed
     */
    public function getReturn()
    {
        return $this->return;
    }
}