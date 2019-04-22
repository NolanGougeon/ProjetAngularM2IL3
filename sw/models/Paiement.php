<?php
	require_once("ConnectionToBD.php");
    class Paiement{

        private $id;
        private $user_trigramme;
        private $num_liste;
        private $date_paiement;
        private $type_paiement;
        private $montant;

        function __construct($id,$user_trigramme,$num_liste,$date_paiement,$type_paiement,$montant){
            $this->id = $id;
            $this->user_trigramme = $user_trigramme;
            $this->num_liste = $num_liste;
            $this->date_paiement = $date_paiement;
            $this->type_paiement = $type_paiement;
            $this->montant = $montant;
        }

        public function add(){
			$bd = new ConnectionToBD();
            $bdconnect = $bd->getBdconect();

            //EXECUTION DE LA REQUETE DE SELECTION DES ARTICLES AVEC
            try{
				// on vérifie si l'enregistrement existe
				$exist = $this->isExist();

				// si l'enregistrement n'existe pas, on retourne le message
				if(isset($exist['status']) and $exist['status']==false){
					return $exist;
				}

				// insertion du paiement
                $sql="INSERT INTO Paiement (user_trigramme,num_liste,date_paiement,type_paiement,montant) VALUES (:user_trigramme,:num_liste,:date_paiement,:type_paiement,:montant);";
                $result = $bdconnect->prepare($sql);
                $result->bindValue(':user_trigramme',$this->user_trigramme);
                $result->bindValue(':num_liste',$this->num_liste);
                $result->bindValue(':date_paiement',$this->date_paiement);
                $result->bindValue(':type_paiement',$this->type_paiement);
                $result->bindValue(':montant',$this->montant);
                $result->execute();
                $response = [
                    "success"=>true,
                    "message"=>"nouvel article enregistre"
                ];
                return $response;
            } catch (PDOException $ex) {
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage()
                ];
                $bd->destruct();
                return $response;
            }
		}

		public function isExist(){
			if($this->id = null and ($this->user_trigramme = null or $this->num_liste = null or $this->date_paiement = null) ){
				$response = [
					"status"=>false,
					"message"=>"impossible de chercher le paiement : pas assez d'informations"
				];
				return $response;
			}else if($this->id = null){
				$condition = "user_trigramme=:user_trigramme AND num_liste=:num_liste AND date_paiement=:date_paiement";
			}else{
				$condition = "id=:id";
			}
			try{
				$bd = new ConnectionToBD();
				$bdconnect = $bd->getBdconect();

				$sql = "SELECT COUNT(*) FROM Paiement WHERE $condition;";
				$request = $bdconnect->prepare($sql);
				if($this->id = null){
					$request->bindValue(':user_trigramme',$this->user_trigramme);
					$request->bindValue(':num_liste',$this->num_liste);
					$request->bindValue(':date_paiement',$this->date_paiement);
				}else{
					$request->bindValue(':id',$this->id);
				}
				$request->execute();
				$result = $request->fetch(PDO::FETCH_NUM)[0];

				if($result == 0){
					$response = [
						"success"=>true,
						"message"=>"nouveau paiement enregistré"
					];
					return $response;
				}else{
					$response =[
						"status"=>false,
						"message"=>"un enregistrement existe déjà"
					];
					return $response;
				}

			} catch (PDOException $ex) {
                $response =[
                    "status"=>false,
                    "message"=>$ex->getMessage()
                ];
                $bd->destruct();
                return $response;
            }
		}
	}
?>
