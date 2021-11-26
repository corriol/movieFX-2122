<?php declare(strict_types=1); ?>

<?php

// Inicialitze les variables perquè existisquen en tots els possibles camins
// Sols emmagatzameré en elles valors vàlids.
// Acumularé els errors en un array per a mostrar-los al final.
// Use la sintaxi alternativa de les estructures de control per a la part de vistes.
// Cree funció clean per a netejar valors

require "helpers.php";
require 'src/Exceptions/FileUploadException.php';
require_once 'src/Exceptions/NoUploadedFileException.php';
require_once 'src/Movie.php';
require_once 'src/UploadedFileHandler.php';
require_once 'src/Registry.php';
require_once 'bootstrap.php';

const MAX_SIZE = 1024*1000;

// En el cas de l'edició els valors inicials haurien de ser els de l'objecte a actualitzar, així
// que caldria inicialitzar l'array $data  tant en l'opció de post com en la get

if (isPost())
    $idTemp = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
else
    $idTemp = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!empty($idTemp))
    $id = $idTemp;
else
    throw new Exception("Id Invalid");

$pdo = new PDO("mysql:host=mysql-server;dbname=movieFX;charset=utf8", "dbuser", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$moviesStmt = $pdo->prepare("SELECT * FROM movie WHERE id=:id");
$moviesStmt->bindValue("id", $id);
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();

$data = $moviesStmt->fetch();
if (empty($data))
    throw new Exception("La pel·lícula seleccionada no existeix");


$validTypes = ["image/jpeg", "image/jpg"];

$errors = [];

// per a la vista necessitem saber si s'ha processat el formulari
if (isPost()) {

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

    /*
    $ratingTemp = filter_input(INPUT_POST, "rating", FILTER_VALIDATE_FLOAT);

    if (!empty($ratingTemp) && ($ratingTemp > 0 && $ratingTemp <= 5))
        $data["rating"] = $ratingTemp;
    else
        $errors[] = "El rating ha de ser un enter entre 1 i 5";*/

    try {

        $uploadedFileHandler = new UploadedFileHandler("poster", ["image/jpeg"], MAX_SIZE);
        $data["poster"] = $uploadedFileHandler->handle("posters");

    }
    catch (NoUploadedFileException $e) {
        // no faig res perquè és una opció vàlida en UPDATE.
    }
    catch (FileUploadException $e) {
        $errors[] = $e->getMessage();
    }
}

if (isPost() && empty($errors)) {
    $pdo = Registry::get("PDO");

    $moviesStmt = $pdo->prepare("UPDATE movie 
                            set title = :title, 
                                overview = :overview, 
                                release_date =:release_date, 
                                rating = :rating, 
                                poster=:poster
                                WHERE id = :id");

    $moviesStmt->execute($data);

    if ($moviesStmt->rowCount() !== 1)
        $errors[] = "No s'ha pogut actualitzar el registre";
    else
        $message = "S'ha actualitzat el registre amb l'ID ({$data["id"]})";
}

require "views/movies-edit.view.php";
