<?php
	require_once("ConnectionToBD.php");
	require_once("Detailvente.php");
	require_once("Article.php");
    class Vente{

        private $codeV;
        private $dateV;
        private $acheteur;
        private $acheteur_numero;
        private $acheteur_adresse;

        function __construct($codeV,$dateV,$acheteur,$acheteur_numero,$acheteur_adresse){
            $this->codeV = $codeV;
            $this->dateV = $dateV;
            $this->acheteur = $acheteur;
            $this->acheteur_numero = $acheteur_numero;
            $this->acheteur_adresse = $acheteur_adresse;
        }

        //Tout les users
        public static function add($data) {
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            try{
                //si c'est une premiere sent pour la data
                if(empty($data["lasteIdVente"])) {
            
                    $sql =  " INSERT INTO vente (dateV, acheteur, acheteur_numero, acheteur_adresse)
                            VALUES (NOW(), :acheteur, :acheteur_numero, :acheteur_adresse);";
                    $preStatment =  $bdconnect->prepare($sql);
                    $preStatment->execute(array(
                        "acheteur"=>$data["acheteur_name"],
                        "acheteur_numero"=>$data["acheteur_numero"],
                        "acheteur_adresse"=>$data["acheteur_adresse"],
                    ));

                    DetailVente::add($bdconnect->lastInsertId(),$date['codeA']);
                    Article::updateToVendu($data['codeA']);

                    $resuldata = [
                        "lasteIdVente"=>$lastIDVente,
                        "success" => true,
                        "message"=>"premier article inserer",
                    ];
                } else {
                    DetailVente::add($data['lasteIdVente'],$date['codeA']);
                    Article::updateToVendu($data['codeA']);

                    $resuldata = [
                        "message"=>" c'est les suivants articles",
                        "success" => true,
                    ];
                }
                return $resuldata;
            } catch (PDOException $ex) {
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage(),
                ];
                $bd->destruct();
                return $reponse;
            }
        }
        
    }
?>