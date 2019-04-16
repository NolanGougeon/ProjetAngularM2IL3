<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Paiement.php");

if(isset($_GET) && !empty($_GET)){
    if($_GET['action']=="add"){
        $paiement = new Paiement(null, $_POST['trigramme'], $_POST['num_liste'], date('d/m/Y H:i:s'), $_POST['type_paiement'], $_POST['montant']);
        json_encode($paiement->add());
    }
}
