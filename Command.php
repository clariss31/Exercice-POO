<?php

// Classe de gestion des commandes

declare(strict_types=1);

spl_autoload_register();

class Command {
    public function list(): void
    {
        echo "Affichage de la liste :\n";
        $contacts = (new ContactManager())->findAll();
        if (empty($contacts)) {
            echo "La liste des contacts est vide.\n";
        } else {
            foreach ($contacts as $contact) {
                echo $contact;
            }
        }
    }

    // Détail d'un contact par son ID
    public function detail(int $id): void
    {
        $contact = (new ContactManager())->findById($id);
        if ($contact) {
            echo "Affichage du détail :\n";
            echo $contact;
        } else {
            echo "Contact introuvable.\n";
        }
    }

    // Création d'un contact
    public function create(string $name, string $email, string $phone_number): void
    {
        $contactManager = new ContactManager();
        $contact = $contactManager->create($name, $email, $phone_number);
        if ($contact) {
            echo "Contact créé avec succès.\n";
        } else {
            echo "Erreur lors de la création du contact.\n";
        }
    }

    // Suppression d'un contact par son ID
    public function delete(int $id): void
    {
        $contactManager = new ContactManager();
        if ($contactManager->delete($id)) {
            echo "Contact supprimé avec succès.\n";
        } else {
            echo "Aucune suppression effectuée (ID introuvable).\n";
        }
    }

    // Modification d'un contact par son ID
    public function modify(int $id, string $name, string $email, string $phoneNumber): void
    {
        $bdd = (new DBConnect())->getPDO();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $updateContact = $bdd->prepare(
            'UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id'
        );
        $updateContact->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone_number' => $phoneNumber,
        ]);
        if ($updateContact->rowCount() > 0) {
            echo "Contact modifié avec succès.\n";
        } else {
            echo "Aucune modification effectuée (vérifiez l'ID ou les données).\n";
        }
    }

    // Aide - liste des commandes disponibles
    public function help(): void
    {
        echo "Voici les commandes disponibles :\n";
        echo "list : Affiche la liste des contacts.\n";
        echo "detail <id> : Affiche le détail d'un contact par son ID.\n";
        echo "create : Créer un contact.\n";
        echo "delete : Supprimer un contact\n";
        echo "modify : Modifier un contact\n";
    }
}