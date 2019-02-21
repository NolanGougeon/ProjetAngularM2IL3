app.controller('userDetailsCtrl' , function ($scope , $routeParams, Login) {


    var trigramme =  $routeParams.trigramme;
    var req = "only&critere=trigramme&value="+trigramme;
    // console.log(req);

    Login.getAllusers(req).then(function (resp) {
            if(resp.data[0]){
                $scope.user = resp.data[0];
                console.log($scope.user);
            } else {
                window.location.href="#/users-all";
            }

    });

    $scope.confirmeDelete = function (data) {
        $scope.toDelete = data;
    };

    $scope.delete = function(data){
        Login.deleteUser(data.trigramme).then(function (response) {
            if(response.data.success){
                window.location.reload();
            }
        });
    }




});