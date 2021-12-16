<?php

namespace App\Alex;

use App\ConfigInterface;

class Config implements ConfigInterface
{
    private \SimpleXMLElement $conf;
    public function __construct(string $configPath)
    {
        $this->conf = simplexml_load_file($configPath);
    }

    public function getDSN(): string{
        $dsn = $this->conf->dsn;
        return $dsn;
    }

    public function getPosterPath(){
        $posterPath = $this->conf->posterpath;
        return $posterPath;
    }

    function getDataSourceName(): string
    {
        // TODO: Implement getDataSourceName() method.
        return $this->getDSN();
    }
}