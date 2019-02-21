app.controller("codeCtrl" , function ($scope, $routeParams , Login , ListesFactory) {


    try {
        $scope.session = JSON.parse(window.localStorage.getItem("user_session"));
    }catch (Exception){
        console.log(Exception);
    }

    $scope.session = $scope.session[0];
    $scope.listeId = $routeParams.idListe;


    Login.getParameters().then(function (response) {

        if(response.data.success){
            $scope.parameters = response.data.data;
        }
    });


    ListesFactory.LoadListeDetails($scope.listeId).then(function (response) {
        if(response.data){
            $scope.articles = response.data;
        }

    });


    $scope.percent = function (prix) {
        var assoPercent = ( (parseInt(prix) * parseInt($scope.parameters.pourcentage)) /100);
        return assoPercent;
    }

    $scope.calculated_price = function (prix) {
        var assoPercent = ( parseInt(prix) + (parseInt(prix) * parseInt($scope.parameters.pourcentage))/100);
        return assoPercent;
    }

});