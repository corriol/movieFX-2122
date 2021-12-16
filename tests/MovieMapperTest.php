<?php

namespace Tests;

use App\InMemoryConfig;
use App\Mapper\MovieMapper;
use App\Movie;
use App\Registry;
use PHPUnit\Framework\TestCase;

class MovieMapperTest extends TestCase
{
    protected function setUp(): void
    {
        $config = new InMemoryConfig();
        Registry::setPDO($config);

        parent::setUp();
    }

    public function testFindMethodShouldReturnNullWhenObjectNotFound(): void {
        $mapper = new MovieMapper();
        $movie = $mapper->find(10);
        $this->assertEquals(null, $movie);
    }

    public function testFindMethodShouldReturnMovieObjectWhenObjectFound(): void {
        $mapper = new MovieMapper();
        $movie = $mapper->find(1);
        $this->assertInstanceOf(Movie::class, $movie);
    }
}