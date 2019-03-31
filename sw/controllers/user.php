<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/User.php");

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps

if(isset($_POST) && !empty($_POST)){
    // Ajouter un utilisateur // Vendeur en occurence
    if($_POST['action']=="ADD"){
        $data = copyArray($_POST, "action");
        echo json_encode(User::addUser($data,$_SERVER['HTTP_REFERER']));
    }
     if($_POST['action']=="VERIFY"){
         $data = copyArray($_POST, "action");
         echo json_encode(User::activeAccount($data));
    }
    if($_POST['action']=="UPDATE"){
        $data = copyArray($_POST, "action");
        echo json_encode(User::updateUser($data));
    }
} elseif (isset($_GET)  && !empty($_GET)){

    if($_GET['action']=="DELETE"){
        echo json_encode(User::deleteUser($_GET));
    }else {
        echo json_encode(User::getAllUsers($_GET));
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