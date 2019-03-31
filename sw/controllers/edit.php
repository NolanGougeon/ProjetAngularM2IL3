<?php

#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Texte.php");

if(isset($_GET)&& !empty($_GET)){
    if($_GET['action']=="show"){
        echo json_encode(Texte::getAll());
    }  
}
if(isset($_POST) && !empty($_POST)){
    if($_POST['action']=="change"){
        echo json_encode(Texte::update($_GET['texte'])); /* pour information : $_GET employé au lieu de $_POST ? */
        //echo json_encode(Texte::update($_POST['texte']));
    }
}

