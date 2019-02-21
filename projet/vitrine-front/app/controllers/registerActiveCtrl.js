app.controller("registerActiveCtrl", function ($scope,toaster,Login , $routeParams,$location) {

    $scope.myparam = $routeParams.token ;
    var data = {
        cle : $scope.myparam,
        actif : 0,
        action: "VERIFY",
    };



    Login.userActive(data).then(function (response) {

        if(response.data.success){
            toaster.pop({
                type: 'success',
                title:'Glazyk Compte',
                body: ' Votre compte a été active avec sucess',
                timeout: 2500
            });
            $location.path("/");

        } else {
            toaster.pop({
                type: 'error',
                title:'Glazyk Compte',
                body: " Votre compte  n\' est pas enregistré ! ",
                timeout: 2500
            });
        }


    });


});