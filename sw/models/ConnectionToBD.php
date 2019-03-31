<?php
    class ConnectiontoBD{

        private $bdconect;
        private $configs_env;
        private $USERS_db;
        private $PASSWORD_db;
        private $HOST_db;
        private $NAME_db;

        function __construct(){
            try{
				$file = file_get_contents('C:\wamp64\www\ProjetAngularM2IL3\sw\config.json');
                $this->configs_env = json_decode($file,true);
        
                $this->USERS_db     = $this->configs_env['user'];
                $this->PASSWORD_db  = $this->configs_env['password'];
                $this->HOST_db      = $this->configs_env['hostname'];
                $this->NAME_db      = $this->configs_env['dbname'];

                $this->bdconect = new PDO("mysql:host=".$this->HOST_db.";dbname=".$this->NAME_db, $this->USERS_db, $this->PASSWORD_db, 
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8")
                );
                $this->bdconect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);/* désactive les requêtes émulées - permet de typer les valeurs retournées */
            } catch ( Exception $e ){
                echo "Erreur: ".$e->getMessage();
                die("<h2>Impossible de se connecter à la base de données !</h2>");
            }
        }

        public function destruct(){
            unset($bdconect);
            unset($configs_env);
            unset($USERS_db);
            unset($PASSWORD_db);
            unset($HOST_db);
            unset($NAME_db);
        }
        
        public function getBdconect(){
			return $this->bdconect;
		}
    }
?>
