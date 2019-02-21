app.factory("Login", function ($q, $http) {

    var factory = {
        // list of services in an agency
        connect: function (params) {
            var deferred = $q.defer();
            $http.post(BASE_URL + "login/user", params).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        userUpdate: function (params) {
            var deferred = $q.defer();
            $http.post(BASE_URL + "user.php", params).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        getAllusers: function (data) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "user.php?action="+data).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        deleteUser: function (data) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "user.php?action=DELETE&value="+data).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        userRegister: function(data){
            var deferred = $q.defer();
            $http.post(BASE_URL+ "user.php", data).then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },
        getParameters: function(){
            var deferred = $q.defer();
            $http.get(BASE_URL+ "parameter.php?action=ALL").then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },

        updateParametre: function(data){
            var deferred = $q.defer();
            $http.post(BASE_URL+ "parameter.php",data).then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },
        checkControl: function(data){
            var deferred = $q.defer();
            $http.post(BASE_URL+ "parameter.php",data).then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },

    };

    return factory;
});