<?php

namespace App\Controller;

use App\Exceptions\FileUploadException;
use App\Exceptions\NoUploadedFileException;
use App\FlashMessage;
use App\Movie;
use App\MovieRepository;
use App\Registry;
use App\UploadedFileHandler;

class MovieController
{
    const MAX_SIZE = 1024 * 1000;
    private MovieRepository $movieRepository;

    public function __construct()
    {
        $this->movieRepository = new MovieRepository();
    }

    public function list()
    {
        $message = FlashMessage::get("message");

        $movies = $this->movieRepository->findAll();

        $logger = Registry::get(Registry::LOGGER);
        $logger->info("s'ha executat una consulta");

        require __DIR__ . "/../../views/index.view.php";
    }

    public function edit(int $id)
    {
        //die("editant la pel·licula $id");

        // $id = $_POST["id"]?? $_GET["id"] ?? null;

        //if (empty($id))
        //    throw new Exception("Id Invalid");
        //else
        //    $id = (int)$id;


        $movie = $this->movieRepository->find($id);
        $data = $movie->toArray();

        //var_dump($data);
        if (empty($data))
            throw new \Exception("La pel·lícula seleccionada no existeix");


        $validTypes = ["image/jpeg", "image/jpg"];

        $errors = [];

        // per a la vista necessitem saber si s'ha processat el formulari
        if (isPost()) {
            $data["title"] = clean($_POST["title"]);
            $data["overview"] = clean($_POST["overview"]);
            $data["release_date"] = $_POST["release_date"];
            try {
                $uploadedFileHandler = new UploadedFileHandler("poster", ["image/jpeg"], self::MAX_SIZE);
                $data["poster"] = $uploadedFileHandler->handle("posters");

            } catch (NoUploadedFileException $e) {
                // no faig res perquè és una opció vàlida en UPDATE.
            } catch (FileUploadException $e) {
                $errors[] = $e->getMessage();
            }

            if (empty($errors)) {
                try {
                    $movie = Movie::fromArray($data);
                    $this->movieRepository->save($movie);
                    $message = "S'ha actualitzat el registre amb l'ID ({$movie->getId()})";
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }

            }
        }
        require __DIR__ ."/../../views/movies-edit.view.php";
    }
}