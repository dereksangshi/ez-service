<?php

namespace Ez\Service;

use Ez\DataStructure\IndexedDeepMergeArray;

class InventoryConfig extends IndexedDeepMergeArray
{
    /**
     * Include the namespace.
     *
     * @param string $namespace
     * @param string $dir
     */
    public function setNamespace($namespace, $dir)
    {
        $this->addArray(array(
            'namespace' => $namespace,
            'dir' => $dir
        ));
    }
}