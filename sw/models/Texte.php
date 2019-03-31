<?php
	require_once("ConnectionToBD.php");
    class Texte{

        private $codetext;
        private $description;
        private $codepage;

        function __construct($codetext,$description,$codepage){
            $this->codetext = $codetext;
            $this->description = $description;
            $this->codepage = $codepage;
        }

        public static function getAll(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DU TEXTE DE PRESENTATION 
            try{
                $sql="SELECT * FROM texte";
                //connect to the BD and exec the sql requete queryis a function that take SQL-R as parametre
                $result = $bdconnect->query($sql);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                //count the number of lignes
                $texteexist = $result->rowCount();
    
                if($texteexist==0){
                    // ACTION A FAIRE AU CAS OU IL N'Y A PAS D'ARTICLE
                } else {
                    $response = [];
                    foreach ($result as $item){
                        $response [] = [
                            "codetext"=>$item['codetext'],
                            "description"=>$item['description']
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

        public static function update(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DU TEXTE DE PRESENTATION 
            try{
                $sql="UPDATE texte set description ='$texte' where codetext=1";
                $result = $bdconnect->exec($sql);
                $response = [
                    "message"=> "modification texte réussie ",
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