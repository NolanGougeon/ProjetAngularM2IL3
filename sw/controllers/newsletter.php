<?php


#... ce bout de code permet au serveur php de recevoir une demande service à partir de n'importe quelle origine et
#.. et sous quelle forme de donnnees les reponse seront emise !
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

#... verif iic apres on mettra des tockens de connexions de sessions mais actu boff pas trop le temps

if(isset($_GET)){

        include'../dbconnexion.php';
        $bdconnect = connectionToBD();
        $response = [];
         //$data = json_decode($_POST, true);

         //$email=$_POST['newsletter'];
         $mail=$_GET['mail'];
        //print_r($mail);


        $reqmail = $bdconnect->query("SELECT * FROM newsletter WHERE email='$mail'");
        $reqmail->setFetchMode(PDO::FETCH_ASSOC);
        $mailexist = $reqmail->rowCount();
         if($mailexist == 0){

            $sql = "INSERT INTO newsletter(email,dates) VALUES ('$mail',NOW())";
            $bdconnect->exec($sql);

            $response = [
                "message"=> "Merci pour votre inscription !",
                "erreur"=>false
                ];

        } else {

            $response = [
                "message"=> "Soit le mail n'est pas valide, soit vous êtes déja inscrit",
                "erreur"=>true
          ];
         }
     
    echo json_encode($response);
}