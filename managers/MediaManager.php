<?php

class MediaManager extends AbstractManager
{
    
    /**
     * crée un nouveau Media
     * @param Media
     * @return void
     */

    public function createMedia(Media $media) : void
    {
        $query = $this->db->prepare('INSERT INTO medias ( original_name, file_name, file_type, url, alt )
        VALUES ( :original_name, :file_name, :file_type, :url, :alt)');
        $parameters = [
            'original_name' => $media->getoriginalName() ,
            'file_name' => $media->getfileName(),
            'file_type' => $media->getFileType(),
            'url' => $media->getUrl(),
            'alt' => $media->getAlt()
        ];
        $query->execute($parameters);
    }
    
    /**
     * va chercher tous les Media
     * @param
     * @return un array avec tous les Media
     */
     
    public function getAllMedias() : array
    {
        $query = $this->db->prepare('SELECT id, original_name, url, alt FROM medias');
        $query->execute();
        $allMedias = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $allMedias;
    }
    
    /**
     * va chercher tous les id des Media
     * @param
     * @return un array avec tous les id des Media
     */
    
    public function getAllMediasIds() : array
    {
        $query = $this->db->prepare('SELECT id FROM medias');
        $query->execute();
        $allMediasIds = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $allMediasIds;
    }

    /**
     * va chercher 24 id de Media
     * @param
     * @return un array avec les 24 id de Media
     */

    public function getMediasIdsforGallery() : array
    {
        $query = $this->db->prepare('SELECT id FROM medias LIMIT 24');
        $query->execute();
        $allMediasIds = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $allMediasIds;
    }
    
    /**
     * va chercher un Media d'après son id
     * @param id
     * @return un Media
     */

    public function getMediaById(int $id) : Media
    {
        $query = $this->db->prepare('SELECT original_name, file_name, file_type, url, alt FROM medias WHERE id = :id');
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
        
        $media = new Media($id, $originalName, $fileName, $fileType, $url, $alt);

        return $media;
    }
    
    /**
     * va chercher l'url et l'alt d'un Media d'après son id
     * @param id
     * @return un array avec l'url et l'alt
     */
    
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
    
    /**
     * reçoit un Media et le met à jour dans la base de données
     * @param un Media
     * @return un Media
     */
    
    public function updateMedia(Media $media) : Media
    {
        $query = $this->db->prepare('UPDATE media SET original_name = :original_name, file_name = :file_name,
        file_type = :file_type, url = :url, alt = :alt FROM medias WHERE media.id = :id');
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
    
    /**
     * supprime un Media de la base de données d'après son id
     * @param id
     * @return void
     */

    
    public function deleteMedia(int $id) : void
    {
        $query = $this->db->prepare('DELETE FROM medias WHERE medias.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
    }
}