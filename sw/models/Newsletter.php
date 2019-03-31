<?php
	require_once("ConnectionToBD.php");
    class Newsletter{

        private $id;
        private $email;
        private $dates;

        function __construct($id,$email,$dates){
            $this->id = $id;
            $this->email = $email;
            $this->dates = $dates;
        }

        public static function addNewsletter($mail){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            try{
                $response = [];
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
                return $response;
            } catch (PDOException $ex) {
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }
    }
?>