app.controller("registerCtrl", function ($scope,toaster,Login,$timeout,$location) {


    $scope.userInfo = true;
    $scope.DataLogin = false;
    $scope.NavigationForm = function (data) {
        if($scope.userInfo){
            $scope.userInfo = false;
            $scope.DataLogin = true;
            $scope.user = data;
        } else {
            $scope.userInfo = true;
            $scope.DataLogin = false;
        }

        $scope.readTerms=false;

    };

    $scope.readTerms = false;
    $scope.afficherBtn = function () {
        if(!$scope.readTerms) {
            $scope.readTerms=true;
        } else {
            $scope.readTerms=false;
        }
    };

    $scope.registerData = function (data) {
        if(verifyData(data)) {
            data.typeUser= "vendeur";
            data.action= "ADD";
            data.dateNaissance = moment(data.dateNaissance).format('YYYY-MM-DD');
            delete  data.passconfirm;
            Login.userRegister(data).then(function (response) {
                if(response.data.exist) {
                    toaster.pop ({
                        type: 'warning',
                        title: 'Compte',
                        body: 'cet email est déjà associé à un compte veuillez le changer ',
                        timeout: 4000
                    });
                } else {
                    toaster.pop ({
                        type: 'success',
                        title:'Inscription',
                        body: 'Votre inscription a bien été prise en compte, vous recevrez un mail de confirmation',
                        timeout: 5000
                    });
                }
                $timeout(function () {
                  $location.path("/");
                }, 3000);
            });
        }
    };

    var verifyData = function (data) {
        if(data.password != data.passconfirm) {
            toaster.pop ({
                type: 'error',
                title: 'Mot de passe',
                body: 'Veuillez entrez les memes mot de passe',
                timeout: 2000
            });
            return false;
        }
        return true;
    }


});
