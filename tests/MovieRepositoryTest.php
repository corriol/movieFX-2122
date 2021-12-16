<?php

namespace Tests;

use App\Movie;
use App\Mapper\MovieMapper;
use App\Repository\MovieRepository;
use PHPUnit\Framework\TestCase;

class MovieRepositoryTest extends TestCase
{
    public function testFindMethodShouldReturnMovieObjectWhenFound(): void {
        $movieDummy = $this->createPartialMock(Movie::class, []);
        $mapperStub = $this->createMock(MovieMapper::class);
        $mapperStub->method("find")->willReturn($movieDummy);
        $mr = new MovieRepository($mapperStub);
        $movie = $mr->find(1);
        $this->assertInstanceOf(Movie::class, $movie);
    }

    public function testFindMethodShouldReturnNullWhenNotFound(): void {
        $mapperStub = $this->createMock(MovieMapper::class);
        $mapperStub->method("find")->willReturn(null);
        $mr = new MovieRepository($mapperStub);
        $movie = $mr->find(2);
        $this->assertEquals(null, $movie);
    }

}