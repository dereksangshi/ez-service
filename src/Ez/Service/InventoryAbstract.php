<?php

namespace Ez\Service;

use Ez\Service\Input\InputInterface;
use Ez\Service\Output\OutputInterface;
use Ez\Service\Output\Output;
use Ez\Service\Exception\ModuleNotFoundException;
use Ez\Service\Module\VirtualModule;
use Ez\Service\Module\ModuleInterface;

/**
 * Class Inventory
 *
 * @package Ez\Service
 * @author Derek Li
 */
abstract class InventoryAbstract implements InventoryInterface
{
    /**
     * @var InventoryConfig
     */
    protected $config = null;

    /**
     * Description of the service.
     *
     * @var string
     */
    protected $description = null;

    /**
     * @var array
     */
    protected $modules = array();

    /**
     * Constructor.
     *
     * @param InventoryConfig $config
     */
    public function __construct(InventoryConfig $config = null)
    {
        if (isset($config)) {
            $this->config = $config;
        }
        $this->init();
    }

    /**
     * Initialize the service inventory.
     */
    abstract protected function init();

    /**
     * Set the configuration.
     *
     * @param InventoryConfig $config
     * @return $this
     */
    public function setConfig(InventoryConfig $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Get the configuration.
     *
     * @return InventoryConfig
     */
    public function getConfig()
    {
        if (!isset($this->config)) {
            $this->config = new InventoryConfig();
        }
        return $this->config;
    }

    /**
     * Describe service.
     *
     * @return string
     */
    public function describe()
    {
        return $this->description;
    }

    /**
     * List all the services that are available in the service.
     *
     * @return array
     */
    public function listServices()
    {

    }

    /**
     * If the service is available.
     *
     * @param string $module The module.
     * @param string $service The service.
     * @return bool
     */
    public function hasService($module, $service)
    {
        try {
            return $this->getModule($module)->hasService($service);
        } catch (ModuleNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get the module class (for a potential service module).
     *
     * @param string $module
     * @return string
     */
    protected function getModuleClass($module)
    {
        return sprintf(
            '%s\\%s',
            $this->getConfig()->get('namespace'),
            ucfirst($module)
        );
    }

    /**
     * Get the module directory (for a potential virtual module).
     *
     * @param string $module
     * @return string
     */
    protected function getModuleDir($module)
    {
        return $this->getConfig()->get('dir').DIRECTORY_SEPARATOR.ucfirst($module);
    }

    /**
     * Get the module to call.
     *
     * @param string $module
     * @return ModuleInterface
     * @throws ModuleNotFoundException
     */
    public function getModule($module)
    {
        if (!array_key_exists($module, $this->modules)) {
            $moduleClass = $this->getModuleClass($module);
            if (class_exists($moduleClass, true)) {
                $this->modules[$module] = new $moduleClass($this->getConfig());
            } else {
                $moduleDir = $this->getModuleDir($module);
                if (file_exists($moduleDir)) {
                    $this->modules[$module] = new VirtualModule(
                        $this->getModuleClass($module),
                        $moduleDir,
                        $this->getConfig()
                    );
                } else {
                    throw new ModuleNotFoundException($module);
                }
            }
        }
        return $this->modules[$module];
    }

    /**
     * Run the service.
     *
     * @param string $module The module.
     * @param string $service The service.
     * @param InputInterface|null $input OPTIONAL The input for the service.
     * @return OutputInterface
     */
    public function call($module, $service, InputInterface $input = null)
    {
        try {
            return $this->getModule($module)->call($service, $input);
        } catch (ModuleNotFoundException $e) {
            $output = new Output();
            return $output->addError('The module [%s] is not found.', $module);
        }
    }

    /**
     * Magic function to get the module.
     *
     * @param string $method The method called
     * @param array $args Arguments passed
     * @return $this
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (preg_match('/^_([a-zA-Z1-9]+)_$/', $method, $matches)) {
            return $this->getModule($matches[1]);
        }
    }
}