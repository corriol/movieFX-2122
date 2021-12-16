<?php

namespace App\Mapper;
use App\Movie;
use App\Registry;
use PDO;

class MovieMapper
{
    protected PDO $pdo;


    public function __construct()
    {
        $this->pdo = Registry::getPDO();


    }

    public function find(int $id): ?Movie
    {
        $stmt = $this->pdo->prepare("SELECT * FROM movie WHERE id=:id");
        $stmt->execute(["id"=>$id]);
        $row = $stmt->fetch();
        $stmt->closeCursor();
        if (!is_array($row)) {
            return null;
        }
        if (!isset($row['id'])) {
            return null;
        }
        $object = Movie::fromArray($row);
        return $object;
    }

    public function findAll(): array {
        $array = [];
        $selectAllStmt = $this->pdo->prepare(
            "SELECT * FROM movie"
        );

        $selectAllStmt->execute();
        while ($row = $selectAllStmt->fetch())
            $array[] = Movie::fromArray($row);
        return $array;
    }

    public function createObject(array $raw): Movie
    {
        $obj = Movie::fromArray($raw);
        return $obj;
    }

    public function insert(Movie $obj)
    {
        $values = $obj->toArray();
        unset($values["id"]);
        $insertStmt = $this->pdo->prepare(
            "INSERT INTO movie(title, overview, release_date, rating, poster) 
            VALUES (:title, :overview, :release_date, :rating, :poster)");
        $insertStmt->execute($values);
        $id = $this->pdo->lastInsertId();
        $obj->setId((int)$id);
    }

    public function update(Movie $object)
    {
        $values = $object->toArray($object);

        $updateStmt = $this->pdo->prepare(
            "UPDATE movie 
                            set title = :title, 
                                overview = :overview, 
                                release_date =:release_date, 
                                rating = :rating, 
                                poster=:poster
                                WHERE id = :id"
        );

        $updateStmt->execute($values);
    }

}