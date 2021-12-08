<?php

namespace App\Josep;

use App\ConfigInterface;

class Config implements ConfigInterface
{
    private array $conf = [];

    public function __construct(string $configPath)
    {
        $dsn = file_get_contents($configPath);
        $this->conf = json_decode($dsn, true);
    }

    function get(string $property) {
        return $this->conf[$property];
    }

    function getDns(): string
    {
        return $this->get("dsn");
    }

    function getRutaPoster(): string
    {
        return $this->get("rutaPosters");
    }

    function getDataSourceName(): string
    {

        return $this->getDns();
    }
}