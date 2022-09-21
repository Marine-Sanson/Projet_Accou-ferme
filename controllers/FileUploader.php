<?php

/**
 * File Uploader class used for media upload
 * @author Mari Doucet
 * @author Marine Sanson
*/

class FileUploader
{
    private string $uploadFile = "/uploads/";
    private array $allowedFileTypes = ["png", "PNG", "jpg", "JPG", "jpeg", "JPEG"];
    private array $mimeTypes = ['png' => 'image/png', 'PNG' => 'image/png', 'jpeg' => 'image/jpeg', 'JPG' => 'image/jpeg', 'jpg' => 'image/jpeg', 'JPEG' => 'image/jpeg'];
    private int $maxFileSize = 2000000; // 2 Mo

    private function generateFileName() : string
    {
        $randomString = bin2hex(random_bytes(10)); // random string, 20 characters a-z 0-9
        
        return $randomString;
    }
    
    private function checkFileSize(int $fileSize) :bool
    {

        $maxFileSize = $this->maxFileSize;
        // vérifier que le fichier n'est pas trop gros
        if($fileSize > $maxFileSize)
        {
            echo "fichier trop gros";
            return false; 
        }
        else
        {
            return true;
        }
    }
    
    private function checkFileType(string $fileType) :bool
    {
        // vérifier que le type est bien l'un des types autorisés
        $allowedFileTypes = $this->allowedFileTypes;
        foreach($allowedFileTypes as $key => $allowedFileType)
        {
            if($fileType === $allowedFileType)
            {
                return true;
                break;
            }
            else
            {
                return false;
            }
        }
    }
    
    private function checkMime(string $fileType, array $mimeTypes)
    {
        if($mimeTypes[$fileType] !== $_FILES['fileToUpload']["type"])
        {
            $errors[] = "Le fichier n'a pas été enregistré correctement !";
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function upload(array $file) : Media
    {
        $explode = explode("/", $_FILES['fileToUpload']['type']);
        $fileType = $explode[1];
        $mimeTypes = $this->mimeTypes;

        // appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
        $fileTypeCheked = $this->checkFileType($fileType);
        
        // appeler$this->checkMime($fileType, $mimeTypes) pour vérifier le mime du fichier
        $mime = $this->checkMime($fileType, $mimeTypes);
        
        // appeler $this->checkFileSize(int $fileSize) pour vérifier le type du fichier
        $fileSizeCheked = $this->checkFileSize($_FILES['fileToUpload']['size']);
        
        if(!$fileTypeCheked || !$fileSizeCheked || !$mime)
        {
            echo "erreur";
        }
        else
        {
            $originalName = $file["name"];
            $fileName = $this->generateFileName();
            $fileType = pathinfo($originalName)["extension"];
            $url = getcwd() . $this->uploadFile . $fileName . ".". $fileType;
            $alt = $_FILES['fileToUpload']['alt'];
            
            move_uploaded_file($file["tmp_name"], $url);
            
            return new Media(null, $originalName, $fileName, $fileType, $url, $alt);
        }
    }
} 