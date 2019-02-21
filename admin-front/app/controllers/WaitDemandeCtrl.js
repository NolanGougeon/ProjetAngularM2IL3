app.controller("WaitDemandeCtrl", function ($scope,$location,$interval,$timeout,ListesFactory, Login) {
    try {
        $scope.session=JSON.parse(window.localStorage.getItem("user_session"));
    }catch (error){ }

    if(!$scope.session){
        window.location.href="../"
    }
    $scope.user = $scope.session.user;



    var critere = "statut" , value="soumis" ;
    var req = "action=GET&critere="+critere+"&value="+value;
    ListesFactory.LoadListeBystatus(req).then(function (response) {
        if(response.data.length !=0){
            $scope.listes = response.data;
            // console.log($scope.listes);
        }
    });

    $scope.validation=function (data) {
        $scope.listeToUpdate = data;
    };

    $scope.updateStatus = function (data) {
        data.action = "UPDATE";
        data.critere = "statut";
        data.type = "ONLYONE";
        data.statut = "acceptee";
      ListesFactory.setUpdate(data).then(function (response) {
          if(response.data.success){
              notif('success',response.data.message,'Liste','toast-top-full-width');
          }else{
              notif('error',response.data.message,'Liste','toast-top-full-width')
          }

      })
    };

    $timeout(function(){
        $("#datatable-buttons").DataTable({
            dom: "Bfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-md"
            }, {
                extend: "csv",
                className: "btn-md"
            }, {
                extend: "excel",
                className: "btn-md"
            }, {
                extend: "pdf",
                className: "btn-md"
            }, {
                extend: "print",
                className: "btn-md"
            }],
            responsive: !0
        });
    },3000)



});