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
            'message' => $contact->getMessage()
            ];
        $query->execute($parameters);
    }
    
    public function getAllPendingMessages() :array
    {
        $query = $this->db->prepare('SELECT id, name, first_name, email, tel, message, date FROM contacts WHERE answered = :answered ORDER BY id');
        $parameters = [
            'answered' => '0'
            ];
        $query->execute($parameters);
        $allMessages = $query->fetchAll(PDO::FETCH_ASSOC);

        return $allMessages;
    }
    
    public function answeredMessage($id)
    {
        $query = $this->db->prepare('UPDATE contacts SET answered = :answered WHERE id = :id');
        $parameters = [
            'id' => $id,
            'answered' => '1'
        ];
        $query->execute($parameters);
    }
    
}

?>