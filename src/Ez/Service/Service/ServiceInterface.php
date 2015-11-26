<?php

namespace Ez\Service\Service;

use Ez\Service\Input\InputInterface;
use Ez\Service\Output\OutputInterface;

/**
 * Interface ServiceInterface
 *
 * @package Ez\Service\Service
 * @author Derek Li
 */
interface ServiceInterface
{
    /**
     * Describe the service.
     *
     * @return string
     */
    public function describe();

    /**
     * If the service is enabled.
     *
     * @return bool
     */
    public function isEnabled();
}