<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps
include '../dbconnexion.php';
if(isset($_GET) && !empty($_GET)){

    if($_GET['action']=="all"){

        $response = [];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql="SELECT * FROM event WHERE event_statut='created' or event_statut='start' ORDER BY date ASC";
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $result->rowCount();


            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "id_event"=>$item['id_event'],
                    "name_event"=>$item['name_event'],
                    "date"=>$item['date'],
                    "lieu"=>$item['lieu'],
                    "event_statut"=>$item['event_statut'],
                    "current_date"=>date("Y-m-d"),


                    ] ;
                }
            
            }
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
    if($_GET['action']=="loadabort"){

        $response = [];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql="SELECT * FROM event WHERE event_statut='abort' ORDER BY date ASC";
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $result->rowCount();

                
            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "id_event"=>$item['id_event'],
                    "name_event"=>$item['name_event'],
                    "date"=>$item['date'],
                    "lieu"=>$item['lieu'],

                    ] ;
                }
            
            }
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
    if($_GET['action']=="abort"){

        $response = [];
        $id_event=$_GET['id_event'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql = "UPDATE event SET event_statut='abort'
            WHERE id_event='$id_event'";
            $sql1 = "UPDATE liste SET liste.statut='en cours',liste.id_event='NULL'
            WHERE liste.id_event='$id_event'";
            // use exec() because no results are returned
            //print_r($sql);
            $bdconnect->exec($sql);
            $bdconnect->exec($sql1);
            $response = [
                        "message"=> "annulation event réussie ",
                        "valide"=>true
                  ];


        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }

    if($_GET['action']=="start"){

        $response = [];
        $id_event=$_GET['id_event'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql = "UPDATE event SET event_statut='start'
            WHERE id_event='$id_event'";
            $sql1 = "UPDATE liste SET liste.statut='en vente'
            WHERE liste.id_event='$id_event'";
            // use exec() because no results are returned
            //print_r($sql);
            $bdconnect->exec($sql);
            $bdconnect->exec($sql1);
            $response = [
                        "message"=> "demarrage event réussie ",
                        "valide"=>true
                  ];


        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
    if($_GET['action']=="close"){

        $response = [];
        $id_event=$_GET['id_event'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql = "UPDATE event SET event_statut='close'
            WHERE id_event='$id_event'";
            // $sql1 = "UPDATE article SET article.statut='INVENDU'
            // WHERE article.statut='RETIRE'";
            // $sql1="UPDATE article SET article.statut='INVENDU' WHERE article.statut='RETIRE'
            // OR article.codeA=(SELECT DISTINCT codeA FROM event,liste WHERE liste.id_event='$id_event' and article.numListe=liste.numListe)";
            $sql1="UPDATE article SET article.statut='INVENDU' WHERE article.codeA=(SELECT DISTINCT codeA FROM event,liste WHERE liste.id_event='$id_event' AND article.numListe=liste.numListe AND (article.statut<>'VENDU' AND article.statut<>'RETIRE') )";
            $sql2="UPDATE liste SET statut='vendue'
            WHERE liste.id_event='$id_event'";
            // use exec() because no results are returned
            //print_r($sql);
            $bdconnect->exec($sql);
            $bdconnect->exec($sql1);
            $bdconnect->exec($sql2);
            $response = [
                        "message"=> "fermetture event réussie ",
                        "valide"=>true
                  ];


        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }

    if($_GET['action']=="eventdetailselement"){

        $response = [];
        $id_event=$_GET['id_event'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql="SELECT * FROM event WHERE event.id_event='$id_event'";
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $result->rowCount();

                
            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "name_event"=>$item['name_event'],
                    "date"=>$item['date'],
                    "lieu"=>$item['lieu'],
                    ] ;
                }
            
            }
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
}
if(isset($_POST) && !empty($_POST)){

    if($_POST['action']=="add"){

        $response = [];
        $name=$_POST['name'];
        $date=$_POST['date'];
        $lieu=$_POST['lieu'];
        //print_r($_POST);
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql = "INSERT INTO event (name_event,date,lieu,date_creation,event_statut)
            VALUES ('$name', '$date', '$lieu',NOW(),'created')";
            // use exec() because no results are returned
            $bdconnect->exec($sql);
            $response = [
                        "message"=> "Ajout event réussi",
                        "valide"=>true
                  ];


        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);


    }
    
    if($_POST['action']=="editevent"){

        $response = [];
        $id_event=$_POST['id_event'];
        $name=$_POST['name'];
        $date=$_POST['date'];
        $lieu=$_POST['lieu'];

    //print_r($_POST);
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql = "UPDATE event SET name_event='$name',date='$date',lieu='$lieu'
            WHERE id_event='$id_event'";
            // use exec() because no results are returned
            //print_r($sql);
            $bdconnect->exec($sql);
            $response = [
                        "message"=> "Modification réussie ",
                        "valide"=>true
                  ];


        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);


    }
}
