<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Articles.php");
require_once("../models/Commentaire.php");

if(isset($_GET) && !empty($_GET)){
    if($_GET['action']=="latest"){
        echo json_encode(Articles::getLatest());
    }
    if($_GET['action']=="all"){
        echo json_encode(Articles::getAll());
    }
    if($_GET['action']=="mostpopular"){
        echo json_encode(Articles::getMostPopular());
    }
    if($_GET['action']=="selected"){
        echo json_encode(Articles::getSelected($_GET['id']));
    }
    if($_GET['action']=="selectedComment"){
        echo json_encode(Articles::getSelectedComment($_GET['id']));
    }
}
if(isset($_POST) && !empty($_POST)){
   if($_POST['action']=="addcomment"){
        echo json_encode(Commentaire::add($_POST['id_art'],$_POST['name'],$_POST['texte']));
   }
}
