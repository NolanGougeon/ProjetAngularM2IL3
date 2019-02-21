app.controller("HomeCtrl", function($scope) {

    try {
        $scope.session = JSON.parse(window.localStorage.getItem("user_session"));
        $scope.session = $scope.session[0];
    } catch (error) {

    }
    //

    if ( $scope.session === null ) {
        // redirection pour une personne non logged qui veut se connecter
        window.location.href = "/Gla-Vide-Grenier/vitrine-front/"
    } else {
            if($scope.session.actif == "0" ){
                window.location.href = "/Gla-Vide-Grenier/vitrine-front/"
            }
    }

});


