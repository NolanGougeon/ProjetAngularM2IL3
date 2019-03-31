<?php
	require_once("ConnectionToBD.php");
    class Parametre{

        private $id;
        private $x;
        private $y;
        private $z;

        function __construct($id,$x,$y,$z){
            $this->id = $id;
            $this->x = $x;
            $this->y = $y;
            $this->z = $z;
        }

        public static function getParameters($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
            
            if($data['action']=="ALL" ){
                try{
                    $sql=" SELECT * FROM parametre ";
                    $result = $bdconnect->query($sql);
                    foreach ($result as $item) {
                        $resuldata = [
                            "montant_article" => $item['x'],
                            "id_parametre" => $item['id'],
                            "nombre_article" => $item['y'],
                            "pourcentage" => $item['z'],
                        ];
                    }
                    $response= [
                        "data"=>$resuldata,
                        "success"=>true,
                    ];
                    return $response;
                }catch (PDOException $ex){
                    $resuldata=[
                        "success"=>false,
                        "error"=>$ex->getMessage(),
                    ];
                    return $response;
                }
            }
        }

        public static function updateParameter($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            if($data['action']=="UPDATE"){
                try{
                    $sql=" UPDATE parametre SET  x=:montant_article, y=:nombre_article, z=:pourcentage WHERE id=:id_parametre";
                    $result = $bdconnect->prepare($sql);
                    $result->execute($data);
                    $resuldata= [
                        "data"=>$resuldata,
                        "success"=>true,
                    ];
                    return $response;
                }catch (PDOException $ex){
                    $resuldata=[
                        "success"=>false,
                        "error"=>$ex->getMessage(),
                    ];
                    return $response;
                }
            }
        }

        function activeVente($data){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            if($data['action']=="CHECK_VENTE_DAY" ){
                $today = date("Y-m-d");
                try{
                    $sql=" SELECT * FROM event WHERE event_statut='start' AND event.date='$today'";;
                    $result = $bdconnect->query($sql);
                    foreach ($result as $item) {
                        $resuldata = [
                            "id_event" => $item['id_event'],
                            "name_event" => $item['name_event'],
                            "is_dayVente" => true,
                            "date" => $item['date'],
        
                        ];
                    }
                    return $resuldata;
                }catch (PDOException $ex){
                    $resuldata=[
                        "success"=>false,
                        "error"=>$ex->getMessage(),
                    ];
                    return $resuldata;
                }
            }
        }

        public static function getAll(){
            $bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();
            try{
                $query = $connexion->prepare("SELECT * FROM parametre");
                $query->execute();

                return $result = $query->fetch();
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
