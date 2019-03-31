<?php
    class Page{

        private $code;
        private $nom;

        function __construct($code,$nom){
            $this->code = $code;
            $this->nom = $nom;
        }
    }
?>