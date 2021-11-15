<?php declare(strict_types=1); ?>
<?php
session_start();
//if (empty($_SESSION["user"]))
//    die("<p><a href= \"login.php\">Login</a> or die!</p>");

// Inicialitze les variables perquè existisquen en tots els possibles camins
// Sols emmagatzameré en elles valors vàlids.
// Acumularé els errors en un array per a mostrar-los al final.
// Use la sintaxi alternativa de les estructures de control per a la part de vistes.
// Cree funció clean per a netejar valors

require "helpers.php";
require 'src/Exceptions/FileUploadException.php';
require_once 'src/Exceptions/NoUploadedFileException.php';
require_once 'src/Movie.php';

const MAX_SIZE = 1024 * 1000;

$data["title"] = "";
$data["release_date"] = "";
$data["overview"] = "";
$data["poster"] = "";
$data["rating"] = 0;

$validTypes = ["image/jpeg", "image/jpg"];

$errors = [];

/*
    Token per a evitar atacs CSRF:
    1) Creem el token en mostrar el formulari
    2) En llegir-lo l'esborrem, ja no serà valid perquè ja s'ha processat satisfactòriament o no el formulari
    3) Si el token és invàlid cancelem l'execució

*/

if (!isPost()) {
    die("Aquesta pàgina sols usa el mètode POST");
}

// per a la vista necessitem saber si s'ha processat el formulari
$token = $_SESSION["token"] ?? "";
unset($_SESSION["token"]);


if (empty($token) || ($_POST["token"] !== $token))
    die('Token invàlid');

try {
    if (validate_string($_POST["title"], 1, 100))
        $data["title"] = clean($_POST["title"]);

} catch (RequiredValidationException $e) {
    $errors[] = "Error en validar el títol";
} catch (TooLongValidationException $e) {
    $errors[] = "Error en validar el títol";
} catch (TooShortValidationException $e) {
    $errors[] = "Error en validar el títol";
}

try {
    if (validate_string($_POST["overview"], 1, 1000))
        $data["overview"] = clean($_POST["overview"]);

} catch (ValidationException $e) {
    $errors[] = "Error en validar la sinopsi";
}


if (!empty($_POST["release_date"]) && (validate_date($_POST["release_date"])))
    $data["release_date"] = $_POST["release_date"];
else
    $errors[] = "Cal indicar una data correcta";


$ratingTemp = filter_input(INPUT_POST, "rating", FILTER_VALIDATE_FLOAT);

if (!empty($ratingTemp) && ($ratingTemp > 0 && $ratingTemp <= 5))
    $data["rating"] = $ratingTemp;
else
    $errors[] = "El rating ha de ser un enter entre 1 i 5";

try {
    if (!empty($_FILES['poster']) && ($_FILES['poster']['error'] == UPLOAD_ERR_OK)) {
        if (!file_exists(Movie::POSTER_PATH))
            mkdir(Movie::POSTER_PATH, 0777, true);

        $tempFilename = $_FILES["poster"]["tmp_name"];
        $currentFilename = $_FILES["poster"]["name"];

        $mimeType = getFileExtension($tempFilename);

        $extension = explode("/", getFileExtension($tempFilename))[1];
        $newFilename = md5((string)rand()) . "." . $extension;
        $newFullFilename = Movie::POSTER_PATH . "/" . $newFilename;
        $fileSize = $_FILES["poster"]["size"];

        if (!in_array($mimeType, $validTypes))
            throw new InvalidTypeFileException("La foto no és jpg");

        if ($extension != 'jpeg')
            throw new InvalidTypeFileException("La foto no és jpg");

        if ($fileSize > MAX_SIZE)
            throw new TooBigFileException("La foto té $fileSize bytes");

        if (!move_uploaded_file($tempFilename, $newFullFilename))
            throw new FileUploadException("No s'ha pogut moure la foto");

        $data["poster"] = $newFilename;

    } else
        throw new NoUploadedFileException("Cal pujar una photo");
} catch (FileUploadException $e) {
    $errors[] = $e->getMessage();
}

if (empty($errors)) {
    $pdo = new PDO("mysql:host=mysql-server;dbname=movieFX;charset=utf8", "dbuser", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');


    $moviesStmt = $pdo->prepare("INSERT INTO movie(title, overview, release_date, rating, poster) 
        VALUES (:title, :overview, :release_date, :rating, :poster)");

    $moviesStmt->execute($data);

    if ($moviesStmt->rowCount() !== 1)
        $errors[] = "No s'ha pogut inserir el registre";
    else {
        $message = "S'ha inserit el registre amb el ID ({$pdo->lastInsertId("movie")})";
        $_SESSION["message"] = $message;
        header("Location: index.php");
        exit();
    }

}
// com que si hi ha hagut èxit redirigirem a la pàgina principal plantegem ací el pitjor escenari.
$_SESSION["data"] = $data;
$_SESSION["errors"] = $errors;
header("Location: movies-create.php");
exit();


//require "views/movies-create.view.php";
