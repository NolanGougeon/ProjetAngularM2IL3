app.controller("recapCtrl" , function ($scope,ListesFactory,Session) {

    $scope.session =  Session.isLogged();
    try {
        var tri = $scope.session.trigramme;

    } catch (error) {
            console.log(error)
    }

    try{
        ListesFactory.LoadListesGain(tri).then(function (response) {
               
               $scope.listes= response.data;
               console.log(response.data);
        });
    }catch (ex){
     console.error(ex)
    }

});