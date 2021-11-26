<?php
declare(strict_types=1);

require_once 'src/Exceptions/FileUploadException.php';
require_once 'src/Exceptions/InvalidTypeFileException.php';

class UploadedFileHandler
{
    private array $uploadedFile;
    public function __construct(string $inputName, array $acceptedTypes, int $maxSize)
    {
        if ($_FILES[$inputName]["error"]===UPLOAD_ERR_NO_FILE)
            throw new NoUploadedFileException("No s'ha pujat cap fitxer o ha hagut un error");

        if (empty($_FILES[$inputName]) || ($_FILES[$inputName]['error'] != UPLOAD_ERR_OK)) {
            throw new FileUploadException("No s'ha pujat cap fitxer o ha hagut un error");
        }
        $this->uploadedFile = $_FILES[$inputName];

        if (!in_array($_FILES[$inputName]["type"], $acceptedTypes))
            throw new InvalidTypeFileException("El fitxer no és del tipus requerit");

        if ($_FILES[$inputName]["size"] > $maxSize)
            throw new TooBigFileException("El fitxer supera el límit de grandària ($maxSize bytes).");
    }

    function handle(string $directory): string
    {
        $tempFilename = $this->uploadedFile["tmp_name"];

        // generem el nom definitiu
        // type => "images/jpeg"
        // explode => ["images", "jpeg"]
        $extension = explode("/", $this->uploadedFile["type"])[1];
        $newFilename = md5((string)rand()) . "." . $extension;

        $newFullFilename = $directory . "/" . $newFilename;

        if (!move_uploaded_file($tempFilename, $newFullFilename))
            throw new FileUploadException("No s'ha pogut moure el fitxer");

        return  $newFilename;
    }
}