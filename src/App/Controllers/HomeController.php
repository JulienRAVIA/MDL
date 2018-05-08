<?php

namespace App\Controllers;

/**
 * Controleur de la page d'accueil
 */
class HomeController {
    
    /**
     * On récupère le singleton de base de données
     */
    public function __construct() {
        try {
            $this->db = \App\Database::getInstance();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Page d'accueil avec les ateliers et les types d'avis
     * @return view Page de connexion ou page d'accueil
     */
    public function index() {
        $types = $this->db->getTypesAvis();
        $ateliers = $this->db->getAteliers();
        \App\View\View::make('index.twig', compact('types', 'ateliers'));
    }

    /**
     * Ajout d'un avis à un atelier
     * @return json Résultat de la requête d'ajout d'un atelier
     */
    public function ajoutAvis()
    {
        $req = $this->db->ajoutAvis($_POST['atelier'], $_POST['type']);
        if ($req) {
            echo json_encode(array('code' => 'success', 'message' => 'Avis ajouté', 'alert' => 'success'));
        } else {
            echo json_encode(array('code' => 'error', 'message' => 'Erreur', 'alert' => 'danger'));
        }
    }

    /**
     * Récuperer les résultats pour un atelier
     * @return json Résultats de l'atelier
     */
    public function resultatsAtelier()
    {
         $req = $this->db->resultatsAtelier($_POST['atelier']);
         echo json_encode(array('data' => $req));
    }

    /**
    * Récuperer les résultats pour un atelier
    * @return json Résultats de l'atelier
    */
    public function nombreAvis()
    {    
        $req = $this->db->nbAvisAtelier($_POST['atelier']);
        echo json_encode(array('data' => $req));
    }
}
