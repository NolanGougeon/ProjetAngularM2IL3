app.controller("newsletterCtrl", function ($scope,NewsletterFactory,toaster,$http) {
    console.log("Hello Newsletter Controller");
    
    $scope.addNewsletter = function (newsletteremail){
        try{
            var mail=newsletteremail;
            
            NewsletterFactory.addMail(mail).then(function (response) {
                   console.log(response.data);
                   if(response.data.erreur==false){
                       toaster.pop({
                           type: 'sucess',
                           title: 'Inscription réussie',
                           body: response.data.message,
                           timeout: 1500
                       });
                       // TODO REDIRECTION A FAIRE
                   } else{
                       toaster.pop({
                           type: 'error',
                           title: 'Echec !',
                           body: response.data.message,
                           timeout: 4000
                       });
                   }
                
            });

        }catch (ex){
         console.error(ex)
         }
    }
    
});