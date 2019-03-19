app.controller("blogdetailsCtrl", function ($scope, $routeParams,toaster,BlogdetailsFactory) {
    var id_article=$routeParams.id;
    try{
        BlogdetailsFactory.GetArticle(id_article).then(function (response) {
            $scope.article= response.data[0];
               console.log("data a afficher");
               console.log($scope.article);
        });
    } catch(ex) {
     console.error(ex)
    }

    try{
        BlogdetailsFactory.GetComment(id_article).then(function (response) {
            $scope.commentaires= response.data;
        });
    } catch(ex) {
     console.error(ex)
    }

     $scope.AddComment= function(name,email,texte) {
        try{
            BlogdetailsFactory.AddComment(name,email,texte,id_article).then(function (response) {
            // $scope.article= response.data[0];
            //    console.log("data a afficher");
                if(response.data.valide) {
                    toaster.pop({
                        type: 'sucess',
                        title: 'Commentaire enregistré !',
                        body: response.data.message,
                        timeout: 1500
                    });
                }
            });
            $scope.name=" ";$scope.email=" ";$scope.texte=" ";
        } catch(ex) {
         console.error(ex)
        }
    }
});
