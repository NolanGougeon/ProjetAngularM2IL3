<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

include '../dbconnexion.php';

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps
$response = [];
if(isset($_POST)){
    $user_login=$_POST['email'];
    $user_password =$_POST['password'];


    if(isset($user_login)){

            $bdconnect = connectionToBD();

            $data = [];
            try{
                $sql = "SELECT *FROM user WHERE  user.email= '$user_login' LIMIT 1 ";
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
                        "trigramme"=>$item['trigramme'],
                        "actif"=>$item['actif'],
                        "adresse"=>$item['adresse'],

                    ] ;
                }

                // si on retrouve des donnees correspondant au user alors on verifie son mot de passe
                if(!empty($data)){
                    // si le password est correcte alors;
                    if(password_verify($user_password, $data[0]['password'])){
                        $response = [
                            "data"=>$data,
                            "autorize"=>true
                        ];
                    } else{
                        $response = [
                            "status" => "failed",
                            "message"=> " Mot de passe ou login Incorrect",
                            "autorize"=>false
                        ];
                    }
                } else {
                    $response = [
                        "status" => "failed",
                        "message"=> " Mot de passe ou login Incorrect",
                        "autorize"=>false
                    ];
                }


            }catch (PDOException $ex){
                echo $ex->getMessage();
                die();
            }
    } else {
        $response = [
            "status" => "failed",
            "message"=> " un vilain message",
            "autorize"=>false
        ];
    }
    echo json_encode($response);
}