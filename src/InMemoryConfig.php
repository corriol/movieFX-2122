<?php

namespace App;

class InMemoryConfig implements ConfigInterface
{

    function getDataSourceName(): string
    {

        return "sqlite:tests/movies.db";
    }
}