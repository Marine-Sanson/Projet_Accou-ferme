<?php

class UserManager
{
    
    public function createUser(User $user) : User
    {
        $query = $this->db->prepare('INSERT INTO users ( name, email, password ,tel, role ) VALUES ( :name, :email, :password, :tel, :role )');
        $parameters = [
            'name' => $name->getName(),
            'email' => $email->getEmail(),
            'password' => $password->getPassword(),
            'tel' => $tel->getTel(),
            'role' => "user"
            // if error try "'user'"
        ];
        $query->execute($parameters);

        return $user;
    }
    
    public function connectUser() : array
    {
        
        $query = $this->db->prepare('SELECT name, email, password, tel FROM users WHERE user.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $user = [];
        
        return $user;
        
    }
    
    public function updateUser(User $user) : User
    {
        
        $query = $this->db->prepare('UPDATE user SET email = :email, password = :password, tel = :tel FROM users WHERE user.name = :name');
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
    
    public function deleteUser(User $user) : User
    {
        
        $query = $this->db->prepare('DELETE id, name, email, password, tel, role FROM users');
        $parameters = [
            
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $user = [];
        
        return $user;
        
    }
    
}

?>