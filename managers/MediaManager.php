<?php

class MediaManager
{
    public function createMedia(Media $media) : Media
    {
        $query = $this->db->prepare('INSERT INTO medias ( original_name, file_name, file_type, url, alt' ) VALUES ( ':original_name, :file_name, :file_type, :url, :alt');
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
    
    public function getMediaById(Media $id : Media
    {
        $query = $this->db->prepare('SELECT original_name, file_name, file_type, url, alt FROM medias WHERE media.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $media = [];

        return $media;
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