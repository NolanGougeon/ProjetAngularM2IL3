<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Paiement.php");

if(isset($_POST) && !empty($_POST)){
    if($_POST['action']=="add"){
        $paiement = new Paiement(null, $_POST['trigramme'], $_POST['num_liste'], date('Y-m-d'), $_POST['type_paiement'], $_POST['montant']);
        $result = $paiement->add();
        return $result;
    }
}
