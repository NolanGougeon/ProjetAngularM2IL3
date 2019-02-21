app.controller("userProfilCtrl", function ($scope,Login, $routeParams) {

    console.log(" hello usser controller");
    $scope.session = JSON.parse(window.localStorage.getItem("user_session"));
    $scope.session = $scope.session[0];
    $scope.session.password="";
    console.log($scope.session);


    $scope.modified = function (data) {

        if(verifyDataSimilar(data.confirmpassword , data.password)){

            delete data.confirmpassword;
            delete data.oldpassword;

            Login.userUpdate(data).then(function (response) {
                if(response.data.success){
                    $scope.session.password="";
                    window.localStorage.setItem("user_session",JSON.stringify($scope.session));
                    notif('success','Modified avec sucess','Compte','toast-top-full-width');
                } else {
                    notif('error',response.data.error,'Compte','toast-top-full-width');
                }
            });
        }

    };



    var verifyDataSimilar = function (data_1, data_2) {
        if(data_1 != data_2){
            notif('error','Veuillez confirmer le nouveaux mot de passe', 'Compte' ,'toast-top-full-width');
            return false;
        }
        return true;
    };

});
