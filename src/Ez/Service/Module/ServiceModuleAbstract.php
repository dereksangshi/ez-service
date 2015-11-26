<?php

namespace Ez\Service\Module;

use Ez\Service\Input\InputInterface;
use Ez\Service\Output\OutputInterface;
use Ez\Service\Output\Output;

/**
 * Class ServiceModuleAbstract
 *
 * @package Ez\Service\Module
 * @author Derek Li
 */
abstract class ServiceModuleAbstract extends ModuleAbstract
{
    /**
     * Name of the description.
     *
     * @var string
     */
    protected $description = null;

    /**
     * List of services.
     *
     * @var array
     */
    protected $serviceList = null;

    /**
     * If the module is enabled (available).
     *
     * @var bool
     */
    protected $isEnabled = true;

    /**
     * Describe service.
     *
     * @return string
     */
    public function describe()
    {
        $this->description;
    }

    /**
     * List all the services that are available in the service.
     *
     * @return array
     */
    public function listServices()
    {
        if (!isset($this->serviceList)) {
            $methods = get_class_methods($this);
            $pattern = '/^([a-zA-Z0-9]+)Service$/';
            foreach ($methods as $m) {
                if (preg_match($pattern, $m, $matches)) {
                    $this->serviceList[$matches[1]] = $matches[1];
                }
            }
        }
        return $this->serviceList;
    }

    /**
     * If the module is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Get the service method name.
     *
     * @param string $service The service.
     * @return string
     */
    protected function getServiceMethod($service)
    {
        return lcfirst(sprintf('%sService', $service));
    }

    /**
     * If the service exists in the module.
     *
     * @param string $service Name of the service.
     * @return bool
     */
    public function hasService($service)
    {
        $serviceMethod = $this->getServiceMethod($service);
        return method_exists($this, $serviceMethod);
    }

    /**
     * Operate the service.
     *
     * @param string $service Name of the service.
     * @param InputInterface $input OPTIONAL
     * @return OutputInterface
     */
    public function call($service, InputInterface $input = null)
    {
        $serviceMethod = $this->getServiceMethod($service);
        if (method_exists($this, $serviceMethod)) {
            return call_user_func_array(array($this, $serviceMethod), $input->getArgs());
        } else {
            $output = new Output();
            return $output->addError('The service [%s] is not found.', $service);
        }
    }
}