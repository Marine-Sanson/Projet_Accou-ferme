<?php

class UserManager extends DBConnect
{
    
    public function createUser(User $user) : User
    {
        $query = $this->db->prepare('INSERT INTO admin ( name, email, password ,tel, role ) VALUES ( :name, :email, :password, :tel, :role )');
        $parameters = [
            'name' => $name->getName(),
            'email' => $email->getEmail(),
            'password' => $password->getPassword(),
            'tel' => $tel->getTel(),
            'role' => "user"
            // if error try "'user'"
        ];
        $query->execute($parameters);
        
        $user = [];

        return $user;
    }
    
    public function connectUser($name) :array
    {
        $query = $this->db->prepare('SELECT name, password, role FROM admin WHERE name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $connectedAdmin = $query->fetch(PDO::FETCH_ASSOC);
        
        return $connectedAdmin;
        
    }
    
    public function getUserByName(string $name) : User
    {
        $query = $this->db->prepare('SELECT id, email, password, tel FROM admin WHERE user.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $user = [];
        
        return $user;
    }
    
    public function updateUser(User $user) : User
    {
        
        $query = $this->db->prepare('UPDATE admin SET email = :email, password = :password, tel = :tel FROM admin WHERE admin.name = :name');
        $parameters = [
            'email' => $email,
            'password' => $password,
            'tel' => $tel
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $user = [];
        
        return $user;
        
    }
    
    public function deleteUser(User $user) : void
    {
        
        $query = $this->db->prepare('DELETE id, name, email, password, tel, role FROM admins WHERE admin.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>