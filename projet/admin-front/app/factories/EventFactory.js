
app.factory("EventFactory", function ($q, $http) {

    var factory = {
        // list of services in an agency
        LoadEvents: function () {
            var deferred = $q.defer();
            $http.get(BASE_URL + "events.php?action=all").then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        LoadAbortedEvents: function () {
            var deferred = $q.defer();
            $http.get(BASE_URL + "events.php?action=loadabort").then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        AbortEvent: function (id_event) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "events.php?action=abort&id_event="+id_event).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        StartEvent: function (id_event) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "events.php?action=start&id_event="+id_event).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        CloseEvent: function (id_event) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "events.php?action=close&id_event="+id_event).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        AddEvent: function (name,date,lieu) {
            console.log(" Je suis dans la fonction addEVENT du factory ");
            // console.log(nom_liste);
            // console.log(trigramme);
            var deferred = $q.defer();
            $http.post(BASE_URL + "events.php",{action:"add",name:name,date:date,lieu:lieu}).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        EditEventDetails: function (id_event,name,date,lieu) {
            console.log(" Je suis dans la fonction POUR modifier UN EVENT du factory ");
            var deferred = $q.defer();
            $http.post(BASE_URL + "events.php",{action:"editevent",id_event:id_event,name:name,date:date,lieu:lieu}).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        loadEventDetailsElement: function (id_event) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "events.php?action=eventdetailselement&id_event="+id_event).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        
    };


    return factory;
});
