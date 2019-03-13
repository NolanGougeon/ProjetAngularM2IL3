app.controller("navbarCtrl", function ($scope, Login, $http,toaster) {

    window.localStorage.removeItem("user_session");
     $scope.setLogin = function (login){
        try{
            Login.userLogin(login).then(function (response) {
                   //console.log(response.data);
                   if(response.data.autorize){
                       toaster.pop({
                           type: 'sucess',
                           title: 'connexion',
                           body: response.data.message,
                           timeout: 1500
                       });
                       // TODO REDIRECTION A
                       window.localStorage.setItem("user_session",JSON.stringify(response.data.data));
                       window.location = "/ProjetAngularM2IL3/admin-front/panel/#/"

                   } else{
                       toaster.pop({
                           type: 'error',
                           title: 'connexion failed',
                           body: response.data.message,
                           timeout: 3000
                       });
                   }

            });
        }catch (ex){
         console.error(ex)
         }

    }
});