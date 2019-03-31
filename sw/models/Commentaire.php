<?php
	require_once("ConnectionToBD.php");
    class Commentaire{

        private $id_commentaire;
        private $id_article;
        private $auteur;
        private $commentaire;
        private $date;

        function __construct($id_commentaire,$id_article,$auteur,$commentaire,$date){
            $this->id_commentaire = $commentaire;
            $this->id_article = $article;
            $this->auteur = $auteur;
            $this->commentaire = $commentaire;
            $this->date = $date;
        }

        public static function add($id_art,$name,$texte){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            // EXECUTION DE LA REQUETE D'AJOUT DE COMMENTAIRE
            try{
                $sql = "INSERT INTO commentaire (id_article,auteur,commentaire,date)
                VALUES ('$id_art', '$name', '$texte',NOW())";
                // use exec() because no results are returned
                $bdconnect->exec($sql);
                $response = [
                    "message"=> "Merci pour ce commentaire !",
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
    }
?>