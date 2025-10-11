<?php

declare(strict_types=1);

require_once 'config.php';
require_once 'Contact.php';

spl_autoload_register();

// Classe de récupération des contacts
class ContactManager {
    function findAll() {
        $db = (new DBConnect())->getPDO();
        $req = $db->query('SELECT * FROM contact');
        $preparation = $req->fetchAll(PDO::FETCH_ASSOC);
        $contacts = [];
        foreach ($preparation as $contact) {
            $contacts[] = new Contact(
                $contact['id'],
                $contact['name'],
                $contact['email'],
                $contact['phone_number']
            );
        }
        return $contacts;
    }

    // Recherche un contact par son ID
    function findById (int $id) : ?Contact {
        $db = (new DBConnect())->getPDO();
        $req = $db->prepare('SELECT * FROM contact WHERE id = ?');
        $req->execute([$id]);
        $contact = $req->fetch(PDO::FETCH_ASSOC);
        if ($contact) {
            return new Contact(
                $contact['id'],
                $contact['name'],
                $contact['email'],
                $contact['phone_number']
            );
        }
        return null;
    }

    // Création d'un contact
    public function create(string $name, string $email, string $phone_number): Contact {
        $db = (new DBConnect())->getPDO();
        $stmt = $db->prepare('INSERT INTO contact (name, email, phone_number) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $phone_number]);
        $id = (int)$db->lastInsertId();
        return new Contact($id, $name, $email, $phone_number);
    }

    // Suppression d'un contact par son ID
    function delete (int $id) : bool {
        $db = (new DBConnect())->getPDO();
        $req = $db->prepare('DELETE FROM contact WHERE id = ?');
        $req->execute([$id]);
        if ($req->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}