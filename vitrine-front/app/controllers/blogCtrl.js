app.controller("blogCtrl", function ($scope, BlogFactory) {

    console.log(" helloContro");

    
        console.log(" je cherche a recuperer les articles ---");
        
        try{
            BlogFactory.LatestArticles().then(function (response) {
                   
                   $scope.articles= response.data;
                   console.log(response.data);
                   console.log("the latest");
                   $scope.latest=response.data[0];
                   $scope.latest1=response.data[1];
                   console.log($scope.latest);
                   
            });
        }catch (ex){
         console.error(ex)
         }
         try{
            BlogFactory.MostPopular().then(function (response) {
                   
                   $scope.mostpopular= response.data;
                   console.log("les most populars");
                   console.log(response.data);
            });
        }catch (ex){
         console.error(ex)
         }
         try{
            BlogFactory.AllArticles().then(function (response) {
                   
                   $scope.all= response.data;

                  // console.log(response.data);
                   //console.log("data ok");
            });
        }catch (ex){
         console.error(ex)
         }

   
});