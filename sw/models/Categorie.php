<?php
    class Categorie{

        private $id_cat;
        private $nom_cat;

        function __construct($id_cat,$nom_cat){
            $this->id_cat = $id_cat;
            $this->nom_cat = $nom_cat;
        }
    }
?>