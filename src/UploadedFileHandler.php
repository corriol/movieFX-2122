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



       if (empty($acceptedTypes) || in_array($this->uploadedFile["type"], $acceptedTypes))
            $this->acceptedTypes = $acceptedTypes;
       else
           throw new InvalidTypeFileException("El tipus del fitxer no és correcte");

        if ($maxSize != 0 && $this->uploadedFile["size"] > $maxSize)
           throw new TooBigFileException("El fitxer ({$this->uploadedFile["size"]}) és major que $maxSize");

       $this->maxSize = $maxSize;
    }

    /**
     * @throws FileUploadException
     * @throws InvalidTypeFileException
     */
    public function handle(string $path): string
    {
        //doble-check




        $mimeType = $this->getFileExtension($this->uploadedFile["tmp_name"]);

        if (!empty($this->acceptedTypes) && !in_array($mimeType, $this->acceptedTypes))
            throw new InvalidTypeFileException("El tipus del fitxer no és correcte 2");

        $extension = explode("/", $mimeType)[1];

        $newFilename = md5((string)rand()) . "." . $extension;
        $newFullFilename = $path . "/" . $newFilename;

        if (!move_uploaded_file($this->uploadedFile["tmp_name"], $newFullFilename))
            throw new FileUploadException("No s'ha pogut moure la foto");

        return $newFilename;
    }

    private function getFileExtension(string $filename): string
    {
        $mime = "";
        try {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $filename);
            if ($mime === false)
                throw new Exception();
        } // return mime-type extension
        finally {
            finfo_close($finfo);
        }
        return $mime;
    }

}
