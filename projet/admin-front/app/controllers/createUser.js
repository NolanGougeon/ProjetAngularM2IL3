app.controller("createUserCtrl", function ($scope , $routeParams, $location, Login ) {


    console.log("hello create user controller");

    $scope.createUser = function (data) {
          data.typeUser="organisateur";
          data.action="ADD";

          if(verifyData(data)){
              console.log(data);
              delete data.passconfirm;
              Login.userRegister(data).then(function (response) {
                  if(response.data.exist){
                      notif('error','le Compte exist déjà','REGISTER','toast-top-full-width');
                  } else {
                      notif('success','le compte à été créer avec succès','Utilisateur','toast-top-full-width');
                  }
              });
          }

    };


    var verifyData = function (data) {
        if(data.password != data.passconfirm){
            notif('error','Confirmer votre mot de passe','Password','toast-top-full-width');
            return false;
        }
        return true;
    }

});