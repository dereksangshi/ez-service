<?php

namespace Ez\Service\Module;

use Ez\Service\Input\InputInterface;
use Ez\Service\Output\OutputInterface;

/**
 * Interface ModuleInterface
 *
 * @package Ez\Service\Module
 * @author Derek Li
 */
interface ModuleInterface
{
    /**
     * Describe service.
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
     * If the service exists in the module.
     *
     * @param string $service Name of the service.
     * @return bool
     */
    public function hasService($service);

    /**
     * If the service is enabled.
     *
     * @return mixed
     */
    public function isEnabled();

    /**
     * Run the service.
     *
     * @param string $service Name of the service.
     * @param InputInterface|null $input OPTIONAL
     * @return OutputInterface
     */
    public function call($service, InputInterface $input = null);
}