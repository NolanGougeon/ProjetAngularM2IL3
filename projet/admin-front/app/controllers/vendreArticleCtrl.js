app.controller("vendreArticleCtrl", function ($scope, $routeParams, Login , ListesFactory,$location) {

    try {

        $scope.session = JSON.parse(window.localStorage.getItem("user_session"));
        $scope.session = $scope.session[0];
        // console.log("hello seller article");
        // console.log($scope.session);
    } catch (error) {

        console.log(error)
    }

    // verify si c'est le jour d'une vente alors on peut acceder a cet espace
    Login.checkControl({action:"CHECK_VENTE_DAY"}).then(function (response) {
        if(response.data.is_dayVente){
        } else {
            $location.path("/");
        }
    });


    $scope.toBuys = [];
    $scope.articles=[];

    $scope.searchArticle = function (article) {

        $scope.articles=[];
        ListesFactory.loadListeDetailsElement(article.codeA).then(function (response) {

            for(var i=0 ; i < response.data.length; i++){
                if(response.data[i].statut != "VENDU"){
                    $scope.articles=response.data;
                }
            }


            //
            for(var i =0 ; i < $scope.articles.length ; i++){
                isAlreadyCheck($scope.toBuys, $scope.articles[i])
            }

        });

    };

    $scope.addToPanier =  function (data) {
        data.isPut = true;
        $scope.toBuys.push(data);
    };

    var isAlreadyCheck =  function (tabOject ,  object) {
        for(var i=0; i < tabOject.length ; i ++){
            if(tabOject[i].codeA == object.codeA){
                object.isPut = true;
            } else {
                object.isPut = false;
            }
        }
    };


    $scope.retirerArticle = function(data){
        for( var i = 0; i < $scope.toBuys.length; i++){
            if ( $scope.toBuys[i].codeA == data.codeA) {
                $scope.toBuys.splice(i, 1);
            }

        }
    };

    $scope.validerAchat = function () {

        for( var i = 0; i < $scope.toBuys.length; i++) {
            $scope.toBuys[i].action ="ADD_VENTE";
            $scope.toBuys[i].acheteur_name =$scope.acheteur.nom;
            $scope.toBuys[i].acheteur_adresse =$scope.acheteur.adresse;
            $scope.toBuys[i].acheteur_numero =$scope.acheteur.numero;
        }


        ListesFactory.setVente($scope.toBuys[0]).then(function (response) {
            $scope.isDone = true;
            if(response.data.success){
                $scope.lasteIdVente = response.data.lasteIdVente;
                for(var i = 1; i < $scope.toBuys.length; i++ ){
                    $scope.toBuys[i].lasteIdVente = $scope.lasteIdVente;
                        ListesFactory.setVente($scope.toBuys[i]).then(function(resp){

                            if(resp.data.success){
                                $scope.isDone =true;
                            } else {
                                $scope.isDone =false;
                            }
                        });
                }
            }
            if($scope.isDone){
                notif('success','le compte à été créer avec succès','VENTE','toast-top-full-width');
            }
        });


    };


    $scope.retirer = function (data) {
        $scope.toRetrait = data;
    };

    $scope.retirerArticle = function (data) {
        data.action="RETRAIT";
        data.statut="RETIRE";
        ListesFactory.setRetrait(data).then(function(response){
            if(response.data.success){
                notif('success','l\'article n\'est plus vendable vous pouver continuer','RETRAIT','toast-top-full-width');
            }else {
                notif('error',response.data.message,'ERREUR SUR RETRAIT','toast-top-full-width');
            }
        });
    };




    $(document).ready(function() {
        $('form').parsley();
    });






});