<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

include '../dbconnexion.php';

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps

if(isset($_POST) && !empty($_POST)){

    if($_POST["action"]=="UPDATE"){
        updateArticle($_POST);
    }
    if($_POST["action"]=="ADD_VENTE"){
         addVente($_POST);
    }
    if($_POST["action"]=="RETRAIT"){
         updateArticle($_POST);
    }
    if($_POST["action"]=="FILE"){
            addArticle($_POST['data']);
    }



} elseif (isset($_GET)  && !empty($_GET)){

}

function addArticle($data){

    $response =[];
    try{


        $bdconnect = connectionToBD();
        $parametres = getAllParametre();
        $sql =  " INSERT INTO article (numListe, prix, taille, description, commentaire, statut, photo, pourcentage)
              VALUES (:num_liste, :prix, :taille, :description, :commentaire, :statut, :photo , :pourcentage);";
        $preStatment = $bdconnect->prepare($sql);

        $data['statut']="NON FOURNI";
        $data['photo'] = null;
        $data['pourcentage'] = $parametres['x'];
        if(isset($_FILES) && !empty($_FILES)) {
            $destination = $_FILES['file']['name'];
            $data['photo'] = $destination;
        }

        $preStatment->execute($data);

        if(isset($_FILES) && !empty($_FILES)){
            $destination = "../files/". $destination;
            move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );
        }
        $response = [
            "success"=>true,
            "message"=>"nouvel article enregistre"
        ];

    }catch (PDOException $ex){
        $response = [
            "success"=>false,
            "message"=>$ex->getMessage(),
        ];
        echo json_encode($response);
    }

    echo json_encode($response);
};







//Tout les users
function addVente($data){


    $bdconnect = connectionToBD();
    $resuldata = [];
    $sql =  " INSERT INTO vente (dateV, acheteur, acheteur_numero, acheteur_adresse)
              VALUES (NOW(), :acheteur, :acheteur_numero, :acheteur_adresse);";


    $sql2 =  " INSERT INTO detailvente (codeV, codeA)
              VALUES (:codeV, :codeA);";

    $sql3 = " UPDATE article SET statut='VENDU' WHERE article.codeA = :codeA";

    $preStatment = $bdconnect->prepare($sql);
    $preStatment2 = $bdconnect->prepare($sql2);
    $preStatment3 = $bdconnect->prepare($sql3);

//    print_r($data);
//    die();

    try{


        //si c'est une premiere sent pour la data
        if( empty($data["lasteIdVente"]) ) {

            $preStatment->execute(array(
                "acheteur"=>$data["acheteur_name"],
                "acheteur_numero"=>$data["acheteur_numero"],
                "acheteur_adresse"=>$data["acheteur_adresse"],
            ));

            $lastIDVente = $bdconnect->lastInsertId();

            $preStatment2->execute(array(
                "codeV"=>$lastIDVente,
                "codeA"=>$data['codeA'],
            ));

            $preStatment3->execute(array(
                "codeA"=>$data['codeA'],
            ));


            $resuldata = [
                "lasteIdVente"=>$lastIDVente,
                "success" => true,
                "message"=>"premier article inserer",
            ];


        } else {

            $preStatment2->execute(array(
                "codeV"=>$data['lasteIdVente'],
                "codeA"=>$data['codeA'],
            ));

            $preStatment3->execute(array(
                "codeA"=>$data['codeA'],
            ));

            $resuldata = [
                "message"=>" c'est les suivants articles",
                "success" => true,
            ];

        }


    }catch (PDOException $ex){
        $resuldata=[
            "success"=>false,
            "error"=>$ex->getMessage(),
        ];
        echo  json_encode($resuldata);
    }

    echo json_encode($resuldata);


};




// mise a jour  d'un utilisateur
function updateArticle($data){


    $response =[];
    $bdconnect = connectionToBD();
    try{


        $sql= "UPDATE article SET article.statut=:statut, article.commentaire=:commentaire WHERE codeA=:codeA ";
        $pst =  $bdconnect->prepare($sql);
        $pst->execute(array(
            "statut"=>$data['statut'],
            "commentaire"=>isset($data['motif'])?$data['motif']:$data['commentaire'],
            "codeA"=>$data['codeA'],
        ));

        $response= [
            "success"=>true,
            "message"=>"modification effectue avec sucess",
        ];
    }catch (PDOException $ex){
        $response=[
            "success"=>false,
            "error"=>$ex->getMessage(),
        ];
        echo  json_encode($response);
    }

    echo json_encode($response);


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
