<?php
	require_once("ConnectionToBD.php");
	require_once("Parametre.php");
    class Article{

        private $codeA;
        private $numListe;
        private $prix;
        private $pourcentage;
        private $taille;
        private $description;
        private $photo;
        private $statut;
        private $commentaire;
        private $codeV;
        private $codeDV;

        function __construct($codeA,$numListe,$prix,$pourcentage,$taille,
        $description,$photo,$statut,$commentaire,$codeV,$codeDV){
            $this->codeA = $codeA;
            $this->numListe = $numListe;
            $this->prix = $prix;
            $this->pourcentage = $pourcentage;
            $this->taille = $taille;
            $this->description = $description;
            $this->photo = $photo;
            $this->statut = $statut;
            $this->commentaire = $commentaire;
            $this->codeV = $codeV;
            $this->codeDV = $codeDV;
        }

        public static function add($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
            
            try {
                $parametres = Parametre::getAllParametre();
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
        
                if(isset($_FILES) && !empty($_FILES)) {
                    $destination = "../files/". $destination;
                    move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );
                }
        
                $response = [
                    "success"=>true,
                    "message"=>"nouvel article enregistre"
                ];
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

        // mise a jour  d'un utilisateur
        public static function update($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            try {
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
            } catch (PDOException $ex) {
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }
        
        public static function delete($codeA){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql="DELETE FROM article WHERE article.codeA='$codeA'";
                $bdconnect->exec($sql);
                $response = [
                    "message"=> "Supression effectuée",
                    "valide"=>true
                ];
                return $response;
            }catch(PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        public static function updateToVendu($codeA){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            try {
                $sql3 = " UPDATE article SET statut='VENDU' WHERE article.codeA = :codeA";
                $preStatment3 =  $bdconnect->prepare($sql3);
                $preStatment3->execute(array(
                    "codeA"=>$data['codeA'],
                ));

                $response= [
                    "success"=>true,
                    "message"=>"modification statut effectue avec sucess",
                ];
            } catch (PDOException $ex) {
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        public static function get($codeA){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql="SELECT * FROM article WHERE article.codeA='$codeA'";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "codeA"=>$item['codeA'],
                            "prix"=>$item['prix'],
                            "taille"=>$item['taille'],
                            "statut"=>$item['statut'],
                            "commentaire"=>$item['commentaire'],
                            "description"=>$item['description'],
                            "numListe"=>$item['numListe']
                        ] ;
                    }
                    return $response;
                }
            }catch(PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        public static function addToListe($num_liste,$description,$prix,$taille,$commentaire,$statut){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $req=$bdconnect->query("SELECT z FROM parametre limit 1");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $req->rowCount();
                $para = [];
                    
                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
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
                return $response;
            }catch(PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        public static function updateFromListe($codeA,$description,$prix,$taille,$commentaire,$statut){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql = "UPDATE article SET prix='$prix',taille='$taille', description='$description',statut='$statut', commentaire='$commentaire'
                WHERE codeA='$codeA'";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $response = [
                    "message"=> "Modification réussie ",
                    "valide"=>true
                ];
                return $response;
            }catch(PDOException $ex){
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