<?php

#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');


include '../dbconnexion.php';
if(isset($_GET)&& !empty($_GET)){
    if($_GET['action']=="show"){

        $response = [];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DU TEXTE DE PRESENTATION 
        try{
            $sql="SELECT * FROM texte";
            //connect to the BD and exec the sql requete queryis a function that take SQL-R as parametre
            $result = $bdconnect->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            //count the number of lignes
            $texteexist = $result->rowCount();

                
            if($texteexist==0){
                // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
            } else
            {
                foreach ($result as $item){
                    $response [] = [
                    "codetext"=>$item['codetext'],
                    "description"=>$item['description'],
                    
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
    if($_POST['action']=="change"){

        $response = [];
        $texte=$_GET['texte'];
        $bdconnect = connectionToBD();
        //EXECUTION DE LA REQUETE DE SELECTION DU TEXTE DE PRESENTATION 
        try{
            $sql="UPDATE texte set description ='$texte' where codetext=1";
            $result = $bdconnect->exec($sql);

                    // $response [] = [
                    //"message"=>"super basma !",
                    //] ;

        }catch(PDOException $ex){
            echo $ex->getMessage();
            die();
        }
        echo json_encode($response);
    }
}

