<?php
	require_once("ConnectionToBD.php");
    class Paiement{

        private $id;
        private $user_trigramme;
        private $num_liste;
        private $date_paiement;
        private $type_paiement;
        private $montant;

        function __construct($id,$user_trigramme,$num_liste,$date_paiement,$type_paiement,$montant){
            $this->id = $id;
            $this->user_trigramme = $user_trigramme;
            $this->num_liste = $num_liste;
            $this->date_paiement = $date_paiement;
            $this->type_paiement = $type_paiement;
            $this->montant = $montant;
        }
	}
?>
