<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

include '../dbconnexion.php';

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps
$response = [];
if(isset($_POST) && !empty($_POST)){
    // Ajouter un utilisateur // Vendeur en occurence
    if($_POST['action']=="ADD"){
        $data = copyArray($_POST, "action");
        addUser($data);
    }

     if($_POST['action']=="VERIFY"){
         $data = copyArray($_POST, "action");
         activeAccount($data);
    }
    if($_POST['action']=="UPDATE"){
        $data = copyArray($_POST, "action");
        updateUser($data);

    }
} elseif (isset($_GET)  && !empty($_GET)){

    if($_GET['action']=="DELETE"){
        deleteUser($_GET);
    }else {
        getAllUsers($_GET);
    }

}








function deleteUser($data){
    $bdconnect = connectionToBD();
    $resuldata = [];

    try{

        $value=$data['value'];
        $sql=" DELETE FROM user WHERE user.trigramme='$value'";
        $bdconnect->query($sql);
        $resuldata= [
            "success"=>true,
            "message"=>"supprimer avec sucess",
        ];

    }catch (PDOException $ex){
        $resuldata=[
            "success"=>false,
            "error"=>$ex->getMessage(),
        ];
        echo  json_encode($resuldata);
    }

    echo json_encode($resuldata);


};


//Tout les users
function getAllUsers($data){
    $bdconnect = connectionToBD();
    $resuldata = [];

    try{
        $sql="";
        if($data['action']=="ALL"){
            $sql = "SELECT * FROM user ";
        } else{
            $critere = $data['critere'];
            $value = $data['value'];
            $sql = "SELECT * FROM user WHERE user.$critere = '$value' ;";
        }


        $result = $bdconnect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($result as $item) {
            $resuldata [] = [
                "nom" => $item['nom'],
                "prenom" => $item['prenom'],
                "trigramme" => $item['trigramme'],
                "adresse" => $item['adresse'],
                "civilite" => $item['civilite'],
                "email" => $item['email'],
                "actif" => $item['actif'],
                "numero" => $item['numero'],
                "type" => $item['typeUser'],
                "dateNaissance" => $item['dateNaissance'],
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




// mise a jour  d'un utilisqteur
function updateUser($data){
    $bdconnect = connectionToBD();

    try{



        $sql = "UPDATE user SET  nom=:nom , prenom=:prenom, adresse=:adresse , 
             password =:password , numero = :numero  WHERE user.email=:email ;";

        $pst =  $bdconnect->prepare($sql);
        $pst->execute(array(
            "nom"=>$data['name'],
            "prenom"=>$data['prenom'],
            "adresse"=>$data['adresse'],
            "password"=>password_hash($data['password'], PASSWORD_BCRYPT),
            "numero"=>$data['numero'],
            "email"=>$data['email'],
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

// Ajout d'un utilisateur
function addUser($data){


    $response=[];
    $bdconnect = connectionToBD();
    if(userExist($data['email'], $bdconnect)){
        $response =[
            "status"=>false,
            "exist"=>true,
            "message"=> " il existe deja ce mail",
        ];
        echo json_encode($response);
        die();
    }
    $trigram = trigrammeGenerate($data, $bdconnect);
    do {
        $isok =  false;
        $resuldata = [];
        $sql = "SELECT *FROM user WHERE  user.trigramme='$trigram' LIMIT 1";
        $result = $bdconnect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            $resuldata = [
                "nom" => $item['nom'],
                "prenom" => $item['prenom'],
                "trigrammeExist" => $item['trigramme'],
            ];
        }
        if(!empty($resuldata)){
            // si le trigramme exist deja
            if($trigram[2] != "Z" ){
                $trigram = nextTrigramme($trigram);
                $isok = true;
            } else {
                $trigram = aleatoireTrigramme();
                $isok = true;
            }
        }else {
            $isok = false;
        }
    }while($isok);

    try{






        $sql =" INSERT INTO user (nom, prenom, dateNaissance, civilite, numero, email, password, typeUser, trigramme, cle, adresse, cp)
                VALUES (:nom, :prenom, :dateNaissance, :civilite, :numero, :email, :password, :typeUser, :trigramme, :cle, :adresse, :cp) ";

        // Ajouter un trigramme dans la data;
        $data['trigramme'] = $trigram;
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['cle'] = md5(microtime(TRUE)*100000);


        $preapreREq = $bdconnect->prepare($sql);
        $preapreREq->execute($data);
        $data['lienActive'] = $_SERVER['HTTP_REFERER']."#/register-active/".$data['cle'] ;

//        sendMail($data['email'], "REGISTER GLAZIK MEMBER", $data);

        $response =[
            "status"=>true,
            "civilite"=>$data['civilite'],
            "username"=>$data['nom'] ." ". $data['prenom'] ,
            "message"=>" Votre insciption a ete prise en compte avec succes, un mail de confirmation vous à été envoyé merci !",
            "token_confirm"=>$data['cle'],
            "exist"=>false,
        ];

    }catch (PDOException $ex){
        $response =[
            "status"=>false,
            "message"=>$ex->getMessage(),
        ];
        echo  json_encode($response);
    }
    echo json_encode($response);
}

function trigrammeGenerate($data , $bdconnect){


         $trigrammeGenerated = strtoupper($data['prenom'][0]);
         $trigrammeGenerated = $trigrammeGenerated . "" . strtoupper(substr($data['nom'], 0, 2));

         $resuldata = [];
         $sql = "SELECT *FROM user WHERE  user.trigramme='$trigrammeGenerated' LIMIT 1";
         $result = $bdconnect->query($sql);
         $result->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($result as $item){
            $resuldata = [
                "nom"=>$item['nom'],
                "prenom"=>$item['prenom'],
                "trigrammeExist"=>$item['trigramme'],
            ] ;
        }

        if(!empty($resuldata)){
            // si le trigramme exist deja
            if($trigrammeGenerated[2] != "Z" ){
                 return nextTrigramme($trigrammeGenerated);
            } else {
                return aleatoireTrigramme();
            }
        }else{
            return $trigrammeGenerated;
        }


};

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

function nextTrigramme($trigammeExistant){
    $alphabet = [
        "A","B","C","D","E","F","G","H","I","J","K","L","M",
        "N","O","P","Q","R","S","T","U","V","W","X","Y","Z"
    ];
    $lastPosition =strtoupper(substr($trigammeExistant,-1));
    $index = 0;
    foreach($alphabet as $value){

        if($value == $lastPosition){
            $trigammeExistant[2] = $alphabet[$index+1];
        }
        $index++;
    }
    return $trigammeExistant;
}

function aleatoireTrigramme(){
    $alphabet = [
        "A","B","C","D","E","F","G","H","I","J","K","L","M",
        "N","O","P","Q","R","S","T","U","V","W","X","Y","Z"
    ];
    $otherAleaTrigramme="";
    for($i=0 ; $i < 2; $i++ ){
        $otherAleaTrigramme =$otherAleaTrigramme."".$alphabet[rand(0,25)];
    }
    return $otherAleaTrigramme;
}


//verification de confirmation de count
function activeAccount($data){

    $response=[];
    $bdconnect = connectionToBD();

    try{
        $cle = $data['cle'];
        $sql = "SELECT *FROM user WHERE  user.cle= '$cle' ";
        $result = $bdconnect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);


        foreach ($result as $item){
            $dataResult [] = [
                "name"=>$item['nom'],
                "prenom"=>$item['prenom'],
                "dateNaissance"=>$item['dateNaissance'],
                "civilite"=>$item['civilite'],
                "email"=>$item['email'],
                "password"=>$item['password'],
                "numero"=>$item['numero'],
            ] ;
        }
        if(!empty($dataResult)){
            $sql = "UPDATE user SET actif='1', cle='verified' WHERE user.cle= '$cle' ";
            $pst =  $bdconnect->prepare($sql);
            $pst->execute();
            $response = [
                "success" => true,
            ];

        } else {
            $response = [
                "success" => false,
            ];
        }
    }catch (PDOException $ex){
    }
    echo  json_encode($response);



}

function userExist($email ,  $bdconnect){
    $data = [];
    try{
        $sql = "SELECT *FROM user WHERE  user.email= '$email' LIMIT 1 ";
        $result = $bdconnect->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($result as $item){
            $data [] = [
                "name"=>$item['nom'],
                "prenom"=>$item['prenom'],
                "dateNaissance"=>$item['dateNaissance'],
                "civilite"=>$item['civilite'],
                "email"=>$item['email'],
                "password"=>$item['password'],
                "numero"=>$item['numero'],
                "type"=>$item['typeUser'],
            ] ;
        }

        // si on retrouve des donnees correspondant au user alors on verifie
        if(!empty($data)){
            return true;
        } else {
            return false;
        }

    }catch (PDOException $ex){
        echo $ex->getMessage();
        die();
    }
}