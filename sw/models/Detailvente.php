<?php
	require_once("ConnectionToBD.php");
    class Detailvente{
        private $codeDV;
        private $codeV;
        private $codeA;

        function __construct($codeDV,$codeV,$codeA){
            $this->codeDV = $codeDV;
            $this->codeV = $codeV;
            $this->codeA = $codeA;
        }

        public static function add($codeV,$codeA){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
            try{
                $sql2 =  " INSERT INTO detailvente (codeV, codeA) VALUES (:codeV, :codeA);";
                $preStatment2 = $bdconnect->prepare($sql2);
                $preStatment2->execute(array(
                    "codeV"=>$codeV,
                    "codeA"=>$data['codeA']
                ));

                $response= [
                    "success"=>true,
                    "message"=>"insertion detailvente effectue avec sucess",
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
    }
?>