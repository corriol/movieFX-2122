<?php
declare(strict_types=1);

namespace App\Repository;
use App\Mapper\MovieMapper;
use App\Movie;

class MovieRepository
{
    public MovieMapper $mapper;
    public function __construct(MovieMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(Movie $movie) {

        if ($movie->getId()!==null) {
            $this->mapper->update($movie);
        } else
            $this->mapper->insert($movie);
    }

    public function find(int $id):?Movie {
        return $this->mapper->find($id);
    }

    public function findAll():array {
        return $this->mapper->findAll();
    }
}