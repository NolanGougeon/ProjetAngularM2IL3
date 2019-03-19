
app.controller("aboutCtrl", function($scope, $http) {
    try {
      $http.get(BASE_URL+"edit.php?action=show").then(function(response){
        $scope.texte=response.data[0];
      });
    } catch (error) {

    }
});
