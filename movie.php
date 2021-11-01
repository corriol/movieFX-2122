<?php
declare(strict_types=1);

require "src/Movie.php";

//creem l'array d'objectes Movie
//require "movies.inc.php";

// inicialitze les variables que necessitaré.
$id = 0;
$errors = [];
$movie = null;

$idTemp = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!empty($idTemp))
    $id = $idTemp;

$pdo = new PDO("mysql:host=mysql-server;dbname=movieFX;charset=utf8", "dbuser", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$moviesStmt = $pdo->prepare("SELECT * FROM movie WHERE id=:id");
$moviesStmt->bindValue("id", $id);
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();

$movieAr = $moviesStmt->fetch();

if (!empty($movieAr)) {
    $movie = new Movie();
    $movie->setId((int)$movieAr["id"]);
    $movie->setTitle($movieAr["title"]);
    $movie->setPoster($movieAr["poster"]);
    $movie->setReleaseDate($movieAr["release-date"]);
    $movie->setOverview($movieAr["overview"]);
    $movie->setRating((float)$movieAr["rating"]);
}
else
    $errors[] = "La pel·lícula sol·licitada no existeix";

/*
Tot aquest codi ja no és necessari
$filteredMovies = array_filter($movies, function ($movie) use ($id) {
    if ($movie->getId()===$id)
        return true;
    return false;
});

if (count($filteredMovies) === 1)
    $movie = array_shift($filteredMovies);
else
    $errors[] = "La pel·lícula sol·licitada no existeix";
*/
require "views/movie.view.php";