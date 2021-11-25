<?php
class UploadedFileHandler {
    private array $uploadedFile;

    public function __construct() {


    }
    
    public function handle() {
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
    }
}
