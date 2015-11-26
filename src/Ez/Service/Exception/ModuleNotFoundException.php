<?php

namespace Ez\Service\Exception;

/**
 * Class ModuleNotFoundException
 *
 * @package Ez\Service\Exception
 */
class ModuleNotFoundException extends \Exception
{
    /**
     * The exception code.
     *
     * @var string
     */
    protected $code = '810002';

    /**
     * Override the message passed through.
     *
     * @param string $module Name of the module.
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($module, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf("The requested module [%s] is not found.", $module), $code, $previous);
    }
}