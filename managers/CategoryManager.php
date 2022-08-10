<?php

class CategoryManager
{
    
    public function createCategory(Category $category) : Category
    {
        $query = $this->db->prepare('INSERT INTO categories ( name ) VALUES ( :name )');
        $parameters = [
            'name' => $name->getName(),
        ];
        $query->execute($parameters);
        
        $produce = [];

        return $category;
    }
    
    public function getCategoryId(string $name) : int
    {
        $query = $this->db->prepare('SELECT id FROM categories WHERE categorie.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $category = [];

        return $category['id'];
    }
    
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