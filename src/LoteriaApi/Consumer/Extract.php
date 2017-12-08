<?php

namespace LoteriaApi\Consumer;

use VIPSoft\Unzip\Unzip;

class Extract
{
    private $component;
    private $datasource;
    private $paths;
    
    public function setComponent(Unzip $component)
    {
        $this->component = $component;
        return $this;
    }
    
    public function setDataSource(array $datasource)
    {
        $this->datasource = $datasource;
        return $this;
    }

    public function setPathsStorage($paths)
    {
        $this->paths = $paths;
        return $this;
    }
    
    public function run()
    {
        foreach ($this->datasource as $concurso) {
            $ppp = $this->paths['path']['zip'] . DS . $concurso['zip'];
            echo "extract from: {$ppp} to: {$this->paths['path']['ext']}\n";
            $this->component->extract(
                $this->paths['path']['zip'] . DS . $concurso['zip'],
                $this->paths['path']['ext']
            );
        }
    }
}
