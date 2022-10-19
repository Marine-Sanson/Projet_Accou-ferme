<?php

class ContactManager extends AbstractManager
{
    
    /**
     * reçoit un Contact et le crée dans la base de données
     * @param Contact
     * @return
     */

    public function createContact(Contact $contact) : void
    {
        $query = $this->db->prepare('INSERT INTO contacts (name, first_name, email, tel, message)
        VALUES (:name, :first_name, :email, :tel, :message)');
        $parameters = [
            'name' => $contact->getName(),
            'first_name' => $contact->getFirstName(),
            'email' => $contact->getEmail(),
            'tel' => $contact->getTel(),
            'message' => $contact->getMessage()
            ];
        $query->execute($parameters);
    }
    
    /**
     * va chercher tous les messages non répondus
     * @param 
     * @return un array avec tous les messages concernés
     */
    
    public function getAllPendingMessages() : array
    {
        $query = $this->db->prepare('SELECT id, name, first_name, email, tel, message, date FROM contacts
        WHERE answered = :answered ORDER BY date DESC');
        $parameters = [
            'answered' => '0'
            ];
        $query->execute($parameters);
        $allMessages = $query->fetchAll(PDO::FETCH_ASSOC);

        return $allMessages;
    }
    
    /**
     * met à jour le booléen d'un message d'après son id
     * @param $id
     * @return void
     */
    
    public function answeredMessage($id) : void
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