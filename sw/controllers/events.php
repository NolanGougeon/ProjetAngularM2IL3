<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

require_once("../models/Event.php");

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps

if(isset($_GET) && !empty($_GET)){
    if($_GET['action']=="all"){
        echo json_encode(Event::getAll());
    }
    if($_GET['action']=="loadabort"){
        echo json_encode(Event::getLoadAbort());
    }
    if($_GET['action']=="abort"){
        echo json_encode(Event::updateAbort($_GET['id_event']));
    }
    if($_GET['action']=="start"){
        echo json_encode(Event::updateStart($_GET['id_event']));
    }
    if($_GET['action']=="close"){
        echo json_encode(Event::updateClose($_GET['id_event']));
    }
    if($_GET['action']=="eventdetailselement"){
        echo json_encode(Event::getEventDetailsElement($_GET['id_event']));
    }
}
if(isset($_POST) && !empty($_POST)){
    if($_POST['action']=="add"){
        echo json_encode(Event::add($_POST['name'],$_POST['date'],$_POST['lieu']));
    }
    if($_POST['action']=="editevent"){
        json_encode(Event::updateEditEvent($_POST['id_event'],$_POST['name'],$_POST['date'],$_POST['lieu']));
    }
}
