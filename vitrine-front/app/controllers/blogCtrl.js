app.controller("blogCtrl", function ($scope, BlogFactory) {
    try{
        BlogFactory.LatestArticles().then(function (response) {
            $scope.articles= response.data;
            $scope.latest=response.data[0];
            $scope.latest1=response.data[1];
        });
    } catch(ex) {
        console.error(ex);
    }
    try{
        BlogFactory.MostPopular().then(function (response) {
               $scope.mostpopular= response.data;
        });
    } catch(ex) {
        console.error(ex);
    }
    try{
        BlogFactory.AllArticles().then(function (response) {
            $scope.all= response.data;
        });
    } catch(ex) {
     console.error(ex)
    }
});
