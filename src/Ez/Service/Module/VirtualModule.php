<?php

namespace Ez\Service\Module;

use Ez\Service\Input\InputInterface;
use Ez\Service\Output\OutputInterface;
use Ez\Service\Output\Output;
use Ez\Service\Service\ServiceInterface;
use Ez\Service\Exception\ServiceNotFoundException;

/**
 * Class VirtualModule
 *
 * @package Ez\Service\Module
 * @author Derek Li
 */
class VirtualModule extends ModuleAbstract
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
     * The namespace of the module.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * The directory of all the services for the module.
     *
     * @var string
     */
    protected $dir = null;

    /**
     * If the directory has been scanned.
     *
     * @var bool
     */
    protected $dirScanned = false;

    /**
     * All the services within the module.
     *
     * @var array
     */
    protected $services = array();

    /**
     * VirtualModule constructor.
     *
     * @param string $namespace The namespace of the module.
     * @param string $dir The directory of all the services for the module.
     * @param IndexedDeepMergeArray|null $config
     */
    public function __construct($namespace = null, $dir = null, IndexedDeepMergeArray $config = null)
    {
        if (iset($namespace)) {
            $this->namespace = $namespace;
        }
        if (isset($dir)) {
            $this->dir = $dir;
        }
        if (isset($config)) {
            $this->config = $config;
        }
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $dir
     * @return $this
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param string $service
     * @return string
     */
    protected function getServiceClass($service)
    {
        return sprintf(
            '%s\\%s',
            $this->getNamespace(),
            ucfirst($service)
        );
    }

    /**
     * Find the service.
     *
     * @param string $service
     * @return ServiceInterface|null
     * @throws ServiceNotFoundException
     */
    protected function findService($service)
    {
        if (!array_key_exists($service, $this->services)) {
            $serviceClassName = $this->getServiceClass($service);
            if (class_exists($serviceClassName, true)) {
                $serviceInstance = new $serviceClassName();
                if ($serviceInstance instanceof ServiceInterface &&
                    method_exists($serviceInstance, lcfirst($service))
                ) {
                    $this->services[$service] = $serviceInstance;
                } else {
                    throw new ServiceNotFoundException($service);
                }
            } else {
                throw new ServiceNotFoundException($service);
            }
        }
        return $this->services[$service];
    }

    /**
     * Find all the services.
     *
     * @return array
     * @throws ServiceNotFoundException
     */
    protected function findAllServices()
    {
        /**
         * The given directory has been scanned.
         * Return back whatever services found before.
         */
        if ($this->dirScanned) {
            return $this->services;
        }
        $dir = $this->getDir();
        /**
         * The given directory does not exist.
         * Return back whatever services found before.
         */
        if (!file_exists($dir)) {
            $this->dirScanned = true;
            return $this->services;
        }
        /**
         * Scan the directory and find all the services inside.
         */
        $files = scandir($dir);
        if (count($files) > 0) {
            foreach ($files as $f) {
                if (fnmatch('*.php', $f)) {
                    $this->findService(str_replace('.php', '', $f));
                }
            }
        }
        $this->dirScanned = true;
        return $this->services;
    }

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
            $this->serviceList = array();
            $services = $this->findAllServices();
            foreach ($services as $name => $s) {
                $this->serviceList[$name] = sprintf(
                    'Service [%s]: %s',
                    $name,
                    $s->describe()
                );
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
     * If the service exists in the module.
     *
     * @param string $service Name of the service.
     * @return bool
     */
    public function hasService($service)
    {
        try {
            $serviceInstance = $this->findService($service);
            return $serviceInstance instanceof ServiceInterface;
        } catch (ServiceNotFoundException $e) {
            return false;
        }
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
        try {
            if ($this->hasService($service)) {
                $serviceInstance = $this->findService($service);
                if ($serviceInstance->isEnabled()) {
                    $service = lcfirst($service);
                    return call_user_func_array(array($serviceInstance, lcfirst($service)), $input->getArgs());
                } else {
                    $output = new Output();
                    return $output->addError('The service [%s] is not enabled.', $service);
                }
            } else {
                $output = new Output();
                return $output->addError('The service [%s] is not found.', $service);
            }
        } catch (ServiceNotFoundException $e) {
            $output = new Output();
            return $output->addError('The service [%s] is not found.', $service);
        }
    }
}