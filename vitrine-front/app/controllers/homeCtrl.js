app.controller("homeCtrl", function ($scope,$http) {
    try{
        $http.get(BASE_URL+"events.php?action=all")
        .then(function (response) {
            var date=response.data[0]['date'];
            var finaldate=date.replace(/-/g,"/");
            HomecompteARebour(finaldate);
        });
    } catch(ex) {
        console.error(ex);
    }
});
