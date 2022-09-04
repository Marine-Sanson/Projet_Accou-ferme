<?php

class MediaManager extends DBConnect
{
    public function createMedia(Media $media) : Media
    {
        $query = $this->db->prepare('INSERT INTO medias ( original_name, file_name, file_type, url, alt ) VALUES ( :original_name, :file_name, :file_type, :url, :alt');
        $parameters = [
            'original_name' => $originalName->getoriginalName() ,
            'file_name' => $fileName->getfileName(),
            'file_type' => $fileType->getFileType,
            'url' => $url->getUrl,
            'alt' => $alt->getAlt
        ];
        $query->execute($parameters);
        
        $media = [];

        return $media;
    }
    
    public function getMediaById(int $id) :Media
    {
        $query = $this->db->prepare('SELECT original_name, file_name, file_type, url, alt FROM medias WHERE medias.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $fullMedia = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $originalName = $fullMedia[0]['original_name'];
        $fileName = $fullMedia[0]['file_name'];
        $fileType = $fullMedia[0]['file_type'];
        $url = $fullMedia[0]['url'];
        $alt = $fullMedia[0]['alt'];

        return new Media($id, $originalName, $fileName, $fileType, $url, $alt);
    }
    
    public function getMediaUrlAlt(int $id) :array
    {
        $query = $this->db->prepare('SELECT url, alt FROM medias WHERE medias.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $mediaUrlAlt = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $mediaUrlAlt;
    }
    
    public function updateMedia(Media $media) : Media
    {
        $query = $this->db->prepare('UPDATE media SET original_name = :original_name, file_name = :file_name, file_type = :file_type, url = :url, alt = :alt FROM medias WHERE media.id = :id');
        $parameters = [
            'original_name' => $originalName,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'url' => $url,
            'alt' => $alt
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $media = [];

        return $media;
    }
    
    public function deleteMedia(Media $media) : Media
    {
        $query = $this->db->prepare('DELETE id, original_name, file_name, file_type, url, alt FROM medias WHERE media.original_name = :original_name');
        $parameters = [
            'original_name' => $originalName
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}