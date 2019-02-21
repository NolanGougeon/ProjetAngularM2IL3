app.controller("SidebarCtrl", function ($scope, $location, Login,Session) {

    $scope.session =  Session.isLogged();
    $scope.logOut = function () {
        notif('warning','Deconnexion en cours','Compte','toast-top-right');
        window.localStorage.removeItem("user_session");
        $location.path("/Gla-Vide-Grenier/vitrine-front/");
    };

    var data = {action:"CHECK_VENTE_DAY"};
    Login.checkControl(data).then(function (response) {

       if(response.data.is_dayVente){
           $scope.isDayVente=true;
       } else {
           $scope.isDayVente=false;
       }
    });



});

