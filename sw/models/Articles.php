<?php
	require_once("ConnectionToBD.php");
    class Articles{

        private $id_article;
        private $id_cat;
        private $titre;
        private $date;
        private $contenu;
        private $vue;

        function __construct($id_article,$id_cat,$titre,$date,$contenu,$vue){
            $this->id_article = $id_article;
            $this->id_cat = $id_cat;
            $this->titre = $titre;
            $this->date = $date;
            $this->contenu = $contenu;
            $this->vue = $vue;
        }

        public static function getLatest(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES RECENTS
            try{
                $sql="SELECT * FROM articles,categorie WHERE articles.id_cat=categorie.id_cat ORDER BY date DESC LIMIT 0, 4";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id"=>$item['id_article'],
                            "id_cat"=>$item['id_cat'],
                            "titre"=>$item['titre'],
                            "date"=>$item['date'],
                            "contenu"=>$item['contenu'],
                            "vue"=>$item['vue'],
                            "nom_cat"=>$item['nom_cat']
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

        public static function getAll(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC 
            try{
                $sql="SELECT * FROM articles,categorie WHERE articles.id_cat=categorie.id_cat";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id"=>$item['id_article'],
                            "id_cat"=>$item['id_cat'],
                            "titre"=>$item['titre'],
                            "date"=>$item['date'],
                            "contenu"=>$item['contenu'],
                            "vue"=>$item['vue'],
                            "nom_cat"=>$item['nom_cat']
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

        public static function getMostPopular(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES RECENTS
            try{
                $sql="SELECT * FROM articles,categorie WHERE articles.id_cat=categorie.id_cat ORDER BY vue DESC LIMIT 0, 4";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id"=>$item['id_article'],
                            "id_cat"=>$item['id_cat'],
                            "titre"=>$item['titre'],
                            "date"=>$item['date'],
                            "contenu"=>$item['contenu'],
                            "vue"=>$item['vue'],
                            "nom_cat"=>$item['nom_cat']
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

        public static function getSelected($selectedid){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            // EXECUTION DE LA REQUETE DE SELECTION DE L'ARTICLE CHOISI
            try{
                $sql="SELECT * FROM articles,categorie WHERE articles.id_article='$selectedid' AND articles.id_cat=categorie.id_cat";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $articleexist = $result->rowCount();

                if($articleexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else { // ON RECUPERE L'ARTICLE
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id"=>$item['id_article'],
                            "id_cat"=>$item['id_cat'],
                            "titre"=>$item['titre'],
                            "date"=>$item['date'],
                            "contenu"=>$item['contenu'],
                            "vue"=>$item['vue'],
                            "nom_cat"=>$item['nom_cat']
                        ] ;
                    }
                    // MET A JOUR LE NOMBRE DE VUE  L'ARTICLE 
                    $id=$response[0]['id'];
                    $vue_update=$response[0]['vue'];
                    $vue_update+=1;
                    $sql2="UPDATE articles SET vue='$vue_update' WHERE id_article='$id'";
                    $result2 = $bdconnect->prepare($sql2);
                    $result2->execute();
                    
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

        public static function getSelectedComment($selectedid){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            // EXECUTION DE LA REQUETE DE SELECTION DES 4 COMMENTAIRES LES PLUS RECENTS DE L'ARTICLE
            try{
                $sql="SELECT * FROM commentaire WHERE commentaire.id_article='$selectedid' ORDER BY date DESC LIMIT 0, 4";
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $nbcommentaires = $result->rowCount();

                if($nbcommentaires==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else { // ON RECUPERE L'ARTICLE
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "id_commentaire"=>$item['id_commentaire'],
                            "id_article"=>$item['id_article'],
                            "auteur"=>$item['auteur'],
                            "commentaire"=>$item['commentaire'],
                            "date"=>$item['date']
                        ] ;
                    }
                    // MET A JOUR LE NOMBRE DE VUE  L'ARTICLE 
                    $id=$response[0]['id'];
                    $vue_update=$response[0]['vue'];
                    $vue_update+=1;
                    $sql2="UPDATE articles SET vue='$vue_update' WHERE id_article='$id'";
                    $result2 = $bdconnect->prepare($sql2);
                    $result2->execute();

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