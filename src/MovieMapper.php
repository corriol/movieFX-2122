<?php

require_once 'Movie.php';

class MovieMapper
{
    protected $pdo;

    private $selectStmt;
    private $updateStmt;
    private $insertStmt;
    private $deleteStmt;
    private $selectAllStmt;

    public function __construct()
    {

        $this->pdo = Registry::getPDO();
        $this->selectAllStmt = $this->pdo->prepare(
            "SELECT * FROM movie"
        );

        $this->selectStmt = $this->pdo->prepare(
            "SELECT * FROM movie WHERE id=:id"
        );
        $this->updateStmt = $this->pdo->prepare(
            "UPDATE movie 
                            set title = :title, 
                                overview = :overview, 
                                release_date =:release_date, 
                                rating = :rating, 
                                poster=:poster
                                WHERE id = :id"
        );

        $this->insertStmt = $this->pdo->prepare(
            "INSERT INTO movie(title, overview, release_date, rating, poster) 
            VALUES (:title, :overview, :release_date, :rating, :poster)"
        );
    }

    public function find(int $id): ?Movie
    {
        $this->selectStmt->execute(["id"=>$id]);
        $row = $this->selectStmt->fetch();
        $this->selectStmt->closeCursor();
        if (!is_array($row)) {
            return null;
        }
        if (!isset($row['id'])) {
            return null;
        }
        $object = $this->createObject($row);
        return $object;
    }

    public function findAll(): array {
        $array = [];
        $this->selectAllStmt->execute();
        while ($row = $this->selectAllStmt->fetch())
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
        $this->insertStmt->execute($values);
        $id = $this->pdo->lastInsertId();
        $obj->setId((int)$id);
    }

    public function update(Movie $object)
    {
        $values = $object->toArray($object);
        $this->updateStmt->execute($values);
    }

}