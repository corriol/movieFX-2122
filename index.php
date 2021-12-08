<?php
declare(strict_types=1);

require 'bootstrap.php';

use App\Movie;
use App\Registry;
use App\FlashMessage;


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
$visits = $_SESSION["visits"] ?? [];

// if not empty generate an HTML Unordered List
if (!empty($visits))
    $messageSession = "<ul><li>" . implode("</li><li>", array_map(function ($v) {
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
*/
$message = FlashMessage::get("message");
if (!empty($message)) {
    echo "<h2>Missatge</h2>";
    echo "<p>$message</p>";
}

$pdo = Registry::get("PDO");
$moviesStmt = $pdo->prepare("SELECT * FROM movie");
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();


$logger = Registry::get(Registry::LOGGER);
$logger->info("s'ha executat una consulta");

// fetchAll tornarà un array les dades de pel·lícules en un altre array
// caldrà mapejar les dades
$moviesAr = $moviesStmt->fetchAll();

foreach ($moviesAr as $movieAr) {
    $movies[] = Movie::fromArray($movieAr);
}

//$movie = new Movie(12222, "", "asdfasdfsd",
//    "2021-10-12", 4.2, "asd.jpg");

// treballaré en l'última película
//echo "La pel·lícula {$movie->getTitle()} té una valoració de {$movie->getRating()}";

//$user = new User(1, "Vicent");

//$value = 5;

//echo "<p>L'usuari {$user->getUsername()} la valora en $value punts</p>";

//$user->rate($movie, $value);

//echo "<p>La pel·lícula {$movie->getTitle()} té ara una valoració de {$movie->getRating()}</p>";

require "views/index.view.php";