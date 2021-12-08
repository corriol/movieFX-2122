<?php
declare(strict_types=1);

require 'bootstrap.php';

use App\Movie;
use App\MovieRepository;
//creem l'array d'objectes Movie
//require "movies.inc.php";

// inicialitze les variables que necessitaré.
$id = 0;
$errors = [];
$movie = null;

$idTemp = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!empty($idTemp))
    $id = $idTemp;

$movieRepository = new MovieRepository();

$movie = $movieRepository->find($id);
if ($movie==null)
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