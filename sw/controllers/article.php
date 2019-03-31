<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Article.php");
require_once("../models/Vente.php");

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps

if(isset($_POST) && !empty($_POST)) {
    if($_POST["action"]=="UPDATE") {
        echo json_encode(Article::update($_POST));
    }
    if($_POST["action"]=="ADD_VENTE") {
         echo json_encode(Vente::add($_POST));
    }
    if($_POST["action"]=="RETRAIT") {
        echo json_encode(Article::update($_POST));
    }
    if($_POST["action"]=="FILE"){
            echo json_encode(Article::add($_POST['data']));
    }
} elseif (isset($_GET)  && !empty($_GET)) {

}