<?php

declare(strict_types=1);

require_once 'config.php';

spl_autoload_register();

//Récupération des commandes
while (true) {
    $line = readline("Entrez votre commande : ");
    $line = trim($line);
    $recognized = false;

    // Liste des contacts
    if ($line === "list") {
        $command = new Command();
        $command->list();
        $recognized = true;
    }  

    // Détail d'un contact
    if (str_starts_with($line, "detail ")) {
        $parts = explode(" ", $line);
        if (isset($parts[1]) && is_numeric($parts[1])) {
            $id = (int)$parts[1];
            $command = new Command();
            $command->detail($id);
        } else {
            echo "Veuillez préciser un ID valide.\n";
        }
        $recognized = true;
    }

    // Création d'un contact
    if (str_starts_with($line, "create ")) {
        $data = substr($line, 7);
        $parts = array_map('trim', explode(",", $data));
        if (count($parts) === 3) {
            [$name, $email, $phone_number] = $parts;
            $command = new Command();
            $command->create($name, $email, $phone_number);
        } else {
            echo "Erreur : la commande doit être sous la forme 'create nom, email, téléphone'.\n";
        }
        $recognized = true;
    }

    // Suppression d'un contact
    if (str_starts_with($line, "delete ")) {
        $parts = explode(" ", $line);
        if (isset($parts[1]) && is_numeric($parts[1])) {
            $id = (int)$parts[1];
            $command = new Command();
            $command->delete($id);
        } else {
            echo "Veuillez préciser un ID valide.\n";
        }
        $recognized = true;
    }

    // Modification d'un contact
    if (str_starts_with($line, "modify ")) {
        $data = trim(substr($line, strlen("modify ")));
        $parts = array_map('trim', explode(",", $data));
        if (count($parts) === 4) {
            [$id, $name, $email, $phone_number] = $parts;
            $command = new Command();
            $command->modify(intval($id), $name, $email, $phone_number);
        } else {
            echo "Erreur : la commande doit être sous la forme 'modify id, nom, email, téléphone'.\n";
        }
        $recognized = true;
    }

    // Aide
    if ($line === "help") {
        $command = new Command();
        $command->help();
        $recognized = true;
    }

    // Exit
    if ($line === "exit") {
        echo "Fermeture du programme.\n";
        $recognized = true;
        break;
    }

    // Commande non reconnue
    if (!$recognized) {
        echo "Commande non reconnue. Tapez 'help' pour la liste des commandes.\n";
    }

}
