<?php
declare(strict_types=1);

require "src/Movie.php";
require "src/User.php";
// ara obtindrem les pel·lícules de la BD
// require "movies.inc.php";

$pdo = new PDO("mysql:host=mysql-server;dbname=movieFX;charset=utf8", "dbuser", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$moviesStmt = $pdo->prepare("SELECT * FROM movie");
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();

// fetchAll tornarà un array les dades de pel·lícules en un altre array
// caldrà mapejar les dades
$moviesAr = $moviesStmt->fetchAll();

foreach ($moviesAr as $movieAr) {
    $movie = new Movie();
    $movie->setId((int)$movieAr["id"]);
    $movie->setTitle($movieAr["title"]);
    $movie->setPoster($movieAr["poster"]);
    $movie->setReleaseDate($movieAr["release_date"]);
    $movie->setOverview($movieAr["overview"]);
    $movie->setRating((float)$movieAr["rating"]);
    $movies[] = $movie;
}

// treballaré en l'última película
echo "La pel·lícula {$movie->getTitle()} té una valoració de {$movie->getRating()}";

$user = new User(1, "Vicent");

$value = 5;

echo "<p>L'usuari {$user->getUsername()} la valora en $value punts</p>";

$user->rate($movie, $value);

echo "<p>La pel·lícula {$movie->getTitle()} té ara una valoració de {$movie->getRating()}</p>";





//require "views/index.view.php";