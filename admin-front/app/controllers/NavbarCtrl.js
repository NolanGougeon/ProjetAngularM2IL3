app.controller("NavbarCtrl", function ($scope,Session,$location) {


    $scope.session =  Session.isLogged();
    $scope.logOut = function () {
        notif('warning','Deconnexion en cours','Compte','toast-top-right');
        window.localStorage.removeItem("user_session");
        $location.path("/ProjetAngularM2IL3/vitrine-front/");
    };



});