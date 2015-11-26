<?php

namespace Ez\Service;

use Ez\Service\Input\InputInterface;
use Ez\Service\Output\OutputInterface;

/**
 * Interface InventoryInterface
 *
 * @package Ez\Service\Service
 * @author Derek Li
 */
interface InventoryInterface
{
    /**
     * Describe the service.
     *
     * @return string
     */
    public function describe();

    /**
     * List all the services that are available in the service.
     *
     * @return array
     */
    public function listServices();

    /**
     * If the service is available.
     *
     * @param string $module The module.
     * @param string $service The service.
     * @return bool
     */
    public function hasService($module, $service);

    /**
     * Run the service.
     *
     * @param string $module The module.
     * @param string $service The service.
     * @param InputInterface|null $input OPTIONAL The input for the service.
     * @return OutputInterface
     */
    public function call($module, $service, InputInterface $input = null);
}