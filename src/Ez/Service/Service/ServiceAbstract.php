<?php

namespace Ez\Service\Service;

use Ez\Service\Input\InputInterface;
use Ez\Service\Output\OutputInterface;

/**
 * Class ServiceAbstract
 *
 * @package Ez\Service\Service
 * @author Derek Li
 */
abstract class ServiceAbstract implements ServiceInterface
{
    /**
     * @var null
     */
    protected $description = null;

    /**
     * @var bool
     */
    protected $isEnabled = true;

    /**
     * Describe the service.
     *
     * @return string
     */
    public function describe()
    {
        return $this->description;
    }

    /**
     * If the service is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }
}