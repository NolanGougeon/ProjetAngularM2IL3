<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');


include '../dbconnexion.php';


//print_r($_POST);
//die();
if(isset($_GET) && !empty($_GET)){


    if($_GET['action']=="all"){

        $response = [];
        $tri=$_GET['tri'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql="SELECT * FROM liste WHERE liste.trigramme='$tri'";
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $result->rowCount();

                
            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "numListe"=>$item['numListe'],
                    "nom_liste"=>$item['nom_liste'],
                    "statut"=>$item['statut'],
                    "date_creation"=>$item['date_creation'],

                    ] ;
                }
            
            }
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
    if($_GET['action']=="allGain"){

        $response = [];
        $tri=$_GET['tri'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql="SELECT liste.numListe, nom_liste, date_creation, SUM(prix) as gain FROM liste, article WHERE liste.trigramme='$tri' and liste.statut='vendue' and liste.numListe=article.numListe and article.statut='VENDU'";
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $result->rowCount();

                
            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "numListe"=>$item['numListe'],
                    "nom_liste"=>$item['nom_liste'],
                    "gain"=>$item['gain'],
                    "date_creation"=>$item['date_creation'],

                    ] ;
                }
            
            }
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
    if($_GET['action']=="loadevents"){

        $response = [];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql="SELECT * FROM event WHERE event_statut='created' ORDER BY date ASC LIMIT 1";
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


    if($_GET['action']=="GET"){

    $response = [];
    $crtiere=$_GET['critere'];
    $value=$_GET['value'];
    $bdconnect = connectionToBD();
    //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC
    try{

        $sql="SELECT * FROM liste,user,event WHERE liste.$crtiere='$value' 
              AND user.trigramme=liste.trigramme AND liste.id_event=event.id_event
            ";
        $result = $bdconnect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $articleexist = $result->rowCount();


        if($articleexist==0){
            // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
        } else
        {
            foreach ($result as $item){
                $response [] = [
                    "numListe"=>$item['numListe'],
                    "nom_liste"=>$item['nom_liste'],
                    "statut"=>$item['statut'],
                    "trigramme"=>$item['trigramme'],
                    "date_creation"=>$item['date_creation'],
                    "nom"=>$item['nom'],
                    "prenom"=>$item['prenom'],
                    "name_event"=>$item['name_event'],
                    "date_event"=>$item['date'],

                ] ;
            }

        }
    }catch(PDOException $ex){
        echo $ex->getMessage();
        die();
    }
    echo json_encode($response);


}

    if($_GET['action']=="listedetails"){

        $response = [];
        $num=$_GET['num'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
        try{
            $sql="SELECT * FROM article WHERE article.numListe='$num'";
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $result->rowCount();

                
            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "codeA"=>$item['codeA'],
                    "prix"=>$item['prix'],
                    "taille"=>$item['taille'],
                    "statut"=>$item['statut'],
                    "commentaire"=>$item['commentaire'],
                    "description"=>$item['description'],
                    "numListe"=>$item['numListe'],
                    "photo"=>$item['photo'],
                    ] ;
                }
            
            }
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }

    if($_GET['action']=="delete"){

        $response = [];
        $num_liste=$_GET['num'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql="DELETE FROM liste WHERE liste.NumListe='$num_liste'";
            $bdconnect->exec($sql);
            $response = [
                        "message"=> "Supression effectuée",
                        "valide"=>true
                  ];
            
            
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
    if($_GET['action']=="deletedetails"){

        $response = [];
        $codeA=$_GET['num'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql="DELETE FROM article WHERE article.codeA='$codeA'";
            $bdconnect->exec($sql);
            $response = [
                        "message"=> "Supression effectuée",
                        "valide"=>true
                  ];
            
            
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }
    if($_GET['action']=="listedetailselement"){

        $response = [];
        $codeA=$_GET['codeA'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql="SELECT * FROM article WHERE article.codeA='$codeA'";
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $result->rowCount();

                
            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "codeA"=>$item['codeA'],
                    "prix"=>$item['prix'],
                    "taille"=>$item['taille'],
                    "statut"=>$item['statut'],
                    "commentaire"=>$item['commentaire'],
                    "description"=>$item['description'],
                    "numListe"=>$item['numListe'],
                    ] ;
                }
            
            }
        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);

    
    }

    if($_GET['action']=="majlistestatut"){

        $response = [];
        $num_liste=$_GET['num'];
        $event=$_GET['event'];
        
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql = "UPDATE liste SET statut='soumis',id_event='$event'
            WHERE numListe='$num_liste'";
            // use exec() because no results are returned
            //print_r($sql);
            $bdconnect->exec($sql);
            $response = [
                        "message"=> "soumission réussie ",
                        "valide"=>true
                  ];
            
            
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
        $trigramme=$_POST['trigramme'];
        $nom_liste=$_POST['nom_liste'];
        $statut=$_POST['statut'];
        //print_r($_POST);
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql = "INSERT INTO liste (nom_liste,statut,trigramme,date_creation)
            VALUES ('$nom_liste', '$statut', '$trigramme',NOW())";
            // use exec() because no results are returned
            $bdconnect->exec($sql);
            $response = [
                        "message"=> "Ajout réussi",
                        "valide"=>true
                  ];


        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);


    }
    if($_POST['action']=="adddetail"){

        $response = [];
        $num_liste=$_POST['num_liste'];
        $description=$_POST['description'];
        $prix=$_POST['prix'];
        $taille=$_POST['taille'];
        $commentaire=$_POST['commentaire'];
        $statut=$_POST['statut'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            
            $req=$bdconnect->query("SELECT z FROM parametre limit 1");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $articleexist = $req->rowCount();
            $para = [];
                
            if($articleexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($req as $item){
                    $para [] = [
                    "z"=>$item['z'],
                    ] ;
                }
            }
            $a=$para[0];
            $z=$a['z'];

            $sql = "INSERT INTO article (numListe,prix,pourcentage,taille,description,statut,commentaire)
            VALUES ('$num_liste','$prix','$z','$taille', '$description','$statut', '$commentaire')";
            // use exec() because no results are returned
            $bdconnect->exec($sql);
            $response = [
                        "message"=> "Ajout réussi",
                        "valide"=>true
                  ];


        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);


    }
    if($_POST['action']=="editdetail"){

        $response = [];
        $description=$_POST['description'];
        $codeA=$_POST['codeA'];
        $prix=$_POST['prix'];
        $taille=$_POST['taille'];
        $commentaire=$_POST['commentaire'];
        $statut=$_POST['statut'];
    //print_r($_POST);
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{
            $sql = "UPDATE article SET prix='$prix',taille='$taille', description='$description',statut='$statut', commentaire='$commentaire'
            WHERE codeA='$codeA'";
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

    if($_POST['action']=="UPDATE"){


        if($_POST['type']=="ONLYONE"){
            $critere=$_POST['critere'];
            $statut =$_POST['statut'];
            $num =$_POST['numListe'];
            $sql = "UPDATE liste SET $critere='$statut' WHERE numListe = '$num'";
        }


        $response = [];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
        try{

            $bdconnect->exec($sql);
            $response = [
                "message"=> "Modification réussie ",
                "success"=>true
            ];


        }catch(PDOException $ex){
            $response = [
                "message"=> $ex->getMessage(),
                "success"=>false,
            ];
            echo json_encode($response);
            die();
        }
        echo json_encode($response);


    }


}
