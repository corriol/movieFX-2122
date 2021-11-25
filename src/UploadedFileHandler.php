<?php
class UploadedFileHandler {
    private array $uploadedFile;
    private int $maxSize;
    private array $acceptedTypes;
    private string $type;

    public function __construct(string $inputName, array $acceptedTypes = [], int $maxSize = 0) {
       if (empty($_FILES[$inputName]))
           throw new Exception("La clau no existeix");

       $this->uploadedFile = $_FILES[$inputName];
       if ($this->uploadedFile["error"] !== UPLOAD_ERR_OK )
           throw new Exception("Error en la pujada");


       if (empty($acceptedTypes) || in_array($this->uploadedFile, $acceptedTypes))
            $this->acceptedTypes = $acceptedTypes;
       else
           throw new InvalidTypeFileException("El tipus del fitxer no és correcte");

        if ($this->uploadedFile["size"] > $maxSize)
           throw new TooBigFileException("El fitxer ({$this->uploadedFile["size"]}) és major que $maxSize");

       $this->maxSize = $maxSize;
    }
    
    public function handle() {
        $tempFilename = $_FILES["poster"]["tmp_name"];
        $currentFilename = $_FILES["poster"]["name"];

        $mimeType = getFileExtension($tempFilename);

        $extension = explode("/", getFileExtension($tempFilename))[1];
        $newFilename = md5((string)rand()) . "." . $extension;
        $newFullFilename = Movie::POSTER_PATH . "/" . $newFilename;

        if (!move_uploaded_file($tempFilename, $newFullFilename))
            throw new FileUploadException("No s'ha pogut moure la foto");

        $data["poster"] = $newFilename;

}
