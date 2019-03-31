<?php
#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Parametre.php");

if(isset($_GET) && !empty($_GET)){
    echo json_encode(Parametre::getParameters($_GET);
}

if(isset($_POST) && !empty($_POST)){
    if($_POST['action']=="UPDATE"){
        echo json_encode(Parametre::updateParameter(copyArray($data , "action")));
    } elseif ($_POST['action']=="ALL"){
        echo json_encode(Parametre::getParameters($_POST);
    } elseif ($_POST['action']=="CHECK_VENTE_DAY"){
        echo json_encode(Parametre::activeVente($_POST));
    }
}

// copy un tableau a l'exeception d'un champ $exeception;
function copyArray($tableau, $exceptItem){
    $toExecute = [];
    if(is_array($tableau)){
        foreach ($tableau as $item =>$value){

            if($item !=$exceptItem) {
                $toExecute[$item] =$value;
            }
        }
    }
    return $toExecute;
}

