app.controller("parameterCtrl" , function ($scope , $location, Login) {
    
    Login.getParameters().then(function (response) {

        if(response.data.success){
            $scope.parameters = response.data.data;
        }

        $scope.editable=false;
        $scope.changeEdit = function () {
          if($scope.editable){
              $scope.editable = false;
          } else {
              $scope.editable= true;
          }

        };

    });

    $scope.modifParameter =  function(data){
        data.action="UPDATE";
        Login.updateParametre(data).then(function (response) {
            if(response.data.success){
                $scope.editable=false;
                notif('success','Modification éffectué avec sucess','Paramètres','toast-top-full-width');
            } else {
                notif('error',response.data.message,'Paramètres','toast-top-full-width');
            }
        })
    }
});