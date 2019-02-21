app.controller("usersCtrl" , function ($scope , $location, Login) {


    console.log(" hello users Ctrl");

    Login.getAllusers("ALL").then(function (resp) {
        console.log(resp);
        $scope.users = resp.data;
        // console.log($scope.users);
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