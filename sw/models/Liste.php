<?php
    require_once("ConnectionToBD.php");
    class Liste{

        public $numListe;
        public $id_event;
        public $nom_liste;
        public $statut;
        public $trigramme;
        public $date_creation;

        function __construct($numListe,$id_event,$nom_liste,$statut,$trigramme,$date_creation){
            $this->numListe = $numListe;
            $this->id_event = $id_event;
            $this->nom_liste = $nom_liste;
            $this->statut = $statut;
            $this->trigramme = $trigramme;
            $this->date_creation = $date_creation;
        }

        public static function getAll($tri){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql="SELECT * FROM liste WHERE liste.trigramme='$tri'";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "numListe"=>$item['numListe'],
                            "nom_liste"=>$item['nom_liste'],
                            "statut"=>$item['statut'],
                            "date_creation"=>$item['date_creation']
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

        public static function getAllGain($tri){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql="SELECT liste.numListe, nom_liste, date_creation, SUM(prix) as gain FROM liste, article WHERE liste.trigramme='$tri' and liste.statut='vendue' and liste.numListe=article.numListe and article.statut='VENDU'";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();
      
                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "numListe"=>$item['numListe'],
                            "nom_liste"=>$item['nom_liste'],
                            "gain"=>$item['gain'],
                            "date_creation"=>$item['date_creation']
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

        public static function get($critere,$value){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC
            try{
                $sql="SELECT * FROM liste,user,event WHERE liste.$critere='$value' 
                    AND user.trigramme=liste.trigramme AND liste.id_event=event.id_event
                    ";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
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
                            "date_event"=>$item['date']
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

        public static function getListeDetails($num){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql="SELECT * FROM article WHERE article.numListe='$num'";
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
                            "numListe"=>$item['numListe'],
                            "photo"=>$item['photo']
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

        public static function delete($num_liste){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql="DELETE FROM liste WHERE liste.NumListe='$num_liste'";
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

        public static function updateMajListeStatut($num_liste,$event){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
            
            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql = "UPDATE liste SET statut='soumis',id_event='$event'
                WHERE numListe='$num_liste'";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $response = [
                    "message"=> "soumission réussie ",
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

        public static function add($trigramme,$nom_liste,$statut){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

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

        public static function update($num,$critere,$statut){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql = "UPDATE liste SET $critere='$statut' WHERE numListe = '$num'";
                $bdconnect->exec($sql);
                $response = [
                    "message"=> "Modification réussie ",
                    "success"=>true
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

        public static function deleteDetails($codeA){
            return Article::delete($codeA);
        }

        public static function getListeDetailsElement($codeA){
            return Article::get($codeA);
        }

        public static function addDetail($num_liste,$description,$prix,$taille,$commentaire,$statut){
            return Article::addToListe($num_liste,$description,$prix,$taille,$commentaire,$statut);
        }

        public static function updateEditDetail($codeA,$description,$prix,$taille,$commentaire,$statut){
            return Article::updateToListe($codeA,$description,$prix,$taille,$commentaire,$statut);
        }
    }
?>