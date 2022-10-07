<?php

class CategoryManager extends AbstractManager
{
    /**
     * reçoit une Category et l'insere dans la base de données
     * @param Category
     * @return void
     */

    public function createCategory(Category $category) : void
    {
        $query = $this->db->prepare('INSERT INTO categories ( name ) VALUES ( :name )');
        $parameters = [
            'name' => $category->getName(),
        ];
        $query->execute($parameters);
    }
    
    /**
     * va chercher toutes les Category
     * @param 
     * @return un array avec toutes les Category
     */
    
    public function getAllCategories() :array
    {
        $query = $this->db->prepare('SELECT id, name FROM categories');
        $query->execute();
        $category = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $category;
    }
    
    /**
     * va chercher l'id de la Category d'après son nom
     * @param $name
     * @return id
     */
    
    public function getCategoryId(string $name) : int
    {
        $query = $this->db->prepare('SELECT id FROM categories WHERE name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $categoryId = $query->fetch(PDO::FETCH_ASSOC);
        
        return $categoryId["id"];
    }
    
    /**
     * va chercher le nom de la Category d'après son id
     * @param id
     * @return $name
     */
    
    public function getCategoryNameById(string $id) : string
    {
        $query = $this->db->prepare('SELECT name FROM categories WHERE id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $categoryName = $query->fetch(PDO::FETCH_ASSOC);
        
        return $categoryName["name"];
    }
    
    /**
     * reçoit une Category et la supprime
     * @param Category
     * @return 
     */

    public function deleteCategory(Category $category) : void
    {
        $query = $this->db->prepare('DELETE id, name FROM categories WHERE categories.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>