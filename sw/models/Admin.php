<?php
    class Admin{

        private $login;
        private $motdepasse;

        function __construct($login,$motdepasse){
            $this->login = $login;
            $this->motdepasse = $motdepasse;
        }
    }
?>