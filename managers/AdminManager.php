<?php

class AdminManager extends DBConnect
{
    
    public function createAdmin(Admin $admin) : Admin
    {
        $query = $this->db->prepare('INSERT INTO admin ( name, email, password, role ) VALUES ( :name, :email, :password, :role )');
        $parameters = [
            'name' => $admin->getName(),
            'email' => $admin->getEmail(),
            'password' => $admin->getPassword(),
            'role' => "user"
            // if error try "'user'"
        ];
        $query->execute($parameters);
        
        $user = [];

        return $user;
    }
    
    public function connectAdmin($name) :array
    {
        $query = $this->db->prepare('SELECT name, password FROM admin WHERE name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $connectedAdmin = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $connectedAdmin;
        
    }
    
    public function getAdminByName(string $name) : User
    {
        $query = $this->db->prepare('SELECT id, email, password, tel FROM admin WHERE admin.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $user = [];
        
        return $user;
    }
    
    public function updateAdmin(User $user) : User
    {
        
        $query = $this->db->prepare('UPDATE admin SET email = :email, password = :password FROM admin WHERE admin.name = :name');
        $parameters = [
            'email' => $email,
            'password' => $password,
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $user = [];
        
        return $user;
        
    }
    
    public function deleteAdmin(Admin $admin) : void
    {
        
        $query = $this->db->prepare('DELETE id, name, email, password, role FROM admin WHERE admin.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>