<?php
	require_once("ConnectionToBD.php");
    class Event{

        private $id_event;
        private $name_event;
        private $date;
        private $lieu;
        private $date_creation;
        private $event_statut;

        function __construct($id_event,$name_event,$date,$lieu,$date_creation,$event_statut){
            $this->id_event = $id_event;
            $this->name_event = $name_event;
            $this->date = $date;
            $this->lieu = $lieu;
            $this->date_creation = $date_creation;
            $this->event_statut = $event_statut;
        }

        public static function getAll(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql="SELECT * FROM event WHERE event_statut='created' or event_statut='start' ORDER BY date ASC";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id_event"=>$item['id_event'],
                            "name_event"=>$item['name_event'],
                            "date"=>$item['date'],
                            "lieu"=>$item['lieu'],
                            "event_statut"=>$item['event_statut'],
                            "current_date"=>date("Y-m-d")
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

        public static function getLoadAbort(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql="SELECT * FROM event WHERE event_statut='abort' ORDER BY date ASC";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id_event"=>$item['id_event'],
                            "name_event"=>$item['name_event'],
                            "date"=>$item['date'],
                            "lieu"=>$item['lieu']
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

        public static function updateAbort($id_event){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql = "UPDATE event SET event_statut='abort'
                WHERE id_event='$id_event'";
                $sql1 = "UPDATE liste SET liste.statut='en cours',liste.id_event='NULL'
                WHERE liste.id_event='$id_event'";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $bdconnect->exec($sql1);
                $response = [
                    "message"=> "annulation event réussie ",
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

        public function updateStart($id_event){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql = "UPDATE event SET event_statut='start'
                WHERE id_event='$id_event'";
                $sql1 = "UPDATE liste SET liste.statut='en vente'
                WHERE liste.id_event='$id_event'";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $bdconnect->exec($sql1);
                $response = [
                    "message"=> "demarrage event réussie ",
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

        public static function updateClose($id_event){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql = "UPDATE event SET event_statut='close'
                WHERE id_event='$id_event'";
                // $sql1 = "UPDATE article SET article.statut='INVENDU'
                // WHERE article.statut='RETIRE'";
                // $sql1="UPDATE article SET article.statut='INVENDU' WHERE article.statut='RETIRE'
                // OR article.codeA=(SELECT DISTINCT codeA FROM event,liste WHERE liste.id_event='$id_event' and article.numListe=liste.numListe)";
                $sql1="UPDATE article SET article.statut='INVENDU' WHERE article.codeA=(SELECT DISTINCT codeA FROM event,liste WHERE liste.id_event='$id_event' AND article.numListe=liste.numListe AND (article.statut<>'VENDU' AND article.statut<>'RETIRE') )";
                $sql2="UPDATE liste SET statut='vendue'
                WHERE liste.id_event='$id_event'";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $bdconnect->exec($sql1);
                $bdconnect->exec($sql2);
                $response = [
                    "message"=> "fermetture event réussie ",
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

        public static function getEventDetailsElement($id_event){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql="SELECT * FROM event WHERE event.id_event='$id_event'";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "name_event"=>$item['name_event'],
                            "date"=>$item['date'],
                            "lieu"=>$item['lieu'],
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

        public static function add($name,$date,$lieu){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql = "INSERT INTO event (name_event,date,lieu,date_creation,event_statut)
                VALUES ('$name', '$date', '$lieu',NOW(),'created')";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $response = [
                    "message"=> "Ajout event réussi",
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

        public static function updateEditEvent($id_event,$name,$date,$lieu){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SUPRESSION D'UNE LISTE
            try{
                $sql = "UPDATE event SET name_event='$name',date='$date',lieu='$lieu'
                WHERE id_event='$id_event'";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $response = [
                    "message"=> "Modification réussie ",
                    "valide"=>true
                ];

            }catch(PDOException $ex){
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $response;
            }
        }

        public static function getLoadEvents(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql="SELECT * FROM event WHERE event_statut='created' ORDER BY date ASC LIMIT 1";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id_event"=>$item['id_event'],
                            "name_event"=>$item['name_event'],
                            "date"=>$item['date'],
                            "lieu"=>$item['lieu']
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
    }
?>