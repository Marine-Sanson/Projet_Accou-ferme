<?php

class ContactManager extends AbstractManager
{
    
    // permet de créer un nouveau produit
    public function createContact(Contact $contact) : void
    {
        $query = $this->db->prepare('INSERT INTO contacts (name, first_name, email, tel, message) VALUES (:name, :first_name, :email, :tel, :message)');
        $parameters = [
            'name' => $contact->getName(),
            'first_name' => $contact->getFirstName(),
            'email' => $contact->getEmail(),
            'tel' => $contact->getTel(),
            'message' => $contact->getMessage(),
        ];
        $query->execute($parameters);
    }
    
    public function getAllMessages() :array
    {
        $query = $this->db->prepare('SELECT id, name, first_name, email, tel, message FROM contacts ORDER BY id DESC');
        $query->execute();
        $allMessages = $query->fetchAll(PDO::FETCH_ASSOC);

        return $allMessages;
    }

}

?>