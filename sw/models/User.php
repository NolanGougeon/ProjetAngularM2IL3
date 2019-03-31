<?php
	require_once("ConnectionToBD.php");
    Class User{

        private $id;
        private $nom;
        private $prenom;
        private $dateNaissance;
        private $civilite;
        private $email;
        private $password;
        private $tyupeUser;
        private $numero;
        private $trigramme;
        private $actif;
        private $cle;
        private $adresse;
        private $cp;

        function __construct($id,$nom,$prenom,$dateNaissance,$civilite,
        $email,$password,$typeUser,$numero,$trigramme,$actif,$cle,$adresse,$cp){
            $this->id = $id;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->dateNaissance = $dateNaissance;
            $this->civilite = $civilite;
            $this->email = $email;
            $this->password = $password;
            $this->tyupeUser = $tyupeUser;
            $this->numero = $numero;
            $this->trigramme = $trigramme;
            $this->actif = $actif;
            $this->cle = $cle;
            $this->adresse = $adresse;
            $this->cp = $cp;
        }
        
        public static function getUser($user_login){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
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
                        "adresse"=>$item['adresse']
                    ] ;
                }
                $bd->destruct();
				return $data;
			}catch (PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }
    
        public static function userExist($email ,  $bdconnect){
            $data = [];
            try{
                $sql = "SELECT * FROM user WHERE  user.email= '$email' LIMIT 1 ";
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
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        public static function addUser($datas, $referer){
            $data = $datas;
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
            if(User::userExist($data['email'], $bdconnect)){
                $response =[
                    "status"=>false,
                    "exist"=>true,
                    "message"=> " il existe deja ce mail"
                ];
                $bd->destruct();
                return $response;
            }
            $trigram = User::trigrammeGenerate($data, $bdconnect);
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
                        "trigrammeExist" => $item['trigramme']
                    ];
                }
                if(!empty($resuldata)){
                    // si le trigramme exist deja
                    if($trigram[2] != "Z" ){
                        $trigram = User::nextTrigramme($trigram);
                        $isok = true;
                    } else {
                        $trigram = User::aleatoireTrigramme();
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
                $data['lienActive'] = $referer."#/register-active/".$data['cle'] ;

        //        sendMail($data['email'], "REGISTER GLAZIK MEMBER", $data);

                $response =[
                    "status"=>true,
                    "civilite"=>$data['civilite'],
                    "username"=>$data['nom'] ." ". $data['prenom'] ,
                    "message"=>" Votre insciption a ete prise en compte avec succes, un mail de confirmation vous à été envoyé merci !",
                    "token_confirm"=>$data['cle'],
                    "exist"=>false
                ];
                return $response;
            }catch (PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        public static function trigrammeGenerate($data , $bdconnect){
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
                    return User::nextTrigramme($trigrammeGenerated);
               } else {
                   return User::aleatoireTrigramme();
               }
           }else{
               return $trigrammeGenerated;
           }
        }

        public static function nextTrigramme($trigammeExistant){
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
        
        public static function aleatoireTrigramme(){
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

        public static function deleteUser($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
        
            try{
        
                $value=$data['value'];
                $sql=" DELETE FROM user WHERE user.trigramme='$value'";
                $bdconnect->query($sql);
                $resuldata= [
                    "success"=>true,
                    "message"=>"supprimer avec sucess",
                ];
                return $resuldata;
            }catch (PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        //Tout les users
        public static function getAllUsers($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
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
                return $resuldata;
            }catch (PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        // mise a jour  d'un utilisqteur
        public static function updateUser($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

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
                return $response;
            }catch (PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        //verification de confirmation de count
        public static function activeAccount($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

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
                return $response;
            }catch (PDOException $ex){
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
