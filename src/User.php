<?php

class User
{
    private int $id;
    private string $username;
    private string $password;
    private Plan $plan;


    public function __construct(int $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return Plan
     */
    public function getPlan(): Plan
    {
        return $this->plan;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan(Plan $plan): void
    {
        $this->plan = $plan;
    }

    public function rate(Movie $movie, int $value): void {
        $pdo = new PDO("mysql:host=mysql-server;dbname=movieFX;charset=utf8", "dbuser", "1234");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $pdo->prepare("SELECT count(id) as count FROM rating WHERE movie_id = ?");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([$movie->getId()]);
        $res = $stmt->fetch();
        $voters = $res["count"];

        $currentRating = $movie->getRating();
        $globalRating = $currentRating * $voters;
        $newRating = ($globalRating + $value)/($voters+1);

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO rating (user_id, movie_id, value) values (?,?,?)");
            $stmt->execute([$this->getId(), $movie->getId(), $value]);

            $stmt = $pdo->prepare("UPDATE movie set rating = ? WHERE id = ?");
            $stmt->execute([$newRating, $movie->getId()]);

            $movie->setRating($newRating);
            $pdo->commit();

        } catch (Exception $exception) {
            $pdo->rollBack();
            throw new Exception("Error en actualitzar la valoració");
        }
    }
}