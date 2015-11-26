<?php

namespace Ez\Service\Exception;

/**
 * Class ServiceNotFoundException
 *
 * @package Ez\Service\Exception
 */
class ServiceNotFoundException extends \Exception
{
    /**
     * The exception code.
     *
     * @var string
     */
    protected $code = '810001';

    /**
     * Override the message passed through.
     *
     * @param string $service Name of the service.
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($service, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf("The requested service [%s] is not found.", $service), $code, $previous);
    }
}