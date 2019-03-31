<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Liste.php");
require_once("../models/Event.php");

if(isset($_GET) && !empty($_GET)){
    if($_GET['action']=="all"){
        echo json_encode(Liste::getAll($_GET['tri']));
    }
    if($_GET['action']=="allGain"){
        echo json_encode(Liste::getAllGain($_GET['tri']));
    }
    if($_GET['action']=="loadevents"){
        echo json_encode(Event::getLoadEvents());
    }
    if($_GET['action']=="GET"){
        echo json_encode(Liste::get($_GET['critere'],$_GET['value']));
    }
    if($_GET['action']=="listedetails"){
        echo json_encode(Liste::getListeDetails($_GET['num']));
    }
    if($_GET['action']=="delete"){
        echo json_encode(Liste::delete($_GET['num']));
    }
    if($_GET['action']=="deletedetails"){
        echo json_encode(Liste::deleteDetails($_GET['num']));
    }
    if($_GET['action']=="listedetailselement"){
        echo json_encode(Liste::getListeDetailsElement($_GET['codeA']));
    }
    if($_GET['action']=="majlistestatut"){
        echo json_encode(Liste::updateMajListeStatut($_GET['num'],$_GET['event']));
    }
}

if(isset($_POST) && !empty($_POST)){
    if($_POST['action']=="add"){
        echo json_encode(Liste::add($_POST['trigramme'],$_POST['nom_liste'],$_POST['statut']));
    }
    if($_POST['action']=="adddetail"){
        echo json_encode(Liste::addDetail($_POST['num_liste'],$_POST['description'],$_POST['prix'],$_POST['taille'],$_POST['commentaire'],$_POST['statut']));
    }
    if($_POST['action']=="editdetail"){
        echo json_encode(Liste::updateEditDetail($_POST['codeA'],$_POST['description'],$_POST['prix'],$_POST['taille'],$_POST['commentaire'],$_POST['statut']));
    }
    if($_POST['action']=="UPDATE"){
        if($_POST['type']=="ONLYONE"){
            echo json_encode(Liste::update($_POST['numListe'],$_POST['critere'],$_POST['statut']));
        }
    }
}
