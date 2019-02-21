app.controller("eventCtrl", function($scope,$routeParams,EventFactory,Session) {

    try {
        // $scope.session = JSON.parse(window.localStorage.getItem("user_session"));
        // $scope.session = $scope.session[0];
        $scope.session =  Session.isLogged();
        $scope.id_event=$routeParams.id;
        var id_event=$routeParams.id;
    } catch (error) {

    }
    try{
        EventFactory.LoadEvents().then(function (response) {
               
            $scope.loadedevents= response.data;
            console.log(" les events tous");
            console.log(response.data);
        });
    }catch (ex){
     console.error(ex)
     }




     try{
        EventFactory.LoadAbortedEvents().then(function (response) {
               
               $scope.loadedabortedevents= response.data;
               console.log(response.data);
        });
    }catch (ex){
     console.error(ex)
     }

     try{
        EventFactory.loadEventDetailsElement(id_event).then(function (response) {

                $scope.thisevent=response.data[0];
                console.log("le thisevent trouve est ");
                console.log(response.data[0]);
                //window.location.href
            });
    }catch (ex){
     console.error(ex)
     }


     $scope.AddEvent= function(name,date,lieu){
        console.log(" Je suis dans la fonction edit event  du controller");


       try{
           EventFactory.AddEvent(name,date,lieu).then(function (response) {
                   console.log(response.data);
                   notif('success','event ajouté avec succès !','AJOUT D\'EVENT','toast-top-full-width');
                   window.location.href="#/events";
               });
       }catch (ex){
        console.error(ex)
        }
    };

    $scope.AbortEvent= function(id_event){
        console.log(" Je suis dans la fonction abortevent  du controller");
       try{
           EventFactory.AbortEvent(id_event).then(function (response) {
                   console.log(response.data);
                   notif('success','event annulé avec succès !','ANNULATION D\'EVENT','toast-top-full-width');
                   window.location.href="#/events";
               });
       }catch (ex){
        console.error(ex)
        }
    };

    $scope.StartEvent= function(data){
        console.log(" Je suis dans la fonction StartEvent  du controller");

        var id_event = data.id_event;

       try{
           EventFactory.StartEvent(id_event).then(function (response) {

                   console.log(response.data);
                   notif('success','event demarré avec succès, ENJOY !','DEMARRAGE D\'EVENT','toast-top-full-width');
                   data.event_statut="start";
                   window.location.href="#/events";
               });
       }catch (ex){
        console.error(ex)
        }
    };
    $scope.CloseEvent= function(id_event){
        console.log(" Je suis dans la fonction CloseEvent  du controller");
        

       try{
           EventFactory.CloseEvent(id_event).then(function (response) {


                   console.log(response.data);
                   notif('success','event arrêté avec succès, ENJOY !','FERMETTURE D\'EVENT','toast-top-full-width');
                   window.location.href="#/events";
               });
       }catch (ex){
        console.error(ex)
        }
    };


     $scope.EditEvent= function(name,date,lieu){
        console.log(" Je suis dans la fonction edit event  du controller");


       try{
           EventFactory.EditEventDetails(id_event,name,date,lieu).then(function (response) {

                   console.log(response.data);
                   notif('success','event modifié avec succès !','MODIFICATION D\'EVENT','toast-top-full-width');
                   window.location.href="#/events";
               });
       }catch (ex){
        console.error(ex)
        }
    }

});