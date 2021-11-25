<?php
declare(strict_types=1);


require 'src/FlashMessage.php';
require 'src/Registry.php';

// es bona idea no treballar en literal
const COOKIE_LAST_VISIT = "last_visit_date";



// we get the current cookie value
$lastVisit = filter_input(INPUT_COOKIE, COOKIE_LAST_VISIT, FILTER_VALIDATE_INT);

// we can also use the coalsece operator
/* $lastVisit =(int)($_COOKIE[$cookieName] ?? null); //
// or the traditional isset
/* if (isset($_COOKIE[$cookieName])) {
    $lastVisit = (int)$_COOKIE[$cookieName];
} else
    $lastVisit = null;
*/

// if null we show a welcome message
if (empty($lastVisit))
    $message = "Benvingut!";
else
    $message = "Benvingut de nou, la teua darrera visita va ser el  " .
        date("d/m/Y h:i:s", $lastVisit);

// we register the current time and set the expiration date to the next week.
setcookie(COOKIE_LAST_VISIT, (string)time(), time() + 7 * 24 * 60 * 60);


// Task 504

# index.php
// Activem el suport per a sessions
session_start();

// comprovem si es la primera visita
$visits = $_SESSION["visits"]??[];

// if not empty generate an HTML Unordered List
if (!empty($visits))
    $messageSession =  "<ul><li>" . implode("</li><li>", array_map(function($v) {
            return date("d/m/Y h:i:s", $v);
        }, $visits)) . "</li></ul>";
else
    $messageSession = "Benvigut! (versió sessió)!";

// guardem en un array index
$_SESSION["visits"][] = time();


require "src/Movie.php";
require "src/User.php";
// ara obtindrem les pel·lícules de la BD
// require "movies.inc.php";
/*
echo "<h2>Activitat 501</h2>";
echo "<p>$message</p>";

echo "<h2>Activitat 504</h2>";
echo "<p>$messageSession</p>";

if (!empty($_SESSION["message"])) {
    echo "<h2>Activitat 507</h2>";
    echo "<p>{$_SESSION["message"]}</p>";
    unset ($_SESSION["message"]);
}
*/


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

/*
// treballaré en l'última película
echo "La pel·lícula {$movie->getTitle()} té una valoració de {$movie->getRating()}";

$user = new User(1, "Vicent");

$value = 5;

echo "<p>L'usuari {$user->getUsername()} la valora en $value punts</p>";

//$user->rate($movie, $value);

echo "<p>La pel·lícula {$movie->getTitle()} té ara una valoració de {$movie->getRating()}</p>";
*/
$message = FlashMessage::get("message");

require "views/index.view.php";